<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<div class="vcn-gs-heading">Course Information</div>
 
<?php if ($data['programs']->programcoursereq->item  OR $data['programs']->provider->providercoursereq->item): ?>
	<!--<div class="courses-detail" id="courses_detail_0" style="margin-left:10px; margin-right:10px">Click on a course from the grid on the left to display details</div>-->
	<?php 

 	?>
	
	
	<?php  if ($data['programs']->programcoursereq) :?>
	 	<?php 
			$count = 0;
			foreach ($data['programs']->programcoursereq->item AS $row ) 
			{
				if ($row->course->course_type == 2) continue;
				echo '<div class="courses-detail off" id="courses_detail_' . ++$count . '">';
		 		echo '	<span class="training-title"><strong>' . $row->course->coursetitle . '</strong></span>';
		 		if ((string) $row->course->description !== NULL AND trim((string) $row->course->description !==''))
		 			echo '  <p>' . $row->course->description . '</p>';
 		 		 	 		 		
		   		echo '<span class="detail-school">';
			    if ((string)$row->course->provider->webaddr !== 'NULL' AND trim((string)$row->course->provider->webaddr) !== '') 
			  	{
			    	$webaddr = substr_compare( 'http',(string)$row->course->provider->webaddr,0,4,true) ? 'http://'. (string)$row->course->provider->webaddr : (string)$row->course->provider->webaddr;
			      	echo '<a target="_blank" href="'.$webaddr.'">'.$row->course->provider->instnm.'</a>';
			 	}
			  	else 
			 	{
			   		echo $row->course->provider->instnm;
				}
				echo '</span><br /> ';
			 	if ((string)$row->course->provider->addr !== 'NULL'  AND trim((string)$row->course->provider->addr) !== '' )  
			 		echo $row->course->provider->addr.'<br />'; 
			   	if ((string)$row->course->provider->city !== 'NULL'  AND trim((string)$row->course->provider->city) !== '' ) 
			 		echo $row->course->provider->city; 
		
			   	if ((string)$row->stabbr !== 'NULL' ) 
			   	{
			     	if ((string)$row->course->provider->city !== 'NULL' AND trim((string)$row->course->provider->city) !== '' )  
			 		echo ', '; 
			 		echo $row->course->provider->stabbr; 
			    }
	    
			    if ((string)$row->course->provider->zip !== 'NULL' AND trim((string)$row->course->provider->zip) !== '' )  
			 		echo ' '. $row->course->provider->zip;
			 		
				echo '<br />';
				if ((string)$row->course->provider->gentele !== 'NULL' AND trim((string)$row->course->provider->gentele) !== '' ) 
	 			echo  ' '. vcn_format_phone( $row->course->provider->gentele ).'<br />';
	            	 
	           	 echo '<p><strong>Accredited By:</strong><br />';
	           	 if (!(array)$row->courseaccreditor) 
	           	 {
	           	 	echo "No accredition information available.";
	           	 }
	           	 else 
	           	 {
			         foreach ($row->courseaccreditor->item as $accreditor)
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
	
		      	 if ((string)$row->coursedeliverymode->description !== 'NULL' AND trim((string)$row->coursedeliverymode->description !== 'NULL')  ) {
			      	 echo '<p><strong>Delivery:</strong> ';
		       		 echo  $row->coursedeliverymode->description .'</p>';
		      	 }  	 
		      	 if ((string)$row->othercost !== 'NULL' AND trim((string)$row->othercost) !== '') {
			      	 echo '<p><strong>Other Cost:</strong> ';
		       		 echo '$'.$row->othercost .'</p>';
		      	 }  
		      	 
		      	 
	           	echo '<h3>More Information</h3>';
				if ((string)$row->courseinfourl !== 'NULL' AND trim((string)$row->courseinfourl) !== '')  
				{ 
					$rowurl = substr_compare( 'http',(string)$row->courseinfourl,0,4,true) ? 'http://'. (string)$row->courseinfourl : (string)$row->courseinfourl;
				   	echo '<a class="small" target="_blank" href="'.$rowurl.'">More Info</a> <br />';
				}
	          	if ((string)$row->course->provider->applurl !== 'NULL' AND trim((string)$row->course->provider->applurl) != '')
	           	{
	           	 	$appurl = substr_compare( 'http',(string)$row->course->provider->applurl,0,4,true) ? 'http://'. (string)$row->course->provider->applurl : (string)$row->course->provider->applurl;
	           		echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
	           	}	
	           	if ((string)$row->course->provider->faidurl !== 'NULL' AND trim((string)$row->course->provider->faidurl) !== '')  
	           	{ 
	           		$faidurl = substr_compare( 'http',(string)$row->course->provider->faidurl,0,4,true) ? 'http://'. (string)$row->course->provider->faidurl : (string)$row->course->provider->faidurl;
	           	 	echo '<a class="small" target="_blank" href="'.$faidurl.'">Financial Aid</a><br />';
	           	}
					
				if ((string)$row->course->onlinecourseurl !== 'NULL' AND trim((string)$row->course->onlinecourseurl !== '') ) 
				{
				   	$ocourseurl = substr_compare( 'http',(string)$row->course->onlinecourseurl,0,4,true) ? 'http://'. (string)$row->course->onlinecourseurl : (string)$row->course->onlinecourseurl;
				   	echo '<a class="small" target="_blank" href="'.$ocourseurl.'">Take Online</a><br />';         	
				} 
			echo '</div>';	 
			}
		?>
	
	<?php elseif ($data['programs']->provider->providercoursereq): ?>
	 	<?php 
			$count = 0;
			$provider = '<span class="detail-school">';
		    if ((string)$data['programs']->provider->webaddr !== 'NULL' AND trim((string)$data['programs']->provider->webaddr) !== '') 
		  	{
		    	$webaddr = substr_compare( 'http',(string)$data['programs']->provider->webaddr,0,4,true) ? 'http://'. (string)$data['programs']->provider->webaddr : (string)$data['programs']->provider->webaddr;
		      	$provider .= '<a target="_blank" href="'.$webaddr.'">'.$data['programs']->provider->instnm.'</a>';
		 	}
		  	else 
		 	{
		   		$provider .= $data['programs']->provider->instnm;
			}
			$provider .=  '</span><br /> ';
		 	if ((string)$row->course->provider->addr !== 'NULL'  AND trim((string)$row->course->provider->addr) !== '' )  
		 		$provider .= $row->course->provider->addr.'<br />'; 
		   	if ((string)$row->course->provider->city !== 'NULL'  AND trim((string)$row->course->provider->city) !== '' ) 
		 		$provider .= $row->course->provider->city; 
	
		   	if ((string)$row->stabbr !== 'NULL' ) 
		   	{
		     	if ((string)$row->course->provider->city !== 'NULL' AND trim((string)$row->course->provider->city) !== '' )  
		 		$provider .= ', '; 
		 		$provider .= $row->course->provider->stabbr; 
		    }
		    
		    if ((string)$row->course->provider->zip !== 'NULL' AND trim((string)$row->course->provider->zip) !== '' )  
		 		$provider .= ' '. $row->course->provider->zip;
		 		
			$provider .= '<br />';
			if ((string)$row->course->provider->gentele !== 'NULL' AND trim((string)$row->course->provider->gentele) !== '' ) 
		 		$provider .=  ' '. vcn_format_phone( $row->course->provider->gentele ).'<br />';
	 		
			foreach ($data['programs']->provider->providercoursereq->item AS $row ) 
			{
				if ($row->course->course_type == 2) continue;
				echo '<div class="courses-detail off" id="courses_detail_' . ++$count . '">';
		 		echo '	<span class="training-title"><strong>' . $row->course->coursetitle . '</strong></span>';
		 		if ((string) $row->course->description !== NULL AND trim((string) $row->course->description !==''))
		 			echo '  <p>' . $row->course->description . '</p>';
 		 		 	 		 		
		   		echo $provider;
	            	 
	           	 echo '<p><strong>Accredited By:</strong><br />';
	           	 if (!(array)$row->courseaccreditor) 
	           	 {
	           	 	echo "No accredition information available.";
	           	 }
	           	 else 
	           	 {
			         foreach ($row->courseaccreditor->item as $accreditor)
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
	
		      	 if ((string)$row->coursedeliverymode->description !== 'NULL' AND trim((string)$row->coursedeliverymode->description !== 'NULL')  ) {
			      	 echo '<p><strong>Delivery:</strong> ';
		       		 echo  $row->coursedeliverymode->description .'</p>';
		      	 }  	 
		      	 if ((string)$row->othercost !== 'NULL' AND trim((string)$row->othercost) !== '') {
			      	 echo '<p><strong>Other Cost:</strong> ';
		       		 echo '$'.$row->othercost .'</p>';
		      	 }  
		      	 
		      	 
	           	echo '<h3>More Information</h3>';
				if ((string)$row->courseinfourl !== 'NULL' AND trim((string)$row->courseinfourl) !== '')  
				{ 
					$rowurl = substr_compare( 'http',(string)$row->courseinfourl,0,4,true) ? 'http://'. (string)$row->courseinfourl : (string)$row->courseinfourl;
				   	echo '<a class="small" target="_blank" href="'.$rowurl.'">More Info</a> <br />';
				}
	          	if ((string)$row->course->provider->applurl !== 'NULL' AND trim((string)$row->course->provider->applurl) != '')
	           	{
	           	 	$appurl = substr_compare( 'http',(string)$row->course->provider->applurl,0,4,true) ? 'http://'. (string)$row->course->provider->applurl : (string)$row->course->provider->applurl;
	           		echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
	           	}	
	           	if ((string)$row->course->provider->faidurl !== 'NULL' AND trim((string)$row->course->provider->faidurl) !== '')  
	           	{ 
	           		$faidurl = substr_compare( 'http',(string)$row->course->provider->faidurl,0,4,true) ? 'http://'. (string)$row->course->provider->faidurl : (string)$row->course->provider->faidurl;
	           	 	echo '<a class="small" target="_blank" href="'.$faidurl.'">Financial Aid</a><br />';
	           	}
					
				if ((string)$row->course->onlinecourseurl !== 'NULL' AND trim((string)$row->course->onlinecourseurl !== '') ) 
				{
				   	$ocourseurl = substr_compare( 'http',(string)$row->course->onlinecourseurl,0,4,true) ? 'http://'. (string)$row->course->onlinecourseurl : (string)$row->course->onlinecourseurl;
				   	echo '<a class="small" target="_blank" href="'.$ocourseurl.'">Take Online</a><br />';         	
				} 
			echo '</div>';	 
			}
			
		?>
	
	<?php endif;?>
	
	
	
<?php else: ?>
	<p style="margin-left:10px; margin-right:10px; text-align:left"> No program or provider course prerequisite information available.</p>
<?php endif; ?>