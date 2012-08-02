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
			

	
if (strlen($_POST['proctorid']) && strlen($_POST['password'])) {

$conn = vcn_connect_to_db();
	
	$proctorid = $_POST['proctorid'];
	$password = $_POST['password'];
	$sid = $_POST['sid'];
	$tsi = $_GET['tsi'];
	
	$query0 = "SELECT * from drupal.users u 
left join hvcp.vcn_proctor p on p.DRUPAL_USER_ID = u.uid
right join hvcp.vcn_test_session s on s.PROCTOR_ID = p.PROCTOR_ID

where u.name='$proctorid' and s.test_session_id='$tsi'";
	$result0 = mysql_query($query0);

	$drupalpass='';
	while($row0 = mysql_fetch_object($result0)) {
		$drupalpass=$row0->pass;
		$newuid= $row0->uid;		
	}
	
	$query = "SELECT * from drupal.users where name='$sid'";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_object($result)) 
		$newsid=$row->uid;
		
	$query = "SELECT * from hvcp.vcn_test_session ts inner join hvcp.vcn_proctor_time_slot pts ON ts.TIME_SLOT_ID = pts.TIME_SLOT_ID  where ts.test_session_id='$tsi'";
	$result = mysql_query($query);	
	
	while($row = mysql_fetch_object($result)) {
		$qsi=$row->QUESTION_SET_ID;	
		$tsuser=$row->TEST_TAKER_ID;
		$testdate = $row->TIME_SLOT_DATE;
		$st = $row->START_TIME;
		$et = $row->END_TIME;
	}
	
	
	$query = "SELECT * from drupal.content_type_test_session where field_session_code_value='$tsi'";
	$result = mysql_query($query);
	
	$sesscount=0;
	$sesscount = mysql_num_rows($result);
	
	
	$query = "select * from drupal.node where nid='$qsi'";
	$result = mysql_query($query);	
	
	while($row = mysql_fetch_object($result)) 
		$testname=$row->title;
		
	

vcn_disconnect_from_db($conn);
		
$url = base_path().'node/'.$qsi.'/'.$newsid.'/'.$tsi.'/start';	
		
	if (md5($password)!=$drupalpass) {
		drupal_set_message(t("Incorrect proctor id / password entered."));
	}
	else if ($newsid!=$tsuser) {
		drupal_set_message(t("Incorrect student id entered."));
	}
	else if ($sesscount) {
		drupal_set_message(t("Session has expired."));
	}
	else  {
	
		add_proctored_test_session($tsi, $proctorid, $newsid, $sid, $qsi, $testname, $testdate, $st, $et);
	
		/*
		if ($user->uid) {
			require_once(drupal_get_path('module', 'user') . '/user.pages.inc');
			user_logout();
		}
		*/
		$params = array(
		'name'   => $proctorid,
		'pass'   => $password, // No need to hash the password
		'status' => 1, // Otherwise the user is blocked on creation
		);
		
		$account = user_authenticate($params);
		
		header('Location: '.$url);
	}
	
		
}

?>



<br/>To start the test, please validate the identity of the Test taker and enter the following

<br/><br/><br/>


<form action="<?php echo base_path(); ?>tests/initiation?tsi=<?php echo $_GET['tsi']; ?>" method="post">

<div>
<div style="float:left; width: 150px;">Proctor ID:</div>
<div><label><input name="proctorid" value="<?php echo $_POST['proctorid']; ?>" type="text" style="width:300px; float:left;" /></label></div>
</div>

<br/><br/>

<div>
<div style="float:left; width: 150px;">Proctor Password:</div>
<div><label><input name="password"  type="password" style="width:300px; float:left;" /></label></div>
</div>

<br/><br/>

<div>
<div style="float:left; width: 150px;">Test Session ID:</div>
<div><label><input name="tsi2" value="<?php echo $_GET['tsi']; ?>" type="text" style="width:300px; float:left;" value="<?php echo $_GET['tsi']; ?>" disabled="true"  /></label></div>
</div>

<br/><br/>

<div>
<div style="float:left; width: 150px;">Test Taker ID:</div>
<div><label><input name="sid" type="text" value="<?php echo $_POST['sid']; ?>" style="width:300px; float:left;" /></label></div>
</div>


<br/><br/>
<label><input type="hidden" name="tsi" id="tsi" value="<?php echo $_GET['tsi']; ?>" /></label>
<label><input type="image" alt="submit" value="Submit" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/tests/images/submit.png" /></label>

</form>