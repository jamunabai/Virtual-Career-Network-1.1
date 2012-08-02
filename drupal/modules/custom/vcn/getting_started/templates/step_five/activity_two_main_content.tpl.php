<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

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

// Getting the CMA User ID...
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

// look for POSTed DELETE request...
if($_POST['function']=="delete")
  {
  $USER_COURSE_ID=$_POST['USER_COURSE_ID'];
  $delete="DELETE from vcn_cma_user_course
           WHERE USER_COURSE_ID=\"$USER_COURSE_ID\"";
//echo "Query is $delete <br /><br />";
  $connection=connectIt();
  $result=mysql_query($delete)
    or die("Error deleting course: ".mysql_error());
  mysql_close($connection);
  }



// get the last course for the user in the database
$select="SELECT MAX(USER_COURSE_ID) AS DB_LAST_COURSE FROM vcn_cma_user_course WHERE USER_ID=\"$USER_ID\"";
$connection=connectIt();
$result=mysql_query($select)
  or die("Error selecting last user course".mysql_error());
mysql_close($connection);
if($row=mysql_fetch_assoc($result)) extract($row);
else $DB_LAST_COURSE="";

// set the last extracted courses
if($DB_LAST_COURSE!="")
  {
  $select="SELECT COURSE_NAME,COURSE_CODE  FROM vcn_cma_user_course WHERE USER_COURSE_ID=\"$DB_LAST_COURSE\"";
  $connection=connectIt();
  $result=mysql_query($select)
    or die("Error selecting info from last record: ".mysql_error);
  mysql_close($connection);
  $row=mysql_fetch_assoc($result);
  extract($row);
  }
else
  {
  $COURSE_NAME="";
  $COURSE_CODE="";
  }

// testVal is to determine if all the blocks are filled in.  If set to 1, yes.  If set to 0, no.
$testVal=1;
$testArray=array("gs_schoolName","gs_courseName","gs_courseNumber","gs_courseYear","gs_creditHours","gs_courseGrade");
foreach($testArray as $testItem)
  {
  if(!isset($_POST[$testItem]) || $_POST[$testItem]=="") $testVal=0;
  else $$testItem=$_POST[$testItem];
  }

// Setting a global for activity 2 main detail.  Gina's framework doesn't carry PHP values between parts.
// It's an array, because all Drupal globals need to be an array.
$testValArray=array();
global $testValArray;
$testValArray['test1']=$testVal;

//testValTwo is to see if the POSTed course name and number match the last database value, avoiding duplicates.
$testValTwo=0;
if($_POST['gs_courseName']==$COURSE_NAME && $_POST['gs_courseNumber']==$COURSE_CODE) $testValTwo=1;

// If all values are posted and there's no duplication between POSTed values and last retrieved DB values,
// then add the values to the database.
if($testVal==1 && $testValTwo==0)
  {
  $courseDate=$gs_courseYear."-01-01";
  $insert="INSERT INTO vcn_cma_user_course
           (USER_ID,INSTITUTION_NAME,COURSE_NAME,COURSE_CODE,DATE_COMPLETED,COURSE_CREDIT,COURSE_GRADE)
           VALUES
           (\"$USER_ID\",\"$gs_schoolName\",\"$gs_courseName\",\"$gs_courseNumber\",\"$courseDate\",\"$gs_creditHours\",\"$gs_courseGrade\")";
  $connection=connectIt();
  $result=mysql_query($insert)
    or die("Error performing insert: ".mysql_error());
  mysql_close($connection);
  foreach($testArray as $testItem) unset($_POST[$testItem]);
  }

$gsStepItemCount=count($_SESSION['gsStepCountArray']);
$gsPctDone=floor($gsStepItemCount/$vars['total_activities_count']*100);


?>

<!--div class="vcn-gs-heading">My College Courses</div-->

<h4>College Course Credit</h4>
<p>
Have you already taken college courses? If you earned a minimum grade of "C", you may be able to 
transfer these courses to your chosen degree program.
</p>
<p>
Colleges require an official record, or transcript, from every college you have attended in order 
to transfer the courses that apply to your intended program. 
</p>
<p>
<a href="javascript:popit('http://www.drexel.com/tools/transcript.aspx?process=alpha&letter=A')">Click here</a> 
to find the colleges you have attended and learn how to order a transcript. Before you 
order and pay for an official transcript, which usually costs between $5 -$20, find out if you can 
obtain an unofficial transcript free of charge. 
</p>
<p>
Give the academic advisor of your intended program as much information as you can about your prior 
college courses through unofficial transcripts.  If you are unable to get unofficial transcripts or
want to show all of the courses you have taken (from multiple schools) in one report, enter the 
information you remember about those courses below. 
<p>
