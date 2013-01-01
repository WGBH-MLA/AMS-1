<?php

/**
	* Assets Model.
	*
	* @package    AMS
	* @subpackage assets_model
	* @author     ALi RAza
	*/
class	Assets_Model	extends	CI_Model
{

				/**
					* constructor. set table name amd prefix
					* 
					*/
				function	__construct()
				{
								parent::__construct();

								$this->_prefix	=	'';
								$this->stations	=	'stations';
								$this->_assets_table	=	'assets';
								$this->_table_asset_dates	=	'asset_dates';
								$this->_table_date_types	=	'date_types';

								$this->_table_asset_types	=	'asset_types';
								$this->_table_assets_asset_types	=	'assets_asset_types';

								$this->_table_backup	=	'stations_backup';
								$this->_table_asset_title_types	=	'asset_title_types';
								$this->_table_subjects	=	'subjects';
								$this->_table_assets_subjects	=	'assets_subjects';
								$this->_table_asset_descriptions	=	'asset_descriptions';
								$this->_table_description_types	=	'description_types';
								$this->_table_identifiers	=	'identifiers';
								$this->_table_genres	=	'genres';
								$this->_table_assets_genres	=	'assets_genres';
								$this->_table_coverages	=	'coverages';
								$this->_table_assets_audience_levels	=	'assets_audience_levels';
								$this->_table_audience_levels	=	'audience_levels';
								$this->_table_audience_ratings	=	'audience_ratings';
								$this->_table_assets_audience_ratings	=	'assets_audience_ratings';
								$this->_table_annotations	=	'annotations';
								$this->_table_relation_types	=	'relation_types';
								$this->_table_assets_relations	=	'assets_relations';
								$this->_table_creators	=	'creators';
								$this->_table_assets_creators_roles	=	'assets_creators_roles';
								$this->_table_creator_roles	=	'creator_roles';
								$this->_table_contributors	=	'contributors';
								$this->_table_assets_contributors_roles	=	'assets_contributors_roles';
								$this->_table_contributor_roles	=	'contributor_roles';
								$this->_table_publishers	=	'publishers';
								$this->_table_assets_publishers_role	=	'assets_publishers_role';
								$this->_table_publisher_roles	=	'publisher_roles';
								$this->_table_rights_summaries	=	'rights_summaries';
								$this->_table_extensions	=	'extensions';
								$this->_table_nominations	=	'nominations';
								$this->_table_nomination_status	=	'nomination_status';
								$this->_table_asset_titles	=	'asset_titles';
				}

				/**
					* Get annotations by assets_id
					* @param type $assets_id
					* @return array 
					*/
				function	get_annotations_by_asset_id($asset_id)
				{
								$this->db->where('assets_id',	$asset_id);
								$query	=	$this->db->get($this->_table_annotations);
								if(isset($query)	&&	!	empty($query))
								{
												$res	=	$query->result();
												if(isset($res)	&&	!	empty($res))
																return	$res;
								}
								return	false;
				}

				/**
					* search audience rating by assets_id
					* 
					* @param type $title_type
					* @return object 
					*/
				function	get_audience_rating_by_asset_id($assets_id)
				{
								$this->db->select("audience_rating ,audience_rating_source ,	audience_rating_ref ");
								$this->db->from($this->_table_assets_audience_ratings);
								$this->db->join($this->_table_audience_ratings,	"$this->_table_assets_audience_ratings.audience_ratings_id=$this->_table_audience_ratings.id",	"left");
								$this->db->where($this->_table_assets_audience_ratings	.	".assets_id",	$assets_id);
								$res	=	$this->db->get();
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->result();
								}
								return	false;
				}

				/**
					* search audience level by assets_id
					* 
					* @param type $title_type
					* @return object 
					*/
				function	get_audience_level_by_asset_id($assets_id)
				{
								$this->db->select("audience_level ,audience_level_source ,audience_level_ref ");
								$this->db->from($this->_table_assets_audience_levels);
								$this->db->join($this->_table_audience_levels,	"$this->_table_assets_audience_levels.audience_levels_id=$this->_table_audience_levels.id",	"left");
								$this->db->where($this->_table_assets_audience_levels	.	".assets_id",	$assets_id);
								$res	=	$this->db->get();
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->result();
								}
								return	false;
				}

				/**
					* Get aa rights summaries by assets_id
					* @param type $assets_id
					* @return array 
					*/
				function	get_rights_summaries_by_asset_id($asset_id)
				{
								$this->db->where('assets_id',	$asset_id);
								$query	=	$this->db->get($this->_table_rights_summaries);
								if(isset($query)	&&	!	empty($query))
								{
												$res	=	$query->result();
												if(isset($res)	&&	!	empty($res))
																return	$res;
								}
								return	false;
				}

				/**
					* Get aa title by assets_id
					* @param type $assets_id
					* @return array 
					*/
				function	get_title_by_asset_id($asset_id)
				{
								$this->db->where('assets_id',	$asset_id);
								$query	=	$this->db->get($this->_table_asset_titles);
								if(isset($query)	&&	!	empty($query))
								{
												$res	=	$query->row();
												if(isset($res)	&&	!	empty($res))
												{
																return	$res->title;
												}
								}
								return	false;
				}

				/**
					* Get aa coverages by assets_id
					* @param type $assets_id
					* @return array 
					*/
				function	get_coverages_by_asset_id($asset_id)
				{
								$this->db->where('assets_id',	$asset_id);
								$query	=	$this->db->get($this->_table_coverages);
								if(isset($query)	&&	!	empty($query))
								{
												$res	=	$query->result();
												if(isset($res)	&&	!	empty($res))
																return	$res;
								}
								return	false;
				}

				/**
					* Get aa descriptions by assets_id
					* @param type $assets_id
					* @return array 
					*/
				function	get_descriptions_by_asset_id($asset_id)
				{
								$this->db->where('assets_id',	$asset_id);
								$query	=	$this->db->get($this->_table_asset_descriptions);
								if(isset($query)	&&	!	empty($query))
								{
												$res	=	$query->row();
												if(isset($res)	&&	!	empty($res))
												{
																return	$res->description;
												}
								}
								return	false;
				}

				/**
					* Get aa guid by assets_id
					* @param type $assets_id
					* @return array 
					*/
				function	get_aa_guid_by_asset_id($asset_id)
				{
								$this->db->where('assets_id',	$asset_id);
								$this->db->where('identifier_source',	"http://americanarchiveinventory.org");
								$query	=	$this->db->get($this->_table_identifiers);
								if(isset($query)	&&	!	empty($query))
								{
												$res	=	$query->row();
												if(isset($res)	&&	!	empty($res))
												{
																return	$res->identifier;
												}
								}
								return	false;
				}

				/**
					* Get local_id by asset_id
					* @param type $assets_id
					* @return array 
					*/
				function	get_local_id_by_asset_id($asset_id)
				{
								$this->db->where('assets_id',	$asset_id);
								$this->db->where('identifier_source !=',	"http://americanarchiveinventory.org");
								$query	=	$this->db->get($this->_table_identifiers);
								if(isset($query)	&&	!	empty($query))
								{
												$res	=	$query->result();
												if(isset($res)	&&	!	empty($res))
												{
																return	$res;
												}
								}
								return	false;
				}

				/**
					* Get list of all the Assets
					* 
					* @return array 
					*/
				function	get_all()
				{
								$sql	=	"SELECT DISTINCT ast.id AS ast_id, ast . * FROM {$this->_assets_table} ast INNER JOIN {$this->_table_identifiers} idt ON ast.id=idt.assets_id LIMIT 100 ";
								$res	=	$this->db->query($sql);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->result();
								}return	false;

								$this->db->select("$this->_assets_table.id as asset_id",	FALSE);
								$this->db->select("$this->_table_identifiers.identifier as guid_identifier",	FALSE);
								$this->db->select("GROUP_CONCAT(local.identifier SEPARATOR ' | ') as local_identifier",	FALSE);
								$this->db->select("$this->_table_asset_descriptions.description",	FALSE);
								$this->db->select("$this->_table_asset_titles.title",	FALSE);


								$this->db->join($this->_table_identifiers	.	' as local',	"local.assets_id = $this->_assets_table.id",	'left');
								$this->db->join($this->_table_identifiers,	"$this->_table_identifiers.assets_id = $this->_assets_table.id",	'left');
								$this->db->join($this->_table_asset_descriptions,	"$this->_table_asset_descriptions.assets_id = $this->_assets_table.id",	'left');
								$this->db->join($this->_table_asset_titles,	"$this->_table_asset_titles.assets_id = $this->_assets_table.id",	'left');

								$this->db->where("$this->_table_identifiers.identifier_source",	"http://americanarchiveinventory.org");
								$this->db->where("local.identifier_source !=",	"http://americanarchiveinventory.org");

								$this->db->limit(100);

								$this->db->group_by("$this->_assets_table.id");

								$result	=	$this->db->get($this->_assets_table)->result();

								return	$result;
				}

				/**
					* Get asset by asset_id
					* 
					* @return array 
					*/
				function	get_asset_by_asset_id($asset_id)
				{
								$sql	=	"SELECT $this->_assets_table.id AS asset_id, $this->_table_identifiers.identifier AS guid_identifier, 
								$this->stations.station_name as organization,
								GROUP_CONCAT(local.identifier SEPARATOR ' | ') AS local_identifier, 
								GROUP_CONCAT(local.identifier_source SEPARATOR ' | ') AS local_identifier_source, 
								GROUP_CONCAT(local.identifier_ref SEPARATOR ' | ') AS local_identifier_ref, 
								$this->_table_asset_descriptions.description,
								GROUP_CONCAT($this->_table_asset_titles.title SEPARATOR ' | ') AS title,
								GROUP_CONCAT($this->_table_asset_titles.title_source SEPARATOR ' | ') AS title_source,
								GROUP_CONCAT($this->_table_asset_titles.title_ref SEPARATOR ' | ') AS title_ref,
								$this->_table_asset_title_types.title_type,
								GROUP_CONCAT($this->_table_asset_types.asset_type SEPARATOR ' | ') AS asset_type
								FROM (`$this->_assets_table`) 
                                LEFT JOIN {$this->_table_identifiers} AS `local` ON `local`.`assets_id` = `$this->_assets_table`.`id` 
                                LEFT JOIN {$this->_table_identifiers} ON `identifiers`.`assets_id` = `$this->_assets_table`.`id` 
                                LEFT JOIN {$this->_table_asset_descriptions} ON `asset_descriptions`.`assets_id` = `$this->_assets_table`.`id` 
                                LEFT JOIN {$this->_table_asset_titles} ON `asset_titles`.`assets_id` = `$this->_assets_table`.`id` 
								LEFT JOIN {$this->_table_asset_title_types} ON `$this->_table_asset_title_types`.`id` = `$this->_table_asset_titles`.`asset_title_types_id` 
								LEFT JOIN {$this->stations} ON {$this->stations}.id = {$this->_assets_table}.stations_id
								LEFT JOIN {$this->_table_assets_asset_types} ON $this->_table_assets_asset_types.assets_id = `$this->_assets_table`.`id`
								LEFT JOIN {$this->_table_asset_types} ON $this->_table_assets_asset_types.asset_types_id = $this->_table_asset_types.`id`
                        WHERE `identifiers`.`identifier_source` = 'http://americanarchiveinventory.org' 
                        AND `local`.`identifier_source` != 'http://americanarchiveinventory.org' 
						AND assets.id='"	.	$asset_id	.	"'
                        GROUP BY `assets`.`id` ";
								$res	=	$this->db->query($sql);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}return	false;
				}

				/**
					* search aseet_dates by assets_id
					* 
					* @param type $assets_id
					* @return object 
					*/
				function	get_assets_dates_by_assets_id($assets_id)
				{
								$this->db->select("$this->_table_asset_dates.asset_date,$this->_table_date_types.date_type");
								$this->db->from($this->_table_asset_dates);
								$this->db->join($this->_table_date_types,	"$this->_table_asset_dates.date_types_id=$this->_table_date_types.id",	"left");
								$this->db->where("$this->_table_asset_dates.assets_id",	$assets_id);
								$res	=	$this->db->get();
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->result();
								}
								return	false;
				}

				/**
					* search assets_genres by assets_id
					* 
					* @param type $assets_id
					* @return object 
					*/
				function	get_assets_genres_by_assets_id($assets_id)
				{
								$this->db->select("genre,genre_source,genre_ref");
								$this->db->from($this->_table_assets_genres);
								$this->db->join($this->_table_genres,	"$this->_table_assets_genres.genres_id=$this->_table_genres.id",	"left");
								$this->db->where("$this->_table_assets_genres.assets_id",	$assets_id);
								$res	=	$this->db->get();
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->result();
								}
								return	false;
				}

				/**
					* search assets_creators_roles by assets_id
					* 
					* @param type $assets_id
					* @return object 
					*/
				function	get_assets_creators_roles_by_assets_id($assets_id)
				{
								$this->db->select("creator_name,creator_affiliation,creator_ref,creator_role ,creator_role_source,creator_role_ref,creators_id");
								$this->db->from($this->_table_assets_creators_roles);
								$this->db->join($this->_table_creator_roles,	"$this->_table_assets_creators_roles.creator_roles_id=$this->_table_creator_roles.id",	"left");
								$this->db->join($this->_table_creators,	"$this->_table_assets_creators_roles.creators_id=$this->_table_creators.id",	"left");
								$this->db->where("$this->_table_assets_creators_roles.assets_id",	$assets_id);
								$res	=	$this->db->get();
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->result();
								}
								return	false;
				}

				/**
					* search assets_contributor_roles by assets_id
					* 
					* @param type $assets_id
					* @return object 
					*/
				function	get_assets_contributor_roles_by_assets_id($assets_id)
				{
								$this->db->select("contributor_role,contributor_role_source,contributor_role_ref ,contributor_name,contributor_affiliation,contributor_source,contributor_ref");
								$this->db->from($this->_table_assets_contributors_roles);
								$this->db->join($this->_table_contributor_roles,	"$this->_table_assets_contributors_roles.contributor_roles_id=$this->_table_contributor_roles.id",	"left");
								$this->db->join($this->_table_contributors,	"$this->_table_assets_contributors_roles.contributors_id=$this->_table_contributors.id",	"left");
								$this->db->where("$this->_table_assets_contributors_roles.assets_id",	$assets_id);
								$res	=	$this->db->get();
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->result();
								}
								return	false;
				}

				/**
					* search assets_publishers_role by assets_id
					* 
					* @param type $assets_id
					* @return object 
					*/
				function	get_assets_publishers_role_by_assets_id($assets_id)
				{
								$this->db->select("publisher_role,publisher_role_source,publisher_role_ref ,publisher,publisher_affiliation,publisher_ref");
								$this->db->from($this->_table_assets_publishers_role);
								$this->db->join($this->_table_publisher_roles,	"$this->_table_assets_publishers_role.publisher_roles_id=$this->_table_publisher_roles.id",	"left");
								$this->db->join($this->_table_publishers,	"$this->_table_assets_publishers_role.publishers_id=$this->_table_publishers.id",	"left");
								$this->db->where("$this->_table_assets_publishers_role.assets_id",	$assets_id);
								$res	=	$this->db->get();
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->result();
								}
								return	false;
				}

				/**
					* search nomination_status by @status
					* 
					* @param type $status
					* @return object 
					*/
				function	get_nomination_status_by_status($status)
				{
								$this->db->where("status LIKE",	$status);
								$res	=	$this->db->get($this->_table_nomination_status);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search publishers by @publisher
					* 
					* @param type $publisher
					* @return object 
					*/
				function	get_publishers_by_publisher($publisher)
				{
								$this->db->where("publisher LIKE",	$publisher);
								$res	=	$this->db->get($this->_table_publishers);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search publisher roles data by publisher_role
					* 
					* @param $publisher_role
					* @return object 
					*/
				function	get_publisher_role_by_role($publisher_role)
				{
								$this->db->where("publisher_role",	$publisher_role);
								$res	=	$this->db->get($this->_table_publisher_roles);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search contributor by contributor_name
					* 
					* @param type $contributor_name
					* @return object 
					*/
				function	get_contributor_by_contributor_name($contributor_name)
				{
								$this->db->where("contributor_name",	$contributor_name);
								$res	=	$this->db->get($this->_table_contributors);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search  contributor roles data by contributor_role
					* 
					* @param $contributor_role
					* @return object 
					*/
				function	get_contributor_role_by_role($contributor_role)
				{
								$this->db->where("contributor_role",	$contributor_role);
								$res	=	$this->db->get($this->_table_contributor_roles);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search creator by creator_name
					* 
					* @param type $creator_name
					* @return object 
					*/
				function	get_creator_by_creator_name($creator_name)
				{
								$this->db->where("creator_name",	$creator_name);
								$res	=	$this->db->get($this->_table_creators);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search  creator roles data by role
					* 
					* @param type $creator_role
					* @return object 
					*/
				function	get_creator_role_by_role($creator_role)
				{
								$this->db->where("creator_role",	$creator_role);
								$res	=	$this->db->get($this->_table_creator_roles);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search id by description_type
					* 
					* @param type $description_type
					* @return object 
					*/
				function	get_description_id_by_type($description_type)
				{
								$this->db->where("description_type",	$description_type);
								$res	=	$this->db->get($this->_table_description_types);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search assets tyoe by type
					* 
					* @param type $asset_type
					* @return object 
					*/
				function	get_assets_type_by_type($asset_type)
				{
								$this->db->where("asset_type",	$asset_type);
								$res	=	$this->db->get($this->_table_asset_types);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search subjects by subject
					* 
					* @param type $subject
					* @return object 
					*/
				function	get_subjects_id_by_subject($subject)
				{
								$this->db->where("subject",	$subject);
								$res	=	$this->db->get($this->_table_subjects);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search subject by assets_id
					* 
					* @param type $title_type
					* @return object 
					*/
				function	get_subjects_by_assets_id($assets_id)
				{
								$this->db->select("subject,subject_source,subject_ref");
								$this->db->from($this->_table_assets_subjects);
								$this->db->join($this->_table_subjects,	"$this->_table_assets_subjects.subjects_id=$this->_table_subjects.id",	"left");
								$this->db->where($this->_table_assets_subjects	.	".assets_id",	$assets_id);
								$res	=	$this->db->get();
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->result();
								}
								return	false;
				}

				/**
					* search asset_title_types by title_type
					* 
					* @param type $title_type
					* @return object 
					*/
				function	get_asset_title_types_by_title_type($title_type)
				{
								$this->db->where("title_type",	$title_type);
								$res	=	$this->db->get($this->_table_asset_title_types);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* search asset by id
					* 
					* @param type $id
					* @return object 
					*/
				function	get_asset_by_id($assets_id)
				{
								$this->db->where("id",	$station_id);
								$res	=	$this->db->get($this->_assets_table);
								if(isset($res)	&&	!	empty($res))
								{
												return	$res->row();
								}
								return	false;
				}

				/**
					* get assets by staion id
					* 
					* @param type $station_id
					* @return array 
					*/
				function	get_assets_by_station_id($station_id)
				{
								$this->db->select("*");
								$this->db->where("stations_id",	$station_id);
								return	$this->db->get($this->_assets_table)->result();
				}

				/**
					* update the stations record
					* 
					* @param type $station_id
					* @param array $data
					* @return boolean 
					*/
				function	update_assets($id,	$data)
				{
								$data["updated"]	=	date("Y-m-d H:i:s");
								$this->db->where("id",	$id);
								return	$this->db->update($this->_assets_table,	$data);
				}

				/*
					*
					* insert the records in assets 
					* 
					* @param array $data
					* @return last inserted id 
					*/

				function	insert_assets($data)
				{
								$this->db->insert($this->_assets_table,	$data);
								return	$this->db->insert_id();
				}

				/*
					*
					* insert the records in asset_title_types 
					* 
					* @param array $data
					* @return last inserted id 
					*/

				function	insert_asset_title_types($data)
				{
								$this->db->insert($this->_table_asset_title_types,	$data);
								return	$this->db->insert_id();
				}

				/*
					*
					* insert the records in subjects 
					* 
					* @param array $data
					* @return last inserted id 
					*/

				function	insert_subjects($data)
				{
								$this->db->insert($this->_table_subjects,	$data);
								return	$this->db->insert_id();
				}

				/*
					*
					* insert the records in assets_subjects
					* 
					* @param array $data
					* @return last inserted id 
					*/

				function	insert_assets_subjects($data)
				{
								$this->db->insert($this->_table_assets_subjects,	$data);
								return	$this->db->insert_id();
				}

				/*
					*
					* insert the records in asset_descriptions
					* 
					* @param array $data
					* @return last inserted id 
					*/

				function	insert_asset_descriptions($data)
				{
								$this->db->insert($this->_table_asset_descriptions,	$data);
								return	$this->db->insert_id();
				}

				/*
					*
					* insert the records in description_types
					* 
					* @param array $data
					* @return last inserted id 
					*/

				function	insert_description_types($data)
				{
								$this->db->insert($this->_table_description_types,	$data);
								return	$this->db->insert_id();
				}

				/*
					*
					* insert the records in identifiers
					* 
					* @param array $data
					* @return last inserted id 
					*/

				function	insert_identifiers($data)
				{
								$this->db->insert($this->_table_identifiers,	$data);
								return	$this->db->insert_id();
				}

				/*
					*
					* insert the records in asset_titles
					* 
					* @param array $data
					* @return last inserted id 
					*/

				function	insert_asset_titles($data)
				{
								$this->db->insert($this->_table_asset_titles,	$data);
								return	$this->db->insert_id();
				}

				/*
					*
					* insert the records in asset_types
					* 
					* @param array $data
					* @return last inserted id 
					*/

				function	insert_asset_types($data)
				{
								$this->db->insert($this->_table_asset_types,	$data);
								return	$this->db->insert_id();
				}

				//By Nouman Tayyab
				/**
					*  Insert get genre type for genres table
					*  @param integer $genre
					*  @param object 
					* 
					*/
				function	get_genre_type($genre)
				{
								$this->db->where("genre",	$genre);
								$result	=	$this->db->get($this->_table_genres);
								if(isset($result)	&&	!	empty($result))
								{
												return	$result->row();
								}
								return	false;
				}

				/**
					*  Insert the record in genre table
					*  @param array $data
					*  @param integer last_inserted id
					* 
					*/
				function	insert_genre($data)
				{
								$this->db->insert($this->_table_genres,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in assets_genres table
					*  @param array $data
					*  @param integer last_inserted id
					* 
					*/
				function	insert_asset_genre($data)
				{
								$this->db->insert($this->_table_assets_genres,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in coverages table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_coverage($data)
				{
								$this->db->insert($this->_table_coverages,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert get genre type for audience_levels table
					*  @param integer $audience_level
					*  @return object 
					* 
					*/
				function	get_audience_level($audience_level)
				{
								$this->db->where('audience_level',	$audience_level);
								$result	=	$this->db->get($this->_table_audience_levels);
								if(isset($result)	&&	!	empty($result))
								{
												return	$result->row();
								}
								return	false;
				}

				/**
					*  Insert the record in _table_audience_levels table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_audience_level($data)
				{
								$this->db->insert($this->_table_audience_levels,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in assets_audience_levels table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_asset_audience($data)
				{
								$this->db->insert($this->_table_assets_audience_levels,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert get genre type for audience_levels table
					*  @param integer $audience_rating
					*  @return object 
					* 
					*/
				function	get_audience_rating($audience_rating)
				{
								$this->db->where('audience_rating',	$audience_rating);
								$result	=	$this->db->get($this->_table_audience_ratings);
								if(isset($result)	&&	!	empty($result))
								{
												return	$result->row();
								}
								return	false;
				}

				/**
					*  Insert the record in _table_audience_levels table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_audience_rating($data)
				{
								$this->db->insert($this->_table_audience_ratings,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in assets_audience_ratings table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_asset_audience_rating($data)
				{
								$this->db->insert($this->_table_assets_audience_ratings,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in annotations table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_annotation($data)
				{
								$this->db->insert($this->_table_annotations,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert get genre type for relation_types table
					*  @param integer $relation_type
					*  @return object 
					* 
					*/
				function	get_relation_types($relation_type)
				{
								$this->db->where('relation_type',	$relation_type);
								$result	=	$this->db->get($this->_table_relation_types);
								if(isset($result)	&&	!	empty($result))
								{
												return	$result->row();
								}
								return	false;
				}

				/**
					*  Insert the record in relation_types table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_relation_types($data)
				{
								$this->db->insert($this->_table_relation_types,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in assets_relations table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_asset_relation($data)
				{
								$this->db->insert($this->_table_assets_relations,	$data);
								return	$this->db->insert_id();
				}

				// End Nouman Tayyab
				// Start Ali Raza 
				/**
					*  Insert the record in creators table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_creators($data)
				{
								$this->db->insert($this->_table_creators,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in assets_creators_roles table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_assets_creators_roles($data)
				{
								$this->db->insert($this->_table_assets_creators_roles,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in creator_roles  table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_creator_roles($data)
				{
								$this->db->insert($this->_table_creator_roles,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in creators table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_contributors($data)
				{
								$this->db->insert($this->_table_contributors,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in assets_contributors_roles table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_assets_contributors_roles($data)
				{
								$this->db->insert($this->_table_assets_contributors_roles,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in contributor_roles  table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_contributor_roles($data)
				{
								$this->db->insert($this->_table_contributor_roles,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in publisherss table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_publishers($data)
				{
								$this->db->insert($this->_table_publishers,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in assets_publishers_role table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_assets_publishers_role($data)
				{
								$this->db->insert($this->_table_assets_publishers_role,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in publisher_roles  table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_publisher_roles($data)
				{
								$this->db->insert($this->_table_publisher_roles,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in rights_summaries  table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_rights_summaries($data)
				{
								$this->db->insert($this->_table_rights_summaries,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the records in extensions  table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_extensions($data)
				{
								$this->db->insert($this->_table_extensions,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the records in nominations  table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_nominations($data)
				{
								$this->db->insert($this->_table_nominations,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in nomination_status  table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_nomination_status($data)
				{
								$this->db->insert($this->_table_nomination_status,	$data);
								return	$this->db->insert_id();
				}

				/**
					*  Insert the record in assets_asset_types  table
					*  @param array $data
					*  @return integer last_inserted id
					* 
					*/
				function	insert_assets_asset_types($data)
				{
								$this->db->insert($this->_table_assets_asset_types,	$data);
								return	$this->db->insert_id();
				}

}

?>