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


$dbserver = $GLOBALS['hvcp_config_db_server_name'];

$dbuser = $GLOBALS['hvcp_config_db_username'];

$dbpass = $GLOBALS['hvcp_config_db_password'];

$dbname = $GLOBALS['hvcp_config_db_name'];


$link = mysql_connect($dbserver, $dbuser, $dbpass);

if (!$link) {

die('Could not connect: ' . mysql_error());

}

$qsi=$_GET['qsi'];
$tti=$_GET['tti'];
$pi=$_GET['pi'];
$oi=$_GET['oi'];
$tsi=$_GET['tsi'];

if (strlen($qsi) && strlen($tti) && strlen($pi) && strlen($oi) && strlen($tsi)) {
	$query = "SELECT * FROM hvcp.vcn_proctor_time_slot WHERE time_slot_id='".$tsi."'";
	$result = mysql_query($query);
	
	$count=0;
	while($row = mysql_fetch_object($result)) {
		$count = $row->NUMBER_OF_SESSIONS;
	}

	if ($count>=3 && $count>=0) {
		echo "toomany";
	}
	
	$query = "SELECT * FROM hvcp.vcn_test_session WHERE time_slot_id='".$tsi."' and test_taker_id='".$tti."'";
	$result = mysql_query($query);	
	
	while($row = mysql_fetch_object($result)) {
		echo "toomany";
		break;
	}	
	
}


mysql_close($link);

?>