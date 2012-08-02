<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php echo $content['search'];?>

<h2>LIST PROVIDER</h2>
 
<?php if ($data) : ?>
	<table class="vcn-table">

	<thead>
   		<tr valign="top">
        	<th class="sortable<?php if ($vars['order_programs'] == 'instnm') echo $vars['direction_programs']; ?>" align="left" >School Name</th>
        	<th class="sortable<?php if ($vars['vhs_yn'] == 'vhs_yn') echo $vars['direction_vhs_yn']; ?>" align="left" width="75px">Virtual HS</th>
        	<th class="sortable<?php if ($vars['type_ecb'] == 'type_ecb') echo $vars['direction_type_ecb']; ?>" align="left" width="100px">Provider Type</th>
         	<th class="sortable<?php if ($vars['num_programs'] == 'num_programs') echo $vars['direction_num_programs']; ?>" align="left" width="100px"># Programs</th>
         	<th width="145px">&nbsp;</th>
       	</tr>
   	</thead>
	<?php $count = 0; ?>
	<?php foreach ( $data AS $row ) : ?>
		<?php $class = (++$count%2 == 0) ? 'odd' : 'even';?>      
      	<tr class="<?php echo $class; ?>"  valign="top">
        	<td>
          		<span class="grid-school">
             	<?php 
	             if ((string)$row->webaddr !== 'NULL' AND trim((string)$row->webaddr) !== '') 
	             {
	           		$webaddr = substr_compare( 'http',(string)$row->webaddr,0,4,true) ? 'http://'. (string)$row->webaddr : (string)$row->webaddr;
	             	echo '<a target="_blank" href="'.$webaddr.'">'.$row->instnm.'</a>';
	             }
	             else {
	             	echo $row->instnm;
	             }
             	?>
	           </span> 
	           <br />
	             <?php 
	             if ((string)$row->addr !== 'NULL' AND trim((string)$row->addr)) echo $row->addr.'<br />'; 
	             if ((string)$row->city !== 'NULL' AND trim((string)$row->city)) echo $row->city; 
	             if ((string)$row->stabbr !== 'NULL' AND trim((string)$row->stabbr)) {
	             	if ((string)$row->city !== 'NULL' AND trim((string)$row->city) ) echo ', '; 
	             	echo $row->stabbr; 
	             }
	             if ((string)$row->zip !== 'NULL' AND trim((string)$row->zip) !== '') echo ' '. $row->zip;
	             echo '<br />';
	             if ((string)$row->gentele !== 'NULL' AND trim((string)$row->gentele) !== '') echo ' '. vcn_format_phone($row->gentele) .'<br />';
	
	
	         	 if ((string)$row->admnurl !== 'NULL' AND trim((string)$row->admnurl) !== '') 
	         	 {
	           		$appurl = substr_compare( 'http',(string)$row->admnurl,0,4,true) ? 'http://'. (string)$row->admnurl : (string)$row->admnurl;
	         	 	echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
	         	 }
	
	             ?>
	          	<a class="small" onclick="return submitToLink(this,'financialaid','program_id','<?php echo $row->programid; ?>')" href="/drupal/find-learning/financialaid/programs/program_id/<?php echo $row->programid; ?>">Financial Aid</a><br />
	           </td>
	           
	           <td>
	           		<?php 
	           			if ( strtoupper(trim((string)$row->vhsyn)) == 'Y') {
	           				echo 'Yes';
	           			} else  {
	           				echo 'No';
	           		 	}
	           		?>
	           </td>
		           
	           <td>
	           		<?php 
	           			if ( strtoupper(trim((string)$row->typeecb)) == 'E') {
	           				echo 'E-Learning';
	           			} elseif (strtoupper(trim((string)$row->typeecb)) == 'C') {
	           				echo 'Classroom';
	           			} elseif (strtoupper(trim((string)$row->typeecb)) == 'B') {
	           				echo 'Both';
	           			} else {	
	           				echo 'Undefined';
	           			}
	           		?>
	           </td>
	           
	           <td>0</td>
	           
	           <td>
	           	<?php 
		            if (user_access('edit vcn_portal providers'))
		            {
		            	echo '<button>Edit</button>';
		            }
		        ?>
	           </td>
	           
	           
      	</tr>     
	<?php endforeach; ?>
	
 
	</table>
<div class="pagination">
	<?php echo $content['pagination']; ?>
</div>	
<?php else: ?>
	<p>No Providers matching criteria</p>
<?php endif; ?>