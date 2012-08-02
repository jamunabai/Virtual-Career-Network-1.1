<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<style>
.strong
  {
  font-weight: bold;
  padding-top: 10px;
  padding-bottom: 10px;
  list-style-type: none;
  }

  
</style>
<?php

$cma = vcnCma::getInstance();

$cmazip='';

if (strlen($cma->zipcode)==5)
	$cmazip='?zipcode='.$cma->zipcode;


?>
<div style="float:right;<?php if (!$user->uid) echo 'display:none;'; ?>">
<a href="<?php echo base_path(); ?>tests/testtaker<?php echo $cmazip; ?>">
<img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/online_courses/images/schedule_a_test.png" alt="Schedule a Test">
</a>
</div>
<?php if ($user->uid): ?>
<br/><br/><br/>
<?php endif; ?>
<br/>
Listed below are the "for-credit" courses and instructional programs offered through the VCN.  Click on the course or program title to start the course.  
<br/><br/>
After completing an individual "for-credit" course, you can earn college credit if you successfully pass the 
associated final examination. To schedule that examination, log in to your VCN account. You will then 
see a "Schedule a Test" button above.
<br/><br/>
<strong>Note: There are limited authorized testing locations.  The closest location could be over 100 miles away from you.   
It's recommended to log in to your VCN account and go to the "Schedule a Test" page as described above to 
see where the closest authorized testing location is relative to your ZIP code.</strong>
<br/><br/>

<?php 

$subjects = vcn_get_data($errors, $vars, $valid,'trainingsvc','courses','list-subject-area',false,false);


$valid['unitid']='valid';
$vars['unitid']=1;

$vcnle = vcn_get_data($errors, $vars, $valid,'trainingsvc','courses','list',$limit=false, $offset=false, $order='course_title', $direction='asc');



$activesubjects0 = array();

$k=0;
foreach ($subjects->courses as $v)  {
	$activesubjects0[(string)$subjects->courses[$k]->description]=(string)$subjects->courses[$k]->activeyn.$subjects->courses[$k]->accreditedyn;
	$k++;
}

ksort($activesubjects0);

foreach ($activesubjects0 as $k=>$v)
	$activesubjects[]=$v.$k;
	
?>
<div>  
	  <?php foreach ($activesubjects as $ks => $vs): 
				if ($vs[0]=='N' || $vs[1]=='N')
					continue;
					
				$coursecount=0;
				$thesubject = substr($vs, 2);  ?> 
		  <div class="strong" style="margin-left:45px;">
		  Subject Area: <?php echo $thesubject; ?> 
			
			<?php if ($vs[1]=='Y'): ?>
			<span style="font-weight:normal;">(For Credit)</span>
			<?php endif; ?>
			
		  </div>		  
		  
		  <?php $k=0; foreach ($vcnle->courses as $v): if ($vcnle->courses[$k]->subject->description[0]==$thesubject && $vcnle->courses[$k]->activeyn=='Y'): ?>
		  <div style="padding-left:70px;">
			<?php if ($vcnle->courses[$k]->comingsoonyn=='N' && strlen($vcnle->courses[$k]->onlinecourseurl)): ?>
				<li style="margin-left:15px; margin-bottom:15px;"><a href="<?php echo base_path().$vcnle->courses[$k]->onlinecourseurl; ?>" ><?php echo $vcnle->courses[$k]->coursetitle; ?></a></li>
			<?php else: ?>
				<li style="margin-left:15px; margin-bottom:15px;"><?php echo $vcnle->courses[$k]->coursetitle; ?> (Coming soon)</li>
			<?php endif; $coursecount++; ?>
		  </div>
		  <?php endif; $k++; endforeach; ?>
		  
		  <?php if (!$coursecount) { echo '<div style="padding-left:70px;"><li style="margin-left:15px; margin-bottom:15px;">(Coming soon)</li></div>'; continue; } ?>
		  
		<?php endforeach; ?>

</div>