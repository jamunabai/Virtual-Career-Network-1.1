<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

// Get some globals
//global $base_url;
$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
//$base_url = $url.base_path();
$base_url = base_path();
//print_r($base_url); exit;


$vars['cma']= vcnCma::getInstance();
global $user;
$profile = profile_load_profile($user); 


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

// Here, we are loading up the questions for the assessment
$query="SELECT   *
		FROM     vcn_provider
		WHERE    UNITID = \"".$user->profile_provider_id."\"";
$result=mysql_query($query)
or die("Error running query: ".mysql_error());
$row=mysql_fetch_assoc($result);
//print_r($row);//exit;
// close the mysql connection
mysql_close($connection);
    
    
// GET GETTING STARTED USER KEYS from HVCP DB
$result = $vars['cma']->getUserKeyList(array('key_name'=>'module'));
$resultactivity = $vars['cma']->getUserKeyList(array('key_name'=>'activity'));
$keyvalue = $result->cma->keyvalue;
$activity = $resultactivity->cma->keyvalue;


$rotateArray=array('1','2','3','4');

    // determine if the page must start in a different div order
    if($_GET['start'] > 1)
      {
      // change the rotation start order
      for($i=1;$i<=$_GET['start']-1;$i++)
        {
        $popItem=array_pop($rotateArray);
        array_unshift($rotateArray,$popItem);
        }
      }
    else
      {
      //do nothing
      }
	  
	  
    //$appPath is where the url where the module is located at
    $appPath=$base_url.drupal_get_path('module','front_page');

    // Add in CSS path
    drupal_add_css(drupal_get_path('module','front_page')."/css/front_page.css");
    //echo "<link href=\"$appPath/css/front_page.css\" rel=\"stylesheet\" type=\"text/css\">";
	//echo $appPath; exit;
	///healthcare/sites/all/modules/custom/vcn/front_page
?>
    <!-- Load the javascript to rotate the page -->
    <script language="javascript" src="<?php echo $appPath;?>/js/rotator.js" xmlns="http://www.w3.org/1999/xhtml"></script>
<?php
    // Preload background images for the rotating banner, preloaded via CSS
    echo "<div id=\"preload1\"></div>\r\n";
    echo "<div id=\"preload2\"></div>\r\n";
    echo "<div id=\"preload3\"></div>\r\n";
    echo "<div id=\"preload4\"></div>\r\n";

    // script for lightbox popup
    $topup_js = drupal_get_path('module','occupations_detail') . "/javascripts/top_up-min.js";
    drupal_add_js($topup_js);
    echo '<script type="text/javascript">';
    echo "TopUp.players_path = \"".base_path() . drupal_get_path('module','occupations_detail')."/players/\";\r\n";
    echo "TopUp.images_path = \"".base_path() . drupal_get_path('module','occupations_detail')."/images/top_up/\";\r\n";
    echo "</script>";	  
	
	//$urlga = $_SERVER['SERVER_NAME'].$base_url.'getting-started/'.$keyvalue.'/'.$activity;
	$urlga=$_SESSION['bounceback']['GA'];
	if($urlga=="") $urlga="getting-started";	
	
	// added to detect stage servers
	$base=$_SERVER['SERVER_NAME'];
	

    /** LEARN **/
    echo "<div class=\"fp-container1\" id=\"fp-container".$rotateArray[0]."\">\r\n";

    echo "<img src=\"$appPath/images/banner_learn.jpg\" alt=\"button navigation image map\" usemap=\"#topButtonNav\"/ style=\"outline:none;\">\r\n";
    echo "<map name=\"topButtonNav\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,91,275,91,279,110,275,130,78,130\" href=\"".base_path()."explorecareers\" alt=\"Choose a Career\" title=\"Pick the right healthcare career.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,133,246,133,267,152,246,172,78,172\" href=\"".base_path()."find-learning\" alt=\"Get Qualified\" title=\"Locate the education or training you need to succeed.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,175,312,175,333,195,312,214,78,214\" href=\"".base_path()."online-courses/take-online\" alt=\"Take a Course Online\" title=\"Use the VCN's Learning Exchange to find and take courses online.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,217,225,217,248,236,225,256,78,256\" href=\"".base_path()."findwork\" alt=\"Find a Job\" title=\"Find your job in healthcare.\">\r\n";
    echo "<area shape=\"rect\" coords=\"19,330,149,459\" href=\""."/careerladder/gsvideos/AACC_VCN0.flv\" toptions=\"width = 425, height = 240, resizable = 1, layout=flatlook, shaded=1\" alt=\"Watch a Video\" title=\"Watch a video about a career in healthcare at www.vcn.org.\">\r\n";
    echo "<area shape=\"rect\" coords=\"188,334,325,464\" href=\"".base_path()."getting-started\" alt=\"The CareerGuide provides a structured, step-by-step approach to help you begin your healthcare career\" title=\"The CareerGuide provides a structured, step-by-step approach to help you begin your healthcare career\">\r\n";
    echo "<area shape=\"rect\" coords=\"355,334,480,461\" href=\"".base_path()."pla\" alt=\"Earn College Credits\" title=\"Get College Credits\">\r\n";
    echo "<area shape=\"rect\" coords=\"528,295,592,316\" href=\"".base_path()."begin?start=1\" alt=\"Learn\" title=\"Learn\">\r\n";
    echo "<area shape=\"rect\" coords=\"638,295,701,316\" href=\"".base_path()."begin?start=2\" alt=\"Earn\" title=\"Earn\">\r\n";
    echo "<area shape=\"rect\" coords=\"750,295,815,316\" href=\"".base_path()."begin?start=3\" alt=\"Advance\" title=\"Advance\">\r\n";
    echo "<area shape=\"rect\" coords=\"862,285,925,316\" href=\"".base_path()."begin?start=4\" alt=\"Serve\" title=\"Serve\">\r\n";
    echo "</map>\r\n";
    echo "<div class=\"rotating-text\">\r\n";
    echo "</div>\r\n"; // closing the rotating-text DIV

    echo "</div>\r\n"; // closing fp-container1 DIV

    /** EARN **/
    echo "<div class=\"fp-container2\" id=\"fp-container".$rotateArray[1]."\" style=\"display:none\">\r\n";

    echo "<img src=\"$appPath/images/banner_earn.jpg\" alt=\"button navigation image map\" usemap=\"#topButtonNav\"/ style=\"outline:none;\">\r\n";
    echo "<map name=\"topButtonNav\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,91,275,91,279,110,275,130,78,130\" href=\"".base_path()."explorecareers\" alt=\"Choose a Career\" title=\"Pick the right healthcare career.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,133,246,133,267,152,246,172,78,172\" href=\"".base_path()."find-learning\" alt=\"Get Qualified\" title=\"Locate the education or training you need to succeed.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,175,312,175,333,195,312,214,78,214\" href=\"".base_path()."online-courses/take-online\" alt=\"Take a Course Online\" title=\"Use the VCN's Learning Exchange to find and take courses online.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,217,225,217,248,236,225,256,78,256\" href=\"".base_path()."findwork\" alt=\"Find a Job\" title=\"Find your job in healthcare.\">\r\n";
    echo "<area shape=\"rect\" coords=\"19,330,149,459\" href=\""."/careerladder/gsvideos/AACC_VCN0.flv\" toptions=\"width = 425, height = 240, resizable = 1, layout=flatlook, shaded=1\" alt=\"Watch a Video\" title=\"Watch a video about a career in healthcare at www.vcn.org.\">\r\n";
    echo "<area shape=\"rect\" coords=\"188,334,325,464\" href=\"".base_path()."getting-started\" alt=\"The CareerGuide provides a structured, step-by-step approach to help you begin your healthcare career\" title=\"The CareerGuide provides a structured, step-by-step approach to help you begin your healthcare career\">\r\n";
    echo "<area shape=\"rect\" coords=\"355,334,480,461\" href=\"".base_path()."pla\" alt=\"Earn College Credits\" title=\"Get College Credits\">\r\n";
    echo "<area shape=\"rect\" coords=\"528,295,592,316\" href=\"".base_path()."begin?start=1\" alt=\"Learn\" title=\"Learn\">\r\n";
    echo "<area shape=\"rect\" coords=\"638,295,701,316\" href=\"".base_path()."begin?start=2\" alt=\"Earn\" title=\"Earn\">\r\n";
    echo "<area shape=\"rect\" coords=\"750,295,815,316\" href=\"".base_path()."begin?start=3\" alt=\"Advance\" title=\"Advance\">\r\n";
    echo "<area shape=\"rect\" coords=\"862,285,925,316\" href=\"".base_path()."begin?start=4\" alt=\"Serve\" title=\"Serve\">\r\n";
    echo "</map>\r\n";
    echo "<div class=\"rotating-text\">\r\n";
    echo "</div>\r\n"; // closing the rotating-text DIV

    echo "</div>\r\n"; // closing fp-container2 DIV

    /** ADVANCE **/
    echo "<div class=\"fp-container3\" id=\"fp-container".$rotateArray[2]."\" style=\"display:none\">\r\n";

    echo "<img src=\"$appPath/images/banner_advance.jpg\" alt=\"button navigation image map\" usemap=\"#topButtonNav\"/ style=\"outline:none;\">\r\n";
    echo "<map name=\"topButtonNav\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,91,275,91,279,110,275,130,78,130\" href=\"".base_path()."explorecareers\" alt=\"Choose a Career\" title=\"Pick the right healthcare career.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,133,246,133,267,152,246,172,78,172\" href=\"".base_path()."find-learning\" alt=\"Get Qualified\" title=\"Locate the education or training you need to succeed.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,175,312,175,333,195,312,214,78,214\" href=\"".base_path()."online-courses/take-online\" alt=\"Take a Course Online\" title=\"Use the VCN's Learning Exchange to find and take courses online.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,217,225,217,248,236,225,256,78,256\" href=\"".base_path()."findwork\" alt=\"Find a Job\" title=\"Find your job in healthcare.\">\r\n";
    echo "<area shape=\"rect\" coords=\"19,330,149,459\" href=\""."/careerladder/gsvideos/AACC_VCN0.flv\" toptions=\"width = 425, height = 240, resizable = 1, layout=flatlook, shaded=1\" alt=\"Watch a Video\" title=\"Watch a video about a career in healthcare at www.vcn.org.\">\r\n";
    echo "<area shape=\"rect\" coords=\"188,334,325,464\" href=\"".base_path()."getting-started\" alt=\"The CareerGuide provides a structured, step-by-step approach to help you begin your healthcare career\" title=\"The CareerGuide provides a structured, step-by-step approach to help you begin your healthcare career\">\r\n";
    echo "<area shape=\"rect\" coords=\"355,334,480,461\" href=\"".base_path()."pla\" alt=\"Earn College Credits\" title=\"Get College Credits\">\r\n";
    echo "<area shape=\"rect\" coords=\"528,295,592,316\" href=\"".base_path()."begin?start=1\" alt=\"Learn\" title=\"Learn\">\r\n";
    echo "<area shape=\"rect\" coords=\"638,295,701,316\" href=\"".base_path()."begin?start=2\" alt=\"Earn\" title=\"Earn\">\r\n";
    echo "<area shape=\"rect\" coords=\"750,295,815,316\" href=\"".base_path()."begin?start=3\" alt=\"Advance\" title=\"Advance\">\r\n";
    echo "<area shape=\"rect\" coords=\"862,285,925,316\" href=\"".base_path()."begin?start=4\" alt=\"Serve\" title=\"Serve\">\r\n";
    echo "</map>\r\n";
    echo "<div class=\"rotating-text\">\r\n";
    echo "</div>\r\n"; // closing the rotating-text DIV

    echo "</div>\r\n"; // closing fp-container3 DIV

    /** SERVE - formerly CONTRIBUTE **/
    echo "<div class=\"fp-container4\" id=\"fp-container".$rotateArray[3]."\" style=\"display:none\">\r\n";

    echo "<img src=\"$appPath/images/banner_contribute.jpg\" alt=\"button navigation image map\" usemap=\"#topButtonNav\"/ style=\"outline:none;\">\r\n";
    echo "<map name=\"topButtonNav\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,91,275,91,279,110,275,130,78,130\" href=\"".base_path()."explorecareers\" alt=\"Choose a Career\" title=\"Pick the right healthcare career.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,133,246,133,267,152,246,172,78,172\" href=\"".base_path()."find-learning\" alt=\"Get Qualified\" title=\"Locate the education or training you need to succeed.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,175,312,175,333,195,312,214,78,214\" href=\"".base_path()."online-courses/take-online\" alt=\"Take a Course Online\" title=\"Use the VCN's Learning Exchange to find and take courses online.\">\r\n";
    echo "<area shape=\"poly\" coords=\"78,217,225,217,248,236,225,256,78,256\" href=\"".base_path()."findwork\" alt=\"Find a Job\" title=\"Find your job in healthcare.\">\r\n";
    echo "<area shape=\"rect\" coords=\"19,330,149,459\" href=\""."/careerladder/gsvideos/AACC_VCN0.flv\" toptions=\"width = 425, height = 240, resizable = 1, layout=flatlook, shaded=1\" alt=\"Watch a Video\" title=\"Watch a video about a career in healthcare at www.vcn.org.\">\r\n";
    echo "<area shape=\"rect\" coords=\"188,334,325,464\" href=\"".base_path()."getting-started\" alt=\"The CareerGuide provides a structured, step-by-step approach to help you begin your healthcare career\" title=\"The CareerGuide provides a structured, step-by-step approach to help you begin your healthcare career\">\r\n";
    echo "<area shape=\"rect\" coords=\"355,334,480,461\" href=\"".base_path()."pla\" alt=\"Earn College Credits\" title=\"Get College Credits\">\r\n";
    echo "<area shape=\"rect\" coords=\"528,295,592,316\" href=\"".base_path()."begin?start=1\" alt=\"Learn\" title=\"Learn\">\r\n";
    echo "<area shape=\"rect\" coords=\"638,295,701,316\" href=\"".base_path()."begin?start=2\" alt=\"Earn\" title=\"Earn\">\r\n";
    echo "<area shape=\"rect\" coords=\"750,295,815,316\" href=\"".base_path()."begin?start=3\" alt=\"Advance\" title=\"Advance\">\r\n";
    echo "<area shape=\"rect\" coords=\"862,285,925,316\" href=\"".base_path()."begin?start=4\" alt=\"Serve\" title=\"Serve\">\r\n";
    echo "</map>\r\n";
    echo "<div class=\"rotating-text\">\r\n";
    echo "</div>\r\n"; // closing the rotating-text DIV

    echo "</div>\r\n"; // closing fp-container4 DIV
?>

   <!-- Run the javascript to rotate the page-->
	<script language="javascript" xmlns="http://www.w3.org/1999/xhtml">display(0)</script>

