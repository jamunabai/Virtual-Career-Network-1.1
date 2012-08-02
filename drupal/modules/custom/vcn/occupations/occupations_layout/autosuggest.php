<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

﻿<?php


   //$db = new mysqli('x.x.1.132', 'USER' ,'PASS', 'DATABASE');
	
	if(!$db) {
	
		echo 'Could not connect to the database.';
	} else {
	
		if(isset($_POST['queryString'])) {
			$queryString = $db->real_escape_string($_POST['queryString']);
			
			if(strlen($queryString) >0) {

				//$query = $db->query("SELECT display_title FROM vcn_occupations WHERE display_title LIKE '$queryString%' LIMIT 10");
						
				$query = $db->query("Select laytitle,onetcode from onetsoc_laytitle where ONETCODE IN ( Select ONETCODE FROM vcn_occupations ) AND laytitle LIKE '%$queryString%' order by laytitle limit 10");
				
				if($query) {
				echo '<ul>';
					$count = 0;
					while ($result = $query ->fetch_object()) {
						$count++;
						if ($count==1)
							echo '<script>getonet(\''.addslashes($result->onetcode).'\');</script>'; 
							//echo '<input type="text" value="'.$result->laytitle.'" size="25" id="first">'.'<ul>';
	         			echo '<li onClick="fill(\''.addslashes($result->laytitle).'\'); getonet(\''.addslashes($result->onetcode).'\');">'.$result->laytitle.'</li>';
	         		}
				echo '</ul>';
					
				} else {
					echo 'OOPS we had a problem :(';
				}
			} else {
				// do nothing
			}
		} else {
			echo 'There should be no direct access to this script!';
		}
	}
	

?>