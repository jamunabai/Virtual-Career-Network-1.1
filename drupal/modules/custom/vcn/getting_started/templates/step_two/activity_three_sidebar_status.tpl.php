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

function deleteit(url,cmaCareerId) {
	//loadhere.location.href = url;
	myRef = window.open(url,'loadhere');
	//alert ('Career Deleted from Notebook');
	$(cmaCareerId).empty().remove();	
  $('#vcn-gs-btn-next').addClass('off');
  $("#vcn-gs-btn-next").attr('disabled',true);	
  $('#vcn-gs-btn-ano-next').addClass('off');
  $("#vcn-gs-btn-ano-next").attr('disabled',true);	
	
}

</script>
<div id="sidebar-height-container" style="font-size:12px; width:90%; padding-left:11px;">
<span class="vcn-gs-heading-black">My Target Career</span>
<br/><br/>


<div class="cmacontainer" id="cmacontainer6">

</div>

</div>


<script>


document.getElementById('cmacontainer6').innerHTML='';
	
$('#cmacontainer6').append('<div style="float:left; width:231px;"><?php echo $vars['target_occupation-title']; ?></div>');


</script>