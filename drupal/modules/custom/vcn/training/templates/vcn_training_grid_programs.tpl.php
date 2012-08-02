<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 

// header( 'Cache-Control: private, max-age=10800, pre-check=10800' );


    // var check
   	$vars  = isset($vars) ? $vars : array() ;
   	$data  = isset($data) ? $data : array() ;
   	$cma   = $vars['cma'];
   	
   	$count_programs     = (isset($vars['count_programs']) AND $vars['count_programs']) ? $vars['count_programs'] : 0;
 	$order_programs     = (isset($vars['order_programs']) AND $vars['order_programs']) ? $vars['order_programs'] : '';
 	$direction_programs = (isset($vars['direction_programs']) AND $vars['direction_programs']) ? $vars['direction_programs'] : ''; 	
   	$limit_programs     = (isset($vars['limit_programs']) AND $vars['limit_programs']) ? $vars['limit_programs'] : 8; 	
  	$pg_programs        = (isset($vars['pg_programs']) AND $vars['pg_programs']) ? $vars['pg_programs'] : 1;
	
 
?>

<?php  if (!$data) :?>
	<tr><td colspan = "5" class="message"><font color="#A71E28">No Programs found</font></td></tr>  
	
<?php else: ?>
 
  <?php $count = 0; ?>
  <?php foreach ( $data AS $row ) : ?>
    	 <?php  $class = (++$count%2 == 0) ? 'odd' : 'even'; ?> 
   	      
      <tr class="<?php echo $class; ?>"  valign="top">
        <td>
          <span class="grid-school">
   			<a href="<?php echo base_path();?>find-learning/detail/school/unitid/<?php echo $row->provider->unitid; ?>" 
   			alt="<?php echo $row->provider->instnm;?>" title="<?php echo $row->provider->instnm;?>" >
   			<?php echo $row->provider->instnm; ?></a>
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
          	<a class="small" href="<?php echo base_path();?>find-learning/financialaid/programs/program_id/<?php echo $row->programid.'/cipcode/'.$row->programcipcode->item->cipcodedetail->cipcode; ?>">Financial Aid</a><br />
           </td>
<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '' AND strlen($vars['zip'])==5) :?>        
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
 <!-- onclick="return submitToLink(this,'programs','program_id','<?php echo $row->programid; ?>')"  -->
 <?php //print_r($vars['onetcode']); ?>
       		<a 
       		  href="<?php echo base_path();?>find-learning/detail/programs/program_id/<?php echo $row->programid?>/cipcode/<?php echo $row->programcipcode->item->cipcode?>/onetcode/<?php echo $vars['onetcode'];?>"
			  alt = "<?php echo $row->programname; ?>" >
          	  <span class="cipcode-title"><?php echo $row->programname; ?></span>
          	</a>
        	<br /><br />
        </td>
        
        <td>
			<?php 
				echo '<span class="cipcode-title"><div style="display:none;">'.$row->educategoryiped->educategory->educationlevel.'</div>'.$row->educategoryiped->educategory->educationcategoryname.'</span>';
        		echo '<br /><br />';
			?>
		</td>
        <td align="center"> 
          <a class="save-to-notebook" alt="Save this program"  onclick="not_logged_in('<?php echo $cma->usersession; ?>','Program Saved temporarily in your wish list'); return vcn_saveOrTargetToCMA (this,'programs', 'program_id', '<?php echo $row->programid; ?>','<?php echo $cma->usersession; ?>','Program Saved','<?php echo $cma->userid; ?>');" title="Save this program" href="<?php echo base_path(); ?>cma/notebook/save/program/<?php echo $row->programid.'/'.$row->programcipcode->item->cipcode; ?>"> </a>
		  <a class="target-to-notebook" alt="Target this program" onclick="not_logged_in('<?php echo $cma->usersession; ?>','Program Targeted temporarily in your wish list'); return vcn_saveOrTargetToCMA ('<?php echo base_path(); ?>cma/notebook/target/program/<?php echo $row->programid.'/'.$row->programcipcode->item->cipcode; ?>','programs', 'program_id', '<?php echo $row->programid; ?>','<?php echo $cma->usersession; ?>','Program Targeted','<?php echo $cma->userid; ?>');" title="Target this program"  href="javascript:void(0);"> </a>
         </td>
      </tr>
<?php endforeach; ?>

<tr><td colspan="6">
<div class="pagination">
	<?php echo $content['pagination']; ?>
</div>
</td></tr>
<?php endif; ?>

<script>

	$(document).ready(function(){

		var type = "<?php echo $vars['type']; ?>";
		
		if (type=='programs' && $("#pawlevel").attr("class")=="sortableAsc" && 
		
		( ($('.sortable').text()=='School NameProgram NameAward Level'  && $('.sortableDesc').text().indexOf('Distance')<0 && $('.sortableAsc').text().indexOf('Distance')<0)
		
		|| $('.sortable').text()=='School NameDistanceProgram NameAward Level')
		
		) { 
			$("#pawlevel").click();
		}
		
			
	 }); 
/* 	 
 	$(document).ready(function(){

		var type = "<?php echo $vars['type']; ?>";
//alert($("#pawlevel").attr("class"));
		if (type=='programs' && $("#pawlevel").attr("class")=="sortableAsc") {  
			$("#pawlevel").click();
			$("#pawlevel").click();
		}
		
			
	 }); 	 */

</script>