<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-four');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','7');
</script>

<table border="0">
<tr>
<?php if ($vars['GETTINGSTARTED']['hsgrad']): ?>
	<td><div id="vcn-gs-uk-hsgrad" class="vcn-gs-target"><span>HS Grad?: </span><?php echo $vars['GETTINGSTARTED']['hsgrad']; ?></div></td>
<?php else: ?>
	<td><div id="vcn-gs-uk-hsgrad" class="vcn-gs-target"><span>HS Grad?: </span>Yes</div></td>
<?php endif;?>
<td>
<?php $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
$base_path = base_path(); ?>
<a href="<?php echo $base_path.'getting-started/step-four/2';?>" style="color:#A71E28;" id="various1">Edit</a>  	
</td>
</tr>

<tr>
<?php if ($vars['GETTINGSTARTED']['testscores']): ?>
	<td><div id="vcn-gs-uk-testscores" class="vcn-gs-target"><span>Test Scores: </span><?php echo $vars['GETTINGSTARTED']['testscores']; ?></div></td>
<?php else: ?>
	<td><div id="vcn-gs-uk-testscores" class="vcn-gs-target"><span>Test Scores: </span>Yes</div></td>
<?php endif;?>
<td>
<a href="<?php echo $base_path.'getting-started/step-four/3';?>" style="color:#A71E28;" id="various1">Edit</a>  	
</td>
</tr>

<tr>
<?php if ($vars['GETTINGSTARTED']['prequisitecourses']): ?>
	<td><div id="vcn-gs-uk-prequisitecourses" class="vcn-gs-target"><span>Prerequisite Courses: </span><?php echo $vars['GETTINGSTARTED']['prequisitecourses']; ?></div></td>
<?php else: ?>
	<td><div id="vcn-gs-uk-prequisitecourses" class="vcn-gs-target"><span>Prerequisite Courses: </span>No</div></td>
<?php endif;?>
<td>
<a href="<?php echo $base_path.'getting-started/step-four/4';?>" style="color:#A71E28;" id="various1">Edit</a>  	
</td>
</tr>
</table>




<script type="text/javascript">
//To disable the activities in the step
$(document).ready(function(){	
//$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
});
</script>