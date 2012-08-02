<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
function vcn_getting_started_get_path($type)
{
	$path = false;
	switch($type)
	{
		case 'templates':
			$path = drupal_get_path('module','vcn_getting_started').'/templates';
		break;
		default;
	}
	return $path;
}

function vcn_getting_started_static_data ( $step, &$data, &$vars )
{
	 // set onetcode
	if (!array_key_exists('onetcode',$vars) OR !$vars['onetcode'])
	{
		$vars['onetcode'] = (array_key_exists('target_onetcode',$vars) AND $vars['target_onetcode']) ? $vars['target_onetcode'] :'';
	}

	// validate step
	$step_array  = array('step-one','step-two','step-three','step-four','step-five','finished');
	if (!in_array($step, $step_array)) $step = $vars['current_step'] = 'step-one';

 	$activity = $note  = array();
	$intro_text = $total_activities = false;

	switch ($step)
	{
		case 'step-one':
			global $user;
			if ($user->uid){
				$activity = array(
				'1' => array('title'=>'activity-one', 'text'=>'Welcome to CareerGuide'),
				'2' => array('title'=>'activity-two', 'text'=>'How to use the CareerGuide'),
				'3' => array('title'=>'activity-three', 'text'=>'Choose Your Location'),
				'4' => array('title'=>'activity-four', 'text'=>'Confirm Selections'),
			);
			$note = array(
				'1' => array('title'=>'note-one', 'text'=>''),
				'2' => array('title'=>'note-two', 'text'=>''),
				'3' => array('title'=>'note-three', 'text'=>''),
				'4' => array('title'=>'note-five', 'text'=>''),
			);
			$intro_text = array(
				'1' => 'Step 1 "Get Started":  Introduction to Healthcare and the CareerGuide.',
				'2' => 'STEP 1 "Get Started": Learn about the CareerGuide and how to use it.',
				'3' => 'Tell us your preferences, and we will set up the VCN to fit your needs.',
				'4' => 'This activity will have the summary for step 1.',
			);
			$total_activities  = '4';
			}
			else{
			$activity = array(
				'1' => array('title'=>'activity-one', 'text'=>'Welcome to CareerGuide'),
				'2' => array('title'=>'activity-two', 'text'=>'How to use CareerGuide'),
				'3' => array('title'=>'activity-three', 'text'=>'Choose Your Location'),
				'4' => array('title'=>'activity-four', 'text'=>'Create an Account'),
				'5' => array('title'=>'activity-four', 'text'=>'Confirm Selections'),
			);
			$note = array(
				'1' => array('title'=>'note-one', 'text'=>''),
				'2' => array('title'=>'note-two', 'text'=>''),
				'3' => array('title'=>'note-three', 'text'=>''),
				'4' => array('title'=>'note-four', 'text'=>''),
				'5' => array('title'=>'note-five', 'text'=>''),
			);
			$intro_text = array(
				'1' => 'In Step 1 we will introduce you to the VCN and help you create your Career Management Account.',
				'2' => 'In Step 1 we will introduce you to the VCN and help you create your Career Management Account.',
				'3' => 'In Step 1 we will introduce you to the VCN and help you create your Career Management Account.',
				'4' => 'In Step 1 we will introduce you to the VCN and help you create your Career Management Account.',
				'5' => 'In Step 1 we will introduce you to the VCN and help you create your Career Management Account.',
			);
			$total_activities  = '5';
			}
		break;

		case 'step-two':
			$activity = array(
				'1' => array('title'=>'activity-one', 'text'=>'Choosing a Career'),
				'2' => array('title'=>'activity-two', 'text'=>'Enter Your Experiences & Preferences'),
				'3' => array('title'=>'activity-three', 'text'=> 'Choose Your Target Career'),
				'4' => array('title'=>'activity-three', 'text'=> 'Confirm Selections'),
			);
			$note = array(
				'1' => array('title'=>'note-one', 'text'=>''),
				'2' => array('title'=>'note-two', 'text'=>''),
				'3' => array('title'=>'note-three', 'text'=>''),
				'4' => array('title'=>'note-three', 'text'=>''),
			);

			$intro_text = 'In Step 2 we will help you find the career in healthcare best suited to your interests, skills and preferences.';
			$total_activities  = '4';

		break;

		case 'step-three':
			$activity = array(
				'1' => array('title'=>'activity-one', 'text'=>'Finding Education'),
				'2' => array('title'=>'activity-two', 'text'=>'Licensed Career'),
				'3' => array('title'=>'activity-three', 'text'=>'Medical and Legal Requirements'),
				'4' => array('title'=>'activity-four', 'text'=>'Credential, School, and Program'),
				'5' => array('title'=>'activity-five', 'text'=>'Identify Certifications'),
				'6' => array('title'=>'activity-six', 'text'=> 'Financial Aid'),
				'7' => array('title'=>'activity-seven', 'text'=> 'Confirm Selections'),
			);
			$note = array(
			/*	'1' => array('title'=>'note-one', 'text'=>'<strong>Hint:</strong> This information will help you make the right choices in the next activity.'),*/
		 /*	    '2' => array('title'=>'note-two', 'text'=>'<strong>Hint:</strong> Keep in mind the requirement for obtaining a license in your state from the previous activity.'),
		  * */
			    '1' => array('title'=>'note-one', 'text'=>''),
				'2' => array('title'=>'note-two', 'text'=>''),
				'3' => array('title'=>'note-three', 'text'=>''),
		     	'4' => array('title'=>'note-four', 'text'=>''),
		        '5' => array('title'=>'note-five', 'text'=>'<strong?Hint:</strong> If your target career is a career that is licensed in your state (see Activity 2 above), remember to take the licensing requirements into account when choosing a certification; some licenses require applicants to attain a specific certification prior to applying for a state license.'),
				'6' => array('title'=>'note-six', 'text'=>''),
				'7' => array('title'=>'note-seven', 'text'=>''),
			);

			$intro_text = 'In Step 3 we will help you to identify the credentials - such as certificate, degree, license, or certification - that you will need to succeed in your chosen career and then help you to find an education or training program where you can earn those credentials.';
			$total_activities  = '7';
		break;

		case 'step-four':
			$activity = array(
				'1' => array('title'=>'activity-one',  'text'=> 'Preparing and Applying'),
				'2' => array('title'=>'activity-two',  'text'=> 'High School Graduate?'),
				'3' => array('title'=>'activity-three',  'text'=> 'Test Scores'),
				'4' => array('title'=>'activity-four','text'=> 'Academic Preparation'),
				'5' => array('title'=>'activity-five', 'text'=> 'Refresher Courses'),
 				'6' => array('title'=>'activity-six', 'text'=> 'Application'),
				'7' => array('title'=>'activity-six', 'text'=> 'Confirm Selections'),
			);
			$note = array(
				'1' => array('title'=>'note-one', 'text'=> ''),
// 				'2' => array('title'=>'note-two',  'text'=> '<strong>Hint:</strong> Don\'t worry. If you\'re not a High School graduate, we can help you get your diploma or GED.'),
				'2' => array('title'=> 'note-two', 'text' => '<b>Hint: </b> Don\'t worry if you do not have a high school diploma or GED.  We can help.  Select "NO" to the question above and a list of "virtual" high schools will be displayed. A "virtual" high school is one you can attend online to get your diploma. <strong class="cg_highlight">Click on the name of the virtual high school in your state to find detailed information about what you need to do; most "virtual" high school programs are free to state residents.</strong>  <br><br> <b> Hint:</b>  Another alternative is to obtain a GED (General Education Development) by passing a test.  Information about obtaining a GED and taking the GED test can be found by <a target="_blank" alt="ged info" title="ged info" href="http://www.acenet.edu/AM/Template.cfm?Section=GED_TS">clicking here</a>.'),

				'3' => array('title'=>'note-three',  'text'=>
				''),
				'4' => array('title'=>'note-four','text'=> ''),
				'5' => array('title'=>'note-five', 'text'=> ''),
				'6' => array('title'=>'note-five', 'text'=> ''),
				'7' => array('title'=>'note-five', 'text'=> ''),

			);

			$intro_text = 'In Step 4 we will walk you through the admission requirements associated with the school and program you have chosen and help you determine whether you meet those requirements. Then we will help you prepare your college application.';
			$total_activities  = '7';
		break;

		case 'step-five':
			$activity = array(
			        '1' => array('title'=>'activey-one', 'text'=>'Earn College Credit'),
				'2' => array('title'=>'activity-two', 'text'=>'My College Courses'),
				'3' => array('title'=>'activity-three', 'text'=>'My Military Training'),
				'4' => array('title'=>'activity-four', 'text'=>'My Professional Training'),
				'5' => array('title'=>'activity-five', 'text'=> 'My National Examinations'),
				'6' => array('title'=>'activity-six', 'text'=> 'My Learning Inventory'),
			);
			$note = array(
				'1' => array('title'=>'note-one', 'text'=>''),
				'2' => array('title'=>'note-one', 'text'=>''),
				'3' => array('title'=>'note-two', 'text'=>''),
				'4' => array('title'=>'note-three', 'text'=>''),
				'5' => array('title'=>'note-four', 'text'=>''),
				'6' => array('title'=>'note-five', 'text'=>''),
			);

			$intro_text = 'In Step 5 we will help you determine whether previous training or experience you may have, such as military service, can earn you college credit toward your chosen credential.';

			$total_activities = '6';
		break;

		case 'finished':

			$activity = array(
				'1' => array('title'=>'activity-two', 'text'=>'Congrats!'),
			);
		 	$note = array(
				'1' => array('title'=>'note-two', 'text'=>''),
			);
			$intro_text .= 'Congratulations! You have completed the Career Exploration in the CareerGuide.';
			$total_activities = '1';
			
		break;
		default:
	}

	// validate activity
	if  (!array_key_exists($vars['current_activity'],$activity)) $vars['current_activity'] = 1;

	$data['gs_activity']    = $activity;
	$data['intro_text']     = $intro_text;
	//$data['intro_tag']      =  ($total_activities)  ? 'There are ' . $total_activities . ' main activities in this step.' : '';
	$data['gs_main_note']   = $note;
	$vars['count_activity'] = $total_activities;

	return $data;
}

$vars['total_activities_count']=28;