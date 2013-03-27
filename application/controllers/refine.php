<?php

/**
 * AMS Archive Management System
 * 
 * PHP version 5
 * 
 * @category AMS
 * @package  CI
 * @author   Nouman Tayyab <nouman@geekschicago.com>
 * @license  CPB http://nouman.com
 * @version  GIT: <$Id>
 * @link     http://amsqa.avpreserve.com

 */

/**
 * Refine Class
 *
 * @category   AMS
 * @package    CI
 * @subpackage Controller
 * @author     Nouman Tayyab <nouman@geekschicago.com>
 * @license    CPB http://nouman.com
 * @link       http://amsqa.avpreserve.com
 */
class Refine extends MY_Controller
{

	/**
	 * Constructor.
	 * 
	 * Load the Models,Library
	 * 
	 * @return 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('googlerefine');
		$this->load->model('refine_modal');
		$this->load->model('sphinx_model', 'sphinx');
		$this->load->model('instantiations_model', 'instantiation');
		$this->load->model('assets_model');
	}

	function export($type)
	{
		set_time_limit(0);
		@ini_set("memory_limit", "1000M"); # 1GB
		@ini_set("max_execution_time", 999999999999); # 1GB
		if ($type == 'instantiation')
		{
			$query = $this->refine_modal->export_refine_csv(TRUE);
			$record = array('user_id' => $this->user_id, 'is_active' => 1, 'export_query' => $query, 'refine_type' => 'instantiation');
			$job_id = $this->refine_modal->insert_job($record);
		}
		else
		{
			$query = $this->refine_modal->export_asset_refine_csv(TRUE);
			$record = array('user_id' => $this->user_id, 'is_active' => 1, 'export_query' => $query, 'refine_type' => 'asset');
			$job_id = $this->refine_modal->insert_job($record);
		}
		echo json_encode(array('msg' => 'You will receive an email containing the link for AMS Refine.'));
		exit_function();
	}

	function remove($project_id)
	{

		$this->googlerefine->delete_project($project_id);
		$db_detail = $this->refine_modal->get_by_project_id($project_id);
		if ($db_detail)
		{
			$data = array('is_active' => 0);
			$this->refine_modal->update_job($db_detail->id, $data);
			if ($db_detail->refine_type == 'instantiation')
				redirect('instantiations');
			else
				redirect('records');
		}
	}

	function save($project_id)
	{
		$project_detail = $this->refine_modal->get_by_project_id($project_id);
		if ($project_detail)
		{
			$response = $this->googlerefine->export_rows($project_detail->project_name, $project_id);
			$filename = 'google_refined_data_' . time() . '.txt';
			$path = $this->config->item('path') . "uploads/google_refine/$filename";
			file_put_contents($path, $response);
			$this->googlerefine->delete_project($project_id);
			$data = array('is_active' => 2, 'import_csv_path' => $path);
			$this->refine_modal->update_job($project_detail->id, $data);
			if ($project_detail->refine_type == 'instantiation')
			{

				redirect('instantiations');
			}
			else
			{
				redirect('records');
			}
		}
	}

// Location: ./controllers/refine.php
}

// END Google Refine Controller

// End of file refine.php
// Location: ./application/controllers/refine.php
