<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php global $user;
if($user->uid) {?>
<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-one');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','4');
</script>
<?php }else{?>
<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-one');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','5');	
</script>
<?php } ?>
<?php 
if($user->uid)
  {
  if($vars['cma']->firstname!='')
    {
    echo '<b><div style="color : #A71E28">Welcome, <a style="text-decoration : none" href=https://'.$_SERVER['SERVER_NAME']. base_path().'cma/profile/view>'.ucfirst($vars['cma']->firstname) .'</a></div></b>';
    }
  else
    {
    echo '<b><div style="color : #A71E28">Welcome, <a style="text-decoration : none" href=https://'.$_SERVER['SERVER_NAME']. base_path().'cma/profile/view>'.ucfirst($user->name) .'</a></div></b>';
    }
  }
?>


<p> Great! You have completed Step 1. Below is the information that you have provided in Step 1. Please review the information below and make 
any corrections before continuing to the next Step.</p>
<table border="0">
<tr>
  	<td>*ZIP Code: </td>
  	<td>
		<?php 
		if(empty($vars['zip']))
		{ ?>
		<script type="text/javascript">
		//this is to disable the next buttons if no career is targeted 
		$(document).ready(function() {
			$('#vcn-gs-btn-next').addClass('off');
			$("#vcn-gs-btn-next").attr('disabled',true);
			$('#vcn-gs-btn-ano-next').addClass('off');
			$("#vcn-gs-btn-ano-next").attr('disabled',true);
		});
		</script>			
			
		<?php }
		else
		{
			echo $vars['zip'];	
		}
		?>
	</td>
  	<td>
		<?php $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
		$base_path = base_path(); ?>
		<a href="<?php echo $base_path.'getting-started/step-one/3';?>" style="color:#A71E28;" id="various1">Edit</a>  	
	</td>
</tr>   
<!--  tr>
  <td>Email Address :
  </td>
  <td>
  		<?php
  		global $user;
		if($user->uid){ 
  		echo $user->mail;
		}
		else 
		{
		echo "";
		}
		//echo '<div id="vcn-header-user-name">Hello, <a style="text-decoration : none" href=https://'.$_SERVER['SERVER_NAME']. base_path().'cma/profile/view>'.ucfirst($vars['cma']->firstname) .'</a></div>';
		?>  
  </td>
  <td>
  		<?php 
  		if($user->uid){
  		?>
		<a href="<?php echo $base_path.'user/'.$user->uid.'/edit';?>" style="color:#A71E28;" id="various1">Edit</a> 
		<?php }else {
		?>
		<a href="<?php echo $base_path.'user/register';?>" style="color:#A71E28;" id="various1">Edit</a>
		<?php }?> 
  </td>
</tr-->
</table>


<?php
    $topup_js = drupal_get_path('module','occupations_detail') . "/javascripts/top_up.js";
    drupal_add_js($topup_js);
//    $topup_js = "<script type='text/javascript' src='http://gettopup.com/releases/latest/top_up-min.js'></script>";
//    drupal_set_html_head($topup_js);
?>
<style>
.te_close_link {
left: 591px;
}
</style>
<script type="text/javascript">
  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";
  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";
</script>

<p>
<b>* Required Field :</b> Without required information you will not be able to go to the next step. 
</p>
<!-- <?php echo base_path(); ?>sites/all/modules/custom/vcn/getting_started/videos/helpvideocomingsoon.flv -->


<script type="text/javascript">
//To disable the activities in the step
$(document).ready(function(){	
//$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
});
</script>
