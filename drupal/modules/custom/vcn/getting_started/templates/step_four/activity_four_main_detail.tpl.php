<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

 
<?php
	$thead = '<table class="">';
	$thead .= '<thead>';
	$thead .= '<tr valign="top">';
	$thead .= '<th class="" align="left">Course Title</th>';
	$thead .= '<th class="">Course Description</th>';
	$thead .= '<th class="">Course Level</th>';
	$thead .= '<th class="">Minimum GPA</th>';
	$thead .= '</tr>';
	$thead .= '</thead>';


	$row = false;
	$count = 0;
	$courses = false;
	
	//print_r($data['programs']); exit;
	  
	if ($data['programs']->programcoursereq)
	{
		$rows = $data['programs']->programcoursereq->item;
	} 
	else if ($data['programs']->provider->providercoursereq)
	{
		$rows = $data['programs']->provider->providercoursereq->item;
	}
 		
		
	$name1=array();	
	$pcrcount=0;
	foreach ($data['programs']->programcoursereq->item AS $row ) 
	{
			$pcrcount++;
 			if ($row->course->coursetype == 2) continue;
			$class = (++$count%2 == 0) ? 'even' : 'odd';  
			
			$name1[$count] = (string)$row->course->coursetitle;
 
			$courses .= '<tr class="' . $class . '"  valign="top">';
			$courses .= '<td><span class="grid-courses-name">';
			//$courses .= '<a onclick="return vcn_gs_show_status_detail_div(\'courses-detail\',\'courses_detail_' . $count . '\')"'; 
			//$courses .= 'href=""  alt = "' . $row->course->coursetitle . '">';
			//$courses .= '<span class="tests-title">' . $row->course->coursetitle .'</span>';
			//$courses .= '</a>';
			$courses .= $row->course->coursetitle;
			$courses .= '</span>';
			$courses .= '</td><td>';
			$courses .= (string)$row->course->description ; 
			$courses .= '</td><td>';
			if ($row->course->courselevel=="H")
				$courses .= 'High School';
			else
				$courses .= 'College';
			//$courses .= (string)$row->course->coursedeliverymode->description;
			$courses .= '</td>';
			$courses .= '<td>';  
			
			if ($row->mingpa>0)
				$courses .= $row->mingpa;

			
			$courses .= '</td>';  			
			$courses .= '</tr>';
	}
	
	$courses0 = $courses;
	
	if (!$pcrcount)
	$courses0.='<tr/><td>Not applicable.</td></tr>';
	
	$courses='';
	
	$pcrcount2=0;
	foreach ($data['programs']->provider->providercoursereq->item AS $row ) 
	{
		$pcrcount2++;
		if ((!in_array((string)$row->course->coursetitle,$name1))) {
 			if ($row->course->coursetype == 2) continue;
			$class = (++$count%2 == 0) ? 'even' : 'odd';  
			
			$courses .= '<tr class="' . $class . '"  valign="top">';
			$courses .= '<td><span class="grid-courses-name">';
			//$courses .= '<a onclick="return vcn_gs_show_status_detail_div(\'courses-detail\',\'courses_detail_' . $count . '\')"'; 
			//$courses .= 'href=""  alt = "' . $row->course->coursetitle . '">';
			//$courses .= '<span class="tests-title">' . $row->course->coursetitle .'</span>';
			//$courses .= '</a>';
			$courses .= $row->course->coursetitle;
			$courses .= '</span>';
			$courses .= '</td><td>';
			$courses .= (string)$row->course->description ; 
			$courses .= '</td><td>';
			if ($row->course->courselevel=="H")
				$courses .= 'High School';
			else
				$courses .= 'College';
			//$courses .= (string)$row->course->coursedeliverymode->description;
			$courses .= '</td>';
			$courses .= '<td>';  
			
			if ($row->mingpa>0)
				$courses .= $row->mingpa;

			
			$courses .= '</td>';  			
			$courses .= '</tr>';
		}
	}
	
	if (!$pcrcount2)
		$courses.='<tr/><td>Not applicable.</td></tr>';	
	
?>
<?php if ($pcrcount || $pcrcount2): ?>
	<p>Based on the program you have selected, displayed below are the prerequisite courses associated needed to qualify for enrollment in your chosen program and school:</p>
	
	
	<h4>Program Prerequisite Courses</h4> 
	
	
	<?php echo $thead.$courses0.'</table>'; ?>
	<br/>
	
	<h4>Provider Prerequisite Courses</h4> 
	
	<?php echo $thead.$courses.'</table>'; ?>
	
	<p>Do you meet these requirements?</p>
	<?php // print_r($vars['GETTINGSTARTED']['prequisitecourses']);?>
	
	<input type="radio" id="vcn-gs-course-yes" name="vcn-gs-course" <?php if ($vars['GETTINGSTARTED']['prequisitecourses'] == 'Yes') echo 'checked="checked"' ; ?>
	onclick="vcn_gs_saveUserKey('GETTINGSTARTED','Prequisite Courses', 'Yes');" /> Yes
	<br />
	<input type="radio" id="vcn-gs-course-no" name="vcn-gs-course" <?php if ($vars['GETTINGSTARTED']['prequisitecourses'] == 'No') {echo 'checked="checked"' ;} else if($vars['GETTINGSTARTED']['prequisitecourses'] != 'Yes') {echo 'checked="checked"' ;}?>
	onclick="vcn_gs_saveUserKey('GETTINGSTARTED','Prequisite Courses', 'No');"/> No
	<br /><br />
	<strong>Hint:  Don't worry if you have not taken one or more of these courses.  We can help.  You may be able to fulfill these prerequisites by taking online courses offered through our VCN application.</strong>
 
<?php else: ?>	
	<p>Our records show there are no prerequisite requirements for the program you have chosen.  However, you should verify this with the school directly.</p>
	<p><strong class="cg_highlight">Click on the next button to continue.</strong></p>
<?php endif; ?> 

 