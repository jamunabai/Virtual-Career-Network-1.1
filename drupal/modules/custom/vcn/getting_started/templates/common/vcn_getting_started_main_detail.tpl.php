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
?>
<?php if ($vars['current_step'] == 'step-one' ) : ?>
	<?php
		// ACTIVITY SPECIFIC STUFF FOR STEP ONE
		switch ( $vars['current_activity'] )
		{
			case '1':
			break;
			case '2':
			break;
			case '3':
			break;
			case '4':
			break;
			case '5':
			break;			
			default:
		}
	?>


<?php elseif ($vars['current_step'] == 'step-two') : ?>
	<?php
		// ACTIVITY SPECIFIC STUFF FOR STEP TWO
		switch ( $vars['current_activity'] )
		{
			case '1':
			break;
			case '2':
			break;
			case '3':
			break;
			case '4':
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
				include_once($template_dir.'/step_three/activity_one_main_detail.tpl.php');
			break;
			case '2':
				include_once($template_dir.'/step_three/activity_two_main_detail.tpl.php');
			break;
			case '3':
				include_once($template_dir.'/step_three/activity_three_main_detail.tpl.php');
			break;
			case '4':
				include_once($template_dir.'/step_three/activity_four_main_detail.tpl.php');
			break;
			case '5':
				include_once($template_dir.'/step_three/activity_five_main_detail.tpl.php');
			break;	
			case '6':
				include_once($template_dir.'/step_three/activity_six_main_detail.tpl.php');
			break;	
			case '7':
				include_once($template_dir.'/step_three/activity_seven_main_detail.tpl.php');
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
				include_once($template_dir.'/step_four/activity_one_main_detail.tpl.php');
			break;
			case '2':
				include_once($template_dir.'/step_four/activity_two_main_detail.tpl.php');
			break;
			case '3':
				include_once($template_dir.'/step_four/activity_three_main_detail.tpl.php');
			break;
			case '4':
				include_once($template_dir.'/step_four/activity_four_main_detail.tpl.php');
			break;
			case '5':
				include_once($template_dir.'/step_four/activity_five_main_detail.tpl.php');
			break;
			case '6':
				include_once($template_dir.'/step_four/activity_six_main_detail.tpl.php');
			break;
			case '7':
				include_once($template_dir.'/step_four/activity_seven_main_detail.tpl.php');				
			break;			
			default:
				echo '<p>This is not a valid activity for this step in Get Started.</p>';
		}
	?>

<?php elseif ($vars['current_step'] == 'step-five') : ?>
	<?php
	$exp_arr=explode("/",$_SERVER['SCRIPT_FILENAME']);
	array_pop($exp_arr);
	$template_dir=implode("/",$exp_arr)."/sites/all/modules/custom/vcn/getting_started/templates";
		// ACTIVITY SPECIFIC STUFF FOR STEP FIVE
		switch ( $vars['current_activity'] )
		{
			case '1': include_once($template_dir.'/step_five/activity_one_main_detail.tpl.php');
			break;
			case '2': include_once($template_dir.'/step_five/activity_two_main_detail.tpl.php');
			break;
			case '3': include_once($template_dir.'/step_five/activity_three_main_detail.tpl.php');
			break;
			case '4': include_once($template_dir.'/step_five/activity_four_main_detail.tpl.php');
			break;
			case '5': include_once($template_dir.'/step_five/activity_five_main_detail.tpl.php');
			break;
			case '6': include_once($template_dir.'/step_five/activity_six_main_detail.tpl.php');
			break;
			default:
		}
	?>
<?php elseif ($vars['current_step'] == 'finished') : ?>

<?php elseif ($vars['current_step'] == 'start') : ?>

<?php endif; ?>