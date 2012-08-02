<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php // header( 'Cache-Control: private, max-age=10800, pre-check=10800' ); ?>
<style type="text/css">
ul { list-style: disc; }
</style>
<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-two');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','1');
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
  
  
function showhide21ga(value,onoff) {
alert(value);
	var first = (value.substr(0,value.length-4));

	if (document.getElementById(value).style.display=='none') {
		document.getElementById(value).style.display='block';
		document.getElementById(first).innerHTML='[-]';
		//document.getElementById(first+'br').innerHTML='';
	}
	else {
		document.getElementById(value).style.display='none';
		document.getElementById(first).innerHTML='[+]';
		//document.getElementById(first+'br').innerHTML='<br/>';
	}
}

</script>
<div>

<!-- span class="vcn-gs-heading">Introduction</span-->
<p>This step is designed to help you explore different healthcare careers and select the one most suitable for you. The right choice will depend on your interests and preferences, availability of jobs, and the typical wages offered. It may also depend on the availability of training, education, and the duration of that training or education. </p>
<p>To get an idea about which careers best match your interests, <font style="color:#189AB0;"><b>click on the blue "Match Your Interests to Careers" button on the right.</b></font> To better understand how healthcare careers relate to the amount of education you engage in, <font style="color:#189AB0;"><b>click on the blue "Match Your Education to Careers" button on the right.</b></font> When using these tools, just click on any of the resulting careers that are displayed to learn more about them. As you move further along in the CareerGuide, you will be able to save careers that interest you to a "wish list" and then later compare directly the key features of those on your wish list to help you select one of a "Career Target." </p>
<p>For ease of search, the healthcare careers have been grouped into five categories.</p>


<ul style="list-style: disc;">
<li><b>Medical, Dental & Nursing</b></li>
<span id="mdntext" style="display:inline;margin-bottom:20px;">These healthcare careers center around direct, hands-on support to the physicians, dentists, and teams of medical professionals who treat patients. Each involves working closely with patients - such as in hospital, office, or clinic settings.</span>
<br/><br/>

<li><b>Office & Research Support</b> </li>
<span id="orstext" style="display:inline;margin-bottom:20px;">These healthcare careers provide the start to finish administrative support needed to run our healthcare system, from greeting patients in medical and dental offices, to obtaining and maintaining their medical records, to compiling the data and doing the research needed to improve service delivery, to conducting community health outreach.</span>
<br/><br/>

<li><b>Lab Work & Imaging</b> </li>
<span id="lwitext" style="display:inline;margin-bottom:20px;">These healthcare careers represent the technologists and technicians who work in laboratories and treatment rooms to accurately diagnose patient problems, provide needed radiologic and other treatments, and fix and maintain complex healthcare equipment.</span>
<br/><br/>

<li><b>Counseling, Therapy & Pharmacy</b> </li>
<span id="ctptext" style="display:inline;margin-bottom:20px;">These healthcare careers center around the specialized healthcare professionals who provide counseling help, physical treatment, medication, or other services that aid patients in recovering or adjusting to illness or injury.</span>
<br/><br/>

<li><b>Vision, Speech/Hearing & Diet</b> </li>
<span id="vshtext" style="display:inline;margin-bottom:20px;">These are healthcare careers that primarily focus on and specialize in the five senses -- seeing, hearing/speaking, tasting, smelling, and feeling -- and address the important related issue of nutrition.</span>
<br/><br/>

</ul>
</div>

<iframe name="loadhere" src="" style="height: 0px; width: 0px; border: 0px;"></iframe>

<?php unset($_SESSION['url']);?>



<script type="text/javascript">
//To disable the activities in the step
$(document).ready(function(){	
//$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
//$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
});
</script>