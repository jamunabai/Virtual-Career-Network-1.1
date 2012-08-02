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
    <div class="vcn-gs-heading">How to Earn College Credit<br/><br/></div>
    <div id="video-link">
        <a href="/careerladder/gsvideos/AACC_VCN4.flv" toptions="width = 425, height = 240, resizable = 1, layout=flatlook, shaded=1" title="Watch Video" alt="Watch Video">
         <img height="154" width="188" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/getting_started/images/step5.png" alt="Watch Video" class="imgA1">
         <img src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/play.png" alt="Play" class="imgB1">
         </a>

    </div>
</div>
