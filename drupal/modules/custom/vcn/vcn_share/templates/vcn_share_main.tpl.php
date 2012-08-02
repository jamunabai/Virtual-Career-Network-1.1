<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
//Ganappa

//this function is to display the test score of the user
function vcn_cma_tests_view() {
global $user;
$flag = 0;
$i = 0;

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
$db=mysql_select_db('drupal',$connection)
or die("Error selecting database: ".mysql_error());

// Here, we are loading up the questions for the assessment
$get_userid = explode('-',$_GET['userid']);
//$query="select * from content_type_test_session ts, node n where field_student_uid = \"".$get_userid[0]."\" and n.nid = ts.nid";

$query="select * from content_type_test_session ts, node n where n.nid = ts.nid;";
$result=mysql_query($query)
or die("Error running query: ".mysql_error());

$checktestscores = mysql_fetch_assoc($result);
	if(!empty($checktestscores)){

	while ($file = mysql_fetch_assoc($result)) {
		

			if($file['field_pass_fail_value']=="p"){
				$pf="Pass";
			}else{
				$pf="Fail";
			}

			if($file['field_credits_value']){
				$c=$file['field_credits_value'];
			}else{
				$c="None";
			}
			
			if(!empty($file['field_test_score_value'])){
				$score = $file['field_test_score_value'];
			}else{
				$score = '0';
			}
			if($file['field_student_uid'] == $user->uid){
			
				if($i == 0){
					$o .= '<br />The following is a list of online courses taken through VCN.org:<br /><br />';
					$o .= '<div style="margin-left: 0px; margin-bottom: 3px;">'.'<b>Course Name</b>'.'</div>';
					$o .= '<div style="margin-left: 825px; margin-top: -20px;">'.'<b>Test Date</b>'.'</div>';
					$o .= '<div style="margin-left: 240px; margin-top: -15px;">'.'<b>Score</b>'.'</div>';
					//$o .= '<div style="margin-left: 340px; margin-top: -15px;">'.'<b>Passed</b>'.'</div>';
					$o .= '<div style="margin-left: 440px; margin-top: -15px;">'.'<b>Credits</b>'.'</div>';
					$o .= ' <hr class="clear-both">' . PHP_EOL;		
				}

				$i++;			
				$flag++;
				$testtitle = explode("/",$file['title']);
				$testtitlediv = '<div style="margin-left: 0px; margin-bottom: 3px;">'.$testtitle[0].'</div>';
				$datevalue = date("Y-m-d",$file['created']);
				$testdatediv = '<div style="margin-left: 825px; margin-top: -20px;">'.$datevalue.'</div>';
				$testscorediv = '<div style="margin-left: 240px; margin-top: -15px;">'.$score.'% '.$pf.'</div>';
				$passfaildiv = '<div style="margin-left: 340px; margin-top: -15px;">'.$pf.'</div>';
				$creditsdiv = '<div style="margin-left: 440px; margin-top: -15px;">'.$c.'</div>';			

				$o .= $testtitlediv; 
				$o .= $testscorediv; 
				//$o .= $passfaildiv;
				$o .= $creditsdiv;
				$o .= $testdatediv;
				$o .= "<br />";

				//$o .= ' <hr class="clear-both">' . PHP_EOL;		
			}
		}
	}
	if($flag == 0){
     	$o .='<br /><br />';
    	$o .='<div><b>The user do not have any Test Scores to share</b></div>';	 	
	} //end if if(empty($checktestscores))
	mysql_close($connection);

return $o; 
} 


//this function is to display the documents of the user
function vcn_cma_documents_view() {
$get_userid = explode('-',$_GET['userid']);
$vars['user_id']=$get_userid[0];
$valid['user_id']='valid';
$documentinfo = vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'cmauserdocument', 'list', $limit=false, $offset=false, $order='document_id', $direction='desc');

foreach ($documentinfo->cma as $document) {
	//$shareynarray = array();
	if($document->shareyn == 'y' || $document->shareyn == 'Y'){
		$shareynarray = $document->shareyn;
	}
}

	if (isset($shareynarray)) {
	
		$base_path = base_path();
		$o .= '<br />The following is a list of available documents:<br /><br />';
/* 		$o .= '<div style="margin-left: 0px; margin-bottom: 3px;">'.'<b>Document Title</b>'.'</div>';
		$o .= '<hr class="clear-both">' . PHP_EOL; */
         foreach ($documentinfo->cma as $document) {
			if($document->shareyn == 'y' || $document->shareyn == 'Y'){
				$imagepath = $base_path . drupal_get_path('module', 'vcn_cma') . '/images';
				if($document->documenttypeid == 2)    {$img = '<img style="margin-left: 1px; margin-top: 1px;" src="' . $imagepath.'/word.png'. '" title="Word Document" alt="Word Document" />';}
				elseif($document->documenttypeid == 3){$img = '<img style="margin-left: 1px; margin-top: 1px;" src="' . $imagepath.'/ppt.png'. '" title="PowerPoint Document" alt="PowerPoint Document" />';}
				elseif($document->documenttypeid == 4){$img = '<img style="margin-left: 1px; margin-top: 1px;" src="' . $imagepath.'/exel.png'. '" title="Excel Document" alt="Excel Document" />';}
				elseif($document->documenttypeid == 5){$img = '<img style="margin-left: 1px; margin-top: 1px;" src="' . $imagepath.'/img.png'. '" title="Image File" alt="Image File" />';}
				elseif($document->documenttypeid == 6){$img = '<img style="margin-left: 1px; margin-top: 1px;" src="' . $imagepath.'/txt.png'. '" title="Text File" alt="Text File" />';}
				elseif($document->documenttypeid == 7){$img = '<img style="margin-left: 1px; margin-top: 1px;" src="' . $imagepath.'/zip.png'. '" title="Zip File" alt="Zip File" />';} 
				elseif($document->documenttypeid == 8){$img = '<img style="margin-left: 1px; margin-top: 1px;" src="' . $imagepath.'/pdf.png'. '" title="PDF File" alt="PDF File" />';}
				else{$img = '<img style="margin-left: 1px; margin-top: 1px;" src="' . $imagepath.'/blank.png'. '" title="Other" alt="Other" />';}

				$onlydate = explode(' ', $document->documentuploaddate);
				$datediv = '<div style="margin-left: 747px; margin-top: -12px;">'.$onlydate[0].'</div>';
				$o .= '	<div id="documentid-' . $document->documentid . '" class="cma-documents">' . PHP_EOL;
				$o .= '		<div class="cma-documents-inner">' . PHP_EOL;
				$o .= '			<div class="cma-documents-body">' . PHP_EOL;

				$docidforcheck = $document->documentid;
				$docidforshareyn = "'".$document->shareyn."'";

				$o .= ' <a style="text-decoration: none; margin-top:1px;" href="/careerladder/getfile.php?docid='.$document->documentid.'"> '.$img.'&nbsp;&nbsp;'.$document->documenttitle.' </a>'.PHP_EOL; //with image 

				$o .= '			</div><!-- /cma-notebook-documents-body -->' . PHP_EOL;
				//$o .= ' <hr class="clear-both">' . PHP_EOL;
				$o .= '		</div><!-- /cma-notebook-certificate-inner -->' . PHP_EOL;
				$o .= '	</div><!-- /cma-notebook-program -->' . PHP_EOL;
			}
        }

		$datein = '<div style=\"margin-left: 746px; margin-top: -8px;\">'.date("Y-m-d").'</div>';
    }else{
     	$o .='<br /><br />';
    	$o .='<div><b>The user do not have any Documents to share</b></div>'; 
    }
    return $o;  
}

$vars['user_id']=$_GET['userid'];
$valid['user_id']='valid';
$shareinfo = vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'cmausershare', 'list', $limit=false, $offset=false, $order=false, $direction=false);	


$value = array();

foreach($shareinfo->cma as $share) {
	$value[] = (int)$share->sharetypeid;
}



// Here, we are loading up the questions for the assessment
$get_userid = explode('-',$_GET['userid']);

$query_user_name = "select * from hvcp.vcn_cma_user where USER_ID=$get_userid[0]";
$result_user_name = db_query($query_user_name);
$usernamecma =  db_fetch_array($result_user_name);

$get_userid = explode('-',$_GET['userid']);

if(empty($get_userid[2]) || !$_GET['userid']){
	echo "<h1 class=\"title\">Access Denied</h1>
    <p>Access Denied. You are not authorized to access this page.</p>";
}else{
	if(empty($usernamecma['FIRST_NAME']) && empty($usernamecma['LAST_NAME'])){
		echo "<h3 style=\"margin-top:-7px;\"> Portfolio </h3>";
 	}else{
		echo "<h3 style=\"margin-top:-7px;\"> Portfolio for ". $usernamecma['FIRST_NAME'] .' ' . $usernamecma['LAST_NAME']."</h3>";
	}
	if(in_array('2', $value)){
		echo vcn_cma_tests_view();
	}
	if(in_array('1', $value)){
		echo vcn_cma_documents_view();
	}
	
} 
?>