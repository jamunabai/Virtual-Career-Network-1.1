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


 
if($_GET['user'] == 'provider'){
	echo"<br>";
	
	echo "<img src=\"$appPath/images/provider_homepage.jpg\" alt=\"button navigation image map\" usemap=\"#topButtonNav\"/ style=\"outline:none;\">\r\n";
	echo "<map name=\"topButtonNav\">\r\n";
	echo "<area shape=\"rect\" coords=\"48,240,246,293\" href=\"".base_path()."user\" alt=\"Sign in\" title=\"Sign in\">\r\n";
	echo "<area shape=\"rect\" coords=\"57,371,190,407\" href=\"".base_path()."user/register?type=provider\" alt=\"Register\" title=\"Register\">\r\n";
    echo "</map>\r\n";
	echo"<br><br>";
	echo"<div style=\"margin-top: -410px; position:absolute; margin-left: 51px; margin-right: 534px; \">";  
	echo"<p><b>".$row['INSTNM']."</p></b>";
	echo"<p>The \"Provider Portal\" is your window into how job seekers and prospective students will view your institution of higher learning....from here you can update and edit your school's profile as well as the information about the instructional programs you offer. This is your \"dashboard\" to control your presence on VCN!</p> </div><br>";
	//echo"If you have any questions please contact: <a href=\"mailto:" . $vcnemail . "\">" . $vcnemail . "</a>";
}
else
if ($user->uid) {

	//extracting database
	$dbpull .= hvcp_get_db_url();
	$tempArr1=explode("/",$dbpull);
	$tempArr2=explode(":",$tempArr1[2]);
	$dbuser=$tempArr2[0];
	$tempArr3=explode("@",$tempArr2[1]);
	$dbpass=$tempArr3[0];
	$dbserver=$tempArr3[1].":3306";
	unset($tempArr1,$tempArr2,$tempArr3);

	//For now, until we get the REST server set up, we'll just pull the data directly from the database
	$connection=mysql_connect($dbserver,$dbuser,$dbpass)
	  or die("Error making database connection: ".mysql_error());
	$db=mysql_select_db('hvcp',$connection)
	  or die("Error selecting database: ".mysql_error());

    $query="SELECT   *
            FROM     vcn_app_properties
            WHERE    ID=3";
    $result=mysql_query($query)
    or die("Error running query: ".mysql_error());
	$row=mysql_fetch_assoc($result);
	$vcnemail = $row['value'];
	
    $query="SELECT   *
            FROM     vcn_provider
            WHERE    UNITID = \"".$user->profile_provider_id."\"";
    $result=mysql_query($query)
    or die("Error running query: ".mysql_error());
	$row=mysql_fetch_assoc($result);
	
	//print_r($row);//exit;
    // close the mysql connection
    mysql_close($connection);
	
	//$content = getproviderdetails();
	

	
	//$vars['unitid']='202';
	$vars['unitid']=$user->profile_provider_id;
	$valid['unitid']='valid';
	
	//Added a new action shortdetailProvider in rest to improve the provider home page speed. 
	$content = vcn_get_data ($errors, $vars, $valid, 'trainingsvc', 'providers', 'shortdetail') ;
	 
	$program_info= $content->providers->program;
	
	$programcontent = vcn_get_data ($errors, $vars, $valid, 'trainingsvc', 'programs', 'list', $limit=4) ;
	//echo"Ganappa 6";exit;
	$typeofschool = $content->providers->ipedslookup->codedesc;
	
	
	if(empty($content->providers->providerdetail->percentadmittedtotal))
		$percentadmitedtotal = "N/A";
	else
		$percentadmitedtotal = $content->providers->providerdetail->percentadmittedtotal;
		
	if(empty($content->providers->providerdetail->totalenrollment))
		$totalstudents = "0";
	else
		$totalstudents = $content->providers->providerdetail->totalenrollment;
	
	if(empty($content->providers->providerdetail->undergraduateenrollment))
		$totalundergrads = "0";
	else
		$totalundergrads = $content->providers->providerdetail->undergraduateenrollment;
	
	if(empty($content->providers->providerdetail->firsttimedegreecertificateundergradenrollment))
		$firsttimedegreeseekers = "0";
	else 
		$firsttimedegreeseekers = $content->providers->providerdetail->firsttimedegreecertificateundergradenrollment;
	
	if(empty($content->providers->providerdetail->graduateenrollment))
		$graduateenrollment = "0";
	else
		$graduateenrollment = $content->providers->providerdetail->graduateenrollment;
	//echo "<pre>";
	//print_r($content->providers->ipedslookup->codedesc); 
	//print_r($content->providers->providerdetail->percentadmittedtotal); exit;
	//print_r($content->providers); exit;
	
	
	$i=0;
	$programdesc = array();
	$programdescid = array();
	foreach($programcontent->programs as $key => $k){
		//print_r($programcontent->programs[$i]->programname);
		if(!in_array((string)$programcontent->programs[$i]->programname,$programdesc)){
			$programdesc[] = (string)$programcontent->programs[$i]->programname;
			$programdescid[] = (string)$programcontent->programs[$i]->educategoryiped->educategory->educationcategoryname;
		}
		//echo "<br>";
		$i++;
	}
	//print_r($programdesc);
	 
	//exit;
	$i = 0;
	$awardsdesc = array();

	foreach($program_info->item as $key => $k){
		//echo $program_info->item[$i]->awardsdesc;
		if (!in_array((string)$program_info->item[$i]->awardsdesc,$awardsdesc))
			$awardsdesc[] = (string)$program_info->item[$i]->awardsdesc;
		//echo "<br />";
		$i++;
	}
	
	

	$school_name = $content->providers->instnm;

	echo"<br>";
	echo"<div id=\"schoolnameheading\" >"; // 1st div 
	echo"<img src=\"$appPath/images/capforheading.png\" alt=\"Provider Profile\" />";
	
	echo"<div style=\"margin-left: 29px; margin-right: 29px; margin-top:-78px; \"> <h2 style=\"color: #A71E28; margin-left: 91px; padding-bottom: 43px;\">".$school_name."</h2>"; // 2st div 
	echo" </div>"; // end of 2nd div
	echo"<hr>";
	
	echo" <div> "; //container div start
 
	echo"<div id=\"left1\">";	
		echo" <h3 style= \" color: #189AB0; margin-left: 10px;\">School Profile</h3>";
		echo" <div id=\"left\" style=\" border-style:solid; border-width:2px; border-color:#666666; height: 230px; overflow:auto;\">";
		echo" <div style=\" margin-bottom: -16px; margin-left: 10px; margin-top:10px; \">Type of School: </div>";
		echo " <div style=\" margin-left: 125px;\">". $typeofschool . "</div>";
		
		echo " <div style=\" margin-left: 125px;\">Percent applicants admitted:". $percentadmitedtotal . "</div> <br /> ";
		
		echo" <div style=\" margin-bottom: -16px; margin-left: 10px;\">Degrees Offered: </div>";
		foreach($awardsdesc as $value){
			echo " <div style=\" margin-left: 125px;\">". $value . "</div> ";
		}
		
		echo" <br /><div style=\" margin-bottom: -16px; margin-left: 10px;\">Size: </div>";
		echo " <div style=\" margin-left: 125px;\">". "Total Students:" . $totalstudents . "</div>";
		echo " <div style=\" margin-left: 125px;\">". "Total Undergrads:" . $totalundergrads . "</div>";
		echo " <div style=\" margin-left: 125px;\">". "1st-time degree-seeking freshmen:" . $firsttimedegreeseekers . "</div>";
		echo " <div style=\" margin-left: 125px;\">". "Graduate Enrollment:" . $graduateenrollment . "</div>";

		echo" </div> <br />";
		echo"<div><a style =\" margin-left: 90px; \" href=\"".base_path()."find-learning/detail/school/unitid/".$row['UNITID']."\"><img src=\"$appPath/images/providers_profile.png\" alt=\"Provider Profile\" /> </a> \r\n</div>";
	echo"</div>";	

	echo"<div id=\"right1\">";
		echo" <h3 style= \" color: #189AB0; margin-left: 10px;\">Programs</h3>";
		echo" <div id=\"right\" style=\" border-style:solid; border-width:2px; border-color:#666666; height: 230px;  overflow:auto;\">";

		
		echo"<table width=\"100%\"> ";
		if(empty($programdesc)){
			echo"<div  style= \" margin-bottom: 10px; margin-left: 10px; margin-top: 10px; \">No Programs Found.</div>";
		}
		for($i=0; $i<4; $i++){			
			echo"  <col width=\"60%\" /> <col width=\"40%\" /><tr> ";
			echo"<td><div  style= \" color : #A71E28; margin-bottom: 10px; margin-left: 10px; margin-top: 10px; \">".$programdesc[$i]."</div></td> ";
			echo"<td><div  style= \" margin-bottom: 10px; margin-left: 10px; margin-top: 10px; \">".$programdescid[$i]."</div></td> ";
			echo"</tr> ";
		}			
		echo"</table> ";

		echo" </div> <br />";
		echo"<div><a style =\" margin-left: 90px; \" href=\"".base_path()."find-learning/results/programs/unitid/".$row['UNITID']."\"><img src=\"$appPath/images/providers_programs.png\" alt=\"Provider Profile\" /> </a> \r\n</div>";
	echo"</div>";	
	
	echo" </div> "; //container div end

	echo" </div>"; // end of 1st div
	
}
 
 
 //echo "Ganappa";