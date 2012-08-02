<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php



function theme_vcn_cma_tests_view($cma) {
global $user;

$query = db_query("select * from content_type_test_session ts, node n where n.nid = ts.nid;");
$i = 0;
$flag = 0;
	
	while ($file = db_fetch_array($query)) {
		//echo "Ganappa";

		
		
		
		if($file['field_pass_fail_value']=="p")
		$pf="Y";
		else
		$pf="N";

		$c=$file['field_credits_value'];
		

		if($file['field_student_uid'] == $user->uid){
		
		if($i == 0){
			$o .= '<h4>Test Scores</h4>';
			$o .= '<div style="margin-left: 0px; margin-bottom: 3px;">'.'<b>Test Title</b>'.'</div>';
			$o .= '<div style="margin-left: 825px; margin-top: -20px;">'.'<b>Test Date</b>'.'</div>';
			$o .= '<div style="margin-left: 240px; margin-top: -15px;">'.'<b>Test Score</b>'.'</div>';
			$o .= '<div style="margin-left: 340px; margin-top: -15px;">'.'<b>Passed</b>'.'</div>';
			$o .= '<div style="margin-left: 440px; margin-top: -15px;">'.'<b>Credits</b>'.'</div>';
			$o .= ' <hr class="clear-both">' . PHP_EOL;		
		}

			$i++;		
			$flag++;
			
			$testtitle = explode("/",$file['title']);
			$testtitlediv = '<div style="margin-left: 0px; margin-bottom: 3px;">'.$testtitle[0].'</div>';
			$datevalue = date("Y-m-d",$file['created']);
			$testdatediv = '<div style="margin-left: 825px; margin-top: -20px;">'.$datevalue.'</div>';
			$testscorediv = '<div style="margin-left: 240px; margin-top: -15px;">'.$file['field_test_score_value'].'</div>';
			$passfaildiv = '<div style="margin-left: 340px; margin-top: -15px;">'.$pf.'</div>';
			$creditsdiv = '<div style="margin-left: 440px; margin-top: -15px;">'.$c.'</div>';

			$o .= $testtitlediv; 
			$o .= $testscorediv; 
			$o .= $passfaildiv;
			$o .= $creditsdiv;
			$o .= $testdatediv;
			$o .= "<br />";

			$o .= ' <hr class="clear-both">' . PHP_EOL;
		}
	}
	
	if($flag == 0){
		$o .= '<h4>No Test Scores</h4>';
	}	

return $o;

} 