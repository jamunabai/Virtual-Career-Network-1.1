<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<a href="javascript:history.back()"><font style="color: #A71E29; font-size: 12px; font-family:Verdana;"> Back </font> </a>
<br><br>
<?php


require_once('vcn.rest.inc');

$rest = new vcnRest;

$rest->setService('occupationsvc');
$rest->setModule('occupation');
$rest->setAction('detail');

// standard filters
$rest->setRequestKey('format','xml');
$rest->setRequestKey('onetcode',$_GET['onetcode']);

$rest->setMethod('post');

$content = $rest->call();

$content = new SimpleXMLElement($content);

$content = $content->data;
?>
<html>
<head>

<script type="text/javascript" src="/careerladder/js/jquery-latest.js"></script>
</head>
<body bgcolor="#ffffff">
<?php
// sniff the browser and version
require_once('phpsniff/phpSniff.class.php');
require_once('phpsniff/phpTimer.class.php');

$timer = new phpTimer();
$timer->start('client');
$sniffer_settings = array('check_cookies'=>$GET_VARS['cc'],
                          'default_language'=>$GET_VARS['dl'],
                          'allow_masquerading'=>$GET_VARS['am']);
$client = new phpSniff($GET_VARS['UA'],$sniffer_settings);
$timer->stop('client');

//echo "<br /><br />browser is ".$client2->property('browser')."<br />";
//echo "version is ".$client2->property('version')."<br /><br />";

if($client->property('browser') == "ie" || ($client->property('version')<=3.6 && $client->property('browser')=='mz')) {?>
  <div id="pagediv" style="background : #ffffff; width : 1010px; height : 650px; overflow : auto; font-family : Verdana; font-size: 12px;">
<?php } else { ?>
  <div id="pagediv" style="background : #ffffff; width : 1010px; height : 650px; overflow : auto; font-family : Verdana; font-size: 12px;">
<?php } ?>
<b>Career Overview</b><br/>
<?php

	echo '<div style="margin-left: 5px; margin-right: 30px;">'.$content->occupation->detaileddescription.'</div>';

?>
</div>


<script type="text/javascript">
$(document).ready(function() {

			if (screen.width<1300) { 
				var pix = '580px';
				if (navigator.appName.indexOf('Internet Explorer')>0)
					pix = '546px';
					
				$('#pagediv').css("overflow-x","hidden");
				$('#pagediv').css("overflow-y","scroll");
				$('#pagediv').css("height",pix);
			}

});
</script>
</body>
</html>
