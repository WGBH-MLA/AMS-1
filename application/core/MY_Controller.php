<?php

if(	!	defined('BASEPATH'))
{
				exit('No direct script access allowed');
}

class	MY_Controller	extends	CI_Controller
{

				/**
					* constructor. Load layout,Model,Library and helpers
					* 
					*/
				public	$total_unread;
				public	$user_id;
				public	$role_id;
				public	$is_station_user;
				public	$station_id;
				public	$user_details;
				public	$can_compose_alert;
				public	$views_settings;
				public	$frozen_column;
				public	$column_order;
				public	$station_name;

				function	__construct()
				{
								parent::__construct();
								$this->layout	=	'main_layout.php';
								if(	!	$this->dx_auth->is_logged_in())
								{
												redirect('auth/login');
								}
								$this->is_station_user	=	FALSE;
								$this->load->library('Form_validation');
								$this->load->helper('form');
								$this->load->model('messages_model',	'msgs');
								$this->load->model('station_model');
								$this->load->model('dx_auth/users',	'users');
								$this->load->model('dx_auth/user_profile',	'user_profile');
								$this->load->model('dx_auth/roles',	'roles');
								$this->load->model('email_template_model',	'email_template');
								$this->load->model('report_model');
								$this->load->model('dx_auth/user_settings',	'user_settings');
								$this->load->model('tracking_model',	'tracking');
								if($this->dx_auth->is_station_user())
								{
												$this->is_station_user	=	TRUE;
												$this->station_id	=	$this->dx_auth->get_station_id();
												$this->station_name	=	$this->station_model->get_station_by_id($this->station_id)->station_name;
								}
								$this->frozen_column	=	0;
								$this->column_order	=	'';
								if(	!	isset($this->user_id))
								{
												$this->_assing_user_info();
								}
								if(is_route_method(array('records'	=>	array('index'),	'instantiations'	=>	array('index',	'update_user_settings'))))
								{
												$this->_table_view_settings();
								}
				}

				/*
					*
					* To Create Assets and instantiation list view
					*
					*/

				function	_table_view_settings()
				{
								if(is_route_method(array('records'	=>	array('index'))))
								{
												$res	=	$this->user_settings->get_setting($this->user_id,	'assets',	'full');
												if($res)
												{
																$this->frozen_column	=	$res->frozen_column;
																$this->column_order	=	json_decode($res->view_settings,	true);
												}
												else
												{
																$assets_tables_data	=	array();
																$assets_tables_data['user_id']	=	$this->user_id;
																$assets_tables_data['table_type']	=	'assets';
																$assets_tables_data['table_subtype']	=	'full';
																$assets_tables_data['frozen_column']	=	'0';
																$table_order	=	$this->config->item('assets_setting');
																$full_table_order	=	$table_order['full'];
																foreach($full_table_order	as	$key	=>	$value)
																{
																				$views_settings[]	=	array("title"																														=>	$key,	"field"																														=>	$value,	"hidden"																													=>	0);
																}
																$assets_tables_data['view_settings']	=	json_encode($views_settings);
																$assets_tables_data['created_at']	=	date('Y-m-d H:i:s');
																$this->user_settings->insert_settings($assets_tables_data);
																$this->frozen_column	=	0;
																$this->column_order	=	$views_settings;
												}
								}
								if(is_route_method(array('instantiations'	=>	array('index'))))
								{
												$res	=	$this->user_settings->get_setting($this->user_id,	'instantiation',	'full');
												if($res)
												{
																$this->frozen_column	=	$res->frozen_column;
																$this->column_order	=	json_decode($res->view_settings,	true);
												}
												else
												{
																$assets_tables_data	=	array();
																$assets_tables_data['user_id']	=	$this->user_id;
																$assets_tables_data['table_type']	=	'instantiation';
																$assets_tables_data['table_subtype']	=	'full';
																$assets_tables_data['frozen_column']	=	'0';
																$table_order	=	$this->config->item('instantiation_setting');
																$full_table_order	=	$table_order['full'];
																foreach($full_table_order	as	$key	=>	$value)
																{
																				$views_settings[]	=	array("title"																														=>	$key,	"field"																														=>	$value,	"hidden"																													=>	0);
																}
																$assets_tables_data['view_settings']	=	json_encode($views_settings);
																$assets_tables_data['created_at']	=	date('Y-m-d H:i:s');
																$this->user_settings->insert_settings($assets_tables_data);
																$this->frozen_column	=	0;
																$this->column_order	=	$views_settings;
												}
								}
				}

				/*
					* To Assign Current Login user info
					*/

				function	_assing_user_info()
				{
								$this->user_id	=	$this->dx_auth->get_user_id();
								$this->role_id	=	$this->dx_auth->get_role_id();
								$this->is_station_user	=	$this->dx_auth->is_station_user();
								if($this->is_station_user)
								{
												$this->station_id	=	$this->dx_auth->get_station_id();
												$this->total_unread	=	$this->msgs->get_unread_msgs_count($this->station_id);
								}
								else	if($this->session->userdata['DX_email']	===	'cstephenson@mail.crawford.com')
								{
												$this->total_unread	=	$this->msgs->get_unread_msgs_count($this->session->userdata['DX_user_id']);
												echo $this->total_unread;exit;
								}
								$this->user_detail	=	$this->users->get_user_detail($this->user_id)->row();
								$this->can_compose_alert	=	false;
								if(in_array($this->role_id,	array(1,	2,	5)))
								{
												$this->can_compose_alert	=	true;
								}
				}

				function	make_array()
				{
								return	array('asset_title'																			=>	'Title',
								'asset_subject'																	=>	'Subject',
								'asset_coverage'																=>	'Coverage',
								'asset_genre'																			=>	'Genre',
								'asset_publisher_name'										=>	'Publisher',
								'asset_description'													=>	'Description',
								'asset_creator_name'												=>	'Creator Name',
								'asset_creator_affiliation'					=>	'Creator Affiliation',
								'asset_contributor_name'								=>	'Contributor Name',
								'asset_contributor_affiliation'	=>	'Contributor Affiliation',
								'asset_rights'																		=>	'Rights Summaries',
								'asset_annotation'														=>	'Annotations',
								'instantiation_identifier'						=>	'ID',
								'instantiation_source'										=>	'ID Source',
								'unit_of_measure'															=>	'Unit of Measure',
								'standard'																						=>	'Standard',
								'location'																						=>	'Location',
								'file_size'																					=>	'File Size',
								'actual_duration'															=>	'Duration',
								'track_data_rate'															=>	'Data Rate',
								'tracks'																								=>	'Tracks',
								'channel_configuration'									=>	'Channel Configuration',
								'track_language'																=>	'Language',
								'alternative_modes'													=>	'Alternative Modes',
								'ins_annotation'																=>	'Annotation',
								'ins_annotation_type'											=>	'Annotation Type',
								'track_essence_track_type'						=>	'Track Type',
								'track_encoding'																=>	'Encoding',
								'track_standard'																=>	'Track Standard',
								'track_frame_rate'														=>	'Frame Rate',
								'track_playback_speed'										=>	'Playback Speed',
								'track_sampling_rate'											=>	'Sampling Rate',
								'track_bit_depth'															=>	'Bit Depth',
								'track_width'																			=>	'Frame Size',
								'track_aspect_ratio'												=>	'Aspect Ratio',
								);
				}

				/**
					* Remove the session variables of facet search
					*  
					*/
				function	unset_facet_search()
				{
								$this->session->unset_userdata('custom_search');
								$this->session->unset_userdata('organization');
								$this->session->unset_userdata('nomination');
								$this->session->unset_userdata('media_type');
								$this->session->unset_userdata('physical_format');
								$this->session->unset_userdata('digital_format');
								$this->session->unset_userdata('generation');
								$this->session->unset_userdata('date_range');
								$this->session->unset_userdata('date_type');
								$this->session->unset_userdata('digitized');
								$this->session->unset_userdata('migration_failed');
				}

				/**
					* Set the session variables of facet search
					* 
					* @param array $search_values 
					*/
				function	set_facet_search($search_values)
				{
								foreach($search_values	as	$key	=>	$value)
								{
												$this->session->set_userdata($key,	$value);
								}
				}

}

?>