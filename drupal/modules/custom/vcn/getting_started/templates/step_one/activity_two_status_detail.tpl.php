<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script>

   
function display(i) { 


 var timeInSecs=12;

var divIds=new Array(); 
divIds[0]="vcn-gs-step-1-activity-1-status-content-1"; 
divIds[1]="vcn-gs-step-1-activity-1-status-content-2"; 
divIds[2]="vcn-gs-step-1-activity-1-status-content-3"; 
divIds[3]="vcn-gs-step-1-activity-1-status-content-4";
divIds[4]="vcn-gs-step-1-activity-1-status-content-5";
divIds[5]="vcn-gs-step-1-activity-1-status-content-6";
divIds[6]="vcn-gs-step-1-activity-1-status-content-7";
divIds[7]="vcn-gs-step-1-activity-1-status-content-8";

    for (var j = 0; j < divIds.length;j++) {
        if (j == i) {
            document.getElementById(divIds[i]).style.display = '';
        }
        else {
            document.getElementById(divIds[j]).style.display = 'none'; 
        }
    }
    if (i < divIds.length-1) {
        i++
        setTimeout('display(' + i + ')',timeInSecs*1000);
    }
    else
    {
        setTimeout('display(0)',timeInSecs*1000);
    }
}
    

</script>

    <?php
     /*
<div id="step-1-actvity-1-status-content">
    <?php $rs_class = 'class="activity-3"';  ?>
    <div id="vcn-gs-recommendation" <?php echo $rs_class; ?> >
      <p class="red">Your VCN Recommendation Score</p>
      <div id="vcn-gs-recommendation-score">&nbsp;</div>
    </div>
</div>
    */  ?>
	


<div id="step-1-actvity-1-status-content">
    <div class="vcn-gs-heading"></div>
    <div class="intro" id ="vcn-gs-step-1-activity-1-status-content-1" >As one of the largest industries in 2008, healthcare provided 14.3 million jobs for wage and salary workers.</div>
    <div class="intro" id ="vcn-gs-step-1-activity-1-status-content-2" >Ten of the 20 fastest growing careers are healthcare related.</div>
	<div class="intro" id ="vcn-gs-step-1-activity-1-status-content-3" >Healthcare will generate 3.2 million new wage and salary jobs between 2008 and 2018, more than any other industry, largely in response to rapid growth in the elderly population.</div>
	<div class="intro" id ="vcn-gs-step-1-activity-1-status-content-4" >20% of all new jobs created between now and 2014 will be healthcare related and most of these jobs will require 4 years of college or less.</div>
	<div class="intro" id ="vcn-gs-step-1-activity-1-status-content-5" >Most workers have jobs that require less than 4 years of college education, but health diagnosing and treating practitioners are highly educated.</div>
	<div class="intro" id ="vcn-gs-step-1-activity-1-status-content-6" >About 595,800 establishments make up the healthcare industry; these establishments vary greatly in terms of size, staffing patterns, and organizational structures.</div>
	<div class="intro" id ="vcn-gs-step-1-activity-1-status-content-7" >About 76 percent of healthcare establishments are offices of physicians, dentists, or other health practitioners.</div>
	<div class="intro" id ="vcn-gs-step-1-activity-1-status-content-8" >Although hospitals constitute only 1 percent of all healthcare establishments, they employ 35 percent of all workers.</div>
	
	
<script language="javascript" xmlns="http://www.w3.org/1999/xhtml">display(0)</script>
	
    <?php $rs_class = 'class="activity-1"';  ?>
	<?php     
	  /*TODO REMOVED BY GINA per James
	    <div id="vcn-gs-recommendation" <?php echo $rs_class; ?> >
	      <p class="red">Your VCN Recommendation Score</p>
	      <div id="vcn-gs-recommendation-score">&nbsp;</div>
	    </div>
	    
	*/
	?>    
</div>