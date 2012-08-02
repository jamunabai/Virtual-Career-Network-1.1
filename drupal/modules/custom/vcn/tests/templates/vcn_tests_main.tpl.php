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

if (!in_array("proctor",$user->roles))
	header('Location: '.base_path());
	
function normaltime($t) {

$xh = explode(":",$t);

$h = $xh[0];

if ($h>12)
	$h-=12;
	
$newtime = $h.':'.$xh[1];

if ($xh[0]>12)
	$newtime.=" PM";
else
	$newtime.=" AM";
	
return $newtime;

}	

?>	
<style type="text/css">
table.sample {
	border-width: 0px;
	border-spacing: 0px;
	border-style: solid;
	border-color: black;
	background-color: white;
	width: 100%;
}
table.sample th {
	border-width: 1px;
	padding: 1px;
	border-style: inset;
	border-color: black;
	background-color: white;
}
table.sample td {
	border-width: 1px;
	padding: 0px;
	border-style: ridge;
	border-style: inset;
	border-color: black;
	/*background-color: white;*/
	padding: 10px;
}
.headtd {
	background-color: #189AB0; 
	font-weight: bold;
	color: #ffffff;
}
</style>

<?php 
/*
$queryt = "select * from hvcp.vcn_proctor where proctor_id='$user->uid'"; 
$resultt = mysql_query($queryt);
while($rowt = mysql_fetch_object($resultt))
	$drupalid = $row->DRUPAL_USER_ID;
*/

$conn = vcn_connect_to_db();

if (strlen($_GET['delete'])) {
	$tsi = $_GET['delete'];
	
	
		$email = 'admin@vcn.org';
		
		$subject = 'VCN Test Session - Rejected by Proctor';	

		$header = "From: ".$email." <".$email.">\r\n";
		$header .= "Reply-To: ".$email."\r\n";
		$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";	

		$query="select *, op.city as CITY, p.EMAIL as EMAIL, du.mail as drupalemail, ts.CREATED_TIME as ct from hvcp.vcn_test_session ts
			inner join hvcp.vcn_proctor p on p.proctor_id = ts.proctor_id
			inner join hvcp.vcn_office_partners op on ts.OFFICE_ID = op.OFFICE_ID
			left join hvcp.vcn_cma_user cma on ts.TEST_TAKER_ID = cma.user_session_id
			inner join drupal.users du on ts.TEST_TAKER_ID = du.uid
			inner join hvcp.vcn_course c on ts.question_set_id = c.drupal_test_id 

			where ts.test_session_id = '$tsi' and cma.USER_SESSION='U' and op.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER')";

			$result = mysql_query($query); 
			
			while($row = mysql_fetch_object($result)) {
				$a1l=$row->ADDRESS.", ".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; 
				$date=$row->ct;
				$st=$row->START_TIME;
				$tssi=$row->TEST_SESSION_ID;
				$username=$row->name;
				$testtakername=$row->FIRST_NAME." ".$row->MIDDLE_NAME." ".$row->LAST_NAME;	
				$studentemail=$row->drupalemail;
				$coursename=$row->COURSE_TITLE;
				$proctorname=$row->PROCTOR_NAME;
				$proctoremail=$row->EMAIL;
			}
			
			$dearuser = $testtakername;
			if (strlen($dearuser)<3)
				$dearuser = $username;

			$comment = "Dear ".$dearuser.",<br/><br/>
			Please note that the following test session has been rejected by the proctor. 
			<br/><br/>
			Office Location: ".$a1l."<br/>
			Date: ".vcn_reformat_date($date)." ".$st."<br/>
			Test Session Code: ".$tssi."<br/>
			Test Taker ID: ".$username."<br/>
			Test Taker Name: ".$testtakername."<br/>
			Course Name: ".$coursename."<br/>
			<br/>
			Thanks,<br/><br/>
			The VCN Team";	
			
			mail( $studentemail, $subject, $comment, $header );			
			

	$query = "delete from hvcp.vcn_test_session where test_session_id = '$tsi'";
	$result = mysql_query($query);
}

if (strlen($_GET['cancel'])) {
	$cancel = $_GET['cancel'];
	$tsi = $_GET['tsi'];
	
	
		$email = 'admin@vcn.org';
		
		$subject = 'VCN Test Session - Cancelled by Proctor';	

		$header = "From: ".$email." <".$email.">\r\n";
		$header .= "Reply-To: ".$email."\r\n";
		$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";	

		$query="select *, op.city as CITY, p.EMAIL as EMAIL, du.mail as drupalemail from hvcp.vcn_test_session ts
			inner join hvcp.vcn_proctor p on p.proctor_id = ts.proctor_id
			inner join hvcp.vcn_office_partners op on ts.OFFICE_ID = op.OFFICE_ID
			inner join hvcp.vcn_proctor_time_slot pts on ts.TIME_SLOT_ID = pts.TIME_SLOT_ID
			left join hvcp.vcn_cma_user cma on ts.TEST_TAKER_ID = cma.user_session_id
			inner join drupal.users du on ts.TEST_TAKER_ID = du.uid
			inner join hvcp.vcn_course c on ts.question_set_id = c.drupal_test_id 

			where ts.test_session_id = '$cancel' and cma.USER_SESSION='U' and op.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER')";

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
			
			$dearuser = $testtakername;
			if (strlen($dearuser)<3)
				$dearuser = $username;

			$comment = "Dear ".$dearuser.",<br/><br/>
			Please note that the following test session has been cancelled by the proctor. 
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
	

	$query = "delete from hvcp.vcn_test_session where test_session_id = '$cancel'";

	$result = mysql_query($query); 
	
	$query = "UPDATE hvcp.vcn_proctor_time_slot SET number_of_sessions = number_of_sessions - 1  WHERE time_slot_id='".$tsi."'";

	$result = mysql_query($query); 	

}

$query = "select *, u.name as tti from hvcp.vcn_test_session t
inner join hvcp.vcn_proctor_time_slot s on t.TIME_SLOT_ID=s.TIME_SLOT_ID
inner join hvcp.vcn_proctor p 
inner join drupal.users u on t.test_taker_id = u.uid 
inner join hvcp.vcn_course c on t.question_set_id = c.drupal_test_id
where s.time_slot_date = curdate() and p.drupal_user_id='$user->uid' and p.proctor_id=s.proctor_id order by s.start_time asc"; 

$result = mysql_query($query);

while($row = mysql_fetch_object($result))
	$resultcopy[] = $row;
	
$query2 = "select *, u.name as tti, t.CREATED_TIME as ct from hvcp.vcn_test_session t

inner join hvcp.vcn_proctor p 
inner join hvcp.vcn_office_partners op on p.office_id = op.office_id
inner join drupal.users u on t.test_taker_id = u.uid 
inner join hvcp.vcn_course c on t.question_set_id = c.drupal_test_id
where p.drupal_user_id='$user->uid' and p.proctor_id=t.proctor_id and t.time_slot_id is null and op.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER') order by t.created_time asc"; 

$result2 = mysql_query($query2);

while($row2 = mysql_fetch_object($result2))
	$resultcopy2[] = $row2;	
	
$query3 = "select *, u.name as tti from hvcp.vcn_test_session t
inner join hvcp.vcn_proctor_time_slot s on t.TIME_SLOT_ID=s.TIME_SLOT_ID
inner join hvcp.vcn_proctor p 
inner join hvcp.vcn_office_partners op on p.office_id = op.office_id
inner join drupal.users u on t.test_taker_id = u.uid 
inner join hvcp.vcn_course c on t.question_set_id = c.drupal_test_id
where s.time_slot_date > curdate() and p.drupal_user_id='$user->uid' and p.proctor_id=s.proctor_id and op.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER') order by s.time_slot_date asc "; 

$result3 = mysql_query($query3);

while($row3 = mysql_fetch_object($result3))
	$resultcopy3[] = $row3;	

vcn_disconnect_from_db($conn);
?>



<br/><br/>
<strong>Following is the list of Tests to be proctored by you today (<?php echo date("F j, Y"); ?>)</strong>
<br/><br/>
<?php if (!count($resultcopy)): ?>

None

<?php else: ?>
<table class="sample"> 
<tr>
<td class="headtd" width="100">Date</td>
<td class="headtd" width="100">Start Time</td>
<td class="headtd" width="182">Student ID/Name</td>
<td class="headtd" width="315">Course Name</td>
<td class="headtd">Test Session Code</td>
</tr>
<?php foreach ($resultcopy as $row) {  ?>
<tr>
<td><?php $date = getdate(strtotime($row->TIME_SLOT_DATE)); $thedate=$date['mon'].'/'.$date['mday'].'/'.$date['year']; echo $thedate; ?></td>
<td><?php echo normaltime($row->START_TIME); ?></td>
<td><?php echo $row->tti; ?></td>
<td><?php echo $row->COURSE_TITLE; ?></td>
<td><?php echo $row->TEST_SESSION_ID; ?></td>
</tr>
<? } ?>
</table>
<?php endif; ?>
<br/><br/><br/>

<strong>Following is a list of Appointment requests made for you:</strong>
<br/>
<br/>(Please click on "Confirm" or "Reject" under Action for the pending request.)<br/><br/>
<?php if (!count($resultcopy2)): ?>

None

<?php else: ?>
<table class="sample"> 
<tr>
<td class="headtd" width="100">Date</td>
<td class="headtd" width="100">Start Time</td>
<td class="headtd" width="182">Student ID/Name</td>
<td class="headtd" width="315">Office Address</td>
<td class="headtd">Action</td>
</tr>
<?php foreach ($resultcopy2 as $row) {  ?>
<tr>
<td><?php $date = getdate(strtotime($row->ct)); $thedate=$date['mon'].'/'.$date['mday'].'/'.$date['year']; echo $thedate; ?></td>
<td></td>
<td><?php echo $row->tti; ?></td>
<td><?php $a1l = $row->ADDRESS." ".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; 
	if (strlen($row->CITY)&&strlen($row->STATE)) echo $row->ADDRESS."<br/>".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; ?></td>
<td><center>
<a onclick="return confirm('Are you sure you want to confirm this session?');" href="https://<?php echo $_SERVER['SERVER_NAME'].base_path(); ?>tests/proctor?tti=<?php echo $row->tti; ?>&courseid=<?php echo $row->DRUPAL_TEST_ID; ?>"><img alt="Confirm" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/tests/images/confirm.png" /></a>
<a onclick="return confirm('Are you sure you want to delete this session?');" href="https://<?php echo $_SERVER['SERVER_NAME'].base_path(); ?>tests/?delete=<?php echo $row->TEST_SESSION_ID; ?>"><img alt="Reject" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/tests/images/reject.png" /></a>
</center>
</td>
</tr>
<? } ?>
</table>
<?php endif; ?>
<br/><br/><br/>

<strong>Following is the list of Test sessions scheduled to be proctored by you in near future:</strong>
<br/>
<br/>(In case you cannot keep these dates, you may cancel the appointment by clicking on Cancel under Action for that session.)<br/><br/>
<?php if (!count($resultcopy3)): ?>

None

<?php else: ?>
<table class="sample"> 
<tr>
<td class="headtd" width="100">Date</td>
<td class="headtd" width="100">Start Time</td>
<td class="headtd" width="182">Student ID/Name</td>
<td class="headtd" width="315">Office Address</td>
<td class="headtd">Action</td>
</tr>
<?php foreach ($resultcopy3 as $row) {  ?>
<tr>
<td><?php $date = getdate(strtotime($row->TIME_SLOT_DATE)); $thedate=$date['mon'].'/'.$date['mday'].'/'.$date['year']; echo $thedate; ?></td>
<td><?php echo normaltime($row->START_TIME); ?></td>
<td><?php echo $row->tti; ?></td>
<td><?php $a1l = $row->ADDRESS." ".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; 
	if (strlen($row->CITY)&&strlen($row->STATE)) echo $row->ADDRESS."<br/>".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; ?></td>
<td><center><a onclick="return confirm('Are you sure you want to cancel this session?');" href="https://<?php echo $_SERVER['SERVER_NAME'].base_path(); ?>tests/?cancel=<?php echo $row->TEST_SESSION_ID; ?>&tsi=<?php echo $row->TIME_SLOT_ID; ?>"><img alt="Cancel" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/tests/images/cancel.png" /></a></center></td>
</tr>
<? } ?>
</table>
<?php endif; ?>


