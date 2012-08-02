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
<!--div class="vcn-gs-heading">Application</div-->
<?php if ($data['programs']) :?>
	<p>Below is the address of the school and the link to the school's application website page. 
	We recommend that you review the school's admission process carefully before you complete the application 
	form and submit your application. </p>
<?php else: ?>
	Sorry, you'll need to target a valid program for application information.
<?php endif;?> 


<script type="text/javascript">

//Get back to the step which a user has stoped in
vcn_gs_saveUserKey ('GETTINGSTARTED','store_the_step',5);

</script>