<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
// $Id: vcn_cma.module, v 0.1 2011/02/02 10:23:00 hills Exp $

/**
 * @file
 * Support file for cma.module containing page type methods/functions.
 */


//$cp = './' . drupal_get_path('module','vcn_cma');

require_once('vcn_cma.class.inc');

/**
 * Base page for CMA
 *
 * Top level for CMA - defines tabs at top level
 *
 */
function cma_interface($section = NULL)
{
    //error_log('cma_interface - section: ' . $section);
  // If no section is specified we default to profile section.
  if (!isset($section)) {
    //drupal_goto('cma/profile');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/profile/view";
	header("Location: $location");	
  }

  $output = '';
  switch ($section) {
      case 'notebook'  : $output = cma_notebook();
                         break;
      case 'history'   : $output = cma_history();
                         break;
      case 'tools'     : $output = cma_tools();
                         break;
      case 'profile'   : $output = cma_profile();
                         break;
      case 'pla'       : $output = cma_pla();
                         break;
      case 'documents' : $output = cma_documents();
                         break;					
      case 'jobs' 	   :$output = cma_jobs();
                         break;		
      case 'tests' 	   :$output = cma_tests();
                         break;							 
      default          : $output = cma_profile();
                         break;
  }
  return $output;
}




//  Top level tabs defined next

/**
 * Page for CMA PLA
 *
 * PLA Tab defined above- sub tabs defined here
 *
 */
function cma_pla($section=NULL)
  {
  if(!isset($section)) {
	//drupal_goto('cma/pla/military');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/pla/military";
	header("Location: $location");	
}	
  switch($section)
    {
    case 'military':
      $output = cma_pla_military();
      break;
    case 'business':
      $output = cma_pla_business();
      break;
    case 'college':
      $output = cma_pla_college();
      break;
    case 'exams':
      $output = cma_pla_exams();
      break;
    default:
      $output = cma_pla_military();
      break;
    }
  return($output);
  }

/**
 * Page for CMA Profile
 *
 * Profile Tab defined - sub tabs defined here
 *
 */
function cma_profile($section = NULL)
{
    //error_log('cma_profile - section: ' . $section);
  // If no section is specified we default to view section.
  if (!isset($section)) {
    //drupal_goto('cma/profile/view');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/profile/view";
	header("Location: $location");		
  }

  $output = '';
  switch ($section) {
      case 'edit' : $output = cma_profile_edit();
                    break;
      case 'view' :
      default     : $output = cma_profile_view();
                    break;
  }
  return $output;
}

/**
 * Page for CMA Documents 
 *
 * Documents Tab defined - sub tabs defined here
 *
 */
function cma_documents($section = NULL)
{
    //error_log('cma_documents - section: ' . $section);
  // If no section is specified we default to view section.
  if (!isset($section)) {
    //drupal_goto('cma/documents/list');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/documents/list";
	header("Location: $location");	
  }

  $output = cma_documents_view();

  return $output;
}

/**
 * Page for CMA jobs 
 *
 * jobs Tab defined - sub tabs defined here
 *
 */
function cma_jobs($section = NULL)
{
    //error_log('cma_jobs - section: ' . $section);
  // If no section is specified we default to view section.
  if (!isset($section)) {
    //drupal_goto('cma/jobs/list');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/jobs/list";
	header("Location: $location");	
	
  }

  $output = cma_jobs_view();

  return $output;
}

/**
 * Page for CMA tests 
 *
 * tests Tab defined - sub tabs defined here
 *
 */
function cma_tests($section = NULL)
{
    //error_log('cma_jobs - section: ' . $section);
  // If no section is specified we default to view section.
  if (!isset($section)) {
    //drupal_goto('cma/tests/list');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/tests/list";
	header("Location: $location");	
  }

  $output = cma_tests_view();

  return $output;
}

/**
 * Page for CMA History
 *
 * History tab defined - subtabs defined here
 *
 */
function cma_history($section = NULL)
{
   // error_log('cma_history - section: ' . $section);
  // If no section is specified we default to view section.
  if (!isset($section)) {
    //drupal_goto('cma/history/association/list');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/history/association/list";
	header("Location: $location");	
  }

  $output = '';
  switch ($section) {
      case 'publication'    : $output = cma_history_publication();
                              break;
      case 'certification'  : $output = cma_history_certification();
                              break;
      case 'association'    : $output = cma_history_association();
                              break;
      case 'education'      : $output = cma_history_education();
                              break;
      case 'employment'     : $output = cma_history_employment();
                              break;
      default               : $output = cma_history_association();
                              break;
  }
  return $output;
}

/**
 * Page for CMA Notebook
 *
 * Notebook tab defined - sub tabs defined here
 *
 */
function cma_notebook($section = NULL)
{
    //error_log('cma_notebook - section: ' . $section);
  // If no section is specified we default to careers section.
  if (!isset($section)) {
    //drupal_goto('cma/notebook/careers');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/notebook/careers";
	header("Location: $location");	
  }

  $output = '';
  switch ($section) {
      case 'vhs'          : $output = cma_notebook_vhs();
                            break;
      case 'programs'     : $output = cma_notebook_programs();
                            break;
      case 'licenses'     : $output = cma_notebook_licenses();
                            break;
      case 'courses'      : $output = cma_notebook_courses();
                            break;
      case 'certificates' : $output = cma_notebook_certificates();
                            break;
      case 'communities' : $output = cma_notebook_communities();
                            break;						
      case 'careers'      :
      default             : $output = cma_notebook_careers();
                            break;
  }

  return $output;
}

/**
 * Page for CMA Tools
 *
 * Tools tab defined
 *
 */
function cma_tools($section = NULL)
{
//error_log('cma_tools - section: ' . $section);
// If no section is specified we default to careers section.

drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_share.js');

$cma = vcnCma::getInstance();
$userid = $cma->userid;
$vars['userid']=$cma->userid;
$valid['userid']='valid';
drupal_set_title('Career Management Account Tools');

	$o = '';
	$o  = '<div id="vcn-cma-tools">' . PHP_EOL;
	$o .= '<span><b>Share Your Portfolio</b></span><br /><br />';

	$o .= '<div  style="margin-left:40px;">If you would like someone to view information in your CMA you can easily share the information by choosing what you want to share and send the person a link to view the information. </div><br />';

	$o .= '<div  style="margin-left:40px;">'; // To shift the select information to be shared section 
	$o .= '<span><b>Select Information to be Shared</b></span>';
	
	$o .= '<div  style="margin-left:40px;">'; // end if condition for buttons and check box
//check box disalbed --> disabled=\"true\"	
//this is to enable disable the check box depending on the vlaue in the database


$myfile = base_path()."cma/tools";


//Vaues are being posted to saved in the database
if ($_POST['mydoccheck']=="Yes" || $_POST['mytestcheck']=="Yes") {
	if($_POST['mydoccheck']=="Yes"){
		$vars['share_type_id']="1";
		$valid['share_type_id']='valid';
		$shareinfo = vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'cmausershare', 'put', $limit=false, $offset=false, $order=false, $direction=false);
	}
		if($_POST['mytestcheck']=="Yes"){
		$vars['share_type_id']="2";
		$valid['share_type_id']='valid';
		$shareinfo = vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'cmausershare', 'put', $limit=false, $offset=false, $order=false, $direction=false);
	}	
}

$isdeletex = explode('/',$_SERVER['REQUEST_URI']);
$isdelete = '';
foreach($isdeletex as $k=>$v) {
	if ($isdeletex[$k]=='tools' && $isdeletex[$k+1]=='delete')
	$isdelete = 'true';
}
if(strlen($_POST['shareid1']) && !empty($_POST['shareid1'])){
	$vars['share_id']=$_POST['shareid1'];
	$valid['share_id']='valid';	
	$del1 = vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'cmausershare', 'delete', $limit=false, $offset=false, $order=false, $direction=false);
}

if(strlen($_POST['shareid2']) && !empty($_POST['shareid2'])){
	$vars['share_id']=$_POST['shareid2'];
	$valid['share_id']='valid';
	$del2 = vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'cmausershare', 'delete', $limit=false, $offset=false, $order=false, $direction=false);
}
$shareinfolist = vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'cmausershare', 'list', $limit=false, $offset=false, $order=false, $direction=false);
$s1 = $shareinfolist->cma[0]->shareid;
$s2 = $shareinfolist->cma[1]->shareid;

//this seciont is to determine what all has been shared by the user, $value will have either 1 or 2 depending upon doc share or test score share
$value = array();
foreach($shareinfolist->cma as $share) {
	$value[] = (int)$share->sharetypeid;
}

if ($s1 || $s2)
$isdelete = 1;

if($isdelete){
	$o .= "
	<span>
	<form method=\"POST\" action=\"$myfile\" >
	<input type=\"hidden\" name=\"cma\" value=\"$userid\" />
	<input type=\"hidden\" name=\"shareid1\" value=\"".$s1."\" />
	<input type=\"hidden\" name=\"shareid2\" value=\"".$s2."\" />
	<br>";
	if(in_array('1', $value)){ $enableddoc = "checked"; }
	if(in_array('2', $value)){ $enabledtest = "checked"; }
	$o .= "	  
	<input type=\"checkbox\" name=\"mydoccheck\" value=\"Yes\" $enableddoc disabled />My Documents
	<br><br>";

	$o .= "	  
	<input type=\"checkbox\" name=\"mytestcheck\" value=\"Yes\" $enabledtest disabled />My VCN Online Test Scores
	<br><br>";	  

	//RandNumber function generates random numbers for the url .. 
	function RandNumber($e){
		for($i=0;$i<$e;$i++){
			$rand =  $rand .  rand(0, 9); 
		}
		return $rand;
	}

	$randno1 = RandNumber(4);
	$randno2 = RandNumber(4);
	$randno3 = RandNumber(4);

	$o .= "<input type=\"image\" src=\"/healthcare/sites/default/files/images/buttons/stop_sharing.png\"  alt=\"Stop Sharing\" title=\"Stop Sharing\" /> ";

	global $user;
	$cma = vcnCma::getInstance();
	$url = "https://".$_SERVER['SERVER_NAME'].base_path()."share?userid=".$cma->userid."-$randno1-".$s1."-$randno2-".$s2."-$randno3";

	$o .= "</form>
	</span><br />
	<b> Your portfolio is currently being shared here: </b> <a href = \" $url \" > $url </a> <br /><br /><br />
	";	
}else{  
	$myfile2=$myfile.'/delete';  

	$o .= "
	<span>
	<form method=\"POST\" action=\"$myfile2\" >
	<input type=\"hidden\" name=\"cma\" value=\"$userid\" />
	<br>";

	$o .= "	  
	<input type=\"checkbox\" name=\"mydoccheck\" id=\"mydoccheck\" value=\"Yes\" $enableddoc />My Documents
	<br><br>";

	$o .= "	  
	<input type=\"checkbox\" name=\"mytestcheck\" id=\"mytestcheck\" value=\"Yes\" $enabledtest />My VCN Online Test Scores
	<br><br>";	  

	$o .= " <input type=\"image\" src=\"/healthcare/sites/default/files/images/buttons/share_portfolio.png\" alt=\"Share Portfolio\" title=\"Share Portfolio\" onclick= \"return checkForTheCondition();\" /> ";

	$o .= "</form>
	</span><br /><br />";	
}
    $o .= '</div>'; // end if condition for buttons and check box
	$o .= '</div>'; // end  select information to be shared section 	
	
	$o .= '<span><b>Guide to Build resume </b> <br />
	<p style="margin-left:40px;">Ready to create a brand-new resume? Need to update your old resume? <br/>
	<b>CareerOneStop\'s</b> <a href=javascript:popit("http://www.careeronestop.org/ResumeGuide/Introduction.aspx")>Resume Guide</a> will help you create a resume that will stand out in today\'s job market.
	</p></span>' . PHP_EOL;  
	$o .= '<span><b>Tips for Cover Letter</b> <br />
	<p style="margin-left:40px;">Like to add a cover letter to your job application? <br />
	<b>CareerOneStop\'s</b>  <a href=javascript:popit("http://www.careeronestop.org/ResumesInterviews/Letters/CoverLetters.aspx?ES=Y&EST=cover+letter")>Cover letter</a> will help you create a cover letter that will increase the value of your resume.
	</p></span><br />' . PHP_EOL;

	$o .= '<span><i><b>Note:</b> After creating the Resume and/or Cover Letter please use the <b>Documents</b> tab if you wish to upload and save the file for later use.</i></span>' . PHP_EOL; 


	$o .= '</div>' . PHP_EOL;

return $o;
}



//  Profile Sub Tabs


/**
 * cma profile view
 */
function cma_profile_view()
{
    //error_log('cma_profile_view');
  $cma = vcnCma::getInstance();
  global $user;

  drupal_set_title('View Career Management Account Profile');
  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_profile_view', $cma);
  //To make sure that only authenticated user can access the cma profile page
  if($user->uid){
  return $cma_themed;
  }else{
  	drupal_access_denied();
  }
}

/**
 * cma profile edit
 */
function cma_profile_edit() {
	global $user;
    drupal_set_title('Edit Career Management Account Profile');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_profile.forms');
	if($user->uid){
    return drupal_get_form('cma_profile_form');
	}else{
		drupal_access_denied();
	}
}


/**
 * cma Documents view
 */
function cma_documents_view()
{
    //error_log('cma_documents_view');
  $cma = vcnCma::getInstance();
  global $user;
  
  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_documents.css');
  drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_documents.js');

  drupal_set_title('View Career Management Documents');
  module_load_include('inc', 'vcn_cma', 'vcn_cma_documents.theme');
  $cma_themed = theme('vcn_cma_documents_view', $cma);
  
  if($user->uid){
	return $cma_themed;
  }else{
	drupal_access_denied();
  }  
}


/**
 * cma Jobs view 
 */
function cma_jobs_view()
{
    //error_log('cma_jobs_view');
  $cma = vcnCma::getInstance();
  global $user;
  
  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_jobs.css');
  drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_jobs.js');

  drupal_set_title('View Career Management Jobs');
  module_load_include('inc', 'vcn_cma', 'vcn_cma_jobs.theme');
  $cma_themed = theme('vcn_cma_jobs_view', $cma);
  
  
  if($user->uid){
	return $cma_themed;
  }else{
	drupal_access_denied();
  }
  
}

/**
 * cma Tests view
 */
function cma_tests_view()
{
    //error_log('cma_jobs_view');
  $cma = vcnCma::getInstance();
  global $user;
  
  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_tests.css');
  drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_tests.js');

  drupal_set_title('View Career Management Tests');
  module_load_include('inc', 'vcn_cma', 'vcn_cma_tests.theme');
  $cma_themed = theme('vcn_cma_tests_view', $cma);
  
  if($user->uid){
	return $cma_themed;
  }else{
	drupal_access_denied();
  } 
}


/**
 * cma Documents edit
 */
function cma_documents_edit() {
    drupal_set_title('Edit Career Management Account Documents');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_documents.forms');
    return drupal_get_form('cma_documents_form');
}

// Notebook Sub Tabs 

/**
 * cma notebook careers 
 */
function cma_notebook_careers()
{
  $cma = vcnCma::getInstance();

//  $output = $cma->getNotebookCareers();
  $output = $cma->getNotebookItems('career');

global $user;
$logged_in = $user->uid;
if($logged_in){
  drupal_set_title('Career Management Account Careers');}
else{
drupal_set_title('Wish List ');}
  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_careers.css');
  drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_careers.js');

  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_notebook_careers', $cma);

  return $cma_themed;
}

/**
 * cma notebook communities 
 */
function cma_notebook_communities(){
  //$cma = vcnCma::getInstance();

//  $output = $cma->getNotebookCareers();
  //$output = $cma->getNotebookItems('Communities');

  drupal_set_title('Career Management Account Careers');
  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_communities.css');
  //drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_communities.js');

  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_notebook_communities');

  return $cma_themed;
}

/**
 * cma notebook certificates
 */
function cma_notebook_certificates()
{
  $cma = vcnCma::getInstance();

//  $output = $cma->getNotebookCertificates();
  $output = $cma->getNotebookItems('certificate');

global $user;
$logged_in = $user->uid;
if($logged_in){
  drupal_set_title('Career Management Account Certifications');}
else{
drupal_set_title('Wish List');}

  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_certificate.css');
  drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_certificate.js');

  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_notebook_certificates', $cma);

  return $cma_themed;
}

/**
 * cma notebook courses
 */
function cma_notebook_courses()
{
  $cma = vcnCma::getInstance();

//  $output = $cma->getNotebookCourses();
  $output = $cma->getNotebookItems('course');

  global $user;
  $logged_in = $user->uid;
  if($logged_in){
	drupal_set_title('Career Management Account Courses');}
  else{
	drupal_set_title('Wish List');}

  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_courses.css');
  drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_courses.js');

  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_notebook_courses', $cma);

  if($user->uid){
	return $cma_themed;
  }else{
	drupal_access_denied();
  } 
}

/**
 * cma notebook licenses
 */
function cma_notebook_licenses()
{
  $cma = vcnCma::getInstance();

//  $output = $cma->getNotebookLicenses();
  $output = $cma->getNotebookItems('license');

  global $user;
$logged_in = $user->uid;
if($logged_in){
  drupal_set_title('Career Management Account Licenses');}
else{
drupal_set_title('Wish List');}

  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_licenses.css');
  drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_licenses.js');

  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_notebook_licenses', $cma);

  return $cma_themed;
}

/**
 * cma notebook programs
 */
function cma_notebook_programs()
{
  $cma = vcnCma::getInstance();

//  $output = $cma->getNotebookPrograms();
  $output = $cma->getNotebookItems('program');

  global $user;
$logged_in = $user->uid;
if($logged_in){
  drupal_set_title('Career Management Account Programs');}
else{
drupal_set_title('Wish List');}


  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_programs.css');
  drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_programs.js');

  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_notebook_programs', $cma);

  return $cma_themed;
}


/**
 * cma notebook vhs
 */
function cma_notebook_vhs()
{
  $cma = vcnCma::getInstance();

//  $output = $cma->getNotebookPrograms();
  $output = $cma->getNotebookItems('vhs');

global $user;
$logged_in = $user->uid;
if($logged_in){
  drupal_set_title('Career Management Account Virtual High Schools');}
else{
drupal_set_title('Wish List');}


  drupal_add_css(drupal_get_path('module', 'vcn_cma') . '/css/vcn_cma_nb_vhs.css');
  drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_vhs.js');

  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_notebook_vhs', $cma);

  return $cma_themed;
}

//  History Sub Tabs

/**
 * Page for CMA History/Publications
 *
 * History/Publications sub tab defined - subtabs defined here
 *
 */
function cma_history_publication($section = NULL, $rec_id = NULL)
{
  // If no section is specified we default to view section.
  if (!isset($section)) {
    //drupal_goto('cma/history/publication/list');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/history/publication/list";
	header("Location: $location");		
  }

  $output = '';
  switch ($section) {
      case 'add'    : $output = cma_publication_add();
                      break;
      case 'edit'   : $output = cma_publication_edit($rec_id);
                      break;
      case 'delete' : $output = cma_publication_delete($rec_id);
                      break;
      case 'list'   :
      default       : $output = cma_publication_list();
                      break;
  }

  return $output;
}

/**
 * cma history/publications list
 */
function cma_publication_list()
{

  $cma = vcnCma::getInstance();
  $output = $cma->getHistoryItemsList('publication');

  drupal_set_title('List Career Management Account Publications History');
  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_publication_list', $cma);

  return $cma_themed;
}

/**
 * cma history/publication/add
 */
function cma_publication_add() {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Add Career Management Account Publication Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_publication.forms');
    return drupal_get_form('cma_publication_form');
}

/**
 * cma history/publication/edit
 */
function cma_publication_edit($rec_id) {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Edit Career Management Account Publication Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_publication.forms');
    return drupal_get_form('cma_publication_form',array('id' => $rec_id, 'mode' => 'E'));
}

/**
 * cma history/publication/delete
 */
function cma_publication_delete($rec_id) {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Delete this Career Management Account Publication Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_publication.forms');
    return drupal_get_form('cma_publication_form',array('id' => $rec_id, 'mode' => 'D'));
}

/**
 * Page for CMA History/Certifications
 *
 * History/Certifications sub tab defined - subtabs defined here
 *
 */
function cma_history_certification($section = NULL, $rec_id = NULL)
{
  // If no section is specified we default to view section.
  if (!isset($section)) {
    //drupal_goto('cma/history/certification/list');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/history/certification/list";
	header("Location: $location");		
  }

  $output = '';
  switch ($section) {
      case 'add'  : $output = cma_certification_add();
                    break;
      case 'edit'   : $output = cma_certification_edit($rec_id);
                      break;
      case 'delete' : $output = cma_certification_delete($rec_id);
                      break;
      case 'list' :
      default     : $output = cma_certification_list();
                    break;
  }

  return $output;
}

/**
 * cma history/certifications list
 */
function cma_certification_list()
{

  $cma = vcnCma::getInstance();
  $output = $cma->getHistoryItemsList('certification');

  drupal_set_title('List Career Management Account Certifications History');
  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_certification_list', $cma);

  return $cma_themed;
}

/**
 * cma history/certification/add
 */
function cma_certification_add() {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Add Career Management Account Certification Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_certification.forms');
    return drupal_get_form('cma_certification_form');
}

/**
 * cma history/certification/%/edit
 */
function cma_certification_edit($rec_id) {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Edit Career Management Account Certification Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_certification.forms');
    return drupal_get_form('cma_certification_form',array('id' => $rec_id, 'mode' => 'E'));
}

/**
 * cma history/certification/%/delete
 */
function cma_certification_delete($rec_id) {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Delete this Career Management Account Certification Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_certification.forms');
    return drupal_get_form('cma_certification_form',array('id' => $rec_id, 'mode' => 'D'));
}

/**
 * Page for CMA History/Memberships
 *
 * History/Memberships sub tab defined - subtabs defined here
 *
 */
function cma_history_association($section = NULL, $rec_id = NULL)
{
 // error_log('History Assoc. - section: ' . $section . ' : rec_id: ' . $rec_id);
  if (!isset($section)) {
    //drupal_goto('cma/history/association/list');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/history/association/list";
	header("Location: $location");	
  }

  $output = '';
  switch ($section) {
      case 'add'  : $output = cma_association_add();
                    break;
      case 'edit'   : $output = cma_association_edit($rec_id);
                      break;
      case 'delete' : $output = cma_association_delete($rec_id);
                      break;
      case 'list' :
      default     : $output = cma_association_list();
                    break;
  }

  return $output;
}

/**
 * cma history/associations list
 */
function cma_association_list()
{
  global $user;
  $cma = vcnCma::getInstance();
  $output = $cma->getHistoryItemsList('association');

  drupal_set_title('List Career Management Account Association History');
  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_association_list', $cma);

  if($user->uid){
	return $cma_themed;
  }else{
	drupal_access_denied();
  } 
}

/**
 * cma history/association/add
 */
function cma_association_add() {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Add Career Management Account Association Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_association.forms');
    return drupal_get_form('cma_association_form');
}

/**
 * cma history/association/%/edit
 */
function cma_association_edit($rec_id) {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Edit Career Management Account Association Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_association.forms');
    return drupal_get_form('cma_association_form',array('id' => $rec_id, 'mode' => 'E'));
}

/**
 * cma history/association/%/delete
 */
function cma_association_delete($rec_id) {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Delete this Career Management Account Association Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_association.forms');
    return drupal_get_form('cma_association_form',array('id' => $rec_id, 'mode' => 'D'));
}

/**
 * Page for CMA History/Education
 *
 * History/Education sub tab defined - subtabs defined here
 *
 */
function cma_history_education($section = NULL, $rec_id = NULL)
{
  // If no section is specified we default to view section.
  if (!isset($section)) {
    //drupal_goto('cma/history/education/list');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/history/education/list";
	header("Location: $location");		
  }

  $output = '';
  switch ($section) {
      case 'add'  : $output = cma_education_add();
                    break;
      case 'edit'   : $output = cma_education_edit($rec_id);
                      break;
      case 'delete' : $output = cma_education_delete($rec_id);
                      break;
      case 'list' :
      default     : $output = cma_education_list();
                    break;
  }

  return $output;
}

/**
 * cma history/education list
 */
function cma_education_list()
{

  $cma = vcnCma::getInstance();
  $output = $cma->getHistoryItemsList('education');

  drupal_set_title('List Career Management Account Education History');
  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_education_list', $cma);

  return $cma_themed;
}

/**
 * cma history/education/add
 */
function cma_education_add() {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Add Career Management Account Education Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_education.forms');
    return drupal_get_form('cma_education_form');
}

/**
 * cma history/education/%/edit
 */
function cma_education_edit($rec_id) {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Edit Career Management Account Education Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_education.forms');
    return drupal_get_form('cma_education_form',array('id' => $rec_id, 'mode' => 'E'));
}

/**
 * cma history/education/%/delete
 */
function cma_education_delete($rec_id) {
/*	print_r($_POST);
	exit();*/
    drupal_set_title('Delete this Career Management Account Education Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_education.forms');
    return drupal_get_form('cma_education_form',array('id' => $rec_id, 'mode' => 'D'));
}

function cma_history_employment($section = NULL, $rec_id = NULL)
{
  // If no section is specified we default to view section.
  if (!isset($section)) {
    //drupal_goto('cma/history/employment/list');
	$location = "https://".$_SERVER['SERVER_NAME'].base_path()."cma/history/employment/list";
	header("Location: $location");		
  }

  $output = '';
  switch ($section) {
      case 'add'  : $output = cma_employment_add();
                    break;
      case 'edit'   : $output = cma_employment_edit($rec_id);
                      break;
      case 'delete' : $output = cma_employment_delete($rec_id);
                      break;
      case 'list' :
      default     : $output = cma_employment_list();
                    break;
  }
  return $output;
}

/**
 * cma history/employment list
 */
function cma_employment_list()
{

  $cma = vcnCma::getInstance();
  $output = $cma->getHistoryItemsList('employment');

  drupal_set_title('List Career Management Account Employment History');
  module_load_include('inc', 'vcn_cma', 'vcn_cma.theme');
  $cma_themed = theme('vcn_cma_employment_list', $cma);

  return $cma_themed;
}

/**
 * cma history/employment/add
 */
function cma_employment_add() {
    drupal_set_title('Add Career Management Account Employment Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_employment.forms');
    return drupal_get_form('cma_employment_form');
}

/**
 * cma history/employment/%/edit
 */
function cma_employment_edit($rec_id) {
    drupal_set_title('Edit Career Management Account Employment Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_employment.forms');
    return drupal_get_form('cma_employment_form',array('id' => $rec_id, 'mode' => 'E'));
}

/**
 * cma history/employment/%/delete
 */
function cma_employment_delete($rec_id) {
    drupal_set_title('Delete this Career Management Account Employment Record');
    module_load_include('inc', 'vcn_cma', 'vcn_cma_employment.forms');
    return drupal_get_form('cma_employment_form',array('id' => $rec_id, 'mode' => 'D'));
}

/**
 * cma pla/military
 */
function cma_pla_military()
  {
  drupal_set_title('Military Training Title');
  $includePath=$_SERVER['DOCUMENT_ROOT'].base_path().drupal_get_path('module','vcn_cma')."/vcn_cma_pla.theme.inc";
  include_once($includePath);
  $output .= displayMilitaryCourses();
  return($output);
  }// end function cma_pla_military()

/**
 * cma pla/business
 */
function cma_pla_business()
  {
  drupal_set_title('Business Training Title');
  $includePath=$_SERVER['DOCUMENT_ROOT'].base_path().drupal_get_path('module','vcn_cma')."/vcn_cma_pla.theme.inc";
  include_once($includePath);
  $output .= displayBusinessCourses();
  return($output);
  }// end function cma_pla_business()

/**
 * cma pla/exams
 */
function cma_pla_exams()
  {
  drupal_set_title('National Exams Title');
  $includePath=$_SERVER['DOCUMENT_ROOT'].base_path().drupal_get_path('module','vcn_cma')."/vcn_cma_pla.theme.inc";
  include_once($includePath);
  $output .= displayNationalExams();
  return($output);
  }// end function cma_pla_business()

/**
 * cma pla/college
 */
function cma_pla_college()
  {
  drupal_set_title('College Courses Title');
  $includePath=$_SERVER['DOCUMENT_ROOT'].base_path().drupal_get_path('module','vcn_cma')."/vcn_cma_pla.theme.inc";
  include_once($includePath);
  $output .= displayCollegeCourses();
  return($output);
  }// end function cma_pla_business()
