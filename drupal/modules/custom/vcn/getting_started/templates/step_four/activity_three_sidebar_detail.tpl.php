<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
	$tableclass = ( isset($vars['GETTINGSTARTED']['testscores']) AND $vars['GETTINGSTARTED']['testscores'] == 'No') ? 'on' : 'off';
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
<div class="vcn-gs-heading">Test Information</div>
   
 <?php
	$countfirst = 0;
	foreach ( $data['programs']->programentrancetest->item AS $row ) 
		$countfirst++;
		
	foreach ( $data['programs']->provider->providerentrancetest->item AS $row )
		$countfirst++;

 ?> 
   
<?php if ($countfirst) :?>
	<div style="margin-left:10px; margin-right:10px" class="tests-detail" id="tests_detail_0" >Contact the test agency to obtain information on how to get a copy of your test score to be sent to your selected school.</div>

	<?php if (!$data['programs']->programentrancetest) :?>
		<?php 
			foreach ( $data['programs']->programentrancetest->item AS $row )  
			{
				$type = ($row->hsgradortransferstudent == 'T') ? 'T': 'H';
 			 	$count = ($type == 'T') ? ++$tcount : ++$hscount;
 	 			$class = ($count%2 == 0) ? 'even' : 'odd';        
 	 			
 	 			$trow = '<div style="margin-left:10px; margin-right:10px" class="tests-detail off" id="tests_detail_'.$type.$count.'" >';
				$trow .= '<strong>'.$row->test->testname.'</strong><br />';
				$trow .= '<p><strong>Description</strong></p>';
				$trow .= '<p>'.$row->test->testdescription.'</p>';
				$trow .= '<p><strong>Minimum Score</strong></p>';
				$trow .= '<p>'.$row->test->minscore.'</p>';
				$trow .= '<p><strong>More information</strong></p>';
	 	  
	       		if ((string)$row->test->testurl !== 'NULL' AND trim((string)$row->test->testurl) !== '') 
	          	{
	           		$webaddr = substr_compare( 'http',(string)$row->test->testurl,0,4,true) ? 'http://'. (string)$row->test->testurl : (string)$row->test->testurl;
					

	             	$trow .= '<a target="_blank" href="'.base_path().(string)$row->test->testurl.'">Click here</a> for more information on this test.';
	            }
	            else 
	            {
	            	$trow .=  'Not available';
	           	}
 
				$trow .= '</div>';
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
	
	<?php elseif ($data['programs']->provider->providerentrancetest) :?>
		<?php 
			foreach ( $data['programs']->provider->providerentrancetest->item AS $row )  
			{
				$type = ($row->hsgradortransferstudent == 'T') ? 'T': 'H';
 			 	$count = ($type == 'T') ? ++$tcount : ++$hscount;
 	 			$class = ($count%2 == 0) ? 'even' : 'odd';        
 	 			
 	 			$trow = '<div style="margin-left:10px; margin-right:10px" class="tests-detail off" id="tests_detail_'.$type.$count.'" >';
				$trow .= '<strong>'.$row->test->testname.'</strong><br />';
				$trow .= '<p><strong>Description</strong></p>';
				$trow .= '<p>'.$row->test->testdescription.'</p>';
				$trow .= '<p><strong>Minimum Score</strong></p>';
				$trow .= '<p>'.$row->minscore.'</p>';
				$trow .= '<p><strong>More information</strong></p>';
	 	  
	       		if ((string)$row->test->testurl !== 'NULL' AND trim((string)$row->test->testurl) !== '') 
	          	{
	           		$webaddr = substr_compare( 'http',(string)$row->test->testurl,0,4,true) ? 'http://'. (string)$row->test->testurl : (string)$row->test->testurl;
					
						
	             	$trow .= '<a target="_blank" href="'.base_path().(string)$row->test->testurl.'">Click here</a> for more information on this test.';
	            }
	            else 
	            {
	            	$trow .=  'Not available';
	           	}
 
				$trow .= '</div>';
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
 
  	<?php echo $highschool;?>
  	<?php echo $transfer;?>
   
<?php else: ?>
 	<!-- <p style="margin-left:10px; margin-right:10px; text-align:justify">No entrance test information available for your selected program or provider.</p> -->
<?php endif;?>