<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 

	  $jobtitle = $_GET['jobtitle'];
	  str_replace($jobtitle,"+"," ");
	  
	  $objDOM = new DOMDocument();

	  $objDOM->load("http://xpand:@www..com/plus/restservice/acMatch/getResult?jobTitle=$jobtitle&codetype=22");


	  $jobnos = $objDOM->getElementsByTagName("occupationResult");
	  $recordcount  = $jobnos->item(0)->nodeValue;
	  
	$count=0; $output="";
	foreach ($jobnos as $value) { 
			$count++;

			$titles = $value->getElementsByTagName("occupationCode");
			$title  = $titles->item(0)->nodeValue;
			
			if ($count>1 && !strstr($title,'9999'))
				$output.=",".$title;
			elseif ($count<=1 && !strstr($title,'9999'))
				$output.=$title;

				
		}
		
	echo $output;
		


?>