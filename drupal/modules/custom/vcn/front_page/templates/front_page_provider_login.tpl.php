<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

    // Add in CSS path
    drupal_add_css(drupal_get_path('module','front_page')."/css/front_page.css");
    //$content .= "<link href=\"$appPath/css/front_page.css\" rel=\"stylesheet\" type=\"text/css\">";
	    //$appPath is where the url where the module is located at
    $appPath=$base_url.drupal_get_path('module','front_page');
// Get some globals
//global $base_url;
//$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
//$base_url = $url.base_path();
$base_url = base_path();
//print_r($base_url); exit;

$vars['cma']= vcnCma::getInstance();
global $user;
$profile = profile_load_profile($user); 

// GET GETTING STARTED USER KEYS from HVCP DB
$result = $vars['cma']->getUserKeyList(array('key_name'=>'module'));
$resultactivity = $vars['cma']->getUserKeyList(array('key_name'=>'activity'));
$keyvalue = $result->cma->keyvalue;
$activity = $resultactivity->cma->keyvalue;


 
	echo"<br>";
	
	echo "<img src=\"$appPath/images/provider_homepage.jpg\" alt=\"button navigation image map\" usemap=\"#topButtonNav\"/ style=\"outline:none;\">\r\n";
	echo "<map name=\"topButtonNav\">\r\n";
	echo "<area shape=\"rect\" coords=\"48,240,246,293\" href=\"https://".$_SERVER['SERVER_NAME'].base_path()."user?type=provider\" alt=\"Sign in\" title=\"Sign in\">\r\n";
	echo "<area shape=\"rect\" coords=\"57,371,190,407\" href=\"https://".$_SERVER['SERVER_NAME'].base_path()."user/register?type=provider\" alt=\"Register\" title=\"Register\">\r\n";
    echo "</map>\r\n";
	echo"<br><br>";
	echo"<div style=\"margin-top: -410px; position:absolute; margin-left: 51px; margin-right: 534px; \">";  
	echo"<p><b>".$row['INSTNM']."</p></b>";
	echo"<p>The \"Provider Portal\" is your window into how job seekers and prospective students will view your institution of higher learning....from here you can update and edit your school's profile as well as the information about the instructional programs you offer. This is your \"dashboard\" to control your presence on VCN!</p> </div><br>";
	//echo"If you have any questions please contact: <a href=\"mailto:" . $vcnemail . "\">" . $vcnemail . "</a>";
//echo"Ganappa";