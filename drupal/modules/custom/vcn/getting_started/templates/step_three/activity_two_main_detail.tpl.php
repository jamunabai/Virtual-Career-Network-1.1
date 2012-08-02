<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>


<?php if ($data['licenses']) :?>

Then target your choice before moving to the next activity. 
<table>
    <thead>
      <tr valign="top">
     	<th class="" align="left" >License Name</th>
      	<th class="" align="left" >Licensing Agency</th>
   <!-- <th width="30px">&nbsp;</th> -->
      </tr>
    </thead>

	<?php $count = 0; ?>
	<?php foreach ( $data['licenses'] AS $training ) : ?>
	<?php $class = (++$count%2 == 0) ? 'even' : 'odd'; ?>      
	<tr class="<?php echo $class; ?>"  valign="top">
      	<td>
      	<span class="grid-license-name">
     	    <a onclick="return vcn_gs_show_status_detail_div ('license-detail', 'license_detail_<?php echo $count ?>')" 
          	   href=""  alt = "<?php echo $training->lictitle ?>">
          	   <span class="cipcode-title"><?php echo $training->lictitle ; ?></span>
          	</a>
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
        
  
      </tr>
	<?php endforeach; ?>
 
</table>
<p> <strong> Hint:</strong> It is important to review the licensing requirements before moving on to the activity, "Choose Credential, School and Program" since the state you live in may require you to obtain a particular credential in order to qualify for a state license. </p>
<?php endif;?>
