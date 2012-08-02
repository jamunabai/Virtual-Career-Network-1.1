<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php require_once('../drupal/sites/default/hvcp.functions.inc');$basepath = $GLOBALS['hvcp_config_default_base_path'];$pieces = explode("/",$_SERVER['HTTP_REFERER']);if ($_SERVER["SERVER_NAME"]=="localhost")	$base = $_SERVER["SERVER_NAME"];else	$base = $pieces[2]; ?><style>.imgA1 { 	top: 0px; 	left: 0px; 	z-index: 1;} .imgB1 { 	top: -442px; 	left: -253px; 	z-index: 3; } .imgC1 { 	position: relative;	top: -442px; 	left: -253px; 	z-index: 3; } * {margin:0; padding:0}body {font:11px/1.5 Verdana, Arial, Helvetica, sans-serif; background:#FFF}#text {margin:50px auto; width:500px}.hotspot {color:#900; padding-bottom:1px;  cursor:pointer}#tt {position:absolute; display:block; background:url(tt_left.gif) top left no-repeat}#tttop {display:block; height:5px; margin-left:5px; background:url(tt_top.gif) top right no-repeat; overflow:hidden}#ttcont {display:block; padding:2px 12px 3px 7px; margin-left:5px; background:#666; color:#FFF}#ttbot {display:block; height:5px; background:url(tt_bottom.gif) top right no-repeat; overflow:hidden}</style><script type="text/javascript" language="javascript" src="script.js"></script><center><font color="31849B" size="3px"><strong>PHARMACY SAMPLE OCCUPATION PATHWAY</strong></font></center><hr style="border-top: none; border-bottom:1px solid #000000;" /><div style="position:relative;"><div style="margin-left: 250px; margin-top:100px; position: absolute;"><img src="ladder3-images/pharmarrows.jpg"></div><div style="margin-left:155px; margin-top:50px; position:absolute;"><img src="ladder3-images/pharmacists.jpg"></div><div style="margin-left:155px; margin-top:155px; position:absolute;"><span class="hotspot" onmouseover="tooltip.show('<u>Pharmacy Technicians</u><br/>Percent growth: 30%<br/>Typical Annual Salary: $20,940 - $32,950'); " onmouseout="tooltip.hide(); "><img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=29-2052.00','_parent');" style="cursor:pointer;" src="ladder3-images/pharmtechs.jpg"></span></div><div style="margin-left:155px; margin-top:271px; position:absolute;"><span class="hotspot" onmouseover="tooltip.show('<u>Pharmacy Aides</u><br/>Percent growth: -6%<br/>Typical Annual Salary: $17,330 - $24,840'); " onmouseout="tooltip.hide(); "><img onclick="window.open('http://<?php echo $base; ?><?php echo $basepath; ?>careerdetails?onetcode=31-9095.00','_parent');" style="cursor:pointer;" src="ladder3-images/pharmacyaides.jpg"></span></div></div><div style="margin-left:10px; margin-top:350px; position: absolute; color:#31849B;"><hr style="border-top: none; border-bottom:1px solid #000000;" /><br/><strong>Pathway Note:</strong> Each box with an "EL" symbol is an "entry-level" occupation. The bottom row of occupations takes the least amount of time for education and training, including on-the-job-training.  <br/><br/>Any occupation with the" EL" symbol above the bottom row can also be an entry-level choice if one invests more time for education and training, but it also is the next-step-up-the-ladder.</div>