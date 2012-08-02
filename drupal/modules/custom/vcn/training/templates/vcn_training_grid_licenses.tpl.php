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
   	
   	$count_licenses       = (isset($vars['count_licenses']) AND $vars['count_licenses']) ? $vars['count_licenses'] : 0;
 	$order_licenses       = (isset($vars['order_licenses']) AND $vars['order_licenses']) ? $vars['order_licenses'] : '';
 	$direction_licenses   = (isset($vars['direction_licenses']) AND $vars['direction_licenses']) ? $vars['direction_licenses'] : ''; 	
   	$limit_licenses       = (isset($vars['limit_licenses']) AND $vars['limit_licenses']) ? $vars['limit_licenses'] : 8; 	
  	$pg_licenses          = (isset($vars['pg_licenses']) AND $vars['pg_licenses']) ? $vars['pg_licenses'] : 1;
?>



<?php if (!$data) : ?>
	<tr><td colspan = "3" class="message"><td></tr>  
	
<?php else: ?>
 	<?php $count = 0; ?>
    <?php foreach ( $data AS $training ) : ?>
     	<?php $class = (++$count%2 == 0) ? 'odd' : 'even'; ?>      
 	    <tr class="<?php echo $class; ?>"  valign="top">
    	<td>
     	<span class="grid-license-name">
     	    <a href="<?php echo base_path();?>find-learning/detail/licenses/licenseid/<?php echo $training->licenseid?>/stfips/<?php echo $training->stfips ?>"
         	   alt = "<?php echo $training->lictitle ?>">
          	   <span class="cipcode-title"><?php echo $training->lictitle ; ?></span>
          	</a>
        	<br /><br />
        </span>
      	</td>
         
        <td>
           <span class="grid-license-agency"> 
           <?php 
        
           		if ((string)$training->licauth->url !== 'NULL' AND trim((string)$training->licauth->url !== ''))	{

           			$url = substr_compare( 'http',(string)$training->licauth->url,0,4,true) ? 'http://'. (string)$training->licauth->url : (string)$training->licauth->url;
           			echo '<a target="_blank" href="'.$url .'">'.$training->licauth->name1.'</a>';
           		}
           		else {
           			echo  $training->licauth->name1;
           		}
           
           ?>
 			</span>
        </td>
<?php

global $user;

$logged_in = $user->uid;

$cma->usersession =  $logged_in ? 'U' : 'S';

?>
      	<td>
          <a class="save-to-notebook" alt="Save this license"  title="Save this license"   onclick="not_logged_in('<?php echo $cma->usersession; ?>','License Saved temporarily in your wish list');return vcn_saveOrTargetToCMA (this,'licenses', 'license_id', '<?php echo $training->licenseid; ?>','<?php echo $cma->usersession; ?>','License Saved');" href="<?php echo base_path(); ?>cma/notebook/save/license/<?php echo $training->licenseid . '/' .$training->stfips; ?>"></a>
          <a class="target-to-notebook" alt="Target this license"  title="Target this license" onclick="not_logged_in('<?php echo $cma->usersession; ?>','License Targeted temporarily in your wish list');return vcn_saveOrTargetToCMA ('<?php echo base_path(); ?>cma/notebook/target/license/<?php echo $training->licenseid . '/' .$training->stfips; ?>','licenses', 'license_id','<?php echo $training->licenseid; ?>','<?php echo $cma->usersession; ?>','License Targeted','<?php echo $cma->userid;?>');" href="javascript:void(0);" ></a>
        </td>
      </tr>
	<?php endforeach; ?>
<tr><td colspan="5">
<div class="pagination">
	<?php echo $content['pagination']; ?>

</div>
</td></tr>
<?php endif; ?>
 
