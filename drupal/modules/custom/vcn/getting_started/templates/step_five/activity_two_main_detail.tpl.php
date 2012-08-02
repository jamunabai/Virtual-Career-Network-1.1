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
$path=$base_url."/getting-started/step-five/2";
?>

<form method="POST" action="<?php echo "$path"; ?>">
<input type="hidden" id="zipcodes5a2" name="zipcodes5a2" value="<?php echo $vars['zip']; ?>" />
<p>
<strong>Add Course:</strong>
</p>
<?php
// if all values were posted correctly, show blank values in the input boxes,
// otherwise, show what was put in previously.
global $testValArray;
if ($testValArray['test1']==1) echo "

<p>
<label for=\"gs_schoolName\">
School Name:
</label><br />
<input type=\"text\" name=\"gs_schoolName\" id=\"gs_schoolName\" size=\"40\"/>
</p>

<p>
<label for=\"gs_courseName\">
Course Name:
</label><br />
<input type=\"text\" name=\"gs_courseName\" id=\"gs_courseName\" size=\"30\" />
</p>

<p>
<label for=\"gs_courseNumber\">
Course Number:
</label><br />
<input type=\"text\" name=\"gs_courseNumber\" id=\"gs_courseNumber\" />
</p>

<p>
<label for=\"gs_courseGrade\">
Final Grade:
</label><br />
<input type=\"text\" id=\"gs_courseGrade\" name=\"gs_courseGrade\" />
</p>

<p>
<label for=\"gs_courseYear\">
Year Course Completed:
</label><br />
<input type=\"text\" name=\"gs_courseYear\" id=\"gs_courseYear\" />
</p>

<p style=\"text-align: left;\">
<label for=\"gs_creditHours\">
Number of Credit Hours:
</label><br />
<input type=\"text\" name=\"gs_creditHours\" id=\"gs_creditHours\" size=\"30\" />
</p>
";

else echo "

<p>
<label for=\"gs_schoolName\">
School Name:
</label><br />
<input type=\"text\" name=\"gs_schoolName\" id=\"gs_schoolName\" size=\"40\" value=\"".$_POST['gs_schoolName']."\" />
</p>

<p>
<label for=\"gs_courseName\">
Course Name:
</label><br />
<input type=\"text\" name=\"gs_courseName\" id=\"gs_courseName\" value=\"".$_POST['gs_courseName']."\" size=\"30\" />
</p>

<p>
<label for=\"gs_courseNumber\">
Course Number:
</label><br />
<input type=\"text\" name=\"gs_courseNumber\" id=\"gs_courseNumber\" value=\"".$_POST['gs_courseNumber']."\"/>
</p>

<p>
<label for=\"gs_courseGrade\">
Final Grade:
</label><br />
<input type=\"text\" id=\"gs_courseGrade\" name=\"gs_courseGrade\" value=\"".$_POST['gs_courseGrade']."\" />
</p>

<p>
<label for=\"gs_courseYear\">
Year Course Completed:
</label><br />
<input type=\"text\" name=\"gs_courseYear\" id=\"gs_courseYear\" value=\"".$_POST['gs_courseYear']."\" />
</p>

<p style=\"text-align: left;\">
<label for=\"gs_creditHours\">
Number of Credit Hours:
</label><br />
<input type=\"text\" name=\"gs_creditHours\" id=\"gs_creditHours\" value=\"".$_POST['gs_creditHours']."\" size=\"30\" />

<input type=\"hidden\" name=\"zipcode\" id=\"zipcode\" value=\"".$_POST['zipcode']."\" />

</p>
";
?>

<input type="image" name="Save" src="<?php echo "$base_url/sites/default/files/images/buttons/save-to-my-learning-inventory.png"; ?>" alt="Save" title="Save" />
</form>

<?php

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

$select="SELECT * FROM vcn_cma_user_course WHERE USER_ID=\"$USER_ID\" AND COURSE_CODE IS NOT NULL AND MILITARY_YN IS NULL";
$connection=connectIt();
$results=mysql_query($select) or die("Error selecting from user course table: ".mysql_error());
mysql_close($connection);
$rowCount=mysql_num_rows($results);
if($rowCount>0)
  {
  echo "<p><b>The following courses have been saved:</b></p>";
  drupal_add_css(drupal_get_path('module', 'pla_main') .'/css/pla_supplemental.css');
  $testCount=0;
  while($row=mysql_fetch_assoc($results))
    {
    extract($row);
    if($testCount%2==0)
      echo "<div class=\"line1\">";
    else
      echo "<div class=\"line2\">";
    echo "<div class=\"StepFiveDivStack\"><form method=\"POST\" action=\"$base_url/getting-started/step-five/2\">";
    ?> <input type="hidden" id="zipcodes5a2" name="zipcodes5a3" value="<?php echo $vars['zip']; ?>" />  <?php
    echo "<div class=\"StepFiveDivColumn1\">$COURSE_NAME $COURSE_CODE: $COURSE_CREDIT Hours</div>
          <div class=\"StepFiveDivColumn2\"><input type=\"hidden\" name=\"USER_COURSE_ID\" value=\"$USER_COURSE_ID\" /><input type=\"hidden\" name=\"function\" value=\"delete\" /></div>
          <div class=\"StepFiveDivColumn3\"><input type=\"image\" src=\"$base_url/sites/default/files/images/buttons/delete.png\" alt=\"Remove this item from your saved list\" title=\"Remove this item from your saved list\"></div>";
    echo "<br /></form></div></div>";
    $testCount++;
    }
  }
?>
<br />
<p>



