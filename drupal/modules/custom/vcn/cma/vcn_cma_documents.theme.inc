<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

// $Id: vcn_cma_doc.theme.inc,v 0.1 2011/01/09 10:07:00 Exp $
drupal_add_js(drupal_get_path('module', 'vcn_cma') . '/js/vcn_cma_nb_documents.js');


//include("header.php");
function theme_vcn_cma_documents_view($cma) {


$vars['unitid']=$cma->userid;
$valid['unitid']='valid';
$documentinfo = vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'cmauserdocument', 'list', $limit=false, $offset=false, $order='document_id', $direction='desc');

/* echo"Begin Ganappa <pre>";
print_r($documentinfo);
echo"Ganappa end </pre>"; */

	if (isset($documentinfo)) {
	
		if(isset($_POST['upload']) && $_GET['thefile']==1){

		// get data directly from DB instead of rest services
		$includes = drupal_get_path('module','vcn').'/includes';
		require_once($includes . '/vcn_common.inc');
		$conn = vcn_connect_to_db();

				// define the posted file into variables
				$name = $_FILES['file']['name'];
				$tmp_name = $_FILES['file']['tmp_name'];
				$type = $_FILES['file']['type'];
				$size = $_FILES['file']['size'];
				$cmauserid = $_POST['cmauserid'];
				$mysqldate = date("m.d.y");				
				if(strpos($name,"doc") !== false){$doctype = '2';}
				elseif(strpos($name,"ppt") !== false){$doctype = '3';}
				elseif(strpos($name,"xls") !== false){$doctype = '4';}
				elseif(strpos($name,"jpeg") !== false){$doctype = '5';}
				elseif(strpos($name,"jpg") !== false){$doctype = '5';}
				elseif(strpos($name,"png") !== false){$doctype = '5';}
				elseif(strpos($name,"txt") !== false){$doctype = '6';}
				elseif(strpos($name,"zip") !== false){$doctype = '7';}
				elseif(strpos($name,"pdf") !== false){$doctype = '8';}
				else{$doctype = '1';}

				if ($size > '0' && $size<'1060000' && ($doctype>=2 && $doctype<=8)) {

					// open up the file and extract the data/content from it
					$extract = fopen($tmp_name, 'r');
					$content = fread($extract, filesize($tmp_name));
					//$content = str_replace("'","XpandGanappaReston2012",$content);
					$content = base64_encode($content);
					//$content = addslashes($content);
					//$content = mysql_real_escape_string($content);
					fclose($extract);  
					
					/* if(!get_magic_quotes_gpc()){
					$name = addslashes($name);
					} */
					
					// connect to the database
					//include "connect.php";

					// the query that will add this to the database
					$addfile = "INSERT INTO vcn_cma_user_document (DOCUMENT_TITLE, DOCUMENT_TYPE_ID, DOCUMENT_UPLOAD_DATE, DOCUMENT_OBJECT, USER_ID ) ".
							   "VALUES ('$name', $doctype, NOW(), '$content','$cmauserid')";

					mysql_query($addfile) or die(mysql_error());

					mysql_close();  
					 
					 
					//print_r($_FILES);exit;
					// we still have to close the original IF statement. If there was nothing posted, kill the page.
				}
				else{
					if($size <= 0){
						$docfilesize="lessthanzero";
					}elseif($doctype < 2 || $doctype > 8){
						$docfiletype="notpresent";
					}
					else{
						$docfilesize="0";
						$docfiletype="0";
					}
				}	
				
			}

		
		$base_path = base_path();
		$target_remove_button = $base_path . drupal_get_path('module', 'vcn_cma') . '/images/delete.png';
		
		//$o .= '<form action="https://localhost/careerladder/upload.php" method="post" enctype="multipart/form-data" name="uploadform">';
		$o .= '<h4>CMA Document Section </h4>';
		$o .= '<div id="errormessages"> </div>';
		$o .= '<br />';
		$o .= '<div id="formdivmessage">  </div>';
		$o .= '<div id="formdiv">';
		//$o .= '<form action="https://localhost/healthcare/cma/documents/list?thefile=1" method="post" enctype="multipart/form-data" name="uploadform">';
		$o .= '<form action="'.$base_path.'cma/documents/list?thefile=1" method="post" enctype="multipart/form-data" name="uploadform">';
		$o .= '<label><input type="hidden" name="MAX_FILE_SIZE" value="1060000" /></label>';
		$o .= '<input name="file" id="file" type="file" id="file" size="50" onchange="javascript:this.form[\'upload\'].disabled=false;" />';
		$o .= "<input type=\"hidden\" name=\"cmauserid\" value=\"$cma->userid\" />";
		$o .= '<input name="upload" type="submit" class="submitbutton" id="upload" value="Upload File!" disabled />';
		$o .= '</form>';	
		$o .= '<div style="margin-left: 855px;"><text><b>Share &nbsp;&nbsp; Delete</b></text></div></div><!-- /formdiv -->';
        		

		//$(".formdiv").append("<p>Test</p>");
		//$o .='<script language="JavaScript" type="text/javascript">alert("Ganappppa");</script>'. PHP_EOL;
/* 		$o .= '<hr class="clear-both">' . PHP_EOL;
		
		$o .= '<div style="margin-bottom: 45px; margin-top: -3px;"> <div style="float:left; margin-left:35px;"><h4>Title</h4></div> <div style="float:right; margin-right:160px;"><h4>Date</h4></div> </div>'; */
		
		$o .= '<hr class="clear-both">' . PHP_EOL;
         foreach ($documentinfo->cma as $document) {
		 
/*  		echo"Ganappa<pre>";
		print_r($document); */  
		 
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
			
			$o .= ' <a style="text-decoration: none; margin-top:1px;" href="/careerladder/getfile.php?docid='.$document->documentid.'"> '.$img.'&nbsp;&nbsp;'.$document->documenttitle.' </a>'.$datediv.' ' . PHP_EOL; //with image 
			//$o .= ' <a href="/careerladder/getfile.php?docid='.$document->documentid.'"> '.$document->documenttitle.' </a>'.$datediv.' ' . PHP_EOL; 
			
			$o .= '<div style="margin-left: 868px; margin-top: -17px;">';
			if($document->shareyn == "y" || $document->shareyn == "Y" ){
			$checked = 'checked="checked" ';
			$o .= '<input type="checkbox" title="Share Document" alt="Share Document" name="share_yn" id="share_yn" '.$checked.' onclick="shareyntoggle('.$docidforcheck.','.$docidforshareyn.');" />';
			}else{
			$checked = '';
			$o .= '<input type="checkbox" title="Share Document" alt="Share Document" name="share_yn" id="share_yn" '.$checked.' onclick="shareyntoggle('.$docidforcheck.','.$docidforshareyn.');" />';
			}			
			$o .= '</div>';
			
			
			
			
			
            $o .= ' <a class="document-remove-button remove-button" docid = "'.$document->documentid.'" href="' . $base_path . 'cma/remove/documents/' . $document->documentid;
            $o .= '"><img src="' . $target_remove_button . '" title="Remove" alt="Remove" /></a>' . PHP_EOL;
		  
            $o .= '			</div><!-- /cma-notebook-documents-body -->' . PHP_EOL;
            $o .= ' <hr class="clear-both">' . PHP_EOL;
            $o .= '		</div><!-- /cma-notebook-certificate-inner -->' . PHP_EOL;
            $o .= '	</div><!-- /cma-notebook-program -->' . PHP_EOL;
			
        }
		//print_r($documentinfo->cma[0]);
		//print_r($mysqldate);
		//$datein = '<div style="margin-right:-400px; margin-top:20px;">'.date("Y-m-d").'</div>';
		$datein = '<div style=\"margin-left: 746px; margin-top: -8px;\">'.date("Y-m-d").'</div>';
		//echo $datedivajax; 
		if(isset($_POST['upload']) && $size > '0' &&  $size<'1060000' && (strpos($name,"pdf") !== false || strpos($name,"doc") !== false || strpos($name,"ppt") !== false || strpos($name,"xls") !== false || strpos($name,"jpeg") !== false || strpos($name,"jpg") !== false || strpos($name,"png") !== false || strpos($name,"txt") !== false || strpos($name,"zip") !== false)){
			$o .='<script language="JavaScript" type="text/javascript"> $("#formdivmessage").append("<h4>File Uploaded</h4>"); </script>';
			$o .='<script language="JavaScript" type="text/javascript"> $("#formdiv").append("<hr class=\"clear-both\">'.$name.$datein.'"); </script>';
		}
		elseif(isset($_POST['upload']) && ($size>'1060000' || $docfilesize == "lessthanzero" )){
			$o .='<script language="JavaScript" type="text/javascript"> $("#formdivmessage").append("<h4>File size should be less than 1MB</h4>"); </script>';
		}
		elseif(isset($_POST['upload']) && ($doctype < 2 || $doctype > 8)){
			$o .='<script language="JavaScript" type="text/javascript"> $("#formdivmessage").append("<h4>File Type not allowed</h4>"); </script>';
		}
    }else{
    	$o .='<br /><br />';
    	$o .='<div><b>You have not saved any Documents</b></div>';
    }

    return $o;

  
  
} 


function theme_vcn_cma_documents_delete($form) {
    return drupal_render($form);
}
