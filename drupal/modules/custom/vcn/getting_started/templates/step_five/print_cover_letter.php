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

$USER_ID = $_POST['cma'];
$name = '';

$query = "SELECT first_name, last_name FROM vcn_cma_user WHERE USER_ID=\"$USER_ID\"";
$connection = connectIt();
$result = mysql_query($query) or die("error getting CMA information: ".mysql_error());
mysql_close($connection);
$row = mysql_fetch_assoc($result);
if ($row) {
	if (strlen($row['first_name']) && strlen($row['last_name'])) {
		$name = $row['first_name'] . ' ' . $row['last_name'];
	}
}

$dateArr = getdate();
$currentDate = $dateArr['month'] . ' ' . $dateArr['mday'] . ', ' . $dateArr['year'];

?>

<html>
<head>
<title>My Learning Inventory Cover Letter</title>
<style type="text/css">
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
<div class="container">

<div style="padding-left: 10px; padding-right: 10px;  font-family: verdana; font-size: 12px;"></div>
<br/><br/><br/>
<?php echo $currentDate; ?>
<br/><br/><br/>
Dear Academic Advisor:
<br/><br/>
I am requesting academic credit toward my intended degree program based on my prior learning. 
Please find attached my "Learning Inventory", a comprehensive list of my prior learning, including:
<ul>
<li>Military Training</li>
<li>Professional Training</li>
<li>National Examinations</li>
<li>Previously completed college course</li>
</ul>
The American Council on Education (ACE) has provided credit recommendations for the prior 
learning I obtained through military training, national examinations, 
and other professional training.  
<br/><br/>
I would greatly appreciate your review of the enclosed Learning Inventory to determine if my 
prior learning might apply toward my intended degree program. I understand this institution 
and my degree program will determine how my prior learning can be applied toward a degree.  
I will provide additional details and official transcripts as needed.
<br><br>
I produced this report using the Healthcare Virtual Career Network, www.vcn.org.
<br/><br/>
Thank you for your time and consideration.
<br/><br/><br/>
Sincerely,
<br/>
<?php echo $name; ?>
<br/>
</div>
<br/><br/>
</div>
</body>
</html>

