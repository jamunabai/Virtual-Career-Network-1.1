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
   	
   	$count_certifications       = (isset($vars['count_certifications']) AND $vars['count_certifications']) ? $vars['count_certifications'] : 0;
 	$order_certifications       = (isset($vars['order_certifications']) AND $vars['order_certifications']) ? $vars['order_certifications'] : '';
 	$direction_certifications   = (isset($vars['direction_certifications']) AND $vars['direction_certifications']) ? $vars['direction_certifications'] : ''; 	
   	$limit_certifications       = (isset($vars['limit_certifications']) AND $vars['limit_certifications']) ? $vars['limit_certifications'] : 8; 	
  	$pg_certifications          = (isset($vars['pg_certifications']) AND $vars['pg_certifications']) ? $vars['pg_certifications'] : 1;
?>



<?php if (!$data) : ?>
	<tr><td colspan = "5" class="message"><font color="#A71E28">No Certifications found</font></td></tr>  
	
<?php else: ?>
	<?php $count = 0; ?>
    <?php foreach ( $data AS $training ) : ?>
 
    <?php $class = (++$count%2 == 0) ? 'odd' : 'even';?>      
 
      <tr class="<?php echo $class; ?>"  valign="top">
        <td>
          	<span class="grid-certification-name">
          	<a onclick="return submitToLink(this, 'programs', 'program_id','<?php echo $training->certid; ?>')" 
          	   href="<?php echo base_path(); ?>find-learning/detail/certifications/cert_id/<?php echo $training->certid; ?>"
         	   alt = "<?php echo $training->certname ?>">
          	   <span class="cipcode-title"><?php echo $training->certname ; ?></span>
          	</a>
        	<br /><br />
		 	</span>
      	</td>
      	
      	<td>
           <span class="grid-cert-type"><?php echo  $training->certxtype->item[0]->certtypename;?></span>
        </td>  
        
        <td>
           <span class="grid-cert-org"> 
            <?php 
     		 if ((string)$training->faidurl !== 'NULL') 
         	 {
           		$orgwebpag = substr_compare( 'http',(string)$training->certorg->orgwebpag,0,4,true) ? 'http://'. (string)$training->certorg->orgwebpag : (string)$training->certorg->orgwebpag;
         	 	echo '<a  target="_blank" href="'.$orgwebpag.'" alt="'
         	 	.$training->certorg->orgname
         	 	.'">'.
         	 	$training->certorg->orgname
         	 	.'</a><br />';
         	 }
            ?>
            </span>
         </td>
<?php

global $user;

$logged_in = $user->uid;

$cma->usersession =  $logged_in ? 'U' : 'S';

//echo"<pre>";print_r($cma->userid);exit;

?>         

      	<td>
          <a class="save-to-notebook" alt="Save this certification"  title="Save this certification" onclick="not_logged_in('<?php echo $cma->usersession; ?>','Certification Saved temporarily in your wish list');return vcn_saveOrTargetToCMA (this,'certifications', 'cert_id', '<?php echo $training->certid; ?>','<?php echo $cma->usersession; ?>','Certification Saved');" href="<?php echo base_path(); ?>cma/notebook/save/certificate/<?php echo $training->certid; ?>"> </a>
          <a class="target-to-notebook" alt="Target this certification"  title="Target this certification" onclick="not_logged_in('<?php echo $cma->usersession; ?>','Certification Targeted temporarily in your wish list'); return vcn_saveOrTargetToCMA ('<?php echo base_path(); ?>cma/notebook/target/certificate/<?php echo $training->certid; ?>','certifications', 'cert_id','<?php echo $training->certid; ?>','<?php echo $cma->usersession; ?>','Certification Targeted','<?php echo $cma->userid;?>');" href="javascript:void(0);"> </a>
        </td>
      </tr>
	<?php endforeach; ?>
<tr><td colspan="5">
<div class="pagination">
	<?php echo $content['pagination']; ?>

</div>
</td></tr>
<?php endif; ?>
 