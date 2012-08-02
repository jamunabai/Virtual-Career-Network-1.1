<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
     // var check
   	$vars  = isset($vars) ? $vars : array() ;
	$hide_search  = ( array_key_exists('hide_search', $vars) AND $vars['hide_search']) ? true : false ;  
 	$cma = $vars['cma'];
?>

<div id="vcn-portal-search" >
<form id="vcn-portal-form" method="post" autocomplete="off"  action="<?php echo base_path(); ?>portal/<?php echo $vars['type']; ?>/" onsubmit="return filterPortal(this);" > 
	<input type="hidden" id="limit" name="limit" value="<?php echo $vars['limit']; ?>" />
	<input type="hidden" id="pg" name="pg" value="<?php echo $vars['pg']; ?>" />
	<input type="hidden" id="order" name="order" value="<?php echo $vars['order']; ?>" />
	<input type="hidden" id="direction" name="direction" value="<?php echo $vars['direction']; ?>" />

	<!-- LIMITS     -->
	<input type="hidden" id="limit_providers" name="limit_providers" value="<?php echo $vars['limit_providers']; ?>" />
	<input type="hidden" id="limit_programs" name="limit_programs" value="<?php echo $vars['limit_programs']; ?>" />
	<input type="hidden" id="limit_teachers" name="limit_teachers" value="<?php echo $vars['limit_teachers']; ?>" />
	<input type="hidden" id="limit_courses" name="limit_courses" value="<?php echo $vars['limit_courses']; ?>" />

	
	<!-- ORDER      -->
	<input type="hidden" id="order_providers" name="order_providers" value="<?php echo $vars['order_providers']; ?>" />
	<input type="hidden" id="order_programs" name="order_programs" value="<?php echo $vars['order_programs']; ?>" />
	<input type="hidden" id="order_teachers" name="order_teachers" value="<?php echo $vars['order_teachers']; ?>" />
	<input type="hidden" id="order_courses" name="order_courses" value="<?php echo $vars['order_courses']; ?>" />


	<!-- DIRECTION  -->
	<input type="hidden" id="direction_providers" name="direction_providers" value="<?php echo $vars['direction_providers']; ?>" />
	<input type="hidden" id="direction_programs" name="direction_programs" value="<?php echo $vars['direction_programs']; ?>" />
	<input type="hidden" id="direction_teachers" name="direction_teachers" value="<?php echo $vars['direction_teachers']; ?>" />
	<input type="hidden" id="direction_courses" name="direction_courses" value="<?php echo $vars['direction_courses']; ?>" />

	<!-- COUNTS     -->
	<input type="hidden" id="count_providers" name="count_providers" value="<?php echo $vars['count_providers']; ?>" />
	<input type="hidden" id="count_programs" name="count_programs" value="<?php echo $vars['count_programs']; ?>" />
	<input type="hidden" id="count_teachers" name="count_teachers" value="<?php echo $vars['count_teachers']; ?>" />
	<input type="hidden" id="count_courses" name="count_courses" value="<?php echo $vars['count_courses']; ?>" />

	<!-- PAGE       -->
 	<input type="hidden" id="pg_providers" name="pg_providers" value="<?php echo $vars['pg_providers']; ?>" />
	<input type="hidden" id="pg_programs" name="pg_programs" value="<?php echo $vars['pg_programs']; ?>" />
	<input type="hidden" id="pg_teachers" name="pg_teachers" value="<?php echo $vars['pg_teachers']; ?>" />
	<input type="hidden" id="pg_courses" name="pg_courses" value="<?php echo $vars['pg_courses']; ?>" />
	
	
	

</form>
</div>

<form>
	<!-- PROVIDERS -->
	<input type="hidden" id="unitid"  name="unitid" value="<?php echo $vars['unitid']; ?>" />
</form>