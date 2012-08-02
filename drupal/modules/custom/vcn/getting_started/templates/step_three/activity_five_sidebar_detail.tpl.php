<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php $cma = vcnCma::getInstance(); ?>
<div class="vcn-gs-heading">Certification Details</div>

<?php if ($data['certifications']) :?>
	<div class="certification-detail" id="certification_detail_0" style="margin-left:10px; margin-right:10px; text-align:left" >Click on a certification from the grid on the left to display details</div>


	<?php $count = 0; ?>
	<?php foreach ( $data['certifications'] AS $training ) : ?>
		<?php $class = (++$count%2 == 0) ? 'even' : 'odd'; ?>      
		<div class="certification-detail off" id="certification_detail_<?php echo $count; ?>"  style="margin-left:10px; margin-right:10px; text-align:left">
			 
			<span class="training-title"><strong><?php  echo $training->certname;?></strong></span>
			<br />
			<p><strong>Description</strong></p>
			<p><?php echo $training->certdescription; ?></p>
		 
      		<p><strong>Certifying Organization</strong></p>	
			
	 		<span class="detail-org">
				<a target="_blank" href="<?php echo $training->certorg->orgwebpag; ?>"><?php echo $training->certorg->orgname;?></a>
			</span> 
  			<br />
			<?php 
				if ($training->certorg->orgaddres) echo $training->certorg->orgaddres.'<br />'; 
				if ($training->certorg->orgphone) 
				{ 
					echo 'Phone:  '. vcn_format_phone( $training->certorg->orgphone ) ; 
					if ($training->certorg->ext) 
				 	{
				    	echo ' ext. ' .$training->certorg->ext;
					}  
				  	echo '<br />';
				}
				if ($training->certorg->orgfax)  echo 'Fax:  ' . vcn_format_phone( $training->certorg->orgfax ).'<br />'; 
			?>
			
			<p class="center">
			<?php /* <a class="target-to-notebook-link"  onclick="not_logged_in('<?php echo $cma->usersession; ?>','Certification targeted.');  return vcn_gs_saveOrTargetToCMA (this,'Certification', 'certid', '<?php echo $training->certid; ?>','certname', '<?php echo $training->certname; ?>');" alt="Make This My Target Certification"  title="Make This My Target Certification" href="<?php echo base_path(); ?>cma/notebook/target/certificate/<?php echo $training->certid; ?>">Make This My Target Certification</a> */ ?>
			<a class="target-to-notebook-link"  onclick="return vcn_gs_saveOrTargetToCMA (this,'Certification', 'certid', '<?php echo $training->certid; ?>','certname', '<?php echo $training->certname; ?>');" alt="Make This My Target Certification"  title="Make This My Target Certification" href="<?php echo base_path(); ?>cma/notebook/target/certificate/<?php echo $training->certid; ?>"><img src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/getting_started/images/target_certification.png" alt="Make This My Target Certification"></a>
			</p>
 			
 		</div>
  	<?php endforeach; ?>
<?php else: ?>

	<div style="margin-left:9px" >No certifications for this career. </div>

<?php endif;?>
