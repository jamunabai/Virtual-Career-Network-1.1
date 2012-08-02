<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php  if ($data['courses']):?>

<style>
table {
	border-collapse:none;
}
.indentonlinegs {
    padding-left: 15px;
}
.title2
  {
  font-size: 16px;
  font-family: arial, helvetica, sans-serif;
  font-weight: bold;
  border: 1px solid black;
  background-color: #189AB0;
  color: white;
  }

.container
  {
  font-size: 14px;
  font-family: arial, helvetica, sans-serif;
  }

.strong
  {
  font-weight: bold;
  padding-top: 10px;
  padding-bottom: 10px;
  list-style-type: none;
  }

td
  {
  font-size: 14px;
  font-family: arial, helvetica, sans-serif;
  width:100%;
  }

.nodot
  {
  list-style-type: none;
  }

.disc
  {
  list-style-type: disc;
  }

.tt-head
  {
  width:310px;
  color: white;
  background: #189AB0;
  border:1px solid #663300;
  text-align: center;
  }

.tt-body
  {
  width:300px;
  background: #FEF5FE;
  font-size: 10px;
  border-left:1px solid #663300;
  border-right:1px solid #663300;
  border-bottom:1px solid #663300;
  padding: 5px;
  }

span.hint
  {
  float: right;
  padding-top: 4px;
  padding-right: 5px;
  text-align: right;
  font-size: 12px;
  }

</style>

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
				if ($vs[0]=='N')
					continue;
					
				$coursecount=0;
				$thesubject = substr($vs, 2);  ?> 
		  <div class="strong">
		  Subject Area: <?php echo $thesubject; ?> 
			
			<?php if ($vs[1]=='Y'): ?>
			<span style="font-weight:normal;">(For Credit)</span>
			<?php endif; ?>
			
		  </div>		  
		  
		  <?php $k=0; foreach ($vcnle->courses as $v): if ($vcnle->courses[$k]->subject->description[0]==$thesubject && $vcnle->courses[$k]->activeyn=='Y'): ?>
		  <div style="padding-left:15px;">
			<?php if ($vcnle->courses[$k]->comingsoonyn=='N'): ?>
				<a href="<?php echo base_path().$vcnle->courses[$k]->onlinecourseurl; ?>" ><?php echo $vcnle->courses[$k]->coursetitle; ?></a>
			<?php else: ?>
				<?php echo $vcnle->courses[$k]->coursetitle; ?> (Coming soon)
			<?php endif; $coursecount++; ?>
		  </div>
		  <?php endif; $k++; endforeach; ?>
		  
		  <?php if (!$coursecount) { echo '<div style="padding-left:15px;">(Coming soon)</div>'; continue; } ?>
		  
		<?php endforeach; ?>

</div>

<?php else: ?>	
	<p>No refresher course data available for the targeted program. <strong class="cg_highlight">Click 'Next' below to move to the next activity.</strong></p>
 
<?php endif;?>

 