<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<div class="vcn-gs-heading">Program Details</div>

<?php if ($data['programs']) :?>
	<div class="program-detail" id="program_detail_0" style="margin-left:10px; margin-right:10px; text-align:left">Click on a program from the grid on the left to display details</div>


	<?php $count = 0; ?>
	<?php foreach ( $data['programs'] AS $row ) : ?>
	 <?php $class = (++$count%2 == 0) ? 'even' : 'odd'; ?>      
		<div class="program-detail off" id="program_detail_<?php echo $count; ?>" style="margin-left:10px; margin-right:10px; text-align:left">
	 
			<span class="program-title"><strong><?php  echo $row->programname; ?></strong></span>
			<br />
			<p><strong>Program Length: </strong>
           	<?php 
        		$awlevel = (string)$row->educategoryiped->educategory->educationcategoryname;
       			$program_length = (string)$row->educategoryiped->educategory->duration;
       				
       			echo '<span class="program-length">'.$program_length.'</span>';
			?>
  			</p>
			<p><strong>Award Level: </strong> 
			      <?php echo $awlevel; ?></p>
			
			<p><strong>Description</strong></p>
			<p><?php echo $row->programdescription; ?></p>
		 
      		<p><strong>School</strong></p>	
          <span class="grid-school">
             <?php 
             if ((string)$row->provider->webaddr !== 'NULL' AND trim((string)$row->provider->webaddr) !== '') 
             {
           		$webaddr = substr_compare( 'http',(string)$row->provider->webaddr,0,4,true) ? 'http://'. (string)$row->provider->webaddr : (string)$row->provider->webaddr;
             	echo '<a target="_blank" href="'.base_path().'find-learning/detail/school/unitid/'.$row->provider->unitid.'">'.$row->provider->instnm.'</a>';
             }
             else {
             	echo $row->provider->instnm;
             }
             ?>
           </span> 
<?php $cma = vcnCma::getInstance(); ?>           
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


         	 if ((string)$row->provider->applurl !== 'NULL' AND trim((string)$row->provider->applurl) !== '') 
         	 {
           		$appurl = substr_compare( 'http',(string)$row->provider->applurl,0,4,true) ? 'http://'. (string)$row->provider->applurl : (string)$row->provider->applurl;
         	 	echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
         	 }

    
         	 if ((string)$row->provider->faidurl !== 'NULL' AND trim((string)$row->provider->faidurl) !== '')  
         	 {
           		$faidurl = substr_compare( 'http',(string)$row->provider->faidurl,0,4,true) ? 'http://'. (string)$row->provider->faidurl : (string)$row->provider->faidurl;
         	 	echo '<a class="small" target="_blank" href="'.$faidurl.'">Financial Aid</a><br />' ;
         	 }
         	 ?>
	 		<p class="center">
  			<?php /* <a class="target-to-notebook-link"  onclick="not_logged_in('<?php echo $cma->usersession; ?>','Program Targeted.');return vcn_gs_saveOrTargetToCMA (this,'Program', 'programid','<?php echo $row->programid; ?>','programname','<?php echo $row->programname;?>' );" alt="Make This My Target Program"  title="Make This My Target Program" href="<?php echo base_path(); ?>cma/notebook/target/program/<?php echo $row->programid.'/'.$row->programcipcode->item->cipcode; ?>">Make This My Target Program</a> */ ?>
  			<a class="target-to-notebook-link"  onclick="return vcn_gs_saveOrTargetToCMA (this,'Program', 'programid','<?php echo $row->programid; ?>','programname','<?php echo $row->programname;?>' );" alt="Make This My Target Program"  title="Make This My Target Program" href="<?php echo base_path(); ?>cma/notebook/target/program/<?php echo $row->programid.'/'.$row->programcipcode->item->cipcode; ?>"><img src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/getting_started/images/target_program.png" alt="Make This My Target Program"></a>
			</p>
 			
 		</div>
  	<?php endforeach; ?>
<?php else: ?>

	<div style="margin-left:10px;">No programs for this career.</div>

<?php endif;?>
