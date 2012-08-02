<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
 
	$hsgrad = ( isset($vars['GETTINGSTARTED']['hsgrad']) AND $vars['GETTINGSTARTED']['hsgrad'] == 'No') ? 'No' : 'Yes';
?>
<!--div class="vcn-gs-heading">High School Graduate?</div-->
 
<p>Do you have a high school diploma or a GED?</p>

<input type="radio" id="vcn-gs-hs-graduate-yes" name="vcn-gs-hs-graduate"  <?php if ($hsgrad == 'Yes') echo 'checked="checked"'; ?>
onclick="vcn_gs_toggle_main_detail_table ('off');  vcn_gs_saveUserKey ('GETTINGSTARTED','HS Grad','Yes');" /><label for="vcn-gs-hs-graduate-yes">Yes</label>
<br />
<input type="radio" id="vcn-gs-hs-graduate-no" name="vcn-gs-hs-graduate"  <?php if ($hsgrad == 'No') echo 'checked="checked"'; ?>
 onclick="vcn_gs_toggle_main_detail_table ('on'); vcn_gs_saveUserKey ('GETTINGSTARTED','HS Grad','No');"/><label for="vcn-gs-hs-graduate-no">No</label>
