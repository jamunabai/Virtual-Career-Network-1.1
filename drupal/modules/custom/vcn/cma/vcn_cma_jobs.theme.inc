<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_jobs.js');


// $Id: vcn_cma.jobs.theme.inc,v 0.1 2011/01/09 10:07:00 Exp $

//include("header.php");
function theme_vcn_cma_jobs_view($cma) {


$cma = vcnCma::getInstance();

$vars['user_id']=$cma->userid;
$valid['user_id']='valid';
$base_path = base_path();
$target_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';
$cma_jobs_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/jobs_button_cma.png';

$joblist =  vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'CmaUserJobScout', 'list', $limit=false, $offset=false, $order='job_scout_id', $direction='desc'); 
			$o .= '<h4>Job Scouts</h4>';
			//$o .= 'This Jobs Section lists the job criteria that is saved by you. ';
			$o .= 'The Job Scouts allow you to save your search criteria from the Find a Job page.  The VCN will use this saved criteria to email you once a week, per Job Search Title, with matching jobs.  The checkboxes to the left of the Job Search Title indicate whether you will receive an email for that Job Scout.';
			$o .= ' <hr style="margin-bottom:13px;" class="clear-both">' . PHP_EOL;
			$o .= '<div class="cma-jobs-jobs"> <b> Job Search Title </b> </div>';
			$o .= '<div class="cma-jobs-zip-heading"> <b> Zipcode </b> </div>';
			$o .= '<div class="cma-jobs-distance-heading"> <b> Distance </b> </div>';
			$o .= '<div class="cma-jobs-date-heading"> <b> Date Saved </b> </div>';
			//$o .= '<div style="margin-top:-27px;" class="job-remove-button"> <b> Remove Button </b> </div>';
            $o .= ' <hr class="clear-both">' . PHP_EOL;
			
			
foreach ($joblist->cma as $job) {

		 $onlydate = explode(' ', $job->createdtime);
		 $datediv = '<div class="cma-jobs-date">'.$onlydate[0].'</div>';
		 if(empty($job->zip)){
			$zipdiv  = '<div class="cma-jobs-zip">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--</div>';
		 }else{
			$zipdiv  = '<div class="cma-jobs-zip">'.$job->zip.'</div>';
		 }
		 $disatnce = '<div class="cma-jobs-distance">'.$job->distance.' miles'.'</div>';
		 //print_r($datediv);exit;
            $o .= '	<div id="jobid-' . $job->jobscoutid . '" class="cma-jobs">' . PHP_EOL;
            $o .= '		<div class="cma-jobs-inner">' . PHP_EOL;
            $o .= '			<div class="cma-jobs-body">' . PHP_EOL;
			///print_r($job); exit;
	$activeynn = "'".$job->activeyn."'";
			//$o .= '<div class="cma-jobs-jobs">';
	if($job->activeyn == "y" || $job->activeyn == "Y" ){
		$checked = 'checked="checked" ';
		$o .= '<input type="checkbox" title="Unsubscribe for email list" alt="Unsubscribe for email list" name="active_yn" id="active_yn" '.$checked.' onclick="activeyntoggle('.$job->jobscoutid.','.$activeynn.');" ';		
	}else{
		$checked = '';
		$o .= '<input type="checkbox" title="Subscribe for email list" alt="Subscribe for email list" name="active_yn" id="active_yn" '.$checked.' onclick="activeyntoggle('.$job->jobscoutid.','.$activeynn.');" ';
	}
	$o .= '</input>';
	if(empty($job->keyword)){
		$vars['onetcode'] = $job->onetcode;
		$valid['onetcode']='valid';
		$joblistonetcode = vcn_get_data ($errors, $vars, $valid, 'occupationsvc', 'occupation', 'list', $limit=false, $offset=false);
		//$o .= 'Healthcare Careers:'.'<a class="cma-jobs-jobs" href="'.base_path().'findworkresults?onetcode='.$job->onetcode.'&distance='.$job->distance.'">'.$joblistonetcode->occupation->displaytitle.'</a>';
		$o .= ' Healthcare Careers: '.$joblistonetcode->occupation->displaytitle;
	}
	if(!empty($job->keyword)){
	$o .=' Job Title: ';
	}
	//$o .= '<a class="cma-jobs-jobs" href="'.base_path().'findworkresults?jobtitle2='.$job->keyword.'&distance='.$job->distance.'">'.$job->keyword.'</a>'.$zipdiv.$disatnce.$datediv.'<br />';
	if(!empty($job->keyword)){
	$o .= $job->keyword;
	}
	//$o .= '</div> <!-- end of cma-jobs-jobs -->';	
	$o .= $zipdiv.$disatnce.$datediv.'<br />';
	//print_r($job);exit; 

	
            $o .= '<a class="job-remove-button remove-button" jobid = "'.$job->jobscoutid.'" href="' . $base_path . 'cma/remove/jobs/' . $job->jobscoutid;
            $o .= '"><img src="' .$target_remove_button . '" title="Delete Job Scout" alt="Delete Job Scout" /></a>' . PHP_EOL;	
 	if(empty($job->keyword)){
		$vars['onetcode'] = $job->onetcode;
		$valid['onetcode']='valid';
		
		$joblistonetcode = vcn_get_data ($errors, $vars, $valid, 'occupationsvc', 'occupation', 'list', $limit=false, $offset=false);
		$o .= '<a style="margin-right: 10px;" class="job-navigate-button" href="'.base_path().'findworkresults?onetcode='.$job->onetcode.'&onetcode2='.$job->onetcode.'&zipcode='.$job->zip.'&distance='.$job->distance.'">'.'<img src="' .$cma_jobs_button . '" title="View Jobs" alt="View Jobs" />'.'</a>';
	}else{
		$search  = array('"', "'");
		$replace = '';
		$jobtitleclean = str_replace($search, $replace, $job->keyword);
		$o .= '<a style="margin-right: 10px;" class="job-navigate-button" href="'.base_path().'findworkresults?jobtitle2='.$jobtitleclean.'&onetcode2='.$job->onetcode.'&zipcode='.$job->zip.'&distance='.$job->distance.'">'.'<img src="' .$cma_jobs_button . '" title="View Jobs" alt="View Jobs" />'.'</a>';
	} 			


            $o .= '			</div><!-- /cma-notebook-jobs-body -->' . PHP_EOL;
            $o .= ' <hr class="clear-both">' . PHP_EOL;
            $o .= '		</div><!-- /cma-jobs-inner -->' . PHP_EOL;
            $o .= '	</div><!-- /cma-jobs -->' . PHP_EOL;
}
    return $o;

  
  
} 


function theme_vcn_cma_jobs_delete($form) {
    return drupal_render($form);
}
