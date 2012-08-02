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

$userid = $_GET['userid'];

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
$query = "SELECT   *
            FROM     vcn_cma_user_notebook
            WHERE    USER_ID = \"".$userid."\"";
	
$result = mysql_query($query)
or die("Error running query: ".mysql_error());

$rows=mysql_num_rows($result);
echo $rows;
//echo "rows are $rows <br />";

// close the mysql connection
mysql_close($connection);

?>