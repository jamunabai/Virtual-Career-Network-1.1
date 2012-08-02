<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">//vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-one');vcn_gs_saveUserKey ('GETTINGSTARTED','activity','1');//To disable the activities in the step$(document).ready(function(){	//$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();});</script><?php    $topup_js = drupal_get_path('module','occupations_detail') . "/javascripts/top_up-min.js";    drupal_add_js($topup_js);//    $topup_js = "<script type='text/javascript' src='http://gettopup.com/releases/latest/top_up-min.js'></script>";//    drupal_set_html_head($topup_js);?><script type="text/javascript">  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";</script><?php//global $base_url;$base_url = base_path();$path=$base_url."/sites/all/modules/custom/vcn/getting_started/templates/step_five";$jsPath="$path/js/html-to-div.js";echo "<script type='text/JavaScript' src='$jsPath'></script>";?><!--div class="vcn-gs-heading">Introduction</div-->You might already be on your way to a degree or certification! Many colleges and universities award credit for prior military training, national exams, and professional training that have been evaluated by the American Council on Education (ACE) for college credit. It's called "prior learning assessment", or PLA, and it can help shorten the amount of time it takes for you to earn a degree and save you money.  For more information about PLA, <a href="javascript:popit('/careerladder/Resourcespdfs/PLA_Factsheet.pdf')">click here</a>.  In addition, college courses you have already completed might also be eligible for credit at your new college or university. <br/><br/>To apply for credit for prior learning, you often need to meet with an academic advisor. The college's admissions office can help you find the right person to meet with. The result of completing this process will be a personalized Learning Inventory.  Completing your personalized Learning Inventory can help you gather the information you need to bring along when you meet with that advisor. To see what a completed Learning Inventory looks like, <a href="javascript:popit('/healthcare/sites/all/modules/custom/vcn/pla_main/Learning_Inventory.pdf')">click here</a>. <br/><br/>This tool was developed for the VCN with the help of the American Council of Education (ACE), a leader in the PLA field. To learn more about ACE, <a href="javascript:popit('/careerladder/Resourcespdfs/Overview_of_ACE_Credit_Recommendations.pdf')">click here</a>.  