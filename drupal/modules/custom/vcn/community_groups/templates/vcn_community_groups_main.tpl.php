<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
	$base_url = base_path();
	$path=$base_url . "/sites/all/themes/zen_hvcp/js/boxover.js";
	$path2=$base_url . "/sites/default/files/images/links/";
?>

<script type="text/javascript" src="<?php print $path ?>"></script>

<?php

	if(!function_exists('connectIt'))
	{
	include_once($base_url.'/default/hvcp.functions.inc');
	function connectIt()
	  {
          $dbserver = $GLOBALS['hvcp_config_db_server_name'];
          $dbuser = $GLOBALS['hvcp_config_db_username'];
          $dbpass = $GLOBALS['hvcp_config_db_password'];
          $dbname = $GLOBALS['hvcp_config_db_name'];

	  //For now, until we get the REST server set up, we'll just pull the data directly from the database
	  $connection=mysql_connect($dbserver,$dbuser,$dbpass)
		or die("Error making database connection: ".mysql_error());
	  $db=mysql_select_db($dbname,$connection)
		or die("Error selecting database: ".mysql_error());
	  return($connection);
	  }
	}

	$query="select * from vcn_site_resource where category_name='Community Group' and active_yn='Y' and resource_link_flag='1' order by resource_name asc";
	$connection=connectIt();
	$result=mysql_query($query);
	mysql_close($connection);
	
	$resultsArray=array();
	while($row=mysql_fetch_assoc($result))
	  {
	  extract($row);
	  $resultsArray[$RESOURCE_ID]=array('CATEGORY_NAME'=>$CATEGORY_NAME,
									   'RESOURCE_NAME'=>$RESOURCE_NAME,
									   'RESOURCE_LINK'=>$RESOURCE_LINK,
									   'RESOURCE_LINK_FLAG' => $RESOURCE_LINK_FLAG,
									   'ACTIVE_YN'=>$ACTIVE_YN);
	  if(strpos($resultsArray[$RESOURCE_ID]['RESOURCE_LINK'],"http://")===false) $resultsArray[$RESOURCE_ID]['RESOURCE_LINK']="http://".$resultsArray[$RESOURCE_ID]['RESOURCE_LINK'];
	  }
	  
	
?>
<br>
The following community groups allow you to discuss topics about specific careers and to get to know other people who are looking to get into the career or who have already been in the career for some time.
<br>
<br>
<table >

<?php 
	foreach($resultsArray as $result) {
?>
		<tr>
		
		<td><a href="javascript:popit('<?php print $result['RESOURCE_LINK'] ?>')"><?php print $result['RESOURCE_NAME'] ?></a></td>
		</tr>
<?php
	}
?>

</table>
          