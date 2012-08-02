<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?
if(isset($_GET['docid']))
	{

	require_once('../drupal/sites/default/hvcp.functions.inc');

	$dbserver = $GLOBALS['hvcp_config_db_server_name'];
	$dbuser = $GLOBALS['hvcp_config_db_username'];
	$dbpass = $GLOBALS['hvcp_config_db_password'];
	$dbname = $GLOBALS['hvcp_config_db_name'];
	//For now, until we get the REST server set up, we'll just pull the data directly from the database
	$connection=mysql_connect($dbserver,$dbuser,$dbpass)
	or die("Error making database connection: ".mysql_error());
	$db=mysql_select_db($dbname,$connection)
	or die("Error selecting database: ".mysql_error());
	// query the server for the picture
	$docid = $_GET['docid'];


	$query = "SELECT * FROM vcn_cma_user_document WHERE document_id = '$docid'";
	$result  = mysql_query($query) or die(mysql_error());


	// define results into variables
	$name=mysql_result($result,0,"DOCUMENT_TITLE");
	$type=mysql_result($result,0,"DOCUMENT_TYPE_ID");
	$content=mysql_result($result,0,"DOCUMENT_OBJECT");
	$content = base64_decode($content);
	//$content = str_replace("XpandGanappaReston2012","'",$content);

	if($type == '2'){$typemodified = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";} 
	elseif($type ==  '3'){$typemodified = "application/vnd.ms-powerpoint";}
	elseif($type ==  '4'){$typemodified = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";}
	elseif($type ==  '5'){$typemodified = "image/png";}
	elseif($type ==  '6'){$typemodified = "text/plain";}
	elseif($type ==  '7'){$typemodified = "application/zip";}
	elseif($type ==  '8'){$typemodified = "application/pdf";}
	else{$typemodified = "";}

	header("Content-Disposition: attachment; filename=$name");
	header("Content-type: $typemodified");
	header("Content-Description: PHP Generated Data");
	header("Content-Length: ".strlen($content));
	
	echo $content;

	mysql_close();
}else{
	die("No file ID given...");
}

?> 