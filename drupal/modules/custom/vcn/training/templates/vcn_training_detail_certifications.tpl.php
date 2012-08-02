<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

$currentUrl = "http://" . $_SERVER['SERVER_NAME'] . base_path() . "find-learning/detail/certifications/cert_id/" . $data->certid;
$facebookTitle = "VCN.org Certification: " . $data->certname;

$facebookMetatags = new vcnFacebookMetatag($facebookTitle, $currentUrl, $data->certdescription);
drupal_set_html_head($facebookMetatags->getTags());
?>

<div id="training-detail" class="panel-2col panel-col-first">
	<div class="back-to-results">
		<!--  a onclick="return backToResults('cert_id');" href="<?php //echo base_path();?>find-learning/results">Back to results</a-->
	</div>
	
<form id="training-form" name="trainingform" method="post" autocomplete="off"  action="javascript:void(0);" onsubmit="caction('1'); return filterTraining(this);" > 
<input type = "hidden" id="occupation-title-one" name="occupation-title-one" value="<?php echo $data->certonetassign->occupation->displaytitle; ?>" />
</form>	

	<?php if ((string)$data->certonetassign->onetxwalk->occupation->item->title) : ?>	 	
		<h2>Career</h2>
		<span class="occupation-title"><?php echo $data->certonetassign->onetxwalk->occupation->item->title ?></span>
	<?php endif; ?>			
 
	<h3>Certification</h3>
	
	<br/>
	
	<div style="width:100%;">
		<div style="float:left; width:80%;">
			<span class="training-title"><strong style="text-decoration:underline;"><?php echo $data->certname; ?></strong></span>
		</div>
		<div style="float:left; text-align:right; vertical-align:middle; width:20%;">
			<?php
			$facebookLikeButton = new vcnFacebookLike($currentUrl);
			$facebookLikeButton->shiftTop = '0';
			$facebookLikeButton->shiftLeft = '0';
			echo $facebookLikeButton->getButton();
			?>
		</div>
		<div style="clear:left;"></div>
	</div>
	
	<p class="detail-description">
		<?php echo $data->certdescription; ?>
	</p>
			
	<div id="training-detail-info">
		<div id="training-detail-org">
			<a href="<?php echo $data->url; ?>" target="_blank">Click here</a> to find out what you need to do to obtain this certification
			<br/></br>
		
			<span class="detail-org">
		    	<a target="_blank" href="<?php echo $data->certorg->orgwebpag; ?>"><?php echo $data->certorg->orgname;?></a>
		    </span> 
		    <br />
		    <?php 
		    if ($data->certorg->orgaddres) echo $data->certorg->orgaddres.'<br />'; 
			?>
	  	</div>
<!-- 
		<div id="training-detail-prerequisites">
			<h2>Prerequisites (TBA) </h2>
		</div>
 -->
	</div>
</div>

<?php

global $user;

$logged_in = $user->uid;

$cma->usersession =  $logged_in ? 'U' : 'S';

?>

	 

<div id="training-sidebar" class="panel-2col panel-col-last" style="margin-left:766px; position: absolute;">
    <a class="save-to-notebook large<?php if ($user->uid=='U') echo 'u'; ?>" alt="Save this certification" title="Save this certification"  onclick="not_logged_in('<?php echo $cma->usersession; ?>','Certificate Saved temporarily in your wish list');return vcn_saveOrTargetToCMA (this,'certifications', 'cert_id', '<?php echo $data->certid; ?>','<?php echo $cma->usersession; ?>','Certificate Saved');"  href="<?php echo base_path(); ?>cma/notebook/save/certificate/<?php echo $data->certid; ?>"> </a>
    <a class="target-to-notebook large" alt="Target this certification" title="Target this certification" onclick="not_logged_in('<?php echo $cma->usersession; ?>','Certificate Targeted temporarily in your wish list'); return vcn_saveOrTargetToCMA ('<?php echo base_path(); ?>cma/notebook/target/certificate/<?php echo $data->certid; ?>','certifications', 'cert_id', '<?php echo $data->certid; ?>','<?php echo $cma->usersession; ?>','Certificate Targeted','<?php echo $cma->userid;?>');"  href="javascript:void(0);" > </a>
<!--
	<br /><br />
    <a class="in-my-neighborhood" alt="Show programs in my neighborhood" onclick="return searchMyNeighborhood('cert_id');" href=""> </a>
    <br /><br />
-->
	<?php  echo $content['sidebar'];  ?>
</div>
 
 
 