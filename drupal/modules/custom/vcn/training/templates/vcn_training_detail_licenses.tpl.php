<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

$currentUrl = "http://" . $_SERVER['SERVER_NAME'] . base_path() . "find-learning/detail/licenses/licenseid/" . $data->licenseid . "/stfips/" . $data->stfips;
$facebookTitle = "VCN.org License: " . $data->lictitle;

$facebookMetatags = new vcnFacebookMetatag($facebookTitle, $currentUrl, $data->licdesc);
drupal_set_html_head($facebookMetatags->getTags());
?>

<div id="training-detail" class="panel-2col panel-col-first" style="margin-top: -17px;">
	<div class="back-to-results">
		<!--  a onclick="return backToResults('licenseid');" href="<?php //echo base_path();?>find-learning/results">Back to results</a-->
	</div>
<form id="training-form" name="trainingform" method="post" autocomplete="off"  action="javascript:void(0);" onsubmit="caction('1'); return filterTraining(this);" >
<input type="hidden" id="occupation-title-one" name="occupation-title-one" value="<?php echo $data->licxonet->occupation->displaytitle; ?>" />
</form>
<?php if (0) : ?>
	<h2>Career</h2>
	<span class="occupation-title"><?php echo 'TODO GET Occupation';?></span>
<?php endif; ?>
	<h3>License</h3>
	<br/>
	<div style="width:100%;">
		<div style="float:left; width:80%;">
			<span class="training-title"><strong style="text-decoration:underline;"><?php echo $data->lictitle; ?></strong></span>
		</div>
		<div style="float:left; text-align:right; vertical-align:middle; width:20%;">
			<?php
			$facebookLikeButton = new vcnFacebookLike($currentUrl);
			$facebookLikeButton->shiftTop = '0';
			$facebookLikeButton->shiftLeft = '0';
			echo $facebookLikeButton->getButton();
			?>
		</div>
		<div style="clear:left;"></div>
	</div>

	<p>
	<?php echo $data->licdesc; ?>
	</p>

	<div id="training-detail-info">
 		<div id="training-detail-auth">
           		<b>Licensing Authority:</b><br />

				<span class="detail-auth">
				<?php
					if ((string)$data->licauth->url !== 'NULL' AND trim((string)$data->licauth->url !== ''))
					{
           				$url = substr_compare( 'http',(string)$data->licauth->url,0,4,true) ? 'http://'. (string)$data->licauth->url : (string)$data->licauth->url;
           				echo '<a target="_blank"  href="'.$url .'">'.$data->licauth->name1.'</a>';
           			}
           			else {
           				echo $data->licauth->name1;
           			}

           			if ((string)$data->licauth->name2 !== 'NULL' AND trim((string)$data->licauth->name2 !== ''))
					{
           				echo '<br />'.$data->licauth->name2;
           			}
           			if ((string)$data->licauth->name3 !== 'NULL' AND trim((string)$data->licauth->name3 !== ''))
					{
           				echo '<br />'.$data->licauth->name3;
           			}
           		 ?>
           		</span>
           		<br />
             	<?php
		             if ((string)$data->licauth->address1 !== 'NULL' AND trim((string)$data->licauth->address1 !== ''))
		             	echo $data->licauth->address1.'<br />';
		             if ((string)$data->licauth->city !== 'NULL' AND trim((string)$data->licauth->city !== ''))
		             	echo $data->licauth->city;
		             if ((string)$data->licauth->st) {
		             	if ((string)$data->licauth->st) echo ', ';
		             	echo $data->licauth->st;
		             }
		             if ((string)$data->licauth->zip !== 'NULL' AND trim((string)$data->licauth->zip !== ''))
		             	echo ' '. $data->licauth->zip;
		             echo '<br />';

		             if ((string)$data->licauth->telephone !== 'NULL' AND trim((string)$data->licauth->telephone !== ''))
		             {
		              	echo '<strong>Phone: </strong> '. vcn_format_phone( $data->licauth->telephone );
		                if ((string)$data->licauth->teleext !== 'NULL' AND trim((string)$data->licauth->teleext !== ''))
		                {
		                	echo ' ext. ' . $data->licauth->teleext;
		                }
		                echo '<br />';
		             }
		         	 if ((string)$data->licauth->fax)  echo '<strong>Fax: </strong> '. vcn_format_phone( $data->licauth->fax ).'<br />';
	            ?>
	            </div>
	</div>
<!--
		  	<div id="training-detail-prerequisites">
				<h2>Prerequisites (TBA)</h2>
			</div>
-->
		</div>
	</div>
<?php

global $user;

$logged_in = $user->uid;

$cma->usersession =  $logged_in ? 'U' : 'S';

?>
 	<div id="training-sidebar" class="panel-2col panel-col-last" style="margin-left:766px; position: absolute;">
	    <a class="save-to-notebook large<?php if ($user->uid=='U') echo 'u'; ?>" alt="Save this license" title="Save this license" onclick="not_logged_in('<?php echo $cma->usersession; ?>','License Saved temporarily in your wish list');return vcn_saveOrTargetToCMA (this,'licenses', 'license_id',' <?php echo $data->licenseid; ?>','<?php echo $cma->usersession; ?>','License Saved');"  href="<?php echo base_path(); ?>cma/notebook/save/license/<?php echo $data->licenseid;?>/<?php echo $data->stfips; ?>"></a>
	    <a class="target-to-notebook large" alt="Target this license" title="Target this license" onclick="not_logged_in('<?php echo $cma->usersession; ?>','License Targeted temporarily in your wish list');return vcn_saveOrTargetToCMA ('<?php echo base_path(); ?>cma/notebook/target/license/<?php echo $data->licenseid .'/'. $data->stfips; ?>','licenses', 'license_id', '<?php echo $data->licenseid; ?>','<?php echo $cma->usersession; ?>','License Targeted','<?php echo $cma->userid;?>');"  href="javascript:void(0);"></a>
<!--
	    <a class="in-my-neighborhood" alt="Show programs in my neighborhood" onclick="return searchMyNeighborhood('licenseid');" href=""></a>
       <br /><br />
-->
		<?php  echo $content['sidebar'];  ?>
 	</div>

