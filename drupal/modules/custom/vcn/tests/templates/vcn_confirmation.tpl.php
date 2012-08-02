<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
$cma = vcnCma::getInstance();
$conn = vcn_connect_to_db();

$qsi=$_GET['qsi'];
$tti=$_GET['tti'];
$pi=$_GET['pi'];
$oi=$_GET['oi'];
$tsi=$_GET['tsi'];
$proctoremail = $_GET['email'];

if (strlen($qsi) && strlen($tti) && strlen($pi) && strlen($oi) && strlen($tsi)) {
	$query = "SELECT * FROM hvcp.vcn_proctor_time_slot vpts inner join hvcp.vcn_proctor p on p.proctor_id=vpts.proctor_id WHERE vtps.time_slot_id='".$tsi."'";
	$result = mysql_query($query);
	
	$count=0;
	while($row = mysql_fetch_object($result)) {
		$count = $row->NUMBER_OF_SESSIONS;

	}

	if ($count<3 && $count>=0) {
		$query = "UPDATE hvcp.vcn_proctor_time_slot SET number_of_sessions=number_of_sessions+1 WHERE time_slot_id='".$tsi."'";
		$result = mysql_query($query);
		
		$pretrimmedtask = md5(uniqid(mt_rand(),true));
		$tasknum =  substr($pretrimmedtask ,0,10);	

		$query = "INSERT INTO hvcp.vcn_test_session ".
		   "(TEST_SESSION_ID,QUESTION_SET_ID,TEST_TAKER_ID,PROCTOR_ID,OFFICE_ID,TIME_SLOT_ID) ".
		   "VALUES ".
		   "('$tasknum','$qsi','$tti','$pi','$oi','$tsi');";
		$result = mysql_query($query); 
		   
		$tssi=$tasknum;
		
		$query = "SELECT * from drupal.users where uid='$tti'";
		$result = mysql_query($query);	
		
		while($row = mysql_fetch_object($result))
			$studentemail=$row->mail;
			
	} else {
		//echo "toomany";
	}
}


global $user;

$thename = $cma->firstname." ".$cma->lastname;



//echo $tsi. ' * '. $pi. ' * '. $tti. ' * '. $thename. ' * '. $qsi. ' * '.$_GET['testname']. ' * '. vcn_reformat_date($_GET['date']). ' * '. $_GET['time']. ' * '.$_GET['endtime'];

$body="Dear ".$_GET['proctorname'].",<br/><br/>
A test session has been scheduled and confirmed.  Your presence will be required during the test session.  The information related to the test session established at this time is provided below.
<br/><br/>
Office Location: ".$_GET['officelocation']."<br/>
Date and Time: ".vcn_reformat_date($_GET['date'])." ".$_GET['time']."<br/>
Test Session Code: ".$tssi."<br/>
Test Taker ID: ".$user->name."<br/>
Test Taker Name: ".$cma->firstname." ".$cma->lastname."<br/>
Test Taker Email: ".$studentemail."<br/>
Course Name: ".$_GET['testname']."<br/>
URL to start the session: https://".$_SERVER['SERVER_NAME'].base_path()."tests/initiation?tsi=".$tssi."<br/><br/>

In case you need to adjust any time for this test session, please contact the Test Taker directly to arrange and finalize that.  Please note that you will need your Proctor ID and Password to login to initiate the test. <br/><br/>

Thanks,<br/><br/>
The VCN Team";


//echo $body."<br/><br/>";
	
	$params = array(
		'subject' => t('VCN Test Schedule Confirmation'),
		'body' => t($body),
	  );
     
	$email = $proctoremail;

    if (strlen($email) > 0) {
		drupal_provider_mail('training', 'mykey', $email, $language, $params, $from = NULL, $send = TRUE);	  
    }
	
$dearuser = $cma->firstname." ".$cma->lastname;
if (strlen($dearuser)<3)
	$dearuser = $user->name;

$body="Dear ".$dearuser.",<br/><br/>
A test session has been scheduled and confirmed.  Please make sure to arrive at the facility 15 minutes prior to the scheduled time. The information related to the test session established at this time is provided below.
<br/><br/>
Office Location: ".$_GET['officelocation']."<br/>
Date and Time: ".vcn_reformat_date($_GET['date'])." ".$_GET['time']."<br/>
Test Session Code: ".$tssi."<br/>
Test Taker ID: ".$user->name."<br/>
Test Taker Name: ".$cma->firstname." ".$cma->lastname."<br/>
Course Name: ".$_GET['testname']."<br/><br/>


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
	
vcn_disconnect_from_db($conn);	
?>

<br/>
You have reserved the Time slot for taking a Test on <?php echo vcn_reformat_date($_GET['date']); ?> at <?php echo $_GET['time']; ?> at <?php echo $_GET['officename']; ?> for <?php echo $_GET['testname']; ?>. 
<br/><br/>
Your request is confirmed and your Test Session ID is:  <strong><?php echo $tssi; ?></strong>
<br/><br/>
Please present this number along with your Photo identification to the Proctor at the Office you have selected. Please arrive at the office 15 minutes prior to the scheduled time. 
<br/><br/><br/>
** A confirmation email will be sent to you and the Proctor. Please communicate with the Proctor via email or phone if needed to finalize the schedule **