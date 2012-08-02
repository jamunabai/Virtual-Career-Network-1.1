<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
require_once('../drupal/sites/default/hvcp.functions.inc');

$basepath = $GLOBALS['hvcp_config_default_base_path'];

$pieces = explode("/",$_SERVER['HTTP_REFERER']);

if ($_SERVER["SERVER_NAME"]=="localhost")
	$base = $_SERVER["SERVER_NAME"];
else
	$base = $pieces[2]; 
?>
<style>
.imgA1 { 

	top: 0px; 
	left: 0px; 
	z-index: 1;
} 

.imgB1 { 
	top: -442px; 
	left: -253px; 
	z-index: 3; 
} 
.imgC1 { 
	position: relative;
	top: -442px; 
	left: -253px; 
	z-index: 3; 
} 

* {margin:0; padding:0}
body {font:11px/1.5 Verdana, Arial, Helvetica, sans-serif; background:#FFF}
#text {margin:50px auto; width:500px}
.hotspot {color:#900; padding-bottom:1px;  cursor:pointer}

#tt {position:absolute; display:block; background:url(tt_left.gif) top left no-repeat}
#tttop {display:block; height:5px; margin-left:5px; background:url(tt_top.gif) top right no-repeat; overflow:hidden}
#ttcont {display:block; padding:2px 12px 3px 7px; margin-left:5px; background:#666; color:#FFF}
#ttbot {display:block; height:5px; background:url(tt_bottom.gif) top right no-repeat; overflow:hidden}


</style>
<script type="text/javascript" language="javascript" src="script.js"></script>


<center>
<font color="31849B" size="3px">
<strong>
MEDICAL OFFICE AND RECORDS CAREERS SAMPLE PATHWAY
</strong>
</font>
</center>
<hr style="border-top: none; border-bottom:1px solid #000000;" />

<div style="position:relative;">

<div style="margin-left: 150px; margin-top:100px; position: absolute;">
<img src="ladder2-images/med.jpg">
</div>

<div style="margin-left:95px; margin-top:68px; position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Biostatisticians</u><br/>Percent growth: 13%<br/>Typical Annual Salary: $43,790 - $90,930'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=15-2041.01','_parent');" style="cursor:pointer;" src="ladder2-images/med6.jpg">
</span>
</div>


<div style="margin-left:290px; margin-top:94px; position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Informatics Nurse Specialist</u><br/>Percent growth: 20%<br/>Typical Annual Salary: $52,070 - $94,610'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=15-1121.01','_parent');" style="cursor:pointer;" src="ladder2-images/med7.jpg">
</span>
</div>


<div style="margin-left:576px; margin-top:104px; position:absolute;">
<img src="ladder2-images/med2.jpg">
</div>


<div style="margin-left:761px; margin-top:104px; position:absolute;">
<img src="ladder2-images/med9.jpg">
</div>

<div style="margin-left:60px; margin-top:227px; position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Medical Transcriptionists</u><br/>Percent growth: 11%<br/>Typical Annual Salary: $24,580 - $37,730'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=31-9094.00','_parent');" style="cursor:pointer;" src="ladder2-images/med3.jpg">
</span>
</div>

<div style="margin-left:329px; margin-top:230px; position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Registered Nurse</u><br/>Percent growth: 22%<br/>Typical Annual Salary: $47,460 - $76,070'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=29-1141.00','_parent');" style="cursor:pointer;" src="ladder2-images/med5.jpg">
</span>
</div>

<div style="margin-left:677px; margin-top:230px; position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Medical Assistants</u><br/>Percent growth: 33%<br/>Typical Annual Salary: $21,970 - $33,190'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=31-9092.00','_parent');" style="cursor:pointer;" src="ladder2-images/med8.jpg">
</span>
</div>

<div style="margin-left:55px; margin-top:408px; position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Medical Records and Health Information Technicians</u><br/>Percent growth: 20%<br/>Typical Annual Salary: $22,450 - $39,590'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=29-2071.00','_parent');" style="cursor:pointer;" src="ladder2-images/med10.jpg">
</span>
</div>

<div style="margin-left:361px; margin-top:408px; position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Medical Secretaries</u><br/>Percent growth: 26%<br/>Typical Annual Salary: $22,640 - $35,850'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=43-6013.00','_parent');" style="cursor:pointer;" src="ladder2-images/med1.jpg">
</span>
</div>

<div style="margin-left:648px; margin-top:408px; position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Patient Representatives</u><br/>Percent growth: 17%<br/>Typical Annual Salary: $21,240 - $38,000'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=43-4051.03','_parent');" style="cursor:pointer;" src="ladder2-images/med4.jpg">
</span>
</div>


</div>

<div style="margin-left:10px; margin-top:500px; position: absolute; color:#31849B;">
<hr style="border-top: none; border-bottom:1px solid #000000;" />
<br/>
<strong>Pathway Note:</strong> Each box with an "EL" symbol is an "entry-level" occupation. The bottom row of occupations takes the least amount of time for education and training, including on-the-job-training.  
<br/><br/>
Any occupation with the" EL" symbol above the bottom row can also be an entry-level choice if one invests more time for education and training, but it also is the next-step-up-the-ladder.
</div>