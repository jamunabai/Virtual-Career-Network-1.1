<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

 <?php

require_once('vcn.rest.inc'); 

$file = "..".$GLOBALS['hvcp_config_default_base_path']."sites/default/hvcp.functions.inc";

require_once($file);


 function vcn_reformat_date($date) {
	 $date = getdate(strtotime($date)); 
	 
	 $thedate=$date['mon'].'/'.$date['mday'].'/'.$date['year'];
	 
	 return $thedate;
 
 }


$dbserver = $GLOBALS['hvcp_config_db_server_name'];

$dbuser = $GLOBALS['hvcp_config_db_username'];

$dbpass = $GLOBALS['hvcp_config_db_password'];

$dbname = $GLOBALS['hvcp_config_db_name'];


$link = mysql_connect($dbserver, $dbuser, $dbpass);

if (!$link) {

die('Could not connect: ' . mysql_error());

}

$tsi = $_GET['tsi'];
$tti = $_GET['tti'];

	$query="select *, op.city as CITY, p.EMAIL as EMAIL, du.mail as drupalemail from hvcp.vcn_test_session ts
	inner join hvcp.vcn_proctor p on p.proctor_id = ts.proctor_id
	inner join hvcp.vcn_office_partners op on ts.OFFICE_ID = op.OFFICE_ID
	inner join hvcp.vcn_proctor_time_slot pts on ts.TIME_SLOT_ID = pts.TIME_SLOT_ID
	left join hvcp.vcn_cma_user cma on ts.TEST_TAKER_ID = cma.user_session_id
	inner join drupal.users du on ts.TEST_TAKER_ID = du.uid
	inner join hvcp.vcn_course c on ts.question_set_id = c.drupal_test_id 

	where ts.time_slot_id='$tsi' and ts.test_taker_id='$tti' and cma.USER_SESSION='U' and op.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER')";

	$result = mysql_query($query); 
	
	while($row = mysql_fetch_object($result)) {
		$a1l=$row->ADDRESS.", ".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; 
		$date=$row->TIME_SLOT_DATE;
		$st=$row->START_TIME;
		$tssi=$row->TEST_SESSION_ID;
		$username=$row->name;
		$testtakername=$row->FIRST_NAME." ".$row->MIDDLE_NAME." ".$row->LAST_NAME;	
		$studentemail=$row->drupalemail;
		$coursename=$row->COURSE_TITLE;
		$proctorname=$row->PROCTOR_NAME;
		$proctoremail=$row->EMAIL;
	}

	$query = "delete from hvcp.vcn_test_session where time_slot_id='".$tsi."' and test_taker_id='".$tti."'";

	$result = mysql_query($query); 
	
	$query = "UPDATE hvcp.vcn_proctor_time_slot SET number_of_sessions = number_of_sessions - 1  WHERE time_slot_id='".$tsi."'";

	$result = mysql_query($query); 	


	// Email header

	$email = 'admin@vcn.org';
	
	$subject = 'VCN Test Session - Cancelled';	

	$header = "From: ".$email." <".$email.">\r\n";
	$header .= "Reply-To: ".$email."\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//$header .= "MIME-Version: 1.0\r\n";
	//$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	

	
	$comment = "Dear ".$proctorname.",<br/><br/>
	Please note that the following test session has been cancelled and removed from the schedule. 
	<br/><br/>
	Office Location: ".$a1l."<br/>
	Date and Time: ".vcn_reformat_date($date)." ".$st."<br/>
	Test Session Code: ".$tssi."<br/>
	Test Taker ID: ".$username."<br/>
	Test Taker Name: ".$testtakername."<br/>
	Test Taker Email: ".$studentemail."<br/>
	Course Name: ".$coursename."<br/>
	<br/>
	Thanks,<br/><br/>
	The VCN Team";	

	mail( $proctoremail, $subject, $comment, $header );	
	
	$dearuser = $testtakername;
	if (strlen($dearuser)<3)
		$dearuser = $username;

	$comment = "Dear ".$dearuser.",<br/><br/>
	Please note that the following test session has been cancelled and removed from the schedule. 
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
	
	mail( $studentemail, $subject, $comment, $header );	

	

	
echo "Record deleted. Email sent.";
mysql_close($link);
?>