<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
//vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-one');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','1');



//To disable the activities in the step
$(document).ready(function(){	
//$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
});
</script>
<?php
    $topup_js = drupal_get_path('module','occupations_detail') . "/javascripts/top_up-min.js";
    drupal_add_js($topup_js);
//    $topup_js = "<script type='text/javascript' src='http://gettopup.com/releases/latest/top_up-min.js'></script>";
//    drupal_set_html_head($topup_js);
?>
<script type="text/javascript">
  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";
  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";
</script>
<!-- div class="vcn-gs-heading">Step 3 is designed to help you do three things:</div-->
<!--span class="vcn-gs-heading">Instructions</span-->
 <p class="font-14">Step 3 is designed to help you do four things:</p>
	<ol>
	<li>Determine whether the career you have chosen is a <a style="text-decoration : none; color:black" title="Licensed Career means that, before you can hold a job in this type of career you must first obtain permission from a state licensing board to practice; this is the same as what doctors or lawyers must do.">"Licensed Career"</a> in the state where you live or where you want to work and understand the state requirements for obtaining that license.</li>
	<br>
	<li>Identify the professional credential -- such as a certificate or degree -- that you need to qualify for an entry level job in your chosen career. </li>
	<br>
	<li>Select a school and education or training program suited to your needs and financial circumstances through which you can earn that credential.</li>
	<br>
	<li>Identify relevant certifications in your career area that you may also want to pursue after completing your initial education or training program.</li>
	  
	</ol>

<br/>

<!--
You should watch the Help video now.<a href="/careerladder/gsvideos/AACC_VCN3.flv" toptions="width = 425, height = 240, resizable = 1, layout=flatlook, shaded=1" title="Watch Video" alt="Watch Video">
            <img align="right" alt="Watch Video" class="watch-video-img" src="<?php echo base_path() . drupal_get_path('theme','zen_hvcp'); ?>/images/btn_video.jpg" />
        </a>
	-->