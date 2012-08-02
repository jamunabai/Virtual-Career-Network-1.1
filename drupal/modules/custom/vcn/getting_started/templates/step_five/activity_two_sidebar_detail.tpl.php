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

echo "
  <div style=\"padding-right:20px; font-size:13px;\">
  <div class=\"vcn-gs-heading\">Details:</div>
  <p style=\"margin-left:10px\">Based upon your responses, we believe you could get this much college credit:</p>
  ";
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

$gs_right_display="<ul>";
$select="SELECT COURSE_CODE,INSTITUTION_NAME,COURSE_NAME,COURSE_CREDIT,MILITARY_YN FROM vcn_cma_user_course where USER_ID=\"$USER_ID\" and MILITARY_YN is NULL";
$connection=connectIt();
$results=mysql_query($select) or die("error selecting from vcn_cma_user_course: ".mysql_error());
mysql_close($connection);
$total=0;
$gs_right_display .= "<table border=\"0\">\r\n";
while($row=mysql_fetch_assoc($results))
  {
  extract($row);
  $gs_right_display .= "<tr>\r\n";
  if($MILITARY_YN!="Y") $gs_right_display .= "<td><li>$COURSE_NAME $COURSE_CODE: $COURSE_CREDIT Hours</li></td>\r\n";
  $total=$total+$COURSE_CREDIT;
  $gs_right_display .= "</tr>\r\n";
  }
$gs_right_display .= "</table>";
$gs_right_display .= "</ul>";
$gs_right_display .= "<p style=\"margin-left:10px\"><b>Total: $total Hours</b></p>";

echo "$gs_right_display";
echo "</div>";
?>



