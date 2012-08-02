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
   	$vars    = isset($vars)    ? $vars : array() ;
   	$content = isset($content) ? $content : array();
   	$data    = isset($data)    ? $data : array();
	$cma     = $vars['cma'];
	global $user;
//print_r($cma);
?>
<script type="text/javascript">
	var cma = <?php echo json_encode($cma); ?>;
</script>

<?php
$testhttps = $_SERVER['HTTPS'];
/*if($testhttps == 'on')
echo "Yes it is https";
else
echo "Not https";
exit;*/


$servername = $_SERVER['SERVER_NAME'];
//if($_SERVER['HTTPS']=="on" || $_SERVER['HTTP_FRONT_END_HTTPS']=="ON"){
if (strlen($user->uid) && $user->uid != '0') {
	$googleMapUrl = 'https://maps.googleapis.com/maps/api/js?key=' . $GLOBALS['hvcp_config_google_map_key'] . '&sensor=false';
} else {
	$googleMapUrl = 'http://maps.googleapis.com/maps/api/js?key=' . $GLOBALS['hvcp_config_google_map_key'] . '&sensor=false';
}
?>

<script src="<?php echo $googleMapUrl; ?>" type="text/javascript"></script>

<?php
/* This is the common form, submit it by name or id for traversing steps. Actions and other forms should submit
 * through ajax calls. Include vars here that need to be passed from step to step (that cma doesn't handle).
 */
?>
<form id="form-getting-started" name="form-getting-started" autocomplete="off" method="post" action=<?php echo base_path();?>getting-started">
	<input type="hidden" id="current_step" name="current_step" value="<?php echo $vars['current_step']; ?>" />
	<input type="hidden" id="current_activity" name="current_activity" value="<?php echo $vars['current_activity']; ?>" />
	<input type="hidden" id="count_activity" name="count_activity" value="<?php echo $vars['count_activity']; ?>" />
	<input type="hidden" id="onetcode" name="onetcode" value="<?php echo $vars['onetcode']; ?>" />
	<input type="hidden" id="occupation-title" name="occupation-title" value="<?php echo $vars['occupation-title']; ?>" />
	<input type="hidden" id="target_onetcode" name="target_onetcode" value="<?php echo $vars['target_onetcode']; ?>" />
	<input type="hidden" id="target_occupation-title" name="target_occupation-title" value="<?php echo $vars['target_occupation-title']; ?>" />

	<input type="hidden" id="zip" name="zip" value="<?php echo $vars['zip']; ?>" />
	<input type="hidden" id="state" name="state" value="<?php echo $vars['state']; ?>" />
	<input type="hidden" id="stabbr" name="stabbr" value="<?php echo $vars['stabbr']; ?>" />
	<input type="hidden" id="email" name="email" value="<?php echo $vars['email']; ?>" />
	<input type="hidden" id="count_activity" name="count_activity" value="<?php echo $vars['count_activity']; ?>" />
	<input type="hidden" id="stfips" name="stfips" value="<?php echo $vars['stfips']; ?>" />

	<?php /* CMA DATA */?>
	<input type="hidden" id="licenseid" name="licenseid" value="<?php echo $vars['licenseid']; ?>" />
	<input type="hidden" id="licensename" name="licensename" value="<?php echo $vars['licensename']; ?>" />

	<input type="hidden" id="cert_id" name="cert_id" value="<?php echo $vars['cert_id']; ?>" />
	<input type="hidden" id="certname" name="certname" value="<?php echo $vars['certname']; ?>" />

	<input type="hidden" id="program_id" name="program_id" value="<?php echo $vars['program_id']; ?>" />
	<input type="hidden" id="programname" name="programname" value="<?php echo $vars['programname']; ?>" />

	<input type="hidden" id="unit_id" name="unit_id" value="<?php echo $vars['unit_id']; ?>" />
	<input type="hidden" id="provider_name" name="provider_name" value="<?php echo $vars['provider_name']; ?>" />

	<input type="hidden" name="awlevel" id="awlevel" value="<?php echo $vars['awlevel']; ?>" />
	<input type="hidden" name="tawlevel" id="tawlevel" value="<?php echo $vars['tawlevel']; ?>" />

	<input type="hidden" name="type_ecb" id="type_ecb" value="<?php echo $vars['type_ecb']; ?>" />


 	<!-- Next hidden type is to ensure the progress bar doesn't get reset on navigation -->
	<input type="hidden" name="gs_reset" id="gs_reset" value="0" />
</form>


<div id="vcn-gs-container-top"></div>
<div id="vcn-gs-container">
	<div class="vcn-gs-intro">
		<?php
			if (is_array($data['intro_text']))
			{
				echo $data['intro_text'][$vars['current_activity']];
			}
			else
			{
				echo $data['intro_text'];
			}
		?>
	</div>
	<div class="vcn-gs-intro-tag">
		<?php echo $data['intro_tag']; ?>
	</div>

	<div id="vcn-gs-container-content">
		<div id="vcn-gs-content-top"></div>
		<div id="vcn-gs-content">
			<div id="vcn-gs-activities" class="roundedleft10">
			<?php if ($vars['current_step'] != 'finished'){?>
			<div style="font-size:18px; color:#000000; font-weight:bold;padding:10px 0; float:left; width:100%; padding:10px 0 0 12px;">Activities</div>
				<?php
			}
				echo $content['gs_activity']; ?>
			</div>

 		<?php
 			$back_class = $back_disabled = $next_class = $next_disabled = false;
 			if ($vars['current_step'] == 'step-one' AND $vars['current_activity'] == 1)
 			{
 				$back_class = 'off';
 				$back_disabled = 'disabled';
 			}

 			if ($vars['current_step'] == 'finished' && $vars['current_activity'] == 1)
 			{
 				$next_class = 'off';
 				$next_disabled = 'disabled';
 			}

 			switch($vars['current_step'])
 			{
	 				case 'step-one':
 					if($user->uid){
	 					if($vars['current_activity'] == 1){$headers = 'Welcome to the CareerGuide';}
	 					elseif($vars['current_activity'] == 2){$headers = 'How to use the CareerGuide';}
	 					elseif($vars['current_activity'] == 3){$headers = 'Choose Your Location';}
	 					elseif($vars['current_activity'] == 4){$headers = 'Confirm Selections';}
 					}else{
 						if($vars['current_activity'] == 1){$headers = 'Welcome to the CareerGuide';}
	 					elseif($vars['current_activity'] == 2){$headers = 'How to use the CareerGuide';}
	 					elseif($vars['current_activity'] == 3){$headers = 'Choose Your Location';}
	 					elseif($vars['current_activity'] == 4){$headers = 'Create Your Career <br /> Management Account';}
 						elseif($vars['current_activity'] == 5){$headers = 'Confirm Selections';}
 					}
 					break;

 			 		case 'step-two':
 					if($vars['current_activity'] == 1){$headers = 'Choosing a Career';}
 					elseif($vars['current_activity'] == 2){$headers = 'Enter Your Experiences <br /> & Preferences';}
 					elseif($vars['current_activity'] == 3){$headers = 'Choose Your Target Career';}
 					elseif($vars['current_activity'] == 4){$headers = 'Confirm Selections';}
		 			break;

		 			case 'step-three':
 					if($vars['current_activity'] == 1){$headers = 'Finding Education';}
 					elseif($vars['current_activity'] == 2){$headers = 'Licensed Career';}
 					elseif($vars['current_activity'] == 3){$headers = 'Medical and Legal Requirements';}
 					elseif($vars['current_activity'] == 4){$headers = 'Credential, School, and Program';}
		 			elseif($vars['current_activity'] == 5){$headers = 'Identify Certifications';}
		 			elseif($vars['current_activity'] == 6){$headers = 'Financial Aid';}
		 			elseif($vars['current_activity'] == 7){$headers = 'Confirm Selections';}
		 			break;

		 			case 'step-four':
 					if($vars['current_activity'] == 1){$headers = 'Preparing and Applying';}
 					elseif($vars['current_activity'] == 2){$headers = 'High School Graduate?';}
 					elseif($vars['current_activity'] == 3){$headers = 'Test Scores';}
 					elseif($vars['current_activity'] == 4){$headers = 'Academic Preparation';}
 					elseif($vars['current_activity'] == 5){$headers = 'Refresher Courses';}
 					elseif($vars['current_activity'] == 6){$headers = 'Application';}
 					elseif($vars['current_activity'] == 7){$headers = 'Confirm Selections';}
		 			break;

		 			case 'step-five':
 					if($vars['current_activity'] == 1){$headers = 'Earn College Credit';}
 					elseif($vars['current_activity'] == 2){$headers = 'My College Courses';}
 					elseif($vars['current_activity'] == 3){$headers = 'My Military Training';}
 					elseif($vars['current_activity'] == 4){$headers = 'My Professional Training';}
 					elseif($vars['current_activity'] == 5){$headers = 'My National Examinations';}
 					
 					elseif($vars['current_activity'] == 6){$headers = 'My Learning Inventory';}
		 			break;

 			 		case 'finished':
 			 		$headers = 'Congratulations!';
 			 		break;


					default:
 			}
 		?>

			<div id="get-head" class="vcn-gs-my-heading" style="width:460px">
				<span style="float:left;"><!-- the heading will go here TODO --> <?php echo "<div class='vcn-gs-heading'>".$headers."</div>";?></span>
				<span style="float:right; width:118px">
					<a id="vcn-gs-btn-ano-back" title="Previous" alt="Previous" class="<?php echo $back_class ;?>" <?php echo $back_disabled?> onclick="return vcn_gs_back_activity();"></a>
				 	<a id="vcn-gs-btn-ano-next" title="Next" alt="Next" class="<?php echo $next_class ;?>" <?php echo $next_disabled?> onclick="return vcn_gs_next_activity();"></a>
				</span>
			</div>
			 <br /><br /><br /><br /><br />

		 		<?php if ($vars['current_step'] != 'start') {echo"<hr width='73%' size=10; >";}?>

<?php if ($vars['navigation_error']) :?>
	<div id="vcn-gs-main">
		<?php echo $vars['navigation_error'];?>
	</div>
<?php else: ?>
			<div id="vcn-gs-main">
		 		<!--<div id="vcn-gs-skip">
		 			<a id="vcn-gs-btn-skip" onclick="return vcn_gs_next_activity();"></a>
		 		</div>-->
				<div id="vcn-gs-main-content" ><?php print_r($content['gs_main_content']);?></div>
				<div id="vcn-gs-main-note">
					<?php echo $content['gs_main_note']?>
				</div>
				<div id="vcn-gs-main-detail">
 					<?php echo $content['gs_main_detail']?>
 				</div>
		 	</div>

		 	<div id="vcn-gs-navigation" >

	 	 		<!--div id="vcn-gs-start-over">
	 	 		        <form method="post">
	 	 		        <input type="hidden" name="gs_reset" value="1">
		 			< a id="vcn-gs-btn-start-over" title="Start Over" alt="Start Over" onclick="return vcn_gs_start_over(); <?php // $_SESSION['ga_memory']=array("lastStep"=>1);?>" ></a>
		 			</form>
		 		</div-->
		 		<div id="vcn-gs-back-next">
				<?php echo"<hr width='90%' size=10; >";?>
				<br/>
				<span style="float:right; width:118px; margin-right:10px;">
		 			<a id="vcn-gs-btn-back" title="Previous" alt="Previous" class="<?php echo $back_class ;?>" <?php echo $back_disabled?> onclick="return vcn_gs_back_activity();"></a>
		 			<a id="vcn-gs-btn-next" title="Next" alt="Next" class="<?php echo $next_class ;?>" <?php echo $next_disabled?> onclick="return vcn_gs_next_activity();"></a>
		 		</span>
		 		</div>
		 	</div>


<?php endif; ?>
		</div>

		<div id="vcn-gs-content-bot"></div>
	</div>

	<div id="vcn-gs-container-sidebar">
 		<div class="vcn-gs-sidebar-block-top"></div>



		<div id="vcn-gs-sidebar-detail" class="vcn-gs-sidebar-block">
		<?php if($vars['current_step'] == 'step-one' && $vars['current_activity'] == '3'){?>
			<div class="vcn-gs-heading-map" style="margin-top:-5px;">Map
			</div>
			<?php }
			echo $content['gs_sidebar_detail'] ?>
		</div>
		<div class="vcn-gs-sidebar-block-bot"></div>

 		<div class="vcn-gs-sidebar-block-top"></div>
		<div id="vcn-gs-sidebar-status" class="vcn-gs-sidebar-block">
			<div id="vcn-gs-status">
				<?php echo $content['gs_sidebar_status'] ?>
			</div>
		</div>
		<div class="vcn-gs-sidebar-block-bot"></div>

		<!-- div class="vcn-gs-sidebar-block-top"></div>
		<div id="vcn-gs-sidebar-status" class="vcn-gs-sidebar-block">
			<?php $rs_class = 'class="'.$vars['current_step'].'"';  ?>
			<div id="vcn-gs-recommendation" <?php // echo $rs_class; ?> >
			      <p class="red"><strong>VCN Progress Bar</strong></p>
			      <div id="gsProgressBar">
			      	    <div class="progress-container" style="width:80%;">
			                  <div class="noresize" style="width:0%;">
			                  </div>
			            </div>
			            <div style="float:left;">0%
			            </div>
			      </div>
			</div>
		</div>
		<div class="vcn-gs-sidebar-block-bot"></div-->



	</div>
</div>
<div id="vcn-gs-container-bot"></div>


<!-- Start: Added by Prashanth To set login variable logged_in for javascript
if logged, "var logged_in" will be true else "var logged_in" will be false
-->
<?php
$logged_in = $user->uid;
?>
<script type="text/javascript">
  var logged_in = <?php echo $logged_in ? 'true' : 'false'; ?>;
</script>
<!-- End: To set login variable in javascript -->