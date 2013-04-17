<div class="row">
	<div style="margin: 2px 0px 10px 0px;float:left;width: 570px;">

		<?php
		$asset_title_type = explode('|', trim(str_replace('(**)', '', $asset_details->title_type)));
		$asset_title = explode('|', trim(str_replace('(**)', '', $asset_details->title)));
		$asset_title_ref = explode('|', trim(str_replace('(**)', '', $asset_details->title_ref)));
		$combine_title = '';
		foreach ($asset_title as $index => $title)
		{
			if (isset($asset_title_type[$index]) && $asset_title_type[$index] != '')
				$combine_title.= $asset_title_type[$index] . ': ';
			if (isset($asset_title_ref[$index]))
			{
				if ($asset_title_ref[$index] != '')
				{
					$combine_title.="<a target='_blank' href='$asset_title_ref[$index]'>$title</a>: ";
					$combine_title.=' (' . $asset_title_ref[$index] . ')';
				}
				else
					$combine_title.=$title;
			}
			else
				$combine_title.=$title;
			$combine_title.='<div class="clearfix"></div>';
		}
		?>
		<h2><?php echo $combine_title; ?></h2>
	</div>
	<div class="clearfix"></div>
	<?php $this->load->view('partials/_list'); ?>
	<div class="span9" style="margin-left: 250px;" id="ins_view_detail">
		<form class="form-horizontal" method="POST" action="<?php echo site_url('assets/edit/' . $asset_id); ?>" id="edit_asset_form">
			<table cellPadding="8" class="record-detail-table">
				<tr>
					<?php
					$add = ' ADD INSTANTIATION ID';
					?>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> INSTANTIATION ID:</b></label>
					</td>
					<td>
						<div id="main_instantiation_id">
							<?php
							if (count($inst_identifier) > 0)
							{
								$add = ' ADD ANOTHER INSTANTIATION ID';
								foreach ($inst_identifier as $index => $identifier)
								{
									?>
									<div id="remove_instantiation_id_<?php echo $index; ?>" class="remove_instantiation_id">
										<div class="edit_form_div">
											<div>
												<p>INSTANTIATION ID:</p>
												<p>
													<input type="text" id="instantiation_id_identifier_<?php echo $index; ?>" name="instantiation_id_identifier[]" value="<?php echo trim($identifier->instantiation_identifier); ?>" />
												</p>
											</div>
											<div>
												<p>INSTANTIATION ID SOURCE:</p>
												<p>
													<input type="text" id="instantiation_id_source_<?php echo $index; ?>" name="instantiation_id_source[]" value="<?php echo trim($identifier->instantiation_source); ?>" />
												</p>
											</div>

										</div>
										<div class="remove_element" onclick="removeElement('#remove_instantiation_id_<?php echo $index; ?>', 'instantiation_id');"><img src="/images/remove-item.png" /></div>
										<div class="clearfix" style="margin-bottom: 10px;"></div>
									</div>

									<?php
								}
							}
							?>
						</div>
						<div class="add-new-element" onclick="addElement('#main_instantiation_id', 'instantiation_id');"><i class="icon-plus-sign icon-white"></i><span id="add_local_id"><?php echo $add; ?></span></div>

					</td>

				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Instantiation Date:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="inst_date" name="inst_date" value="<?php echo (isset($date->instantiation_date) ? $date->instantiation_date : ''); ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Instantiation Date Type:</b></label>
					</td>
					<td>
						<p>
							<select id="inst_date_type" name="inst_date_type">
								<?php
								foreach ($pbcore_asset_date_types as $row)
								{
									$selected = '';
									if (isset($date->date_type) && $date->date_type == $row->value)
										$selected = 'selected="selected"'
										?>
									<option value="<?php echo $row->value; ?>" <?php echo $selected; ?>><?php echo $row->value; ?></option>
								<?php }
								?>
							</select>
						</p>

					</td>
				</tr>

				<tr>
					<?php
					$add = ' ADD DIMENSION';
					?>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> DIMENSION:</b></label>
					</td>
					<td>
						<div id="main_dimension">
							<?php
							if (count($inst_demension) > 0)
							{
								$add = ' ADD ANOTHER DIMENSION';
								foreach ($inst_demension as $index => $demension)
								{
									?>
									<div id="remove_dimension_<?php echo $index; ?>" class="remove_dimension">
										<div class="edit_form_div">
											<div>
												<p>Dimension:</p>
												<p>
													<input type="text" id="dimension_<?php echo $index; ?>" name="asset_dimension[]" value="<?php echo $demension->instantiation_dimension; ?>" />
												</p>
											</div>
											<div>
												<p>Unit of measure:</p>
												<p>
													<input type="text" id="dimension_unit_<?php echo $index; ?>" name="dimension_unit[]" value="<?php echo $demension->unit_of_measure; ?>" />
												</p>
											</div>
										</div>
										<div class="remove_element" onclick="removeElement('#remove_dimension_<?php echo $index; ?>', 'dimension');"><img src="/images/remove-item.png" /></div>
										<div class="clearfix" style="margin-bottom: 10px;"></div>
									</div>

									<?php
								}
							}
							?>
						</div>
						<div class="add-new-element" onclick="addElement('#main_dimension', 'dimension');"><i class="icon-plus-sign icon-white"></i><span id="add_date"><?php echo $add; ?></span></div>

					</td>

				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Standard:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="standard" name="standard" value="<?php echo $instantiation_detail->standard; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Location:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="location" name="location" value="<?php echo $instantiation_detail->location; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> File Size:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="file_size" name="file_size" value="<?php echo $instantiation_detail->file_size; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> File Size Unit of measure:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="file_size_unit" name="file_size_unit" value="<?php echo $instantiation_detail->file_size_unit_of_measure; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Time start:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="time_start" name="time_start" value="<?php echo $instantiation_detail->time_start; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Projected Duration:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="projected_duration" name="projected_duration" value="<?php echo $instantiation_detail->projected_duration; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Actual Duration:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="actual_duration" name="actual_duration" value="<?php echo $instantiation_detail->actual_duration; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Data rate:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="data_rate" name="data_rate" value="<?php echo $instantiation_detail->data_rate; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Data rate unit of measure:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="data_rate_unit" name="data_rate_unit" value="<?php echo (isset($inst_data_rate_unit->unit_of_measure) ? $inst_data_rate_unit->unit_of_measure : ''); ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Color:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="color" name="color" value="<?php echo (isset($inst_color->color) ? $inst_color->color : ''); ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Tracks:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="tracks" name="tracks" value="<?php echo $instantiation_detail->tracks; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Channel Configuration:</b></label>
					</td>
					<td>
						<p>
							<input type="text" id="channel_configuration" name="channel_configuration" value="<?php echo $instantiation_detail->channel_configuration; ?>" />
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Language:</b></label>
					</td>
					<td>
						<p>
							<input type="text" value="<?php echo $instantiation_detail->language; ?>"  id="language" name="language"/>
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Media Type:</b></label>
					</td>
					<td>
						<p>
							<?php
							$media_type = explode(' | ', $inst_media_type->media_type);
							$static_types = array('Animation', 'Artifact', 'Collection', 'Dataset', 'Event', 'Interactive', 'Moving Image', 'Object', 'Presentation', 'Service', 'Software', 'Sound', 'Static Image', 'Text');
							?>
							<select  id="media_type" name="media_type" style="width: 300px;">
								<?php
								foreach ($static_types as $row)
								{
									$selected = '';
									if (in_array($row, $media_type))
										$selected = 'selected="selected"';
									?>
									<option value="<?php echo $row; ?>" <?php echo $selected; ?>><?php echo $row; ?></option>
								<?php }
								?>

							</select>
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Nomination Status:</b></label>
					</td>
					<td>
						<p>
							<select id="nomination" name="nomination">
								<option value="">Select</option>
								<?php
								foreach ($nominations as $row)
								{
									$selected = '';
									if (isset($ins_nomination->status) && $ins_nomination->status == $row->status)
										$selected = 'selected="selected"'
										?>
									<option value="<?php echo $row->status; ?>" <?php echo $selected; ?>><?php echo $row->status; ?></option>
								<?php }
								?>
							</select>
						</p>

					</td>
				</tr>
				<tr>
					<td class="record-detail-page">
						<label><i class="icon-question-sign"></i><b> Nomination Reason:</b></label>
					</td>
					<td>
						<p>
							<textarea style="width: 540px;height: 90px;" id="nomination_reason" name="nomination_reason"><?php echo (isset($ins_nomination->nomination_reason)) ? $ins_nomination->nomination_reason : ''; ?></textarea>
						</p>

					</td>
				</tr>

				<tr>
					<td colspan="2">
						<a class="btn" href="<?php echo site_url('instantiations/detail/' . $inst_id); ?>">Cancel</a>
						<input type="button" onclick="validateForm();" value="Save Changes" class="btn btn-primary"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript">



</script>
<!--<script type="text/javascript" src="/js/edit_asset.js"></script>-->