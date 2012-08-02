<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<div class="vcn-gs-heading">Virtual High School</div>
 
<?php if ($data['vhs']) :?>
	<div class="vhs-detail" id="vhs_detail_0" style="margin-left:10px; margin-right:10px; text-align:justify" >Click on a virtual high school from the grid on the left to display details</div>

	<?php $count = 0; ?>
	<?php foreach ( $data['vhs'] AS $training ) : ?>
		<?php $class = (++$count%2 == 0) ? 'even' : 'odd'; ?>      
 
		<div class="vhs-detail off" id="vhs_detail_<?php echo $count; ?>" style="margin-left:10px; margin-right:10px;" >
			<strong><?php echo $training->instnm ; ?></strong>
			<br />
			<p><strong>Description</strong></p>
	 		<p>Not available</p>
	
			<p><strong>More information</strong></p>
	 	 	<?php 
	       		if ((string)$training->webaddr !== 'NULL' AND trim((string)$training->webaddr) !== '') 
	          	{
	           		$webaddr = substr_compare( 'http',(string)$training->webaddr,0,4,true) ? 'http://'. (string)$training->webaddr : (string)$training->webaddr;
	             	echo '<a target="_blank" href="'.$webaddr.'">Click here</a> to visit this virtual high school\'s website.';
	            }
	            else 
	            {
	            	echo 'Not available';
	           	}
	       ?>
	    	<!-- p class="center">
				<a class="target-to-notebook-link"  onclick="return vcn_gs_saveOrTargetToCMA (this,'vhs', 'provider_id', <?php echo $training->unitid; ?>);"  alt="Save This Virtual High School"  title="Save This Virtual High School" href="<?php echo base_path(); ?>cma/notebook/target/vhs/<?php echo $training->unitid; ?>">Save This Virtual High School</a>
			</p-->
	   	</div>
 	<?php endforeach; ?>
 
<?php else: ?>
 	<p style="margin-left:10px; margin-right:10px;"> No virtual high schools available in your selected state. </p>
<?php endif;?>