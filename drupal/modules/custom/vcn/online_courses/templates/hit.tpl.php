<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script>
$(document).ready(function () {

	$('#hitright').css("height",$('#hitleft').height());

});
</script>

<?php

$valid['subject_area']='valid';
$vars['subject_area']=7;

$valid['active_yn']='valid';
$vars['active_yn']='Y';

$courses = vcn_get_data($errors, $vars, $valid,'trainingsvc','courses','list',$limit=false, $offset=false, $order='course_title', $direction='asc');


?>

<br/>
Health information technology (HIT) makes it possible for healthcare providers to better manage patient care through secure use and sharing of health information. Health IT includes the use of electronic health records (EHRs) instead of paper medical records to maintain people's health information. As the nation moves toward a more technologically advanced health care system, providers are going to need highly skilled health IT experts to support them in the adoption and meaningful use of electronic health records. <br/><br/>
<center><strong>HIT professionals are in demand.</strong></center><br/>
To help address this growing demand, the Office of the National Coordinator for Health Information Technology (ONC) in the Department of Health and Human Services (HHS), awarded $10 million in federal funds to five domestic institutions of higher education (Oregon Health & Science University, University of Alabama at Birmingham, Johns Hopkins University, Columbia University, and Duke University) to develop curriculum and instructional materials to enhance workforce training programs primarily at the community college level.  For more information about <strong>HIT</strong>, <a target="_blank" href="http://healthit.hhs.gov/portal/server.pt?open=512&objID=1419&&PageID=16937&mode=2&in_hi_userid=11673&cached=true#bkgd">click here</a>.  For more information about <strong>HIT Exams</strong>, <a target="_blank" href="/careerladder/docs/onc-competency-exam-06-07-11.pdf">click here</a>.
<br/><br/>
<div style="font-size:10px;">
<div id="hitleft" style="width:47%; float:left; background-color:#6cbcd0; padding:10px; border: 2px solid #ffffff; box-shadow: 3px 3px 5px #888888;">
<center><strong style="font-size:12px;">Courses of Study</strong></center><br/>

The HIT instructional program, composed of the 20 individual courses shown on this page, is based on the curriculum described above.  These courses are free to the user.  Completing these courses and passing one of the several tests shown on the right can lead to attainment of a valuable HIT credential.  <strong>Click on the Course name</strong> to start the course. <br/><br/>
<?php $mb='10px'; ?>
<ul>
<?php $k=0; foreach ($courses->courses as $v):  ?>
<li style="margin-bottom:<?php echo $mb; ?>;">
<?php if ($courses->courses[$k]->comingsoonyn=='N' && strlen($courses->courses[$k]->onlinecourseurl)): ?>
<a href="<?php echo base_path().$courses->courses[$k]->onlinecourseurl; ?>" >
<?php endif; ?>
<?php echo $courses->courses[$k]->coursetitle; ?>
<?php if ($courses->courses[$k]->comingsoonyn=='N' && strlen($courses->courses[$k]->onlinecourseurl)): ?>
</a>
<?php endif; ?>
</li>
<?php  $k++; endforeach; ?>
</ul>
</div>

<div id="hitright" style="width:47%; float:left; background-color:#b0ca7b; padding:10px; margin-left:-2px; border: 2px solid #ffffff; box-shadow: 3px 3px 5px #888888;">
<center><strong style="font-size:12px;">The Exam Blueprint</strong></center><br/>
Northern Virginia Community College (NOVA), again under a grant from ONC, developed the HIT competency examinations described below.  There are 6 exams.  The exams are aligned with the roles and competencies developed by the <a target="_blank" href="http://healthit.hhs.gov/communitycollege">Community College Consortia</a> and the training courses (see the <a target="_blank" href="/careerladder/docs/matrix_of_curriculum_components_by_6_month_role_as_of_06_30_10.pdf">Course to Exam matrix</a>).  Each test consists of 125 multiple-choice questions to be completed in 3 hours.<br/><br/>
<ul>
<li style="margin-bottom:<?php echo $mb; ?>;"><a target="_blank" href="/careerladder/docs/clinician_consultant_exam_blueprint.pdf">Clinician/Practitioner Consultant</a></li>
<li style="margin-bottom:<?php echo $mb; ?>;"><a target="_blank" href="/careerladder/docs/implementation_manager_exam_blueprint.pdf">Implementation Manager</a></li> 
<li style="margin-bottom:<?php echo $mb; ?>;"><a target="_blank" href="/careerladder/docs/implementation_support_specialist_exam_blueprint.pdf">Implementation Support Specialist</a></li> 
<li style="margin-bottom:<?php echo $mb; ?>;"><a target="_blank" href="/careerladder/docs/practice_workflow_exam_blueprint.pdf">Practice Workflow & Information Management Redesign Specialist</a></li> 
<li style="margin-bottom:<?php echo $mb; ?>;"><a target="_blank" href="/careerladder/docs/technical_software_support_exam_blueprint.pdf">Technical/Software Support Staff</a></li> 
<li style="margin-bottom:<?php echo $mb; ?>;"><a target="_blank" href="/careerladder/docs/trainer_exam_blueprint.pdf">Trainer</a></li> 
</ul>
<br/>
<strong>Scheduling/Cancellation of the Exams</strong><br/>
Individuals can make reservations to take exams with Pearson Vue at one of its 230 nationwide test centers (<a target="_blank" href="http://www.pearsonvue.com/vtclocator/">locate the nearest center</a>) either by telephone (888-944-8776) or <a target="_blank" href="http://www.pearsonvue.com/hitpro">online</a>.  Individuals may cancel or reschedule their reservations up to 48 hours before the appointment. In the absence of an emergency, individuals who fail to make their appointment will be charged a fee and will lose the free voucher.<br/><br/>
<strong>Cost for Individuals</strong><br/>
The first exam without a voucher costs $299. The cost for re-taking an exam or taking an additional exam for another role is $199.<br/><br/>
<strong>Free Exam Vouchers</strong><br/>
Free exam vouchers, enabling individuals to take their first exam at no cost, will be available for students trained through the <a target="_blank" href="http://healthit.hhs.gov/communitycollege">Community College Consortia</a> program and for other individuals with relevant experience, training, or education in health care or IT. Vouchers will be available through Pearson Vue's <a target="_blank" href="http://www.pearsonvue.com/vouchers/">Voucher Store</a> and may be ordered by the following institutions: 1) Members of the Community College Consortia or 2) Other accredited academic institutions or 3) State and local employment agencies. 

</div>
</div>