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

$url = $_GET['url'];
$email = $_GET['email'];
$subject = $_GET['subject'];
$subject = str_replace('~', ' ', $subject);
$comment = $_GET['comment'];
$comment = str_replace('~', ' ', $comment);
$by = $_GET['by'];
$datetime = $_GET['datetime'];

$dbserver = $GLOBALS['hvcp_config_db_server_name'];
$dbuser = $GLOBALS['hvcp_config_db_username'];
$dbpass = $GLOBALS['hvcp_config_db_password'];
$dbname = $GLOBALS['hvcp_config_db_name'];

//For now, until we get the REST server set up, we'll just pull the data directly from the database
$connection=mysql_connect($dbserver,$dbuser,$dbpass)
or die("Error making database connection: ".mysql_error());
$db=mysql_select_db($dbname,$connection)
or die("Error selecting database: ".mysql_error());

// Here, we are loading up the questions for the assessment
$query="INSERT INTO vcn_comment (page_url, sender_email, subject, sender_comment, created_by, created_time) VALUES ('$url', '$email', '$subject', '$comment', '$by', '$datetime')";
$result=mysql_query($query)
or die("Error running query: ".mysql_error());
$row=mysql_fetch_assoc($result);

// Here, we are loading up the questions for the assessment
$query="SELECT   *
        FROM     vcn_app_properties
        WHERE    NAME = 'vcn_support_email' ";
$result=mysql_query($query) or die("Error running query: ".mysql_error());
$row=mysql_fetch_assoc($result);
 
$supportemail = $row['VALUE'];

// Email header
$header = "From: $email \r\n";
$header .= "Reply-To: $email \r\n";

if (strlen($email) > 0) {
	mail( $supportemail, 'Comment: '. $subject, $comment, $header );
}

mysql_close($connection);

?>
