<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
require_once('../drupal/sites/default/hvcp.functions.inc');

$dbserver = $GLOBALS['hvcp_config_db_server_name'];
$dbuser = $GLOBALS['hvcp_config_db_username'];
$dbpass = $GLOBALS['hvcp_config_db_password'];
$dbname = $GLOBALS['hvcp_config_db_name'];

session_start();
session_save_path();
echo '>>>'.session_save_path().'<<<';
$con = mysql_connect($dbserver,$dbuser,$dbpass);
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}else {
	echo 'Connected <br />';
}
mysql_select_db($dbname, $con);


//To get the list of sessions users
$user_array = array();
// echo $sql_user = 'SELECT USER_ID, USER_SESSION, USER_SESSION_ID, CREATED_TIME, UPDATED_TIME FROM  vcn_cma_user where USER_SESSION = "S" AND UPDATED_TIME < (NOW()- INTERVAL 6 HOUR);' ;
echo $sql_user = 'SELECT USER_ID, USER_SESSION, USER_SESSION_ID, CREATED_TIME, UPDATED_TIME FROM  vcn_cma_user where USER_SESSION = "S" AND (USER_ID > 500 AND USER_ID < 700);' ;
// $sql_user = 'DELETE FROM vcn_cma_user WHERE user_id > 450 && user_id < 462;';
$userResult = mysql_query($sql_user);
//mysql_query('DELETE FROM vcn_cma_user WHERE user_id > 460 && user_id < 470;');
echo '--------------no of rows-------------------'.mysql_num_rows($userResult);
while($row = mysql_fetch_array($userResult)){
	print_r($row); echo'<br />';
	array_push($user_array, '\''.$row[0].'\'');
}


// List of table from which we want to delere record of session users
$table_list = array('vcn_cma_user_key', 'vcn_cma_user_notebook','vcn_cma_user_assessment','vcn_cma_user_association','vcn_cma_user_bookmark','vcn_cma_user_certificate','vcn_cma_user_course','vcn_cma_user_education','vcn_cma_user_employment','vcn_cma_user_license','vcn_cma_user_privacy_setting','vcn_cma_user_publication','vcn_cma_user_reference','vcn_cma_user_resume','vcn_cma_user_target_job','vcn_cma_user_test','vcn_provider_contact');
foreach($table_list as $key =>$value){
	$table_name = $value;
	$sql_session = 'SELECT * FROM '.$table_name.' WHERE USER_ID IN('. implode(',', $user_array).')';
	//$sql_session = 'DELETE FROM '.$table_name.' WHEREIN('. implode(',', $user_array).')';
	//echo '--------------query for the dependent tables-------------------'.$sql_session. '<br />';
	$sessionResult = mysql_query($sql_session);
	//echo '----------'.$table_name.'-----------'.'<br>';
	while($rows = mysql_fetch_array($sessionResult)){
		print_r($rows); echo"<br />";
		//echo $rows[0].'---'.$rows[1].'---'.$rows[2].'<br>';
	}
}
// some code

?>