<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

 <?php 
 switch ($vars['type'])
 {
  	case 'licenses':
  		echo '<p><strong>License</strong><br />';
  		if ($data )
  		{
  			echo 'Click on license to view details.</p>';
  			echo '<ul>';
  			foreach ($data AS $row)
  			{
  				 echo '<li><a onclick = "submitToLink(this, \'licenses\',\'licenseid\',\''.$row->licenseid.'\')" href="'. base_path() . 'find-learning/detail/licenses/onetcode/'.$vars['onetcode'].'/licenseid/'.$row->licenseid . '/stfips/' . $row->stfips .'" alt="'.$row->lictitle.'" title="'.$row->lictitle.'">'. $row->lictitle .'</a></li>';
  				 
  			}
  			echo '</ul>';
  			echo '<br /><br />';
  		}
  		else 
  		{
  			echo 'No license required in your state.</p>';
  		}
 
 	break;
  	case 'certifications':
 		echo '<p><strong>Certifications</strong><br />';
  		if ($data )
  		{
  			echo 'Click on certification to view details.</p>';
  			echo '<ul>';
  			foreach ($data AS $row)
  			{
   				 echo '<li><a href="'. base_path() . 'find-learning/detail/certifications/onetcode/'.$vars['onetcode'].'/cert_id/'.$row->certid . '" alt="'.$row->certname.'" title="'.$row->certname.'">'. $row->certname .'</a></li>';
    		}
    		echo '</ul>';
    		echo '<br /><br />';
   		}
   		else 
   		{
  			echo 'No certification information available.</p>';
  		}
 	break;
  	case 'programs':
  		echo '<p><strong>Programs</strong><br />';
   		if ($data )
  		{
			$pcount=0;
  			echo 'Click on program to view details.<br /></p>';
  			echo '<ul>'; 
  			foreach ($data AS $row)
  			{
				$pcount++;
   				echo '<li style="margin-bottom:15px;"><a href="'. base_path() . 'find-learning/detail/programs/program_id/'.$row->programid . '/cipcode/' . $row->programcipcode->item->cipcode . '/onetcode/'.$vars['onetcode'].'" alt="'.$row->programname.'" title="'.$row->programname.'">'. $row->programname .'</a><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->provider->instnm.'</li>';
				if ($pcount==5)
					break;
  	 		}
			echo '</ul>';
  		}

  		else {
  			echo 'No program information available.</p>';
  		}
  		
  	break;
  	case 'courses':
   		echo '<p><strong>Courses</strong><br />';
    	if ($data)
  		{
   			$prerequisites = $refresher = false;
  			foreach ($data AS $row)
  			{
  				 echo '<a href="" alt="" title="">'.ucwords($row->coursetitle).'</a>';
  			}
  			if ($prerequisites OR $refresher)
  			{
 				echo 'Click on course to view details.<br /></p>';
  		 		echo '<strong>Prerequisites</strong><br />';
 				if ($prerequisites)
 					echo prerequisites;
 				else 
 					echo 'No prerequisite course information available.';
 					
 				echo '<strong>Refresher</strong><br />';
 				if ($refresher) 
 					echo $refresher;
 				else 
 					echo 'No refresher course information available.';
  			}
  			else 
  			{
  				echo 'No course information available.</p>';
  			}
   		}
   		else 
   		{
  				echo 'No course information available.</p>';
    	}
  	break;
  	case 'legal': 
   		echo '<p><strong>Legal Requirements</strong><br />';
    	if ($data->occupationlegalrequirement->item[0]->legalrequirement)
  		{
  		  echo $data->occupationlegalrequirement->item[0]->legalrequirement;
   		}
   		else 
   		{
  			echo 'No legal information available.</p>';
    	}
  	break;
  	case 'medical':
  		$medical = false;  
    	if ($data->physicalrequirement)
  		{
  		  $medical .= '<p><b>Physical Requirements</b><br />';
  		  $medical .= $data->physicalrequirement . '</p>';
  		}
  		if  ($data->healthrequirement)
  		{
  		  $medical .= '<p><b>Medical/Health Requirements</b><br />';
  		  $medical .= $data->healthrequirement . '</p>';
   		}

   		//echo '<p><strong>Medical</strong><br />';
   		if ($medical)
   		{
   			echo $medical;
   		}
   		else 
   		{
  			echo 'No Medical information available.</p>';
    	}
    	
    	
  	break;
  	
  	default:
 }
 ?>