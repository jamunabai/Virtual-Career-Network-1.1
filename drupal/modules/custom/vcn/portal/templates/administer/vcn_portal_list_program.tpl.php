<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php echo $content['search'];?>

<h2>LIST PROGRAM</h2>

<?php if ($data) : ?>
	<table class="vcn-table">

	<thead>
   		<tr valign="top">
        	<th class="sortable<?php if ($vars['order_programs'] == 'instnm') echo $vars['direction_programs']; ?>" align="left" width="240px">School Name</th>
		<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== ''): ?>
      		<th class="<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '') echo 'sortable'; if ($vars['order_programs'] == 'distance') echo $vars['direction']; ?>" align="left" width="70px">Distance</th>
		<?php endif; ?> 
        	<th class="sortable<?php if ($vars['order_programs'] == 'ciptitle') echo $vars['direction_programs']; ?>" align="left" width="240px">Program Name</th>
        	<th class="sortable<?php if ($vars['order_programs'] == 'awlevel') echo $vars['direction_programs']; ?>" align="left" width="75px">Program Length</th>
			<th class="unsortable" align="left" >Award Level</th>
        	<th width="145px">&nbsp;</th>
       	</tr>
   	</thead>
       
   	</thead>
	<?php $count = 0; ?>
	<?php foreach ( $data AS $row ) : ?>
   		<?php $class = (++$count%2 == 0) ? 'odd' : 'even';?>      
      	<tr class="<?php echo $class; ?>"  valign="top">
        	<td>
	          <span class="grid-school">
	             <?php 
	             if ((string)$row->provider->webaddr !== 'NULL' AND trim((string)$row->provider->webaddr) !== '') 
	             {
	           		$webaddr = substr_compare( 'http',(string)$row->provider->webaddr,0,4,true) ? 'http://'. (string)$row->provider->webaddr : (string)$row->provider->webaddr;
	             	echo '<a target="_blank" href="'.$webaddr.'">'.$row->provider->instnm.'</a>';
	             }
	             else {
	             	echo $row->provider->instnm;
	             }
	             ?>
	           </span> 
	           <br />
	             <?php 
	             if ((string)$row->provider->addr !== 'NULL' AND trim((string)$row->provider->addr)) echo $row->provider->addr.'<br />'; 
	             if ((string)$row->provider->city !== 'NULL' AND trim((string)$row->provider->city)) echo $row->provider->city; 
	             if ((string)$row->provider->stabbr !== 'NULL' AND trim((string)$row->provider->stabbr)) {
	             	if ((string)$row->provider->city !== 'NULL' AND trim((string)$row->provider->city) ) echo ', '; 
	             	echo $row->provider->stabbr; 
	             }
	             if ((string)$row->provider->zip !== 'NULL' AND trim((string)$row->provider->zip) !== '') echo ' '. $row->provider->zip;
	             echo '<br />';
	             if ((string)$row->provider->gentele !== 'NULL' AND trim((string)$row->provider->gentele) !== '') echo ' '. vcn_format_phone($row->provider->gentele) .'<br />';
	
	
	         	 if ((string)$row->provider->admnurl !== 'NULL' AND trim((string)$row->provider->admnurl) !== '') 
	         	 {
	           		$appurl = substr_compare( 'http',(string)$row->provider->admnurl,0,4,true) ? 'http://'. (string)$row->provider->admnurl : (string)$row->provider->admnurl;
	         	 	echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
	         	 }
	 
             ?>
          		<a class="small" onclick="return submitToLink(this,'financialaid','program_id','<?php echo $row->programid; ?>')" href="/drupal/find-learning/financialaid/programs/program_id/<?php echo $row->programid.'/'.$row->programcipcode->item->cipcodedetail->cipcode; ?>">Financial Aid</a><br />
           </td>
			<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '') :?>        
			        <td>
			           <span class="grid-distance">
			           	<?php 
			           		if ((string)$row->distance !== 'NULL' AND trim((string)$row->distance) !== '')
			           			echo $row->distance . ' m'; 
			           	?>
			           </span>
			        </td>
			<?php endif; ?>        
        
	       	<td>
	       		<a onclick="return submitToLink(this,'programs','program_id','<?php echo $row->programid; ?>')" 
	       		  href="/drupal/find-learning/detail/programs/program_id/<?php echo $row->programid?>/cipcode/<?php echo $row->programcipcode->item->cipcodedetail->cipcode; ?>"
				  alt = "<?php echo $row->programname ?>" >
	          	  <span class="cipcode-title"><?php echo $row->programname; ?>a</span>
	          	</a>
	        	<br /><br />
	        </td>
        
	        <td>
	           	<?php 
	        		$awlevel = (string)$row->awlevel;
	       			$program_length = false;
	       				
	         		switch ($awlevel) {
	          	 		case '1':
	          	 			$program_length = 'Less than 1 year';
	          	 		break;
	          	 		case '2':
	          	 			$program_length = 'Less than 2 years';
	          	 		break;
	          	 		case '3':
	          	 			$program_length = '2 years';
	          	 		break;
	          	 		case '4':
	          	 			$program_length = 'Less than 4 years';	
	          	 		break;
	          	 		case '5':
	          	 			$program_length = '4 years';	
	          	 		break;
	          	 		case '6':
	          	 			$program_length = 'Undetermined';
	          	 		break;
	          	 		case '7':
	          	 			$program_length = '6 years';
	          	 		break;
	            	 		default:
	          	 	}
	       			echo '<span class="program-length">'.$program_length.'</span>';
	        		echo '<br /><br />';
				?>
	        </td>
		
	        <td>
				<?php 
	       			echo '<span class="cipcode-title">'.$row->ipedslookup->codedesc.'</span>';
	        		echo '<br /><br />';
				?>
			</td>
       		 <td align="center"> 
        
	           	<?php 
		            if (user_access('edit vcn_portal programs'))
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
	<p>No Programs matching criteria</p>
<?php endif; ?>