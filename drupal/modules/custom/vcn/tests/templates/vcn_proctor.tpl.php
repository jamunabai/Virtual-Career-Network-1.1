<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php


function recorddata($uid,$date,$st,$et,$sid,$course,$password) {

	$newdate=explode("/",$date);

	
	//echo count($newdate) . is_int($newdate[0]) . is_int($newdate[1]) . is_int($newdate[2]) . ($newdate[0]<0) . ($newdate[0]>12) . ($newdate[1]<0) . ($newdate[1]>31) . ($newdate[2]<0) . ($newdate[2]>99);
	
	
	
	if ((count($newdate)!=3 || ($newdate[0]<=0) || ($newdate[0]>12) || ($newdate[1]<=0) || ($newdate[1]>31) || ($newdate[2]<=0) || ($newdate[2]>99)) || (strtotime("now")-strtotime($date)>86400) || !checkdate($newdate[0],$newdate[1],($newdate[2]+2000))) {
		drupal_set_message(t("Date is not in proper format."));
		inputscreen();
		return;
	} else {
		$sqldate=($newdate[2]+2000).'-'.$newdate[0].'-'.$newdate[1]; 
	}


	$currentTime = strtotime("now");
	$startTime = strtotime($st);
	
	if ($startTime<$currentTime && strtotime($date)<=strtotime("now")) {
		drupal_set_message(t("Start time is less than the current time."));
		inputscreen();
		return;		
	}

	$newtime=explode(":",$st);

	if (count($newtime)!=2 || ($newtime[0]<=0) || ($newtime[0]>23) || ($newtime[1]<0) || ($newtime[1]>59)) {
		drupal_set_message(t("Start time is not in proper format."));
		inputscreen();
		return;	
	}
	
	$newtime=explode(":",$et);

	if (count($newtime)!=2 || ($newtime[0]<=0) || ($newtime[0]>23) || ($newtime[1]<0) || ($newtime[1]>59)) {
		drupal_set_message(t("End time is not in proper format."));
		inputscreen();
		return;			
	}
	
	if (strtotime($et)<=strtotime($st)) {
		drupal_set_message(t("End time is less than or equal to start time."));
		inputscreen();
		return;			
	}	
	
	$conn = vcn_connect_to_db();
	
	$query0 = "SELECT * from drupal.users where name='$uid'";
	$result0 = mysql_query($query0);

	$drupalpass='';
	while($row0 = mysql_fetch_object($result0)) {
		$drupalpass=$row0->pass;
		$newuid= $row0->uid;		
	}
	
	
	if (md5($password)!=$drupalpass) {
		vcn_disconnect_from_db($conn); 
		drupal_set_message(t("Incorrect username/password entered."));
		inputscreen();
		return;
	}	
	
	$query = "SELECT * from drupal.users where name='$sid'";
	$result = mysql_query($query);	
	
	while($row = mysql_fetch_object($result)) {
		$username=$row->name;
		$umail=$row->mail;
	}
	
	if (!mysql_num_rows($result)) {
		vcn_disconnect_from_db($conn); 
		drupal_set_message(t("Incorrect student id entered."));
		inputscreen();
		return;	
	}
	
	$query = "SELECT *, p.email as proctoremail from hvcp.vcn_proctor p inner join hvcp.vcn_office_partners vop on p.office_id=vop.office_id where p.drupal_user_id='$newuid' and vop.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER')";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_object($result)) {
		$oi=$row->OFFICE_ID;
		$proctorname=$row->PROCTOR_NAME;
		$proctoremail=$row->proctoremail;
		$a1l = $row->ADDRESS." ".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; 
		$proctorid = $row->PROCTOR_ID;
	}
		
	$query = "SELECT * from drupal.users where name='$sid'";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_object($result)) 
		$newsid=$row->uid;

		

	
		

	
	$query = "INSERT INTO hvcp.vcn_proctor_time_slot (PROCTOR_ID,TIME_SLOT_DATE,START_TIME,END_TIME,NUMBER_OF_SESSIONS,BY_APPOINTMENT) VALUES ('$proctorid','$sqldate','$st','$et','1','Y')";

	$result = mysql_query($query);
	$tsi=mysql_insert_id();
	
	$pretrimmedtask = md5(uniqid(mt_rand(),true));
	$tasknum =  substr($pretrimmedtask ,0,10);	
	
	$query = "select * from hvcp.vcn_test_session where question_set_id='$course' and test_taker_id='$newsid' and proctor_id='$proctorid' and time_slot_id is null";

	$result = mysql_query($query); 	
	$countexisting = 0;
	
	while($row = mysql_fetch_object($result)) {
		$countexisting++;
		$existingsession = $row->TEST_SESSION_ID;
	}
	
	if ($countexisting) {
		$query = "update hvcp.vcn_test_session set time_slot_id='$tsi' where test_session_id='$existingsession'";
	
		$result = mysql_query($query); 

		$tasknum=$existingsession;
			
	} else {
	
	$query = "INSERT INTO hvcp.vcn_test_session ".
	   "(TEST_SESSION_ID,QUESTION_SET_ID,TEST_TAKER_ID,PROCTOR_ID,OFFICE_ID,TIME_SLOT_ID) ".
	   "VALUES ".
	   "('$tasknum','$course','$newsid','$proctorid','$oi','$tsi');";

	$result = mysql_query($query); 
	
	}
	
	$tssi=$tasknum;
	
	
	$query = "SELECT * from drupal.node where nid='$course'";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_object($result))
		$coursename=$row->title;
		
		
	$query = "SELECT * from hvcp.vcn_cma_user where user_session_id='$newsid'";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_object($result)) {
		$testtakername=$row->FIRST_NAME." ".$row->MIDDLE_NAME." ".$row->LAST_NAME;		
	}
	
	$query = "SELECT * from drupal.users where uid='$newsid'";
	$result = mysql_query($query);	
	
	while($row = mysql_fetch_object($result))
		$studentemail=$row->mail;
	
	vcn_disconnect_from_db($conn);	

	//////////// PROCTOR EMAIL //////////////
	
	$body0="<br/>Dear ".$proctorname.",<br/><br/>
A test session has been scheduled and confirmed.  Your presence will be required during the test session.  The information related to the test session established at this time is provided below.
<br/><br/>
Office Location: ".$a1l."<br/>
Date and Time: ".vcn_reformat_date($date)." ".$st."<br/>
Test Session Code: ".$tssi."<br/>
Test Taker ID: ".$username."<br/>
Test Taker Name: ".$testtakername."<br/>
Test Taker Email: ".$studentemail."<br/>
Course Name: ".$coursename."<br/>
URL to start the session : https://".$_SERVER['SERVER_NAME'].base_path()."tests/initiation?tsi=".$tssi."
<br/><br/>
In case you need to adjust any time for this test session, please contact the Test Taker directly to arrange and finalize that.  Please note that you will need your Proctor ID and Password to login to initiate the test. <br/><br/>

Thanks,<br/><br/>
The VCN Team";

$params = array(
	'subject' => t('VCN Test Schedule Confirmation'),
	'body' => t($body0),
  );
 
$email = $proctoremail;

if (strlen($email) > 0) {
	drupal_provider_mail('training', 'mykey', $email, $language, $params, $from = NULL, $send = TRUE);	  
}

	/////////////////////// PROCTOR EMAIL END ///////////////////
	
	////////////////////// TEST TAKER EMAIL ////////////////////
	
$dearuser = $testtakername;
if (strlen($dearuser)<3)
	$dearuser = $username;

$body = "Dear ".$dearuser.",<br/><br/>
A test session has been scheduled and confirmed.  Please make sure to arrive at the facility 15 minutes prior to the scheduled time. The information related to the test session established at this time is provided below.
<br/><br/>
Office Location: ".$a1l."<br/>
Date and Time: ".vcn_reformat_date($date)." ".$st."<br/>
Test Session Code: ".$tssi."<br/>
Test Taker ID: ".$username."<br/>
Test Taker Name: ".$testtakername."<br/>
Course Name: ".$coursename."<br/>
<br/>
Thanks,<br/><br/>
The VCN Team";	
	
$params = array(
	'subject' => t('VCN Test Schedule Confirmation'),
	'body' => t($body),
  );
 
$email = $studentemail;

if (strlen($email) > 0) {
	drupal_provider_mail('training', 'mykey', $email, $language, $params, $from = NULL, $send = TRUE);	  
}
	
	////////////////////// TEST TAKER EMAIL END ////////////////////
	
	echo "<br/>Your request to set up a test session on ".vcn_reformat_date($date)." at ".$st." has been confirmed and communicated to the Test Taker.";
	
}

function inputscreen($message) {

	$conn = vcn_connect_to_db();
	
	$query3 = "select * from hvcp.vcn_course where drupal_test_id > 0";
	$result3 = mysql_query($query3);
	
	vcn_disconnect_from_db($conn);	
	
	$si = isset($_POST['sid'])?$_POST['sid']:$_GET['tti'];
	
	$o='<form action="'.base_path().'tests/proctor?tti='.$_GET['tti'].'&courseid='.$_GET['courseid'].'" method="post" name="proctorform" id="proctorform">
	<br/><br/>
	<div>
	<div style="float:left; width: 133px;">Proctor ID:</div>
	<div><label><input name="uid" value="'.$_POST['uid'].'" type="text" style="width:300px; float:left;" /></label></div>
	</div>

	<br/><br/>
	
	<div>
	<div style="float:left; width: 133px;">Password:</div>
	<div><label><input name="password" type="password" style="width:300px; float:left;" /></label></div>
	</div>

	<br/><br/>
	
	<div>
	<div style="float:left; width: 133px;">Date (MM/DD/YY):</div>
	<div><label><input name="date" value="'.$_POST['date'].'" type="text" style="width:300px; float:left;" /></label></div>
	</div>

	<br/><br/>

	<div>
	<div style="float:left; width: 133px;">Start time (HH:MM):</div>
	<div><label><input name="st" value="'.$_POST['st'].'" type="text" style="width:300px; float:left;" /></label></div>
	</div>

	<br/><br/>

	<div>
	<div style="float:left; width: 133px;">End time (HH:MM):</div>
	<div><label><input name="et" value="'.$_POST['et'].'" type="text" style="width:300px; float:left;" /></label></div>
	</div>

	<br/><br/>
	

	<div>
	<div style="float:left; width: 133px;">Test Taker ID:</div>
	<div><label><input name="sid2" value="'.$si.'" type="text" style="width:300px; float:left;" disabled="true" /></label></div>
	</div>

	<br/><br/>

	<div>
	<div style="float:left; width: 133px;">Course Name:</div>
	<div>
		<label><select id="alltests2" name="alltests2" style="width:306px;" disabled="true">';
		 while($row3 = mysql_fetch_object($result3)) {
		 $o.='<option ';
		  if ($_GET['courseid']==$row3->DRUPAL_TEST_ID) {
			$o.= 'selected="selected"'; 
			}

			$o.= ' value="'.$row3->DRUPAL_TEST_ID.'">'.$row3->COURSE_TITLE.'</option>';
		  } 
		$o.='</select></label> 
	</div>
	</div>

	<br/><br/>
	<input type="hidden" id="sid" name="sid" value="'.$si.'" />
	<input type="hidden" id="alltests" name="alltests" value="'.$_GET['courseid'].'" />
	<label><input alt="Submit" type="image" value="Submit" src="'.base_path().'sites/all/modules/custom/vcn/tests/images/submit.png" /></label></form>';

	echo $o;
}

	global $user;

	//if (!in_array('proctor',$user->roles))
	//	header('Location: '.base_path());
		
		
	if (strlen($_POST['uid']) || strlen($_POST['date']) || strlen($_POST['st']) || strlen($_POST['et']) || strlen($_POST['sid']) || strlen($_POST['alltests']) || strlen($_POST['password']))
		recorddata($_POST['uid'],$_POST['date'],$_POST['st'],$_POST['et'],$_POST['sid'],$_POST['alltests'],$_POST['password']);
	else
		inputscreen();
?>	
