<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript" src="/careerladder/js/jquery-latest.js"></script>


<script type="text/javascript">

function submitcheck(){
	if ($('input:radio[name=group2]:checked').val() && $('input:radio[name=group3]:checked').val()
			  && $('input:radio[name=group4]:checked').val() && $('input:radio[name=group5]:checked').val()
			  && $('input:radio[name=group6]:checked').val() && $('input:radio[name=group7]:checked').val()
			  && $('input:radio[name=group8]:checked').val() && $('input:radio[name=group9]:checked').val()
			  && $('input:radio[name=group10]:checked').val() && $('input:radio[name=group11]:checked').val()) {
	//document.getElementById('seeresultson').style.display = "block";
	//document.getElementById('seeresultsoff').style.display = "none";
	}
	 
}

 

</script>

<style>

body {background-color: #ffffff;font-family: verdana; font-size:12px;}
#page1 { font-weight:bold; }
#page2 { font-weight:bold; }
#page3 { font-weight:bold; }
#page4 { font-weight:bold; }
#page5 { font-weight:bold; }

</style>

    <div id="step-1-actvity-3-sidebar-content-pursuit">
        <div class="vcn-gs-heading"><strong>Career Pursuit</strong></div>
			<div id="pursuit-question-1">
			    <div style="height:175px;">
					<p style="font-size:14px">
						1. Which healthcare career requires only a high school diploma and 3 months training?
					</p>
					<ul class="pursuitul"  style="list-style: none;">
						<li class="pursuitli"><label for="MassageTherapist"><input id="MassageTherapist" type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Massage Therapist</li>
						<li class="pursuitli"><label for="MedicalSecretary"><input id="MedicalSecretary" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Medical Secretary</li>
						<li class="pursuitli"><label for="NurseAide"><input id="NurseAide" selected type="radio" name="pursuit" value="4" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').hide(); $('#videoul').append('MEDICAL SECRETARY');"></label>Nurses Aide</li>
						<li class="pursuitli"><label for="RadiologicTechnician"><input id="RadiologicTechnician" type="radio" name="pursuit" value="5" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Radiologic Technician</li><br><br>
					</ul>
				</div>
				<div style="margin-top:30px; width:100%; text-align:center;">
					<b id="page1">1</b>
					<a id="page2" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').show(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">2</a>
					<a id="page3" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').show(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">3</a>
					<a id="page4" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').show(); $('#pursuit-question-5').hide();">4</a>
					<a id="page5" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').show();">5</a>
				</div>
			</div>
			
			<div id="pursuit-question-2" style="display:none;">	
				<div style="height:175px;">
				<p style="font-size:14px">
					2. Which healthcare career requires Doctoral or Professional degree?
				</p>
				<ul class="pursuitul" style="list-style: none;">
					<li class="pursuitli"><label for="LabTechnician"><input id="LabTechnician" type="radio" name="pursuit" value="1" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Lab Technician</li>
					<li class="pursuitli"><label for="Audiologists"><input id="Audiologists" selected type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').hide();"></label>Audiologists</li>
					<li class="pursuitli"><label for="MedicalSecretary23"><input id="MedicalSecretary23" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Medical Secretary</li>
					<li class="pursuitli"><label for="HomeHealthAide"><input id="HomeHealthAide" type="radio" name="pursuit" value="4" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Home Health Aide</li>
				</ul>
				</div>

				<div style="margin-top:30px; width:100%; text-align:center;">
					<a id="page1" href= "javascript:void(0);" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').show(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">1</a>
					<b id="page2">2</b>
					<a id="page3" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').show(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">3</a>
					<a id="page4" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').show(); $('#pursuit-question-5').hide();">4</a>
					<a id="page5" href= "javascript:void(0);" onclick= "$('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').show();">5</a>
				</div>
			</div>

			<div id="pursuit-question-3" style="display:none;">
				<div style="height:175px;">
				<p style="font-size:14px">
					3. Which healthcare career requires one or two years of training involving both on-the-job experience and informal training with experienced workers?
				</p>
				<ul class="pursuitul" style="list-style: none;">
					<li class="pursuitli"><label for="MassageTherapists"><input id="MassageTherapists" type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Massage Therapist</li>
					<li class="pursuitli"><label for="CriticalCareNurses"><input id="CriticalCareNurses" selected type="radio" name="pursuit" value="1" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').hide();"></label>Critical Care Nurses</li>
					<li class="pursuitli"><label for="NursesAide"><input id="NursesAide" type="radio" name="pursuit" value="4" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Nurses Aide</li>
					<li class="pursuitli"><label for="HomeHealthAides"><input id="HomeHealthAides" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Home Health Aides</li><br><br>
				</ul>
				</div>
				<div style="margin-top:30px; width:100%; text-align:center;">
					<a id="page1" href= "javascript:void(0);" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').show(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">1</a>
					<a id="page2" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').show(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">2</a>
					<b id="page3">3</b>
					<a id="page4" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').show(); $('#pursuit-question-5').hide();">4</a>
					<a id="page5" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').show();">5</a>
				</div>
			</div>
			
			<div id="pursuit-question-4" style="display:none;">
				<div style="height:175px;">
					<p style="font-size:14px">
						4. Which healthcare career requires a four-year Bachelor's degree?
					</p>
					<ul class="pursuitul" style="list-style: none;">
						<li class="pursuitli"><label for="RadiologicTechnician3"><input id="RadiologicTechnician3" type="radio" name="pursuit" value="5" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Radiologic Technician</li>
						<li class="pursuitli"><label for="MassageTherapist3"><input id="MassageTherapist3" type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Massage Therapist</li>
						<li class="pursuitli"><label for="CriticalCareNurses3"><input id="CriticalCareNurses3" selected type="radio" name="pursuit" value="1" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Critical Care Nurses</li>
						<li class="pursuitli"><label for="HealthEducators"><input id="HealthEducators" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').hide();"></label>Health Educators</li><br>
					</ul>
				</div>
				<div style="margin-top:30px; width:100%; text-align:center;">
					<a id="page1" href= "javascript:void(0);" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').show(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">1</a>
					<a id="page2" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').show(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">2</a>
					<a id="page3" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').show(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">3</a>
					<b id="page4">4</b>
					<a id="page5" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').show();">5</a>
				</div>
			</div>
			
			<div id="pursuit-question-5" style="display:none;">
				<div style="height:175px;">
					<p style="font-size:14px">
						5. Which healthcare career requires training in vocational schools, related on-the-job experience, or an Associate's degree?
					</p>
					<ul class="pursuitul" style="list-style: none;">
						<li class="pursuitli"><label for="RadiologicTechnician4"><input id="RadiologicTechnician4" type="radio" name="pursuit" value="5" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Radiologic Technician</li>
						<li class="pursuitli"><label for="SurgicalTechnologists4"><input id="SurgicalTechnologists4" type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').show();"></label>Surgical Technologists</li>
						<li class="pursuitli"><label for="CriticalCareNurses4"><input id="CriticalCareNurses4" selected type="radio" name="pursuit" value="1" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Critical Care Nurses</li>
						<li class="pursuitli"><label for="HomeHealthAides4"><input id="HomeHealthAides4" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Home Health Aides</li><br><br>
					</ul>
				</div>
				<div style="margin-top:30px; width:100%; text-align:center;">
					<a id="page1" href= "javascript:void(0);" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').show(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">1</a>
					<a id="page2" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').show(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">2</a>
					<a id="page3" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').show(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">3</a>
					<a id="page4" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').show(); $('#pursuit-question-5').hide();">4</a>
					<b id="page5">5</b>
				</div>
			</div>
			
			<div id="step-one-activity-3-correct" style="width:100%; text-align:center; color:darkgreen; font-weight:bold;"><br/><br/>That's Correct!</div>
			<div id="step-one-activity-3-incorrect" style="width:100%; text-align:center; color:red; font-weight:bold;"><br/><br/>Sorry, Incorrect.</div>	
			        			
    </div>

   <script>
   
   $('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').show(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();
   
   </script>
 
