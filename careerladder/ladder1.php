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
HEARING / SPEECH CAREERS SAMPLE PATHWAY
</strong>
</font>
</center>
<hr style="border-top: none; border-bottom:1px solid #000000;" />

<div style="position:relative;">

<div style="margin-left: 250px; margin-top:105px; position: absolute;">
<img src="ladder1-images/sarrow.jpg">
</div>

<div style="margin-left:205px; margin-top:70px;position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Audiologist</u><br/>Percent growth: 24%<br/>Typical Annual Salary: $44,380 - $78,080'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=29-1181.00','_parent');" style="cursor:pointer;" src="ladder1-images/sp1.jpg">
</span>
</div>


<div style="margin-left:162px; margin-top:154px;position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Hearing Aid Specialist</u><br/>Percent growth: 18%<br/>Typical Annual Salary: $27,330 - $49,610'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=29-2092.00','_parent');" style="cursor:pointer;" src="ladder1-images/sp2.jpg">
</span>
</div>


<div style="margin-left:115px; margin-top:233px;position:absolute;">
<span class="hotspot" onmouseover="tooltip.show('<u>Speech Language Pathology Assistant</u><br/>Percent growth: 17%<br/>Typical Annual Salary: $21,900 - $36,060'); " onmouseout="tooltip.hide(); ">
<img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=31-9099.01','_parent');" style="cursor:pointer;" src="ladder1-images/sp3.jpg">
</span>
</div>

</div>

<div style="margin-left:10px; margin-top:300px; position: absolute; color:#31849B;">
<hr style="border-top: none; border-bottom:1px solid #000000;" />
<br/>
<strong>Pathway Note:</strong> Each box with an "EL" symbol is an "entry-level" occupation. The bottom row of occupations takes the least amount of time for education and training, including on-the-job-training.  
<br/><br/>
Any occupation with the" EL" symbol above the bottom row can also be an entry-level choice if one invests more time for education and training, but it also is the next-step-up-the-ladder.
</div>