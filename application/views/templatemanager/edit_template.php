<?php
$system_id = array(
    'name' => 'system_id',
    'id' => 'system_id',
    'value' => $template_detail->system_id,
);
$subject = array(
    'name' => 'subject',
    'id' => 'subject',
    'value' => $template_detail->subject,
);
$body_plain = array(
    'name' => 'body_plain',
    'id' => 'body_plain',
    'value' => $template_detail->body_plain,
);
$body_html = array(
    'name' => 'body_html',
    'id' => 'body_html',
    'value' => $template_detail->body_html,
);
$form_attributes = array('id' => 'edit_template',"class"=>"bs-docs-example");
$from = array(
    'name' => 'email_from',
    'id' => 'email_from',
    'value' =>$template_detail->email_from,
);
$reply_to = array(
    'name' => 'reply_to',
    'id' => 'reply_to',
    'value' => $template_detail->reply_to,
);
$rep_decode='';
if(isset($template_detail->replaceables) && !empty($template_detail->replaceables))
{
	$rep_decode=implode("\n",json_decode($template_detail->replaceables,true));
}
$replacebale = array(
    'name' => 'replaceables',
    'id' => 'replaceables',
    'value' =>$rep_decode ,
);
//$replacebale=array("{station name}","{first name}","{last name}","{start date}","{end date}");

echo form_open_multipart(site_url('templatemanager/edit/'.$template_id), $form_attributes);
?>
<?php 
if($add_temp){?>
       <div class="alert alert-success">Template Added Successfully</div>
    <?php } ?>
<table class="table no_border">

    <tr>
          <td><?php echo form_label('System id', $system_id['id']); ?></td>
          <td><span class="input-xlarge uneditable-input">Some value here</span></td>
          
       	</tr>
        <tr>
          <td><?php echo form_label('Email From*', $from['id']); ?></td>
          <td><?php echo form_input($from); ?><span class="help-inline"><?php echo form_error($from['id']); ?></span></td>
          
        </tr>
        <tr>
          <td><?php echo form_label('Reply To*', $reply_to['id']); ?></td>
          <td><?php echo form_input($reply_to); ?><span class="help-inline"><?php echo form_error($reply_to['id']); ?></span></td>
           
        </tr>
        <tr>
          <td><?php echo form_label('Subject*', $subject['id']); ?></td>
          <td><?php echo form_input($subject); ?><span class="help-inline"><?php echo form_error($subject['id']); ?></span></td>
          
        </tr>
        <tr>
        	<td><?php echo form_label('Replaceables', $subject['id']); ?></td>
         	<td><?php echo form_textarea($replacebale); ?></td>
     
        </tr>
        <tr>
       	<td><?php echo form_label('Email Type', 'email_type'); ?></td>
        <td>
          <select name="email_type" id="email_type" class="span2" onchange="toggal_message_body();">
            <option value="plain" <?php echo set_select('email_type', 'plain', TRUE); ?>>Plain</option>
            <option value="html" <?php echo set_select('email_type', 'html'); ?>>Html</option>
         </select>
				</td>
       </tr>
        <tr>
        	<td><?php echo form_label('Plain Body', $body_plain['id']); ?></td>
        	<td><?php echo form_textarea($body_plain); ?></td>
     
        </tr>
        <tr id="html_body_msg" style="display:none">
        	<td><?php echo form_label('Html Body', $body_html['id']); ?></td>
        	<td><?php echo form_textarea($body_html); ?></td>
     
        </tr>
          
        
        
       
       <tr>
        <td colspan="2" align="center"><?php echo form_submit('updatetemplate', 'Update Template', 'class="btn" '); ?></td>
    </tr>
</table>

<?php echo form_close(); ?>
