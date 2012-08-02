<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 

	$type = $vars['type'];
 	$data = $data->$type;
 
?>
	
<?php if ($errors) : ?>
	<div class="errors">
<?php foreach ($errors AS $error):?>
		<span class="error"><?php echo $error . '<br />'; ?></span>
<?php endforeach;?>
	</div>
<?php endif; ?>
 
<?php echo $content['search']; ?> 
  

<div id="training-detail" class="panel-2col panel-col-first">
 Coming Soon 

 

	<?php if ($data): ?>
 		<?php if ($type == 'programs') :?>
	 		<h3>Provider Financial Aid</h3>
	 		<h4><?php echo $data->cipcodedetail->ciptitle; ?></h4>
			<p><?php echo $data->cipcodedetail->cipdesc; ?></p>
				
			<span class="detail-school">
			<?php 
		    	if ((string)$data->provider->webaddr !== 'NULL' AND trim((string)$data->provider->webaddr) !== '') 
		        {
		        	$webaddr = substr_compare( 'http',(string)$data->provider->webaddr,0,4,true) ? 'http://'. (string)$data->provider->webaddr : (string)$data->provider->webaddr;
		            echo '<a target="_blank" href="'.$webaddr.'">'.$data->provider->instnm.'</a>';
		        }
		    ?>
		    </span> 
		    <br />
		    <?php 
		    	if ((string)$data->provider->addr !== 'NULL'  AND trim((string)$data->provider->addr) !== '' )  echo $data->provider->addr.'<br />'; 
		        if ((string)$data->provider->city !== 'NULL'  AND trim((string)$data->provider->city) !== '' ) echo $data->provider->city; 
		        if ((string)$data->stabbr !== 'NULL' ) 
		        {
		        	if ((string)$data->provider->city !== 'NULL' AND trim((string)$data->provider->city) !== '' )  echo ', '; 
		             	echo $data->provider->stabbr; 
		             }
		             if ((string)$data->provider->zip !== 'NULL' AND trim((string)$data->provider->zip) !== '' )  echo ' '. $data->provider->zip;
		             echo '<br />';
		             if ((string)$data->provider->gentele !== 'NULL' AND trim((string)$data->provider->gentele) !== '' ) echo ' '. vcn_format_phone( $data->provider->gentele ).'<br />';
		
		           	 if ((string)$data->provider->admnurl !== 'NULL' AND trim((string)$data->provider->admnurl) != '')
		           	 {
		           	 	$appurl = substr_compare( 'http',(string)$data->provider->admnurl,0,4,true) ? 'http://'. (string)$data->provider->admnurl : (string)$data->provider->admnurl;
		           		echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
		           	 }	
		           	 if ((string)$data->provider->faidurl !== 'NULL' AND trim((string)$data->provider->faidurl) !== '')  
		           	 { 
		           		$faidurl = substr_compare( 'http',(string)$data->provider->faidurl,0,4,true) ? 'http://'. (string)$data->provider->faidurl : (string)$data->provider->faidurl;
		           	 	echo '<a class="small" target="_blank"  href="'.$faidurl.'">Provider Financial Aid</a><br />';
		        }
		  ?>
			
		<?php endif; ?>
		
		<?php if ($type == 'certifications') :?>
			<!-- currently only supports programs -->
		<?php endif; ?>
		
		<?php if ($type == 'licenses') :?>
			<!-- currently only supports programs -->
		<?php endif; ?>
		
		<?php if ($type == 'courses') :?>
			<!-- currently only supports programs -->
		<?php endif; ?>
 
	<?php endif; ?>
</div>

 
 
	
<div id="training-sidebar" class="panel-2col panel-col-last">
	<?php  echo $content['sidebar'];  ?>
</div> 