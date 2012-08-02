<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

	<?php
	/*
	 * Get specific stuff for step and activity. Down the road
 	 * You can create functions here or include other templates if needed.
	 *
 	 */
 	$template_dir = vcn_getting_started_get_path('templates');

    /** seems to me that this could be much simpler
     *
    $stepValue = str_replace('-",'_',$vars['current_step']);
    $activityValues = array('zero','one','two','three','four','five','six','seven','eight','nine');  // 'zero' is just a place holder
    $avitiyValue = $activityValues[(int)$vars['current_activity']];

    include_once($template_dir.'/'.$stepValue.'/activity_'.$activityValue.'_main_content.tpl.php');

     *
     */
?>

<?php if ($vars['current_step'] == 'step-one' ) : ?>
	<?php
		// ACTIVITY SPECIFIC STUFF FOR STEP ONE
		global $user;
		if ($user->uid){
			switch ( $vars['current_activity'] )
			{
				case '1':
					include_once($template_dir.'/step_one/activity_one_main_content.tpl.php');
				break;
				case '2':
					include_once($template_dir.'/step_one/activity_two_main_content.tpl.php');
				break;
				case '3':
					include_once($template_dir.'/step_one/activity_three_main_content.tpl.php');
				break;
				case '4':
					include_once($template_dir.'/step_one/activity_five_main_content.tpl.php');
				break;			
				default:
			}
		}
		else{
			switch ( $vars['current_activity'] )
			{
				case '1':
					include_once($template_dir.'/step_one/activity_one_main_content.tpl.php');
				break;
				case '2':
					include_once($template_dir.'/step_one/activity_two_main_content.tpl.php');
				break;
				case '3':
					include_once($template_dir.'/step_one/activity_three_main_content.tpl.php');
				break;
				case '4':
					include_once($template_dir.'/step_one/activity_four_main_content.tpl.php');
				break;
				case '5':
					include_once($template_dir.'/step_one/activity_five_main_content.tpl.php');
				break;			
				default:
			}			
		}
	?>


<?php elseif ($vars['current_step'] == 'step-two') : ?>
	<?php
		// ACTIVITY SPECIFIC STUFF FOR STEP TWO
		switch ( $vars['current_activity'] )
		{
			case '1':
				include_once($template_dir.'/step_two/activity_one_main_content.tpl.php');
			break;
			case '2':
				include_once($template_dir.'/step_two/activity_two_main_content.tpl.php');
			break;
			case '3':
				include_once($template_dir.'/step_two/activity_three_main_content.tpl.php');
			break;
			case '4':
				include_once($template_dir.'/step_two/activity_four_main_content.tpl.php');
			break;

			default:
		}
	?>

<?php elseif ($vars['current_step'] == 'step-three') : ?>
	<?php
		// ACTIVITY SPECIFIC STUFF FOR STEP THREE
		switch ( $vars['current_activity'] )
		{
			case '1':
				include_once($template_dir.'/step_three/activity_one_main_content.tpl.php');
			break;
			case '2':
				include_once($template_dir.'/step_three/activity_two_main_content.tpl.php');
			break;
			case '3':
				include_once($template_dir.'/step_three/activity_three_main_content.tpl.php');
			break;
			case '4':
				include_once($template_dir.'/step_three/activity_four_main_content.tpl.php');
			break;
			case '5':
				include_once($template_dir.'/step_three/activity_five_main_content.tpl.php');
			break;
			case '6':
				include_once($template_dir.'/step_three/activity_six_main_content.tpl.php');
			break;		
			case '7':
				include_once($template_dir.'/step_three/activity_seven_main_content.tpl.php');
			break;				
			default:
		}
	?>

<?php elseif ($vars['current_step'] == 'step-four') : ?>
	<?php
		// ACTIVITY SPECIFIC STUFF FOR STEP FOUR
		switch ( $vars['current_activity'] )
		{
			case '1':
				include_once($template_dir.'/step_four/activity_one_main_content.tpl.php');
			break;
			case '2':
				include_once($template_dir.'/step_four/activity_two_main_content.tpl.php');
			break;
			case '3':
				include_once($template_dir.'/step_four/activity_three_main_content.tpl.php');
			break;
			case '4':
				include_once($template_dir.'/step_four/activity_four_main_content.tpl.php');
			break;
			case '5':
				include_once($template_dir.'/step_four/activity_five_main_content.tpl.php');
			break;
			case '6':
				include_once($template_dir.'/step_four/activity_six_main_content.tpl.php');
			break;
			case '7':
				include_once($template_dir.'/step_four/activity_seven_main_content.tpl.php');
			break;
			default:
				echo '<p>This is not a valid activity for this step in Get Started.</p>';
		}
	?>

<?php elseif ($vars['current_step'] == 'step-five') : ?>
	<?php
		// ACTIVITY SPECIFIC STUFF FOR STEP FIVE
		switch ( $vars['current_activity'] )
		{
			case '1': include_once($template_dir.'/step_five/activity_one_main_content.tpl.php');
			break;
			case '2': include_once($template_dir.'/step_five/activity_two_main_content.tpl.php');
			break;
			case '3': include_once($template_dir.'/step_five/activity_three_main_content.tpl.php');
			break;
			case '4': include_once($template_dir.'/step_five/activity_four_main_content.tpl.php');
			break;
			case '5': include_once($template_dir.'/step_five/activity_five_main_content.tpl.php');
			break;
			case '6': include_once($template_dir.'/step_five/activity_six_main_content.tpl.php');
			break;
			default:
		}
	?>
	
<?php elseif ($vars['current_step'] == 'finished') : ?>
	<?php
		switch ( $vars['current_activity'] )
		{
			case '1': include_once($template_dir.'/finished/activity_two_main_content.tpl.php');
			break;
			default:
		}
	?>
	
<?php elseif ($vars['current_step'] == 'start') : ?>
	<?php
		switch ( $vars['current_activity'] )
		{
			case '1': include_once($template_dir.'/start/activity_one_main_content.tpl.php');
			break;
			default:
		}
	?>	
<?php endif; ?>


<?php // code for progress bar
if(!is_array($_SESSION['gsStepCountArray']))$_SESSION['gsStepCountArray']=array();
if(isset($_POST['gs_reset']) && $_POST['gs_reset']==1) $_SESSION['gsStepCountArray']=array();
if($vars['current_step']!="finished")
  {
  $gsStep=$vars['current_step']."-".$vars['current_activity'];
  $_SESSION['gsStepCountArray'][$gsStep]=1;
  }
$gsStepItemCount=count($_SESSION['gsStepCountArray']);
$gsPctDone=floor($gsStepItemCount/$vars['total_activities_count']*100);
