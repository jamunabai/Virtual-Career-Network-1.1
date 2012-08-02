<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php //echo"G got it <br />";
$cma = vcnCma::getInstance();
function webserviceforcmaga($userid, $item_type='OCCUPATION'){
	    $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('notebook');
        $rest->setAction('get-notebook-items');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $userid);
         $rest->setRequestKey('item_type', $item_type);
       // $rest->setRequestKey('session_id', $this->sessionId);

        $rest->setMethod('post');


        $content = $rest->call();

        $content = new SimpleXMLElement($content);

        return $content;
}?>
<div style = "margin-left:143px;"> 
	<div style="margin-top:-90px; width: 475px;">
	<b> <p class="vcn-gs-heading" style="margin-top: -1px; margin-bottom: 31px; margin-left: 0px;"> CareerGuide </p> </b>
	<p><hr style="margin-top: 48px; position: absolute; width: 465px;"></p>
	<p style=" margin-top: -12px;"><b>The CareerGuide is the easiest way to navigate the Virtual Career Network. The four 
	easy-to-use wizards shown below will guide you, step by step, through all 
	the activities needed to qualify for a career in Healthcare.</b> </p>
	</div>
	<br />
	<script type="text/javascript">
	//To disable the activities in the step
	$(document).ready(function(){	
	//$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
	$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
	$('#vcn-gs-btn-ano-back').hide();
	$('#vcn-gs-btn-ano-next').hide();
	$('#vcn-gs-btn-back').hide();
	$('#vcn-gs-btn-next').hide();
	$('#vcn-gs-back-next').hide();
	$('#vcn-gs-activities').hide();
	$('#vcn-gs-navigation').hide();
	
	});
	</script>
	<div>
			<div onclick="location.href='<?php echo base_path()?>getting-started/step-one';" style="cursor:pointer;" id="leftcolumn">
			<img src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/career_exploration_on.jpg" />
			</div>
			<div onclick="location.href='<?php echo base_path()?>getting-started/step-one';" style="cursor:pointer;" id="rightcolumn">
			<p style="width:345px;" class="vcn-gs-heading-green"> Career Exploration </p> 
			<p style ="margin-top: -18px; width:345px;">Choose the best career for your interests and needs</p>
			</div>
			<?php 
			$careerfound = webserviceforcmaga($cma->userid,'career');
			$careerrank = $careerfound->data->notebookresults->item->itemrank;
			if((string)($careerrank)==1 && $vars['zip']) //if condition for the target is selected or not 
			{
			?>
				<br /><br /><br />
				<div onclick="location.href='<?php echo base_path()?>getting-started/step-three';" style="cursor:pointer;" id="leftcolumn">
				<img src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/college_prep_on.jpg" />
				</div>
				<div onclick="location.href='<?php echo base_path()?>getting-started/step-three';" style="cursor:pointer;" id="rightcolumn">
				<p style="width:345px;" class="vcn-gs-heading-green"> College Preparation & Application </p> 
				<p style ="margin-top: -18px; width:345px;">Find out if you can earn credits from you prior learning</p>
				</div>			
			<?php }else { ?>
				<br /><br /><br />
				<div id="leftcolumn">
				<img src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/college_prep_on.jpg" />
				</div>
				<div id="rightcolumn" >
				<p style="color:#666362; width:345px;" class="vcn-gs-heading-green"> College Preparation & Application </p> 
				<p style ="margin-top: -18px; color:#666362; width:345px;">Find out if you can earn credits from you prior learning</p>
				</div>
			<?php }?>
			
			
			<?php if ($vars['target_programname'] && $vars['zip']){ ?>
				<br /><br /><br />
				<div onclick="location.href='<?php echo base_path()?>getting-started/step-five';" style="cursor:pointer;" id="leftcolumn">
				<img src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/earn_credit_on.jpg" />
				</div>
				<div onclick="location.href='<?php echo base_path()?>getting-started/step-five';" style="cursor:pointer;" id="rightcolumn">
				<p style="width:345px;" class="vcn-gs-heading-green"> Earn College Credit </p> 
				<p style ="margin-top: -18px; width:345px;">Apply to college and get Financial Aid</p>
				</div>
			<?php } else {?>
				<br /><br /><br />
				<div id="leftcolumn">
				<img src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/earn_credit_on.jpg" />
				</div>
				<div id="rightcolumn">
				<p style="color:#666362; width:345px;" class="vcn-gs-heading-green"> Earn College Credit </p> 
				<p style ="margin-top: -18px; color:#666362; width:345px;">Apply to college and get Financial Aid</p>
				</div>
			<?php }?>
			
			<?php if ($vars['target_programname'] && $vars['zip']){ ?>
				<br /><br /><br />
				<div onclick="location.href='<?php echo base_path()?>getting-started/finished';" style="cursor:pointer;" id="leftcolumn">
				<img src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/summary_on.jpg" />
				</div>
				<div onclick="location.href='<?php echo base_path()?>getting-started/finished';" style="cursor:pointer;" id="rightcolumn">
				<p style="width:345px;" class="vcn-gs-heading-green"> Summary of Activities </p> 
				<p style ="margin-top: -18px; width:345px;">Find out what you have accomplished and what the next step is</p>
				</div>
			<?php } else {?>
				<br /><br /><br />
				<div id="leftcolumn">
				<img src="<?php echo base_path()?>/sites/all/modules/custom/vcn/getting_started/images/summary_on.jpg" />
				</div>
				<div id="rightcolumn">
				<p style="color:#666362; width:345px;" class="vcn-gs-heading-green"> Summary of Activities </p> 
				<p style ="margin-top: -18px; color:#666362; width:345px;">Find out what you have accomplished and what the next step is</p>
				</div>
			<?php }?>
	</div>
</div>