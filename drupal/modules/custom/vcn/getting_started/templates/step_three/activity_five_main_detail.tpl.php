<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php if ($data['certifications']) :?>
   
<table>
    <thead>
      <tr valign="top">
        <th class="sortable<?php if ($vars['order_certifications'] == 'cert_name') echo $vars['direction_certifications']; ?>"  align="left" >Certification Name</th>
        <th class="sortable<?php if ($vars['order_certifications'] == 'org_name') echo $vars['direction_certifications']; ?>" align="left" >Certifying Organization</th>
      </tr>
    </thead>
 
	<?php $count = 0; ?>
	<?php foreach ( $data['certifications'] AS $training ) : ?>
		<?php $class = (++$count%2 == 0) ? 'even' : 'odd'; ?>      
		<tr class="<?php echo $class; ?>"  valign="top">
 			<td><span class="grid-certification-name"> 
 				<a onclick="return vcn_gs_show_status_detail_div ('certification-detail', 'certification_detail_<?php echo $count ?>')" 
          	   	href=""   alt = "<?php echo $training->certname ?>">
          	   	<span class="cipcode-title"><?php echo $training->certname ; ?></span>
          		</a>
          		</span>
 			</td>
 			<td><span class="grid-cert-org"> 
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
 
	<?php endforeach; ?>
</table>
 
<?php endif;?>
 