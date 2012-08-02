<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
    $topup_js = drupal_get_path('module','occupations_detail') . "/javascripts/top_up.js";
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

<html>
<p>You have completed CareerGuide. As you complete your education and training, please come back and log on again our Guide to VCN and update your Career Management Account. </p>
<p>To help you with your healthcare career plans, below is a summary of the information and process you
have completed</p>
<ul style ="list-style : disc">
<li>You have identified a Target Career <b><?php echo $vars['target_occupation-title']; ?></b></li>
<li>You have selected an instructional program <b><?php echo $vars['target_programname']; ?></b></li>
<li>You have reviewed the career and program requirements</li>
<li>You have reviewed the financial aid information</li>
<li>You have developed your <b>Career Learning Summary</b></li>

</ul>
</html>
<script>
$(document).ready(function(){
	$('#vcn-gs-btn-next').hide();
	$('#vcn-gs-btn-ano-next').hide();
	//$('#vcn-gs-btn-home').show();
})



//To disable the activities in the step
$(document).ready(function(){
	$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
	$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
 });

</script>

<br />
<a style = "margin-left:180px;" href="<?php echo base_path();?>"  title="Done" alt="Done" >
<img alt="Home" class="watch-video-img" src="<?php echo base_path() . drupal_get_path('theme','zen_hvcp'); ?>/images/button_done.png" />
</a>
