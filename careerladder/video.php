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
?>
<script type="text/javascript" src="<?php echo $basepath; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/javascripts/top_up-min.js"></script>
<script type="text/javascript">
  TopUp.host = "http://<?php echo $_SERVER["SERVER_NAME"]; ?>";
  //TopUp.host = window.location.protocol+"//"+window.location.host+"/";  
  TopUp.players_path = "<?php echo $basepath; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/players/";
  TopUp.images_path = "<?php echo $basepath; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/top_up/";
</script> 
  
 <?php 
 
 $onetcode = $_GET['onetcode'];
 $displaytitle = $_GET['displaytitle'];


 ?> 
  
  <div style="position: absolute; width: auto; height: auto; display: block;" class="te_top_up" id="top_up"><div class="te_wrapper te_flatlook"><div class="te_title" style="display: block;"><?php echo $displaytitle; ?></div><table class="te_frame" style="width: auto; height: auto;"><tbody><tr class="te_top"><td class="te_left te_corner"><div class="te_left_filler"></div></td><td class="te_middle te_rib"></td><td class="te_right te_corner"><div class="te_right_filler"></div></td></tr><tr class="te_middle"><td class="te_left te_rib"></td><td class="te_middle"><div class="te_content" style="width: auto; height: auto;"><!-- Content --><div width="425" height="344" class="" style="width: 425px; height: 344px; display: block;"><object width="425" height="344" classid="clsid:D27CDB6E-AE6D-11CF-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" style=""><param name="movie" value="http://<?php echo $_SERVER["SERVER_NAME"] . $basepath; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/players/flvplayer.swf"><param name="flashvars" value="file=http://<?php echo $_SERVER["SERVER_NAME"] . $basepath; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/videos/<?php echo $onetcode; ?>.flv&amp;autostart=true"><param name="allowfullscreen" value="false"><embed width="425" height="344" src="http://<?php echo $_SERVER["SERVER_NAME"] . $basepath; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/players/flvplayer.swf" flashvars="file=http://<?php echo $_SERVER["SERVER_NAME"] . $basepath; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/videos/<?php echo $onetcode; ?>.flv&amp;autostart=true" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://get.adobe.com/flashplayer/"></object></div></div></td><td class="te_right te_rib"></td></tr><tr class="te_bottom"><td class="te_left te_corner"></td><td class="te_middle te_rib"></td><td class="te_right te_corner"></td></tr></tbody></table><div style="display: none" class="te_controls"><a onclick="TopUp.previous()" class="te_previous_link"></a><a onclick="TopUp.next()" class="te_next_link"></a></div><a style="display: block;" onclick="TopUp.close()" class="te_close_link"></a></div></div>