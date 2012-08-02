<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php  

$profile = profile_load_profile($user); 

$providerDetail = $data['providerdetails'];
$providerServices = $data['providerservices'];
$providerEntranceTests = $data['providerentrancetests'];
$providerReqCourses = $data['providerreqcourses'];
$providerDegrees = $data['providerdegrees'];
$providerFaid = $data['provideradditionalfaid'];

global $base_url;

if (isset($user->profile_provider_id) && strlen($user->profile_provider_id)>0 && $_SESSION['provider'] == 1) {
	if ($user->profile_provider_id === $providerDetail->unitid) {
		$whovar="p";
	}/* else {
		drupal_set_title(t('Access denied'));
		echo '<br /> You are not authorized to access this page. <br/> ';
		return false;
	}*/
}

$providerStatus = $providerDetail->status;

if ($whovar=="p" && $_GET["modify"]) {
	$body .= '<br/><strong>Submitted By User:</strong> '. $user->name . ' &#160;&#160; ' . $user->mail . ' &#160;&#160; (' . $user->uid . ')' . "\r\n";
	$body .= '<br/><strong>Profile Status:</strong> '.$_POST['statusvalue'].'<br/><br/>' . "\r\n";
	$body .= '<strong style="text-decoration:underline;">School Information:</strong><br/>' . "\r\n";
	$body .= '<strong>Provider Id: </strong> '.$providerDetail->unitid.'<br/>' . "\r\n";
	$body .= '<strong>School Name:</strong> '.$_POST['instnm'].'<br/>' . "\r\n";
	$body .= '<strong>Address:</strong> '.$_POST['addr'].'<br/>' . "\r\n";
	$body .= '<strong>City:</strong> '.$_POST['city'].'<br/>' . "\r\n";
	$body .= '<strong>State:</strong> '.$_POST['stabbr'].'<br/>' . "\r\n";
	$body .= '<strong>Zipcode:</strong> '.$_POST['zip'].'<br/>' . "\r\n";
	$body .= '<strong>Phone:</strong> '.$_POST['gentele'].'<br/>' . "\r\n";
	$body .= '<strong>School URL:</strong> '.$_POST['webaddr'].'<br/>' . "\r\n";
	$body .= '<strong>Application URL:</strong> '.$_POST['applurl'].'<br/>' . "\r\n";
	$body .= '<strong>Financial Aid URL:</strong> '.$_POST['faidurl'].'<br/><br/>' . "\r\n";
	$body .= '<strong>Mission Statement:</strong> '.$_POST['missionstatement'].'<br/><br/>' . "\r\n";
	$body .= '<strong>Mission Statement URL:</strong> '.$_POST['missionstatementurl'].'<br/><br/>' . "\r\n";
	
	$tests = '';
	for ($i=1; $i<=10; $i++) {
		if (strlen($_POST['teststatus'.$i]) && (strlen($_POST['testname'.$i]) || strlen($_POST['testdesc'.$i]) || strlen($_POST['testminscore'.$i]))) {
			$tests .= '<strong>Status '.$i.':</strong> '.$_POST['teststatus'.$i].'<br/>' . "\r\n";
			$tests .= '<strong>Test Name '.$i.':</strong> '.$_POST['testname'.$i].'<br/>' . "\r\n";
			$tests .= '<strong>Test Description '.$i.':</strong> '.$_POST['testdesc'.$i].'<br/>' . "\r\n";
			$tests .= '<strong>Test Minimum Score '.$i.':</strong> '.$_POST['testminscore'.$i].'<br/><br/>' . "\r\n";
		}
	}
	if (strlen($tests)) {
		$body .= '<br/><strong style="text-decoration:underline;">School Entrance Test Requirements:</strong><br/>' . "\r\n";
		$body .= $tests;
	}
	
	$courses = '';
	for ($i=1; $i<=10; $i++) {
		if (strlen($_POST['coursestatus'.$i]) && (strlen($_POST['coursename'.$i]) || strlen($_POST['coursedesc'.$i]) || strlen($_POST['courselevel'.$i]) || strlen($_POST['coursemingpa'.$i]) )) {
			$courses .= '<strong>Status '.$i.':</strong> '.$_POST['coursestatus'.$i].'<br/>' . "\r\n";
			$courses .= '<strong>Course Name '.$i.':</strong> '.$_POST['coursename'.$i].'<br/>' . "\r\n";
			$courses .= '<strong>Course Description '.$i.':</strong> '.$_POST['coursedesc'.$i].'<br/>' . "\r\n";
			$courses .= '<strong>Course Level '.$i.':</strong> '.$_POST['courselevel'.$i].'<br/>' . "\r\n";
			$courses .= '<strong>Course Minimum GPA '.$i.':</strong> '.$_POST['coursemingpa'.$i].'<br/><br/>' . "\r\n";
		}
	}	
	if (strlen($courses)) {
		$body .= '<br/><strong style="text-decoration:underline;">Prerequsite Courses for Admission to School:</strong><br/>' . "\r\n";
		$body .= $courses;
	}

	
	$params = array(
		'subject' => t('VCN Provider Changes'),
		'body' => t($body),
	  );

	//connect directly to db
	$conn = vcn_connect_to_db();

    // Here, we are loading up the questions for the assessment
    $query="SELECT   *
            FROM     vcn_app_properties
            WHERE    NAME = \"provider_portal_email\"";
    $result=mysql_query($query) or die("Error running query: ".mysql_error());
    $row=mysql_fetch_assoc($result);
     
	$email = $row['VALUE'];

	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$header .= "From: $user->mail \r\n";
	$header .= "Reply-To: $user->mail \r\n";
	
    if (strlen($email) > 0) {
		mail( $email, 'VCN Provider Changes', $body, $header );
		
		/**
		**Begin : Provider Registration and Updates to Profile/Program Should be Logged redmine : 6875
		**/
	
		$date = date_create();
		$datestamp = date_timestamp_get($date);
		
		$providerid = $user->profile_provider_id;
		$userid = $user->uid;
		
		$bodylog = $body;
		
		if($_SERVER['SERVER_NAME'] == "localhost"){
			$myFile = "../careerladder/AppLogs/"."provider-".$providerid."--user-".$userid."-school-".$datestamp.".txt";
		}else{
			$myFile = "/usr/local/zend/apache2/htdocs/careerladder/AppLogs/"."provider-".$providerid."--user-".$userid."-school-".$datestamp.".txt";
		}
		//$myFile = "http://hvcp2-dev-portal.hvcp.local/careerladder/AppLogs/provider_registration.txt";
		$fh = fopen($myFile, 'a'); // or die("can't open file");
		$stringData = $bodylog;
		fwrite($fh, $stringData);
		fclose($fh);
		
		/**
		**End : Provider Registration and Updates to Profile/Program Should be Logged redmine : 6875
		**/
	
    }
	//echo $body;
		
	drupal_set_message(t("The information has been sent to the VCN staff for review."));

	// update the provider status (UP=Update Pending, C=Confirmed, CP=Confirm Pending)
	$providerStatus = 'UP';
	if ($_POST['statusvalue'] == 'CONFIRMED') {
		$providerStatus = 'C';
	}
	$query = " UPDATE vcn_provider
			   SET status = '$providerStatus', updated_by = $user->uid, updated_time = Now()
		       WHERE unitid = $providerDetail->unitid ";
	mysql_query($query) or die("Error running query: ".mysql_error());
	
	vcn_disconnect_from_db($conn);
}

$currentUrl = "http://" . $_SERVER['SERVER_NAME'] . base_path() . "find-learning/detail/school/unitid/" . $providerDetail->unitid;
$facebookTitle = "VCN.org School: " . $providerDetail->instnm;

$facebookMetatags = new vcnFacebookMetatag($facebookTitle, $currentUrl, '');
drupal_set_html_head($facebookMetatags->getTags());
?>

<link href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/css/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />


<link href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/css/application.css" media="screen" rel="stylesheet" type="text/css" />

<style>
h4 { font-weight: bold; }
</style>

<form name="providerform" action="<?php echo base_path(); ?>find-learning/detail/school/unitid/<?php echo $providerDetail->unitid; ?>?modify=1" method="post">

<table width="100%" height="100%" cellspacing="0" class="reset prepend-top append-bottom">
                     <tbody><tr valign="top" height="100%" align="left">
                        <td class="content_pane">
                            <div class="prepend-1 append-1 span-46 last">
<?php if ($whovar=="p"): ?>
<h3>Provider Profile</h3>
<br>
Please review. If everything is correct then click Confirm. Otherwise, edit the as necessary and click Submit Changes.
<?php endif; ?>

<div class="box2 box_grey span-46 prepend-top">
  <div class="prepend-1 append-1 prepend-top append-bottom span-44">
    <div class="column span-8">
        <img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/missing_large.jpg" alt="Missing_large">
    </div>
    <div class="column span-36 last">
      <div class="column" style="width:100%;">
		<?php if ($whovar=="p"): ?>		
			<!--<input type="text" style="height:20px;" size="15" value="<?php echo $providerDetail->instnm; ?>" maxlength="20" id="instnm" name="instnm">-->
		<?php else: ?>	  
			<div style="width:100%;">
				<div style="float:left; width:85%;">
					<h2><?php echo $providerDetail->instnm; ?></h2>
				</div>
				<div style="float:left; text-align:right; vertical-align:middle; width:15%;">
					<?php
					$facebookLikeButton = new vcnFacebookLike($currentUrl);
					$facebookLikeButton->shiftTop = '5';
					$facebookLikeButton->shiftLeft = '0';
					echo $facebookLikeButton->getButton();
					?>
				</div>
				<div style="clear:left;"></div>
			</div>
		<?php endif; ?>
      </div>
      
      <hr class="divider">
       <h4>School Information</h4>
       <br/>
        <span>
		
		<?php if ($whovar=="p"): ?>	
			<span>
				<span style="float:left;">
				Name:<br/>
				<label><input type="text" style="height:20px;" size="25" value="<?php if ($_GET['modify']==1) echo $_POST['instnm']; else echo $providerDetail->instnm; ?>" maxlength="255" id="instnm" name="instnm"></label>
				</span>
				<span style="float:left; margin-left:10px;">
				Phone:<br/>
				<label><input type="text" style="height:20px;" size="18" value="<?php if ($_GET['modify']==1) echo $_POST['gentele']; else  echo vcn_format_phone($providerDetail->gentele); ?>" maxlength="15" id="gentele" name="gentele"></label>
				</span>
				<span style="float:left; margin-left: 173px;">
				Status: 
				<?php 
				// status (UP=Update Pending, C=Confirmed, CP=Confirm Pending)
				if ($providerStatus == 'UP') {
					$providerStatus = 'Update Pending';
				} else if ($providerStatus == 'C') {
					$providerStatus = 'Confirmed';
				} else if ($providerStatus == 'CP') {
					$providerStatus = 'Confirm Pending';
				}
				echo '<strong>' . $providerStatus . '</strong>'; 
				?>
				</span>
			</span>
			
			<br/><br/><br/>

			<span>
				<span style="float:left;">
				Street Address:<br/>
				<label><input type="text" style="height:20px;" size="25" value="<? if ($_GET['modify']==1) echo $_POST['addr']; else   echo $providerDetail->addr; ?>" maxlength="255" id="addr" name="addr"></label>	
				</span>
				<span style="float:left; margin-left:10px;">
				State:<br/>
				<label><input type="text" style="height:20px;" size="18" value="<?php if ($_GET['modify']==1) echo $_POST['stabbr']; else   echo $providerDetail->stabbr; ?>" maxlength="2" id="stabbr" name="stabbr"></label>		
				</span>
				<span style="float:left; margin-left: 173px; cursor: pointer;">
				<img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/confirm.png" alt="Submit" onclick="document.getElementById('statusvalue').value='CONFIRMED'; document.providerform.submit();" />				
				</span>			
			</span>			
			
			
			<br/><br/><br/>

			<span>
				<span style="float:left;">
				City:<br/>
				<label><input type="text" style="height:20px;" size="25" value="<?php if ($_GET['modify']==1) echo $_POST['city']; else   echo $providerDetail->city; ?>" maxlength="50" id="city" name="city"></label>	
				</span>
				<span style="float:left; margin-left:10px;">
				Zip:<br/>
				<label><input type="text" style="height:20px;" size="18" value="<?php if ($_GET['modify']==1) echo $_POST['zip']; else   echo $providerDetail->zip; ?>" maxlength="10" id="zip" name="zip"></label>
				</span>
				<span style="float:left; margin-left: 173px; cursor: pointer;">
				<img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/submit-changes.png" alt="Submit" onclick="document.getElementById('statusvalue').value='UPDATED';document.providerform.submit();" />				
				</span>				
			</span>						
			
			
			<br/><br/><br/>

			<span>
				<span style="float:left;">
				School URL:<br/>
				<label><input type="text" style="height:20px;" size="45" value="<?php if ($_GET['modify']==1) echo $_POST['webaddr']; else  echo $s.$providerDetail->webaddr; ?>" maxlength="300" id="webaddr" name="webaddr"></label>
				</span>
			</span>						
			
		<br/><br/><br/>
		
			<span>
				<span style="float:left;">
				Application URL:<br/>
				<label><input type="text" style="height:20px;" size="45" value="<?php  if ($_GET['modify']==1) echo $_POST['applurl']; else echo $s.$providerDetail->applurl; ?>" maxlength="300" id="applurl" name="applurl"></label>
				</span>
			</span>		

	<br/><br/><br/>
	
			<span>
				<span style="float:left;">
				Financial Aid URL:<br/>
				<label><input type="text" style="height:20px;" size="45" value="<?php if ($_GET['modify']==1) echo $_POST['faidurl']; else  echo $s.$providerDetail->faidurl; ?>" maxlength="300" id="faidurl" name="faidurl"></label>
				</span>
			</span>		
			
	<br/><br/><br/>
		
		Mission Statement:<br/>
		<label><input type="text" style="height:20px;" size="45" value="<?php if ($_GET['modify']==1) echo $_POST['missionstatement']; else  echo $providerDetail->missionstatement; ?>" maxlength="2000" id="missionstatement" name="missionstatement"></label>
	
		<br/><br/>
		
		Mission Statement URL:<br/>
		<label><input type="text" style="height:20px;" size="45" value="<?php if ($_GET['modify']==1) echo $_POST['missionstatementurl']; else  echo $providerDetail->missionstatementurl; ?>" maxlength="300" id="missionstatementurl" name="missionstatementurl"></label>
				
	<br/><br/><br/>
	
	<h4>School Entrance Test Requirements</h4>
	<br/>
		<?php 
		if ($whovar=="p"): 
		?>
		<table width="100%" id="satact">
		<tr>
			<td>Test Name</td>
			<td>Test Description</td>
			<td>Minimum Score</td>
		</tr>	
		<?php 
			$rowswithdata = 0;
			for ($i=1; $i<=10; $i++): 
				
				if ($_GET["modify"]):
					$testnameVal = $_POST['testname'.$i];
					$testdescVal = $_POST['testdesc'.$i];
					$testminscoreVal = $_POST['testminscore'.$i];
				else:
					$testnameVal = $providerEntranceTests[$i-1]->testname;
					$testdescVal = $providerEntranceTests[$i-1]->testdescription;
					$testminscoreVal = $providerEntranceTests[$i-1]->minscore;
				endif;
							
				if ($testnameVal || $testdescVal || $testminscoreVal  ):
		?>
					<tr id="testrow<?php echo $i; ?>">
						<td>
						<label><input type="hidden" id="teststatus<?php echo $i; ?>" name="teststatus<?php echo $i; ?>" value="UPDATED" /></label>
						<label><input type="text" size="20" value="<?php echo $testnameVal; ?>" id="testname<?php echo $i; ?>" name="testname<?php echo $i; ?>"></label>
						</td>
						<td>
						<label><input type="text" size="20" value="<?php echo $testdescVal; ?>" id="testdesc<?php echo $i; ?>" name="testdesc<?php echo $i; ?>"></label>
						</td>
						<td>
						<label><input type="text" size="20" value="<?php echo $testminscoreVal; ?>" id="testminscore<?php echo $i; ?>" name="testminscore<?php echo $i; ?>"></label>
						</td>
						<td>
						<img id="testimg<?php echo $i; ?>" onclick="DeleteRow('test', <?php echo $i; ?>, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
						</td>
					</tr>
		<?php 
					$rowswithdata++;
				endif; 
			endfor; 
			
			if ($rowswithdata === 0):
		?>
			<tr id="testrow1">
				<td>
				<label><input type="hidden" id="teststatus1" name="teststatus1" value="ADDED" /></label>
				<label><input type="text" size="20" value="" id="testname1" name="testname1"></label>
				</td>
				<td>
				<label><input type="text" size="20" value="" id="testdesc1" name="testdesc1"></label>
				</td>
				<td>
				<label><input type="text" size="20" value="" id="testminscore1" name="testminscore1"></label>
				</td>
				<td>
				<img id="testimg1" onclick="DeleteRow('test', 1, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
				</td>
			</tr>	
		<?php
			endif;
			if ($rowswithdata <= 1):
		?>
			<tr id="testrow2">
				<td>
				<label><input type="hidden" id="teststatus2" name="teststatus2" value="ADDED" /></label>
				<label><input type="text" size="20" value="" id="testname2" name="testname2"></label>
				</td>
				<td>
				<label><input type="text" size="20" value="" id="testdesc2" name="testdesc2"></label>
				</td>
				<td>
				<label><input type="text" size="20" value="" id="testminscore2" name="testminscore2"></label>
				</td>
				<td>
				<img id="testimg2" onclick="DeleteRow('test', 2, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
				</td>
			</tr>		
		<?php		
			endif;
		?>
		</table>		
		<?php endif; ?>
		
		<a href="javascript:void(0);" onclick="AddRow('test', 'satact');"><img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/add-new-entrance-test.png" alt="Add New Entrance Test" /></a>
	
<br/><br/><br/>
	
	<h4>Prerequisite Courses for Admission to School</h4>
	<br/>
		<?php 
		if ($whovar=="p"): 
		?>	
		<table width="100%" id="precourses">
		<tr>
			<td>Course Title</td>
			<td>Course Description</td>
			<td>Course Level</td>
			<td>Minimum GPA</td>
		</tr>
		<?php 
			$rowswithdata = 0;
			for ($i=1; $i<=10; $i++): 
				if ($_GET["modify"]):
					$coursenameVal = $_POST['coursename'.$i];
					$coursedescVal = $_POST['coursedesc'.$i];
					$courselevelVal = $_POST['courselevel'.$i];
					$coursemingpaVal = $_POST['coursemingpa'.$i];
				else:
					$coursenameVal = $providerReqCourses[$i-1]->coursetitle;
					$coursedescVal = $providerReqCourses[$i-1]->description;
					
					$level = '';
					if (strlen($providerReqCourses[$i-1]->courselevel)) {
						switch (strtoupper($providerReqCourses[$i-1]->courselevel)) {
							case 'C':
								$level = 'College';
								break;
							case 'H':
								$level = 'High School';
								break;
							case 'H or C':
								$level = 'High School or College';
								break;
							case 'B':
								$level = 'Bachelors';
								break;
						}
					}
					$courselevelVal = $level;
					$coursemingpaVal = $providerReqCourses[$i-1]->mingpa;
				endif;
				
				if ($coursenameVal || $coursedescVal || $courselevelVal || $coursemingpaVal ):
		?>
		<tr id="courserow<?php echo $i; ?>">
			<td>
			<label><input type="hidden" id="coursestatus<?php echo $i; ?>" name="coursestatus<?php echo $i; ?>" value="UPDATED" /></label>
			<label><input type="text" size="15" value="<?php echo $coursenameVal; ?>" id="coursename<?php echo $i; ?>" name="coursename<?php echo $i; ?>"></label>
			</td>
			<td>
			<label><input type="text" size="15" value="<?php echo $coursedescVal; ?>" id="coursedesc<?php echo $i; ?>" name="coursedesc<?php echo $i; ?>"></label>
			</td>
			<td>
			<label><input type="text" size="15" value="<?php echo $courselevelVal; ?>" id="courselevel<?php echo $i; ?>" name="courselevel<?php echo $i; ?>"></label>
			</td>
			<td>
			<label><input type="text" size="15" value="<?php echo $coursemingpaVal; ?>" id="coursemingpa<?php echo $i; ?>" name="coursemingpa<?php echo $i; ?>"></label>
			</td>			
			<td>
			<img id="courseimg<?php echo $i; ?>" onclick="DeleteRow('course', <?php echo $i; ?>, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
			</td>
		</tr>
		<?php 
					$rowswithdata++;
				endif;
			endfor; 
					
			if ($rowswithdata === 0):
			
		?>
			<tr id="courserow1">
				<td>
				<label><input type="hidden" id="coursestatus1" name="coursestatus1" value="ADDED" /></label>
				<label><input type="text" size="15" value="" id="coursename1" name="coursename1"></label>
				</td>
				<td>
				<label><input type="text" size="15" value="" id="coursedesc1" name="coursedesc1"></label>
				</td>
				<td>
				<label><input type="text" size="15" value="" id="courselevel1" name="courselevel1"></label>
				</td>
				<td>
				<label><input type="text" size="15" value="" id="coursemingpa1" name="coursemingpa1"></label>
				</td>				
				<td>
				<img id="courseimg1" onclick="DeleteRow('course', 1, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
				</td>
			</tr>	
		<?php
			endif;
			if ($rowswithdata <= 1):
		?>
			<tr id="courserow2">
				<td>
				<label><input type="hidden" id="coursestatus2" name="coursestatus2" value="ADDED" /></label>
				<label><input type="text" size="15" value="" id="coursename2" name="coursename2"></label>
				</td>
				<td>
				<label><input type="text" size="15" value="" id="coursedesc2" name="coursedesc2"></label>
				</td>
				<td>
				<label><input type="text" size="15" value="" id="courselevel2" name="courselevel2"></label>
				</td>
				<td>
				<label><input type="text" size="15" value="" id="coursemingpa2" name="coursemingpa2"></label>
				<label><input type="text" size="15" value="" id="coursemingpa2" name="coursemingpa2"></label>
				</td>				
				<td>
				<img id="courseimg2" onclick="DeleteRow('course', 2, true);" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />
				</td>
			</tr>		
		<?php		
			endif;
		?>
		</table>		
		<?php endif; ?>
		
		<a href="javascript:void(0);" onclick="AddRow('course', 'precourses');"><img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/add-new-prerequisite-courses.png" alt="Add New Pre-req Courses" /></a>
		
		<?php endif; ?>

		<?php if (strlen($providerDetail->missionstatement) && $whovar!="p"): ?>
		<br/><?php echo $providerDetail->missionstatement; ?>
		<?php endif; ?>
		

		<?php 
		   $s='http://';
		   if ( strstr($providerDetail->missionstatementurl, 'http') )
			$s='';			
		   if ( strstr($providerDetail->missionstatementurl, 'https') )
			$s='';
			
		   ?>		
		<?php if (strlen($providerDetail->missionstatementurl)>4 && $whovar!="p" && $providerDetail->missionstatementurlflag): ?>
		<a target="_blank" href="<?php echo $s.$providerDetail->missionstatementurl; ?>"><?php echo $providerDetail->instnm; ?> Mission Statement</a>
		<?php endif; ?>
		</span>
      <br><br>

      <div class="span-36 last">

      
	      <div class="right">
		   <?php if (strlen($providerDetail->applurl)>4 && $whovar!="p" && $providerDetail->applurlflag): ?>
		   <?php 
		   $s='http://';
		   if ( strstr($providerDetail->applurl, 'http') )
			$s='';			
		   if ( strstr($providerDetail->applurl, 'https') )
			$s='';
			
		   ?>
	        <a title="Apply Online" target="_blank" href="<?php echo $s.$providerDetail->applurl; ?>"><img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/apply_online_f2.png?1292296901" class="fadable" alt="Apply Online"></a>
			<?php endif; ?>
	      </div>
      </div>
    </div>
  </div>
</div>
<?php $w='N/A'; ?>

<?php if ($whovar!="p"): ?>
<div class="box2 span-46 prepend-top append-bottom">
    <div class="prepend-1 append-1 prepend-top append-bottom span-44">
        <div class="span-32">
            <div class="span-31 append-1">
                <div class="span-2">
                    <img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/s_profile_overview.png" alt="S_profile_overview">
                </div>
                <div class="span-28 last indent">
                    <h4 style="margin-top: 10px;">School Overview</h4>
                    <hr class="divider">
                    <div class="span-5 push_text_right"><strong>Type of School:</strong></div>
                      <div class="span-23 last"><span><?php $p=$providerDetail->ipedsdesc; if (!$p) echo $w; else echo $p; ?></span></div>
                      <div class="span-23 prepend-5 last">
                        <span>Percent applicants admitted:</span> <span><?php $p=intval($providerDetail->percentadmittedtotal); if ($p<1) echo $w; else echo number_format($p, 0, '.', ',')."%"; ?></span>
                      </div>
                       <!-- <div class="span-28 prepend-top">
                            <div class="span-5 push_text_right" style="text-align: right; margin-right:5px;"><span>Calendar:</span></div>
                            <div class="span-23 last"><span>Semester</span></div>
                        </div> -->
                      <div class="span-28 prepend-top">
                        <div class="column span-7 pull-2 push_text_right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Degrees Offered:</strong></div>
						<?php 
						$i = 0;
						foreach ($providerDegrees as $degree): 
							$class = '';
							if ($i > 0) {
								$class = 'prepend-5';
							}
						?>
							<div class="span-23 <?php echo $class; ?> last"><span><?php echo $degree; ?></span></div>						
						<?  
							$i++;
						endforeach; 
						?>
                      </div>
                    <div class="column span-28 prepend-top">
                        <div class="column span-5 push_text_right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	Size:</strong></div>
                        <div class="column span-23 last"><span>Total students:</span> <span><?php echo number_format(intval($providerDetail->totalenrollment), 0, '.', ','); ?></span></div>
                        <div class="column span-23 prepend-5 last"><span>Total undergrads:</span> <span><?php echo number_format(intval($providerDetail->undergraduateenrollment), 0, '.', ','); ?></span></div>
                        <div class="column span-23 prepend-5 last"><span>1st-time degree-seeking freshmen:</span> <span><?php echo number_format(intval($providerDetail->firsttimedegreecertificateundergradenrollment), 0, '.', ','); ?></span></div>
                        <div class="column span-23 prepend-5 last"><span>Graduate enrollment:</span> <span><?php echo number_format(intval($providerDetail->graduateenrollment), 0, '.', ','); ?></span></div>
                    </div>
                    <div class="column span-28 prepend-top last">
                        <div class="column span-7 pull-2 push_text_right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entrance Tests:</strong></div>
                        <?php 
                        if (count($providerEntranceTests) > 0) :
							$i = 0;
							foreach ($providerEntranceTests as $test): 
								$class = '';
								if ($i > 0) {
									$class = 'prepend-5';
								}
								if (strlen($test->minscore) && (strtoupper($test->minscore) == 'NONE' || strtoupper($test->minscore) == 'N/A' || strtoupper($test->minscore) == 'NA')) {
									$testminscore = '';
								} else {
									$testminscore = ': ' . $test->minscore;	
								}
							?>
								<div class="span-23 <?php echo $class; ?> last"><span><?php echo $test->testname . $testminscore; ?></span></div>						
							<?  
								$i++;
							endforeach; 
						else:
						?>
							<div class="span-23 last"><span>N/A</span></div>
						<?php
						endif;
						
						if (intval($providerDetail->satcriticalreading25thpercentilescore)>1 || intval($providerDetail->satcriticalreading75thpercentilescore)>1  ): ?>		
						<div class="column span-23 prepend-5"><span><br/></span></div>
						<div class="column span-23 prepend-5">
									<span style="margin-left:140px;"></span>
									<span>25th Percentile</span>
									<span style="margin-left:50px;"></span>
									<span>75th Percentile</span>
						</div>
						<?php endif; ?>
						<?php if (intval($providerDetail->satcriticalreading25thpercentilescore)>1 || intval($providerDetail->satcriticalreading75thpercentilescore)>1  ): ?>						
						<div class="column span-23 prepend-5">
							<span>SAT Critical Reading</span>
							<span style="margin-left:86px;"><?php $p=intval($providerDetail->satcriticalreading25thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>
							<span style="margin-left:110px;"><?php $p=intval($providerDetail->satcriticalreading75thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>
						</div>
						<?php endif; ?>
						<?php if (intval($providerDetail->satmath25thpercentilescore)>1 || intval($providerDetail->satmath75thpercentilescore)>1  ): ?>
						<div class="column span-23 prepend-5">
							<span>SAT Math</span>
							<span style="margin-left:148px;"><?php $p=intval($providerDetail->satmath25thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>
							<span style="margin-left:110px;"><?php $p=intval($providerDetail->satmath75thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>							
						</div>
						<?php endif; ?>
						<?php if (intval($providerDetail->satwriting25thpercentilescore)>1 || intval($providerDetail->satwriting75thpercentilescore)>1  ): ?>
						<div class="column span-23 prepend-5">
							<span>SAT Writing</span>
							<span style="margin-left:136px;"><?php $p=intval($providerDetail->satwriting25thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>
							<span style="margin-left:110px;"><?php $p=intval($providerDetail->satwriting75thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>							
						</div>	
						<?php endif; ?>
						<?php if (intval($providerDetail->actcomposite25thpercentilescore)>1 || intval($providerDetail->actcomposite75thpercentilescore)>1  ): ?>
						<div class="column span-23 prepend-5">
							<span>ACT Composite</span>
							<span style="margin-left:118px;"><?php $p=intval($providerDetail->actcomposite25thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>
							<span style="margin-left:118px;"><?php $p=intval($providerDetail->actcomposite75thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>							
						</div>	
						<?php endif; ?>
						<?php if (intval($providerDetail->actenglish25thpercentilescore)>1 || intval($providerDetail->actenglish75thpercentilescore)>1  ): ?>
						<div class="column span-23 prepend-5">
							<span>ACT English</span>
							<span style="margin-left:137px;"><?php $p=intval($providerDetail->actenglish25thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>
							<span style="margin-left:118px;"><?php $p=intval($providerDetail->actenglish75thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>							
						</div>	
						<?php endif; ?>
						<?php if (intval($providerDetail->actmath25thpercentilescore)>1 || intval($providerDetail->actmath75thpercentilescore)>1  ): ?>
						<div class="column span-23 prepend-5">
							<span>ACT Math</span>
							<span style="margin-left:153px;"><?php $p=intval($providerDetail->actmath25thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>
							<span style="margin-left:118px;"><?php $p=intval($providerDetail->actmath75thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>							
						</div>	
						<?php endif; ?>						
						<?php if (intval($providerDetail->actwriting25thpercentilescore)>1 || intval($providerDetail->actwriting75thpercentilescore)>1  ): ?>
						<div class="column span-23 prepend-5">
							<span>ACT Writing</span>
							<span style="margin-left:141px;"><?php $p=intval($providerDetail->actwriting25thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>
							<span style="margin-left:118px;"><?php $p=intval($providerDetail->actwriting75thpercentilescore); if ($p<1) echo $w; else echo $p; ?></span>							
						</div>	
						<?php endif; ?>
                    </div>	
					
                </div>
            </div>
            <div class="span-31 append-1 prepend-top">
                <div class="span-2">
                    <img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/s_profile_cost.png" alt="S_profile_cost">
                </div>
                <div class="span-28 last indent">
                    <h4 style="margin-top: 10px;">Costs + Fees</h4>
                    <hr class="divider">
					
                    <div class="span-19 prepend-9 last">
                        <div class="span-6"><h5>Living on-campus</h5></div>
                        <div class="span-6"  style="margin-left:-6px;"><h5>Living at home</h5></div>
                        <div class="span-6 last"  style="margin-left:-6px;"><h5>Commuting</h5></div>
                    </div>
                    <div class="span-9 push_text_right"><strong>In-state tuition:</strong></div>
                    <div class="span-19 last">
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->priceinstateoncampus); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->priceinstateoffcampusfamily); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent"><span><?php $p=intval($providerDetail->priceinstateoffcampusnofamily); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                    </div>
                    <div class="span-9 push_text_right"><strong>Out-of-state tuition:</strong></div>
                    <div class="span-19 last">
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->priceoutofstateoncampus); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->priceoutofstateoffcampusfamily); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent"><span><?php $p=intval($providerDetail->priceoutofstateoffcampusnofamily); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                    </div>
                    <div class="span-9 push_text_right"><strong>Room and board:</strong></div>
                    <div class="span-19 last">
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->combinedchargeroomboard); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->combinedchargeroomboard); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent"><span><?php $p=intval($providerDetail->combinedchargeroomboard); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                    </div>
                    <div class="span-9 push_text_right"><strong>Books and supplies:</strong></div>
                    <div class="span-19 last">
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->booksandsupplies); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->booksandsupplies); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent"><span><?php $p=intval($providerDetail->booksandsupplies); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                    </div>
                   <!-- <div class="span-9 push_text_right"><span>Estimated personal expenses:</span></div>
                    <div class="span-19 last">
                        <div class="span-6 indent last"><span>$3,575</span></div>
                        <div class="span-6 indent last"><span>$3,575</span></div>
                        <div class="span-6 indent"><span>$3,575</span></div>
                    </div> -->
                    <div class="span-18 prepend-12 prepend-top last">
                        <div class="span-6"><h5>Undergraduates</h5></div>
                        <div class="span-6 last"  style="margin-left:-6px;"><h5>Graduates</h5></div>
                    </div>
                    <div class="span-12 push_text_right"><strong>Cost per credit hour (state):</strong></div>
                    <div class="span-16 last">
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->instatecreditchargeparttimeundergrad); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent"><span><?php $p=intval($providerDetail->instatecreditchargeparttimegrad); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                    </div>
                    <div class="span-12 push_text_right"><strong>Cost per credit hour (out-of-state):</strong></div>
                    <div class="span-16 last">
                        <div class="span-6 indent last"><span><?php $p=intval($providerDetail->outofstatecreditchargeparttimeundergrad); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                        <div class="span-6 indent"><span><?php $p=intval($providerDetail->outofstatecreditchargeparttimegrad); if ($p<1) echo $w; else echo "$".number_format($p, 0, '.', ','); ?></span></div>
                    </div>
                </div>
            </div>
            <div class="span-31 append-1 prepend-top">
                <div class="span-2">
                    <a name="mission"></a>
                    <img width="40px" height="40px" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/s_profile_description.png" alt="S_profile_description">
                </div>
                <div class="span-28 last indent">
                    <h4 style="margin-top: 10px;">Description and Mission Statement</h4>
                    <hr class="divider">
					<span>
					<?php echo $providerDetail->missionstatement; ?><br/>
					<?php 
					   $s='http://';
					   if ( strstr($providerDetail->missionstatementurl, 'http') )
						$s='';			
					   if ( strstr($providerDetail->missionstatementurl, 'https') )
						$s='';
					   ?>
					<?php if (strlen($providerDetail->missionstatementurl)>4 && $providerDetail->missionstatementurlflag): ?>
					<a target="_blank" href="<?php echo $s.$providerDetail->missionstatementurl; ?>"><?php echo $providerDetail->instnm; ?> Mission Statement</a>
					<?php endif; ?>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					</span>
                </div>
            </div>
        </div>

        <div class="span-11 last">
					<?php if (strlen($providerDetail->faidurl)>4 && $providerDetail->faidurlflag): ?>
  				    <div style="position: relative; height:108px;" class="column span-11 welcome_learn_more welcome_rounded_border">
					<?php else: ?>
					 <div style="position: relative; height:78px;" class="column span-11 welcome_learn_more welcome_rounded_border">
					<?php endif; ?>
  					      <div class="column">
  						        <img style="vertical-align: bottom;" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/ic_financial_aid.png" alt="Ic_financial_aid">
  					      </div>
						  
  					      <div style="width: 165px; position: absolute; right: 0; top: 5px;" class="column right">
  						        <h4 class="welcome_content_title push_text_right">&nbsp;&nbsp;Learn About Financial<br/>&nbsp;&nbsp;&nbsp; Aid Opportunities</h4>
  					      </div>
  					      <div style="width: 150px; position: absolute; right: 0; bottom: 5px;" class="column right welcome_content_title push_text_right">
						  	  <?php 
							   $s='http://';
							   if ( strstr($providerDetail->faidurl, 'http') )
								$s='';			
							   if ( strstr($providerDetail->faidurl, 'https') )
								$s='';
								
							   ?>	
							<div style="margin-top:-20px; <?php 
								if (strlen($providerFaid[0]->v2__loan_id) && !strlen($providerFaid[1]->v2__loan_id)) echo 'margin-bottom:-34px;'; 
								else if (strlen($providerDetail->faidurl)>4 && $providerDetail->faidurlflag && strlen($providerFaid[0]->v2__loan_id) && strlen($providerFaid[1]->v2__loan_id)) echo 'margin-bottom:-90px;';
								else if (strlen($providerFaid[0]->v2__loan_id) && strlen($providerFaid[1]->v2__loan_id)) echo 'margin-bottom:-61px;';
								?>">	
								<?php if (strlen($providerDetail->faidurl)>4 && $providerDetail->faidurlflag): ?>									
									<a target="_blank" href="<?php echo $s.$providerDetail->faidurl; ?>">Financial Aid (For this school)</a>
									<br/>
								<?php endif; ?>	
									<a target="_blank" href="<?php echo base_path(); ?>find-learning/financialaid">Financial Aid (General)</a>
									<br/>
									
								<?php  if (strlen($providerFaid[0]->v2__loan_id)): ?>
								<a target="_blank" href="<?php echo $providerFaid[0]->v3__loan_url; ?>"><?php echo $providerFaid[0]->v3__loan_name; ?></a>
								<?php endif; ?>		

								<?php  if (strlen($providerFaid[1]->v2__loan_id)): ?>
								<br/>
								<a target="_blank" href="<?php echo $providerFaid[1]->v3__loan_url; ?>"><?php echo $providerFaid[1]->v3__loan_name; ?></a>
								<?php endif; ?>									
							</div>
						  
  				    </div>
				
            <div class="box2 box_grey span-11 last" style="<?php 
			
			if (strlen($providerFaid[0]->v2__loan_id)) {
				echo 'margin-top:130px;'; 
			} else {			
				if (strlen($providerDetail->faidurl)>4 && $providerDetail->faidurlflag) 
					echo 'margin-top:55px;'; 
				else
					echo 'margin-top:15px;'; 
				
			}
			
			?>">
                <div class="column statistics" style="margin: 10px">
	                <div class="column">
	                    <img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/s_profile_admissions.png" class="middle" alt="S_profile_admissions">
	                </div>
	                <div class="column last">
	                    <h4 style="margin-top: 5px;">School Information</h4>
	                </div>
	                <hr class="divider">
	                    <div style="margin-top: 10px;" class="span-10 last">
	                        <h6>School Address:</h6>
	                            <?php if ($providerDetail->addr!='null'&& $providerDetail->addr!='NULL'): ?> 
								
									<?php if ($whovar=="p"): ?>		
										<span><input type="text" style="height:20px;" size="20" value="<? echo $providerDetail->addr; ?>" maxlength="20" id="addr" name="addr"></span>										
									<?php else: ?>	  
										<span><? echo $providerDetail->addr; ?></span>
									<?php endif; ?>								
									
								
								
								<br>
								
								<? endif; ?>
								
									<?php if ($whovar=="p"): ?>		
										<span>
										<input type="text" style="height:20px;" size="20" value="<?php echo $providerDetail->city; ?>" maxlength="20" id="city" name="city">
										<input type="text" style="height:20px;" size="20" value="<?php echo $providerDetail->stabbr; ?>" maxlength="20" id="stabbr" name="stabbr">
										<input type="text" style="height:20px;" size="20" value="<?php echo $providerDetail->zip; ?>" maxlength="20" id="zip" name="zip">
										</span>										
									<?php else: ?>	  
										 <span><?php echo $providerDetail->city; ?>, <?php echo $providerDetail->stabbr; ?> <?php echo $providerDetail->zip; ?></span>
									<?php endif; ?>	
									
	                       
	                    </div>
                      <div class="span-10 prepend-top last">
                          <h6>School Phone:</h6>
									<?php if ($whovar=="p"): ?>		
										<span><input type="text" style="height:20px;" size="20" value="<?php echo vcn_format_phone($providerDetail->gentele); ?>" maxlength="20" id="gentele" name="gentele"></span>										
									<?php else: ?>	  
										<span><?php echo vcn_format_phone($providerDetail->gentele); ?></span>
									<?php endif; ?>							  
                          
                      </div>
	                    <div class="span-10 prepend-top last">
						 <?php if ($providerDetail->webaddr && $providerDetail->webaddr!="NULL" && $providerDetail->webaddr!="null" && $providerDetail->webaddrflag): ?>
	                        <h6>School Website:</h6>
	                        <div class="span-10 last">
							   <?php 
							   $s='http://';
							   if ( strstr($providerDetail->webaddr, 'http') )
								$s='';			
							   if ( strstr($providerDetail->webaddr, 'https') )
								$s='';
								
							   ?>							
							
							
									<?php if ($whovar=="p"): ?>		
										<span><input type="text" style="height:20px;" size="40" value="<?php echo $s.$providerDetail->webaddr; ?>" maxlength="40" id="webaddr" name="webaddr"></span>										
									<?php else: ?>	  
										<a target="_blank" href="<?php echo $s.$providerDetail->webaddr; ?>"><?php echo $s.$providerDetail->webaddr; ?></a>
									<?php endif; ?>	
									
  	                        
							
  	                      </div>
						  <?php endif; ?>
  	                      <div class="span-10 last">
						    <?php if ($providerDetail->applurl && $providerDetail->applurl!="NULL" && $providerDetail->applurl!="null" && $providerDetail->applurlflag): ?>
							   <?php 
							   $s='http://';
							   if ( strstr($providerDetail->applurl, 'http') )
								$s='';			
							   if ( strstr($providerDetail->applurl, 'https') )
								$s='';
								
							   ?>							
  	                        <a target="_blank" href="<?php echo $s.$providerDetail->applurl; ?>">Online Application</a>
							<?php endif; ?>
  	                      </div>
	                    </div>

	                <div style="margin-top: 10px;" class="span-10">
	                    <div class="column">
	                        <img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/s_profile_demographics.png" class="middle" alt="S_profile_demographics">
	                    </div>
	                    <div class="column last">
	                        <h4 style="margin-top: 5px;">Student Demographics</h4>
	                    </div>
	                </div>
	                <hr class="divider">
	                <div class="span-10 last">
	                  <div class="column"><h6 class="inline">Women:</h6></div>
	                  <div class="right"><span><?php echo $providerDetail->percentwomen; ?>%</span></div>
	                </div>
	                <div class="span-10 last">
	                  <div class="column"><h6 class="inline">Men:</h6></div>
	                  <div class="right"><span><?php echo (100-$providerDetail->percentwomen); ?>%</span></div>
	                </div>
	                <div class="span-10 prepend-top last">
	                  <div class="column"><h6 class="inline">American Indian/Alaskan:</h6></div>
	                  <div class="right"><span><?php $p=$providerDetail->percentamericanindianoralaskanative; if ($p<1) $p="<1"; echo $p; ?>%</span></div>
	                </div>
	                <div class="span-10 last">
	                  <div class="column"><h6 class="inline">Asian/Pacific Islander:</h6></div>
	                  <div class="right"><span><?php $p=$providerDetail->percentasiannativehawaiianpacificislander; if ($p<1) $p="<1"; echo $p; ?>%</span></div>
	                </div>
	                <div class="span-10 last">
	                  <div class="column"><h6 class="inline">Black/Non-Hispanic:</h6></div>
	                  <div class="right"><span><?php $p=$providerDetail->percentblackorafricanamerican; if ($p<1) $p="<1"; echo $p; ?>%</span></div>
	                </div>
	                <div class="span-10 last">
	                  <div class="column"><h6 class="inline">Hispanic:</h6></div>
	                  <div class="right"><span><?php $p=$providerDetail->percenthispaniclatino; if ($p<1) $p="<1"; echo $p; ?>%</span></div>
	                </div>
	                <div class="span-10 last">
	                  <div class="column"><h6 class="inline">White/Non-Hispanic:</h6></div>
	                  <div class="right"><span><?php $p=$providerDetail->percentwhite; if ($p<1) $p="<1"; echo $p; ?>%</span></div>
	                </div>
	                <div class="span-10 last">
	                  <div class="column"><h6 class="inline">Non-Resident Alien:</h6></div>
	                  <div class="right"><span><?php $p=$providerDetail->percentnonresidentalien; if ($p<1) $p="<1"; echo $p; ?>%</span></div>
	                </div>
	                <div class="span-10 last">
	                  <div class="column"><h6 class="inline">Race/Ethnicity unreported:</h6></div>
	                  <div class="right"><span><?php $p=$providerDetail->percentraceethnicityunknown; if ($p<1) $p="<1"; echo $p; ?>%</span></div>
	                </div>
	            </div>
            </div>
            <div class="box2 box_grey span-11 last prepend-top">
                <div class="column statistics" style="margin: 10px">
                    <div class="column">
                        <img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/training/images/ic_services.png" class="middle" alt="Ic_services">
                    </div>
                    <div class="column last">
                        <h4 style="margin-top: 5px;">School Services</h4>
                    </div>
                    <hr class="divider">
						<?php foreach ($providerServices as $servicename): ?>
								<div class="span-10 last"><div class="column"><span><?php echo $servicename; ?></span></div>
						<?php endforeach; ?>
						
						<?php if ($whovar=="p"): ?>	
						<br/><br/>
						<input type="submit" value="Submit" id="schoolsubmit" name="schoolsubmit">
						<?php endif; ?>

                </div>
        </div>
    </div>
</div>

                            </div>
                        </div></div></div></div></div></div></div></div></div><?php endif; ?></div></div></div></div></td>
                    </tr>
                </tbody></table>
			
<input type="hidden" value="" id="statusvalue" name="statusvalue" />			
</form>				
<!-- http://localhost/drupal/find-learning/results/programs/unitid/104151 -->		

<?php
/*
$to = "andrew.kurtser@xpandcorp.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "someonelse@example.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
*/
?> 		