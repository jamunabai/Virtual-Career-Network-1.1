<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
require_once('vcn.rest.inc'); 

$rest = new vcnRest;

$rest->setService('occupationsvc');
$rest->setModule('occupation');
$rest->setAction('list');

if ($_GET['groupid'])
$rest->setRequestKey('group_id',$_GET['groupid']);

// standard filters
$rest->setRequestKey('format','xml');
$rest->setRequestKey('limit','10');

$rest->setMethod('post');

$content = $rest->call();

$content = new SimpleXMLElement($content);
$rowcount = $content->status->rowcount;
$content = $content->data;
	
?>
<div class="vcn-gs-heading">Career Quiz Results</div>

Based on your quiz results...<br/><?php echo $rowcount; ?> healthcare careers

<?php

   if ($_GET['groupid']==8)
	echo " for occupations related to <b>Medical, Dental & Nursing</b>";
   if ($_GET['groupid']==14)
	echo " for occupations related to <b>Counseling, Therapy & Pharmacy</b>";	
   if ($_GET['groupid']==13)
	echo " for occupations related to <b>Vision, Speech/Hearing, Diet</b>";		
   if ($_GET['groupid']==1)
	echo " for occupations related to <b>Lab Work & Imaging</b>";		
   if ($_GET['groupid']==6)
	echo " for occupations related to <b>Office & Research Support</b>";	

?>
<br/><ul>
<?php

$basepath = $GLOBALS['hvcp_config_default_base_path'];

foreach($content->occupation as $occupation)
	echo "<li style='margin-left:-20px; line-height:20px; font-size:12px;'><a href='".$basepath."careerdetails?onetcode=".$occupation->onetcode."'>".$occupation->displaytitle."</a></li>";

?>
</ul>