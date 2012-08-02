<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
//	$awlevel_array = array(3=>2,5=>4);
//	foreach ($awlevel_array AS $key=>$value) 
//	{
//		echo '<input type="checkbox" id="award_level_'.$key.'" name="award_level" />'.$key.' years'.'<br />';
//	}
?>


<?php if ($vars['tawlevelname']) : ?>
  <br /><b>Typical Education for this career:</b> <?php echo $vars['tawlevelname']; ?><br /> 
  <br /><b>Minimum Education for this career:</b> <?php echo $vars['mawlevelname']; ?><br /> 
<?php endif;?>

<?php //if ($vars['tawlevel']>2) : ?>
<br/><strong>Program Length</strong>
<br/>
<?php
$includes = drupal_get_path('module','vcn').'/includes';

require_once($includes . '/vcn_common.inc');

$catlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','category','list');
?>

<label><select name="fawlevel" id="awlevel_cert" onchange="$('#awlevel').val(this.value); updateGettingStartedActivity('<?php echo $vars['current_step'];?>', <?php echo $vars['current_activity'];?>);">
<?php $catcount=1; foreach ($catlist->category as $k=>$v): $catcount++; 
if ($catcount==3) $catcount++;
if (isset($vars['education_level']))
	$selected = (array_key_exists('education_level',$vars) && trim($vars['education_level'] == $catlist->category[$catcount]->educationcategoryid)  ) ? 'selected="selected"' : false;
else
	$selected = (trim($vars['tawlevel'] == $catlist->category[$catcount]->educationcategoryid)  ) ? 'selected="selected"' : false;

if ($catlist->category[$catcount]->educationcategoryid):
?>				
<option value="<?php echo $catlist->category[$catcount]->educationcategoryid; ?>" <?php echo $selected; ?>><?php echo $catlist->category[$catcount]->educationcategoryname; ?></option>
<?php endif; endforeach; ?>
</select></label>

<?php //endif; ?>

<br/><br/>

<?php if ($data['programs']):?>
<table >
	<thead>
   		<tr valign="top">
        	<th class="sortable<?php if ($vars['order_programs'] == 'ciptitle') echo $vars['direction_programs']; ?>" align="left" width="240px">Program Name</th>
        	<th class="sortable<?php if ($vars['order_programs'] == 'instnm') echo $vars['direction_programs']; ?>" align="left" width="240px">School Name</th>
      		<th class="<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '') echo 'sortable'; if ($vars['order_programs'] == 'distance') echo $vars['direction']; ?>" align="left" width="70px">Distance</th>
        	<th class="sortable<?php if ($vars['order_programs'] == 'awlevel') echo $vars['direction_programs']; ?>" align="left" width="75px">Program Length</th>
		<!-- 	<th class="unsortable" align="left" >Award Level</th> 
        	<th width="30px">&nbsp;</th>-->
       	</tr>
   	</thead>
   	
	<?php $count = 0; ?>
	<?php foreach ( $data['programs'] AS $row ) : ?>
 		<?php $class = (++$count%2 == 0) ? 'even' : 'odd'; ?>      
 	 
		<tr class="<?php echo $class; ?>"  valign="top">
       	<td>
 
       		<a onclick="return vcn_gs_show_status_detail_div ('program-detail', 'program_detail_<?php echo $count ?>')"
       		  href="" alt = "<?php echo $row->programname; ?>" >
          	  <span class="cipcode-title"><?php $pne = explode(' ',$row->programname); if (strlen($pne[0])>25) $row->programname = substr($row->programname, 0, 25); echo $row->programname; ?></span>
          	</a>
         </td>
         
        <td>
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
        <!--    
           <br />
             <?php 
            /* if ((string)$row->provider->addr !== 'NULL' AND trim((string)$row->provider->addr)) echo $row->provider->addr.'<br />'; 
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
         	 */
             ?>

          	<a class="small" target="_blank" onclick="return submitToLink(this,'program_id','<?php echo $row->programid; ?>')" href="/drupal/find-learning/financialaid/programs/program_id/<?php echo $row->programid.'/'.$row->programcipcode->item->cipcode; ?>">Financial Aid</a><br />
           </td>
           -->
        <td>
           <span class="grid-distance">
           	<?php 
           		if ((string)$row->distance !== 'NULL' AND trim((string)$row->distance) !== '')
           			echo $row->distance . ' m'; 
           	?>
           </span>
        </td>

        
        <td>
           	<?php 
        		$program_length  = (string)$row->educategoryiped->educategory->duration;

       			echo '<span class="program-length">'.$program_length.'</span>';
        		echo '<br /><br />';
			?>
        </td>
		
    <!--     <td>
			<?php 
       			echo '<span class="cipcode-title">'.$row->ipedslookup->codedesc.'</span>';
        		echo '<br /><br />';
        		
			?>
		</td>
        <td align="center"> 
            <a class="target-to-notebook" alt="Make this my target program" title="Make this my target program" href="<?php echo base_path(); ?>cma/notebook/target/program/<?php echo $row->programid.'/',$row->programcipcode->item->cipcodedetail->cipcode; ?>"> </a>
         </td>-->
      </tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>
<?php if ($vars['tawlevel']>2) : ?>
<strong style="color:red"> No programs found.</strong>
<?php elseif (!$count): ?>
<strong style="color:red"> No programs found for the typical education for this career.</strong>
<?php endif; ?>
</p>
<?php endif;?>