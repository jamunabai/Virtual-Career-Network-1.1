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
$explodetheurl = explode('/',$_SERVER['REQUEST_URI']);

$setvalue = 0;

if(!empty($explodetheurl[6]) && !empty($explodetheurl[8])){

		$setvalue = 1;

		$vars['onetcode']=$explodetheurl[10];
		$vars['cipcode']=$explodetheurl[8];
		$vars['program_id']=$explodetheurl[6];
		
		$valid['onetcode']='valid';
		$valid['cipcode']='valid';
		$valid['program_id']='valid';

		$allprograms = vcn_get_data ($errors, $vars, $valid, 'trainingsvc', 'programs', 'list') ;
}

// This condition is to make sure that the editable program page can be accessed only by the provider rest other users should get a access denied message
// And for the provider FAQ page the condition has been included in drupal admin page 

/*if((empty($user->uid) && empty($explodetheurl[6])) || (empty($user->profile_provider_id) && empty($explodetheurl[6])) || (empty($allprograms->programs) && $setvalue == 1 && $_GET["modify"] != 1)){

//drupal_access_denied();
	drupal_set_title(t('Access denied'));
	echo 'You are not authorized to access this page.';

}else{ */// else condition for if((empty($user->uid) && empty($explodetheurl[6])) || (empty($user->profile_provider_id) && empty($explodetheurl[6])))


//print_r($user);


$programdetails = $data['programdetails'];
$programreqcourses = $data['programreqcourses'];
$programreqeducation = $data['programreqeducation'];
$programentrancetests = $data['programentrancetests'];
$programaccredited = $data['programaccredited'];
$providerdetails = $data['providerdetails'];
$providerreqcourses = $data['providerreqcourses'];
$providerentrancetests = $data['providerentrancetests'];

global $base_url;

if (isset($user->profile_provider_id) && strlen($user->profile_provider_id)>0) { 
	if (($user->profile_provider_id === $providerdetails->unitid || !empty($user->profile_provider_id)) && $_SESSION['provider'] == 1) {
		$whovar="p";
	}
}

$programStatus = $programdetails->status;
if ($whovar=="p" && $_GET["modify"]) {
	$programid = $programdetails->programid;
	if(empty($programdetails->programid)){
		$programid = "NEW PROGRAM";
	}
	$body .= '<br/><strong>Submitted By User:</strong> '. $user->name . ' &#160;&#160; ' . $user->mail . ' &#160;&#160; (' . $user->uid . ')' . "\r\n";
	$body .= '<br/><strong>Program Status:</strong> '.$_POST['statusvalue'].'<br/><br/>' . "\r\n";
	$body .= '<strong style="text-decoration:underline;">Program Information:</strong><br/>' . "\r\n";
	$body .= '<strong>Provider Id: </strong> '.$providerdetails->unitid.'<br/>' . "\r\n";
	$body .= '<strong>Program Id: </strong> '.$programid.'<br/>' . "\r\n";
	$body .= '<strong>Program Name:</strong> '.$_POST['programname'].'<br/>' . "\r\n";
	$body .= '<strong>Award Level:</strong> '.$_POST['ipedsdesc'].'<br/>' . "\r\n";
	$body .= '<strong>Program Length:</strong> '.$_POST['programlength'].'<br/>' . "\r\n";
	$body .= '<strong>Program URL:</strong> '.$_POST['programurl'].'<br/>' . "\r\n";
	$body .= '<strong>Program Description:</strong> '.$_POST['programdescription'].'<br/>' . "\r\n";
	$body .= '<strong>Program Contact Name:</strong> '.$_POST['programcontactname'].'<br/>' . "\r\n";
	$body .= '<strong>Program Contact Email:</strong> '.$_POST['programcontactemail'].'<br/>' . "\r\n";
	$body .= '<strong>Program Contact Phone:</strong> '.$_POST['programcontactphone'].'<br/>' . "\r\n";

	$tests = '';
	for ($i=1; $i<=10; $i++) {
		if (strlen($_POST['teststatus'.$i]) && (strlen($_POST['testname'.$i]) || strlen($_POST['testdesc'.$i]) || strlen($_POST['testminscore'.$i]))) {
			$tests .= '<strong>Status '.$i.':</strong> '.$_POST['teststatus'.$i].'<br/>' . "\r\n";
			$tests .= '<strong>Test Name '.$i.':</strong> '.$_POST['testname'.$i].'<br/>' . "\r\n";
			$tests .= '<strong>Test Description '.$i.':</strong> '.$_POST['testdesc'.$i].'<br/>' . "\r\n";
			$tests .= '<strong>Test Minimum Score '.$i.':</strong> '.$_POST['testminscore'.$i].'<br/><br/>' . "\r\n";
		}
	}
	if (strlen($tests)) {
		$body .= '<br/><strong style="text-decoration:underline;">Program Enrollment Test Requirements:</strong><br/>' . "\r\n";
		$body .= $tests;
	}

	$courses = '';
	for ($i=1; $i<=10; $i++) {
		if (strlen($_POST['coursestatus'.$i]) && (strlen($_POST['coursename'.$i]) || strlen($_POST['coursedesc'.$i]) || strlen($_POST['courselevel'.$i]) || strlen($_POST['coursemingpa'.$i]) )) {
			$courses .= '<strong>Status '.$i.':</strong> '.$_POST['coursestatus'.$i].'<br/>' . "\r\n";
			$courses .= '<strong>Course Name '.$i.':</strong> '.$_POST['coursename'.$i].'<br/>' . "\r\n";
			$courses .= '<strong>Course Description '.$i.':</strong> '.$_POST['coursedesc'.$i].'<br/>' . "\r\n";
			$courses .= '<strong>Course Level '.$i.':</strong> '.$_POST['courselevel'.$i].'<br/>' . "\r\n";
			$courses .= '<strong>Course Minimum GPA '.$i.':</strong> '.$_POST['coursemingpa'.$i].'<br/><br/>' . "\r\n";
		}
	}
	if (strlen($courses)) {
		$body .= '<br/><strong style="text-decoration:underline;">Prerequsite Courses for Enrollment in Program:</strong><br/>' . "\r\n";
		$body .= $courses;
	}
	$body .= '<br/><br/>';

	$params = array(
		'subject' => 'VCN Program Changes',
		'body' => $body,
	);

	//connect directly to db
	$conn = vcn_connect_to_db();

	// Here, we are loading up the questions for the assessment
	$query = " SELECT   *
               FROM     vcn_app_properties
               WHERE    NAME = \"provider_portal_email\" ";
	$result = mysql_query($query) or die("Error running query: ".mysql_error());
	$row = mysql_fetch_assoc($result);
	
	$email = $row['VALUE'];
	
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$header .= "From: $user->mail \r\n";
	$header .= "Reply-To: $user->mail \r\n";
	
	if (strlen($email) > 0) {
		mail( $email, 'VCN Program Changes', $body, $header );
		
		/**
		**Begin : Provider Registration and Updates to Profile/Program Should be Logged redmine : 6875
		**/
	
		$date = date_create();
		$datestamp = date_timestamp_get($date);
		
		$providerid = $user->profile_provider_id;
		$userid = $user->uid;
		
		$bodylog = $body;
		
		if($_SERVER['SERVER_NAME'] == "localhost"){
			$myFile = "../careerladder/AppLogs/"."provider-".$providerid."--user-".$userid."-program-".$datestamp.".txt";
		}else{
			$myFile = "/usr/local/zend/apache2/htdocs/careerladder/AppLogs/"."provider-".$providerid."--user-".$userid."-program-".$datestamp.".txt";
		}
		//$myFile = "http://hvcp2-dev-portal.hvcp.local/careerladder/AppLogs/provider_registration.txt";
		$fh = fopen($myFile, 'a'); // or die("can't open file");
		$stringData = $bodylog;
		fwrite($fh, $stringData);
		fclose($fh);
		
		/**
		**End : Provider Registration and Updates to Profile/Program Should be Logged redmine : 6875
		**/
	
	}
	//echo $body;

	drupal_set_message(t("The information has been sent to the VCN staff for review."));
	
	// update the program status (UP=Update Pending, C=Confirmed, CP=Confirm Pending)
	// But only do this for programs that are already in the system not new ones
	if(!empty($programdetails->programid)){
		$programStatus = 'UP';
		if ($_POST['statusvalue'] == 'CONFIRMED') {
			$programStatus = 'C';
		}
		$query = " UPDATE vcn_program
					   SET status = '$programStatus', updated_by = $user->uid, updated_time = Now()
			           WHERE program_id = $programdetails->programid ";
		mysql_query($query) or die("Error running query: ".mysql_error());
	}
	
	vcn_disconnect_from_db($conn);
	
	// if a new program was added then redirect back to the blank entry page so they can add another if they want
	if(empty($programdetails->programid)){
		$redirecturl = $base_url.'/find-learning/detail/programs/program_id/';
		drupal_goto($redirecturl);
	}
}

function gettargettitle($onetcode) {

  $cp = dirname(dirname(drupal_get_path('module','occupations_detail')));

  require_once($cp . '/vcn.rest.inc');

  $rest = new vcnRest;
	

	$rest->setSecret('');
	$rest->setBaseurl(getBase());
	$rest->setService('occupationsvc');
	$rest->setModule('occupation');
	$rest->setAction('list');

	// standard filters
	$rest->setRequestKey('apikey','apikey');
	$rest->setRequestKey('format','xml');

	
  $rest->setRequestKey('onetcode',$onetcode);	


	$rest->setMethod('post');

	$content = $rest->call();

	$content = new SimpleXMLElement($content);


  return $content->data->occupation->displaytitle;

}

$basepath = base_path();
?>

<style>
.panel-2col { width:100%; }
.panel-col-first { width:100%; }
.training-detail-left { width: 406px; }
.training-detail-right { width: 212px; margin-left: 50px; }
.training-detail-details { width: 699px; }

.tablestyle { width:100%; border:none; }
.tablestyle th { width:50px; background-color: #189AB0; color:white; padding:6px; text-align:center; }

</style>
<script>

function hidedetails() {
	$(document).ready(function() {
		$('#training-detail-details').css("display","none");		
	});
}
$(document).ready(function() {
	$('.panel-col-first').css("width","100%");	
});
</script>

<?php 
$onetcode1 = $vars['onetcode']; 

$currentUrl = "http://" . $_SERVER['SERVER_NAME'] . base_path() . "find-learning/detail/programs/program_id/" . $programdetails->programid . "/cipcode/" . $programdetails->cipcode . "/onetcode/" . $onetcode1;
$facebookTitle = "VCN.org Program: " . $programdetails->programname;

$facebookMetatags = new vcnFacebookMetatag($facebookTitle, $currentUrl, $programdetails->programdescription);
drupal_set_html_head($facebookMetatags->getTags());
?>
<form id="training-form" name="trainingform" method="post" autocomplete="off"  action="javascript:void(0);" onsubmit="caction('1'); return filterTraining(this);" >
<label><input type="hidden" id="occupation-title-one" name="occupation-title-one" value="<?php echo gettargettitle($onetcode1); ?>" /></label>
</form>

<div id="training-detail" class="panel-2col panel-col-first" style="margin-top: -25px;">
	<div class="training-detail-details">
	
		<?php if (strstr($_SERVER['HTTP_REFERER'], 'find-learning/results/programs')): ?>
		<div class="back-to-results">
			<!--  a onclick="return backToResults('program_id');" href="<?php //echo base_path();?>find-learning/results">Back to results</a-->
	 	</div>
		<?php endif; ?>
		
		<h3>Program Details</h3>
		<br/>
		
		<?php 
		if ($whovar != "p" && !empty($programdetails->programid)) :
		
			echo '<div style="width:100%;">' . "\n";
			echo '	<div style="float:left; width:80%;">' . "\n";
			
			if (strlen($programdetails->programurl)>4) {
				echo '<span class="training-title"><strong><a target="_blank" href="' . $programdetails->programurl . '">' . $programdetails->programname . '</a></strong></span>';
			} else {
				echo '<span class="training-title"><strong style="text-decoration:underline;">' . $programdetails->programname . '</strong></span>';
			};
			
			echo '	</div>' . "\n";
			echo '	<div style="float:left; text-align:right; vertical-align:middle; width:20%;">' . "\n";
			
			$facebookLikeButton = new vcnFacebookLike($currentUrl);
			$facebookLikeButton->shiftTop = '0';
			$facebookLikeButton->shiftLeft = '0';
			echo $facebookLikeButton->getButton();
			
			echo '	</div>' . "\n";
			echo '	<div style="clear:left;"></div>' . "\n";
			echo '</div>' . "\n";
 
			echo '<p>' . $programdetails->programdescription . '</p>';
			
			echo '<a href="' . base_path() . 'find-learning/detail/school/unitid/' . $providerdetails->unitid .'" alt="' . $providerdetails->instnm . '" title="' . $providerdetails->instnm . '" >' . $providerdetails->instnm . '</a><br />';
	
			if ((string)$providerdetails->addr !== 'NULL'  AND trim((string)$providerdetails->addr) !== '' )  echo $providerdetails->addr.'<br />';
			if ((string)$providerdetails->city !== 'NULL'  AND trim((string)$providerdetails->city) !== '' ) echo $providerdetails->city;
			if ((string)$providerdetails->stabbr !== 'NULL' ) {
				if ((string)$providerdetails->city !== 'NULL' AND trim((string)$providerdetails->city) !== '' )  echo ', ';
				echo $providerdetails->stabbr;
			}
			if ((string)$providerdetails->zip !== 'NULL' AND trim((string)$providerdetails->zip) !== '' )  echo ' '. $providerdetails->zip;
			echo '<br />';
			if ((string)$providerdetails->gentele !== 'NULL' AND trim((string)$providerdetails->gentele) !== '' ) echo ' '. vcn_format_phone( $providerdetails->gentele ).'<br />';
			
			if (trim($programdetails->admissionurl)) {
				$appurl = substr_compare( 'http',(string)$programdetails->admissionurl,0,4,true) ? 'http://'. $programdetails->admissionurl : $programdetails->admissionurl;
				echo '<a target="_blank" href="'.$appurl.'">Admissions</a><br />';
			}
			if ((string)$providerdetails->faidurl !== 'NULL' AND trim((string)$providerdetails->faidurl) !== '') {
				$faidurl = substr_compare( 'http',(string)$providerdetails->faidurl,0,4,true) ? 'http://'. (string)$providerdetails->faidurl : (string)$providerdetails->faidurl;
				echo '<a target="_blank"  href="'.$faidurl.'">Financial Aid (For this school)</a><br />';
			}

			echo '<a href="'.base_path().'find-learning/financialaid">Financial Aid (General)</a><br />';
		
			if ((string)$programdetails->programurl !== 'NULL' AND trim((string)$programdetails->programurl) !== '') {
				$programurl = substr_compare( 'http',(string)$programdetails->programurl,0,4,true) ? 'http://'. (string)$programdetails->programurl : (string)$programdetails->programurl;
				echo '<a target="_blank"  href="'.$programurl.'">Program Website</a><br />';
			}
			echo '<br />';
			if ((string)$programdetails->programcontactname !== 'NULL' AND trim((string)$programdetails->programcontactname) !== '') {
				echo $programdetails->programcontactname . '<br />';
			}
			if ((string)$programdetails->programcontactemail !== 'NULL' AND trim((string)$programdetails->programcontactemail) !== '')
			{
				echo $programdetails->programcontactemail . '<br />';
			}
			if ((string)$programdetails->programcontactphone !== 'NULL' AND trim((string)$programdetails->programcontactphone) !== '')
			{
				echo $programdetails->programcontactphone . '<br />';
			}
			
			echo '<p>';
	       	echo '<strong>Award Level: </strong>';
	       	
			//if ((string)$programdetails->awlevel==1 || (string)$programdetails->awlevel==2 || (string)$programdetails->awlevel==4)
			//	$programdetails->ipedsdesc = 'Certificate';
	
			echo $programdetails->awdesc; 
			echo '</p>';
			
			echo '<p>';
			echo '<strong>Program Length: </strong>';

			$awlevel = (string)$programdetails->duration;
			echo $awlevel;
	        	
	   		echo '</p>';
	   		
			if ((string)$programdetails->totalcredits !== 'NULL' AND trim((string)$programdetails->totalcredits) !== '') {
		      	 echo '<p><strong>Total Credits: </strong>';
	       		 echo $programdetails->totalcredits .'</p>';
	      	 }
	      	 if ((string)$programdetails->totalcourses !== 'NULL' AND trim((string)$programdetails->totalcourses) !== '') {
		      	 echo '<p><strong>Total Courses: </strong>';
	       		 echo $programdetails->totalcourses .'</p>';
	      	 }
	    	 if ((string)$programdetails->tuitioninstate !== 'NULL' AND trim((string)$programdetails->tuitioninstate) !== '') {
		      	 echo '<p><strong>In-state Tuition: </strong>';
	       		 echo '$'.$programdetails->tuitioninstate .'</p>';
	      	 }
	    	 if ((string)$programdetails->tuitionoutstate !== 'NULL' AND trim((string)$programdetails->tuitionoutstate) !== '') {
		      	 echo '<p><strong>Out-of-state Tuition: </strong>';
	       		 echo '$'.$programdetails->tuitionoutstate .'</p>';
	      	 }
	       	 if ((string)$programdetails->othercost !== 'NULL' AND trim((string)$programdetails->othercost) !== '') {
		      	 echo '<p><strong>Other Cost: </strong>';
	       		 echo '$'.$programdetails->othercost .'</p>';
	      	 }
	      	 if ((array)$programaccredited) {
	      	 	if (count($programaccredited) > 0) {
	      	 		echo '<p><strong>Accredited By:</strong><br />';
	      	 		foreach ($programaccredited as $creditor) {
	      	 			echo $creditor . '<br/>';
	      	 		}
	      	 		echo '</p>';
	      	 	}
	      	 }
			
		 	if ($programdetails->otherrequirements) {
		 		echo '<h4>General Admission Requirements:</h4>';
		 		echo '<p>'.$programdetails->otherrequirements .'</p>';
		 	}
		 	
		 	if ($providerdetails->transferpolicy) {
		 		echo '<h4>Transfer Policy:</h4>';
		 		echo '<p>'.$providerdetails->transferpolicy;
		 		if ($providerdetails->mingpafortransfer)
		 		echo '<br /><strong>Minimum GPA for transfer: </strong>'.$providerdetails->mingpafortransfer;
		 		echo '</p>';
		 	}
		 	
		 	if ((array)$programreqeducation ) {
		 		$count = 0;
		 		if (count($programreqeducation) > 0) {
		 			foreach ($programreqeducation as $education) {
		 				if ((string)$education->name !== 'NULL' AND trim((string)$education->name  !== '') ) {
		 					$class = (++$count%2 == 0) ? 'odd' : 'even';
		 					echo '<tr class="'.$class.'">';
		 					echo '<td class="td-education">' . $education->name  . '</td>';
		 	
		 					if ((string)$education->mingpa !== 'NULL'  AND trim((string)$education->mingpa !== '') ) {
		 						echo ' <td><strong>Minimum GPA: </strong>'. $education->mingpa . '</td>';
		 					}
		 	
		 					if ((string)$education->educationlevel == 2) {
		 						echo '<td  class="lastorlinks"><a class="small"  href="'.base_path().'/find-learning/results/vhs">Virtual High Schools</a></td>';
		 					} else {
		 						echo '<td>&nbsp;</td>';
		 					}
		 					echo '</tr>';
		 				}
		 			}
		 			echo '</table><br/>';
		 		}
		 	}
		 	
		 	$highschool = $transfer = '';
		 	$thead ='<table class="tablestyle">';
		 	$thead .='<thead>';
		 	$thead .='<tr valign="middle">';
		 	$thead .='    <th>Test</th>';
		 	$thead .='    <th>Test Description</th>';
		 	$thead .='    <th>Minimum Score</th>';
		 	$thead .='</tr>';
		 	$thead .='</thead>';
		 	$thead .='<tbody>';
		 	
		 	$name1 = array();
		 	if ((array) $programentrancetests) {
		 		$hscount = $tcount = 0;
		 		foreach ($programentrancetests as $test) {
		 			$type = ($test->hsgradortransferstudent == 'T') ? 'T': 'H';
		 			$count = ($type == 'T') ? ++$tcount : ++$hscount;
		 			$class = ($count%2 == 0) ? 'even' : 'odd';
		 	
		 			$trow = '<tr class="'.$class.'"  valign="top">';
		 			$trow .= '<td>';
		 			if ((string)$test->testurl !== 'NULL' AND trim((string)$test->testurl) !== '') {
		 				$testurl = substr_compare( 'http',(string)$test->testurl,0,4,true) ? 'http://'. (string)$test->testurl : (string)$test->testurl;
		 	
		 				$testurl = $basepath.(string)$test->testurl;
		 				$trow .=  '<a href="'.$testurl.'">' . $test->testname . '</a>';
		 	
		 				$name1[$count] = (string)$test->test->testname;
		 			} else {
		 				$trow .= $test->testname;
		 			}
		 			$trow .= '</td><td>';
		 			if ((string)$test->testdescription !== 'NULL' AND trim((string)$test->testdescription !== '') ) {
		 				$trow .= $test->testdescription;
		 			}
		 			$trow .= '</td><td style="text-align:center;">';
		 			$trow .= $test->minscore;
		 			$trow .= '</td>';
		 			$trow .= '</tr>';
		 	
		 			if ($type == 'T') {
		 				$transfer .= $trow;
		 			} else {
		 				$highschool .= $trow;
		 			}
		 		}
		 		
		 		$transfer .= '</table>';
		 		$highschool .= '</tbody></table><br/>';
		 	
		 		$highschool = $thead.$highschool;
		 	
		 		echo '<h4>Program Entrance Tests:</h4>';
		 	
		 		echo $highschool;
		 	} else {
		 		$counter=0;
		 		$counter++;
		 	}
		 	
		 	if ((array) $providerentrancetests) {
		 	
		 		$highschool = '';
		 		$hscount = $tcount = 0;
		 		$trow='';
		 		foreach ( $providerentrancetests as $test) {
		 			if (!in_array((string)$test->testname,$name1)) {
		 				$type = ($test->hsgradortransferstudent == 'T') ? 'T': 'H';
		 				$count = ($type == 'T') ? ++$tcount : ++$hscount;
		 				$class = ($count%2 == 0) ? 'even' : 'odd';
		 	
		 				$trow = '<tr class="'.$class.'"  valign="top">';
		 				$trow .= '<td>';
		 				if ((string)$test->testurl !== 'NULL' AND trim((string)$test->testurl) !== '') {
		 					$testurl = substr_compare( 'http',(string)$test->testurl,0,4,true) ? 'http://'. (string)$test->testurl : (string)$test->testurl;
		 	
		 					$testurl = $basepath.(string)$test->testurl;
		 					$trow .=  '<a href="'.$testurl.'">' . $test->testname . '</a>';
		 				} else {
		 					$trow .= $test->testname;
		 				}
		 				$trow .= '</td><td>';
		 				if ((string)$test->testdescription !== 'NULL' AND trim((string)$test->testdescription !== '') ) {
		 					$trow .= $test->testdescription;
		 				}
		 				$trow .= '</td><td style="text-align:center;">';
		 				$trow .= $test->minscore ;
		 				$trow .= '</td>';
		 				$trow .= '</tr>';
		 	
		 				if ($type == 'T') {
		 					$transfer .= $trow;
		 				} else {
		 					$highschool .= $trow;
		 	
		 				}
		 			}
		 		}
		 		$transfer .= '</table>';
		 		$highschool .= '</tbody></table><br/>';
		 	
		 		$highschool = $thead.$highschool;
		 	
		 		if ($hscount) {
		 			echo '<h4>Provider Entrance Tests:</h4>'.$highschool;
		 		} else {
		 			$counter++;
		 		}
		 	} else {
		 		$counter++;
		 	}
		 	
		 	$thead  = '<table class="tablestyle">';
		 	$thead .= '<thead>';
		 	$thead .= '<tr valign="middle">';
		 	$thead .= '<th>Course Title</th>';
		 	$thead .= '<th>Course Description</th>';
		 	$thead .= '<th>Course Level</th>';
		 	$thead .= '<th>Minimum GPA</th>';
		 	$thead .= '</tr>';
		 	$thead .= '</thead>';
		 	$rows   = false;
		 	
		 	for ($i=1; $i<=2; $i++):
		 	if ($i==1) {
		 		$rows = $programreqcourses;
		 	} else {
		 		$rows = $providerreqcourses;
		 	}
		 	
		 	$prcourses = '';
		 	$count = 0;
		 	
		 	if ($i==1)
		 	$name1=array();
		 	
		 	foreach ($rows AS $row ) {
		 		if ($i==1 || (!in_array((string)$row->coursetitle,$name1) && $i==2)) {
		 			if ($row->coursetype != 1) continue;
		 			$class = (++$count%2 == 0) ? 'even' : 'odd';
		 	
		 			$prcourses .= '<tr class="' . $class . '"  valign="top">';
		 			$prcourses .= '<td>';
		 			$prcourses .= $row->coursetitle.'</td>';
		 	
		 			if ($i==1)
		 			$name1[$count] = (string)$row->coursetitle;
		 	
		 			if ((string)$row->subjectareadescription !== 'NULL' AND trim((string)$row->subjectareadescription) !== '' )
		 			$pcourses .= '<br /><strong>Subject :'.$row->subjectareadescription ;
		 			if ((string)$row->deliverymodedescription !== 'NULL' AND trim((string)$row->deliverymodedescription) !== '' )
		 			$pcourses .= '<br /><strong>Delivery :'.$row->deliverymodedescription ;
		 	
		 			$prcourses .=  '<td>';
		 			$prcourses .= '<span>' . $row->description .'</span>';
		 			$prcourses .= '</td><td style="text-align:center;">';
		 			if ((string)$row->courseinfourl !== 'NULL' AND trim((string)$row->courseinfourl) !== '') {
		 				$courseurl = substr_compare( 'http',(string)$row->courseinfourl,0,4,true) ? 'http://'. (string)$row->courseinfourl : (string)$row->courseinfourl;
		 				$prcourses .= '<a class="small" target="_blank" href="'.$courseurl.'">More Info</a> <br />';
		 			}
		 	
		 			if ((string)$row->onlinecourseurl !== 'NULL' AND trim((string)$row->onlinecourseurl !== '') ) {
		 				if ((string)$row->deliverymode == '3') {
		 					$target =  '_self';
		 					$ocourseurl =  base_path().(string)$course->onlinecourseurl;
		 				} else {
		 					$target =  '_blank';
		 					$ocourseurl = substr_compare( 'http',(string)$row->onlinecourseurl,0,4,true) ? 'http://'. (string)$row->onlinecourseurl: (string) $row->onlinecourseurl;
		 				}
		 				$prcourses .= '<a class="small" target="_blank" href="'.$ocourseurl.'">Take Online</a><br />';
		 			}
		 	
		 			if ($row->courselevel=="H")
		 			$prcourses .= 'High School';
		 			else
		 			$prcourses .= 'College';
		 	
		 			$prcourses .= '</td>';
		 	
		 			$prcourses .= '<td style="text-align:center;">';
		 	
		 			if (strlen($row->mingpa) > 0)
		 			$prcourses .= $row->mingpa;
		 	
		 			$prcourses .= '</td>';
		 			$prcourses .= '</tr>';
		 		}
		 	}
		 	if ($prcourses) {
		 		if ($i==1) {
		 			echo '<h4>Program Prerequisite Courses:</h4> '.$thead .'<p>These courses are required by the program.</p>'.$prcourses . '</table><br/>';
		 		} else {
		 			echo '<h4>Provider Prerequisite Courses:</h4> '.$thead .'<p>These courses are required by the provider.</p>'.$prcourses . '</table><br/>';
		 		}
		 	} else {
		 		if ($i==1) {
		 			$counter++;
		 		} else {
		 			$counter++;
		 		}
		 	}
		 	
		 	endfor;
	 	else :
	 	?>
	 	<form name="programform" action="<?php echo base_path(); ?>find-learning/detail/programs/program_id/<?php echo $programdetails->programid; ?>/cipcode/<?php echo $programdetails->cipcode; ?>?modify=1" method="post">
	 		<span>
				<span style="float:left;">
				Program Name:<br/>
				<label><input type="text" style="height:20px;" size="25" value="<?php if ($_GET['modify']==1) echo $_POST['programname']; else echo $programdetails->programname; ?>" maxlength="255" id="programname" name="programname"></label>
				</span>
				<span style="float:left; margin-left:10px;">
				Award Level:<br/>
				<label><input type="text" style="height:20px;" size="25" value="<?php if ($_GET['modify']==1) echo $_POST['ipedsdesc']; else  echo $programdetails->awdesc ?>" maxlength="50" id="ipedsdesc" name="ipedsdesc"></label>
				</span>
				<span style="float:left; margin-left:10px;">
				Program Length:<br/> 
				<?php
				$awlevel = (string)$programdetails->awlevel;
				$programlength = '';
				switch ($awlevel) {
					case '1':
						$programlength =  'Less than 1 year';
						break;
					case '2':
						$programlength =  'Less than 2 years';
						break;
					case '3':
						$programlength =  '2 years';
						break;
					case '4':
						$programlength =  'Less than 4 years';
						break;
					case '5':
						$programlength =  '4 years';
						break;
					case '6':
						$programlength =  'Undetermined';
						break;
					case '7':
						$programlength =  '6 years';
						break;
					default:
				}
				?>
				<label><input type="text" style="height:20px;" size="25" value="<?php if ($_GET['modify']==1) echo $_POST['programlength']; else  echo $programlength ?>" maxlength="25" id="programlength" name="programlength"></label>
				</span>
			</span>
			<br><br><br><br>
			<span>
				<span style="float:left;">
				Program URL:<br/>
				<label><input type="text" style="height:20px;" size="85" value="<?php if ($_GET['modify']==1) echo $_POST['programurl']; else echo $programdetails->programurl; ?>" maxlength="500" id="programurl" name="programurl"></label>
				</span>
			</span>
			<br><br><br><br>
			<span>
				<span style="float:left;">
				Program Description:<br/>
				<label><textarea cols="85" rows="7" id="programdescription" name="programdescription"><?php if ($_GET['modify']==1) echo $_POST['programdescription']; else echo $programdetails->programdescription; ?></textarea></label>
				</span>
			</span>
			<br><br><br><br><br><br><br><br><br><br><br>
			<span>
				<span style="float:left;">
				Program Contact Name:<br/>
				<label><input type="text" style="height:20px;" size="25" value="<?php if ($_GET['modify']==1) echo $_POST['programcontactname']; else echo $programdetails->programcontactname; ?>" maxlength="100" id="programcontactname" name="programcontactname"></label>
				</span>
				<span style="float:left; margin-left:10px;">
				Program Contact Email:<br/>
				<label><input type="text" style="height:20px;" size="25" value="<?php if ($_GET['modify']==1) echo $_POST['programcontactemail']; else  echo $programdetails->programcontactemail ?>" maxlength="100" id="programcontactemail" name="programcontactemail"></label>
				</span>
				<span style="float:left; margin-left:10px;">
				Program Contact Phone:<br/> 
				<label><input type="text" style="height:20px;" size="25" value="<?php if ($_GET['modify']==1) echo $_POST['programcontactphone']; else  echo $programcontactphone ?>" maxlength="100" id="programcontactphone" name="programcontactphone"></label>
				</span>
			</span>
			<br><br><br><br>
			<h4>Program Enrollment Test Requirements</h4>
			<table width="100%" id="satact">
			<tr>
				<td>Test Name</td>
				<td>Test Description</td>
				<td>Minimum Score</td>
			</tr>	
			<?php 
				$rowswithdata = 0;
				for ($i=1; $i<=10; $i++): 
					
					if ($_GET["modify"]):
						$testnameVal = $_POST['testname'.$i];
						$testdescVal = $_POST['testdesc'.$i];
						$testminscoreVal = $_POST['testminscore'.$i];
					else:
						$testnameVal = $programentrancetests[$i-1]->testname;
						$testdescVal = $programentrancetests[$i-1]->testdescription;
						$testminscoreVal = $programentrancetests[$i-1]->minscore;
					endif;
								
					if ($testnameVal || $testdescVal || $testminscoreVal  ):
			?>
						<tr id="testrow<?php echo $i; ?>">
							<td>
							<label><input type="hidden" id="teststatus<?php echo $i; ?>" name="teststatus<?php echo $i; ?>" value="UPDATED" /></label>
							<label><input type="text" size="20" value="<?php echo $testnameVal; ?>" id="testname<?php echo $i; ?>" name="testname<?php echo $i; ?>"></label>
							</td>
							<td>
							<label><input type="text" size="20" value="<?php echo $testdescVal; ?>" id="testdesc<?php echo $i; ?>" name="testdesc<?php echo $i; ?>"></label>
							</td>
							<td>
							<label><input type="text" size="20" value="<?php echo $testminscoreVal; ?>" id="testminscore<?php echo $i; ?>" name="testminscore<?php echo $i; ?>"></label>
							</td>
							<td>
							<img id="testimg<?php echo $i; ?>" onclick="DeleteRow('test', <?php echo $i; ?>, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
							</td>
						</tr>
			<?php 
						$rowswithdata++;
					endif; 
				endfor; 
				
				if ($rowswithdata === 0):
			?>
				<tr id="testrow1">
					<td>
					<label><input type="hidden" id="teststatus1" name="teststatus1" value="ADDED" /></label>
					<label><input type="text" size="20" value="" id="testname1" name="testname1"></label>
					</td>
					<td>
					<label><input type="text" size="20" value="" id="testdesc1" name="testdesc1"></label>
					</td>
					<td>
					<label><input type="text" size="20" value="" id="testminscore1" name="testminscore1"></label>
					</td>
					<td>
					<img id="testimg1" onclick="DeleteRow('test', 1, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
					</td>
				</tr>	
			<?php
				endif;
				if ($rowswithdata <= 1):
			?>
				<tr id="testrow2">
					<td>
					<label><input type="hidden" id="teststatus2" name="teststatus2" value="ADDED" /></label>
					<label><input type="text" size="20" value="" id="testname2" name="testname2"></label>
					</td>
					<td>
					<label><input type="text" size="20" value="" id="testdesc2" name="testdesc2"></label>
					</td>
					<td>
					<label><input type="text" size="20" value="" id="testminscore2" name="testminscore2"></label>
					</td>
					<td>
					<img id="testimg2" onclick="DeleteRow('test', 2, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
					</td>
				</tr>		
			<?php		
				endif;
			?>
			</table>		
			
			<a href="javascript:void(0);" onclick="AddRow('test', 'satact');"><img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/add-new-entrance-test.png" alt="Add New Entrance Test" /></a>
		
			<br/><br/><br/>
				
			<h4>Prerequisite Courses for Enrollment in Program</h4>
			<table width="100%" id="precourses">
			<tr>
				<td>Course Name</td>
				<td>Course Description</td>
				<td>Course Level</td>
				<td>Minimum GPA</td>
			</tr>
			<?php 
				$rowswithdata = 0;
				for ($i=1; $i<=10; $i++): 
					if ($_GET["modify"]):
						$coursenameVal = $_POST['coursename'.$i];
						$coursedescVal = $_POST['coursedesc'.$i];
						$courselevelVal = $_POST['courselevel'.$i];
						$coursemingpaVal = $_POST['coursemingpa'.$i];
					else:
						$coursenameVal = $programreqcourses[$i-1]->testname;
						$coursedescVal = $programreqcourses[$i-1]->testdescription;
						$level = '';
						if (strlen($providerReqCourses[$i-1]->courselevel)) {
							switch (strtoupper($providerReqCourses[$i-1]->courselevel)) {
								case 'C':
									$level = 'College';
									break;
								case 'H':
									$level = 'High School';
									break;
								case 'H or C':
									$level = 'High School or College';
									break;
								case 'B':
									$level = 'Bachelors';
									break;
							}
						}
						$courselevelVal = $level;
						$coursemingpaVal = $providerReqCourses[$i-1]->mingpa;
					endif;
					
					if ($coursenameVal || $coursedescVal || $courselevelVal || $coursemingpaVal  ):
			?>
			<tr id="courserow<?php echo $i; ?>">
				<td>
				<label><input type="hidden" id="coursestatus<?php echo $i; ?>" name="coursestatus<?php echo $i; ?>" value="UPDATED" /></label>
				<label><input type="text" size="15" value="<?php echo $coursenameVal; ?>" id="coursename<?php echo $i; ?>" name="coursename<?php echo $i; ?>"></label>
				</td>
				<td>
				<label><input type="text" size="15" value="<?php echo $coursedescVal; ?>" id="coursedesc<?php echo $i; ?>" name="coursedesc<?php echo $i; ?>"></label>
				</td>
				<td>
				<label><input type="text" size="15" value="<?php echo $courselevelVal; ?>" id="courselevel<?php echo $i; ?>" name="courselevel<?php echo $i; ?>"></label>
				</td>
				<td>
				<label><input type="text" size="15" value="<?php echo $coursemingpaVal; ?>" id="coursemingpa<?php echo $i; ?>" name="coursemingpa<?php echo $i; ?>"></label>
				</td>
				<td>
				<img id="courseimg<?php echo $i; ?>" onclick="DeleteRow('course', <?php echo $i; ?>, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
				</td>
			</tr>
			<?php 
						$rowswithdata++;
					endif;
				endfor; 
						
				if ($rowswithdata === 0):
			?>
				<tr id="courserow1">
					<td>
					<label><input type="hidden" id="coursestatus1" name="coursestatus1" value="ADDED" /></label>
					<label><input type="text" size="15" value="" id="coursename1" name="coursename1"></label>
					</td>
					<td>
					<label><input type="text" size="15" value="" id="coursedesc1" name="coursedesc1"></label>
					</td>
					<td>
					<label><input type="text" size="15" value="" id="courselevel1" name="courselevel1"></label>
					</td>
					<td>
					<label><input type="text" size="15" value="" id="coursemingpa1" name="coursemingpa1"></label>
					</td>	
					<td>
					<img id="courseimg1" onclick="DeleteRow('course', 1, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
					</td>
				</tr>	
			<?php
				endif;
				if ($rowswithdata <= 1):
			?>
				<tr id="courserow2">
					<td>
					<label><input type="hidden" id="coursestatus2" name="coursestatus2" value="ADDED" /></label>
					<label><input type="text" size="15" value="" id="coursename2" name="coursename2"></label>
					</td>
					<td>
					<label><input type="text" size="15" value="" id="coursedesc2" name="coursedesc2"></label>
					</td>
					<td>
					<label><input type="text" size="15" value="" id="courselevel2" name="courselevel2"></label>
					</td>
					<td>
					<label><input type="text" size="15" value="" id="coursemingpa2" name="coursemingpa2"></label>
					</td>
					<td>
					<img id="courseimg2" onclick="DeleteRow('course', 2, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
					</td>
				</tr>		
			<?php		
				endif;
			?>
			</table>		
			
			<a href="javascript:void(0);" onclick="AddRow('course', 'precourses');"><img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/add-new-prerequisite-courses.png" alt="Add New Pre-req Courses" /></a>
			
			<label><input type="hidden" value="" id="statusvalue" name="statusvalue" /></label>
			
			</form>
	 	<?php
	 	endif;  // if ($whovar != "p")
  		?>
	</div>
	<br/><br/><br/>
</div>

<?php 

if ($counter == 4)
	echo '<script>hidedetails();</script>';

global $user;

$logged_in = $user->uid;

$cma->usersession =  $logged_in ? 'U' : 'S';

?>

<div id="training-sidebar" class="panel-2col panel-col-last" style="margin-left:766px; position: absolute;">
<?php 
if ($whovar != "p" && !empty($programdetails->programid)) : 
?>
	<a class="save-to-notebook large<?php if ($user->uid=='U') echo 'u'; ?>" alt="Save this program" title="Save this program" onclick="not_logged_in('<?php echo $cma->usersession; ?>','Program Saved temporarily in your wish list');return vcn_saveOrTargetToCMA (this,'programs', 'program_id', '<?php echo $programdetails->programid; ?>','<?php echo $cma->usersession; ?>','Program Saved');" href="<?php echo base_path(); ?>cma/notebook/save/program/<?php echo $programdetails->programid.'/'.$programdetails->cipcode; ?>"> </a>
	<a class="target-to-notebook large" alt="Target this program" title="Target this program" onclick="not_logged_in('<?php echo $cma->usersession; ?>','Program Targeted temporarily in your wish list');return vcn_saveOrTargetToCMA ('<?php echo base_path(); ?>cma/notebook/target/program/<?php echo $programdetails->programid.'/'.$programdetails->cipcode; ?>','programs', 'program_id', '<?php echo $programdetails->programid; ?>','<?php echo $cma->usersession; ?>','Program Targeted','<?php echo $cma->userid;?>');" href="javascript:void(0);"> </a>
<?php 
else : 
	//if (strlen($programdetails->programid)) :	
?>
	<?php 
	// status (UP=Update Pending, C=Confirmed, CP=Confirm Pending)
	if ($programStatus == 'UP') {
		$programStatus = 'Update Pending';
	} else if ($programStatus == 'C') {
		$programStatus = 'Confirmed';
	} else if ($programStatus == 'CP') {
		$programStatus = 'Confirm Pending';
	}
	echo 'Update Status: <strong>' . $programStatus . '</strong>'; 
	//these buttons should show up only when the user modify the program
	if(!empty($programdetails->programid)){
	?>
	<br><br>
	<img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/confirm.png" onclick="document.getElementById('statusvalue').value='CONFIRMED'; document.programform.submit();" title="Confirm" alt="Confirm" style="cursor:pointer;" />
	<br><br>
	<img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete_program.png" onclick="document.getElementById('statusvalue').value='DELETED';document.programform.submit();" title="Delete" alt="Delete" style="cursor:pointer;" />
	
<?php
	}
?>	
	<br><br>
	<img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/submit-changes.png" onclick="document.getElementById('statusvalue').value='UPDATED';document.programform.submit();" title="Submit" alt="Submit" style="cursor:pointer;" />
	<br><br>
<?php
	//else :
	if(!empty($programdetails->programid)){
?>
	<!--img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/add_new_programs_big.png" onclick="document.getElementById('statusvalue').value='NEW PROGRAM'; document.programform.submit();" title="Add New" alt="Add New" style="cursor:pointer;" / -->
	<a href="<?php echo base_path().'find-learning/detail/programs/program_id/'; ?>"><img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/add_new_programs_big.png" onclick="document.getElementById('statusvalue').value='NEW PROGRAM';" title="Add New" alt="Add New" style="cursor:pointer;" /></a>
	<br><br>	
	
<?php 
	}
	//endif; 
?>	
	<div style="width:172px; text-align:center;">
	<a href="<?php echo base_path(); ?>find-learning/results/programs/unitid/<?php echo $user->profile_provider_id; ?>"><img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/return-to-program-list.png" title="Return to Program" alt="Return to Program" style="cursor:pointer;" /></a>
	</div>
<?php 
endif; 
?>
	
	<br><br>
	<?php  echo $content['sidebar'];  
	// } // end if for if((empty($user->uid) && empty($explodetheurl[6])) || (empty($user->profile_provider_id) && empty($explodetheurl[6])))
	?>
</div>
