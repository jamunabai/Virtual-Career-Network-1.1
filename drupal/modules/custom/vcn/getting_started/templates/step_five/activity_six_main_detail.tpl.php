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

$myfile = $base_url."learning-inventory-output";
$myfile2 = $base_url."learning-inventory-output?c=1";
?>

<p>
<center>
<form method="POST" action="<?php echo $myfile; ?>" target="_blank">
<!-- <a href="<?php echo $myfile; ?>" target="_blank">Click Here to View Your Summary</a> -->
<input type="hidden" name="cma" value="<?php echo $USER_ID; ?>" />
<?php
global $user;
$drupalID=$user->uid;
echo "<input type=\"hidden\" name=\"drupalID\" value=\"$drupalID\" />\r\n";
?>
<input type="image" src="<?php echo $base_url."/sites/default/files/images/buttons/view-my-learning-inventory.png"; ?>" onclick="this.form.action='<?php echo $myfile; ?>';" alt="Click Here to View Your Summary" title="Click Here to View Your Summary" />
<br><br>
<input type="image" src="<?php echo $base_url."/sites/default/files/images/buttons/view-my-cover-letter.png"; ?>" onclick="this.form.action='<?php echo $myfile2; ?>';" alt="Click Here to View Your Cover Letter" title="Click Here to View Your Cover Letter" />
</form>
</center>
</p>

