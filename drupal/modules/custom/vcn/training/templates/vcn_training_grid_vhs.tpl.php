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
   	$data  = isset($data) ? $data : array() ;
   	$cma   = $vars['cma'];
   	$count_vhs     = (isset($vars['count_vhs']) AND $vars['count_vhs']) ? $vars['count_vhs'] : 0;
 	$order_vhs     = (isset($vars['order_vhs']) AND $vars['order_vhs']) ? $vars['order_vhs'] : '';
 	$direction_vhs = (isset($vars['direction_vhs']) AND $vars['direction_vhs']) ? $vars['direction_vhs'] : ''; 	
   	$limit_vhs     = (isset($vars['limit_vhs']) AND $vars['limit_vhs']) ? $vars['limit_vhs'] : 8; 	
  	$pg_vhs        = (isset($vars['pg_vhs'])    AND $vars['pg_vhs']) ? $vars['pg_vhs'] : 1;
 
?>

<?php  if (!$data) :?>
	<tr><td colspan = "5" class="message">No Programs found</td></tr>  
	
<?php else: ?>
	<?php $count = 0; ?>
	<?php foreach ( $data AS $training ) : ?>
		<?php $class = (++$count%2 == 0) ? 'odd' : 'even';?>      
	 
 	    <tr class="<?php echo $class; ?>"  valign="top">
 		<td>
          <span class="grid-school">
             <?php 
             	if ((string)$training->instnm !== 'NULL' AND trim((string)$training->instnm) !== '') 
             	{
            		if ((string)$training->webaddr !== 'NULL' AND trim((string)$training->webaddr) !== '') 
            		{
           				$webaddr = substr_compare( 'http',(string)$training->webaddr,0,4,true) ? 'http://'. (string)$training->webaddr : (string)$training->webaddr;
             			echo '<a target="_blank" href="'.$webaddr.'">'.$training->instnm.'</a>';
             		}
             		else 
             		{
             			echo $training->instnm;
             		}
             	}
             ?>
           </span> 
 <!--      </td><td>
           <span class="grid-distance">
           	<?php 
           		if ((string)$training->distance !== 'NULL' AND trim((string)$training->distance) !== '')
           			echo $training->distance . ' m.'; 
           	?>
           </span>
 -->
 		</td><td>
 	   		<?php 
           		if ((string)$training->stabbr !== 'NULL' AND trim((string)$training->stabbr) !== '')
           	 		echo $training->stabbr ; 
           	?> 
 		</td><td>
           <a class="save-to-notebook" alt="Save to Career Management Account" title = "Save to Career Management Account" onclick="return vcn_saveOrTargetToCMA (this,'vhs', 'unit_id', '<?php echo $training->unitid; ?>');" href="<?php echo base_path(); ?>cma/notebook/save/vhs/<?php echo $training->unitid; ?>"> </a>
           <a class="target-to-notebook" alt="Target this virtual high school" title = "Target this virtual high school"  onclick="return vcn_saveOrTargetToCMA (this,'vhs', 'unit_id', '<?php echo $training->unitid; ?>');"  href="<?php echo base_path(); ?>cma/notebook/target/vhs/<?php echo $training->unitid; ?>"> </a>

        </td>
 		</tr>
 	<?php endforeach; ?>
 	
	<tr><td colspan="6">
		<div class="pagination">
			<?php echo $content['pagination']; ?>
		</div>
	</td></tr>

<?php endif; ?> 


