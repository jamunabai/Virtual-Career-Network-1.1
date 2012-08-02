<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
	$testscores = ( isset($vars['GETTINGSTARTED']['testscores']) AND $vars['GETTINGSTARTED']['testscores'] == 'No') ? 'No' : 'Yes';
	$tableclass = ( isset($vars['GETTINGSTARTED']['testscores']) AND $vars['GETTINGSTARTED']['testscores'] == 'No') ? 'on' : 'on';
	$hscount = 0;
	$tcount  = 0;
	$highschool = '';
	$transfer   = '';
	$thead ='<table class="'.$tableclass.'">';
	$thead .='<thead>';
	$thead .='<tr valign="top">';
	$thead .='  		<th class="" align="left">Code</th>';
	$thead .='      	<th class="">Minimum Score</th>';
	$thead .='</tr>';
	$thead .='</thead>';
 ?>

<?php if ($data['programs']->programentrancetest  OR $data['programs']->provider->providerentrancetest ) :?>

	<?php if ($data['programs']->programentrancetest->item) :?>
	 
		<?php 
			foreach ( $data['programs']->programentrancetest->item AS $row )  
			{ 
				$type = ($row->hsgradortransferstudent == 'T') ? 'T': 'H';
 			 	$count = ($type == 'T') ? ++$tcount : ++$hscount;
				
 	 			$class = ($count%2 == 0) ? 'even' : 'odd';        
				$trow  = '<tr class="'.$class.'"  valign="top">';
				$trow .= '<td><span class="grid-tests-name">';
		     	$trow .= '<a onclick="return vcn_gs_show_status_detail_div (\'tests-detail\',\'tests_detail_'.$type.$count.'\')"'; 
		     	$trow .= ' href=""  alt = "'.$row->test->testname.'">';
		     	$trow .= ' <span class="tests-title">'.$row->test->testname.'</span>';
		     	$trow .= '</a>';
		     	$trow .= '</span>';
		     	$trow .= '</td><td>';
				$trow .= $row->minscore ; 
		     	$trow .= '</td>';
		     	$trow .= '</tr>';
		     	 
		     	if ($type == 'T')
		     	{
		     		$transfer .= $trow;
		     	}
		     	else 
		     	{
		     		$highschool .= $trow;
 		     	}
			} 
 	 	?>
	
	<?php elseif ($data['programs']->provider->providerentrancetest->item) : ?>
	 
		<?php 
	 		foreach ( $data['programs']->provider->providerentrancetest->item AS $row )  
			{
				$type = ($row->hsgradortransferstudent == 'T') ? 'T': 'H';
 			 	$count = ($type == 'T') ? ++$tcount : ++$hscount;
 	 			$class = ($count%2 == 0) ? 'even' : 'odd';
  
				$trow  = '<tr class="'.$class.'"  valign="top">';
				$trow .= '<td><span class="grid-tests-name">';
		     	$trow .= '<a onclick="return vcn_gs_show_status_detail_div (\'tests-detail\',\'tests_detail_'.$type.$count.'\')"'; 
		     	$trow .= ' href=""  alt = "'.$row->test->testname.'">';
		     	$trow .= ' <span class="tests-title">'.$row->test->testname.'</span>';
		     	$trow .= '</a>';
		     	$trow .= '</span>';
		     	$trow .= '</td><td>';
				$trow .= $row->minscore ; 
		     	$trow .= '</td>';
		     	$trow .= '</tr>';
		     	 
		     	if ($type == 'T')
		     	{
		     		$transfer .= $trow;
		     	}
		     	else 
		     	{
		     		$highschool .= $trow;
		     		 
		     	}
			} 
 	 	?>
  	<?php endif; ?> 
	
	
	<?php 

		if ($highschool) 
		{ 
		
			echo '<p>The school and program that you have selected requires you to complete the following achievement test and/or placement exams.</p>';
			
			echo '<strong>Hint:</strong> Don\'t worry if you have not taken one or more of these tests. We can help. 
				Displayed below are some resources that can help you prepare for, take a practice test, and 
				register to take the test you need.
				<ul><li><a target="_blank" href="http://www.studygs.net/">Study Guides and Strategies</a></li>
					<li><a target="_blank" href="http://www.muskingum.edu/~cal/database/general/testtaking.html">Test Taking Strategies</a></li>
					<li><a target="_blank" href="http://www.testtakingtips.com/">Test Taking Tips</a></li>
				</ul>';
			echo $thead.$highschool.'</table>';
		}
		else 
		{
			echo '<br/>Our records show there are no test score entry requirements associated with the school 
			and program you have chosen. However, you should verify this with the school directly. <br/><br/>
			<strong class="cg_highlight">Click on the next button to continue</strong>';
		}
		/*
		echo '<h4>Transfer Student Tests</h4>';
		if ($transfer) 
		{ 
			echo $thead.$transfer.'</table>';
		}
		else 
		{
			echo 'No transfer student entrance test information available.';
		}
		*/
	?> 
	<?php if ($highschool) :?>
	<p>Have you taken these exams?</p>
	
	<input type="radio" id="vcn-gs-entry-test-yes" name="vcn-gs-entry-test" <?php if ($testscores == 'Yes') echo 'checked="checked"'; ?>
	onclick="$('#vcn-gs-test-answer').removeClass('off');vcn_gs_saveUserKey ('GETTINGSTARTED','Test Scores','Yes');" /> Yes
	
	<br />
	<input type="radio" id="vcn-gs-entry-test-no" name="vcn-gs-entry-test"  <?php if ($testscores == 'No') echo 'checked="checked"'; ?>
	onclick="$('#vcn-gs-test-answer').addClass('off');vcn_gs_saveUserKey ('GETTINGSTARTED','Test Scores','No');"/> No
	<br /><br />
	<div id="vcn-gs-test-answer" class="">Contact the test agency if you need to request a copy of your test results to be sent to the school.</div>
	<?php endif; ?>
<?php endif; ?> 