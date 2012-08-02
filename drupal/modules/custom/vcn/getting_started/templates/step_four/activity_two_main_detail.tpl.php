<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
	$tableclass = ( isset($vars['GETTINGSTARTED']['hsgrad']) AND $vars['GETTINGSTARTED']['hsgrad'] == 'No') ? 'on' : 'off';
?>
<?php if ($data['vhs']) :?>

<table class="borderless <?php echo $tableclass; ?>">
<!--tr><td>
Click on a virtual high school below to view details. Then target your choice before moving to the next activity.
</td></tr-->
</table> 
	<? if ($data['vhs']->children()) : ?>
<table class="<?php echo $tableclass; ?>">
<thead>
	<tr valign="top">
   		<th class="" align="left">Name</th>
       	<th class="">State</th>
	</tr>
</thead>
 
	<?php $count = 0; ?>
	<?php foreach ( $data['vhs'] AS $training ) : ?>
	<?php $class = (++$count%2 == 0) ? 'even' : 'odd'; ?>      
	<tr class="<?php echo $class; ?>"  valign="top">
      	<td><span class="grid-vhs-name">
     	    <a onclick="return vcn_gs_show_status_detail_div ('vhs-detail', 'vhs_detail_<?php echo $count ?>')" 
          	   href=""  alt = "<?php echo $training->instnm ?>">
          	   <span class="cipcode-title"><?php echo $training->instnm ; ?></span>
          	</a>
        </span>
      	</td><td>
          	<?php 
           		if ((string)$training->stabbr !== 'NULL' AND trim((string)$training->stabbr) !== '')
           	 		echo $training->stabbr ; 
           	?> 
 		</td>
   		</tr>
 	<?php endforeach; ?>
	</table>
	<?php else : ?>
	<strong style="color:red;">No "virtual" high schools found for your state.</strong>
	<?php endif; ?>
<?php else : ?>
	<strong style="color:red;">No "virtual" high schools found for your state.</strong>	
<?php endif; ?> 

 