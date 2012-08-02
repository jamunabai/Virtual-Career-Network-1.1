<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

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

<div id="step-1-actvity-1-sidebar-content">
    <div class="vcn-gs-heading">Why Healthcare?</div>
    <div id="video-link">
        <a href="/careerladder/gsvideos/AACC_VCN0.flv" toptions="width = 425, height = 240, resizable = 1, layout=flatlook, shaded=1" title="Watch Video" alt="Watch Video">
         <img height="212" width="212" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/video_cap.jpg" alt="Watch Video" class="imgA1">
         <img src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/play.png" alt="Play" class="imgB1">
         </a>

    </div>
</div>


<?php $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
		$base_path = base_path(); ?>
		
<br /><br />
    		
<div class ="xouter">
	<div class = "xleftcol">
		<a toptions="type = iframe, width = 900, height = 700, resizable = 1, layout=flatlook, title=Always in Demand, scrolling=yes, shaded=1" href="<?php echo $base_path.'top10byjobs';?>">
        <img align="right" alt="Watch Video" title="Always in Demand" class="watch-video-img" src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/button_briefcase.png" />
        </a>
        <div style="text-align:center; margin-left:33px; font-size:10px;" class="noresize">Always in<br/>Demand</div>
	</div>
	<div class = "xmiddlecol">
		<a toptions="type = iframe, width = 900, height = 700, resizable = 1, layout=flatlook, title=Good Prospects, scrolling=yes, shaded=1" href="<?php echo $base_path.'top10bygrowth';?>">
        <img align="right" alt="Watch Video" title="Good Prospects" class="watch-video-img" src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/button_graph.png" />
        </a>
        <div style="text-align:center; margin-left:33px; font-size:10px;" class="noresize">Good Prospects</div>
	</div>
	<div class = "xrightcol">
        <a toptions="type = iframe, width = 900, height = 700, resizable = 1, layout=flatlook, title=Excellent Pay, scrolling=yes, shaded=1" href="<?php echo $base_path.'top10bypay';?>">
        <img align="right" alt="Watch Video" title="Excellent Pay" class="watch-video-img" src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/button_dollar.png" />
        </a>
        <div style="text-align:center; margin-left:32px; font-size:10px;" class="noresize">Excellent Pay</div>
	</div>
</div>
<br />
