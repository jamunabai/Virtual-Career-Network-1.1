<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
    $topup_js = drupal_get_path('module','occupations_detail') . "/javascripts/top_up-min.js";
    drupal_add_js($topup_js);
    /*
//    $topup_js = "<script type='text/javascript' src='http://gettopup.com/releases/latest/top_up-min.js'></script>";
//    drupal_set_html_head($topup_js);
?>


<script type="text/javascript">
  //TopUp.host = "http://<?php //echo $_SERVER["SERVER_NAME"]; /";?>
  TopUp.host = window.location.protocol+"//"+window.location.host+"/";  
  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";
  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";
</script>
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
  function quizcheck(){

var done=1;
	  /*if ($('input:radio[name=group2]:checked').val() && $('input:radio[name=group3]:checked').val()
			  && $('input:radio[name=group4]:checked').val() && $('input:radio[name=group5]:checked').val()
			  && $('input:radio[name=group6]:checked').val() && $('input:radio[name=group7]:checked').val()
			  && $('input:radio[name=group8]:checked').val() && $('input:radio[name=group9]:checked').val()
			  && $('input:radio[name=group10]:checked').val() && $('input:radio[name=group11]:checked').val()
			   && $('input:radio[name=group12]:checked').val())
		  // add an end comment * / here if you wanna use this file 

		  if (done==1)
		  {
			  
	  var cls=0; var nur=0; var thr=0; var sts=0; var den=0;
		
			if ($('input:radio[name=group2]:checked').val()=="one") {
				nur+=4;
				thr+=4;
												
			}
			if ($('input:radio[name=group2]:checked').val()=="two") {
				thr+=2;
				nur+=2;
				
			}
			if ($('input:radio[name=group2]:checked').val()=="three") {
				cls-=4;
				sts-=4;
				den-=3;
			}						
		

			if ($('input:radio[name=group3]:checked').val()=="one") {
				nur+=4;
				thr+=2;
				sts+=3;
				den+=2;
			}
			if ($('input:radio[name=group3]:checked').val()=="two") {
				nur+=2;
				thr+=1;
				sts+=1;
				den+=1;
				
			}
			if ($('input:radio[name=group3]:checked').val()=="three") {
				cls-=4;
			}						
		
	
			if ($('input:radio[name=group4]:checked').val()=="one") {
				den+=6;
				sts+=2;
			}
			if ($('input:radio[name=group4]:checked').val()=="two") {
				den+=3;
				sts+=1;
			}
			if ($('input:radio[name=group4]:checked').val()=="three") {
				nur-=4;
				thr-=4;
				cls-=4;
			}		

		
		
			if ($('input:radio[name=group5]:checked').val()=="one") {
				cls+=3;
				nur+=6;
				thr+=2;
				sts+=1;
			}
			if ($('input:radio[name=group5]:checked').val()=="two") {
				cls+=1;
				nur+=2;
				thr+=1
			}
			if ($('input:radio[name=group5]:checked').val()=="three") {
				den-=8;
				
			}						
		
		
			if ($('input:radio[name=group6]:checked').val()=="one") {
				den+=4;
				cls+=3;
				nur+=2;
				thr=+1;
				sts+=1;
			}
			if ($('input:radio[name=group6]:checked').val()=="two") {
				nur+=1;
				cls+=1;
				den+=2;
			}
									
		
	
			if ($('input:radio[name=group7]:checked').val()=="one") {
			    cls+=1;
				nur+=2;
				thr+=4;
				sts+=2;
				den+=1;
			}
			if ($('input:radio[name=group7]:checked').val()=="two") {
				nur+=1;
				thr+=2;
				sts+=1;								
			}
									
		
		
			if ($('input:radio[name=group8]:checked').val()=="one") {
				cls+=1;
				nur+=4;
				sts+=1;
			}
			if ($('input:radio[name=group8]:checked').val()=="two") {
				nur+=2;
			}
			if ($('input:radio[name=group8]:checked').val()=="three") {
				thr-=4;
				den-=4;
			}						
		
		
			if ($('input:radio[name=group9]:checked').val()=="one") {
				nur+=2;
				thr+=4;
				sts+=1;
				den+=1;
			}
			if ($('input:radio[name=group9]:checked').val()=="two") {
				nur+=1;
				thr+=2;
			}
			if ($('input:radio[name=group9]:checked').val()=="three") {
				cls-=4;
			}						
		
		
			if ($('input:radio[name=group10]:checked').val()=="one") {
				cls+=1;
				nur+=4;
				thr+=3;
				sts+=1;
				den+=3;
				
			}
			if ($('input:radio[name=group10]:checked').val()=="two") {
				nur+=2;
				thr+=2;
				den+=1;
			}
									
		
		
			if ($('input:radio[name=group11]:checked').val()=="one") {
				cls+=3;
				thr+=1;
				sts+=2;
				den+=3;
				nur-=4;
				
			}
			if ($('input:radio[name=group11]:checked').val()=="two") {
				cls+=1;
				den+=1;
				sts+=1;
			}
				
		
		var category = 1;
		if (nur>category)
			category=8;
		if (thr>category)
			category=14;
		if (sts>category)
			category=13;
		if (den>category)
			category=6;
			
		if (cls==12 && nur==24 && thr== 13 && sts==14 && den==20) {
		   alert('You have selected that you like everything.');
		  // return;
		}
		else {
	//	   document.sidebarquiz.action = "<?php echo base_path(); ?>careergrid/group_id/"+category;
			//window.open("<?php echo base_path(); ?>careergrid/group_id/"+category, "_self");
			$('#loading').removeClass('off');			
			$('#step-1-actvity-3-sidebar-content-quiz').load('/careerladder/groupid.php?groupid='+category, function () { $('#loading').addClass('off'); });
		}
		  }
}
 

</script>

<style>


#page1 { font-weight:bold; }
#page2 { font-weight:bold; }
#page3 { font-weight:bold; }
#page4 { font-weight:bold; }
#page5 { font-weight:bold; }

</style>
<div id="step-1-actvity-3-sidebar-content">
    <div id="step-1-actvity-3-sidebar-content-none"></div>
    <div id="step-1-actvity-3-sidebar-content-pursuit">
        <div class="vcn-gs-heading">Career Pursuit</div>
			<div id="pursuit-question-1">
				<p style="font-size:14px">
					1. Which of these healthcare jobs requires only a high school diploma and 3 months training?
				</p>
				<ul class="pursuitul"  style="list-style: none;">
					
					<li class="pursuitli"><label for="MassageTherapist"><input id="MassageTherapist" type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Massage Therapist</li>
					<li class="pursuitli"><label for="MedicalSecretary"><input id="MedicalSecretary" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Medical Secretary</li>
					<li class="pursuitli"><label for="NurseAide"><input id="NurseAide" selected type="radio" name="pursuit" value="4" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').hide(); $('#videoul').append('MEDICAL SECRETARY');"></label>Nurses Aide</li>
					<li class="pursuitli"><label for="RadiologicTechnician"><input id="RadiologicTechnician" type="radio" name="pursuit" value="5" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Radiologic Technician</li><br><br>
					
										
					<div id="numbers" style="margin-top:39px; margin-left:5px">
					
					<b id="page1">1</b>
					<a id="page2" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').show(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">2</a>
					<a id="page3" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').show(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">3</a>
					<a id="page4" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').show(); $('#pursuit-question-5').hide();">4</a>
					<a id="page5" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').show();">5</a>
					</div>
				</ul>
			</div>
			
			<div id="pursuit-question-2" style="display:none;">	
				<p style="font-size:14px">
					2. Which of these healthcare jobs requires Doctoral or Professional degree?
				</p>
				<ul class="pursuitul" style="list-style: none;">
					<li class="pursuitli"><label for="LabTechnician"><input id="LabTechnician" type="radio" name="pursuit" value="1" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Lab Technician</li>
					<li class="pursuitli"><label for="Audiologists"><input id="Audiologists" selected type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').hide();"></label>Audiologists</li>
					<li class="pursuitli"><label for="MedicalSecretary"><input id="MedicalSecretary" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Medical Secretary</li>
					<li class="pursuitli"><label for="HomeHealthAide"><input id="HomeHealthAide" type="radio" name="pursuit" value="4" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Home Health Aide</li>
					
					<div id="numbers" style="margin-top:73px; margin-left:5px">
					<a id="page1" href= "javascript:void(0);" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').show(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">1</a>
					<b id="page2">2</b>
					<a id="page3" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').show(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">3</a>
					<a id="page4" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').show(); $('#pursuit-question-5').hide();">4</a>
					<a id="page5" href= "javascript:void(0);" onclick= "$('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').show();">5</a>
					</div>
				</ul>
			</div>

			<div id="pursuit-question-3" style="display:none;">
				<p style="font-size:14px">
					3. Which of these healthcare jobs need one or two years of training involving both on-the-job experience and informal training with experienced workers?
				</p>
				<ul class="pursuitul" style="list-style: none;">
					<li class="pursuitli"><label for="MassageTherapists"><input id="MassageTherapists" type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Massage Therapist</li>
					<li class="pursuitli"><label for="CriticalCareNurses"><input id="CriticalCareNurses" selected type="radio" name="pursuit" value="1" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').hide();"></label>Critical Care Nurses</li>
					<li class="pursuitli"><label for="NursesAide"><input id="NursesAide" type="radio" name="pursuit" value="4" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Nurses Aide</li>
					<li class="pursuitli"><label for="HomeHealthAides"><input id="HomeHealthAides" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Home Health Aides</li><br><br>
					
					<div id="numbers" style="margin-top:17px; margin-left:5px">
					<a id="page1" href= "javascript:void(0);" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').show(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">1</a>
					<a id="page2" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').show(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">2</a>
					<b id="page3">3</b>
					<a id="page4" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').show(); $('#pursuit-question-5').hide();">4</a>
					<a id="page5" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').show();">5</a>
					</div>
				</ul>
			</div>
			
			<div id="pursuit-question-4" style="display:none;">
				<p style="font-size:14px">
					4. Which of these healthcare careers require a four-year Bachelor's degree?
				</p>
				<ul class="pursuitul" style="list-style: none;">
					<li class="pursuitli"><label for="RadiologicTechnician3"><input id="RadiologicTechnician3" type="radio" name="pursuit" value="5" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Radiologic Technician</li>
					<li class="pursuitli"><label for="MassageTherapist3"><input id="MassageTherapist3" type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Massage Therapist</li>
					<li class="pursuitli"><label for="CriticalCareNurses3"><input id="CriticalCareNurses3" selected type="radio" name="pursuit" value="1" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Critical Care Nurses</li>
					<li class="pursuitli"><label for="HealthEducators"><input id="HealthEducators" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').hide();"></label>Health Educators</li><br>
					
					<div id="numbers" style="margin-top:68px; margin-left:5px">
					<a id="page1" href= "javascript:void(0);" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').show(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">1</a>
					<a id="page2" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').show(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">2</a>
					<a id="page3" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').show(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">3</a>
					<b id="page4">4</b>
					<a id="page5" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').show();">5</a>
					</div>
				</ul>
			</div>
			
			<div id="pursuit-question-5" style="display:none;">
				<p style="font-size:14px">
					5. Which of these healthcare careers require training in vocational schools, related on-the-job experience, or an Associate's degree?
				</p>
				<ul class="pursuitul" style="list-style: none;">
					<li class="pursuitli"><label for="RadiologicTechnician4"><input id="RadiologicTechnician4" type="radio" name="pursuit" value="5" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Radiologic Technician</li>
					<li class="pursuitli"><label for="SurgicalTechnologists4"><input id="SurgicalTechnologists4" type="radio" name="pursuit" value="2" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').show(); $('#step-one-activity-3-completed').show();"></label>Surgical Technologists</li>
					<li class="pursuitli"><label for="CriticalCareNurses4"><input id="CriticalCareNurses4" selected type="radio" name="pursuit" value="1" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Critical Care Nurses</li>
					<li class="pursuitli"><label for="HomeHealthAides4"><input id="HomeHealthAides4" type="radio" name="pursuit" value="3" onclick="$('#step-one-activity-3-incorrect').show(); $('#step-one-activity-3-correct').hide(); $('#step-one-activity-3-completed').hide();"></label>Home Health Aides</li><br><br>
					
					<div id="numbers" style="margin-top:16px; margin-left:5px">
					<a id="page1" href= "javascript:void(0);" onclick="$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').show(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">1</a>
					<a id="page2" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').show(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">2</a>
					<a id="page3" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').show(); $('#pursuit-question-4').hide(); $('#pursuit-question-5').hide();">3</a>
					<a id="page4" href= "javascript:void(0);" onclick= "$('#step-one-activity-3-incorrect').hide(); $('#step-one-activity-3-correct').hide(); $('#pursuit-question-1').hide(); $('#pursuit-question-2').hide(); $('#pursuit-question-3').hide(); $('#pursuit-question-4').show(); $('#pursuit-question-5').hide();">4</a>
					<b id="page5">5</b>
					</div>
				</ul>
			</div>
			
			<div id="step-one-activity-3-correct" >That's Correct!</div>
			<div id="step-one-activity-3-incorrect" >Sorry, Incorrect.</div>	
			        			
    </div>
    <div id="step-1-actvity-3-sidebar-content-quiz">
        <div class="vcn-gs-heading">Career Quiz</div>
        <p style="font-size: 14px;">
            Select Like (<b>L</b>), Unsure (<b>U</b>) or Dislike (<b>D</b>) options for all of the following statements, to learn more about the type of healthcare career you are suited to.
        </p>
<FORM ACTION="javascript:quizcheck();" name="sidebarquiz" id="sidebarquiz" METHOD="post">
        <table cellspacing="0" cellpadding="0" border="0" >
			<tbody style="border-top:0px;">
            <tr>
                <td style="color: #A71E28; font-size:16px;"><b>L</b></td>
                <td style="color: #A71E28; font-size:16px;"><b>U</b></td>
                <td style="color: #A71E28; font-size:16px;"><b>D</b></td>
                <td></td></b>
            </tr>
            
            <tr id="pq1" style="font-size:14px;">
                <td valign="top"><label for="develop1"><input style="margin-left:0px;" onclick="javascript:submitcheck();"  id="develop1" type="radio" name="group2" value="one"></label></td>
                <td valign="top"><label for="develop2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();"  id="develop2" type="radio" name="group2" value="two"></label></td>
                <td valign="top"><label for="develop3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();"  id="develop3" type="radio" name="group2" value="three"></label></td>
                <td style="font-family: arial;">How willing are you to work with or near patients who are very ill, seriously injured, or possibly dying?<br/><br/></td>
            </tr>
            <tr id="pq2" style="font-size:14px;">
                <td valign="top"><label for="teach1"><input style="margin-left:0px;"  onclick="javascript:submitcheck();"  id="teach1" type="radio" name="group3" value="one"></label></td>
                <td valign="top"><label for="teach2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();"  id="teach2" type="radio" name="group3" value="two"></label></td>
                <td valign="top"><label for="teach3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();"  id="teach3" type="radio" name="group3" value="three"></label></td>
                <td style="font-family: arial;">How comfortable would you be dealing with aggressive and potentially violent individuals as patients?<br/><br/></td>
            </tr>
            
            <tr id="pq3" style="font-size:14px;">
                <td valign="top"><label for="help1"><input style="margin-left:0px;"  onclick="javascript:submitcheck();"  id="help1" type="radio" name="group4" value="one"></label></td>
                <td valign="top"><label for="help2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();"  id="help2" type="radio" name="group4" value="two"></label></td>
                <td valign="top"><label for="help3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();"  id="help3" type="radio" name="group4" value="three"></label></td>
                <td style="font-family: arial;">How comfortable are you seeing blood or other bodily fluids?<br/><br/></td>
            </tr>
            <tr id="pq4" style="font-size:14px;">
                <td valign="top"><label for="proofread1"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="proofread1" type="radio" name="group5" value="one"></label></td>
                <td valign="top"><label for="proofread2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="proofread2" type="radio" name="group5" value="two"></label></td>
                <td valign="top"><label for="proofread3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="proofread3" type="radio" name="group5" value="three"></label></td>
                <td style="font-family: arial;">How much do you know about computer hardware and software (including applications and programming), circuit boards, processors, chips, and electronic equipment?<br/><br/></td>
            </tr>
            <tr id="pq5" style="font-size:14px;">
                <td valign="top"><label for="perform1"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="perform1" type="radio" name="group6" value="one"></label></td>
                <td valign="top"><label for="perform2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="perform2" type="radio" name="group6" value="two"></label></td>
                <td valign="top"><label for="perform3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="perform3" type="radio" name="group6" value="three"></label></td>
                <td style="font-family: arial;">How often should your job require making repetitive motions?<br/><br/></td>
            </tr>
            <tr id="pq6" style="font-size:14px;">
                <td valign="top"><label for="comfort1"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="comfort1" type="radio" name="group7" value="one"></label></td>
                <td valign="top"><label for="comfort2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="comfort2" type="radio" name="group7" value="two"></label></td>
                <td valign="top"><label for="comfort3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="comfort3" type="radio" name="group7" value="three"></label></td>
                <td style="font-family: arial;">How much of your work time would you prefer to spend in an office (mostly away from patients)?<br/><br/></td>
            </tr>
			<tr id="pq7" style="font-size:14px;">
                <td valign="top"><label for="longhours1"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="longhours1" type="radio" name="group8" value="one"></label></td>
                <td valign="top"><label for="longhours2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="longhours2" type="radio" name="group8" value="two"></label></td>
                <td valign="top"><label for="longhours3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="longhours3" type="radio" name="group8" value="three"></label></td>
                <td style="font-family: arial;">How much time do you want to spend sitting?<br/><br/></td>
            </tr>
			<tr id="pq8" style="font-size:14px;">
			
                <td valign="top"><label for="handson1"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="handson1" type="radio" name="group9" value="one"></label></td>
                <td valign="top"><label for="handson2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="handson2" type="radio" name="group9" value="two"></label></td>
                <td valign="top"><label for="handson3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="handson3" type="radio" name="group9" value="three"></label></td>
                <td style="font-family: arial;">How much of your work day do you want to work with patients and their families?<br/><br/></td>
            </tr>
			<tr id="pq9" style="font-size:14px;">
                <td valign="top"><label for="others1"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="others1" type="radio" name="group10" value="one"></label></td>
                <td valign="top"><label for="others2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="others2" type="radio" name="group10" value="two"></label></td>
                <td valign="top"><label for="others3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="others3" type="radio" name="group10" value="three"></label></td>
                <td style="font-family: arial;">Are you comfortable with a job in which making a mistake could have serious consequences for the patients and the company?<br/><br/></td>
           </tr>
			<tr id="pq10" style="font-size:14px;">
                <td valign="top"><label for="computer1"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="computer1" type="radio" name="group11" value="one"></label></td>
                <td valign="top"><label for="computer2"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="computer2" type="radio" name="group11" value="two"></label></td>
                <td valign="top"><label for="computer3"><input style="margin-left:0px;"  onclick="javascript:submitcheck();" id="computer3" type="radio" name="group11" value="three"></label></td>
                <td style="font-family: arial;">Are you good at using scientific instruments and carefully handling biological specimens?<br/><br/>
				
				</td>
				
            </tr>
			</tbody>
       </table>
         
         <div id="quizpagination">
	         <b><span style="text-decoration: underline; cursor: pointer; color: #A71E28; font-size:16px;" onclick="showquestions('1');" id="quizpage1"> 1</b></span> 
	         <b><span style="text-decoration: underline; cursor: pointer; color: #A71E28;font-size:16px;" onclick="showquestions('2');" id="quizpage2"> 2</b></span> 
	         <b><span style="text-decoration: underline; cursor: pointer; color: #A71E28;font-size:16px;" onclick="showquestions('3');" id="quizpage3"> 3</b></span>
         </div> 
         
 		</form>
 		
 		<script>showquestions('1');</script>
   </div>
    
    <div id="step-1-actvity-3-sidebar-content-video">
        <div class="vcn-gs-heading">Career Videos</div>
        <p style="font-size:14px;">
            Watch these videos to learn more about each of these careers.
        </p>
        <ul>
            <li class="videoli"><a href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_detail/videos/29-1126.00.flv" toptions="width = 425, height = 344, resizable = 1, layout=flatlook, title=Respiratory Therapist, shaded=1">Respiratory Therapist</a></li>
            <li class="videoli"><a href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_detail/videos/29-2021.00.flv" toptions="width = 425, height = 344, resizable = 1, layout=flatlook, title=Dental Hygienist, shaded=1">Dental Hygienist</a></li>
            <li class="videoli"><a href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_detail/videos/31-9094.00.flv" toptions="width = 425, height = 344, resizable = 1, layout=flatlook, title=Medical Transcriptionist, shaded=1">Medical Transcriptionist</a></li>
            <li class="videoli"><a href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_detail/videos/29-1123.00.flv" toptions="width = 425, height = 344, resizable = 1, layout=flatlook, title=Physical Therapist, shaded=1">Physical Therapist</a></li>
            <li class="videoli"><a href="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_detail/videos/31-1011.00.flv" toptions="width = 425, height = 344, resizable = 1, layout=flatlook, title=Home Health Aide, shaded=1">Home Health Aide</a></li>
			
        </ul>
    </div>
    <div id="step-1-actvity-3-sidebar-content-jobs">
        <div class="vcn-gs-heading">Job Openings</div>
        <p>
            Review these job openings to learn more about each of these jobs.
        </p>
        <ul>
            <li><a href="http://web.detma.org/JobQuest/JobDetails.aspx?jo=989460" target="_blank">Medical Assistant (MA)</a></li>
            <li><a href="http://web.detma.org/JobQuest/JobDetails.aspx?jo=990609" target="_blank">Staff Nurse (MA)</a></li>
            <li><a href="https://jobs.healthcaresource.com/cd/index.cfm?fuseaction=search.jobDetails&template=dsp_job_details.cfm&cJobId=997629" target="_blank">Radiation Therapist (MA)</a></li>
            <li><a href="https://jobs.healthcaresource.com/cd/index.cfm?fuseaction=search.jobDetails&template=dsp_job_details.cfm&cJobId=829986" target="_blank">Pharmacy Technician (MA)</a></li>
        </ul>
    </div>
</div>
*/ ?>



<div id="step-1-actvity-1-sidebar-content">
    <div class="vcn-gs-heading">How to Get Started</div>
    <div id="video-link">
        <a href="/careerladder/gsvideos/AACC_VCN1.flv" toptions="width = 425, height = 240, resizable = 1, layout=flatlook, shaded=1" title="Watch Video" alt="Watch Video">
         <img height="212" width="212" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/photo.43601300.jpg" alt="Watch Video" class="imgA1">
         <img src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/career_images/play.png" alt="Play" class="imgB1">
         </a>

    </div>
</div>

