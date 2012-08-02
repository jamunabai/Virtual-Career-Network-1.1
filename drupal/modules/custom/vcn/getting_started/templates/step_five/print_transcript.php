<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
// debug is set to 1 to follow tracking of generic variables
// debug is set to 2 to track military variables
$debug=0;

/** Loading initial bootstrap so we can pull from drupal's user table **/
chdir('../../../../../../../..'); //the Drupal root, relative to the directory of the path
require_once './includes/bootstrap.inc';
require_once './includes/common.inc';
require_once './includes/module.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

if($debug==1) echo "db url is $db_url<br />";

// because this isn't in the drupal system per se, it pulls a UID of 0, regardless of whether the person is logged in or not.
// so we pass it from the drupal system instead.
$drupalID=$_POST['drupalID'];
if($debug==1) echo "Drupal ID is $drupalID<br />";

/**Begin Function**/
if(!function_exists('connectIt'))
{
include_once('../../../../../../../default/hvcp.functions.inc');
function connectIt()
  {
  //extracting database
  $dbpull = hvcp_get_db_url();
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
/**End Functions**/

$USER_ID=$_POST['cma'];

$query="SELECT FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,HOME_PHONE,CELL_PHONE FROM vcn_cma_user WHERE USER_ID=\"$USER_ID\"";
$query2="SELECT ITEM_TYPE,ITEM_ID FROM vcn_cma_user_notebook WHERE USER_ID=\"$USER_ID\" AND (ITEM_TYPE=\"PROGRAM\" OR ITEM_TYPE=\"OCCUPATION\") AND ITEM_RANK=\"1\"";
if($debug==1) echo "$query2 <br />";
$connection=connectIt();
$result=mysql_query($query) or die("error getting CMA information: ".mysql_error());
$result2=mysql_query($query2) or die("error extracting information from CMA notebook: ".mysql_error());
mysql_close($connection);
$row=mysql_fetch_assoc($result);
extract($row);
while($row2=mysql_fetch_assoc($result2))
  {
  extract($row2);
  if($ITEM_TYPE=="OCCUPATION")
    {
    $select3="SELECT ONET_TITLE AS careerTitle FROM vcn_cma_occupation WHERE ONETCODE=\"$ITEM_ID\"";
    if($debug==1) echo "select 3 statement is $select3 <br />";
    $connection=connectIt();
    $result3=mysql_query($select3) or die("error selecting from vcn_cma_occupation table: ".mysql_error());
    mysql_close($connection);
    $row3=mysql_fetch_assoc($result3);
    extract($row3);
    //echo "Career Extracted as $careerTitle<br />";
    }
  if($ITEM_TYPE=="PROGRAM")
    {
    $select4="SELECT PROGRAM_NAME AS programTitle FROM vcn_program WHERE PROGRAM_ID=\"$ITEM_ID\"";
    if($debug==1) echo "select 4 is $select4 <br />";
    $connection=connectIt();
    $result4=mysql_query($select4) or die("error selecting from vcn_program table: ".mysql_error());
    mysql_close($connection);
    $row4=mysql_fetch_assoc($result4) or die("error during extraction: ".mysql_error());
    extract($row4);
    }
  }
//if($programTitle=="")$programTitle="None Targeted";
//if($careerTitle=="")$careerTitle="None Targeted";

if($debug==1) echo "email address from query is $EMAIL_ADDRESS <br />";
if($drupalID != 0 && $EMAIL_ADDRESS=="")
  {
  if($debug==1) echo "attempting email extraction<br />";
  $connection=connectIt();
  $db=mysql_select_db('drupal',$connection) or die("Error selecting database: ".mysql_error());
  $query="SELECT mail as EMAIL_ADDRESS FROM users WHERE uid=\"$drupalID\"";
  if($debug==1)echo "email query is $query <br />";
  $result=mysql_query($query);
  mysql_close($connection);
  $row=mysql_fetch_assoc($result);
  if($debug==1) echo "Item count is ".count($result)." <br />";
  extract($row);
  if($debug==1) echo "Email address attempted extraction ($EMAIL_ADDRESS) <br />";
  }

//get the SOC code for now.  We'll eventually replace with O*Net codes.
$SOC=substr($ITEM_ID,0,7);
if($debug==2) echo "SOC is $SOC<br />";

/** for doing SOC/CIP comparison **/
$socCipArray[]="15-1121,11";
$socCipArray[]="15-2041,26,27,45,52";
$socCipArray[]="19-2041,3,30,40,51";
$socCipArray[]="19-4011,1";
$socCipArray[]="19-4092,40,43";
$socCipArray[]="21-1015,51";
$socCipArray[]="21-1022,44,51";
$socCipArray[]="29-1031,19,51";
$socCipArray[]="29-1071,51,26";
$socCipArray[]="29-1122,51,26";
$socCipArray[]="29-1123,51,26";
$socCipArray[]="29-1124,51,26";
$socCipArray[]="29-1125,51,26";
$socCipArray[]="29-1126,51,26";
$socCipArray[]="29-1141,51,26";
$socCipArray[]="29-1151,51,26";
$socCipArray[]="29-1171,51,26";
$socCipArray[]="29-1181,51,26";
$socCipArray[]="29-2011,51,26";
$socCipArray[]="29-2012,51,26";
$socCipArray[]="29-2021,51";
$socCipArray[]="29-2031,51,26";
$socCipArray[]="29-2032,51,26";
$socCipArray[]="29-2033,51,26";
$socCipArray[]="29-2034,51,26";
$socCipArray[]="29-2041,51,26";
$socCipArray[]="29-2051,19,30,51";
$socCipArray[]="29-2052,51";
$socCipArray[]="29-2053,51";
$socCipArray[]="29-2054,51,26";
$socCipArray[]="29-2055,51,26";
$socCipArray[]="29-2061,51,26";
$socCipArray[]="29-2071,51";
$socCipArray[]="29-2081,51,26";
$socCipArray[]="29-2091,51,26";
$socCipArray[]="29-2092,51";
$socCipArray[]="29-2099,51,26";
$socCipArray[]="29-9012,51";
$socCipArray[]="29-9092,51,26";
$socCipArray[]="29-9099,51,26";
$socCipArray[]="31-1011,51";
$socCipArray[]="31-1013,51";
$socCipArray[]="31-2011,51";
$socCipArray[]="31-2012,51";
$socCipArray[]="31-2021,51,26";
$socCipArray[]="31-2022,51,26";
$socCipArray[]="31-9011,51,26";
$socCipArray[]="31-9091,51";
$socCipArray[]="31-9092,51,26";
$socCipArray[]="31-9093,51";
$socCipArray[]="31-9094,51";
$socCipArray[]="31-9095,none";
$socCipArray[]="31-9099,51,26";
$socCipArray[]="39-9021,51";
$socCipArray[]="39-9031,13,31";
$socCipArray[]="43-4051,52";
$socCipArray[]="43-6013,51";
$socCipArray[]="49-9062,15";
$socCipArray[]="51-9081,51";
$socCipArray[]="51-9082,51";
$socCipArray[]="51-9083,51";
$socCipArray[]="53-3011,51";
if($debug==2)
  {
  foreach($socCipArray as $socCipItem)
    {
    if(substr($socCipItem,0,7)==$SOC) echo "Match line is $socCipItem<br />";
    }
  }
/** end load of SOC/CIP mapping data **/

/** mapping for General Credit **/
$CipGeneralCredit="11,16,23,26,27,38,40,42,45,54";
$GeneralCreditArray=explode(",",$CipGeneralCredit);
/** end General Credit Mapping **/

/** Sorting Military Credits **/
//the array we assign credit "buckets" to
$milCredSortArray=array();

//First, we get all saved Course numbers
$query1="
  SELECT  COURSE_CODE
  FROM    vcn_cma_user_course
  WHERE   USER_ID=\"$USER_ID\"
  AND     MILITARY_YN=\"Y\"";
$connection=connectIt();
$result1=mysql_query($query1) or die("error getting military courses: ".mysql_error());
mysql_close($connection);
$countMil=mysql_num_rows($result1);
if($debug==2) echo "There are $countMil rows to process<br />";
$milCourseCredit=0;
while($row1=mysql_fetch_assoc($result1))
  {
  extract($row1);
  //MilCipNum is the key for the third query
  $MilCipNum=str_replace("|","-",$COURSE_CODE);
  // we get ACE ID, start date and end date for keys
  $parseArray=explode("|",$COURSE_CODE);
  $ace_id=$parseArray[0];
  $start_date=$parseArray[1];
  $end_date=$parseArray[2];

  //here we get credit specifics
  $query2="
    SELECT  a.first_title, a.second_title, a.objective, a.instruction, b.course_credit,b.course_credit_unit,b.course_credit_level,b.course_subject
    FROM    vcn_ace_course a, vcn_ace_course_credit b
    WHERE   a.ace_id=b.ace_id
    AND     a.start_date=b.start_date
    AND     a.end_date=b.end_date
    AND     a.ace_id=\"$ace_id\"
    AND     a.start_date=\"$start_date\"
    AND     a.end_date=\"$end_date\"
    ";
  $connection=connectIt();
  $result2=mysql_query($query2) or die("error getting military credit details: ".mysql_error());
  mysql_close($connection);
  $test_title="";

  // get the CIP codes that correspond to the military course
  $query3="SELECT cip FROM vcn_military_cip WHERE MILITARY_COURSE_ID=\"$MilCipNum\"";
  $connection=connectIt();
  $result3=mysql_query($query3);
  mysql_close($connection);
  if(!isset($MilCipArray))$MilCipArray=array();
  while($row3=mysql_fetch_assoc($result3))
    {
    extract($row3);
    if($debug==2) echo "Mil CIP from database is $cip<br />";
    if(!isset($MilCipArray[$MilCipNum])) $MilCipArray[$MilCipNum]=array();
    $MilCipArray[$MilCipNum][]=$cip;
    } // end while($row3=mysql_fetch_assoc($result3))

  while($row2=mysql_fetch_assoc($result2))
    {
    extract($row2);
    if($debug==2) echo "<b>$course_subject:</b> $course_credit $course_credit_unit<br />";

    //used to determine which bin it goes
    $bucketSort=0;

    // find the correct CIPs for the targeted career(SOC), if CIPS match CIPS for military
    // courses, then they are career specific credits
    foreach($socCipArray as $socCipItem)
      {
      //first, see if the SOC matches
      $socArray=explode(",",$socCipItem);
      //if we have a match...
      if($socArray[0]==$SOC)
        {
        //pop off the SOC, leaving only the CIPs
        array_shift($socArray);
        //$match removes dupes
        $match=0;
        //next, check it against the Mil CIP array
        foreach($socArray as $socItem)
          {
          if(!isset($credSpecCount))$credSpecCount=0;
          foreach($MilCipArray[$MilCipNum] as $MilCip)
            {
            //if we have a match and it isn't a dupe...
            if($MilCip==$socItem && $match==0)
              {
              if($debug==2) echo "Cred count is $credSpecCount<br />";
              // set the match to unique
              $match=1;
              //tag bucketSort, so we don't process it beyond a Career Field match
              $bucketSort=1;
              if($debug==2) echo "Military CIP $MilCip matches Targeted Occupation CIP of $socItem <br />";
              //initialize sub array if it isnt' intialized
              if(!isset($milCredSortArray['creditSpecific']))
	        {
	        $milCredSortArray['creditSpecific']=array();
	        if($debug==2) echo "credit specific array bucket initialized <br />";
	        }
              if(!isset($milCredSortArray['creditSpecific'][$COURSE_CODE])) $milCredSortArray['creditSpecific'][$COURSE_CODE]=array();
              $milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['title']=$first_title;
              if($debug==2)echo "\$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['title'] is set to ".$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['title']."<br />";
              $milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['subject']=$course_subject;
              if($debug==2)echo "\$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['subject'] is set to ".$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['subject']."<br />";
              $milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['credit']=$course_credit;
              if($debug==2)echo "\$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['credit'] is set to ".$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['credit']."<br />";
              $milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['creditUnit']=$course_credit_unit;
              if($debug==2)echo "\$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['creditUnit'] is set to ".$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['creditUnit']."<br />";
              $milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['second_title']=$second_title;
              if($debug==2)echo "\$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['second_title'] is set to ".$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['second_title']."<br />";
              $milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['objective']=$objective;
              if($debug==2)echo "\$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['objective'] is set to ".$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['objective']."<br />";
              $milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['instruction']=$instruction;
              if($debug==2)echo "\$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['instruction'] is set to ".$milCredSortArray['creditSpecific'][$COURSE_CODE][$credSpecCount]['instruction']."<br />";
              $credSpecCount++;
              }// end if($MilCip==$socItem)
            }// end foreach($MilCipArray[$MilCipNum] as $MilCip)
          }// end foreach($socArray as $socItem)
        }// end if($socArray[0]==$SOC)
      }// end foreach($socCipArray as $socCipItem)

    //we don't have career specific credits, so now we check for general education credits
    if($bucketSort==0)
      {
      if($debug==2) echo "No Career Match.  Trying General Education Credit<br />";
      $match2=0;
      if(!isset($genCredCount)) $genCredCount=0;
      foreach($MilCipArray[$MilCipNum] as $milCIP)
        {
        foreach($GeneralCreditArray as $creditItem)
          {
          //if theres a match and it's unique
          if($creditItem==$milCIP && $match2==0)
            {
            $match2=1;
            if($debug==2) echo "General credit is matched for $milCIP<br />";
            $bucketSort=1;
            if(!isset($milCredSortArray['general'])) $milCredSortArray['general']=array();
            if(!isset($milCredSortArray['general'][$COURSE_CODE])) $milCredSortArray['general'][$COURSE_CODE]=array();
            $milCredSortArray['general'][$COURSE_CODE][$genCredCount]['title']=$first_title;
            if($debug==2) echo "\$milCredSortArray['general'][$COURSE_CODE][$genCredCount]['title'] is being set to ".$milCredSortArray['general'][$COURSE_CODE][$genCredCount]['title']."<br />";
            $milCredSortArray['general'][$COURSE_CODE][$genCredCount]['subject']=$course_subject;
            $milCredSortArray['general'][$COURSE_CODE][$genCredCount]['credit']=$course_credit;
            $milCredSortArray['general'][$COURSE_CODE][$genCredCount]['creditUnit']=$course_credit_unit;
            $milCredSortArray['general'][$COURSE_CODE][$credSpecCount]['second_title']=$second_title;
            $milCredSortArray['general'][$COURSE_CODE][$credSpecCount]['objective']=$objective;
            $milCredSortArray['general'][$COURSE_CODE][$credSpecCount]['instruction']=$instruction;
            $genCredCount++;
            }
          }//end foreach($GeneralCreditArray as $creditItem)
        }// end foreach($MilCipArray[$MilCipNum] as $milCIP)
      }// end if($bucketSort==0) matching general electives

    // What's left are elective credits, if any credits at all...
    if($bucketSort==0 && $COURSE_CODE!="")
      {
      if($debug==2) echo "No General Education Credits.  Putting them in Electives<br />";
      if(!isset($milCredSortArray['elective']))
        {
        $milCredSortArray['elective']=array();
        if($debug==2) echo "Elective array initialized <br />";
        }
      if(!isset($lastname))$lastname="";
      if(!isset($milCredSortArray['elective'][$COURSE_CODE])) $milCredSortArray['elective'][$COURSE_CODE]=array();
      if(isset($milCredSortArray['elective'][$COURSE_CODE]))
        {
        $ccCountName=$COURSE_CODE."_Count";
        if(!isset($$ccCountName)) $$ccCountName=0;
        $milCredSortArray['elective'][$COURSE_CODE][$$ccCountName]['title']=$first_title;
        if($debug==2) echo "setting \$milCredSortArray['elective'][$COURSE_CODE][".$$ccCountName."]['title'] to ".$milCredSortArray['elective'][$COURSE_CODE][$$ccCountName]['title']."<br />";
        $milCredSortArray['elective'][$COURSE_CODE][$$ccCountName]['subject']=$course_subject;
        $milCredSortArray['elective'][$COURSE_CODE][$$ccCountName]['credit']=$course_credit;
        $milCredSortArray['elective'][$COURSE_CODE][$$ccCountName]['creditUnit']=$course_credit_unit;
        $milCredSortArray['elective'][$COURSE_CODE][$credSpecCount]['second_title']=$second_title;
        $milCredSortArray['elective'][$COURSE_CODE][$credSpecCount]['objective']=$objective;
        $milCredSortArray['elective'][$COURSE_CODE][$credSpecCount]['instruction']=$instruction;
        $$ccCountName++;
        }
      } // end if($bucketSort==0 && $COURSE_CODE!="")
    } // end while($row2=mysql_fetch_assoc($result2))
  } // while($row1=mysql_fetch_assoc($result1))
/** end Military Credit Sorting **/

if($debug==2)
  {
  echo "<pre>";
  print_r($milCredSortArray);
  echo "</pre>";
  }

if($FIRST_NAME=="" && $LAST_NAME=="") $name="";
  else $name="$FIRST_NAME $LAST_NAME";  

$dateArr = getdate();
$currentDate = $dateArr['month'] . ' ' . $dateArr['mday'] . ', ' . $dateArr['year'];

/** the actual data layout starts here **/
echo "
<html>
<head>
<title>My Learning Inventory</title>
<style type=\"text/css\">
table
  {
  border-collapse: collapse;
  table-layout: fixed;
  }

table, td, th
  {
  border:2px solid black;
  font-size:12px;
  }

th, td
  {
  column-width: 200px;
  }

.container
  {
  padding: 50px;
  font-family: verdana;
  }

.lightGray
  {
  background-color: #f2f2f2;
  }

.midGray
  {
  background-color: #d9d9d9;
  }

.darkGray
  {
  background-color: #bfbfbf;
  }
</style>
</head>
<body>
<div class=\"container\">";

echo "<div style=\"padding-left: 10px; padding-right: 10px;  font-family: verdana; font-size: 12px; \">
<b>Learning Inventory: My Information</b>
<br /><br />
</div>";

echo "<div style=\"padding-left: 10px; padding-right: 10px; font-family: verdana; font-size: 12px;\">";
echo "<div style=\"float:left;  font-family: verdana; font-size: 12px; width: 45%\">";
echo "<b>Name: </b>";
echo "$name<br />";
echo "<b>Home Phone: </b>";
      echo $HOME_PHONE;
      echo "<br />";
echo "<b>Selected Career: </b>$careerTitle<br />";
echo "</div>";

//echo "<div style=\"padding-right: 50px; font-family: verdana; font-size: 12px; width:50%\">";
echo "<div style=\"font-family: verdana; font-size: 12px;\">";
echo "<b>Email address: </b>";
      if($EMAIL_ADDRESS=="") echo "";
      else echo $EMAIL_ADDRESS;
      echo "<br />";
echo "<b>Cell Phone: </b>";
      echo $CELL_PHONE;
      echo "<br />";
echo "<b>Selected Program: </b>$programTitle<br />";
echo "</div>";
echo "</div>";



//echo "<div>";
echo "<br/><br/><div style=\"padding-left: 10px; padding-right: 10px;  font-family: verdana; font-size: 12px; \">";
echo "<b>ACE Credit Recommendation for College/Military/Employer Trainings</b>";
echo "<br /><br />";
echo "<table style=\"width:100%; padding-left: 10px; padding-right: 10px;\">";

/** Column Headings **/
echo "<table>";
echo "
  <tr class=\"lightGray\">
    <th width=\"13%\">My Competency Areas</th>
    <th width=\"29%\">My College Courses</th>
    <th width=\"29%\">ACE Credit Recommendations for Military Training/Careers</th>
    <th width=\"29%\">ACE Credit Recommendations for Employer Training</th>
  </tr>";


/** General Education Row **/
$gedEdRowCredits=0;
echo "
  <tr class=\"midGray\">
    <td width=\"13%\"><b>General Education</b></td>";

// College Courses
$query="SELECT * FROM vcn_cma_user_course WHERE USER_ID=\"$USER_ID\" AND MILITARY_YN is NULL";
$connection=connectIt();
$result=mysql_query($query) or die("Error Extracting College Course Data: ".mysql_error());
mysql_close($connection);
$creditTotal=0;
$countGen=mysql_num_rows($result);
if($countGen==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">";
while($row=mysql_fetch_assoc($result))
  {
  extract($row);
  if($MILITARY_YN==NULL)
    {
    echo "<b>Course:</b> $COURSE_NAME $COURSE_CODE<br /><b>Credit Hours:</b> $COURSE_CREDIT<br /><br />";
    $creditTotal = $creditTotal + $COURSE_CREDIT;
    $genEdRowCredits = $genEdRowCredits + $COURSE_CREDIT;
    }
  }
echo "</td>";

// Military Courses
if($countMil==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">";
if(isset($milCredSortArray['general']))
  {
  foreach($milCredSortArray['general'] as $genArray1)
    {
    $testname="";
    foreach($genArray1 as $genArray)
      {
      if($genArray['title']!=$testname)
        {
        echo "<b>".$genArray['title']."</b><br />";
        $testname=$genArray['title'];
        }
      if(strlen($genArray['subject'])){
      	echo ucfirst(strtolower($genArray['subject'])).": ".$genArray['credit']." ".$genArray['creditUnit']."<br />";
      }
      $milCourseCredit=$milCourseCredit + $genArray['credit'];
      $genEdRowCredits = $genEdRowCredits + $genArray['credit'];
      }
    echo "<br />";
    }
  }
echo "</td>";

// Business Courses
$query1="
  SELECT  COURSE_CODE
  FROM    vcn_cma_user_course
  WHERE   USER_ID=\"$USER_ID\"
  AND     MILITARY_YN=\"C\"";
$connection=connectIt();
$result1=mysql_query($query1) or die("error getting military courses: ".mysql_error());
mysql_close($connection);
$countBus=mysql_num_rows($result1);
if($countBus==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">";

$busCourseCredit=0;
while($row1=mysql_fetch_assoc($result1))
  {
  extract($row1);
  $parseArray=explode("|",$COURSE_CODE);
  $ace_id=$parseArray[0];
  $start_date=$parseArray[1];
  $end_date=$parseArray[2];

  $query2="
    SELECT  a.first_title, b.course_credit,b.course_credit_unit,b.course_credit_level,b.course_subject
    FROM    vcn_ace_national_course a, vcn_ace_national_course_credit b
    WHERE   a.ace_id=b.ace_id
    AND     a.start_date=b.start_date
    AND     a.end_date=b.end_date
    AND     a.ace_id=\"$ace_id\"
    AND     a.start_date=\"$start_date\"
    AND     a.end_date=\"$end_date\"
    ";
  $connection=connectIt();
  $result2=mysql_query($query2) or die("error getting military credit details: ".mysql_error());
  mysql_close($connection);
  $test_title="";
  while($row2=mysql_fetch_assoc($result2))
    {
    extract($row2);
    if($first_title != $test_title)
      {
      echo "<b>$first_title:</b><br />";
      $test_title=$first_title;
      }
    if(strlen($course_subject)){
    	echo ucfirst(strtolower($course_subject)).": ". $course_credit." ".$course_credit_unit."<br />";
    }  
    $busCourseCredit = $busCourseCredit + $course_credit;
    }
  echo "<br />";
  }
echo "</td>";

// End Row
echo "</tr>";


/** Career Field Row **/
$careerFieldRow=0;
echo "
  <tr class=\"lightGray\">
    <td width=\"13%\"><b>Career Field</b><br /><br /></td >";
if($countGen==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">";
echo "&nbsp;</td>";

if($countMil==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">";
if(isset($milCredSortArray['creditSpecific']))
  {
  foreach($milCredSortArray['creditSpecific'] as $specArray1)
    {
    $testname="";
    foreach($specArray1 as $specArray)
      {
      if($specArray['title']!=$testname)
        {
        echo "<b>".$specArray['title']."</b><br />";
        $testname=$specArray['title'];
        }
      if(strlen($specArray['subject'])){
        	echo ucfirst(strtolower($specArray['subject'])).": ".$specArray['credit']." ".$specArray['creditUnit']."<br />";
      }
      
      $milCourseCredit=$milCourseCredit + $specArray['credit'];
      $careerFieldRow = $careerFieldRow + $specArray['credit'];
      }
    echo "<br />";
    }
  }
echo "&nbsp;</td>";

if($countBus==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">";
echo "&nbsp;</td>
  </tr>";


/** Electives Row **/
$elecRowCredits=0;
echo "
  <tr class=\"midGray\">
    <td width=\"13%\"><b>Electives<br /><br /></b></td >";
if($countGen==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">";
echo "&nbsp;</td>";

if($countMil==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">";
$testname="";
if(isset($milCredSortArray['elective']))
  {
  foreach($milCredSortArray['elective'] as $elecArray1)
    {
    foreach($elecArray1 as $elecArray)
      {
      if($elecArray['title']!=$testname)
      {
        echo "<b>".$elecArray['title']."</b><br />";
        $testname=$elecArray['title'];
      }
      if(strlen($elecArray['subject'])) {
      	echo ucfirst(strtolower($elecArray['subject'])).": ".$elecArray['credit']." ".$elecArray['creditUnit']."<br />";
      }
      $milCourseCredit=$milCourseCredit + $elecArray['credit'];
      $elecRowCredits = $elecRowCredits + $elecArray['credit'];
      }
    echo "<br />";
    }
  }
echo "&nbsp;</td>";

if($countBus==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">";
echo "&nbsp;</td>
  </tr>";


/** Credit Hours Estimate Row **/
echo "
  <tr class=\"lightGray\">
    <td width=\"13%\"><b>Credit Hour Estimate<br /><br /></b></td >";
if($countGen==0) echo "<td class=\"darkGray\" align=\"center\" width=\"29%\">$creditTotal Hours</td>";
else echo "<td align=\"center\" width=\"29%\">$creditTotal Hours</td>";
if($countMil==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">$milCourseCredit Hours";
echo "&nbsp;</td>";
if($countBus==0) echo "<td class=\"darkGray\" width=\"29%\">";
else echo "<td width=\"29%\">$busCourseCredit Hours";
echo "&nbsp;</td>
  </tr>";

echo "</table>";
echo "</div><br/><br/>";


/** National Exams **/
echo "<div style=\"padding-left: 10px; padding-right: 10px;  font-family: verdana; font-size: 12px; \">";
echo "<b>ACE Credit Information for National Examinations</b>";
echo "<br /><br />";
echo "</div>";

echo "<div style=\"padding-left: 10px; padding-right: 10px;  font-family: verdana; font-size: 12px; \">";
echo "<table >";
echo "<tr><th width=\"15%\">Test Provider</th><th width=\"35%\">Title</th><th width=\"50%\">Credit Information</th></tr>";

$select="SELECT * FROM vcn_cma_user_course WHERE USER_ID=\"$USER_ID\" AND MILITARY_YN=\"E\" ";
$connection=connectIt();
$result=mysql_query($select) or die("Error selecting national exams from user course table: ".mysql_error());
mysql_close($connection);
while($row=mysql_fetch_assoc($result))
  {
  extract($row);
  $courseInfo=explode("|",$COURSE_CODE);
  $select2="SELECT credit_info
            FROM   vcn_ace_national_exam_credit
            WHERE  ace_id=\"".$courseInfo[0]."\"
            AND    start_date=\"".$courseInfo[1]."\"
            AND    end_date=\"".$courseInfo[2]."\"
            ";
  $select3="SELECT first_title
            FROM   vcn_ace_national_course
            WHERE  ace_id=\"".$courseInfo[0]."\"
	    AND    start_date=\"".$courseInfo[1]."\"
	    AND    end_date=\"".$courseInfo[2]."\"
            ";
  $ace_code_array=explode("-",$courseInfo[0]);
  $select4="SELECT company_name
            FROM vcn_ace_national_course_company
            WHERE ace_type=\"exam\"
            AND ace_code=\"".$ace_code_array[0]."\"";
  $connection=connectIt();
  $result2=mysql_query($select2) or die("Cannot get exam credit info: ".mysql_error());
  $result3=mysql_query($select3) or die("Cannot get exam title: ".mysql_error());
  $result4=mysql_query($select4) or die("Cannot get company title: ".mysql_error());
  mysql_close($connection);
  $row2=mysql_fetch_assoc($result2);
  extract($row2);
  $row3=mysql_fetch_assoc($result3);
  extract($row3);
  $row4=mysql_fetch_assoc($result4);
  extract($row4);
  echo "<tr>";
  //echo "<div style=\"padding-left: 50px; padding-right: 50px;  font-family: verdana; font-size: 12px; \">";
  echo "<td width=\"15%\">$company_name</td>";
  echo "<td width=\"35%\">$first_title</td>";
  echo "<td width=\"50%\">$credit_info</td>";
  //echo "</div>";
  echo "</tr>";
  }

echo "</table>";
echo "</div>";
echo "</body>";

echo "<div style=\"padding-left: 10px; padding-right: 10px;  font-family: verdana; font-size: 12px; \">";
echo "<br /><br /><br /><b>Details of Courses Referred Above</b>";
echo "<br /><br />";
echo "</div>";

echo "<div style=\"padding-left: 10px; padding-right: 10px;  font-family: verdana; font-size: 12px; \">";
/** Details for Courses **/

foreach($milCredSortArray as $bucket)
  {
  $bucketTest="";
  $bucketVal="";
  foreach($bucket as $milCourseSet)
    {
    	if ($bucketVal != $bucketTest) {
    		echo "<br /><hr /><br />";
    		$bucketVal = $bucketTest;
    	}
	$mcicount=0;
	$mciar=array();
    foreach($milCourseSet as $milCourseItem)
      {
		$mcicount++;
      	if (strlen($milCourseItem['title'])) {
        	$bucketTest=$milCourseItem['title'];
      	}
        if (strlen($milCourseItem['title'])) {
			$mciar[$mcicount]=$milCourseItem['title'];
			if ($mciar[$mcicount]!=$mciar[$mcicount-1])
				echo "<b>Primary Course Name: </b>".$milCourseItem['title']."<br />";
        }	
        if (strlen($milCourseItem['second_title'])) {
        	echo "<b>Secondary Course Name: </b>".$milCourseItem['second_title']."<br />";
        }
        if (strlen($milCourseItem['objective'])) {
        	echo "<b>Objective: </b>".$milCourseItem['objective']."<br />";
        }
        if (strlen($milCourseItem['instruction'])) {
        	echo "<b>Instruction: </b>".$milCourseItem['instruction']."<br />";
        }

      }
    }
  }
echo "</div>";


?>