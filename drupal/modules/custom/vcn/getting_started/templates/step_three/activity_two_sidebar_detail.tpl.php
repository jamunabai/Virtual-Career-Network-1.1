<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/javascripts/top_up-min.js"></script>
<script type="text/javascript">
  TopUp.players_path = "/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/players/";
  TopUp.images_path = "/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/images/top_up/";
</script>


<?php $cma = vcnCma::getInstance(); ?>
<div class="vcn-gs-heading">License Details</div>

<?php if ($data['licenses']) :?>  
	<div class="license-detail" id="license_detail_0" style="margin-left:10px; margin-right:10px;">Click on a license from the grid on the left to display details</div>

	<?php $count = 0; ?>
	<?php foreach ( $data['licenses'] AS $training ) : ?>
	<?php $class = (++$count%2 == 0) ? 'even' : 'odd'; ?>

	<div class="license-detail off" id="license_detail_<?php echo $count; ?>" style="margin-left:10px; margin-right:10px;" >
		<strong><?php echo $training->lictitle ; ?></strong>
		<br />
		<p><strong>Description</strong></p>

		<p><?php $licdescfull = $training->licdesc; $licdescp = explode(".",$licdescfull); echo $licdescp[0]."."; ?></p>
		
		
		<p><a toptions="type = iframe, title=License Description, shaded = 1, width=800, height=500, resizable = 1" title="License Description" href="/careerladder/licensedetails.php?id=<?php echo $training->licenseid;?>">See more</a></p>
		
      	<p><strong>Licensing Agency</strong></p>
	 	<span class="detail-auth">
			<?php
					if ((string)$training->licauth->url !== 'NULL' AND trim((string)$training->licauth->url !== ''))
					{
           				$url = substr_compare( 'http',(string)$training->licauth->url,0,4,true) ? 'http://'. (string)$training->licauth->url : (string)$training->licauth->url;
           				echo '<a target="_blank"  href="'.$url .'">'.$training->licauth->name1.'</a>';
           			}
           			else {
           				echo $training->licauth->name1;
           			}

           			if ((string)$training->licauth->name2 !== 'NULL' AND trim((string)$training->licauth->name2 !== ''))
					{
           				echo '<br />'.$training->licauth->name2;
           			}
           			if ((string)$training->licauth->name3 !== 'NULL' AND trim((string)$training->licauth->name3 !== ''))
					{
           				echo '<br />'.$training->licauth->name3;
           			}
         	?>
       	</span>

        <br/>
      	<?php
			if ((string)$training->licauth->address1 !== 'NULL' AND trim((string)$training->licauth->address1 !== ''))
		    	echo $training->licauth->address1.'<br />';
		  	if ((string)$training->licauth->city !== 'NULL' AND trim((string)$training->licauth->city !== ''))
		   		echo $training->licauth->city;
		 	if ((string)$training->licauth->st)
		 	{
		    	if ((string)$training->licauth->st) echo ', ';
		        echo $training->licauth->st;
		    }
		    if ((string)$training->licauth->zip !== 'NULL' AND trim((string)$training->licauth->zip !== '')) echo ' '. $training->licauth->zip;
		    echo '<br />';

		    if ((string)$training->licauth->telephone !== 'NULL' AND trim((string)$training->licauth->telephone !== ''))
		    {
		    	echo 'Phone: '. vcn_format_phone( $training->licauth->telephone );
		        if ((string)$training->licauth->teleext !== 'NULL' AND trim((string)$training->licauth->teleext !== ''))
		        {
		        	echo ' ext. ' . $training->licauth->teleext;
		        }
		        echo '<br />';
		    }
		    if ((string)$training->licauth->fax)  echo 'Fax: '. vcn_format_phone( $training->licauth->fax ).'<br />';
			$training->lictitle = str_replace("'","", $training->lictitle);
	   	?>

			<p class="center">
			<?php /*<a class="target-to-notebook-link" onclick="not_logged_in('<?php echo $cma->usersession; ?>','License targeted'); return vcn_gs_saveOrTargetToCMA (this,'License', 'licenseid','<?php echo $training->licenseid;?>','licensename','<?php echo $training->lictitle;?>');" alt="Make This My Target License" title="Make This My Target License" href="<?php echo base_path(); ?>cma/notebook/target/license/<?php echo $training->licenseid.'/'.$training->stfips; ?>">Make This My Target License</a> */ ?>
			<a class="target-to-notebook-link" onclick="return vcn_gs_saveOrTargetToCMA (this,'License', 'licenseid','<?php echo $training->licenseid;?>','licensename','<?php echo $training->lictitle;?>');" alt="Make This My Target License" title="Make This My Target License" href="<?php echo base_path(); ?>cma/notebook/target/license/<?php echo $training->licenseid.'/'.$training->stfips; ?>"><img src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/getting_started/images/target_license.png" alt="Make This My Target License"></a>
			</p>
	   	</div>

 	<?php endforeach; ?>
<?php else: ?>
	<p style="margin-left:10px; margin-right:10px; text-align:justify">This information will help you make the right choices in the next activity.</p>

<?php endif;?>

