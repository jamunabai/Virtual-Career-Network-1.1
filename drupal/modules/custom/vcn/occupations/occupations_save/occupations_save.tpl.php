<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
$cma = vcnCma::getInstance(); 
$onetcode = $_GET['onetcode'];

if (!$onetcode)
	$onetcode = $_POST['onetcode'];
	
global $user;


?>

<script type="text/javascript">

function saveit(url) {
	var isuser = '<?php global $user; $logged_in = $user->uid; if ($logged_in) echo "U"; else echo "S"; ?>'; 
	var cmaid = '<?php echo $cma->userid; ?>';
	
	loadhere.location.href = url;

	if (!document.getElementById('wish_list_icon').innerHTML && isuser!='U')
		document.getElementById('wish_list_icon').innerHTML="<a href=\"http://<?php echo $_SERVER['SERVER_NAME'].base_path(); ?>cma/notebook/careers\" title=\"Wish List\" alt=\"Wish List\"><img id=\"header-cma\" src=\"<?php echo base_path().drupal_get_path('module','vcn_header'); ?>/images/btn_wish_list.png\" alt=\"Wish List\" /></a>";

	
	var theurl = '/careerladder/careercount.php?userid='+cmaid;

	$.ajax({     
		url: '/careerladder/careercount.php?userid='+cmaid,     
		cache: false,    
		dataType: "html",     
		success: function(data) {         
			var count = data;

			if (isuser!='U') {	
				if (count<4)	
					not_logged_in(isuser,'Career Saved temporarily in your wish list.'); 
				else 
					red_error_box('4');
			} else {
				if (count<4)
					alert('Career is saved in Career Management Account.');
				else
					red_error_box('4');
			}
		} 
	}); 
}

function targetit(url,onetcode) {
	var cmaid = '<?php echo $cma->userid; ?>';
	var isuser = '<?php global $user; $logged_in = $user->uid; if ($logged_in) echo "U"; else echo "S"; ?>'; 
		
	$.ajax({
		url: '/careerladder/getcareeronetcodes.php?userid='+cmaid,
		cache: false,
		dataType: "html",
		success: function(data) {
			var data1 = data.split("###");
			var found = jQuery.inArray(onetcode, data1);
			var arrlength = data1.length;
				if (arrlength > 4 && found == -1){
					red_error_box('4');
					return false;
				}

			loadhere.location.href = url;

			if (!document.getElementById('wish_list_icon').innerHTML && isuser!='U')
				document.getElementById('wish_list_icon').innerHTML="<a href=\"http://<?php echo $_SERVER['SERVER_NAME'].base_path(); ?>cma/notebook/careers\" title=\"Wish List\" alt=\"Wish List\"><img id=\"header-cma\" src=\"<?php echo base_path().drupal_get_path('module','vcn_header'); ?>/images/btn_wish_list.png\" alt=\"Wish List\" /></a>";
			
			if (isuser!='U') {		
				not_logged_in(isuser,'Career targeted temporarily in your wish list.'); 
			} else {
				alert('Career is Targeted in Career Management Account.');
			}			
			
		} 
	}); 
		


}

</script>
<?php 
$titleTxt = 'Save To My Wish List';
if ($user->uid!='U') {
	$titleTxt = 'Save to My Career Management Account';
}
?>
<script type="text/javascript" language="javascript" src="/careerladder/script.js"></script>
	<center class="noresize" style="margin-bottom:-30px; margin-left: 23px; position: absolute;">
	  <nobr>
	    <a href="javascript:void(0);" onclick="saveit('<?php echo base_path(); ?>cma/notebook/save/career/<?php echo $onetcode; ?>')"><img width="110" alt="<?php echo $titleTxt; ?>" title="<?php echo $titleTxt; ?>" src="<?php echo base_path() . drupal_get_path('module','occupations_save'); ?>/btn_save<?php if ($user->uid!='U') echo '2'; ?>.png" /></a>
	    <a href="javascript:void(0);" onclick="targetit('<?php echo base_path(); ?>cma/notebook/target/career/<?php echo $onetcode; ?>','<?php echo $onetcode; ?>')"><img width="110" alt="Make This My Target" title="Make This My Target" src="<?php echo base_path() . drupal_get_path('module','occupations_save'); ?>/btn_make_my_target.png" /></a>
	  </nobr>
	</center>
<br/><iframe name="loadhere" src="" style="height: 0px; width: 0px; border: 0px;">&nbsp;</iframe>

<div id="loadcareercount" style="display:none;"></div>