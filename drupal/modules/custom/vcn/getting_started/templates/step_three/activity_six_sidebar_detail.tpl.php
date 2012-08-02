<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<div class="vcn-gs-heading">Financial Aid Details</div>

<?php if ($data['fa_array']) :?>
	<div class="financial-aid-detail" id="financial_aid_detail_0" style="margin-left:10px; margin-right:10px; text-align:justify">Click on a link from the grid on the left to display details</div>

 	<?php foreach ( $data['fa_array'] AS $key => $training ) : ?>
		<?php $class = ($key%2 == 0) ? 'even' : 'odd'; ?>   
		<div class="financial-aid-detail off" id="financial_aid_detail_<?php echo $key; ?>"  style="margin-left:10px; margin-right:10px; text-align:left">
			 
			<span class="financial-aid-title"><strong><?php  echo $training['title'] ;?></strong></span>
			<br />
 
			<p><strong>Description</strong></p>
			<p><?php echo $training['description']; ?></p>
		 
			<p><strong>More information</strong></p>
		 	<p style="width:100%;text-align:center;"><a target="_blank" href="<?php echo $training['href']; ?>" alt="<?php echo $training['title']; ?>">Go to Website</a>

 		</div>
  	<?php endforeach; ?>
<?php else: ?>
	No financial aid for this career.
<?php endif;?>
