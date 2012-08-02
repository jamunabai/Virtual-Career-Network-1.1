<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>


<?php
global $user;
$profile = profile_load_profile($user);
//$user->profile_provider_id = 1;



$explodetheurl = explode('/',$_SERVER['REQUEST_URI']);

//if(($user->profile_provider_id === $explodetheurl[6]) && !empty($user->profile_provider_id) || ($user->uid && empty($user->profile_provider_id)) || empty($user->uid)){
?>

<?php if ($_SESSION['provider'] == 0) : ?>
 <div id="training-header">
 	<?php if (in_array($vars['type'], array('programs','certifications','licenses') )) :?><br />
	<strong><?php echo $vars['count_programs']+$vars['count_certifications']+$vars['count_licenses'] ;?></strong>
	<?php else : ?>
		<strong><?php echo $vars['count_'.$vars['type']];?></strong>
 	<?php endif; ?>
	training options found
	<?php if ($vars['occupation-title']) echo 'for <span class="occupation-title"><strong>'.$vars['occupation-title'].'</strong></span>'; ?>
	&nbsp;&nbsp;
 <!-- 	<a class="small-link" href="#">Explore Similar Careers</a> -->
 </div>

<?php if (in_array($vars['type'], array('programs','certifications','licenses')) ) : ?>
	<div class="tabs">
	<div class="primary-tabs">
	<div class="primary-tabs-inner">
		<ul class="tabs primary clear">
			<?php if ($vars['type'] == 'programs') : ?>
				<li class="active" ><a href="#" onclick="return false;"><span class="tab">Programs (<?php echo $vars['count_programs']; ?>)</span></a></li>
			<?php else: ?>
				<li>
			 		<a href="javascript:void(0);" onclick="return selectTrainingTab('programs', '<?php echo $_SERVER['REQUEST_URI']; ?>');" ><span class="tab">Programs (<?php echo $vars['count_programs']; ?>)</span></a>
		       </li>
			<?php endif;?>


			<?php if ($vars['type'] == 'certifications') : ?>
				<li class="active" ><a href="#" onclick="return false;"><span class="tab">Certifications (<?php echo $vars['count_certifications']; ?>)</span></a></li>
			<?php else: ?>
				<li>
			 		<a href="javascript:void(0);" onclick="return selectTrainingTab('certifications', '<?php echo $_SERVER['REQUEST_URI']; ?>');" ><span class="tab">Certifications (<?php echo $vars['count_certifications']; ?>)</span></a>
		        </li>
			<?php endif;?>


			<?php if ($vars['type'] == 'licenses') : ?>
				<li class="active" ><a href="#" onclick="return false;"><span class="tab">Licenses (<?php echo $vars['count_licenses']; ?>)</span></a></li>
			<?php else: ?>
				<li>
			 		<a href="javascript:void(0);" onclick="return selectTrainingTab('licenses', '<?php echo $_SERVER['REQUEST_URI']; ?>');" ><span class="tab">Licenses (<?php echo $vars['count_licenses']; ?>)</span></a>
		       </li>
		   <?php endif;?>
		</ul>
	</div>
	</div>
	</div>
<?php endif; ?>


<?php if ($errors) : ?>
	<div class="errors">
<?php foreach ($errors AS $error):?>
		<span class="error"><?php echo $error . '<br />'; ?></span>
<?php endforeach;?>
	</div>
<?php endif; ?>

	<div id="training-search-container" class="<? echo $vars['type']; ?>" >
		<?php echo $content['search']; ?>
	</div>
<?php elseif($user->profile_provider_id && $_SESSION['provider'] == 1): 
				$vars['unitid']=$user->profile_provider_id;
				$valid['unitid']='valid';
				$providerdetails = vcn_get_data ($errors, $vars, $valid, 'trainingsvc', 'providers', 'detail') ;
?>
	
	<?php if ($vars['type'] == 'programs' ) { ?>
	<center><h3> List of Programs for <?php echo "<span style='color:#A71E28;'>".$providerdetails->providers->instnm."</span>";?></h3></center>	
	<?php } ?>
	
	<div style="width:50%;float: left;">
	<strong><?php echo $vars['count_programs'];?></strong>
	programs found
	</div>
	<div style="width:50%; text-align:right;float: right;">
		<a href="<?php echo base_path(); ?>find-learning/detail/programs/program_id/"><img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/add_new_programs.png" alt="add new program"></a>
	</div>
	<br/><br/>
	
	<?php echo $content['search']; ?>
	
<?php endif; // strlen($user->profile_provider_id) ?>

<div id="training-grid">
<?php if ($vars['type'] == 'programs' ) :?>

<div style="margin-bottom:-10px;">
Hint: Arrows to the right of a heading allow users to sort the column below, e.g., from closest to farthest under the "Distance" column or lowest to highest under the "Award level" column.
</div><br/>

<?php endif; ?>
<table cellspacing="0" cellpadding="10px" align="left" width="960px" border="0"  >
<?php if ($vars['type'] == 'programs' ) : ?>
<?php     if (($user->uid) && $_SESSION['provider'] == 0 || (!$user->uid)) :?>
	<thead>
   		<tr valign="middle">
        	<th class="sortable<?php if ($vars['order_programs'] == 'instnm') echo $vars['direction_programs']; ?>" style="text-align: center;" width="266px">School Name</th>
<?php         if (array_key_exists('zip', $vars) AND $vars['zip'] !== '' AND strlen($vars['zip'])==5 ): ?>
      		<th class="<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '') echo 'sortable'; if ($vars['order_programs'] == 'distance') echo $vars['direction']; ?>" width="126px">Distance</th>
<?php         endif; ?>
        	<th class="sortable<?php if ($vars['order_programs'] == 'program_name') echo $vars['direction_programs']; ?>" style="text-align: center;" width="155px">Program Name</th>
		<th class="sortable<?php if ($vars['order_programs'] == 'awardlevel') echo $vars['direction_programs'];  ?>" style="text-align: left;" width="134px" id="pawlevel" >Award Level</th>
        	<th width="135px" class="unsortable">Save Program</th>
       	</tr>
   	</thead>
<?php     elseif(!empty($user->profile_provider_id) && $_SESSION['provider'] == 1) : ?>
	<thead>
		<tr valign="middle">
			<th class="sortable<?php if ($vars['order_programs'] == 'program_name') echo $vars['direction_programs']; ?>" style="text-align: center;" width="250px">Program Name</th>
        	<th class="sortable<?php if ($vars['order_programs'] == 'program_description') echo $vars['direction_programs']; ?>" style="text-align: center;" width="250px">Program Description</th>
        	<th class="sortable<?php if ($vars['order_programs'] == 'awlevel') echo $vars['direction_programs']; ?>" style="text-align: center;" width="135px">Program Length</th>
			<th class="sortable<?php if ($vars['order_programs'] == 'awardlevel') echo $vars['direction_programs'];  ?>" style="text-align: center;" width="150px" id="pawlevel" >Award Level</th>
			<th class="sortable<?php if ($vars['order_programs'] == 'status') echo $vars['direction_programs']; ?>" style="text-align: center;" width="100px" >Status</th>
       	</tr>
   	</thead>
<?php     endif; ?>
<?php elseif ($vars['type'] == 'certifications' ):?>
    <thead>
      <tr valign="middle">
        <th class="sortable<?php if ($vars['order_certifications'] == 'cert_name') echo $vars['direction_certifications']; ?>"  align="center" >Certification Name</th>
      	<th class="sortable<?php if ($vars['order_certifications'] == 'cert_type_name') echo $vars['direction_certifications']; ?> minwidth" width="60px" align="center" >Type</th>
        <th class="sortable<?php if ($vars['order_certifications'] == 'org_name') echo $vars['direction_certifications']; ?>" align="center" >Certifying Organization</th>
       	<th width="145px" class="unsortable">Save Certification</th>
      </tr>
    </thead>
<?php elseif ($vars['type'] == 'licenses' ): ?>
    <thead>
      <tr valign="middle">
     	<th class="sortable<?php if ($vars['order_licenses'] == 'lictitle') echo $vars['direction_licenses']; ?>" align="left" >License Name</th>
      	<th class="sortable<?php if ($vars['order_licenses'] == 'name1') echo $vars['direction_licenses']; ?>" align="left" >Licensing Agency</th>
       	<th width="145px" class="unsortable">Save License</th>
      </tr>
    </thead>
<?php elseif ($vars['type'] == 'courses' ): ?>
	<thead>
   		<tr valign="middle">
        	<th class="sortable<?php if ($vars['order_courses'] == 'instnm') echo $vars['direction_courses']; ?>" align="left" width="240px">School Name</th>
<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '' AND strlen($vars['zip'])==5 AND !(strstr($_SERVER['REQUEST_URI'],'courses/course_type'))): ?>
      		<th class="<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '') echo 'sortable'; if ($vars['order_courses'] == 'distance') echo $vars['direction']; ?>" align="left" width="70px">Distance</th>
<?php endif; ?>
        	<th class="sortable<?php if ($vars['order_courses'] == 'course_title') echo $vars['direction_courses']; ?>" align="left" width="240px">Course Title</th>
        	<th class="sortable<?php if ($vars['order_courses'] == 'course_type') echo $vars['direction_courses']; ?>" align="left" width="75px">Type</th>
        	<th class="sortable<?php if ($vars['order_courses'] == 'delivery_mode') echo $vars['direction_courses']; ?>" align="left" width="75px">Access</th>
			<th class="sortable<?php if ($vars['order_courses'] == 'subject_area') echo $vars['direction_courses']; ?>" align="left" width="135px">Subject Area</th>
        	<th width="145px">&nbsp;</th>
       	</tr>
	</thead>
<?php elseif ($vars['type'] == 'vhs' ): ?>
	<thead>
   		<tr valign="top">
        	<th class="sortable<?php if ($vars['order_courses'] == 'instnm') echo $vars['direction_courses']; ?>" align="left" width="240px">Name</th>
<!--
      		<th class="<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '') echo 'sortable'; if ($vars['order_courses'] == 'distance') echo $vars['direction']; ?>" align="left" width="70px">Distance</th>
-->
         	<th class="sortable<?php if ($vars['order_courses'] == 'stabbr') echo $vars['direction_courses']; ?>" align="left" width="75px">State</th>
        	<th width="145px">&nbsp;</th>
       	</tr>
	</thead>
<? else :?>
	<p>Search Invalid: <?php echo $vars['type']?></p>
<?php endif; ?>

<tbody id="training-grid-data">
 	<?php
 		if ( in_array($vars['type'], array('programs','certifications','licenses','courses','vhs')) ) {
 			if (!strlen($user->profile_provider_id) && $_SESSION['provider'] == 0) {
 				include('vcn_training_grid_' . $vars['type'] . '.tpl.php');
 			} elseif(!empty($user->profile_provider_id) && $_SESSION['provider'] == 1) {
				//include('vcn_training_grid_' . $vars['type'] . '.tpl.php');
				include('vcn_training_grid_school_programs.tpl.php');
 			} else{
				include('vcn_training_grid_' . $vars['type'] . '.tpl.php');
			}
 		 	
 		}
	?>
</tbody>

</table>
<script>

$("#pawlevel").attr('class','sortableAsc');
</script>
</div>

<input type="hidden" value="1" maxlength="5" id="trpage" name="trpage">


<script>$(document).ready(function() { if ($('#trpage').val()!=1) selectTrainingPage($('#trpage').val()); });</script>
<?php 
/*}else{ // else condition for if($user->profile_provider_id === $explodetheurl[6] || $user->uid && empty($user->profile_provider_id))
//drupal_access_denied();

	drupal_set_title(t('Access denied'));
	echo ' <br />You are not authorized to access this page. <br /><br />';

} */// end of if($user->profile_provider_id === $explodetheurl[6] || $user->uid && empty($user->profile_provider_id))
?>

<?php if ($vars['type'] == 'certifications' ): ?>
<div style="float:right;"><a target="_blank" href="http://www.careeronestop.org"><img alt="COS" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/images/careeronestoplogo.png"></a></div>
<?php endif; ?>