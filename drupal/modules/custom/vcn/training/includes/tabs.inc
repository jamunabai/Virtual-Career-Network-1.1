<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<div id="training-tabs">
<ul>
	<?php if ($vars['type'] == 'programs') : ?>
		<li class="toprndcrnr selected" ><span class="training-tab">Programs (<?php echo $vars['count_programs']; ?>)</span></li>
	<?php else: ?>
		<li class="toprndcrnr" >
	 		<a class="training-tab" href="#" onclick="return selectTrainingTab('programs');" >Programs (<?php echo $vars['count_programs']; ?>)</a> 
       </li>
	<?php endif;?>
		
		
	<?php if ($vars['type'] == 'certifications') : ?>
		<li class="toprndcrnr selected" ><span class="training-tab">Certifications (<?php echo $vars['count_certifications']; ?>)</span></li>
	<?php else: ?>
		<li class="toprndcrnr" >
	 		<a class="training-tab" href="#" onclick="return selectTrainingTab('certifications');" >Certifications (<?php echo $vars['count_certifications']; ?>)</a> 
        </li>
	<?php endif;?>
		
	 
	<?php if ($vars['type'] == 'licenses') : ?>
		<li class="toprndcrnr selected" ><span class="training-tab">Licenses (<?php echo $vars['count_licenses']; ?>)</span></li>
	<?php else: ?>
		<li class="toprndcrnr" >
	 		<a class="training-tab" href="#" onclick="return selectTrainingTab('licenses');" >Licenses (<?php echo $vars['count_licenses']; ?>)</a> 
       </li>	
   <?php endif;?>
</ul>
</div>