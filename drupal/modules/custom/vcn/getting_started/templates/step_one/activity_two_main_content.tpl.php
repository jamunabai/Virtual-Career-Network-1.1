<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-one');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','2');
</script>
<?php
/* Step 1 Act 1 and Act 2 need to be exchanged in order Task 4634
	$cma = vcnCma::getInstance();
	if ($cma->zipcode)
		$zipcode = $cma->zipcode;
?>
		<div id="step-1-actvity-3-main-content">
		
<p>Healthcare offers job and career opportunities for everyone - including you!</p>  
<p>Choosing a healthcare career is choosing job security now and in the future.</p>

<p>There are millions of healthcare jobs available now across the United States.  You may begin work in many jobs after receiving a certificate that takes less than a year to get. Many other jobs require just a two year degree from a community college.  A healthcare career will give you stability and opportunity to advance.</p>  

<p>In healthcare, you may choose from over 200 hundred types of jobs that range in level of skills needed and in work place settings. For example, you may choose to work in health information technology or lab technician jobs or you may choose to work directly with patients to solve health problems and ensure wellness in positions such as respiratory therapist or dietician.  All of these jobs are different, and getting started can start here.</p>  
		

    <p class="font-14">Below are some additional information designed to expose you to different kinds of healthcare careers. </p>
    <ul style ="list-style : disc">
        <li>Play <a onclick="$('#step-1-actvity-3-sidebar-content').children().hide();$('#step-1-actvity-3-sidebar-content-pursuit').show();
		$('#step-1-actvity-3-sidebar-content').height(345); ">Career Pursuit</a></li>
      	<!-- <li>Take a <a onclick="$('#step-1-actvity-3-sidebar-content').children().hide();$('#step-1-actvity-3-sidebar-content-quiz').show(); 
	    $('#step-1-actvity-3-sidebar-content').height(482); ">Career Quiz</a></li> -->
        <li>View <a onclick="$('#step-1-actvity-3-sidebar-content').children().hide();$('#step-1-actvity-3-sidebar-content-video').show();">Career Videos</a></li>
        <!--  li>Review Sample <a onclick="$('#loading').removeClass('off');  $('#step-1-actvity-3-sidebar-content').load('/careerladder/jobopenings.php?zipcode=<?php echo $zipcode; ?>', function() {
	 	$('#loading').addClass('off');
		});  ">Job Openings</a> in Your Area</li-->
		<?php $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
		$base_path = base_path(); ?>
		<!-- li>View <a href="<?php echo $url.$base_path.'top10byjobs';?>" target="_blank" style="color:#A71E28;">Top 10 by Jobs</a></li>
		<li>View <a href="<?php echo $url.$base_path.'top10bygrowth';?>" target="_blank" style="color:#A71E28;">Top 10 by Growth</a></li>
		<li>View <a href="<?php echo $url.$base_path.'top10bypay';?>" target="_blank" style="color:#A71E28;">Top 10 by Pay</a></li-->
    </ul>
</div>
<script type="text/javascript">

To disable the activities in the step
//$(document).ready(function(){	
//	$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
//	$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
// });

</script>
*/ ?>



<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-one');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','1');

function textchange(onoff) {

if (onoff) {
	document.getElementById('moreless').style.display = 'block';
	document.getElementById('morelesstexton').style.display = 'none';
	document.getElementById('morelesstextoff').style.display = 'block';
	
}
else {
	document.getElementById('moreless').style.display = 'none';
	document.getElementById('morelesstexton').style.display = 'block';
	document.getElementById('morelesstextoff').style.display = 'none';	
}

}
</script>
<?php
    $topup_js = drupal_get_path('module','occupations_detail') . "/javascripts/top_up-min.js";
    drupal_add_js($topup_js);
//    $topup_js = "<script type='text/javascript' src='http://gettopup.com/releases/latest/top_up-min.js'></script>";
//    drupal_set_html_head($topup_js);
?>
<style>
.te_close_link {
left: 591px;
}
</style>
<script type="text/javascript">
  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";
  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";
</script>
<div id="step-1-actvity-1-main-content">
    <!-- div class="vcn-gs-heading">Instructions</div-->
    <p class="font-14">
The CareerGuide consists of 5 Steps.  Each Step has one or more activities that will guide you through the things you need to know and the decisions you need to make to begin a career in Healthcare: </p>
		
	<?php $browser = explode(';', $_SERVER['HTTP_USER_AGENT']); if (!strstr($browser[1],'MSIE 7.0')): ?>
	<ul style ="list-style : disc">
	<?php endif; ?>
	
	<li><b>Step 1 : Get Started</b> -- Learn about the CareerGuide and how to use it. </li>
	<li><b>Step 2 : Choose Career</b> -- Select the healthcare career that is the best fit for your interests, preferences, and experience.</li>
	<li><b>Step 3 : Find Education</b> -- Choose an education or training program that leads to the credential you need to be successful in that career.</li>
	<li><b>Step 4 : Prepare and Apply</b> -- Find out about the school and program's entrance requirements and what you will need to do to meet them.</li>
	<li><b>Step 5 : Earn College Credit</b> -- Determine whether you might already have earned valuable college credits based on your prior learning and experience.</li> 
	</ul>

	
	
	<!-- p class="font-14"  style="width:53%" >
	
	        <a href="/careerladder/gsvideos/AACC_VCN1.flv" toptions="width = 425, height = 240, resizable = 1, layout=flatlook, shaded=1" title="How to use GA Video" alt="Watch Video" >
            <img align="right" alt="Watch Video" class="watch-video-img" src="<?php echo base_path() . drupal_get_path('theme','zen_hvcp'); ?>/images/btn_video.jpg" />
        </a>
	Watch how to use VCN Video</p-->

</div>
<!-- <?php echo base_path(); ?>sites/all/modules/custom/vcn/getting_started/videos/helpvideocomingsoon.flv -->