<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

function getVideoImage($onetcode)
{
                // compress onetcode
                $photo = preg_replace('/[^0-9]/i', '', $onetcode);
                return base_path()."sites/all/themes/zen_hvcp/career_images/photo.$photo.jpg";
} 

function getVideoLink($onetcode,$oldonetcode) {

//if ($onetcode!=$oldonetcode)
	//$onetcode=$oldonetcode;
	
$dir = base_path() . drupal_get_path('module','occupations_detail') . "/videos/";
$path = "..".$dir.$onetcode.".flv";

if (file_exists($path))
	return $dir.$onetcode.".flv";
else
	return '';

}

function getAnnualSalary($wageocc)
{
               foreach ($wageocc AS $wage)
               {
                               if ( $wage->RATETYPE == 4)
                                               return $wage->MEDIAN;
               }
                
                return false;
} 

function getHourlyWage($wageocc)
{
               foreach ($wageocc AS $wage)
               {
                               if ( $wage->RATETYPE == 1)
                                               return $wage->MEDIAN;
               }
                
                return false;
} 
function goodImplodeD($data, $max, $type) {

	$count=0;

	foreach ($data as $value) {
		$count+=1;
		if ($count<=$max) {
				if ($type=="br")
					$output .= $value."<br/>";
				else
					$output .= $value.", ";
		}
	}
	
	$output[strlen($output)-2]=' ';
	
	return $output;
		

}
function getTrainingD($training) {

	$pieces = explode(" - ", $training); 
	$training = $pieces[0];
	
	$pieces = explode(" (", $training); 
	$training = $pieces[0];
	
	$pieces = explode("(", $training); 
	$training = $pieces[0];	
	
	return $training;

} 

$onetcode = $_GET['onetcode'];

if (!$onetcode)
$onetcode = $_POST['onetcode'];

if (get_clean_url_paired_parameter('onetcode'))
  $onetcode = get_clean_url_paired_parameter('onetcode');

if (!$onetcode)
	$doesitwork = "No data found";

if ($onetcode) {

  $cp = dirname(dirname(drupal_get_path('module','occupations_detail')));

  require_once($cp . '/vcn.rest.inc');

  $rest = new vcnRest;

  $rest->setSecret('');
  $rest->setBaseurl(getBase());
  $rest->setService('occupationsvc');
  $rest->setModule('occupation');
  $rest->setAction('detail');
  
  // standard filters
  $rest->setRequestKey('apikey','apikey');
  $rest->setRequestKey('format','xml');
  $rest->setRequestKey('onetcode',$onetcode);
  
  //echo "post = ".$_GET['zip']."<br/>";
  //echo "session = ".$_SESSION['zipcode']."<br/>";
  //echo "frompage = ".$_POST['frompage']."<br/>";

  $cma = vcnCma::getInstance();
  

  if(preg_match("/^[0-9]{5}$/",$cma->zipcode) && strlen($cma->zipcode) && $_POST['frompage']!="true") {
	$zipcode = $cma->zipcode; 
	
  }
  

  
  if(preg_match("/^[0-9]{5}$/",$_SESSION['zipcode']) && strlen($_SESSION['zipcode']))  {
	$zipcode = $_SESSION['zipcode'];

  }
  
  if(preg_match("/^[0-9]{5}$/",$_GET['zip']) && strlen($_GET['zip'])) {
	$zipcode = $_GET['zip']; 
	if ($zipcode=="00000")
		$zipcode="";

  }
  
	if ((strstr($_SERVER['REQUEST_URI'],'&zip') && !preg_match("/^[0-9]{5}$/",$_GET['zip'])))
		$zipcode="";
		

	
	//if(!isset($_SESSION))
		session_start();  
		
	  if (isset($_SESSION['cma'])) {
		if ($cma->zipcode!=$_SESSION['cma'])
			$zipcode = $cma->zipcode;
	  }
	  $_SESSION['cma']=$cma->zipcode;		

	$_SESSION['zipcode']=$zipcode;
	$_SESSION['firsttime']="no";

  $rest->setRequestKey('zipcode',$zipcode);
  $rest->setMethod('post');
  
  
  if (!$zipcode) {
	  $use_appcache = true;
	  $cid = "occupation:" . $onetcode;
	  $cached_content = null;
	  
	  //print "OCCUPATIONS DETAIL: before call to rest data " . udate("H:i:s:u") . "<br />";
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
	  //print "OCCUPATIONS DETAIL: after call to rest data " . udate("H:i:s:u") . "<br />";
	} else {
		$content = $rest->call();
	}
	
  if (isset($content['NODATA'])) {
    $content = new SimpleXMLElement($content);
//    $content = json_decode($content);


if ($content->status->code=="fail")
	$doesitwork="No data found";
else
	$doesitwork="";

	$state = $content->params->state;
	
    $content = $content->data->occupation;

  if (isset($_GET['debug'])) { 
    echo "<div style='border: 1px black solid;'><p><pre>";
    print_r($content);
    echo "</pre></p></div>";
  }

	$videoImage = getVideoImage($onetcode);
    $annualSalary = getAnnualSalary($content->VCN_WageOcc);
    $hourlyWage = getHourlyWage($content->VCN_WageOcc);

  }

}
?>

<script type="text/javascript" language="javascript" src="/careerladder/script.js"></script>

<?php
if ($content->displaytitle) {
	$dir = base_path() . drupal_get_path('module','occupations_detail');
	
	$currentUrl = "http://" . $_SERVER['SERVER_NAME'] . base_path() . "careerdetails?onetcode=".$onetcode;
	$imgUrl = "http://" . $_SERVER['SERVER_NAME'] . $videoImage;
	$facebookTitle = "VCN.org Career: " . $content->displaytitle;
	
	$facebookMetatags = new vcnFacebookMetatag($facebookTitle, $currentUrl, $content->detaileddescription, $imgUrl);
	drupal_set_html_head($facebookMetatags->getTags());
?>
	<div style="width:100%;">
		<div style="float:left; width:90%;">
			<h2><?php echo $content->displaytitle; ?></h2>
		</div>
		<div style="float:left; text-align:right; vertical-align:middle; width:10%;">
			<?php
			$facebookLikeButton = new vcnFacebookLike($currentUrl);
			echo $facebookLikeButton->getButton();
			?>
		</div>
		<div style="clear:left;"></div>
	</div>
	
	<font size='2px'>
		<div id='linkcontainer' style='position:relative; padding-bottom:15px;'>
			<div id='overviewlink' style='position:absolute; left:0px;'><img alt='Overview' title='Overview' src='<?php echo $dir; ?>/images/btn_overview_on.jpg' /></div>
			<div id='salarylink' style='position:absolute; left:93px;'><a href='javascript:void(0);' onclick='changemain("salary");'><img alt='Salary & Outlook' title='Salary & Outlook' name='salaryimg' src='<?php echo $dir; ?>/images/btn_salary_outlook_off.jpg' onmouseover='document.salaryimg.src="<?php echo $dir; ?>/images/btn_salary_outlook_on.jpg"' onmouseout='document.salaryimg.src="<?php echo $dir; ?>/images/btn_salary_outlook_off.jpg"' /></a></div>
			<div id='onthejoblink' style='position:absolute; left:226px;'><a href='javascript:void(0);' onclick='changemain("onthejob");'><img  alt='On the Job' title='On the Job' name='onthejobimg' src='<?php echo $dir; ?>/images/btn_on_the_job_off.jpg' onmouseover='document.onthejobimg.src="<?php echo $dir; ?>/images/btn_on_the_job_on.jpg"' onmouseout='document.onthejobimg.src="<?php echo $dir; ?>/images/btn_on_the_job_off.jpg"' /></a></div>
			<div id='educationlink' style='position:absolute; left:321px;'><a href='javascript:void(0);' onclick='changemain("education");'><img alt='Education & Training' title='Education & Training'  name='educationimg' src='<?php echo $dir; ?>/images/btn_education_training_off.jpg' onmouseover='document.educationimg.src="<?php echo $dir; ?>/images/btn_education_training_on.jpg"' onmouseout='document.educationimg.src="<?php echo $dir; ?>/images/btn_education_training_off.jpg"' /></a></div>
			<div id='skillslink' style='position:absolute; left:481px;'><a href='javascript:void(0);' onclick='changemain("skills");'><img  alt='Skills & Tools' title='Skills & Tools' name='skillsimg' src='<?php echo $dir; ?>/images/btn_skills_tools_off.jpg' onmouseover='document.skillsimg.src="<?php echo $dir; ?>/images/btn_skills_tools_on.jpg"' onmouseout='document.skillsimg.src="<?php echo $dir; ?>/images/btn_skills_tools_off.jpg"' /></a></div>
			<div id='resourceslink' style='position:absolute; left:589px;'><a href='javascript:void(0);' onclick='changemain("resources");'><img  alt='Resources' title='Resources' name='resourcesimg' src='<?php echo $dir; ?>/images/btn_resources_off.jpg' onmouseover='document.resourcesimg.src="<?php echo $dir; ?>/images/btn_resources_on.jpg"' onmouseout='document.resourcesimg.src="<?php echo $dir; ?>/images/btn_resources_off.jpg"' /></a></span></div>
		</div>
<?		
} else {
	echo "No data found.";
}


?>

<div style="display: none;" id="zipod">

default val

</div> 


<script type="text/javascript" src="<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/javascripts/top_up-min.js"></script>
<script type="text/javascript">
  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";
  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";
  
  var path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>";
  

	$(document).ready(function() {

		var r = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
		
		if (r.indexOf("getting-started")>0 || r.indexOf("top10byjobs")>0 || r.indexOf("top10bygrowth")>0 || r.indexOf("top10bypay")>0) {
			document.getElementById('vcn-header').style.display = 'none';
			document.getElementById('vcn-footer').style.display = 'none';
			document.getElementById('copyright').style.display = 'none';
			$('.panel-col-last').remove();
			
			
			document.getElementById('dronoff').innerHTML = document.getElementById('video-link').innerHTML;
			
			//document.getElementById('dronoff').style.display = 'none';
			
			//document.getElementById('video-link').style.display = 'block';
			
			
			
			$('#dronoff').css("position","relative");
			
			$('#page').css("margin-left","20px");
			
			if (screen.width<1300) {
				$('#page').css("overflow-x","hidden");
				$('#page').css("overflow-y","scroll");
				$('#page').css("height","560px");
			}
			$('#page').css("width","700px");
			
			if (document.referrer.indexOf("top10")>0) {
				$('#page').css("overflow-x","hidden");
				$('#page').css("overflow-y","scroll");
				
				if (screen.width<1300) 
					$('#page').css("height","465px");
				else
					$('#page').css("height","575px");
			}
			
			$('.breadcrumb').css("display","none");

			
			
		}
			
	
	});


  
  function changemain(where) {
	if (where=='overview') {
		document.getElementById('details-left').style.display = 'block';
		document.getElementById('details-skills').style.display = 'none';
		document.getElementById('details-salary').style.display = 'none';
		document.getElementById('details-onthejob').style.display = 'none';
		document.getElementById('details-education').style.display = 'none';
		document.getElementById('details-skills').style.display = 'none';
		document.getElementById('details-resources').style.display = 'none';
		
		document.getElementById('overviewlink').innerHTML = '<img alt="Overview" title="Overview" src="'+path+'/images/btn_overview_on.jpg" />';
		document.getElementById('skillslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'skills\');"><img alt="Skills & Tools" title="Skills & Tools" name="skillsimg" src="'+path+'/images/btn_skills_tools_off.jpg" onmouseover="document.skillsimg.src=\''+path+'/images/btn_skills_tools_on.jpg\'" onmouseout="document.skillsimg.src=\''+path+'/images/btn_skills_tools_off.jpg\'" /></a>';
		document.getElementById('salarylink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'salary\');"><img alt="Salary & Outlook" title="Salary & Outlook" name="salaryimg" src="'+path+'/images/btn_salary_outlook_off.jpg" onmouseover="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_on.jpg\'" onmouseout="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_off.jpg\'" /></a>';
		document.getElementById('onthejoblink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'onthejob\');"><img alt="On the Job" title="On the Job" name="onthejobimg" src="'+path+'/images/btn_on_the_job_off.jpg" onmouseover="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_on.jpg\'" onmouseout="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_off.jpg\'" /></a>';	
		document.getElementById('educationlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'education\');"><img alt="Education & Training" title="Education & Training" name="educationimg" src="'+path+'/images/btn_education_training_off.jpg" onmouseover="document.educationimg.src=\''+path+'/images/btn_education_training_on.jpg\'" onmouseout="document.educationimg.src=\''+path+'/images/btn_education_training_off.jpg\'" /></a>';	
		document.getElementById('resourceslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'resources\');"><img alt="Resources" title="Resources" name="resourcesimg" src="'+path+'/images/btn_resources_off.jpg" onmouseover="document.resourcesimg.src=\''+path+'/images/btn_resources_on.jpg\'" onmouseout="document.resourcesimg.src=\''+path+'/images/btn_resources_off.jpg\'" /></a>';				
		
	}
	if (where=='skills') { 
		document.getElementById('details-left').style.display = 'none';
		document.getElementById('details-skills').style.display = 'block';
		document.getElementById('details-salary').style.display = 'none';
		document.getElementById('details-onthejob').style.display = 'none';
		document.getElementById('details-education').style.display = 'none';
		document.getElementById('details-skills').style.display = 'none';
		document.getElementById('details-resources').style.display = 'none';

		document.getElementById('overviewlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'overview\');"><img alt="Overview" title="Overview" name="overviewimg" src="'+path+'/images/btn_overview_off.jpg" onmouseover="document.overviewimg.src=\''+path+'/images/btn_overview_on.jpg\'" onmouseout="document.overviewimg.src=\''+path+'/images/btn_overview_off.jpg\'" /></a>';
		document.getElementById('skillslink').innerHTML = '<img alt="Skills & Tools" title="Skills & Tools" name="skillsimg" src="'+path+'/images/btn_skills_tools_on.jpg" /><img style = "display:none;" alt="Skills & Tools" title="Skills & Tools" name="skillsimg" src="'+path+'/images/btn_skills_tools_on.jpg" />';
		document.getElementById('salarylink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'salary\');"><img alt="Salary & Outlook" title="Salary & Outlook" name="salaryimg" src="'+path+'/images/btn_salary_outlook_off.jpg" onmouseover="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_on.jpg\'" onmouseout="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_off.jpg\'" /></a>';
		document.getElementById('onthejoblink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'onthejob\');"><img alt="On the Job" title="On the Job" name="onthejobimg" src="'+path+'/images/btn_on_the_job_off.jpg" onmouseover="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_on.jpg\'" onmouseout="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_off.jpg\'" /></a>';	
		document.getElementById('educationlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'education\');"><img alt="Education & Training" title="Education & Training" name="educationimg" src="'+path+'/images/btn_education_training_off.jpg" onmouseover="document.educationimg.src=\''+path+'/images/btn_education_training_on.jpg\'" onmouseout="document.educationimg.src=\''+path+'/images/btn_education_training_off.jpg\'" /></a>';	
		document.getElementById('resourceslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'resources\');"><img alt="Resources" title="Resources" name="resourcesimg" src="'+path+'/images/btn_resources_off.jpg" onmouseover="document.resourcesimg.src=\''+path+'/images/btn_resources_on.jpg\'" onmouseout="document.resourcesimg.src=\''+path+'/images/btn_resources_off.jpg\'" /></a>';
	}
	if (where=='skills') { 
		document.getElementById('details-skills').style.display = 'block';
	}
	if (where=='salary') {
		$('#loading').removeClass('off');
		
		$('#details-salary').load('/careerladder/salarydiv.php?onetcode=<?php echo $onetcode; ?>&zipcode=<?php echo $zipcode; ?>', function() {
			document.getElementById('details-left').style.display = 'none';
			document.getElementById('details-skills').style.display = 'none';
			document.getElementById('details-salary').style.display = 'block';
			document.getElementById('details-onthejob').style.display = 'none';
			document.getElementById('details-education').style.display = 'none';
			document.getElementById('details-skills').style.display = 'none';
			document.getElementById('details-resources').style.display = 'none';
			
			$('#loading').addClass('off');
		});

		
				
		document.getElementById('overviewlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'overview\');"><img alt="Overview" title="Overview" name="overviewimg" src="'+path+'/images/btn_overview_off.jpg" onmouseover="document.overviewimg.src=\''+path+'/images/btn_overview_on.jpg\'" onmouseout="document.overviewimg.src=\''+path+'/images/btn_overview_off.jpg\'" /></a>';
		document.getElementById('skillslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'skills\');"><img alt="Skills & Tools" title="Skills & Tools" name="skillsimg" src="'+path+'/images/btn_skills_tools_off.jpg" onmouseover="document.skillsimg.src=\''+path+'/images/btn_skills_tools_on.jpg\'" onmouseout="document.skillsimg.src=\''+path+'/images/btn_skills_tools_off.jpg\'" /></a>';
		document.getElementById('salarylink').innerHTML = '<img alt="Salary & Outlook" title="Salary & Outlook" name="salaryimg" src="'+path+'/images/btn_salary_outlook_on.jpg" /><img style = "display:none;" alt="Salary & Outlook" title="Salary & Outlook" name="salaryimg" src="'+path+'/images/btn_salary_outlook_on.jpg" />';
		document.getElementById('onthejoblink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'onthejob\');"><img alt="On the Job" title="On the Job" name="onthejobimg" src="'+path+'/images/btn_on_the_job_off.jpg" onmouseover="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_on.jpg\'" onmouseout="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_off.jpg\'" /></a>';	
		document.getElementById('educationlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'education\');"><img alt="Education & Training" title="Education & Training" name="educationimg" src="'+path+'/images/btn_education_training_off.jpg" onmouseover="document.educationimg.src=\''+path+'/images/btn_education_training_on.jpg\'" onmouseout="document.educationimg.src=\''+path+'/images/btn_education_training_off.jpg\'" /></a>';	
		document.getElementById('resourceslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'resources\');"><img alt="Resources" title="Resources" name="resourcesimg" src="'+path+'/images/btn_resources_off.jpg" onmouseover="document.resourcesimg.src=\''+path+'/images/btn_resources_on.jpg\'" onmouseout="document.resourcesimg.src=\''+path+'/images/btn_resources_off.jpg\'" /></a>';
		
	}
	if (where=='onthejob') { 
		document.getElementById('details-left').style.display = 'none';
		document.getElementById('details-skills').style.display = 'none';
		document.getElementById('details-salary').style.display = 'none';
		document.getElementById('details-onthejob').style.display = 'block';
		document.getElementById('details-education').style.display = 'none';
		document.getElementById('details-skills').style.display = 'none';
		document.getElementById('details-resources').style.display = 'none';
		
		document.getElementById('overviewlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'overview\');"><img alt="Overview" title="Overview" name="overviewimg" src="'+path+'/images/btn_overview_off.jpg" onmouseover="document.overviewimg.src=\''+path+'/images/btn_overview_on.jpg\'" onmouseout="document.overviewimg.src=\''+path+'/images/btn_overview_off.jpg\'" /></a>';
		document.getElementById('skillslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'skills\');"><img alt="Skills & Tools" title="Skills & Tools" name="skillsimg" src="'+path+'/images/btn_skills_tools_off.jpg" onmouseover="document.skillsimg.src=\''+path+'/images/btn_skills_tools_on.jpg\'" onmouseout="document.skillsimg.src=\''+path+'/images/btn_skills_tools_off.jpg\'" /></a>';
		document.getElementById('salarylink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'salary\');"><img alt="Salary & Outlook" title="Salary & Outlook" name="salaryimg" src="'+path+'/images/btn_salary_outlook_off.jpg" onmouseover="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_on.jpg\'" onmouseout="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_off.jpg\'" /></a>';
		document.getElementById('onthejoblink').innerHTML = '<img alt="On the Job" title="On the Job" name="onthejobimg" src="'+path+'/images/btn_on_the_job_on.jpg" /><img style = "display:none;" alt="On the Job" title="On the Job" name="onthejobimg" src="'+path+'/images/btn_on_the_job_on.jpg" />';	
		document.getElementById('educationlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'education\');"><img alt="Education & Training" title="Education & Training" name="educationimg" src="'+path+'/images/btn_education_training_off.jpg" onmouseover="document.educationimg.src=\''+path+'/images/btn_education_training_on.jpg\'" onmouseout="document.educationimg.src=\''+path+'/images/btn_education_training_off.jpg\'" /></a>';	
		document.getElementById('resourceslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'resources\');"><img alt="Resources" title="Resources" name="resourcesimg" src="'+path+'/images/btn_resources_off.jpg" onmouseover="document.resourcesimg.src=\''+path+'/images/btn_resources_on.jpg\'" onmouseout="document.resourcesimg.src=\''+path+'/images/btn_resources_off.jpg\'" /></a>';
	}
	if (where=='education') {
		document.getElementById('details-left').style.display = 'none';
		document.getElementById('details-skills').style.display = 'none';
		document.getElementById('details-salary').style.display = 'none';
		document.getElementById('details-onthejob').style.display = 'none';
		document.getElementById('details-education').style.display = 'block';
		document.getElementById('details-skills').style.display = 'none';
		document.getElementById('details-resources').style.display = 'none';
		
		document.getElementById('overviewlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'overview\');"><img alt="Overview" title="Overview" name="overviewimg" src="'+path+'/images/btn_overview_off.jpg" onmouseover="document.overviewimg.src=\''+path+'/images/btn_overview_on.jpg\'" onmouseout="document.overviewimg.src=\''+path+'/images/btn_overview_off.jpg\'" /></a>';
		document.getElementById('skillslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'skills\');"><img alt="Skills & Tools" title="Skills & Tools" name="skillsimg" src="'+path+'/images/btn_skills_tools_off.jpg" onmouseover="document.skillsimg.src=\''+path+'/images/btn_skills_tools_on.jpg\'" onmouseout="document.skillsimg.src=\''+path+'/images/btn_skills_tools_off.jpg\'" /></a>';
		document.getElementById('salarylink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'salary\');"><img alt="Salary & Outlook" title="Salary & Outlook" name="salaryimg" src="'+path+'/images/btn_salary_outlook_off.jpg" onmouseover="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_on.jpg\'" onmouseout="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_off.jpg\'" /></a>';
		document.getElementById('onthejoblink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'onthejob\');"><img alt="On the Job" title="On the Job" name="onthejobimg" src="'+path+'/images/btn_on_the_job_off.jpg" onmouseover="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_on.jpg\'" onmouseout="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_off.jpg\'" /></a>';	
		document.getElementById('educationlink').innerHTML = '<img alt="Education & Training" title="Education & Training" name="educationimg" src="'+path+'/images/btn_education_training_on.jpg" /><img style = "display:none;" alt="Education & Training" title="Education & Training" name="educationimg" src="'+path+'/images/btn_education_training_on.jpg" />';	
		document.getElementById('resourceslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'resources\');"><img alt="Resources" title="Resources" name="resourcesimg" src="'+path+'/images/btn_resources_off.jpg" onmouseover="document.resourcesimg.src=\''+path+'/images/btn_resources_on.jpg\'" onmouseout="document.resourcesimg.src=\''+path+'/images/btn_resources_off.jpg\'" /></a>';
	}
	if (where=='resources') {
		document.getElementById('details-left').style.display = 'none';
		document.getElementById('details-skills').style.display = 'none';
		document.getElementById('details-salary').style.display = 'none';
		document.getElementById('details-onthejob').style.display = 'none';
		document.getElementById('details-education').style.display = 'none';
		document.getElementById('details-skills').style.display = 'none';
		document.getElementById('details-resources').style.display = 'block';
		
		document.getElementById('overviewlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'overview\');"><img alt="Overview" title="Overview" name="overviewimg" src="'+path+'/images/btn_overview_off.jpg" onmouseover="document.overviewimg.src=\''+path+'/images/btn_overview_on.jpg\'" onmouseout="document.overviewimg.src=\''+path+'/images/btn_overview_off.jpg\'" /></a>';
		document.getElementById('skillslink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'skills\');"><img alt="Skills & Tools" title="Skills & Tools" name="skillsimg" src="'+path+'/images/btn_skills_tools_off.jpg" onmouseover="document.skillsimg.src=\''+path+'/images/btn_skills_tools_on.jpg\'" onmouseout="document.skillsimg.src=\''+path+'/images/btn_skills_tools_off.jpg\'" /></a>';
		document.getElementById('salarylink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'salary\');"><img alt="Salary & Outlook" title="Salary & Outlook" name="salaryimg" src="'+path+'/images/btn_salary_outlook_off.jpg" onmouseover="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_on.jpg\'" onmouseout="document.salaryimg.src=\''+path+'/images/btn_salary_outlook_off.jpg\'" /></a>';
		document.getElementById('onthejoblink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'onthejob\');"><img alt="On the Job" title="On the Job" name="onthejobimg" src="'+path+'/images/btn_on_the_job_off.jpg" onmouseover="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_on.jpg\'" onmouseout="document.onthejobimg.src=\''+path+'/images/btn_on_the_job_off.jpg\'" /></a>';	
		document.getElementById('educationlink').innerHTML = '<a href="javascript:void(0);" onclick="changemain(\'education\');"><img alt="Education & Training" title="Education & Training" name="educationimg" src="'+path+'/images/btn_education_training_off.jpg" onmouseover="document.educationimg.src=\''+path+'/images/btn_education_training_on.jpg\'" onmouseout="document.educationimg.src=\''+path+'/images/btn_education_training_off.jpg\'" /></a>';		
		document.getElementById('resourceslink').innerHTML = '<img alt="Resources" title="Resources" name="resourcesimg" src="'+path+'/images/btn_resources_on.jpg" /><img style = "display:none;" alt="Resources" title="Resources" name="resourcesimg" src="'+path+'/images/btn_resources_on.jpg" />';
	}
  
  }
  
  function moredetailsdisp(which, bigdiv, littlediv) {

	if (document.getElementById('more'+bigdiv).style.display=="block" && which=='l') {
		document.getElementById('more'+bigdiv).style.display="none";
		document.getElementById('more'+littlediv).style.display="block";
		document.getElementById('less'+littlediv).style.display="none";
	}
	if (which=='m') {
		document.getElementById('more'+bigdiv).style.display="block";
		document.getElementById('more'+littlediv).style.display="none";
		document.getElementById('less'+littlediv).style.display="block";
	}

  }
  
  function ziplength(value) {
	document.getElementById('zip').setAttribute('maxlength','10');
  }
  
		function numericonly(evt) {			

			var key = (evt.which) ? evt.which : event.keyCode;

			if (key!=45 && key > 31 && (key < 48 || key > 57))
				return false;

			return true;			

			//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
		}

	
  function salaryonoff(text) {

	var zipcode = '<?php echo $zipcode; ?>';
  
	if (text=='wage-table') {
		document.getElementById(text).style.display="block";
		document.getElementById(text+'-link').style.fontWeight = "bold";
		document.getElementById('hourly-wage-chart-link').style.fontWeight = "normal";
		document.getElementById('annual-wage-chart-link').style.fontWeight  = "normal";
		document.getElementById('hourly-wage-chart').style.display="none";
		document.getElementById('annual-wage-chart').style.display="none";
	
	}
	else if (text=='hourly-wage-chart') {
		document.getElementById(text).style.display="block";
		document.getElementById(text+'-link').style.fontWeight = "bold";
		document.getElementById('wage-table-link').style.fontWeight = "normal";
		document.getElementById('annual-wage-chart-link').style.fontWeight = "normal";		
		document.getElementById('wage-table').style.display="none";
		document.getElementById('annual-wage-chart').style.display="none";
	
	}
	else if (text=='annual-wage-chart') {
		document.getElementById(text).style.display="block";
		document.getElementById(text+'-link').style.fontWeight = "bold";
		document.getElementById('hourly-wage-chart-link').style.fontWeight = "normal";
		document.getElementById('wage-table-link').style.fontWeight = "normal";		
		document.getElementById('hourly-wage-chart').style.display="none";
		document.getElementById('wage-table').style.display="none";
	
	}	
	else {
	
		alert('Please enter a ZIP Code.');
	
	}
  
  }


	  
function goformaction() {
        //var zipvalueinoccupationdetail = $('#zip').val();
        var zipvalueinoccupationdetail = document.getElementById('zip').value;
            $('#zipod').load('/careerladder/zipvalidation.php?zipcode='+zipvalueinoccupationdetail, function() {
                  var zval = document.getElementById("zipod").innerHTML;
                  if(zval == 'true' || zipvalueinoccupationdetail == '' || zipvalueinoccupationdetail == 'Zip code'){
                        var tab='';
                        if (document.getElementById('details-left').style.display == 'block')
                              tab='overview';
                        else if (document.getElementById('details-skills').style.display == 'block')
                              tab='skills';
                        else if (document.getElementById('details-salary').style.display == 'block')
                              tab='salary';
                        else if (document.getElementById('details-onthejob').style.display == 'block')
                              tab='onthejob';
                        else if (document.getElementById('details-education').style.display == 'block')
                              tab='education';
                        else if (document.getElementById('details-resources').style.display == 'block')
                              tab='resources';
                    
						var theurl = document.thegoform.action='<?php echo base_path(); ?>careerdetails?onetcode=<?php echo $onetcode; ?>&tab='+tab+'&zip='+zipvalueinoccupationdetail;
						
						window.open(theurl,'_self');
						
                       // document.thegoform.action='<?php echo base_path(); ?>careerdetails?onetcode=<?php echo $onetcode; ?>&tab='+tab;
                     // document.forms["thegoform"].submit();
                          }
              else 
                          {
							$("#zip").addClass("redborder");
						 alert('Please enter a valid US ZIP Code');
						document.searchform.zip.focus();	

                        return false;
                          }
            });
  }


</script> 


<br/><br/>

<div id="details-left" class="details-left">
				<span class="lineunder">Other Names</span><br/>
					<?php $olts2=''; $oltc=-1; $olts=''; foreach ($content->onetsoclaytitle->item as $olt): $oltc++; ?>
						
						<?php 
						
						if ($oltc<15) {
							if ($_GET['value']==$content->onetsoclaytitle->item[$oltc]->laytitle)
								$olts.='<b>'.$content->onetsoclaytitle->item[$oltc]->laytitle.'</b>, '; 
							else
								$olts.=$content->onetsoclaytitle->item[$oltc]->laytitle.', '; 
						} else {
							if ($oltc==15)
								$olts.=', ';
								
							if ($_GET['value']==$content->onetsoclaytitle->item[$oltc]->laytitle)
								$olts2.='<b>'.$content->onetsoclaytitle->item[$oltc]->laytitle.'</b>, '; 
							else
								$olts2.=$content->onetsoclaytitle->item[$oltc]->laytitle.', '; 
								
							if ($oltc%15==0 && $oltc>15)
								$olts2.='<br/><br/>';
						}
						
						?>
					
					<?php endforeach; ?>
					
					<?php $olts = substr($olts, 0, -2); echo $olts; ?>
					
					<?php if ($olts2): ?>
					<br/><br/>
			
					<div id="moredetailslay" style="display:none;">				
					<?php $olts2 = substr($olts2, 0, -2);  echo $olts2; ?>
					</div>
					
					<?php endif; ?>
					<span id='morelay' style='float:right;<?php if ($oltc<15) echo 'display:none;'; ?>'><a href='javascript:void(0);' onclick="$('#moredetailslay').show();$('#morelay').hide();$('#lesslay').show();">More Detail</a></span>
					<span id='lesslay' style='float:right; display:none;'><a href='javascript:void(0);' onclick="$('#moredetailslay').hide();$('#morelay').show();$('#lesslay').hide();">Less Detail</a></span>					
					
				<br/><br/>
				

				<span class="lineunder">Description</span><br/>
                <?php 
				$desc = $content->detaileddescription;
				
				$pieces = explode ('.',$desc);
				
				if ($pieces[0])
				echo $pieces[0].".";
				if ($pieces[1])
					echo $pieces[1]."."; 
				
				echo "<br/><br/>";
				
				echo '<div id="moredetails" style="display:none;">';
				
				$keycount=0;
				foreach ($pieces as $key=>$value)
					$keycount++;
				
				foreach ($pieces as $key=>$value) {
					if ($key>=2 && $key<$keycount-1)
						echo $pieces[$key].'.';

				
				}
				echo '</div>';
				
				if ($pieces[2]) {
					echo "<span id='mored' style='float:right;'><a href='javascript:void(0);' onclick=\"moredetailsdisp('m','details','d');\">More Detail</a></span>";
					echo "<span id='lessd' style='float:right; display:none;'><a href='javascript:void(0);' onclick=\"moredetailsdisp('l','details','d');\">Less Detail</a></span>";
				}
				?>
				
				
				
				 <?php 
				$pr = $content->physicalrequirement;

				
				if ($pr && !stristr($pr,'None Specified') && !stristr($pr,'Non Specified') && !stristr($pr,'no data available') && strlen($pr)>1) {
				
				
				echo '<br/><br/>
				<span class="lineunder">Physical Requirements</span><br/>';		
					$pr = str_replace('e.g.','|EG|',$pr);
										
					$pieces = explode ('.',$pr);

					foreach ($pieces as $e1 => $e2)
						if (strstr($pieces[$e1],'|EG|'))
							$pieces[$e1] = str_replace('|EG|','e.g.',$pieces[$e1]);
					
					
						
					if ($pieces[0])
					echo $pieces[0].".";
					if ($pieces[1]) {
						echo $pieces[1]."."; 
					}
					else {
						if (strstr($content->physicalrequirementurl,'http://') && $content->physicalrequirementurlflag==1)
							echo '<br/><br/><a target="_blank" href="'.$content->physicalrequirementurl.'">Additional Information</a>'; 					
					}

					
					
					echo "<br/><br/>";
					
					echo '<div id="morepreq" style="display:none;">';
					
					$keycount=0;
					foreach ($pieces as $key=>$value)
						$keycount++;
					
					foreach ($pieces as $key=>$value) {
						if ($key>=2 && $key<$keycount) {
							echo $pieces[$key];
							if (strlen($pieces[$key]))
								echo '.';
							
						}
					
					}
					if (strstr($content->physicalrequirementurl,'http://'))
						echo '<br/><br/><a target="_blank" href="'.$content->physicalrequirementurl.'">Additional Information</a>'; 
					echo '</div>';

					if ($pieces[2]) {
						echo "<br/><span id='morepr' style='float:right;'><a href='javascript:void(0);' onclick=\"moredetailsdisp('m','preq','pr');\">More Detail</a></span>";
						echo "<br/><span id='lesspr' style='float:right; display:none;'><a href='javascript:void(0);' onclick=\"moredetailsdisp('l','preq','pr');\">Less Detail</a></span>";
					}
				}
				?>
				
				
				
				
				 <?php 
				$pr = $content->healthrequirement;
				
				
				
				if ($pr && !stristr($pr,'None Specified') && !stristr($pr,'Non Specified') && !stristr($pr,'no data available') && strlen($pr)>1) {
				
					echo '<br/><br/>
					<span class="lineunder">Medical/Health Requirements</span><br/>';
					$pieces = explode ('.',$pr);
					
					if ($pieces[0])
					echo $pieces[0].".";
					//if ($pieces[1])
						//echo $pieces[1]."."; 
					
					echo "<br/><br/>";
					
					echo '<div id="morehreq" style="display:none;">';
					
					$keycount=0;
					foreach ($pieces as $key=>$value)
						$keycount++;
					
					foreach ($pieces as $key=>$value) {
						if ($key>=1 && $key<$keycount)
							echo $pieces[$key].'.';

					
					}
					echo '</div>';
					
					if ($pieces[1]) {
						echo "<span id='morehr' style='float:right;'><a href='javascript:void(0);' onclick=\"moredetailsdisp('m','hreq','hr');\">More Detail</a></span>";
						echo "<span id='lesshr' style='float:right; display:none;'><a href='javascript:void(0);' onclick=\"moredetailsdisp('l','hreq','hr');\">Less Detail</a></span>";
					}
				}
				?>


				
				
				
				 <?php 
				$pr = $content->occupationlegalrequirement->item[0]->legalrequirement;
				//if ($pr && !stristr($pr,'None Specified') && !stristr($pr,'Non Specified') && !stristr($pr,'no data available') && strlen($pr)>1) {
				
					echo '<br/><br/>
					<span class="lineunder">Legal Requirements</span><br/>';
					
					$pieces = explode ('.',$pr);
					
					
					foreach($pieces as $pk => $pv) {
						if (strlen($pieces[$pk])<30 || $pieces[$pk][1]=='(' || !preg_match('/[A-Z]$/',$pieces[$pk]{0})  ) {
							$pieces[0].='.'.$pieces[$pk];
								unset ($pieces[$pk]);
						}
					
					}
				
					foreach($pieces as $pk2 => $pv2)
						$piecestemp[] = $pieces[$pk2];
					
					$pieces=$piecestemp;
					
					
					if (strlen($content->occupationlegalrequirement->item[0]->absoluteprohibitions)) {
						$tempfirstpiece = $pieces[0];					
						$pieces[0] = $content->occupationlegalrequirement->item[0]->absoluteprohibitions."<br/><br/>".$tempfirstpiece;
					}
					
					if (strlen((string)$content->occupationlegalrequirement->item[0]->healthissues) || strlen((string)$content->occupationlegalrequirement->item[0]->genericrequirements)) {
						$countpieces = count($pieces);
						
						if (strlen((string)$content->occupationlegalrequirement->item[0]->healthissues))
							$pieces[$countpieces] = (string)$content->occupationlegalrequirement->item[0]->healthissues;
						if (strlen((string)$content->occupationlegalrequirement->item[0]->genericrequirements)) { 
							//if (strlen((string)$content->occupationlegalrequirement->item[0]->healthissues))
							if (isset($pieces[0]) && isset($pieces[1]))
								$pieces[$countpieces+1]	=	"<br/><br/>";
							$pieces[$countpieces+1]	.= (string)$content->occupationlegalrequirement->item[0]->genericrequirements;
						}
							
							
					}

					$temppieces=array();
					
					foreach ($pieces as $kp => $kv)
						$temppieces[]=$kv;
						
					$pieces = $temppieces;

					if (isset($pieces[2]) && !isset($pieces[1])){
						$pieces[1]=$pieces[2];
						unset($pieces[2]);
					}
					
					if ($pieces[0]) {
						if ($pieces[0][strlen($pieces[0])-1]=='.')
							echo $pieces[0];
						else
							echo $pieces[0].".";
						
						
					}
					else {
						echo 'Please enter your ZIP Code to view the legal requirements of this occupation.';
					}
					
					//if ($pieces[1])
						//echo $pieces[1]."."; 
					
					if ($pieces[1])
						echo "<br/><br/>";

					if (!strlen($pieces[1]) && strlen($content->occupationlegalrequirement->item[0]->associatedurl)>1 && $content->occupationlegalrequirement->item[0]->associatedurlflag==1)
						echo "<br/><br/>For additional information, <a target='_blank' href='".$content->occupationlegalrequirement->item[0]->associatedurl."'>click here</a>";
					
					echo '<div id="morelreq" style="display:none;">';
					
					$keycount=0;
					foreach ($pieces as $key=>$value)
						$keycount++;
					
					foreach ($pieces as $key=>$value) {
						if ($key>=1 && $key<$keycount) {
							echo $pieces[$key];
							
							//if (strlen($pieces[$key])>1)
							//	echo '.';
							
							
						}

					
					}
					
					if (strlen($content->occupationlegalrequirement->item[0]->associatedurl)>1)
							echo "<br/><br/>For additional information, <a target='_blank' href='".$content->occupationlegalrequirement->item[0]->associatedurl."'>click here</a>";
							
					echo '</div>';

					if ($pieces[1]) {
						echo "<span id='morelr' style='float:right;'><a href='javascript:void(0);' onclick=\"moredetailsdisp('m','lreq','lr');\">More Detail</a></span>";
						echo "<span id='lesslr' style='float:right; display:none;'><a href='javascript:void(0);' onclick=\"moredetailsdisp('l','lreq','lr');\">Less Detail</a></span>";
					}
				//}
				?>

				
				
				<?php
				
				$ar = $content->academicrequirement;
				
				if (strlen($ar)<-100) {
					echo "<br/><br/><br/><b>Education & Training</b><br/><hr style=\"border-top: none; border-bottom: 1px solid;\" />";
					
					$pieces = explode ('.',$ar);
					if ($pieces[0]!="{null}")
						echo $pieces[0].".";
					if ($pieces[1])
						echo $pieces[1]."."; 
					echo "<br/><br/><span style='float:right;'><a href='javascript:void(0);' onclick='changemain(\"education\");'>More Detail</a></span>";
				}



//echo $doesitwork;


?>


<?php if (strlen($ar)<-100 AND ($content->skills->item OR $content->toolstechnology->tools->item OR $content->toolstechnology->technology->item)) : ?>
                <div class="skills" >
                                <br/><br/><span class="lineunder">Skills & Tools</span><br/>
								
                                <?php if ($content->skills->item) echo  goodImplodeD($content->skills->item,'5','comma'); ?>															
                </div>				
<?php endif; ?>


<?php if (strlen($ar)<-100 AND ($content->toolstechnology->tools->item OR $content->toolstechnology->technology->item)) :?>
                <div class="toolsandtech">
                                <ul>
                                <?php if ($content->toolstechnology->tools->item) echo '<li><strong>Tools: </strong>'. goodImplodeD($content->toolstechnology->tools->item,'5','comma')
								. '</li>'; ?>
								
                                <?php if ($content->toolstechnology->technology->item) echo '<br/><li><strong>Technology: </strong>'. goodImplodeD($content->toolstechnology->technology->item,'5','comma') 
								. '</li>'; ?>
								
                                </ul> 
								<span style='float:right;'><a href="javascript:void(0);" onclick="changemain('skills');">More Detail</a></span>	
                </div>
								
<?php endif; ?>                

<?php if ($jobtitles) : ?>
                <div class="jobtitles">
                                <h3>Job Title Examples</h3>
                                <?php 
                                                foreach ( $jobtitles AS $title) {
                                                                echo '<li>$title</li>'; 
                                                }
                                ?> 
                             
                </div>   
				
<?php endif; ?>

</div>

<div id="details-salary" class="details-salary" style="display:none; float:left; width:60%;">


</div>

<div id="details-onthejob" class="details-onthejob" style="display:none; float:left; width:60%;">
<span class="lineunder">A Day In The Life</span>

<?php if ($content->dayinlife) {

echo $content->dayinlife; 
//echo "<br/>"; 

if ($content->dayinlifeurl!="{null}" && $content->dayinlifeurl!="" && !(stristr($content->dayinlifeurl, 'null')) && $content->dayinlifeurlflag==ph)
	echo $content->dayinlifeurldescription.' <a target="_blank" href="'.$content->dayinlifeurl.'">click here</a>'; 

} else {

echo "No information available."; 

}
 ?>
 <br/><br/>
 

 <?php if (strlen($content->occupationinterview->item[0]->interviewurldescription)>0) {

echo '<span class="lineunder">Interview</span>';
	$ivcount=-1;
	foreach ($content->occupationinterview->item as $iv) {
		$ivcount++;
		echo $content->occupationinterview->item[$ivcount]->interviewdescription; echo "<br/><br/>"; 

		if ($content->occupationinterview->item[$ivcount]->interviewurl!="{null}" && $content->occupationinterview->item[$ivcount]->interviewurl!="" && !(stristr($content->occupationinterview->item[$ivcount]->interviewurl, 'null')) && $content->occupationinterview->item[$ivcount]->interviewurlflag==1)
			echo $content->occupationinterview->item[$ivcount]->interviewurldescription.' <a target="_blank" href="'.$content->occupationinterview->item[$ivcount]->interviewurl.'">click here</a>'; 
			
		//echo '<br/><br/>';
	}
} 
 ?>
 
</div>

<div id="details-education" class="details-education" style="display:none; float:left; width:60%;">
<span class="lineunder">Education & Training</span><br/>

<?php if (getTrainingD($content->alltraining->item[0]->name) && $content->alltraining->item[0]->datavalue) {

if (!$content->alltraining->item[0]->datavalue || $content->alltraining->item[0]->datavalue==0)
	$content->alltraining->item[0]->datavalue=0.1;
	
if (!$content->alltraining->item[1]->datavalue || $content->alltraining->item[1]->datavalue==0)
	$content->alltraining->item[1]->datavalue=0.1;
	
if (!$content->alltraining->item[2]->datavalue || $content->alltraining->item[2]->datavalue==0)
	$content->alltraining->item[2]->datavalue=0.1;

echo '<img alt="Education & Training graph" src = "/careerladder/education.php?e1='.getTrainingD($content->alltraining->item[0]->name).'&v1='.$content->alltraining->item[0]->datavalue.'&e2='.getTrainingD($content->alltraining->item[1]->name).'&v2='.$content->alltraining->item[1]->datavalue.'&e3='.getTrainingD($content->alltraining->item[2]->name).'&v3='.$content->alltraining->item[2]->datavalue.'" />';

} ?>

<p>
<?php echo $content->edugraphsrcdesc; ?>
</p>

<?php if (!strlen($ar)): ?>
Education information not available.
<?php endif; ?>

<?php if ($ar!="{null}") echo $ar; ?>
</div>

<div id="details-skills" class="details-skills" style="display:none; float:left; width:60%;">

                <div class="skills" >
                                <span class="lineunder">Skills</span><br/>
								
								<?php if ($onetcode=='29-1128.00' || $onetcode=='29-2035.00' || $onetcode=='31-9097.00'): ?>
								
								
								This is a new career for 2011 and the data is not yet available.  The information will be provided when it becomes available.
								
								<?php else: ?>
								
                                <?php if ($content->skills->item) echo  goodImplodeD($content->skills->item,'10','br'); else echo 'No information available.'; ?> 
								
								<?php endif; ?>
                </div>


<?php if ($content->toolstechnology->tools OR $content->toolstechnology->technology) :?>
                <div class="toolsandtech">
                                <br/><br/><span class="lineunder">Tools</span><br/>
                                <?php if ($content->toolstechnology->tools->item) echo goodImplodeD($content->toolstechnology->tools->item,'10','br'); else echo 'No information available.'; ?> 
								<br/><br/><span class="lineunder">Technology</span><br/>
                                <?php if ($content->toolstechnology->technology->item) echo goodImplodeD($content->toolstechnology->technology->item,'10','br'); else echo 'No information available.'; ?>
                </div>   
<?php endif; ?>  
</div>

<div id="details-resources" class="details-resources" style="display:none; float:left; width:60%;">
<span class="lineunder">Resources related to the Career</span><br/>
<?php if ($content->occupationresource->item[0]): ?>


<?php  $tempar = array(); $count=-1; foreach ($content->occupationresource->item as $oritem): $count++;

$tempar[] = (string)$content->occupationresource->item[$count]->occresourcecategory->categoryname;

endforeach;

asort($tempar);

$tempar2=array();
foreach ($tempar as $k=>$v) {
	$tempar2[] = $k;
}


?>



<?php $count=-1; foreach ($content->occupationresource->item as $oritem): $count++; ?>
<b><?php 
if ((string)$content->occupationresource->item[$tempar2[$count-1]]->occresourcecategory->categoryname != (string)$content->occupationresource->item[$tempar2[$count]]->occresourcecategory->categoryname || $count==0) 
	echo $content->occupationresource->item[$tempar2[$count]]->occresourcecategory->categoryname."<br/>";
	?></b>

<?php if ($content->occupationresource->item[$tempar2[$count]]->resourcelinkflag==1): ?>
<a target="_blank" href="<?php echo $content->occupationresource->item[$tempar2[$count]]->resourcelink; ?>"><?php echo $content->occupationresource->item[$tempar2[$count]]->resourcename; ?></a><br/>
<br/>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>

<!-- <b>Funding Opportunities</b><br/>
<a target="_blank" href="http://explorehealthcareers.org/en/careers/funding">Search for funding opportunities related to this career</a>
<br/><br/> -->


<?php if ($content->occupationfinancialaid->item[0]): ?>

<b>Financial Aid</b>
<br/>
<?php $count=-1; foreach ($content->occupationfinancialaid->item as $v): $count++; ?>
<?php if ($content->occupationfinancialaid->item[$count]->financialaidurlflag==1): ?>
<a target="_blank" href="<?php echo $content->occupationfinancialaid->item[$count]->financialaidurl; ?>"><?php echo $content->occupationfinancialaid->item[$count]->financialaidname; ?></a>
<?php endif; ?>
<br/>
<?php endforeach; ?>
<?php endif; ?>

</div>


<?php if ($content->displaytitle): ?>
<div class="details-right" id="dronoff">
			<?php if (getVideoLink($onetcode,$onetcode) && file_exists("../".$videoImage)): ?>
                <div id="video-link">          
								<?php if (strstr($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')):?>
                                <a href="javascript:void(0);" alt="<?php echo $content->title; ?>" onclick="javascript: window.open('/careerladder/video.php?onetcode=<?php echo $onetcode; ?>&displaytitle=<?php echo $content->displaytitle; ?>','','width=443,height=371');">
                                <img class="imgA1" alt="Video" src="<?php echo $videoImage; ?>" width="212" height="212">
                                <img class="imgB1" alt="Play" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/play.png">
                                </a>								
								
								<?php else: ?>
								
                                <a href="<?php echo getVideoLink($onetcode,$onetcode); ?>" alt="<?php echo $content->title; ?>" toptions="width = 425, height = 344, resizable = 1, layout=flatlook, title=<?php echo $content->displaytitle; ?>, shaded=1">
                                <img class="imgA1" alt="Video" src="<?php echo $videoImage; ?>" width="212" height="212">
                                <img class="imgB1" alt="Play" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/play.png">
                                </a>
								
								<?php endif; ?>
                                
                </div>
			<?php endif; ?>
			
                <div id="career-snapshot">
                                <h4>Career Snapshot</h4>
                                <?php 
                                //if reusable form:
                                //echo get_training_form()
                                ?>           
                                <!-- onblur="if (this.value=='' || !(this.value.match(/^[0-9]+$/))) this.value='<?php if($zipcode) echo $zipcode; else echo 'Zip code'; ?>';"  -->
                                <form method="post" action="javascript: void(0);" name="thegoform" onsubmit="goformaction();" >
                                                <div>
                                                Enter ZIP Code to see locality specific information.
                                                </div>

												<div style="position:absolute; margin-top:12px;">
													<div style="position:relative; float:left; height:30px;">
													<label for="zip">
													<input type="text" name="zip" id="zip" maxlength="5" onclick="if (this.value=='ZIP Code') this.value=''; " onkeypress="return numericonly(event);"
													
													
													<?php 
													if($zipcode && $zipcode!="00000")
														echo 'value="'.$zipcode.'"'; 
													else
														echo 'value="ZIP Code"'; 
													
													?> size="10" style="height:20px;" />
													</label>												
													<?php 
													$referar = '';
													$_SERVER['HTTP_REFERER'];
													if(strstr($_SESSION['HTTP_REFERER'],  'careergrid')){ //echo 'if';
														$job_category_title = explode('=',$_SESSION['HTTP_REFERER']);
														$referar = $job_category_title[1];
													}else if(isset($_SESSION['careergrid']) && $_SESSION['careergrid'] != ''){// echo 'else';
															$referar = $_SESSION['careergrid'];														
													}
												//	echo $referar;
													unset($_SESSION['careergrid']);
													 ?>
													<input type="hidden" name="referer_url" value="<?php echo $referar; ?>">
													<input type="hidden" name="frompage" id="frompage" value="true" />
													</div>
													<div style="position:relative; float:left; margin-left:5px;">
													<input type="image" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/go.png" alt="Go" title="Go" />
													</div>													
												</div>
												<br/><br/><br/><br/>
                                </form>
                </div>
			
                <?php if ($content->typicaltraining->title) : ?>    
                                <div id="training">
                                                <h4>Education & Training</h4>
                                                <?php echo '<b>Typical Education:</b><br/>'.$content->typicaltraining->title; ?>
												
												<?php //echo '<b>Typical Education:</b><br/>'.getTrainingD($content->alltraining->item[0]->name); ?>
												<br/>
												<?php
		  
												if (strlen($zipcode)==5 && $zipcode!="00000") 
													echo '<a href="'.base_path().'find-learning/results/programs/onetcode/'.$onetcode.'/zip/'.$zipcode.'/distance/100">Find Programs in '.$zipcode.'</a>';
												else
													echo '<a href="'.base_path().'find-learning/results/programs/onetcode/'.$onetcode.'/zip/none">Find Programs</a>';
												  ?>
                                </div>
                <?php endif; ?>                
                
				<hr style="border-bottom: 1px solid #808080; border-top: 0px; margin-top:20px; margin-bottom:15px;" />
				
                 
                <div id="job-growth">
								<h4>Jobs</h4>
                                <strong>Percent growth: </strong><?php $percent = floatval($content->jobgrowth->percent); if ($percent) echo number_format($percent,0,'.',',')."%"; else echo "Not available"; ?>
                                <br />
                                <?php echo $content->jobgrowth->text;
								
								if (strlen($zipcode)==5 && $zipcode!="00000") {
									echo '<br/><a href="'.base_path().'findworkresults?onetcode='.$onetcode.'&onetcode2='.$onetcode.'&zipcode='.$zipcode.'&distance=100">Find Jobs in '.$zipcode.'</a>';
								
								}
								else {
									echo '<br/><a href="'.base_path().'findworkresults?onetcode='.$onetcode.'&onetcode2='.$onetcode.'&zipcode=00000&distance=100">Find Jobs</a>';
								}
								?>
                </div>
                           
              
				<hr style="border-bottom: 1px solid #808080; border-top: 0px; margin-top:20px; margin-bottom:15px;" />
				<?php $annual = intval($content->wageocc->item[1]->pct25); $annual2 = intval($content->wageocc->item[1]->pct75);   ?> 
                         
                <div id="salary">
                <h4>Salary
				<?php if (strlen($zipcode)==5 && $zipcode!="00000"): ?>
				in <?php echo $zipcode; ?>
				<?php endif; ?>
				</h4>
						 <?php if ($content->wageocc->item[0]->entrywg AND $content->wageocc->item[1]->entrywg AND $annual AND $annual2) : ?>   		
                               <strong>Typical Annual Salary: </strong><?php echo "$".number_format($annual,0,'.',','); ?> - <?php echo "$".number_format($annual2,0,'.',','); ?>
                               <br/><strong>Typical Hourly Wage: </strong><br/><?php echo "$".number_format(floatval($content->wageocc->item[0]->pct25),0,'.',','); ?> - <?php echo "$".number_format(floatval($content->wageocc->item[0]->pct75),0,'.',','); ?>
							   
						<?php else: ?>
                               <strong>Typical Annual Salary: </strong>Not available
                               <br/><strong>Typical Hourly Wage: </strong><br/>Not available
						<?php endif; ?>   
                </div>
                             


</div>

<?php endif; ?>

<script>

  var fromwhere = '<?php echo $_GET["tab"]; ?>';	
	
  if (fromwhere)
	changemain(fromwhere);
</script>


