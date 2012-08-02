<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<!--div class="vcn-gs-heading">My Military Training</div-->

<?php

if(!function_exists('connectIt'))
{
function connectIt()
  {
  //extracting database
  $dbpull .= hvcp_get_db_url();
  $tempArr1=explode("/",$dbpull);
  $tempArr2=explode(":",$tempArr1[2]);
  $dbuser=$tempArr2[0];
  $tempArr3=explode("@",$tempArr2[1]);
  $dbpass=$tempArr3[0];
  $dbserver=$tempArr3[1].":3306";
  unset($tempArr1,$tempArr2,$tempArr3);

  //For now, until we get the REST server set up, we'll just pull the data directly from the database
  $connection=mysql_connect($dbserver,$dbuser,$dbpass)
    or die("Error making database connection: ".mysql_error());
  $db=mysql_select_db('hvcp',$connection)
    or die("Error selecting database: ".mysql_error());
  return($connection);
  }
}

/**
 * This next section gets the CMA User ID...
 */
global $user;
if($user->uid!=0) $userID=$user->uid;
else
  {
  $userID=session_id();
  if($userID=="")
    {
    $userID=$_COOKIE[session_name()];
    }
  }
$select="SELECT USER_ID FROM vcn_cma_user WHERE USER_SESSION_ID=\"$userID\"";
$connection=connectIt();
$result=mysql_query($select)
  or die("Error getting USER_ID from vcm_cma_user: ".mysql_error());
mysql_close($connection);
$row=mysql_fetch_assoc($result);
extract($row);
/**
 * end section that gets CMA User ID
 */

// get the last course for the user in the database
$select="SELECT MAX(USER_COURSE_ID) AS DB_LAST_COURSE FROM vcn_cma_user_course WHERE USER_ID=\"$USER_ID\" AND MILITARY_YN=\"Y\"";
$connection=connectIt();
$result=mysql_query($select)
  or die("Error selecting last user course".mysql_error());
mysql_close($connection);
if($row=mysql_fetch_assoc($result)) extract($row);
else $DB_LAST_COURSE="";

// set the last extracted courses
if($DB_LAST_COURSE!="")
  {
  $select="SELECT COURSE_CODE FROM vcn_cma_user_course WHERE USER_COURSE_ID=\"$DB_LAST_COURSE\"";
  $connection=connectIt();
  $result=mysql_query($select)
    or die("Error selecting info from last record: ".mysql_error);
  mysql_close($connection);
  $row=mysql_fetch_assoc($result);
  extract($row);
  }
else
  {
  $COURSE_CODE="";
  }

if($_POST['save']=="save")
  {
  $ace_id=$_POST['ace_id'];
  $start_date=$_POST['start_date'];
  $end_date=$_POST['end_date'];
  if($COURSE_CODE != $ace_id."|".$start_date."|".$end_date)
    {
    $insert="INSERT INTO vcn_cma_user_course (USER_ID,COURSE_CODE,MILITARY_YN) VALUES (\"$USER_ID\",\"".$ace_id."|".$start_date."|".$end_date."\",\"Y\")";
    $connection=connectIt();
    $result=mysql_query($insert) or die("Error selecting last military course id: ".mysql_error());
    mysql_close($connection);
    }
  }

$gsStepItemCount=count($_SESSION['gsStepCountArray']);
$gsPctDone=floor($gsStepItemCount/$vars['total_activities_count']*100);



if(!isset($_GET['ace_id']))
  {
  echo "
	<h4>College Courses for Military Training and Occupations</h4>
	<p>
	Have you served in the U.S. Armed Services or with the Department of Defense?  
	Your training and military occupational specialty (MOS) may have college credit recommendations 
	from American Council on Education (ACE). 
	<br />
	<p>
	<strong>Military Training</strong>
	<br/>
	Many colleges and universities recognize your military training when you provide them with 
	an official transcript from your service branch. 
    </p>";
  }


?>