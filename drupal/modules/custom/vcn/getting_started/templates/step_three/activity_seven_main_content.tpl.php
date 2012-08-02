<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
$cma = vcnCma::getInstance();
module_load_include('inc', 'vcn', 'includes/vcn_common');

?>


<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-three');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','7');
</script>

<?php $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
$base_path = base_path(); ?>

<table border="0">
<tr>
<?php if ($vars['target_licensename']): ?>
<td><div id="vcn-gs-target-licensename" class="vcn-gs-target"><span>License: </span><?php echo $vars['target_licensename']; ?></div></td>
<td><a href="<?php echo $base_path.'getting-started/step-three/2';?>" style="color:#A71E28;" id="various1">Edit</a></td>  	
<?php else: ?>
<td><div id="vcn-gs-target-licensename" class="vcn-gs-target"><span>License: </span>No license targeted</div></td>
<td>

<a href="<?php echo $base_path.'getting-started/step-three/2';?>" style="color:#A71E28;" id="various1">Edit</a>  	
</td>
<?php endif;?>
</tr>




<tr>
<?php if ($vars['target_certname']): ?>
	<td><div id="vcn-gs-target-certname" class="vcn-gs-target"><span>Certification: </span><?php echo $vars['target_certname']; ?></div></td>
	<td><a href="<?php echo $base_path.'getting-started/step-three/5';?>" style="color:#A71E28;" id="various1">Edit</a> </td>
<?php else: ?>
	<td><div id="vcn-gs-target-certname" class="vcn-gs-target"><span>Certification: </span>No certification targeted</div></td>
<td>
<a href="<?php echo $base_path.'getting-started/step-three/5';?>" style="color:#A71E28;" id="various1">Edit</a>  	
</td>
<?php endif;?>
</tr>




<tr>
<?php //This is to get the targeted program from the rest call
if ($cma->mytargets->cma[0]->program->item->programname): ?>
	<td><div id="vcn-gs-target-programname" class="vcn-gs-target"><span>*Program: </span><?php echo $cma->mytargets->cma[0]->program->item->programname; ?></div></td>
	<td><a href="<?php echo $base_path.'getting-started/step-three/4';?>" style="color:#A71E28;" id="various1">Edit</a>  	</td>
<?php else: ?>
	<td><div id="vcn-gs-target-programname" class="vcn-gs-target"><span>*Program: </span>No program targeted</div></td>
	<script type="text/javascript">
	//this is to disable the next buttons if no career is targeted 
	$(document).ready(function() {
		$('#vcn-gs-btn-next').addClass('off');
		$("#vcn-gs-btn-next").attr('disabled',true);
		$('#vcn-gs-btn-ano-next').addClass('off');
		$("#vcn-gs-btn-ano-next").attr('disabled',true);
	// });
	</script>	
<td>
<a href="<?php echo $base_path.'getting-started/step-three/4';?>" style="color:#A71E28;" id="various1">Edit</a>  	
</td>		
<?php endif;?>
</tr>
</table>

<p>
<b>* Required Field :</b> Without required information you will not be able to go to the next step. 
</p>

<script type="text/javascript">

//To disable the activities in the step
$(document).ready(function(){	
//$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
});
</script>