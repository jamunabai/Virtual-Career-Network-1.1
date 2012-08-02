<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
//global $base_url;
$base_url = base_path();

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
 * End section that gets CMA User ID
 */

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

if(!isset($_GET['ace_id'])){
echo "<strong class=\"cg_highlight\">Look up college credit recommendations from ACE for your military training.</strong>";

echo "<form method=\"POST\" action=\"$base_url/getting-started/step-five/3#results\">";
?>
<input type="hidden" id="zipcodes5a3" name="zipcodes5a3" value="<?php echo $vars['zip']; ?>" />
<?php
echo "<p>Select your branch: <br/>";
echo "<label>\r\n";
echo "<select name=\"branch\">\r\n";
if(urldecode($_REQUEST['branch'])=="air force")
  echo "<option value=\"air force\" selected>Air Force</option>";
else
  echo "<option value=\"air force\">Air Force</option>";
if(urldecode($_REQUEST['branch'])=="army")
  echo "<option value=\"army\" selected>Army</option>";
else
  echo "<option value=\"army\">Army</option>";
if(urldecode($_REQUEST['branch'])=="coast guard")
  echo "<option value=\"coast guard\" selected>Coast Guard</option>";
else
  echo "<option value=\"coast guard\">Coast Guard</option>";
if(urldecode($_REQUEST['branch'])=="Dept of Defense")
  echo "<option value=\"Dept of Defense\" selected>Department of Defense</option>";
else
  echo "<option value=\"Dept of Defense\">Department of Defense</option>";
if(urldecode($_REQUEST['branch'])=="marine corps")
  echo "<option value=\"marine corps\" selected>Marine Corps</option>";
else
  echo "<option value=\"marine corps\">Marine Corps</option>";
if(urldecode($_REQUEST['branch'])=="navy")
  echo "<option value=\"navy\" selected>Navy</option>";
else
  echo "<option value=\"navy\">Navy</option>";
echo "</select></label></p>\r\n";
echo "<p><label for=\"searchVal\">Enter a military course id number, key words, and/or phrases in the title:</label><br/>";
echo "<input type=\"text\" name=\"searchVal\" id=\"searchVal\" value=\"".$_POST['searchVal']."\" size=50/></p>";
echo "<input type=\"image\" src=\"$base_url/sites/all/modules/custom/vcn/occupations/ocupations_search/search.png\" value=\"Search\" alt=\"Search\" title=\"Search\" /></p>";
echo "</form>";

/**
 * Section added to delete already selected courses
 */
drupal_add_css(drupal_get_path('module', 'pla_main') .'/css/pla_supplemental.css');
$query="SELECT USER_COURSE_ID,COURSE_CODE from vcn_cma_user_course WHERE USER_ID=\"$USER_ID\" AND MILITARY_YN=\"Y\"";
$connection=connectIt();
$result=mysql_query($query) or die("error selecting military courses: ".mysql_error());
$lineCount=mysql_num_rows($result);
$testCount=0;
if($lineCount>0)
  {
  echo "<p><b>The following courses have been saved:</b></p>";
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
        echo "<div class=\"line1\">";
      else
        echo "<div class=\"line2\">";
      echo "<div class=\"StepFiveDivStack\">\r\n
              <form method=\"POST\" action=\"$base_url/getting-started/step-five/3\">\r\n";
      ?> <input type="hidden" id="zipcodes5a3" name="zipcodes5a3" value="<?php echo $vars['zip']; ?>" />  <?php
      echo "<div class=\"StepFiveDivColumn1\">\r\n
              <a href=\"$base_url/getting-started/step-five/3?view=y&ace_id=$tmpAceID&start_date=$tmpStartDate&end_date=$tmpEndDate&branch=".str_replace(" ","+",$branch)."\" style=\"font-size: 14px; font-family: arial;\">$first_title</a>\r\n
            </div>\r\n
            <div class=\"StepFiveDivColumn2\">\r\n
              <input type=\"hidden\" name=\"USER_COURSE_ID\" value=\"$USER_COURSE_ID\" />\r\n
              <input type=\"hidden\" name=\"function\" value=\"delete\" />\r\n
            </div>\r\n
            <div class=\"StepFiveDivColumn3\">\r\n
              <input type=\"image\" src=\"$base_url/sites/default/files/images/buttons/delete.png\" alt=\"Remove this item from your saved list\" title=\"Remove this item from your saved list\">\r\n
            </div>\r\n";
      echo "<br /></form></div></div>\r\n";
      $testCount++;
      }
    }
  }
mysql_close($connection);
/**
 * End section to delete selected courses
 */


if(isset($_POST['searchVal']))
  {
  $connection=connectIt();
  $branch=mysql_real_escape_string($_POST['branch'],$connection);
  $searchVal=mysql_real_escape_string(html_entity_decode($_POST['searchVal']),$connection);
  $searchValArray=explode(" ",$searchVal);
  if(count($searchValArray)==1)
    {
    $select="SELECT *
             FROM   vcn_ace_course a,vcn_ace_military_course b
             WHERE  a.ace_id=b.ace_id
             AND    a.start_date=b.start_date
             AND    a.end_date=b.end_date
             AND    a.branch=\"$branch\"
             AND    (a.first_title LIKE \"%$searchVal%\"
             OR     a.second_title LIKE \"%$searchVal%\"
             OR     b.course_id LIKE \"%$searchVal%\")
             ";
    }
  elseif(count($searchValArray)==0)
    {
    $select="";
    }
  else // count($searchValArray
    {
    $select="SELECT *
             FROM   vcn_ace_course a,vcn_ace_military_course b
             WHERE  a.ace_id=b.ace_id
             AND    a.start_date=b.start_date
             AND    a.end_date=b.end_date
             AND    a.branch=\"$branch\"
             ";
    foreach($searchValArray as $searchItem)
      {
      $select .= "AND    (a.first_title LIKE \"%$searchItem%\"
                  OR     a.second_title LIKE \"%$searchItem%\"
                  OR     b.course_id LIKE \"%$searchItem%\")
                  ";
      }
    }
  if($select!="")
    $connect .= "ORDER BY b.course_id";

  $db=mysql_select_db("hvcp",$connection)
    or die("cannot select \"hvcp\" database: ".mysql_error());
  if($select!="") $results=mysql_query($select)
    or die("Error running select: ".mysql_error());
  mysql_close($connection);

  $lineCount=mysql_num_rows($results);
  echo "<a name=\"results\"></a>";
  if($lineCount > 0)
    {
    echo "<p>Based upon your search parameters, we suggest the following possible matches:</p><ul style=\"list-style-type:disc; margin-left:-22px;\">";
    }
  else
    {
    echo '<p><strong style="color:red;">No results found. Please try altering your search.</strong></p><ul>';
    }

  while($row=mysql_fetch_assoc($results))
    {
    extract($row);
    if($end_date=="999999") $endDate="Present";
    else $endDate=substr($end_date,4,2)."/".substr($end_date,0,4);
    $startDate=substr($start_date,4,2)."/".substr($start_date,0,4);
    $urlBranch=urlencode($branch);
    echo "<li style=\"margin-left:0px;\"><a href=\"$base_url/getting-started/step-five/3?ace_id=$ace_id&start_date=$start_date&end_date=$end_date&branch=$urlBranch\">$course_id - $first_title (Course taken between $startDate and $endDate)</a></li>";
    }
  echo "</ul>";
  }
}

if(isset($_GET['ace_id']) && !isset($_POST['searchVal']))
  {
  drupal_add_css(drupal_get_path('module', 'pla_main') .'/css/pla_supplemental.css');
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
  
  echo "<p><strong>Course Detail</strong></p>";
  
  echo "<div class=\"line2\" style=\"font-size: 14px;\">";
  echo "<p>ACE ID: <b>$ace_id</b></p>";
  echo "<p>Primary Title: <b>$first_title</b></p>";
  if($second_title!="" && $second_title!=NULL)
    echo "<p>Secondary Title: <b>$second_title</b></p>";
  if($militaryCourses!="")
    echo "Applicable Military Courses: <b>$militaryCourses</b>";
  if($objective!="" && $objective!=Null)
    echo "<p>Objective: $objective</p>";
  if($instruction!="" && $instruction !=NULL)
    echo "<p>Instruction: $instruction</p>";
  if($ref_sequence!="" && $ref_sequence!=NULL)
    {
    $refDate=substr($ref_date,4,2)."/".substr($ref_date,0,4);
    echo "<p>Reference: $ref_sequence $refDate see $ref_ace_id</p>";
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
    echo "</div>";
    echo "<p>Course Hours:</p>";
    echo "<div class=\"line2\" style=\"font-size: 14px;\">";
    echo "<p>$courseCreditDetails</p>";
    echo "</div>";
    } // end if($results3!=NULL)
  //if($credit_info!="" && $credit_info!=NULL)
   // echo "<p>Additional Course Hour Information: <div class=\"line2\" style=\"font-size: 14px;\">$credit_info</p></div>";

  echo "<br><div>";
  echo "<form method=\"POST\" action=\"$base_url/getting-started/step-five/3\">";
  ?> 
  <input type="hidden" id="zipcodes5a3" name="zipcodes5a3" value="<?php echo $vars['zip']; ?>" /> 
  <?php
  echo "<input type=\"hidden\" name=\"ace_id\" value=\"$ace_id\" />";
  echo "<input type=\"hidden\" name=\"start_date\" value=\"$start_date\" />";
  echo "<input type=\"hidden\" name=\"end_date\" value=\"$end_date\" />";
  echo "<input type=\"hidden\" id=\"save\" name=\"save\" value=\"save\" />";
  
  if (!isset($_GET['view']) || strlen($_GET['view']) == 0) {
  	echo "<input type=\"image\" src=\"$base_url/sites/default/files/images/buttons/save-to-my-learning-inventory.png\" alt=\"Save\" title=\"Save\"/>";
  } 

  echo "&#160;&#160;";
  echo "<input type=\"image\" src=\"$base_url/sites/default/files/images/buttons/search_again.jpg\" onclick=\"document.getElementById('save').value='';\" name=\"searchAgain\" value=\"searchAgain\" alt=\"search again\" title=\"Search Again\"/>";
  echo "</form>";
  echo "</div>";
  
} else { // end if(isset($_GET['ace_id']) && !isset($_POST['searchVal']))
?>
<p>
<strong>Military Occupations</strong>
<br> 
Some colleges also award credit for learning you gained through your 
military occupational specialty. For credit recommendations for military 
occupations, 
<a href="javascript:popit('http://www.militaryguides.acenet.edu/OccupationSearch.asp')">click here</a> 
to visit ACE's Military Guide Online.
</p>
<p>
<strong>Transcripts</strong>
<br>
Your service branch will provide you with a transcript of your training 
and occupational experiences, including those with ACE credit 
recommendations. Click on your service branch to learn how to order a 
transcript:  
<a href="javascript:popit('http://aarts.army.mil/');">Army</a>,
<a href="javascript:popit('https://smart.navy.mil/');">Navy/Marines</a>, 
<a href="javascript:popit('http://www.au.af.mil/au/ccaf/');">Air Force</a>,
<a href="javascript:popit('http://www.uscg.mil/hq/cgi/active_duty/go_to_college/official_transcript.asp');">Coast Guard</a>, or 
<a href="javascript:popit('http://www.dodea.edu/students/transcripts.cfm')">Department of Defense</a>.
</p>

<?php
}
?>