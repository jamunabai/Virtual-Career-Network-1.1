<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
 
    // var check
   	$vars  = isset($vars) ? $vars : array() ;
 	$cma = $vars['cma'];
?>
 
<script>
	var cma = <?php echo json_encode($cma); ?>;
</script>

<form id="training-form" method="post" autocomplete="off"  action="<?php echo base_path(); ?>find-learning/results/<?php echo $vars['type']; ?>/" onsubmit="return filterTraining(this);" > 
<input type="hidden" id="onetcode" name="onetcode" value="<?php echo $vars['onetcode']; ?>" />
<input type="hidden" id="type" name="type" value="<?php echo $vars['type']; ?>" />
<input type="hidden" id="occupation_title" name="occupation_title" value="<?php echo $vars['occupation_title']; ?>" />
<input type="hidden" id="limit" name="limit" value="<?php echo $vars['limit']; ?>" />
<input type="hidden" id="pg" name="pg" value="<?php echo $vars['pg']; ?>" />
<input type="hidden" id="order" name="order" value="<?php echo $vars['order']; ?>" />
<input type="hidden" id="direction" name="direction" value="<?php echo $vars['direction']; ?>" />
  
<input type="hidden" id="count_courses" name="count_courses" value="<?php echo $vars['count_courses']; ?>" />
<input type="hidden" id="order_courses" name="order_courses" value="<?php echo $vars['order_courses']; ?>" />
<input type="hidden" id="direction_courses" name="direction_courses" value="<?php echo $vars['direction_courses']; ?>" />
<input type="hidden" id="limit_courses" name="limit_courses" value="<?php echo $vars['limit_courses']; ?>" />
<input type="hidden" id="pg_courses" name="pg_courses" value="<?php echo $vars['pg_courses']; ?>" />
<input type="hidden" id="course_id" name="course_id" value="<?php echo $vars['course_id']; ?>" />
<input type="hidden" id="subject_area"  name="subject_area" value="<?php echo $vars['subject_area']; ?>" />
<input type="hidden" id="delivery_mode_name"  name="delivery_mode_name" value="<?php echo $vars['delivery_mode_name']; ?>" />
    
</form>
	 
  
<?php if ($errors) : ?>
	<div class="errors">
<?php foreach ($errors AS $error):?>
		<span class="error"><?php echo $error . '<br />'; ?></span>
<?php endforeach;?>
	</div>
<?php endif; ?>
 
  
 
<div id="training-grid"> 
<table cellspacing="0" cellpadding="10px" align="left" width="960px" border="0"  >
 
<thead>
	<tr valign="top">
      	<th class="sortable<?php if ($vars['order_courses'] == 'course_title') echo $vars['direction_courses']; ?>" align="left" width="240px">Course Title</th>
   		<th class="sortable<?php if ($vars['order_courses'] == 'delivery_mode') echo $vars['direction_courses']; ?>" align="left" width="75px">Type</th>
		<th class="sortable<?php if ($vars['order_courses'] == 'subject_area') echo $vars['direction_courses']; ?>" align="left" width="135px">Subject Area</th>
     	<th width="145px">&nbsp;</th>
	</tr>
</thead>
 

<tbody id="training-grid-data">
 	<?php include('online_courses_grid_update.tpl.php'); ?>
</tbody>

</table>

</div>
	 