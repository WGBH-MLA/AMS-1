<?php
/**
 * AMS Archive Management System
 * 
 * PHP version 5
 * 
 * @category   AMS
 * @package    CI
 * @subpackage Controller
 * @author     Nouman Tayyab <nouman@avpreserve.com>
 * @copyright  Copyright (c) WGBH (http://www.wgbh.org/). All Rights Reserved.
 * @license    http://www.gnu.org/licenses/gpl.txt GPLv3
 * @version    GIT: <$Id>
 * @link       https://github.com/avpreserve/AMS
 */

/**
 * Searchd Class
 *
 * @category   Class
 * @package    CI
 * @subpackage Controller
 * @author     Nouman Tayyab <nouman@avpreserve.com>
 * @copyright  Copyright (c) WGBH (http://www.wgbh.org/). All Rights Reserved.
 * @license    http://www.gnu.org/licenses/gpl.txt GPLv3
 * @link       https://ams.americanarchive.org
 */
class Searchd extends CI_Controller
{

	/**
	 * Constructor.
	 * 
	 * Load Model,Helper and Library.
	 *  
	 */
	function __construct()
	{
		parent::__construct();

		$this->load->library('sphnixrt');
		$this->load->model('station_model');
		$this->load->model('searchd_model');
		$this->load->helper('sphnixdata');
		$this->load->model('assets_model');
	}

	/**
	 * Insert Stations information to Sphnix Realtime Index.
	 * 
	 * @return none
	 */
	function insert_station_sphnix()
	{
		$stations = $this->station_model->get_all();
		foreach ($stations as $key => $row)
		{
			$record = make_station_sphnix_array($row);
			$this->sphnixrt->insert($this->config->item('station_index'), $record, $row->id);
		}
		exit_function();
	}

	/**
	 * Map ID from 2D arrary
	 * 
	 * @param array $value
	 * @return string/integer
	 */
	function make_map_array($value)
	{

		return $value->id;
	}

	/**
	 * Insert Instantiations information to Sphnix Realtime Index.
	 * 
	 * @return none
	 */
	function insert_instantiations_sphnix()
	{
		set_time_limit(0);
		@ini_set("memory_limit", "1000M"); # 1GB
		@ini_set("max_execution_time", 999999999999);
		$db_count = 0;
		$offset = 0;
		while ($db_count == 0)
		{
			$inst = $this->searchd_model->get_ins($offset, 1000);
			$ids = array_map(array($this, 'make_map_array'), $inst);
			$records = $this->searchd_model->get_ins_index($ids);
			foreach ($records as $row)
			{
				$data = make_instantiation_sphnix_array($row);
				$this->sphnixrt->insert('instantiations_list', $data, $row->id);
			}
			$offset = $offset + 1000;
			if (count($inst) < 1000)
				$db_count ++;
		}

		exit_function();
	}

	/**
	 * Use this function if you want to insert assets one by one in assets sphinx index.
	 */
	function insert_assets()
	{
		set_time_limit(0);
		@ini_set("memory_limit", "8000M"); # 1GB
		@ini_set("max_execution_time", 999999999999);
		$dString = file_get_contents ( '/tmp/insert2assets_list.csv' );
                $asset_ids = explode(',',$dString);
		foreach ($asset_ids as $asset_id)
		{
		$assets = $this->searchd_model->run_query('SELECT id from assets WHERE id = '.$asset_id )->result();
		//$assets = $this->searchd_model->run_query('SELECT id from assets')->result();
		foreach ($assets as $asset)
		{
			myLog('using searchd.php function insert_assets');
			myLog('Start Inserting ID =>' . $asset->id);
			$records = $this->searchd_model->get_asset_index(array($asset->id));
			myLog('Start inserting to sphinx');
			foreach ($records as $row)
			{
				$data = make_assets_sphnix_array($row);
				$this->sphnixrt->insert($this->config->item('asset_index'), $data, $row->id);
				myLog('Inserted ID =>' . $row->id);
			}
		}
		}
	}

	/**
	 * Insert Assets information to Sphnix Realtime Index.
	 * 
	 * @return none
	 */
	function insert_assets_sphnix()
	{
		set_time_limit(0);
		@ini_set("memory_limit", "8000M"); # 1GB
		@ini_set("max_execution_time", 999999999999);

		$db_count = 0;
		$offset = 0;
		//$offset = 720654 ;
		while ($db_count == 0)
		{
			$inst = $this->searchd_model->get_asset($offset, 1000);
			myLog('Get 1000 records');
			$ids = array_map(array($this, 'make_map_array'), $inst);
			//mylog($ids);
			$records = $this->searchd_model->get_asset_index($ids);
			myLog('Start inserting to sphinx');
			foreach ($records as $row)
			{
				$data = make_assets_sphnix_array($row);
				$this->sphnixrt->insert($this->config->item('asset_index'), $data, $row->id);
				myLog('Inserted ID =>' . $row->id);
			}
			myLog('Inserted 1000 records');
			$offset = $offset + 1000;
			if (count($inst) < 1000)
				$db_count ++;
		}

		exit_function();
	}

	/**
	 * You need to add assets.id in an array that you want to update. and then run this script.
	 * 
	 */
	function update_assets_index()
	{
		
		# * experiment to read values from a file
		$dString = file_get_contents ( '/tmp/asset_ids2reindex.csv' );
		$asset_ids = explode(',',$dString);
		

		# $asset_ids = array(4888822,4889382,4888577,4888231,4889276,4889033,4889592,4888556,4889120,4888934,4888985,4888184);
	/**
	* modify what is commented here to control what becomes $asset_ids
	*
		$asset_ids = array(1, 2, 3, 4);
	*
	*/
		foreach ($asset_ids as $_id)
		{
			$asset = $this->searchd_model->run_query("SELECT id from assets WHERE id = {$_id}")->row();
			$asset_list = $this->searchd_model->get_asset_index(array($asset->id));
			$updated_asset_info = make_assets_sphnix_array($asset_list[0], FALSE);
			$this->sphnixrt->update('assets_list', $updated_asset_info);
			myLog('Asset successfully update with id=> ' . $_id);
		}
	}

	/**
	 * You need to add instantiations.id in an array that you want to update. and then run this script.
	 * 
	 */
	function update_instantiations_index()
	{
		
		$dString = file_get_contents ( '/tmp/instantiations2reindex.csv' );
                $instantiation_ids = explode(',',$dString);
		# $instantiation_ids = array(4819547,4819548);
		foreach ($instantiation_ids as $_id)
		{
			$instantiation = $this->searchd_model->run_query("SELECT id from instantiations WHERE id = {$_id}")->row();
			//$instantiation_list = $this->searchd_model->get_ins_index(array($instantiation));
			if ( empty($instantiation))
			{
				myLog('NOT FOUND: instantiation id ' . $_id);
			} else 
			{
				$instantiation_list = $this->searchd_model->get_ins_index(array($_id));
				$new_list_info = make_instantiation_sphnix_array($instantiation_list[0], FALSE);
				$this->sphnixrt->update('instantiations_list', $new_list_info);
				myLog('Instantiation successfully updated with id=> ' . $_id);
			}
		}
	}


	function test_instantiations_index()
	{
		$_id=5463209;
		$instantiation = $this->searchd_model->run_query("SELECT id from instantiations WHERE id = {$_id}")->row();
		$instantiation_list = $this->searchd_model->get_ins_index(array($instantiation->id));
		$new_list_info = make_instantiation_sphnix_array($instantiation_list[0], FALSE);
		if ( empty($instantiation) )
		myLog ('it was not found');
		myLog( implode (',',$new_list_info )) ;
	}

}

// END Searchd Controller

// End of file searchd.php 
/* Location: ./application/controllers/searchd.php */
