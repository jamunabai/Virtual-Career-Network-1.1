<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

/**
 * This function is to properly identify the source path for includes or images
 */
function sourcePath()
  {
  if($_SERVER['HTTPS']=="on" || $_SERVER['HTTP_FRONT_END_HTTPS']=="ON") $mode="https://";
  else $mode = "http://";
  $sourcePath=base_path().drupal_get_path('module','vcn_cma');
  return($sourcePath);
  }

/**
 * This function is to make a database connection
 */

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

/**
 * This function gets the CMA User ID...
 */
function getUserID()
  {
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
  return($USER_ID);
  }

/**** display functions listed below ****/

/**
 * This function returns a display of the user's selected military courses
 */
function displayMilitaryCourses()
  {
  /**
   * section that deletes a posted request
   */
  if(isset($_POST['USER_COURSE_ID']) && $_POST['function']=="delete")
    {
    $USER_COURSE_ID=$_POST['USER_COURSE_ID'];
    $del="DELETE FROM vcn_cma_user_course WHERE USER_COURSE_ID=\"$USER_COURSE_ID\"";
    $connection=connectIt();
    $results=mysql_query($del) or die("error removing record from table: ".mysql_error());
    mysql_close($connection);
    }
  /**
   * end section that deletes Posted request
   */

  // get the user vcn id
  $USER_ID=getUserID();
  // add css to make it pretty
  drupal_add_css(drupal_get_path('module','vcn_cma')."/css/pla_supplemental.css");

  /**
   * Section added to delete already selected courses
   */
  $query="SELECT USER_COURSE_ID,COURSE_CODE from vcn_cma_user_course WHERE USER_ID=\"$USER_ID\" AND MILITARY_YN=\"Y\"";
  $connection=connectIt();
  $result=mysql_query($query) or die("error selecting military courses: ".mysql_error());
  $lineCount=mysql_num_rows($result);
  if($lineCount>0 && !isset($_GET['ace_id']))
    {
    $output .= "<p><b>The following courses have been saved:</b></p>";
    $testCount=0;
    while($row=mysql_fetch_assoc($result))
      {
      extract($row);
      $tempArr=explode("|",$COURSE_CODE);
      $tmpAceID=$tempArr[0];
      $tmpStartDate=$tempArr[1];
      $tmpEndDate=$tempArr[2];
      $select2="SELECT first_title,branch FROM vcn_ace_course WHERE ace_id=\"$tmpAceID\" AND start_date=\"$tmpStartDate\" AND end_date=\"$tmpEndDate\"";
      $result2=mysql_query($select2) or die("error extracting military course credits: ".mysql_error());
      while($row2=mysql_fetch_assoc($result2))
        {
        extract($row2);
        if($testCount%2==0)
          $output .= "<div class=\"line1\">";
        else
          $output .= "<div class=\"line2\">";
        $output .= "<div class=\"StepFiveDivStack\">\r\n
                <form method=\"POST\" action=\"$path\">\r\n";
        $output .= "<span style=\"display:inline-block; vertical-align: middle; width: 90%;\"><div class=\"StepFiveDivColumn1\">\r\n
                <a href=\"$path?ace_id=$tmpAceID&start_date=$tmpStartDate&end_date=$tmpEndDate&branch=".str_replace(" ","+",$branch)."\">$first_title</a>\r\n
              </div></span>\r\n
              <div class=\"StepFiveDivColumn2\">\r\n
                <input type=\"hidden\" name=\"USER_COURSE_ID\" value=\"$USER_COURSE_ID\" />\r\n
                <input type=\"hidden\" name=\"function\" value=\"delete\" />\r\n
              </div>\r\n
              <div class=\"StepFiveDivColumn3\">\r\n
                <input type=\"image\" src=\"".sourcePath()."/images/delete.png\" alt=\"Remove this item from your saved list\" title=\"Remove this item from your saved list\">\r\n
              </div>\r\n";
        $output .= "<br /></form></div></div>\r\n";
        $testCount++;
        }// end while($row2=mysql_fetch_assoc($result2))
      }//end while($row=mysql_fetch_assoc($result))
    }// end if($lineCount>0 && !isset($_GET['ace_id']))
  mysql_close($connection);
  /**
   * End section to delete selected courses
   */

  /**
   * section to display course information
   */
  if(isset($_GET['ace_id']) && !isset($_POST['searchVal']))
    {
    $ace_id=$_GET['ace_id'];
    $start_date=$_GET['start_date'];
    $end_date=$_GET['end_date'];
    $select1="SELECT *
              FROM   vcn_ace_course
              WHERE  ace_id=\"$ace_id\"
              AND    start_date=\"$start_date\"
              AND    end_date=\"$end_date\"";
    $select2="SELECT *
              FROM   vcn_ace_military_course
              WHERE  ace_id=\"$ace_id\"
              AND    start_date=\"$start_date\"
              AND    end_date=\"$end_date\"";
    $select3="SELECT *
              FROM   vcn_ace_course_credit
              WHERE  ace_id=\"$ace_id\"
              AND    start_date=\"$start_date\"
              AND    end_date=\"$end_date\"";
    $select4="SELECT *
              FROM   vcn_ace_course_credit_span
              WHERE  ace_id=\"$ace_id\"
              AND    start_date=\"$start_date\"
              AND    end_date=\"$end_date\"";
    $connection=connectIt();
    $results1=mysql_query($select1)
      or die("Error running $select1: ".mysql_error());
    $results2=mysql_query($select2)
      or die("Error running $select2: ".mysql_error());
    $results3=mysql_query($select3)
      or die("Error running $select3: ".mysql_error());
    $results4=mysql_query($select4)
      or die("Error running $select4: ".mysql_error());
    mysql_close($connection);

    $row1=mysql_fetch_assoc($results1);
    extract($row1);
    $militaryCourses="";
    while($row2=mysql_fetch_assoc($results2))
      {
      extract($row2);
      $militaryCourses .="$course_id, ";
      }
    $militaryCourses = trim($militaryCourses);
    if(strlen($militaryCourses)>0)
      $militaryCourses=substr($militaryCourses,0,-1);
    $output .= "<p>The details we have for this item are as follows:</p>";
    $output .= "<div class=\"line2\">";
    $output .= "<p><b>The primary title for this course is </b>$first_title</p>";
    if($second_title!="" && $second_title!=NULL)
      $output .= "<p><b>The secondary title for this course is </b>$second_title</p>";
    if($militaryCourses!="")
      $output .= "<b>Military courses this is applicable to are: </b>$militaryCourses";
    if($objective!="" && $objective!=Null)
      $output .= "<p><b>The objective for this course is: </b>$objective</p>";
    if($instruction!="" && $instruction !=NULL)
      $output .= "<p><b>The instruction provided in this course is: </b>$instruction</p>";
    if($ref_sequence!="" && $ref_sequence!=NULL)
      {
      $refDate=substr($ref_date,4,2)."/".substr($ref_date,0,4);
      $output .= "Course reference is $ref_sequence $refDate see $ref_ace_id";
      }
    if($results3!=NULL)
      {
      $courseCreditDetails="";
      while($row3=mysql_fetch_assoc($results3))
        {
        extract($row3);
        if($course_conjunction!="" && $course_conjunction!=NULL)
          {
          $courseCreditDetails = substr($courseCreditDetails,0,-4);
          $courseCreditDetails .=" $course_conjunction ";
          }
        if($course_preterm!="" && $course_credit!=NULL)
          $courseCreditDetails .= "$course_preterm ";
        $courseCreditDetails .= "$course_credit $course_credit_unit $course_condition $course_credit_midterm $course_subject</p>";
        if($course_postterm!="" && $course_postterm!=NULL)
          {
          $courseCreditDetails = substr($courseCreditDetails,0,-4);
          $courseCreditDetails .= " $course_postterm</p>";
          }
        }
      $output .= "<p><b>Course credit details are stated below:</b></p>";
      $output .= "<p>$courseCreditDetails</p>";
      } // end if($results3!=NULL)
    if($credit_info!="" && $credit_info!=NULL)
      $output .= "<p><b>Additional Credit information is as follows: </b>$credit_info</p>";
      $output .= "</div>";
      $output .= "<br />";
      $output .= "<form method=\"post\" action=\"".base_path()."cma/pla/military\">";
      $output .= "<input type=\"submit\" value=\"Go Back\" />";
      $output .= "</form>";
      } // end if(isset($_GET['ace_id']) && !isset($_POST['searchVal'])

  return($output);
  }// end function displayMilitaryCourses()

/********/

/**
 * This function returns a display of the user's selected business courses
 */
function displayBusinessCourses()
  {
  /**
   * section that deletes a posted request
   */
  if(isset($_POST['USER_COURSE_ID']) && $_POST['function']=="delete")
    {
    $USER_COURSE_ID=$_POST['USER_COURSE_ID'];
    $del="DELETE FROM vcn_cma_user_course WHERE USER_COURSE_ID=\"$USER_COURSE_ID\"";
    $connection=connectIt();
    $results=mysql_query($del) or die("error removing record from table: ".mysql_error());
    mysql_close($connection);
    }
  /**
   * end section that deletes Posted request
   */

  // get the user vcn id
  $USER_ID=getUserID();
  // add css to make it pretty
  drupal_add_css(drupal_get_path('module','vcn_cma')."/css/pla_supplemental.css");

  /**
   * Section added to delete already selected courses
   */
  if(!isset($_GET['ace_id']))
    {
    $query="SELECT USER_COURSE_ID,COURSE_CODE from vcn_cma_user_course WHERE USER_ID=\"$USER_ID\" AND MILITARY_YN=\"C\"";
    $connection=connectIt();
    $result=mysql_query($query) or die("error selecting corporate courses: ".mysql_error());
    mysql_close($connection);
    $lineCount=mysql_num_rows($result);
    $testCount=0;
    if($lineCount>0)
      {
      $output .= "<p><b>The following courses have been saved:</b></p>";
      while($row=mysql_fetch_assoc($result))
        {
        extract($row);
        $tempArr=explode("|",$COURSE_CODE);
        $tmpAceID=$tempArr[0];
        $tmpStartDate=$tempArr[1];
        $tmpEndDate=$tempArr[2];
        $connection2=connectIt();
        $select2="SELECT first_title FROM vcn_ace_national_course WHERE ace_id=\"$tmpAceID\" AND start_date=\"$tmpStartDate\" AND end_date=\"$tmpEndDate\"";
        $result2=mysql_query($select2) or die("error extracting corporate course credits: ".mysql_error());
        mysql_close($connection2);
        while($row2=mysql_fetch_assoc($result2))
          {
          extract($row2);
          if($testCount%2==0)
            $output .= "<div class=\"line1\">";
          else
            $output .= "<div class=\"line2\">";
          $output .= "<div class=\"StepFiveDivStack\">\r\n
                  <form method=\"POST\" action=\"\">\r\n";
          $output .= "<div class=\"StepFiveDivColumn1\">\r\n
                  <a href=\"$path?ace_id=$tmpAceID&start_date=$tmpStartDate&end_date=$tmpEndDate&company=Course\">$first_title</a>\r\n
                </div>\r\n
                <div class=\"StepFiveDivColumn2\">\r\n
                  <input type=\"hidden\" name=\"USER_COURSE_ID\" value=\"$USER_COURSE_ID\" />\r\n
                  <input type=\"hidden\" name=\"function\" value=\"delete\" />\r\n
                </div>\r\n
                <div class=\"StepFiveDivColumn3\">\r\n
                  <input type=\"image\" src=\"".sourcePath()."/images/delete.png\" alt=\"Remove this item from your saved list\" title=\"Remove this item from your saved list\">\r\n
                </div>\r\n";
          $output .= "<br /></form></div></div>\r\n";
          $testCount++;
          }// end while($row2=mysql_fetch_assoc($result2))
        }// end while($row=mysql_fetch_assoc($result))
      }// end if($lineCount>0)
    } // end if(!isset($_GET['ace_id']))
  /**
   * End section to delete selected courses
   */

  if(isset($_GET['ace_id']) && !isset($_POST['searchVal']))
    {
    $ace_id=$_GET['ace_id'];
    $start_date=$_GET['start_date'];
    $end_date=$_GET['end_date'];
    $select1="SELECT *
              FROM   vcn_ace_national_course
              WHERE  ace_id=\"$ace_id\"
              AND    start_date=\"$start_date\"
              AND    end_date=\"$end_date\"";
    $select3="SELECT *
              FROM   vcn_ace_national_course_credit
              WHERE  ace_id=\"$ace_id\"
              AND    start_date=\"$start_date\"
              AND    end_date=\"$end_date\"";
    $select4="SELECT *
              FROM   vcn_ace_national_course_credit_span
              WHERE  ace_id=\"$ace_id\"
              AND    start_date=\"$start_date\"
              AND    end_date=\"$end_date\"";
    $connection=connectIt();
    $results1=mysql_query($select1)
      or die("Error running $select1: ".mysql_error());
    $results3=mysql_query($select3)
      or die("Error running $select3: ".mysql_error());
    $results4=mysql_query($select4)
      or die("Error running $select4: ".mysql_error());
    mysql_close($connection);

    $row1=mysql_fetch_assoc($results1);
    extract($row1);
    $output .= "<p>The details we have for this item are as follows:</p>";
    $output .= "<div class=\"line2\">";
    $output .= "<p>The ACE ID for this course is <b>$ace_id</b></p>";
    $output .= "<p>The primary title for this course is <b>$first_title</b></p>";
    if($second_title!="" && $second_title!=NULL)
      $output .= "<p>The secondary title for this course is <b>$second_title</b></p>";
    if($objective!="" && $objective!=Null)
      $output .= "<p>The objective for this course is: <i>$objective</i></p>";
    if($instruction!="" && $instruction !=NULL)
      $output .= "<p>The instruction provided in this course is: <i>$instruction</i></p>";
    if($ref_sequence!="" && $ref_sequence!=NULL)
      {
      $refDate=substr($ref_date,4,2)."/".substr($ref_date,0,4);
      $output .= "Course reference is $ref_sequence $refDate see $ref_ace_id";
      }
    if($results3!=NULL)
      {
      $courseCreditDetails="";
      while($row3=mysql_fetch_assoc($results3))
        {
        extract($row3);
        if($course_conjunction!="" && $course_conjunction!=NULL)
          {
          $courseCreditDetails = substr($courseCreditDetails,0,-4);
          $courseCreditDetails .=" $course_conjunction ";
          }
        if($course_preterm!="" && $course_credit!=NULL)
          $courseCreditDetails .= "$course_preterm ";
        $courseCreditDetails .= "$course_credit $course_credit_unit $course_condition $course_credit_midterm $course_subject</p>";
        if($course_postterm!="" && $course_postterm!=NULL)
          {
          $courseCreditDetails = substr($courseCreditDetails,0,-4);
          $courseCreditDetails .= " $course_postterm</p>";
          }
        }// end while($row3=mysql_fetch_assoc($results3))
      $output .= "<p>Course credit details are stated below:</p>";
      $output .= "<p><i>$courseCreditDetails</i></p>";
      } // end if($results3!=NULL)
    if($credit_info!="" && $credit_info!=NULL)
    $output .= "<p>Additional Credit information is as follows: <i>$credit_info</i></p>";
    $output .= "</div>";
    $output .= "<form method=\"post\" action=\"".base_path()."cma/pla/business\">";
    $output .= "<input type=\"submit\" value=\"Go Back\" />";
    $output .= "</form>";
    } // end if(isset($_GET['ace_id']) && !isset($_POST['searchVal']))

  return($output);
  }// end function displayBusinessCourses()

/********/

/**
 *  This function returns a display of the user's selected national exams
 */
function displayNationalExams()
  {
  // get the user vcn id
  $USER_ID=getUserID();
  // add css to make it pretty
  drupal_add_css(drupal_get_path('module','vcn_cma')."/css/pla_supplemental.css");

  /**
   * section that deletes a posted request
   */
  if(isset($_POST['USER_COURSE_ID']) && $_POST['function']=="delete")
    {
    $USER_COURSE_ID=$_POST['USER_COURSE_ID'];
    $del="DELETE FROM vcn_cma_user_course WHERE USER_COURSE_ID=\"$USER_COURSE_ID\"";
    $connection=connectIt();
    $results=mysql_query($del) or die("error removing record from table: ".mysql_error());
    mysql_close($connection);
    }
  /**
   * end section that deletes Posted request
   */

  /**
   * Section added to delete already selected courses
   */
  if(!isset($_GET['ace_id']))
    {
    $query="SELECT USER_COURSE_ID,COURSE_CODE from vcn_cma_user_course WHERE USER_ID=\"$USER_ID\" AND MILITARY_YN=\"E\"";
    $connection=connectIt();
    $result=mysql_query($query) or die("error selecting national exams: ".mysql_error());
    mysql_close($connection);
    $lineCount=mysql_num_rows($result);
    $testCount=0;
    if($lineCount>0)
      {
      $output .= "<p><b>The following national exams have been saved:</b></p>";
      while($row=mysql_fetch_assoc($result))
        {
        extract($row);
        $tempArr=explode("|",$COURSE_CODE);
        $tmpAceID=$tempArr[0];
        $tmpStartDate=$tempArr[1];
        $tmpEndDate=$tempArr[2];
        $connection2=connectIt();
        $select2="SELECT first_title FROM vcn_ace_national_course WHERE ace_id=\"$tmpAceID\" AND start_date=\"$tmpStartDate\" AND end_date=\"$tmpEndDate\"";
        $result2=mysql_query($select2) or die("error extracting national exam credits: ".mysql_error());
        mysql_close($connection2);
        while($row2=mysql_fetch_assoc($result2))
          {
          extract($row2);
          if($testCount%2==0)
            {
            $output .= "<div class=\"line1\">";
            }
          else
            {
            $output .= "<div class=\"line2\">";
            }
          $output .= "<div class=\"StepFiveDivStack\">\r\n
                  <form method=\"POST\" action=\"\">\r\n";
          $output .= "<div class=\"StepFiveDivColumn1\">\r\n
                  <a href=\"$path?ace_id=$tmpAceID&start_date=$tmpStartDate&end_date=$tmpEndDate&company=Exam\">$first_title</a>\r\n
                </div>\r\n
                <div class=\"StepFiveDivColumn2\">\r\n
                  <input type=\"hidden\" name=\"USER_COURSE_ID\" value=\"$USER_COURSE_ID\" />\r\n
                  <input type=\"hidden\" name=\"function\" value=\"delete\" />\r\n
                </div>\r\n
                <div class=\"StepFiveDivColumn3\">\r\n
                  <input type=\"image\" src=\"".sourcePath()."/images/delete.png\" alt=\"Remove this item from your saved list\" title=\"Remove this item from your saved list\">\r\n
                </div>\r\n";
          $output .= "<br /></form></div></div>\r\n";
          $testCount++;
          }// end while($row2=mysql_fetch_assoc($result2))
        }// end while($row=mysql_fetch_assoc($result))
      }// end if($lineCount>0)
    }// end if(!isset($_GET['ace_id']))
  /**
   * End section to delete selected courses
   */

  if(isset($_GET['ace_id']) && !isset($_POST['searchVal']))
    {
    $ace_id=$_GET['ace_id'];
    $start_date=$_GET['start_date'];
    $end_date=$_GET['end_date'];
    $select1="SELECT *
              FROM   vcn_ace_national_course
              WHERE  ace_id=\"$ace_id\"
              AND    start_date=\"$start_date\"
              AND    end_date=\"$end_date\"
              AND    branch = \"Exam\"";
    $select3="SELECT *
              FROM   vcn_ace_national_exam_credit
              WHERE  ace_id=\"$ace_id\"
              AND    start_date=\"$start_date\"
              AND    end_date=\"$end_date\"";
    $connection=connectIt();
    $results1=mysql_query($select1)
      or die("Error running $select1: ".mysql_error());
    $results3=mysql_query($select3)
      or die("Error running $select3: ".mysql_error());
    mysql_close($connection);

    $row1=mysql_fetch_assoc($results1);
    extract($row1);

    $output .= "<p>The details we have for this item are as follows:</p>";
    $output .= "<div class=\"line2\">";
    $output .= "<p>The ACE ID for this course is <b>$ace_id</b></p>";
    $output .= "<p>The primary title for this exam is <b>$first_title</b></p>";
    if($second_title!="" && $second_title!=NULL)
      $output .= "<p>The secondary title for this exam is <b>$second_title</b></p>";
    if($objective!="" && $objective!=Null)
      $output .= "<p>The objective for this exam is: <i>$objective</i></p>";
    if($instruction!="" && $instruction !=NULL)
      $output .= "<p>The instruction provided in this exam is: <i>$instruction</i></p>";
    if($ref_sequence!="" && $ref_sequence!=NULL)
      {
      $refDate=substr($ref_date,4,2)."/".substr($ref_date,0,4);
      $output .= "Course reference is $ref_sequence $refDate see $ref_ace_id";
      }
    if($results3!=NULL)
      {
      $courseCreditDetails="";
      while($row3=mysql_fetch_assoc($results3))
        {
        extract($row3);
        $courseCreditDetails .= "<p>$credit_info</p>";
        }
      $output .= "<p>Course credit details are stated below:</p>";
      $output .= "<p><i>$courseCreditDetails</i></p>";
      } // end if($results3!=NULL)
    if($credit_info!="" && $credit_info!=NULL)
    $output .= "<p>Additional Credit information is as follows: <i>$credit_info</i></p>";
    $output .= "</div>";
    $output .= "<form method=\"post\" action=\"".base_path()."cma/pla/exams\">";
    $output .= "<input type=\"submit\" value=\"Go Back\" />";
    $output .= "</form>";
    } // end if(isset($_GET['ace_id']) && !isset($_POST['searchVal']))


  return($output);
  }// end function displayNationalExams()

/********/

/**
 *  This function returns a display of the user's saved college courses
 */
function displayCollegeCourses()
  {
  // get the user vcn id
  $USER_ID=getUserID();
  // add css to make it pretty
  drupal_add_css(drupal_get_path('module','vcn_cma')."/css/pla_supplemental.css");

  /**
   * This section handles a college credit delete request
   */
  if($_POST['function']=="delete")
    {
    $USER_COURSE_ID=$_POST['USER_COURSE_ID'];
    $delete="DELETE from vcn_cma_user_course
             WHERE USER_COURSE_ID=\"$USER_COURSE_ID\"";
    $connection=connectIt();
    $result=mysql_query($delete)
      or die("Error deleting course: ".mysql_error());
    mysql_close($connection);
    }
  /**
   * end credit delete request section
   */

  /**
   * this section displays the saved college courses
   */
  $select="SELECT * FROM vcn_cma_user_course WHERE USER_ID=\"$USER_ID\" AND COURSE_CODE IS NOT NULL AND MILITARY_YN IS NULL";
  $connection=connectIt();
  $results=mysql_query($select) or die("Error selecting from user course table: ".mysql_error());
  mysql_close($connection);
  $rowCount=mysql_num_rows($results);
  if($rowCount>0)
    {
    $courseCount=0;
    $output .= "<p><b>The following courses have been saved:</b></p>";
    while($row=mysql_fetch_assoc($results))
      {
      extract($row);
      if($courseCount%2==0)
        $output .= "<div class=\"line1\">";
      else
        $output .= "<div class=\"line2\">";
      $output .= "<div class=\"StepFiveDivStack\"><form method=\"POST\" action=\"\">";
      $output .= "<div class=\"StepFiveDivColumn1\">$COURSE_NAME $COURSE_CODE: $COURSE_CREDIT Hours</div>
                   <div class=\"StepFiveDivColumn2\"><input type=\"hidden\" name=\"USER_COURSE_ID\" value=\"$USER_COURSE_ID\" /><input type=\"hidden\" name=\"function\" value=\"delete\" /></div>
                   <div class=\"StepFiveDivColumn3\"><input type=\"image\" src=\"".sourcePath()."/images/delete.png\" alt=\"Remove this item from your saved list\" title=\"Remove this item from your saved list\"></div>";
      $output .= "<br /></form></div></div>";
      $courseCount++;
      }
    }
  /**
   * end display of college courses
   */

  return($output);
  }// end function displayCollegeCourses()
