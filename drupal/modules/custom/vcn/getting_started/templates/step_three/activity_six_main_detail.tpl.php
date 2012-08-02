<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<!--div class="vcn-gs-heading">Explore Financial Aid</div-->


<table>
	<thead><tr valign="top"><th lign="left">Financial Aid</th></tr></thead>

  	<?php foreach ( $data['fa_array'] AS $key => $training ) : ?>
  		<?php $class = ( $key%2 == 0) ? 'even' : 'odd'; ?>
		<tr class="<?php echo $class; ?>"  valign="top">
		 	<td>
	       		<a onclick="return vcn_gs_show_status_detail_div ('financial-aid-detail', 'financial_aid_detail_<?php echo $key ?>')"
	       		  href="" alt = "<?php echo $training['title'] ?>" >
	          	  <span class="financial-aid-title"><?php echo $training['title'] ?></span>
	          	</a>
	         </td>
        </tr>

	<?php endforeach; ?>

<thead><tr valign="top"><td lign="left"><a href="<?php echo base_path(); ?>/find-learning/resources/job-corps">Job Corps Programs</a></td></tr></thead>
<tr valign="top"><td lign="left"><a href="<?php echo base_path(); ?>/find-learning/resources/apprenticeship-training">Apprenticeship Training</a></td></tr>
<thead><tr valign="top"><td lign="left"><a href="<?php echo base_path(); ?>/find-learning/resources/health-service-corps">National Health Service Corps</a></td></tr></thead>
</table>

<?php if ($data['programs']) :?>
<?php $row = $data['programs']; ?>
	<h3>Provider Financial Aid</h3>
	<h4><?php echo $row->programname ?></h4>

	<span class="detail-school">
	<?php
		if ((string)$row->provider->webaddr !== 'NULL' AND trim((string)$row->provider->webaddr) !== '')
		{
			$webaddr = substr_compare( 'http',(string)$row->provider->webaddr,0,4,true) ? 'http://'. (string)$row->provider->webaddr : (string)$row->provider->webaddr;
			echo '<a target="_blank" href="'.$webaddr.'">'.$row->provider->instnm.'</a>';
		}
		else
		{
			echo $row->provider->instnm;
		}
	?>
	</span>
	<br />
	<?php
		if ((string)$row->provider->addr !== 'NULL'  AND trim((string)$row->provider->addr) !== '' )  echo $row->provider->addr.'<br />';
		if ((string)$row->provider->city !== 'NULL'  AND trim((string)$row->provider->city) !== '' ) echo $row->provider->city;
		if ((string)$row->stabbr !== 'NULL' )
		{
			if ((string)$row->provider->city !== 'NULL' AND trim((string)$row->provider->city) !== '' )  echo ', ';
		  		echo $row->provider->stabbr;
		}
		if ((string)$row->provider->zip !== 'NULL' AND trim((string)$row->provider->zip) !== '' )  echo ' '. $row->provider->zip;
		echo '<br />';
		if ((string)$row->provider->gentele !== 'NULL' AND trim((string)$row->provider->gentele) !== '' ) echo ' '. vcn_format_phone( $row->provider->gentele ).'<br />';

		if ((string)$row->provider->applurl !== 'NULL' AND trim((string)$row->provider->applurl) != '')
		{
			$appurl = substr_compare( 'http',(string)$row->provider->applurl,0,4,true) ? 'http://'. (string)$row->provider->applurl : (string)$row->provider->applurl;
		 	echo '<a target="_blank" href="'.$appurl.'">Admissions</a><br />';
		}
		if ((string)$row->provider->faidurl !== 'NULL' AND trim((string)$row->provider->faidurl) !== '')
		{
		  	$faidurl = substr_compare( 'http',(string)$row->provider->faidurl,0,4,true) ? 'http://'. (string)$row->provider->faidurl : (string)$row->provider->faidurl;
			echo '<a target="_blank"  href="'.$faidurl.'">Provider Financial Aid</a><br />';
		}
	?>

<?php endif; ?>