<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<div style="padding-right:20px; font-size: 14px;">
<div class="vcn-gs-heading">Details:</div>
<p style="margin-left:10px; font-size: 14px;">Based upon your responses, we believe you could get this much college credit:</p>
<ul>

<?php
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

$query="SELECT COURSE_CODE from vcn_cma_user_course WHERE USER_ID=\"$USER_ID\"";
    $connection=connectIt();
    $result=mysql_query($query) or die("error selecting military courses: ".mysql_error());
    while($row=mysql_fetch_assoc($result))
      {
      extract($row);
      $tempArr=explode("|",$COURSE_CODE);
      $tmpAceID=$tempArr[0];
      $tmpStartDate=$tempArr[1];
      $tmpEndDate=$tempArr[2];
      $select2="SELECT * FROM vcn_ace_course_credit WHERE ace_id=\"$tmpAceID\" AND start_date=\"$tmpStartDate\" AND end_date=\"$tmpEndDate\"";
      $result2=mysql_query($select2) or die("error extracting military course credits: ".mysql_error());
      while($row2=mysql_fetch_assoc($result2))
        {
        extract($row2);
        echo "<li>$course_subject: $course_credit $course_credit_unit";
        if($course_credit_level=="Low") echo "(lower level credit)</li>\r\n";
        elseif($course_credit_level=="Up") echo "(upper level credit)</li>\r\n";
        elseif($course_credit_level=="Grad") echo "(graduate level credit)</li>\r\n";
        else $content .="(vocational credit)</li>\r\n";
        }
      }
    mysql_close($connection);
?>

</ul>
</div>