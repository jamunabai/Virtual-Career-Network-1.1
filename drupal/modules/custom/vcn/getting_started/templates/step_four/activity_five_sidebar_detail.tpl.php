<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<div class="vcn-gs-heading">Course Information</div>
 
<?php 
global $user;
if ($data['courses']): 
?>
	<div class="courses-detail" id="courses_detail_0" style="margin-left:10px; margin-right:10px; text-align:justify">Click on the refresher course title to take the course</div>
	<?php 
			$count = 0;
			foreach ($data['courses'] AS $row ) 
			{
				if ($row->course_type == 1) continue;
				echo '<div class="courses-detail off" id="courses_detail_' . ++$count . '" style="margin-left:10px; margin-right:10px; text-align:left">';
		 		echo '	<span class="training-title"><strong>' . $row->coursetitle . '</strong></span><br />';
		 		if ((string) $row->description !== NULL AND trim((string) $row->description !==''))
		 			echo '  <p>' . $row->description . '</p>';
 		 		 	 		 		
		   		echo '<span class="detail-school">';
			    if ((string)$row->provider->webaddr !== 'NULL' AND trim((string)$row->provider->webaddr) !== '') 
			  	{
			    	$webaddr = substr_compare( 'http',(string)$row->provider->webaddr,0,4,true) ? 'http://'. (string)$row->provider->webaddr : (string)$row->provider->webaddr;
			      	echo '<a target="_blank" href="'.$webaddr.'">'.$row->provider->instnm.'</a>';
			 	}
			  	else 
			 	{
			   		echo $row->provider->instnm;
				}
				echo '</span><br /> ';
			 	if ((string)$row->provider->addr !== 'NULL'  AND trim((string)$row->provider->addr) !== '' )  
			 		echo $row->provider->addr.'<br />'; 
			   	if ((string)$row->provider->city !== 'NULL'  AND trim((string)$row->provider->city) !== '' ) 
			 		echo $row->provider->city; 
		
			   	if ((string)$row->stabbr !== 'NULL' ) 
			   	{
			     	if ((string)$row->provider->city !== 'NULL' AND trim((string)$row->provider->city) !== '' )  
			 		echo ', '; 
			 		echo $row->provider->stabbr; 
			    }
	    
			    if ((string)$row->provider->zip !== 'NULL' AND trim((string)$row->provider->zip) !== '' )  
			 		echo ' '. $row->provider->zip;
			 		
				echo '<br />';
				if ((string)$row->provider->gentele !== 'NULL' AND trim((string)$row->provider->gentele) !== '' ) 
	 			echo  ' '. vcn_format_phone( $row->provider->gentele ).'<br />';
	            	 
	           	 echo '<p><strong>Accredited By:</strong><br />';
	           	 if (!(array)$rowaccreditor) 
	           	 {
	           	 	echo "No accreditation information available.";
	           	 }
	           	 else 
	           	 {
			         foreach ($rowaccreditor->item as $accreditor)
			         {
		 
			         	if ((string)$accreditor->accreditor->websiteurl !== 'NULL' AND trim((string)$accreditor->accreditor->websiteurl) != '')
			           	 {
			           	 	$appurl = substr_compare( 'http',(string)$accreditor->accreditor->websiteurl,0,4,true) ? 'http://'. (string)$accreditor->accreditor->websiteurl : $accreditor->accreditor->websiteurl;
			           		echo '<a class="small" target="_blank" href="'.$appurl.'">' . $accreditor->accreditor->name . '</a><br />';
			           	 }	
					 	 else 
					 	 {
					 		echo $accreditor->accreditor->name;
					 	 } 
					 	
					 	 echo '</p>';
		      	 	}
	           	 }
	
		      	 if ((string)$row->totalcredits !== 'NULL' AND trim((string)$row->totalcredits) !== '') {
			      	 echo '<p><strong>Total Credits:</strong> ';
		       		 echo $row->totalcredits .'</p>';
		      	 }  
		      	 if ((string)$row->subject->description !== 'NULL' AND trim((string)$row->subject->description) !== '') {
			      	 echo '<p><strong>Subject Area:</strong> ';
		       		 echo $row->subject->description .'</p>';
		      	 }  
		    	 if ((string)$row->language->name !== 'NULL' AND trim((string)$row->language->name) !== '') {
			      	 echo '<p><strong>Language Name:</strong> ';
		       		 echo $row->language->name .'</p>';
		      	 }  	
		      	 if ((string)$type->description !== 'NULL' AND trim((string)$type->description) !== '') {
			      	 echo '<p><strong>Course Type:</strong> ';
		       		 echo $type->description .'</p>';
		      	 }  
		      	 if ((array)$row->accessibility !== 'NULL' AND trim((array)$row->accessibility !== '') )
		      	 {
			      	 echo '<p><strong>Accessibility:</strong> ';
			      	 foreach ($row->accessibility->item as $access)
			      	 {
		       		 	echo $access->access->description . '<br />';
			      	 }
		       		 echo '</p>';
		      	 }  		
	
		      	 if ((string)$rowdeliverymode->description !== 'NULL' AND trim((string)$rowdeliverymode->description !== 'NULL')  ) {
			      	 echo '<p><strong>Delivery:</strong> ';
		       		 echo  $rowdeliverymode->description .'</p>';
		      	 }  	 
		      	 if ((string)$row->othercost !== 'NULL' AND trim((string)$row->othercost) !== '') {
			      	 echo '<p><strong>Other Cost:</strong> ';
		       		 echo '$'.$row->othercost .'</p>';
		      	 }  
		      	 
		      	 
	           	echo '<h3>More Information</h3>';
				if ((string)$rowinfourl !== 'NULL' AND trim((string)$rowinfourl) !== '')  
				{ 
					$rowurl = substr_compare( 'http',(string)$rowinfourl,0,4,true) ? 'http://'. (string)$rowinfourl : (string)$rowinfourl;
				   	echo '<a class="small" target="_blank" href="'.$rowurl.'">More Info</a> <br />';
				}
	          	if ((string)$row->provider->applurl !== 'NULL' AND trim((string)$row->provider->applurl) != '')
	           	{
	           	 	$appurl = substr_compare( 'http',(string)$row->provider->applurl,0,4,true) ? 'http://'. (string)$row->provider->applurl : (string)$row->provider->applurl;
	           		echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
	           	}	
	           	if ((string)$row->provider->faidurl !== 'NULL' AND trim((string)$row->provider->faidurl) !== '')  
	           	{ 
	           		$faidurl = substr_compare( 'http',(string)$row->provider->faidurl,0,4,true) ? 'http://'. (string)$row->provider->faidurl : (string)$row->provider->faidurl;
	           	 	echo '<a class="small" target="_blank" href="'.$faidurl.'">Financial Aid</a><br />';
	           	}
					
				if ((string)$row->onlinecourseurl !== 'NULL' AND trim((string)$row->onlinecourseurl !== '') ) 
				{
					$ocourseurl = '';
					if ((string)$row->coursedeliverymode->name == 'VCN')
					{
		 				$target =  '_self';
						$ocourseurl =  base_path().(string)$row->onlinecourseurl;
					}
					else 
					{
						$target =  '_blank';
			    		$ocourseurl = substr_compare( 'http',(string)$row->onlinecourseurl,0,4,true) ? 'http://'. (string)$row->onlinecourseurl : (string)$row->onlinecourseurl;
					}
					/*
					if (strlen($user->uid) && $user->uid != '0') {
						$url_prot="https://";
					} else {
						$url_prot="http://";
					}
					*/
					$url_prot="http://";
			 	   	echo '<a class="small" target="_blank" href="' .$url_prot . $_SERVER['SERVER_NAME'] . $ocourseurl.'">Take Online</a><br />';         	
			 	   //echo '<a  target="'.$target.'" href="'.hvcp_moodle_server().$ocourseurl.'">Take Online</a><br />';
				} 
			echo '</div>';	 
			}
		?>
   	
<?php else: ?>
	No  refresher course information available.
<?php endif; ?>