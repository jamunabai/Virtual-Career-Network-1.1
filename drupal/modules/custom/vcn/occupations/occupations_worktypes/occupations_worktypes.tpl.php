<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 

$browser = $_SERVER['HTTP_USER_AGENT']; 
global $user; 

$jamuna='';

if (stristr($browser, 'WOW64'))
	$jamuna=1;

?>

<?php if (stristr($browser, 'MSIE 9') && $user->uid): ?>
<style>
.xleftcol {width:33%;}
.xrightcol {width:31%}
</style>
<?php endif; ?>

<?php if (stristr($browser, 'MSIE 8') && $user->uid): ?>
<style>
.xleftcol {width:34%;}
.xrightcol {width:33%}
</style>
<?php endif; ?>


<style>
ol {

	margin-left:-20px;
	

}

ul {
	margin-top:3px;
}
</style>
<?php

function getVideoImage2($onetcode)
{
                // compress onetcode
                $photo = preg_replace('/[^0-9]/i', '', $onetcode);
                return base_path()."sites/all/themes/zen_hvcp/career_images/photo.$photo.png";
}

function getVideoLink2($onetcode) {

$dir = base_path() . drupal_get_path('module','occupations_detail') . "/videos/";
$path = "..".$dir.$onetcode.".flv";

if (file_exists($path))
	return $dir.$onetcode.".flv";
else
	return '';

}

function getVideoBox($occupation, $count) {

   $videoImage = getVideoImage2($occupation->onetcode);
   $occtext = 'Click to play the video above to learn more about a day in the life of the healthcare professional in this category.';
   if (strstr($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')):
   
      $vidbox = '<a style="color: black; text-decoration: none;" onclick="javascript: window.open(\'/careerladder/video.php?onetcode=' . $occupation->onetcode . '&displaytitle=' . $occupation->displaytitle . '\',\'\',\'width=443,height=395\');" alt="' . $occupation->displaytitle . '" href="javascript:void(0);">' .
            	'<div class="greybg" ><img class="imgA1" alt="' . $count . '" src="' . $videoImage . '" />' . $occtext . '</a></div>';	     
   else:   
      $vidbox = '<a style="color: black; text-decoration: none;" href="' . getVideoLink2($occupation->onetcode) . '" alt="' . $occupation->displaytitle . '" toptions="width = 425, height = 344, resizable = 1, layout=flatlook, title=' . $occupation->displaytitle . ', shaded=1">' .
  	            '<div class="greybg" ><img class="imgA1" alt="' . $count . '" src="' . $videoImage . '" />' . $occtext . '</a></div>';
   endif;
   
      $vidbox = '<img class="imgA1" alt="' . $count . '" src="' . $videoImage . '" />';   
   return $vidbox;
}

function getOccs($code,$limit) {

	if (!$limit)
		$limit=5;

	$cp = dirname(dirname(drupal_get_path('module','occupations_detail')));

	require_once($cp . '/vcn.rest.inc');

	$rest = new vcnRest;

	$rest->setSecret('');
	$rest->setBaseurl(getBase());
	$rest->setService('occupationsvc');
	$rest->setModule('occupation');
	$rest->setAction('list');


	// standard filters
	$rest->setRequestKey('apikey','apikey');
	$rest->setRequestKey('format','xml');
	$rest->setRequestKey('limit',$limit);
	$rest->setRequestKey('worktypecode',$code);
	$rest->setRequestKey('scode','high');

	$rest->setMethod('post');

	
	$use_appcache = true;
	$cid = 'occupation-list-'.$code;
	$cached_content = null;

	//print "OCCUPATIONS LIST: before call to rest data " . udate("H:i:s:u") . "<br />";
	if ($use_appcache) {
	 $cached = cache_get($cid,'cache_content');
	 $ser_content = $cached->data;
	 if (!empty($ser_content)) {
		$cached_content = unserialize($ser_content);
		//print "using cached data for " . $cid . "<br />";
	 }
	}

	if (empty($cached_content)) {
	 $content = $rest->call();
	 if ($use_appcache) {
	   // save data to cache
	   $ser_content = serialize($content);
	   cache_set($cid, $ser_content, 'cache_content', $CACHE_PERMANENT);
	   //print "setting cache for " . $cid . "<br />";
	}
	} else {
	 $content = $cached_content; 
	}

	
	$content = new SimpleXMLElement($content);

	$content = $content->data;

  return $content;

}

?>
<script type="text/javascript" src="<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/javascripts/top_up-min.js"></script>
<script type="text/javascript">
  //TopUp.host = "http://<?php //echo $_SERVER["SERVER_NAME"]; /";?>
  TopUp.host = window.location.protocol+"//"+window.location.host+"/";
  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";
  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";


  function changeimage(value) {

	var first = 'i'+value+'link';

	if (value=='mdn') {
		document.getElementById('iofclink').innerHTML = '<img alt="Office & Research Support" name="iofc" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png" 	onmouseout="document.iofc.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png\'" 	onmouseover="document.iofc.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_on.png\'" style="cursor:pointer;" onclick="changeimage(\'ofc\');"/>';

		document.getElementById('ilablink').innerHTML = '<img alt="Lab Work & Imaging" name="ilab" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png" 	onmouseout="document.ilab.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png\'" 	onmouseover="document.ilab.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_on.png\'" style="cursor:pointer;" onclick="changeimage(\'lab\');"/>';

		document.getElementById('ictplink').innerHTML = '<img alt="Counseling, Therapy & Pharmacy" name="ictp" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png" 	onmouseout="document.ictp.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png\'" 	onmouseover="document.ictp.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_on.png\'" style="cursor:pointer;" onclick="changeimage(\'ctp\');"/>';

		document.getElementById('ivshlink').innerHTML = '<img alt="Vision, Speech/Hearing & Diet" name="ivsh" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png" 	onmouseout="document.ivsh.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png\'" 	onmouseover="document.ivsh.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_on.png\'" style="cursor:pointer;" onclick="changeimage(\'vsh\');"/>';

		document.getElementById(first).innerHTML = '<img alt="Medical, Dental & Nursing" name="imdn" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_on.png"	onclick="changeimage(\'mdn\');"/>';

		document.getElementById('tabofc').style.display='none';
		document.getElementById('tablab').style.display='none';
		document.getElementById('tabctp').style.display='none';
		document.getElementById('tabvsh').style.display='none';
		document.getElementById('tab'+value).style.display='block';

	}

	if (value=='ofc') {
		document.getElementById('imdnlink').innerHTML = '<img alt="Medical, Dental & Nursing" name="imdn" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png" 	onmouseout="document.imdn.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png\'" 	onmouseover="document.imdn.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_on.png\'" style="cursor:pointer;" onclick="changeimage(\'mdn\');"/>';

		document.getElementById('ilablink').innerHTML = '<img alt="Lab Work & Imaging" name="ilab" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png" 	onmouseout="document.ilab.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png\'" 	onmouseover="document.ilab.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_on.png\'" style="cursor:pointer;" onclick="changeimage(\'lab\');"/>';

		document.getElementById('ictplink').innerHTML = '<img alt="Counseling, Therapy & Pharmacy" name="ictp" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png" 	onmouseout="document.ictp.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png\'" 	onmouseover="document.ictp.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_on.png\'" style="cursor:pointer;" onclick="changeimage(\'ctp\');"/>';

		document.getElementById('ivshlink').innerHTML = '<img alt="Vision, Speech/Hearing & Diet" name="ivsh" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png" 	onmouseout="document.ivsh.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png\'" 	onmouseover="document.ivsh.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_on.png\'" style="cursor:pointer;" onclick="changeimage(\'vsh\');"/>';

		document.getElementById(first).innerHTML = '<img alt="Office & Research Support" name="iofc" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_on.png"	onclick="changeimage(\'ofc\');"/>';

		document.getElementById('tabmdn').style.display='none';
		document.getElementById('tablab').style.display='none';
		document.getElementById('tabctp').style.display='none';
		document.getElementById('tabvsh').style.display='none';
		document.getElementById('tab'+value).style.display='block';
	}

	if (value=='lab') {
		document.getElementById('imdnlink').innerHTML = '<img alt="Medical, Dental & Nursing" name="imdn" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png" 	onmouseout="document.imdn.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png\'" 	onmouseover="document.imdn.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_on.png\'" style="cursor:pointer;" onclick="changeimage(\'mdn\');"/>';

		document.getElementById('iofclink').innerHTML = '<img alt="Office & Research Support" name="iofc" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png" 	onmouseout="document.iofc.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png\'" 	onmouseover="document.iofc.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_on.png\'" style="cursor:pointer;" onclick="changeimage(\'ofc\');"/>';

		document.getElementById('ictplink').innerHTML = '<img alt="Counseling, Therapy & Pharmacy" name="ictp" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png" 	onmouseout="document.ictp.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png\'" 	onmouseover="document.ictp.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_on.png\'" style="cursor:pointer;" onclick="changeimage(\'ctp\');"/>';

		document.getElementById('ivshlink').innerHTML = '<img alt="Vision, Speech/Hearing & Diet" name="ivsh" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png" 	onmouseout="document.ivsh.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png\'" 	onmouseover="document.ivsh.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_on.png\'" style="cursor:pointer;" onclick="changeimage(\'vsh\');"/>';

		document.getElementById(first).innerHTML = '<img alt="Lab Work & Imaging" name="ilab" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_on.png"	onclick="changeimage(\'lab\');"/>';

		document.getElementById('tabofc').style.display='none';
		document.getElementById('tabmdn').style.display='none';
		document.getElementById('tabctp').style.display='none';
		document.getElementById('tabvsh').style.display='none';
		document.getElementById('tab'+value).style.display='block';
	}

	if (value=='ctp') {
		document.getElementById('imdnlink').innerHTML = '<img alt="Medical, Dental & Nursing" name="imdn" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png" 	onmouseout="document.imdn.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png\'" 	onmouseover="document.imdn.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_on.png\'" style="cursor:pointer;" onclick="changeimage(\'mdn\');"/>';

		document.getElementById('iofclink').innerHTML = '<img alt="Office & Research Support" name="iofc" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png" 	onmouseout="document.iofc.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png\'" 	onmouseover="document.iofc.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_on.png\'" style="cursor:pointer;" onclick="changeimage(\'ofc\');"/>';

		document.getElementById('ilablink').innerHTML = '<img alt="Lab Work & Imaging" name="ilab" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png" 	onmouseout="document.ilab.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png\'" 	onmouseover="document.ilab.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_on.png\'" style="cursor:pointer;" onclick="changeimage(\'lab\');"/>';

		document.getElementById('ivshlink').innerHTML = '<img alt="Vision, Speech/Hearing & Diet" name="ivsh" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png" 	onmouseout="document.ivsh.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png\'" 	onmouseover="document.ivsh.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_on.png\'" style="cursor:pointer;" onclick="changeimage(\'vsh\');"/>';

		document.getElementById(first).innerHTML = '<img alt="Counseling, Therapy & Pharmacy" name="ictp" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_on.png"	onclick="changeimage(\'ctp\');"/>';
		document.getElementById('tabofc').style.display='none';
		document.getElementById('tablab').style.display='none';
		document.getElementById('tabmdn').style.display='none';
		document.getElementById('tabvsh').style.display='none';
		document.getElementById('tab'+value).style.display='block';
	}

	if (value=='vsh') {
		document.getElementById('imdnlink').innerHTML = '<img alt="Medical, Dental & Nursing" name="imdn" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png" 	onmouseout="document.imdn.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png\'" 	onmouseover="document.imdn.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_on.png\'" style="cursor:pointer;" onclick="changeimage(\'mdn\');"/>';

		document.getElementById('iofclink').innerHTML = '<img alt="Office & Research Support" name="iofc" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png" 	onmouseout="document.iofc.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png\'" 	onmouseover="document.iofc.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_on.png\'" style="cursor:pointer;" onclick="changeimage(\'ofc\');"/>';

		document.getElementById('ictplink').innerHTML = '<img alt="Counseling, Therapy & Pharmacy" name="ictp" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png" 	onmouseout="document.ictp.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png\'" 	onmouseover="document.ictp.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_on.png\'" style="cursor:pointer;" onclick="changeimage(\'ctp\');"/>';

		document.getElementById('ilablink').innerHTML = '<img alt="Lab Work & Imaging" name="ilab" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png" 	onmouseout="document.ilab.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png\'" 	onmouseover="document.ilab.src=\'/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_on.png\'" style="cursor:pointer;" onclick="changeimage(\'lab\');"/>';

		document.getElementById(first).innerHTML = '<img alt="Vision, Speech/Hearing & Diet" name="ivsh" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_on.png"	onclick="changeimage(\'vsh\');"/>';

		document.getElementById('tabofc').style.display='none';
		document.getElementById('tabmdn').style.display='none';
		document.getElementById('tabctp').style.display='none';
		document.getElementById('tablab').style.display='none';
		document.getElementById('tab'+value).style.display='block';
	}

	
	//$(document).ready(function() {
		var jamuna = '<?php echo $jamuna; ?>';
		
		var browser = '<?php echo $browser; ?>';
		
		var which = value;
		
		if (which=='lab')
			which='lwi';
		
		var bbtotal=$('#bbimage').height();

		var biggest=1;
		var biggestname='';
		
		
		if (document.getElementById(which+'onelink')) {
			if ($('#'+which+'oneshow').height()>biggest && document.getElementById(which+'onelink').innerHTML=='see less') {
				var biggest = $('#'+which+'oneshow').height();
				var biggestname = which+'one';
			}
		}	
		if (document.getElementById(which+'twolink')) {
			if ($('#'+which+'twoshow').height()>biggest && document.getElementById(which+'twolink').innerHTML=='see less') {
				biggest=$('#'+which+'twoshow').height();
				biggestname = which+'two';
			}
		}	
		if (document.getElementById(which+'threelink')) {
			if ($('#'+which+'threeshow').height()>biggest && document.getElementById(which+'threelink').innerHTML=='see less') {
				biggest=$('#'+which+'threeshow').height();	
				biggestname = which+'three';
			}
		}
		var newheight=405 + biggest + 10;

		
		if (biggest<=1)
			newheight=405;

                if (jamuna)
                        newheight+=25;

                if (jamuna && which=='lwi')
                        newheight+=20;

                if (jamuna && which=='ctp')
                        newheight+=5;


		$('#bbimage').css("height",newheight + 'px');
		
		if (which=='ctp')
			$('#bbimage').css("height",newheight + 10 + 'px');
		
		$('#vcn-footer').css("margin-top", $('#bbimage').height()+100+"px"); 
	

		//});  	
	
  }
  

  
  $(document).ready(function() { 
	document.getElementById('jobtitle').value=''; 
	document.getElementById('jobtitle').focus();
	
	
	$('#vcn-footer').css("margin-top",'505px');
	$('#under-search').css("position",'absolute');
	$('#under-search').css("margin-top",'142px');
	$('#blueborder').css("position",'absolute');
	
	$('.xouter').css("margin-top",'43px');
	
	
  });
</script>


<br/>
<div id="blueheader" class="noresize">
<span id="imdnlink" class="noresize">
<img alt="Medical, Dental & Nursing" name="imdn" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png"
	onmouseout="document.imdn.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_off.png'"
	onmouseover="document.imdn.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_mdn_on.png'"
	style="cursor:pointer;"
	onclick="changeimage('mdn');"
/>
</span><img alt="spacer image" src="/drupal/sites/all/themes/zen_hvcp/images/transparent.gif" width="4" /><span id="iofclink" class="noresize">
<img alt="Office & Research Support" name="iofc" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png"
	onmouseout="document.iofc.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_off.png'"
	onmouseover="document.iofc.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ofc_on.png'"
	style="cursor:pointer;"
	onclick="changeimage('ofc');"
/></span><img alt="spacer image" src="/drupal/sites/all/themes/zen_hvcp/images/transparent.gif" width="4" /><span id="ilablink" class="noresize">
<img alt="Lab Work & Imaging" name="ilab" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png"
	onmouseout="document.ilab.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_off.png'"
	onmouseover="document.ilab.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_lab_on.png'"
	style="cursor:pointer;"
	onclick="changeimage('lab');"
/>
</span><img alt="spacer image" src="/drupal/sites/all/themes/zen_hvcp/images/transparent.gif" width="4" /><span id="ictplink" class="noresize">
<img alt="Counseling, Therapy & Pharmacy" name="ictp" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png"
	onmouseout="document.ictp.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_off.png'"
	onmouseover="document.ictp.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_ctp_on.png'"
	style="cursor:pointer;"
	onclick="changeimage('ctp');"
/></span><img alt="spacer image" src="/drupal/sites/all/themes/zen_hvcp/images/transparent.gif" width="4" /><span id="ivshlink" class="noresize">
<img alt="Vision, Speech/Hearing & Diet" name="ivsh" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png"
	onmouseout="document.ivsh.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_off.png'"
	onmouseover="document.ivsh.src='/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/tab_vsh_on.png'"
	style="cursor:pointer;"
	onclick="changeimage('vsh');"
/>
</span>

</div>

<div id="blueborder">
<img id="bbimage" alt="bbimage" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/main_671.png" />
  <div id="tabmdn" class="thetabs">
    <div style="float: left; width: 632px;">
		<div style="width:450px; float:left;">
			  <strong>Medical, Dental & Nursing</strong><br/><br/>
			  These healthcare careers center around direct, hands-on support to the physicians, dentists, and teams of medical professionals who treat patients. Each involves working closely with patients - such as in hospital, office, or clinic settings.
			  <br/><br/>
			  <strong>Careers in Medical, Dental & Nursing category organized by minimum educational requirements</strong><br/><br/>

				To see the Career Pathway By Education for this category -  <a toptions="width = 800, height = 580, resizable = 1, layout=flatlook, title=Career Pathway By Education, shaded=1" alt="Career Pathway By Education" href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/medical-dental-nursing.jpg">Click here</a>

	  </div>
	  	<div style="float:right;">
		<img height="150" width="150" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/photo.29107100s.jpg" alt="Medical, Dental & Nursing Image" />
		</div>	
	
    </div>

	<script>
		
		
		function workshowhide(name,which) { 
			var adpix=0;
			var isie8='<?php if (stristr($_SERVER["HTTP_USER_AGENT"],"MSIE 8")) echo "1"; else echo "0"; ?>';
			var ischrome='<?php if (stristr($_SERVER["HTTP_USER_AGENT"],"Chrome")) echo "1"; else echo "0"; ?>';
			
			
			if  (name=='mdnone')
				adpix=35;
				
			var jamuna = '<?php echo $jamuna; ?>';
				
				
			if  (name=='ctpthree')
				adpix=33;					
		
			if (document.getElementById(name+'show').style.display=='none')
				document.getElementById(name+'show').style.display='block';
			else
				document.getElementById(name+'show').style.display='none';
				
			if (document.getElementById(name+'link').innerHTML=='see more') {
				document.getElementById(name+'link').innerHTML='see less';	
				
				var bbtotal=$('#bbimage').height();

				var biggest = $('#'+which+'oneshow').height();
				var biggestname = which+'one';
				
				if ($('#'+which+'twoshow').height()>biggest) {
					biggest=$('#'+which+'twoshow').height();
					biggestname = which+'two';
				}
				if ($('#'+which+'threeshow').height()>biggest) {
					biggest=$('#'+which+'threeshow').height();	
					biggestname = which+'three';
				}
				var newheight=bbtotal + biggest + 10;

				if (newheight>525 && which=='lwi')
					newheight=525;
					

                if (jamuna && which=='ctp')
                        $('#bbimage').css("height", $('#bbimage').height()+15+"px");						
				
				if (biggestname==name || (name=='lwitwo' && document.getElementById('lwionelink').innerHTML=='see more') ) {
					if (jamuna && name=='lwitwo')
						newheight+=10;
					if (jamuna && name=='lwione')
						$('#bbimage').css("height",newheight+30+"px");
					else
						$('#bbimage').css("height",newheight + 'px');
				}
				
				$('#vcn-footer').css("margin-top", $('#bbimage').height()+100+"px");	
				
				//if (isie8==0) {
				//    $('#under-search').css("margin-top", usmt+"px");	
				//}
		
			}
			else {
				
				
				var bbtotal=$('#bbimage').height();

				var biggest = $('#'+which+'oneshow').height();
				var biggestname = which+'one';
				
				if ($('#'+which+'twoshow').height()>biggest) {
					biggest=$('#'+which+'twoshow').height();
					biggestname = which+'two';
				}
				if ($('#'+which+'threeshow').height()>biggest) {
					biggest=$('#'+which+'threeshow').height();	
					biggestname = which+'three';
				}	

				var newheight=bbtotal - biggest - 10;
				
				var smcount=0;
				
				document.getElementById(name+'link').innerHTML='see more';
				
					
				
				if (newheight<405)
					newheight=405;
				

                if (jamuna && which=='ctp')
                        $('#bbimage').css("height", $('#bbimage').height()-15+"px");
						
				if (name=='lwione' && document.getElementById('lwionelink').innerHTML=='see more' && document.getElementById('lwitwolink').innerHTML=='see less')
					newheight=$('#bbimage').height();	
					
				if (biggestname==name || (name=='lwitwo' && document.getElementById('lwionelink').innerHTML=='see more') ) {

					if (jamuna && name=='lwitwo')
						$('#bbimage').css("height",newheight+25+"px");
					else
						$('#bbimage').css("height",newheight + 'px');
				}
					
				
				$('#vcn-footer').css("margin-top", $('#bbimage').height()+100+"px");	
				
				//if (isie8==0) {
				//	$('#under-search').css("margin-top", usmt+"px");	
				//}				
			}
			
		}
	</script>
	
	
	<div style="float:left; width:632px; margin-top: 15px;">
		<div style="float:left; width:632px;">
			<div style="float:left; width:210px;">
				<b><u>HS/Some College/Certificates</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-9091.00">Dental Assistant</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2041.00">Emergency Medical Technician and Paramedic</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-1011.00">Home Health Aide</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-9092.00">Medical Assistant</a></li>
				</ul>
				<div class="smlink">(<a id="mdnonelink" href="javascript:void(0);" onclick="workshowhide('mdnone','mdn');">see more</a>)</div>
				
				<ul id="mdnoneshow" style="display:none; <?php if ($jamuna) echo 'height:210px;'; else echo 'height:191px;'; ?>">
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2061.00">Licensed Practical and Licensed Vocational Nurses</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2053.00">Psychiatric Technician</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-9099.01">Midwife</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-1014.00">Nursing Assistant</a></li>				
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2055.00">Surgical Technologist</a></li>		
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-1015.00">Orderly</a></li>		
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=39-9021.00">Personal Care Aide</a></li>		
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=53-3011.00">Ambulance Drivers and Attendants, Except Emergency Medical Technicians</a></li>		
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-1013.00">Psychiatric Aide</a></li>	
				</ul>
			</div>
			<div style="float:left; width:210px;">
				<b style="margin-left:27px;"><u>Associate's Degree</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1141.01">Acute Care Nurse</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1141.03">Critical Care Nurse</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2021.00">Dental Hygienist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1141.00">Registered Nurse</a></li>
				</ul>
				
			</div>
			<div style="float:left; width:210px;">
				<b><u>Bachelor's Degree and Above</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1071.01">Anesthesiologist Assistant</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1141.04">Clinical Nurse Specialist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1151.00">Nurse Anesthetist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1171.00">Nurse Practitioner</a></li>
				</ul>	
				<br/>
				<div class="smlink">(<a id="mdnthreelink" href="javascript:void(0);" onclick="workshowhide('mdnthree','mdn');">see more</a>)</div>
				
				<ul id="mdnthreeshow" style="display:none;">
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2091.00">Orthotist and Prosthetist</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1071.00">Physician Assistant</a></li>
				</ul>				
			</div>		
		</div>

		<div style="float:left;margin-top: 15px;">		
			 <span style="font-size: 12px;" class="seemore1">
				<b><a href="<?php echo base_path(); ?>careergrid/worktypecode/mdn/score/high">See All Medical, Dental & Nursing Careers</a> </b>
				<img alt="See more medical, dental & nursing careers" src="<?php echo base_path() . drupal_get_path('module','occupations_worktypes'); ?>/arrowright.jpg" />
			</span>
		</div>
	</div>

  </div>

  <div id="tabofc" class="thetabs">
    <div style="float: left; width: 632px;">
		<div style="width:450px; float:left;">
       <strong>Office & Research Support</strong><br/><br/>
       These healthcare careers provide the start to finish administrative support needed to run our healthcare system, from greeting patients in medical and dental offices, to obtaining and maintaining their medical records, to compiling the data and doing the research needed to improve service delivery, to conducting community health outreach.
       <br/><br/>
   
      <strong>Careers in Office & Research Support category organized by minimum educational requirements</strong><br/><br/>

				To see the Career Pathway By Education for this category -  <a toptions="width = 800, height = 580, resizable = 1, layout=flatlook, title=Career Pathway By Education, shaded=1" alt="Career Pathway By Education" href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/office-and-research-support.jpg">Click here</a>

	  </div>
	  	<div style="float:right;">
		<img height="150" width="150" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/photo.19204100s.jpg" alt="Office & Research Support Image" />
		</div>	
	
    </div>

	<div style="float:left; width:632px; margin-top: 15px;">
		<div style="float:left; width:632px;">
			<div style="float:left; width:210px;">
				<b><u>HS/Some College/Certificates</u></b>
				<ul>							
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=21-1094.00">Community Health Worker</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=43-6013.00">Medical Secretary</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-9094.00">Medical Transcriptionist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2071.00">Medical Records and Health Information Technician</a></li>
				</ul>
				<!--(<a href="<?php echo base_path(); ?>careergrid/worktypecode/ofc/score/high/education_category_id_less/4">see all</a>) -->
			</div>
			<div style="float:left; width:210px;">
				<b style="margin-left:27px;"><u>Associate's Degree</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=19-4092.00">Forensic Science Technician</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-9012.00">Occupational Health and Safety Technician</a></li>
				</ul>
				<!--(<a href="<?php echo base_path(); ?>careergrid/worktypecode/ofc/score/high/education_category_id_less/5">see all</a>)-->
			</div>
			<div style="float:left; width: 210px;">
				<b><u>Bachelor's Degree and Above</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=11-9111.00">Health Planner / Medical and Health Services Manager</a></li>				
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=21-1091.00">Health Educator</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=15-2041.01">Biostatistician</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=19-4011.02">Food Science Technician</a></li>
				</ul>	
				<div class="smlink">(<a id="ofcthreelink" href="javascript:void(0);" onclick="workshowhide('ofcthree','ofc');">see more</a>)</div>
				
				<ul id="ofcthreeshow" style="display:none; height:83px;">
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-9011.00">Occupational Health and Safety Specialists</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=19-2041.00">Environmental Scientists and Specialists, Including Health</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=15-1121.01">Informatics Nurse Specialists</a></li>
				</ul>			
			</div>		
		</div>

		<div style="float:left;margin-top: 15px;">		
			 <span style="font-size: 12px;" class="seemore1">
				<b><a href="<?php echo base_path(); ?>careergrid/worktypecode/ofc/score/high">See All Office & Research Support Careers</a> </b>
				<img alt="See more office & research support careers" src="<?php echo base_path() . drupal_get_path('module','occupations_worktypes'); ?>/arrowright.jpg" />
			</span>
		</div>
	</div>

  </div>

  
  <div id="tablab" class="thetabs">
    <div style="float: left; width: 632px;">
		<div style="width:450px; float:left;">
       <strong>Lab Work & Imaging</strong><br/><br/>
       These healthcare careers represent the technologists and technicians who work in laboratories and treatment rooms to accurately diagnose patient problems, provide needed radiologic and other treatments, and fix and maintain complex healthcare equipment.<br/><br/>
   
      <strong>Careers in Lab Work & Imaging category organized by minimum educational requirements</strong><br/><br/>

		To see the Career Pathway By Education for this category -  <a toptions="width = 800, height = 580, resizable = 1, layout=flatlook, title=Career Pathway By Education, shaded=1" alt="Career Pathway By Education" href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/lab-work-and-imaging.jpg">Click here</a>

	  </div>
	  	<div style="float:right;">
		<img height="150" width="150" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/photo.29201100s.jpg" alt="Lab Work & Imaging Image" />
		</div>	
	
    </div>

	<div style="float:left; width:632px; margin-top: 15px;">
		<div style="float:left; width:632px;">
			<div style="float:left; width:210px;">
				<b><u>HS/Some College/Certificates</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=51-9081.00">Dental Laboratory Technician</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-9099.02">Endoscopy Technician</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2099.06">Radiologic Technician</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2012.00">Medical and Clinical Laboratory Technician</a></li>
				</ul>
				<br/>
				<?php if (!stristr($browser, 'MSIE 9')): ?>
				<br/>
				<?php endif; ?>
				
				<div class="smlink">(<a id="lwionelink" href="javascript:void(0);" onclick="workshowhide('lwione','lwi');">see more</a>)</div>
				
				<ul id="lwioneshow" style="display:none; height:110px;">
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=51-9082.00">Medical Appliance Technician</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=49-9062.00">Medical Equipment Repairer</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=51-9083.00">Ophthalmic Laboratory Technician</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-9093.00">Medical Equipment Preparer</a></li>				
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-9097.00">Phlebotomist</a></li>		
				</ul>
			</div>
			<div style="float:left; width:210px;">
				<b style="margin-left:27px;"><u>Associate's Degree</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2031.00">Cardiovascular Technologist and Technician</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2032.00">Diagnostic Medical Sonographer</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2011.03">Histotechnologist and Histologic Technician</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2034.00">Radiologic Technologist</a></li>
				</ul>
				<div class="smlink">(<a id="lwitwolink" href="javascript:void(0);" onclick="workshowhide('lwitwo','lwi');">see more</a>)</div>
				
				<ul id="lwitwoshow" style="display:none; height:88px;">
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2099.01">Neurodiagnostic Technologist</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2033.00">Nuclear Medicine Technologist</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2035.00">Magnetic Resonance Imaging Technologist</a></li>
				</ul>
			</div>
			<div style="float:left; width: 210px;">
				<b><u>Bachelor's Degree and Above</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2011.02">Cytotechnologist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2011.00">Medical and Clinical Laboratory Technologist</a></li>
				</ul>	
				<!--(<a href="<?php echo base_path(); ?>careergrid/worktypecode/lab/score/high/education_category_id_less/6">see all</a>) -->					
			</div>		
		</div>

		<div style="float:left;margin-top: 14px;">		
			 <span style="font-size: 12px;" class="seemore1">
				<b><a href="<?php echo base_path(); ?>careergrid/worktypecode/lab/score/high">See All Lab Work & Imaging Careers</a> </b>
				<img alt="See more lab work & imaging careers" src="<?php echo base_path() . drupal_get_path('module','occupations_worktypes'); ?>/arrowright.jpg" />
			</span>
		</div>
	</div>

  </div>
  

  <div id="tabctp" class="thetabs">
    <div style="float: left; width: 632px;">
		<div style="width:450px; float:left;">
              <strong>Counseling, Therapy & Pharmacy</strong><br/><br/>
        These healthcare careers center around the specialized healthcare professionals who provide counseling help, physical treatment, medication, or other services that aid patients in recovering or adjusting to illness or injury.
        <br/><br/>
	
      <strong>Careers in Counseling, Therapy & Pharmacy category organized by minimum educational requirements</strong><br/><br/>

		To see the Career Pathway By Education for this category -  <a toptions="width = 800, height = 580, resizable = 1, layout=flatlook, title=Career Pathway By Education, shaded=1" alt="Career Pathway By Education" href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/counseling-therapy-and-pharmacy.jpg">Click here</a>

	  </div>
	  	<div style="float:right;">
		<img height="150" width="150" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/photo.21101500s.jpg" alt="Counseling, Therapy & Pharmacy Image" />
		</div>	
	
    </div>

	<div style="float:left; width:632px; margin-top: 15px;">
		<div style="float:left; width:632px;">
			<div style="float:left; width:210px;">
				<b><u>HS/Some College/Certificates</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=39-9031.00">Fitness Trainer and Aerobics Instructor</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-9011.00">Massage Therapist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-2012.00">Occupational Therapy Aide</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=43-4051.03">Patient Representative</a></li>
				</ul>
				<div class="smlink">(<a id="ctponelink" href="javascript:void(0);" onclick="workshowhide('ctpone','ctp');">see more</a>)</div>
				
				<ul id="ctponeshow" style="display:none;">
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2052.00">Pharmacy Technician</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-9095.00">Pharmacy Aide</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-2022.00">Physical Therapist Aide</a></li>
				</ul>
			</div>
			<div style="float:left; width:210px;">
				<b style="margin-left:27px;"><u>Associate's Degree</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-2011.00">Occupational Therapy Assistant</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-2021.00">Physical Therapy Assistant</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1124.00">Radiation Therapist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1126.00">Respiratory Therapist</a></li>
				</ul>
				<div class="smlink">(<a id="ctptwolink" href="javascript:void(0);" onclick="workshowhide('ctptwo','ctp');">see more</a>)</div>
				
				<ul id="ctptwoshow" style="display:none; height:14px;">
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2054.00">Respiratory Therapy Technician</a></li>
				</ul>
			</div>
			<div style="float:left; width: 210px;">
				<b><u>Bachelor's Degree and Above</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1125.01">Art Therapist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1128.00">Exercise Physiologist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-9092.00">Genetic Counselor</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=21-1022.00">Healthcare Social Worker</a></li>
				</ul>
				<br/>
				<div class="smlink">(<a id="ctpthreelink" href="javascript:void(0);" onclick="workshowhide('ctpthree','ctp');">see more</a>)</div>
				
				<ul id="ctpthreeshow" style="display:none; height: 95px;">
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1122.01">Low Vision Therapist, Orientation and Mobility Specialist, and Vision Rehabilitation Therapist</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1122.00">Occupational Therapist</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1123.00">Physical Therapist</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=21-1015.00">Rehabilitation Counselor</a></li>
				</ul>				
			</div>		
		</div>

		<div style="float:left;margin-top: 15px;">		
			 <span style="font-size: 12px;" class="seemore1">
				<b><a href="<?php echo base_path(); ?>careergrid/worktypecode/ctp/score/high">See All Counseling, Therapy & Pharmacy Careers</a> </b>
				<img alt="See more counseling, therapy & pharmacy careers" src="<?php echo base_path() . drupal_get_path('module','occupations_worktypes'); ?>/arrowright.jpg" />
			</span>
		</div>
	</div>

  </div>
  
  
  <div id="tabvsh" class="thetabs">
    <div style="float: left; width: 632px;">
		<div style="width:450px; float:left;">
        <strong>Vision, Speech/Hearing & Diet</strong><br/><br/>
        These are healthcare careers that primarily focus on and specialize in the five 
        senses -- seeing, hearing/speaking, tasting, smelling, and feeling -- and address the 
        important related issue of nutrition.<br/><br/>
 
      <strong>Careers in Vision, Speech/Hearing & Diet category organized by minimum educational requirements</strong><br/><br/>

		To see the Career Pathway By Education for this category -  <a toptions="width = 800, height = 580, resizable = 1, layout=flatlook, title=Career Pathway By Education, shaded=1" alt="Career Pathway By Education" href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/vision_speech_hearing_singular.jpg">Click here</a>

	  </div>
	  	<div style="float:right;">
		<img height="150" width="150" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/photo.29103100s.jpg" alt="Vision, Speech/Hearing & Diet Image" />
		</div>	
	
    </div>

	<div style="float:left; width:632px; margin-top: 15px;">
		<div style="float:left; width:632px;">
			<div style="float:left; width:210px;">
				<b><u>HS/Some College/Certificates</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2051.00">Dietetic Technician</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2092.00">Hearing Aid Specialist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2057.00">Opthalmic Medical Technician</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2099.05">Opthalmic Medical Technologist</a></li>
				</ul>
				<div class="smlink">(<a id="vshonelink" href="javascript:void(0);" onclick="workshowhide('vshone');">see more</a>)</div>
				
				<ul id="vshoneshow" style="display:none; height: 29px;">
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2081.00">Optician, Dispensing</a></li>
					<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-9099.01">Speech-Language Pathology Assistant</a></li>
				</ul>	
			</div>
			<div style="float:left; width:210px;">
				<b style="margin-left:27px;"><u>Associate's Degree</u></b>
				<ul style="margin-left:-10px;">None</ul>
			</div>
			<div style="float:left; width: 210px;">
				<b><u>Bachelor's Degree and Above</u></b>
				<ul>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1181.00">Audiologist</a></li>
				<li style="display:list-item;"><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-1031.00">Dietitian & Nutritionist</a></li>
				</ul>	
				<!--(<a href="<?php echo base_path(); ?>careergrid/worktypecode/vsh/score/high/education_category_id_less/6">see all</a>)	-->				
			</div>		
		</div>

		<div style="float:left;margin-top: 15px;">		
			 <span style="font-size: 12px;" class="seemore1">
				<b><a href="<?php echo base_path(); ?>careergrid/worktypecode/vsh/score/high">See All Vision, Speech/Hearing & Diet Careers</a> </b>
				<img alt="See more vision, speech/hearing & diet careers" src="<?php echo base_path() . drupal_get_path('module','occupations_worktypes'); ?>/arrowright.jpg" />
			</span>
		</div>
	</div>

  </div>
  
</div>

<?php 
global $user; 
if (!$user->uid) { 
?>
<div id="under-search">
	<?php echo get_getting_started_icons_html(); ?>
	
	<div style="width:100%; text-align:center;">
		<strong>Career Management Account</strong>
		<br/><br/>
		<a href="<?php echo 'https://'.$_SERVER['SERVER_NAME'].base_path(); ?>user/register">Set up an account</a>
	</div>
	<br/>
	A Career Management Account is one of the best features of the Virtual Career Network.  
	&#160;&#160;&#160;
	<a href="javascript:void(0);" onclick="expandContract(document.getElementById('cmamoretext'), this);" style="margin-right:15px;">More</a>
	<br/>
	<div id="cmamoretext" style="display:none;">
		<br/>
		<li style="display:list-item;">It lets you save all your education, training and work-related information in one place.</li>
		<li style="display:list-item;">It provides access to tools that help you create a resume, draft cover letters, or store transcripts.</li>
		<li style="display:list-item;">It helps you create and store a portfolio of your skills.</li>
		<br/>
		It is private and secure. Only you control it. If you choose you can also share selected information in your Career Management Account 
		with others such as career counselors, employers or schools. Any information you provide will be secure, encrypted, and kept confidential.  
	</div> 
</div>

<?php 
} else {
	echo get_getting_started_icons_html();
}
?>

<?php 
function get_getting_started_icons_html() {
	global $user; 
	if (!$user->uid) {
		$cssClass = 'xouter2';
	} else {
		$cssClass = 'xouter';
	}
	$html = 
		'<div class="' . $cssClass . '">' . "\n" .
		'	<div class = "xleftcol">' . "\n" .
		'		<a toptions="type = iframe, width = 900, height = 700, resizable = 1, layout=flatlook, title=Always in Demand, scrolling=yes, shaded=1" href="' . $url.$base_path.'top10byjobs' . '">' . "\n" .
		'			<img align="right" alt="Watch Video" title="Always in Demand" class="watch-video-img" src="' . base_path() . '/sites/all/modules/custom/vcn/getting_started/images/button_briefcase.png" />' . "\n" .
		'		</a>' . "\n" .
		'		<div class="noresize" style="text-align:center; margin-left:35px; font-size:10px">Always in Demand</div>' . "\n" .
		'	</div>' . "\n" .
		'	<div class = "xmiddlecol">' . "\n" .
		'		<a toptions="type = iframe, width = 900, height = 700, resizable = 1, layout=flatlook, title=Good Prospects, scrolling=yes, shaded=1" href="' . $url.$base_path.'top10bygrowth' . '">' . "\n" .
		'			<img align="right" alt="Watch Video" title="Good Prospects" class="watch-video-img" src="' . base_path() . '/sites/all/modules/custom/vcn/getting_started/images/button_graph.png" />' . "\n" .
		'		</a>' . "\n" .
		'		<div class="noresize" style="text-align:center; margin-left: 35px; margin-top: 45px; position: absolute; font-size:10px">Good <br/> Prospects</div>' . "\n" .
		'	</div>' . "\n" .
		'	<div class = "xrightcol">' . "\n" .
		'		<a toptions="type = iframe, width = 900, height = 700, resizable = 1, layout=flatlook, title=Excellent Pay, scrolling=yes, shaded=1" href="' . $url.$base_path.'top10bypay' . '">' . "\n" .
		'			<img align="right" alt="Watch Video" title="Excellent Pay" class="watch-video-img" src="' . base_path() . '/sites/all/modules/custom/vcn/getting_started/images/button_dollar.png" />' . "\n" .
		'		</a>' . "\n" .
		'		<div class="noresize" style="text-align:center; margin-left:33px; font-size:10px">Excellent Pay</div>' . "\n" .
		'	</div>' . "\n" .
		'</div>' . "\n";
	
	return $html;
}
?>

<script language="javascript">
function expandContract(obj, self) {
	if (obj.style.display == 'none') {
		obj.style.display='inline';
		self.innerHTML = 'Less';
	} else {
		obj.style.display='none';
		self.innerHTML = 'More';
	}
}
</script>

<script>changeimage('mdn');</script>
