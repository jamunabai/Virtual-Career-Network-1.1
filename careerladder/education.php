<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php    

	$e1=$_GET['e1'];
	$e2=$_GET['e2'];
	$e3=$_GET['e3'];


	$v1= number_format($_GET['v1'], 0, '', '');
	$v2= number_format($_GET['v2'], 0, '', '');
	$v3= number_format($_GET['v3'], 0, '', '');

 
    //Set content-type header
    header("Content-type: image/png");

    //Include phpMyGraph5.0.php
    include_once('phpMyGraph5.0ed.php');
    
    //Set config directives
    $cfg['title'] = 'Most common education levels';
    $cfg['width'] = 400;
	
	if ($e1) {
		$cfg['height'] = 100;
		$data = array(
			$e1 => $v1
		);		
	}		
		
	if ($e2) { 
		$cfg['height'] = 150;
		$data = array(
			$e1 => $v1,
			$e2 => $v2
		);		
	}		
		
	if ($e3) { 
		$cfg['height'] = 200;
		$data = array(
			$e1 => $v1,
			$e2 => $v2,
			$e3 => $v3

		);		
	}			
    
    
    //Create phpMyGraph instance
    $graph = new phpMyGraph();

    //Parse
    $graph->parseHorizontalColumnGraph($data, $cfg);
?> 