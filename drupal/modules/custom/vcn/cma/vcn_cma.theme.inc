<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
// $Id: vcn_cmx.theme.inc,v 0.1 2011/01/09 10:07:00 hills Exp $

/**
 * @file
 * Provides theme functions for vcn_cma modules
 */



function theme_vcn_cma_profile_view($cma) {
global $user;
$pwpath1 = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
$pwpath2 = $_SERVER['REQUEST_URI'];
$pwpath2 = explode('/', $pwpath2);

  $o  = '<div id="vcn-cma-profile">' . PHP_EOL;
  $o .= '  <dl class="cma-profile">' . PHP_EOL;


//  error_log('theme_vcn_cma_profile - cma_profile: ' . print_r($cma,true));
  $cma_profile = array(
      'firstname' => 'First Name',
      'lastname'  => 'Last Name',
      'address1'   => 'Address1',
      'address2'   => 'Address2',
      'city'       => 'City',
      'state'      => 'State',
      'zipcode'    => 'ZIP Code',
      'homephone' => 'Home Phone',
      'cellphone' => 'Cell Phone',
  );

  foreach ($cma_profile as $k => $v) {
   //   $o .= $userfield . PHP_EOL;
      $k_class = strtolower(str_replace(' ','-',$v));
      $o .= '    <b><dt class="' . $k_class . '-label">' . $v . ':</dt></b>' . PHP_EOL;
      $o .= '    <dd class="' . $k_class . '-element">' . $cma->{$k} . '</dd>' . PHP_EOL;
  }

  $o .='<br />';
  //$o .= '<div> Click <a href="' . $pwpath1.'/'.$pwpath2[1] . '/user/'. $user->uid.'/edit';
  //$o .= '" alt="Change Password '. '">' . 'here' . '</a> to change the Password</div>'. PHP_EOL;
  $o .= '  </dl>' . PHP_EOL;
  $o .= '</div>' . PHP_EOL;
  return $o;
}

function theme_vcn_cma_profile_edit($form) {
    return drupal_render($form);
}


function webserviceitemrank($userid, $item_type='OCCUPATION'){
	    $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('notebook');
        $rest->setAction('get-notebook-items');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $userid);
         $rest->setRequestKey('item_type', $item_type);
       // $rest->setRequestKey('session_id', $this->sessionId);

        $rest->setMethod('post');


        $content = $rest->call();

        $content = new SimpleXMLElement($content);

        return $content;

}

function theme_vcn_cma_notebook_careers($cma) {

    $base_path = base_path();


    $target_career_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/target.png';
    $target_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';
	$cma_programs_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/program_button_cma.png';
	$cma_jobs_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/jobs_button_cma.png';

    $o  = '<div id="vcn-cma-notebook-careers">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-notebook-career-inner">' . PHP_EOL;

   $itemrank = webserviceitemrank($cma->userid,'career');
   $cmamycareer = $cma->mycareers;
   $careercount = count($cmamycareer);
   $cmamycareerkeys = array_keys($cmamycareer);
   $targetsecondcareer = $cmamycareerkeys[1];
   $careercmaid = $cma->userid;
   //echo $cmamycareerkeys[0];

    if (isset($cma->mycareers)) {
    	$count=0;
        foreach ($cma->mycareers as $snapshot) {
		
        //echo"<pre>";
        //print_r($snapshot);
		//exit;

       	$count++;
  //          error_log("MyCareers Snapshot: " . print_r($snapshot,true));
            $o .= '    <div id="onet-' . str_replace('.', '-', $snapshot['onetcode']) . '" class="cma-notebook-snapsot">' . PHP_EOL;
            $o .= '      <div class="cma-notebook-snapsot-inner">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-snapsot-header">' . PHP_EOL;
            $o .= '            <a href="' . $base_path . 'careerdetails?onetcode=' . $snapshot['onetcode'];
            $o .= '" alt="link to details for ' . $snapshot['title'] . '">' . $snapshot['title'] . '</a><span style="padding-left:10px; font-weight:bold;" class="target_careers" id="target_careers_'.str_replace('.', '-', $snapshot['onetcode']).'">' . PHP_EOL;
            if ($count==1 && $itemrank->data->notebookresults->item->itemrank == '1'){$o .= '(This is the Targeted Career)';}
            $o .= '</span>';
            /*$o .= '            <a class="snapshot-target-button" href="' . $base_path . 'cma/notebook/target/career/' . $snapshot['onetcode'];
            $o .= '"><img src="' . $target_career_button . '" title="Target" alt="Target" /></a>' . PHP_EOL;*/
			
			$o .= '            <a class="snapshot-remove-button" secondcareeronet = "'.$targetsecondcareer.'" countvariable = "'.$count.'" careercmaid = "'.$careercmaid.'" careercount = "'.$careercount.'" href="' . $base_path . 'cma/notebook/remove/career/' . $snapshot['onetcode'];
            $o .= '"><img src="' . $target_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
			
			$tmpzip=$cma->zipcode;
			if (strlen($tmpzip)!=5)
				$tmpzip='00000';
				
			$o .= '            <a style ="margin-right:9px;" class="snapshot-remove-button" href="' . $base_path . 'findworkresults?onetcode=' .$snapshot['onetcode'].'&onetcode2='.$snapshot['onetcode'].'&zipcode='.$tmpzip.'&distance=100';
            $o .= '"><img src="' . $cma_jobs_button . '" title="jobs" alt="jobs" /></a>' . PHP_EOL;
			
			
            $o .= '            <a style ="margin-right:9px;" class="snapshot-remove-button" href="' . $base_path . 'find-learning/results/programs/onetcode/'.$snapshot['onetcode'].'/zip/'.$cma->zipcode.'/distance/100';
            $o .= '"><img src="' . $cma_programs_button . '" title="programs" alt="programs" /></a>' . PHP_EOL;
			
			
			
			
			
			
			
			
            $o .= '        </div><!-- /cma-notebook-snapsot-header -->' . PHP_EOL;
            //$o .= '        <hr class="clear-both">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-snapsot-body">' . PHP_EOL;
            $o .= '          <p>Salary: $';
            $o .= number_format($snapshot['wageocc']['item'][1]['pct25'],0,'.',',');
            $o .= ' - $';
            $o .= number_format($snapshot['wageocc']['item'][1]['pct75'],0,'.',',');
            $o .= '</p>' . PHP_EOL;
            $o .= '          <p>Minimum Training: ' . _getTraining($snapshot['typicaltraining']['title']) . '</p>' . PHP_EOL;
            $o .= '          <p>Job Growth: ';
            $o .= $snapshot['jobgrowth']['percent'];
            $o .= '% ';
            $o .= $snapshot['jobgrowth']['text'];
            $o .= '</p>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-snapsot-body -->' . PHP_EOL;
            $o .= '        <div class="cma-notebook-snapsot-match">' . PHP_EOL;
            //$o .= '          <p class="match-prompt">Your match for this career</p>' . PHP_EOL;
            //$matchPercent = 35; // need some form of calculation here...
           // $o .= '          <p class="match-percent">' . $matchPercent . '%</p>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-snapsot-match -->' . PHP_EOL;
            $o .= '        <hr class="clear-both">' . PHP_EOL;
//            $o .= '        <div class="cma-notebook-snapsot-footer">' . PHP_EOL;
//            $o .= '          <p><!-- img src="' . $preview_arrow . '" / -->Preview your career plan</p>' . PHP_EOL;
//            $o .= '        </div><!-- /cma-notebook-snapsot-footer -->' . PHP_EOL;
            $o .= '      </div><!-- /cma-notebook-snapsot-inner -->' . PHP_EOL;
            $o .= '    </div><!-- /cma-notebook-snapsot -->' . PHP_EOL;
        }
    }else{
    	$o .='<br /><br />';
    	$o .='<div><b>You have not saved any Careers</b></div>';
    }
    $o .= '  </div>' . PHP_EOL;
    $o .= '</div>' . PHP_EOL;
    return $o;
}




function theme_vcn_cma_notebook_communities() {

	$o = theme('vcn_community_groups_main');  
    return $o;
}



function _getTraining($training) {

	$pieces = explode(" - ", $training);
	$training = $pieces[0];

	$pieces = explode(" (", $training);
	$training = $pieces[0];

	return $training;

}

function theme_vcn_cma_notebook_certificates($cma) {

    $base_path = base_path();

    $target_certificate_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/target.png';
    $target_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';

    $o  = '<div id="vcn-cma-notebook-certificates">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-notebook-certificate-inner">' . PHP_EOL;

        $itemrank = webserviceitemrank($cma->userid,'certificate');

//    error_log('what does mycertificates look like here - mycertificates: ' . print_r($cma->mycertificates,TRUE));
    if (isset($cma->mycertificates)) {
    	$count=0;
        foreach ($cma->mycertificates as $certificate) {
        	$count++;
            $o .= '    <div id="certificate-' . str_replace('.', '-', $certificate['certid']) . '" class="cma-notebook-program">' . PHP_EOL;
            $o .= '      <div class="cma-notebook-certificate-inner">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-certificate-header">' . PHP_EOL;
            $o .= '            <a href="' . $base_path . 'find-learning/detail/certifications/cert_id/' . $certificate['certid'];
            $o .= '" alt="link to details for ' . $certificate['certname'] . '">' . $certificate['certname'] . '</a><span style="padding-left:10px; font-weight:bold;" class="target_certificate" id="target_certificate_'.str_replace('.', '-', $certificate['certid']).'">' . PHP_EOL;
        	if ($count==1 && $itemrank->data->notebookresults->item->itemrank == '1'){$o .= '<b>(This is the Targeted Certification) </b>';}
            $o .= '</span>';
            /*$o .= '            <a class="certificate-target-button target-button" href="' . $base_path . 'cma/notebook/target/certificate/' . $certificate['certid'];
            $o .= '"><img src="' . $target_certificate_button . '" title="Target" alt="Target" /></a>' . PHP_EOL;*/
            $o .= '            <a class="certificate-remove-button remove-button" careercmaid = "'.$cma->userid.'" href="' . $base_path . 'cma/notebook/remove/certificate/' . $certificate['certid'];
            $o .= '"><img src="' . $target_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-program-header -->' . PHP_EOL;
//            $o .= '        <hr class="clear-both">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-certificate-body">' . PHP_EOL;

            $o .= '<p>' . $certificate['certdescription'] . '</p>' . PHP_EOL;

            $o .= '        </div><!-- /cma-notebook-certificate-body -->' . PHP_EOL;
            $o .= '        <div class="cma-notebook-certificate-match">' . PHP_EOL;
            //$o .= '          <p class="match-prompt">Your match for this certificate</p>' . PHP_EOL;
            //$matchPercent = 35; // need some form of calculation here...
           // $o .= '          <p class="match-percent">' . $matchPercent . '%</p>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-certificate-match -->' . PHP_EOL;
            $o .= '        <hr class="clear-both">' . PHP_EOL;
//            $o .= '        <div class="cma-notebook-certificate-footer">' . PHP_EOL;
//            $o .= '          <p><img src="' . $preview_arrow . '" />Preview your certification plan</p>' . PHP_EOL;
//            $o .= '        </div><!-- /cma-notebook-certificate-footer -->' . PHP_EOL;
            $o .= '      </div><!-- /cma-notebook-certificate-inner -->' . PHP_EOL;
            $o .= '    </div><!-- /cma-notebook-program -->' . PHP_EOL;
        }
    }else{
    	$o .='<br /><br />';
    	$o .='<div><b>You have not saved any Certifications</b></div>';
    }
    $o .= '  </div>' . PHP_EOL;
    $o .= '</div>' . PHP_EOL;
    return $o;
}

function theme_vcn_cma_notebook_courses($cma) {

    $base_path = base_path();

    $target_course_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/target.png';
    $target_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';

    $o  = '<div id="vcn-cma-notebook-courses">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-notebook-course-inner">' . PHP_EOL;

        $itemrank = webserviceitemrank($cma->userid,'course');

//    error_log('what does mycourses look like here - mycourses: ' . print_r($cma->mycourses,TRUE));
    if (isset($cma->mycourses)) {
    	$count=0;
         foreach ($cma->mycourses as $course) {
         	$count++;
            $o .= '    <div id="course-' . str_replace('.', '-', $course['courseid']) . '" class="cma-notebook-course">' . PHP_EOL;
            $o .= '      <div class="cma-notebook-course-inner">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-course-header">' . PHP_EOL;
            $o .= '            <a href="' . $base_path . 'find-learning/detail/courses/course_id/' . $course['courseid'];
            $o .= '" alt="link to details for ' . $course['coursetitle'] . '">' . $course['coursetitle'] . '</a><span style="padding-left:10px; font-weight:bold;" class="target_course" id="target_course_'.str_replace('.', '-', $course['courseid']).'">' . PHP_EOL;
         	if ($count==1 && $itemrank->data->notebookresults->item->itemrank == '1'){$o .= '<b> (This is the Targeted Course) </b>';}
            $o .= '</span>';
            /*$o .= '            <a class="course-target-button" href="' . $base_path . 'cma/notebook/target/course/' . $course['courseid'];
            $o .= '"><img src="' . $target_course_button . '" title="Target" alt="Target" /></a>' . PHP_EOL;*/
            $o .= '            <a class="course-remove-button" careercmaid = "'.$cma->userid.'" href="' . $base_path . 'cma/notebook/remove/course/' . $course['courseid'];
            $o .= '"><img src="' . $target_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-course-header -->' . PHP_EOL;
//            $o .= '        <hr class="clear-both">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-course-body">' . PHP_EOL;
			$o .= '<p>' . 	$course['description'] . '</p>' . PHP_EOL;

            $o .= '        </div><!-- /cma-notebook-course-body -->' . PHP_EOL;
            $o .= '        <div class="cma-notebook-course-match">' . PHP_EOL;
           // $o .= '          <p class="match-prompt">Your match for this course</p>' . PHP_EOL;
            //$matchPercent = 35; // need some form of calculation here...
           // $o .= '          <p class="match-percent">' . $matchPercent . '%</p>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-course-match -->' . PHP_EOL;
            $o .= '        <hr class="clear-both">' . PHP_EOL;
//            $o .= '        <div class="cma-notebook-course-footer">' . PHP_EOL;
//            $o .= '          <p><img src="' . $preview_arrow . '" />Preview your course plan</p>' . PHP_EOL;
//            $o .= '        </div><!-- /cma-notebook-course-footer -->' . PHP_EOL;
            $o .= '      </div><!-- /cma-notebook-course-inner -->' . PHP_EOL;
            $o .= '    </div><!-- /cma-notebook-course -->' . PHP_EOL;
        }
    }else{
    	$o .='<br /><br />';
    	$o .='<div><b>You have not saved any Courses</b></div>';
    }
    $o .= '  </div>' . PHP_EOL;
    $o .= '</div>' . PHP_EOL;
    return $o;
}

function theme_vcn_cma_notebook_licenses($cma) {

    $base_path = base_path();

    $target_license_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/target.png';
    $target_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';

    $o  = '<div id="vcn-cma-notebook-licenses">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-notebook-license-inner">' . PHP_EOL;

        $itemrank = webserviceitemrank($cma->userid,'license');

//    error_log('what does mylicenses look like here - mylicenses: ' . print_r($cma->mylicenses,TRUE));
    if (isset($cma->mylicenses)) {
    	$count=0;
        foreach ($cma->mylicenses as $license) {
        	$count++;
            $o .= '    <div id="license-' . str_replace('.', '-', $license['licenseid'] . $license['stfips'] ) . '" class="cma-notebook-license">' . PHP_EOL;
            $o .= '      <div class="cma-notebook-license-inner">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-license-header">' . PHP_EOL;
            $o .= '            <a href="' . $base_path . 'find-learning/detail/licenses/licenseid/' . $license['licenseid'].'/stfips/'.$license['stfips'];
            $o .= '" alt="link to details for ' . $license['lictitle'] . '">' . $license['lictitle'] . '</a><span style="padding-left:10px; font-weight:bold;" class="target_license" id="target_license_'.str_replace('.', '-', $license['stfips']).'">' . PHP_EOL;
       		if ($count==1 && $itemrank->data->notebookresults->item->itemrank == '1'){$o .= '<b> (This is the Targeted License) </b>';}
            $o .= '</span>';
            /*$o .= '            <a class="license-target-button target-button" href="' . $base_path . 'cma/notebook/target/license/' . $license['licenseid'].'/'.$license['stfips'];
            $o .= '"><img src="' . $target_license_button . '" title="Target" alt="Target" /></a>' . PHP_EOL;*/
            $o .= '            <a class="license-remove-button remove-button" careercmaid = "'.$cma->userid.'" href="' . $base_path . 'cma/notebook/remove/license/' . $license['licenseid'].'/'.$license['stfips'];
            $o .= '"><img src="' . $target_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-license-header -->' . PHP_EOL;
//            $o .= '        <hr class="clear-both">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-license-body">' . PHP_EOL;

            $o .= '<p>' . $license['licdesc'] . '</p>' . PHP_EOL;

            $o .= '        </div><!-- /cma-notebook-license-body -->' . PHP_EOL;
            $o .= '        <div class="cma-notebook-license-match">' . PHP_EOL;
           // $o .= '          <p class="match-prompt">Your match for this license</p>' . PHP_EOL;
           // $matchPercent = 35; // need some form of calculation here...
           // $o .= '          <p class="match-percent">' . $matchPercent . '%</p>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-license-match -->' . PHP_EOL;
            $o .= '        <hr class="clear-both">' . PHP_EOL;
//            $o .= '        <div class="cma-notebook-license-footer">' . PHP_EOL;
//            $o .= '          <p><img src="' . $preview_arrow . '" />Preview your certification plan</p>' . PHP_EOL;
//            $o .= '        </div><!-- /cma-notebook-license-footer -->' . PHP_EOL;
            $o .= '      </div><!-- /cma-notebook-license-inner -->' . PHP_EOL;
            $o .= '    </div><!-- /cma-notebook-program -->' . PHP_EOL;
        }
    }else{
    	$o .='<br /><br />';
    	$o .='<div><b>You have not saved any Licenses</b></div>';
    }
    $o .= '  </div>' . PHP_EOL;
    $o .= '</div>' . PHP_EOL;
    return $o;
}

function theme_vcn_cma_notebook_programs($cma) {
    module_load_include('inc', 'vcn', 'includes/vcn_common');

    $base_path = base_path();

    $target_program_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/target.png';
    $target_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';

    $o  = '<div id="vcn-cma-notebook-programs">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-notebook-program-inner">' . PHP_EOL;

        $itemrank = webserviceitemrank($cma->userid,'program');


//    error_log('what does myprograms look like here - myprograms: ' . print_r($cma->myprograms,TRUE));
    if (isset($cma->myprograms)) {
    	$count=0;
        foreach ($cma->myprograms as $program) {
        	$count++;
         	$cipcode = $program['programcipcode']['item'][0]['cipcode'];

            $o .= '    <div id="onet-' . str_replace('.', '-', $program['programid']).str_replace('.','-',$cipcode) . '" class="cma-notebook-program">' . PHP_EOL;
            $o .= '      <div class="cma-notebook-program-inner">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-program-header">' . PHP_EOL;
            $o .= '            <a href="' . $base_path . 'find-learning/detail/programs/program_id/' . $program['programid'] .'/cipcode/'.$cipcode;
            $o .= '" alt="link to details for ' . $program['programname'] . '">' . $program['programname'] . '</a><span style="padding-left:10px; font-weight:bold;" class="target_program" id="target_program_'.str_replace('.', '-', $cipcode).'">' . PHP_EOL;
        	if ($count==1 && $itemrank->data->notebookresults->item->itemrank == '1'){$o .= '<b>(This is the Targeted Program)</b>';}
            $o .= '</span>';
            /*$o .= '            <a class="program-target-button" href="' . $base_path . 'cma/notebook/target/program/' . $program['programid'].'/'.$cipcode;
            $o .= '"><img src="' . $target_program_button . '" title="Target" alt="Target" /></a>' . PHP_EOL;*/
            $o .= '            <a class="program-remove-button" careercmaid = "'.$cma->userid.'" href="' . $base_path . 'cma/notebook/remove/program/' . $program['programid'].'/'.$cipcode;
            $o .= '"><img src="' . $target_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-program-header -->' . PHP_EOL;
//            $o .= '        <hr class="clear-both">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-program-body">' . PHP_EOL;


            $o .= '          <span class="school-link">' . PHP_EOL;
            if ((string)$program['provider']['webaddr'] !== 'NULL' AND trim((string)$program['provider']['webaddr']) !== '')
            {
          	    $webaddr = substr_compare( 'http',(string)$program['provider']['webaddr'],0,4,true) ? 'http://'. (string)$program['provider']['webaddr'] : (string)$program['provider']['webaddr'];
                $o .= '                  <a target="_blank" href="' . $webaddr . '">' . $program['provider']['instnm'] . '</a>' . PHP_EOL;
            }
            $o .= '          </span><br />' . PHP_EOL;
            if ((string)$program['provider']['addr'] !== 'NULL' AND trim((string)$program['provider']['addr'])) {
                $o .= '                     '. $program['provider']['addr'] . '<br />' . PHP_EOL;
            }
            if ((string)$program['provider']['city'] !== 'NULL' AND trim((string)$program['provider']['city'])) {
                $o .= '                     ' . $program['provider']['city'];
            }
            if ((string)$program['provider']['stabbr'] !== 'NULL' AND trim((string)$program['provider']['stabbr'])) {
             	if ((string)$program['provider']['city'] !== 'NULL' AND trim((string)$program['provider']['city']) ) {
                    $o .= ', ';
                }
             	$o .= $program['provider']['stabbr'];
            }
            if ((string)$program['provider']['zip'] !== 'NULL' AND trim((string)$program['provider']['zip']) !== '') {
                $o .= ' ' . $program['provider']['zip'] . '<br />' . PHP_EOL;
            }
            if ((string)$program['provider']['gentele'] !== 'NULL' AND trim((string)$program['provider']['gentele']) !== '') {
                $o .= '                    '. vcn_format_phone($program['provider']['gentele']) . '<br />' . PHP_EOL;
            }


            if ((string)$program['provider']['admnurl'] !== 'NULL' AND trim((string)$program['provider']['admnurl']) !== '') {
           		$appurl = substr_compare( 'http',(string)$program['provider']['webaddr'],0,4,true) ? 'http://'. (string)$program['provider']['admnurl'] : (string)$program['provider']['admnurl'];
         	 	$o .= '                 <a class="small" target="_blank" href="' . $appurl . '">Admissions</a><br />' . PHP_EOL;
            }
            if ((string)$program['provider']['faidurl'] !== 'NULL' AND trim((string)$program['provider']['faidurl']) !== '') {
           	  $faidurl = substr_compare( 'http',(string)$provider['provider']['webaddr'],0,4,true) ? 'http://'. (string)$program['provider']['faidurl'] : (string)$program['provider']['faidurl'];
         	   $o .= '                  <a class="small" target="_blank" href="' . $faidurl . '">Financial Aid</a><br />' . PHP_EOL;
            }



            $o .= '        </div><!-- /cma-notebook-program-body -->' . PHP_EOL;
            $o .= '        <div class="cma-notebook-program-match">' . PHP_EOL;
           // $o .= '          <p class="match-prompt">Your match for this program</p>' . PHP_EOL;
            //$matchPercent = 35; // need some form of calculation here...
           // $o .= '          <p class="match-percent">' . $matchPercent . '%</p>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-program-match -->' . PHP_EOL;
            $o .= '        <hr class="clear-both">' . PHP_EOL;
//            $o .= '        <div class="cma-notebook-program-footer">' . PHP_EOL;
//            $o .= '          <p><img src="' . $preview_arrow . '" />Preview your program plan</p>' . PHP_EOL;
//            $o .= '        </div><!-- /cma-notebook-program-footer -->' . PHP_EOL;
            $o .= '      </div><!-- /cma-notebook-program-inner -->' . PHP_EOL;
            $o .= '    </div><!-- /cma-notebook-program -->' . PHP_EOL;
        }
    }else{
		$o .='<br /><br />';
    	$o .='<div><b>You have not saved any Programs</b></div>';
    }
    $o .= '  </div>' . PHP_EOL;
    $o .= '</div>' . PHP_EOL;
    return $o;
}

function theme_vcn_cma_notebook_vhs($cma) {

    $base_path = base_path();

    $target_program_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/target.png';
    $target_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';

    $o  = '<div id="vcn-cma-notebook-vhs">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-notebook-vhs-inner">' . PHP_EOL;

        $itemrank = webserviceitemrank($cma->userid,'vhs');

//    error_log('what does myvhs look like here - myvhs: ' . print_r($cma->myvhs,TRUE));
    if (isset($cma->myvhs)) {
    	$count=0;
        foreach ($cma->myvhs as $vhs) {
        	$count++;
            $o .= '    <div id="vhs-' . str_replace('.', '-', $vhs['vhsid']) . '" class="cma-notebook-vhs">' . PHP_EOL;
            $o .= '      <div class="cma-notebook-vhs-inner">' . PHP_EOL;
            $o .= '        <div class="cma-notebook-vhs-header">' . PHP_EOL;
            $o .= '            <a href="' . $vhs['WEBADDR'];
            $o .= '" alt="link to details for ' . $vhs['INSTNM'] . '">' . $vhs['INSTNM'] . '</a>' . PHP_EOL;
        	if ($count==1 && $itemrank->data->notebookresults->item->itemrank == '1'){$o .= '<b>(This is the Targeted Program)</b>';}
            $o .= '</span>';
            $o .= '<span class="cma-notebook-vhs-stabbr">' . $vhs['STABBR'] . '</span>' . $PHP_EOL;
            /*$o .= '            <a class="vhs-target-button" href="' . $base_path . 'cma/notebook/target/vhs/' . $vhs['vhsid'];
            $o .= '"><img src="' . $target_program_button . '" title="Target" alt="Target" /></a>' . PHP_EOL;*/
            $o .= '            <a class="vhs-remove-button" href="' . $base_path . 'cma/notebook/remove/vhs/' . $vhs['vhsid'];
            $o .= '"><img src="' . $target_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= '        </div><!-- /cma-notebook-vhs-header -->' . PHP_EOL;
            $o .= '        <hr class="clear-both">' . PHP_EOL;
            $o .= '      </div><!-- /cma-notebook-vhs-inner -->' . PHP_EOL;
            $o .= '    </div><!-- /cma-notebook-vhs -->' . PHP_EOL;
        }
    }else{
    	$o .='<br /><br />';
    	$o .='<div><b>You have not saved any Virtual High School</b></div>';
    }
    $o .= '  </div>' . PHP_EOL;
    $o .= '</div>' . PHP_EOL;
    return $o;
}

function theme_vcn_cma_publication_list($cma)
{
     $base_path = base_path();

    $history_item_edit_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/edit.png';
    $history_item_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';


	$o  = '<div id="vcn-cma-publication-list">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-publication-list-inner">' . PHP_EOL;
    global $user;
	$userloggedin = $user->uid;
    if ($cma->publicationList && $userloggedin)
    {

    	foreach ($cma->publicationList->cma AS $list)
    	{
            $o .= '<a class="history-item-edit-button" href="' . $base_path . 'cma/history/publication/' . $list->userpublicationid;
            $o .= '/edit"><img src="' . $history_item_edit_button . '" title="Edit" alt="Edit" /></a>' . PHP_EOL;
            $o .= '<a class="history-item-remove-button" href="' . $base_path . 'cma/history/publication/' . $list->userpublicationid;
            $o .= '/delete"><img src="' . $history_item_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= 'Published Date:'.$list->publisheddate . '<br />';
            $o .= 'Publication Name: '. $list->publicationname . '<br />';
            $o .= 'Description:'.$list->publicationdescription . '<br />';
            $o .= '<hr />';
    	}
    }
    else
    {
    	$o .= 'No records found';
    }
	$o .= '  </div><!-- /vcn-cma-publication-list-inner -->' . PHP_EOL;
	$o .= '</div><!-- /vcn-cma-publication-list -->' . PHP_EOL;
	return $o;
}

function theme_vcn_cma_publication_add($form) {
    return drupal_render($form);
}

function theme_vcn_cma_publication_edit($form) {
    return drupal_render($form);
}

function theme_vcn_cma_publication_delete($form) {
    return drupal_render($form);
}

function theme_vcn_cma_certification_list($cma)
{
    $base_path = base_path();

    $history_item_edit_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/edit.png';
    $history_item_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';


	$o  = '<div id="vcn-cma-certification-list">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-certification-list-inner">' . PHP_EOL;
    global $user;
	$userloggedin = $user->uid;
    if ($cma->certificationList && $userloggedin)
    {

    	foreach ($cma->certificationList->cma AS $list)
    	{
            $o .= '<a class="history-item-edit-button" href="' . $base_path . 'cma/history/certification/' . $list->usercertid;
            $o .= '/edit"><img src="' . $history_item_edit_button . '" title="Edit" alt="Edit" /></a>' . PHP_EOL;
            $o .= '<a class="history-item-remove-button" href="' . $base_path . 'cma/history/certification/' . $list->usercertid;
            $o .= '/delete"><img src="' . $history_item_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= 'Obtained Date:'.$list->datecertificateobtained . '<br />';
            $o .= 'Certification Name: '. $list->certificatename . '<br />';
            $o .= 'Description:'.$list->certificatedescription . '<br />';
            $o .= '<hr />';
    	}
    }
    else
    {
    	$o .= 'No records found';
    }
	$o .= '  </div><!-- /vcn-cma-certification-list-inner -->' . PHP_EOL;
	$o .= '</div><!-- /vcn-cma-certification-list -->' . PHP_EOL;
	return $o;
}

function theme_vcn_cma_certification_add($form) {
    return drupal_render($form);
}

function theme_vcn_cma_certification_edit($form) {
    return drupal_render($form);
}

function theme_vcn_cma_certification_delete($form) {
    return drupal_render($form);
}

function theme_vcn_cma_association_list($cma)
{

    $base_path = base_path();

    $history_item_edit_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/edit.png';
    $history_item_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';

    $o  = '<div id="vcn-cma-association-list">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-association-list-inner">' . PHP_EOL;
    global $user;
	$userloggedin = $user->uid;
    if ($cma->associationList && $userloggedin)
    {
//        error_log('Association List: ' . print_r($cma->associationList,TRUE));
    	foreach ($cma->associationList->cma AS $list)
    	{
            $o .= '<a class="history-item-edit-button" href="' . $base_path . 'cma/history/association/' . $list->userassociationid;
            $o .= '/edit"><img src="' . $history_item_edit_button . '" title="Edit" alt="Edit" /></a>' . PHP_EOL;
            $o .= '<a class="history-item-remove-button" href="' . $base_path . 'cma/history/association/' . $list->userassociationid;
            $o .= '/delete"><img src="' . $history_item_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= 'Join Date:'.$list->joindate . '<br />';
            $o .= 'Association Name: '. $list->associationname . '<br />';
            $o .= 'Description:'.$list->description . '<br />';
            $o .= 'End Date:'.$list->enddate. '<br />';
            $o .= '<hr />';
    	}
    }
    else
    {
    	$o .= 'No records found';
    }
	$o .= '  </div><!-- /vcn-cma-association-list-inner -->' . PHP_EOL;
	$o .= '</div><!-- /vcn-cma-association-list -->' . PHP_EOL;
	return $o;
}

function theme_vcn_cma_association_add($form) {
    return drupal_render($form);
}

function theme_vcn_cma_association_edit($form) {
    return drupal_render($form);
}

function theme_vcn_cma_association_delete($form) {
    return drupal_render($form);
}

function theme_vcn_cma_education_list($cma)
{

    $base_path = base_path();

    $history_item_edit_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/edit.png';
    $history_item_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';

	$o  = '<div id="vcn-cma-education-list">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-education-list-inner">' . PHP_EOL;
    global $user;
	$userloggedin = $user->uid;
    if ($cma->educationList && $userloggedin)
    {

    	foreach ($cma->educationList->cma AS $list)
    	{
            $o .= '<a class="history-item-edit-button" href="' . $base_path . 'cma/history/education/' . $list->educationid;
            $o .= '/edit"><img src="' . $history_item_edit_button . '" title="Edit" alt="Edit" /></a>' . PHP_EOL;
            $o .= '<a class="history-item-remove-button" href="' . $base_path . 'cma/history/education/' . $list->educationid;
            $o .= '/delete"><img src="' . $history_item_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= 'Year Graduated:' . $list->yeargraduated . '<br />';
            $o .= 'School Name: ' . $list->institutionname . '<br />';
            $o .= 'Major:' . $list->majordesc . '<br />';
            $o .= 'Years Attended:' . $list->yearsattended . '<br />';
            $o .= '<hr />';
    	}
    }
    else
    {
    	$o .= 'No records found';
    }
	$o .= '  </div><!-- /vcn-cma-education-list-inner -->' . PHP_EOL;
	$o .= '</div><!-- /vcn-cma-education-list -->' . PHP_EOL;
	return $o;
}

function theme_vcn_cma_education_add($form) {
    return drupal_render($form);
}

function theme_vcn_cma_education_edit($form) {
    return drupal_render($form);
}

function theme_vcn_cma_education_delete($form) {
    return drupal_render($form);
}

function theme_vcn_cma_employment_list($cma)
{
    $base_path = base_path();

    $history_item_edit_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/edit.png';
    $history_item_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';

    $o  = '<div id="vcn-cma-employment-list">' . PHP_EOL;
    $o .= '  <div id="vcn-cma-employment-list-inner">' . PHP_EOL;
    global $user;
	$userloggedin = $user->uid;
    if ($cma->employmentList && $userloggedin)
    {
    	foreach ($cma->employmentList->cma AS $list)
    	{
//            error_log("List: " . print_r($list,TRUE));
            $o .= '<a class="history-item-edit-button" href="' . $base_path . 'cma/history/employment/' . $list->useremploymentid;
            $o .= '/edit"><img src="' . $history_item_edit_button . '" title="Edit" alt="Edit" /></a>' . PHP_EOL;
            $o .= '<a class="history-item-remove-button" href="' . $base_path . 'cma/history/employment/' . $list->useremploymentid;
            $o .= '/delete"><img src="' . $history_item_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
            $o .= 'Employer Name: '. $list->employername . '<br />';
            $o .= 'Job Title:'.$list->jobtitle. '<br />';
            $o .= 'Start Date:'.$list->startdate. '<br />';
            $endDate = (empty($list->enddate)) ? 'Present' : $list->enddate;
            $o .= 'End Date: ' . $endDate . '<br />';
            $o .= '<hr />';
    	}
    }
    else
    {
    	$o .= 'No records found';
    }
	$o .= '  </div><!-- /vcn-cma-employment-list-inner -->' . PHP_EOL;
	$o .= '</div><!-- /vcn-cma-employment-list -->' . PHP_EOL;
	return $o;
}

function theme_vcn_cma_employment_add($form) {
    return drupal_render($form);
}

function theme_vcn_cma_employment_edit($form) {
    return drupal_render($form);
}

function theme_vcn_cma_employment_delete($form) {
    return drupal_render($form);
}