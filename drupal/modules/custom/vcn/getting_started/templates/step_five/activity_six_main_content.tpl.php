<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-five');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','6');


//To disable the activities in the step
$(document).ready(function(){	
//$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
});
</script>
<!--div class="vcn-gs-heading">Summary of My Career Learning</div-->

<h4>Summary of my Career Learning</h4>
<p>
After you've entered information about all your prior learning, you will have an inventory of your 
prior learning that might be applied to your intended degree program. Remember that this inventory 
is an estimate of potential academic credit. Each college determines whether (and how) your prior 
learning will be applied to a specific degree program. 
</p>
<p>
Once you choose a college and degree program, schedule a meeting with an advisor and print the 
summary of your Learning Inventory to share with him or her. This Learning Inventory will help 
you and your advisor develop a degree plan, showing how your prior learning meets specific 
requirements and what courses you have left to complete.
</p>

<?php
/** Set $gsStep below to a unique identifier for the page: **/
$gsStep="step-five-5";

// if the session array is not initialized, initialize it
if(!is_array($_SESSION['gsStepCountArray']))$_SESSION['gsStepCountArray']=array();
// add individual page value to the array, if it doesn't already exist.
$_SESSION['gsStepCountArray'][$gsStep]=1;

// uncomment the line below to clear the gsStepCountArray for testing
//$_SESSION['gsStepCountArray']=array();

// count the number of items in gsStepCountArray and figure a percentage
$gsStepItemCount=count($_SESSION['gsStepCountArray']);
$gsPctDone=floor($gsStepItemCount/24*100);

// refresh the progress bar with the new percentages
echo "<script type=\"text/javascript\">
    document.getElementById('gsProgressBar').innerHTML = '<div class=\"progress-container\" style=\"width:80%;\"><div style=\"width:$gsPctDone%\"></div></div><div style=\"float:left;\">$gsPctDone%</div>';
  </script>";
?>