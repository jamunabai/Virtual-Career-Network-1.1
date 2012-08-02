<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>




<?php // header( 'Cache-Control: private, max-age=10800, pre-check=10800' ); ?>

<?php 


$browser = $_SERVER['HTTP_USER_AGENT'];

$ged = explode('/',$_SERVER['REQUEST_URI']);

foreach ($ged as $k=>$v) {
	if ($v=='ged')
		$gedvalue=$ged[$k+1];
	if ($v=='awlevel')
		$awurl = $ged[$k+1];
}

?>

<p class="intro">
 Choose from our education and training programs from around the country to prepare you for a variety of Healthcare Careers. 
 <br/><strong>Hint:</strong> Before you begin, you may want to read "How to Manage a Career Change" 
 (<a alt="factsheet" title="factsheet" href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/253/How_to_Manage_a_Career_Change_Part_1')">Part 1</a>, 
  <a alt="factsheet" title="factsheet" href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/254/How_to_Manage_a_Career_Change_Part_2')">Part 2</a>)
</p>

<?php echo $content['search']; ?>
<?php

	  $use_appcache = true;
	  $cid = "findlearning-occupation-list-short";
	  $cached_content = null;
	  
	  //print "OCCUPATIONS DETAIL: before call to rest data " . udate("H:i:s:u") . "<br />";
	  if ($use_appcache) {
		 $cached = cache_get($cid,'cache_content');
		 $ser_content = $cached->data;
		 if (!empty($ser_content)) {
			$cached_content = unserialize($ser_content);
			//print "using cached data for " . $cid . "<br />";
		 }
	  }
	  
	  if (empty($cached_content)) {
		 $occupations = vcn_get_occupations(false,false,true,'list-short'); 
		 if ($use_appcache) {
		   // save data to cache
		   $ser_content = serialize($occupations);
		   cache_set($cid, $ser_content, 'cache_content', $CACHE_PERMANENT);
		   
		  
		   //print "setting cache for " . $cid . "<br />";
		} 
	  } else {
		 $occupations = $cached_content; 
	  }
	  
////////////////////////////////////////////////////////////////////////////////////////

	  $use_appcache = true;
	  $cid = "findlearning-occupation-list";
	  $cached_content = null;
	  
	  //print "OCCUPATIONS DETAIL: before call to rest data " . udate("H:i:s:u") . "<br />";
	  if ($use_appcache) {
		 $cached = cache_get($cid,'cache_content');
		 $ser_content = $cached->data;
		 if (!empty($ser_content)) {
			$cached_content = unserialize($ser_content);
			//print "using cached data for " . $cid . "<br />";
		 }
	  }
	  
	  if (empty($cached_content)) {
		 $occupationslist = vcn_get_occupations(false,false,true,'list');
		 if ($use_appcache) {
		   // save data to cache
		   $ser_content = serialize($occupationslist);
		   cache_set($cid, $ser_content, 'cache_content', $CACHE_PERMANENT);
		   //print "setting cache for " . $cid . "<br />";
		} 
	  } else {
		 $occupationslist = $cached_content; 
	  }	  
	  
	$occupationslistsorted=array();
	
	foreach ($occupationslist as $k=>$v)
		$occupationslistsorted[$k]=$v['title'];
		
   asort($occupationslistsorted);
   $awlevels    = vcn_get_ipeds_lookup('AWLEVEL');

?>

<script>
 var occupations = <?php echo json_encode($occupations); ?>;
 var occupationslist = <?php echo json_encode($occupationslist); ?>;
 var awlevels    = <?php echo json_encode($awlevels);  ?>;



	
 $(document).ready(function() {
 

	highorgedtext(document.getElementById('highorged').value);


	var onetcode = $('#fl-occ1').val();
 	var zip      = $('#fl-zip1').val();

	var q = '';

	if (!onetcode || !zip) {
		var q = "<?php echo $vars['q']; ?>";

		var qarr = q.split("/");

		var awcheck = '';

		for (var i=0; i<qarr.length; i++) {
			var thenext = (i+1);

			if (qarr[i]=='onetcode')
				onetcode = qarr[thenext];

			if (qarr[i]=='zip')
				zip = qarr[thenext];

			if (qarr[i]=='awlevel') {
				var awlevel = qarr[thenext];
				awcheck=1;
			}
			if (qarr[i]=='radius') {
				var radius = qarr[thenext];
			}

		}

		if (!awcheck) { 
			if (onetcode && zip)
				vcn_FlSelect1(onetcode,zip);
			$('#fl-occ1').val(onetcode);
			$('#fl-zip1').val(zip);
		} else {
			vcn_FlSelect1(onetcode,zip);
			vcn_FlSelect2(onetcode,zip);
		}



	}


	if ( onetcode && zip && !q )
	{
		vcn_FlSelect1(onetcode,zip);
		vcn_FlSelect2(onetcode,zip);
	}

 });

 function vcn_validateFindLearning(section)
 {
	var onetcode = $('#fl-occ' + section).val();
 	var zip      = $('#fl-zip'+ section).val();

  	if (!onetcode) {
		alert('Please select a career');
		vcn_toggleFllinks(section,'off');
		return false;
	}

var zipvalueinoccupationdetail = zip;
var base_path = vcn_base_path();

$('#zipod').load('/careerladder/zipvalidation.php?zipcode='+zipvalueinoccupationdetail, function() {
                  var zval = document.getElementById("zipod").innerHTML;
                  if(zval == 'true'){
					if (section == 1)
						var url = base_path+'find-learning/onetcode/' + $('#onetcode').val()+'/zip/'+  $('#fl-zip1').val() + '/ged/'+ $('#highorged').val();

					if (section == 2)
						var url = base_path+'find-learning/onetcode/' + $('#onetcode').val()+'/zip/'+  $('#fl-zip2').val() +'/radius/'+$('#fl-distance').val()+'/awlevel/'+$('#fawlevel').val() + '/ged/'+ $('#highorged').val();

					if (section == 1) { window.open(url,'_self'); return; $("#fl-zip1").removeClass("redborder"); $("#fl-zip1").addClass("fl-input"); vcn_FlSelect1(onetcode,zip,'only1'); }
					if (section == 2) { window.open(url,'_self'); return; $("#fl-zip2").removeClass("redborder"); $("#fl-zip2").addClass("fl-input"); vcn_FlSelect1(onetcode,zip,'both'); vcn_FlSelect2(onetcode,zip); }

					return false	;
                          }
              else
                          {
							if (section == 1) {

								$("#fl-zip1").removeClass("fl-input");
								$("#fl-zip1").addClass("redborder");
								$("#fl-zip1").css( "padding", "5px" );
							}
							else {
								$("#fl-zip2").removeClass("fl-input");
								$("#fl-zip2").addClass("redborder");
								$("#fl-zip2").css( "padding", "5px" );
							}

							alert('Please enter a valid US ZIP Code');
							vcn_toggleFllinks(section,'off');
							if (section == 1)
								document.searchform.f1-zip1.focus();
							else
								document.searchform.f1-zip2.focus();
                            return false;
                          }
            });
	/*
	if (!zip || zip.length!=5) {
		alert('Please enter a valid US zipcode.');
		vcn_toggleFllinks(section,'off');
		return false;
	}
	*/

}
function vcn_FlSelect1(onetcode,zip,which)
{

	document.getElementById('select1div').innerHTML='Displayed below are the typical training, license, legal, physical and medical/health requirements in your state associated with the career you have chosen. The most common industry-based certifications are also displayed.';

	document.getElementById('select2div').innerHTML='Displayed below are the programs associated with the career and credentials you have chosen.';


	if (occupations[onetcode]!=undefined)
		var awlevel  = occupations[onetcode]['awlevel'];



	if(onetcode) $('#onetcode').val(onetcode);
	if(zip)      $('#zip').val(zip);
	if(awlevel)  $('#awlevel').val(awlevel);

	$('#fl-occ2').val(onetcode);
	$('#fl-zip2').val(zip);
	//alert(awlevel + + $('#fawlevel').val());
	if (awlevel == $('#fawlevel').val())
 	$('#fawlevel').val(awlevel);

	if (which=='only1')
	$('#fawlevel').val("");
  	//$('#fl-licenselink').attr('href', 'javascript:void(0);');
  	//$('#fl-certificationlink').attr('href', 'javascript:void(0);');
  	$("#fl-programs").html('');


 	var text = $('#fawlevel option:selected').text();

	text = awlevels[awlevel];

	if (onetcode) {
		text = occupationslist[onetcode]['education'];
		//text = text.split(' - ');
		//text = text[0];

		//text = text.split(' (');
		//text = text[0];
	}

	 if (text)
  	 	$('#fl-mintraining').html('<p><strong>Typical Training for this career: </strong><br />' + text + '</p>');
	else
		$('#fl-mintraining').html('<p><strong>Typical Training for this career: </strong><br />Typical Training for this career is unavailable.</p>');

	vcn_toggleFllinks(1,'on');
	vcn_toggleFllinks(2,'off');

	if (onetcode && zip)
	{
		$('#loading').removeClass('off');
		$.ajax({
			type: "POST",
			url: base_path + "training/find-detail/1",
			data: $("#training-form").serialize(),
			success: function(data)
			{
				$('#loading').addClass('off');
				var content = eval('(' + data + ')');
				$("#fl-licenses").html(content["licenses"]);
				$("#fl-certifications").html(content["certifications"]);
				$("#fl-legal").html(content["legal"]);
				$("#fl-medical").html(content["medical"]);


				var awurl = '<?php echo $awurl; ?>';
				
				if (awurl!='')
					document.getElementById('select2div').scrollIntoView();
					
				if (document.getElementById('fl-certifications').innerHTML.indexOf('No certification')>0)
					document.getElementById('fl-certificationlink').style.display='none';
				else
					document.getElementById('fl-certificationlink').style.display='block';					
					


	 		},
			error: function (xmlhttp) {}
 		});
	}
 	return true;
}
function vcn_FlSelect2(onetcode,zip)
{
	var distance = $('#fl-distance').val();
	var awlevel  = $('#fawlevel').val();

		var q = "<?php echo $vars['q']; ?>";

		var qarr = q.split("/");


		for (var i=0; i<qarr.length; i++) {
			var thenext = (i+1);


			if (qarr[i]=='awlevel') {
				awlevel=qarr[thenext];
				$('#fawlevel').val(awlevel);
			}

			if (qarr[i]=='radius') {
				distance=qarr[thenext];
				$('#fl-distance').val(distance);
			}



		}


	if(onetcode) $('#onetcode').val(onetcode);
	if(zip)      $('#zip').val(zip);
	if(distance) $('#distance').val(distance);
	if(awlevel)  $('#awlevel').val(awlevel);



	$('#fl-occ1').val($('#fl-occ2').val());
	$('#fl-zip1').val($('#fl-zip2').val());
//	$('#fl-programlink').attr('href', 'javascript:void(0);');

	vcn_toggleFllinks(2,'on');

	if (onetcode && zip )
	{
		$('#loading').removeClass('off');
	    $.ajax({
			type: "POST",
			url: base_path + "training/find-detail/2",
			data: $("#training-form").serialize(),
			success: function(data)
			{
				if (document.getElementById('fl-licenses').innerHTML!='')
					$('#loading').addClass('off');
				var content = eval('(' + data + ')');
				$("#fl-programs").html(content["programs"]);

		
				var awurl = '<?php echo $awurl; ?>';
				
				if (awurl!='')
					document.getElementById('select2div').scrollIntoView();

		 	},
			error: function (xmlhttp) {}
	 	});
	}


 	return true;
}

function vcn_toggleFllinks(section, state)
{
	if (state == 'on')
 		$('.fl-links'+section).removeClass('off');
 	else
		$('.fl-links'+section).addClass('off');
}

function numericonly(evt) {

	var key = (evt.which) ? evt.which : event.keyCode;

	if (key!=45 && key > 31 && (key < 48 || key > 57))
		return false;

	return true;

	//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
}

function gotourl(value) {
	var base_path = vcn_base_path();
	
	if (value=='l') {
		var url = base_path+'find-learning/results/licenses/onetcode/' + $('#onetcode').val()+'/zip/'+  $('#fl-zip1').val() +'/distance/'+$('#fl-distance').val()+'/awlevel/'+$('#fawlevel').val();
		//window.open(url,'_self');

		$('#fl-licenselink').attr('href', url);

	}
	if (value=='c') {
		var url = base_path+'find-learning/results/certifications/onetcode/' + $('#onetcode').val()+'/zip/'+  $('#fl-zip1').val() +'/distance/'+$('#fl-distance').val()+'/awlevel/'+$('#fawlevel').val();
		//window.open(url,'_self');

		$('#fl-certificationlink').attr('href', url);
	}
	if (value=='p') {
		var url = base_path+'find-learning/results/programs/onetcode/' + $('#onetcode').val()+'/zip/'+  $('#fl-zip2').val() +'/distance/'+$('#fl-distance').val()+'/awlevel/'+$('#fawlevel').val();
		//window.open(url,'_self');

		$('#fl-programlink').attr('href', url);
	}

}

function highorgedtext(value) {

if (!value)
	document.getElementById('high-or-ged-text').innerHTML='Educational attainment is important in qualifying for healthcare careers, and graduation from High School is the minimum starting point for most of those careers.';

if (value=='Yes')
	document.getElementById('high-or-ged-text').innerHTML='You have a good starting point. You can identify the credentials you need by viewing the Professional Credentials and Requirements below for the career you have chosen and then find schools and programs that lead to attainment of that credential.';

// NOTE: This really needs to be dynamic and pull these values from the DB, but for now we will leave them as hardcoded due to time constraints
if (value=='No')
	document.getElementById('high-or-ged-text').innerHTML='Your choice of healthcare careers is limited at this time. Only a very few healthcare careers have entry level positions that do not require at least high school graduation or GED. ' +
														  'These include:' +
														  '<ul>' +
														  '<li><a href="<?php echo base_path(); ?>careerdetails?onetcode=53-3011.00">Ambulance Driver and Attendant (not EMT)</a></li>' +
														  '<li><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2051.00">Dietetic Technician</a></li>' +
														  '<li><a href="<?php echo base_path(); ?>careerdetails?onetcode=29-2041.00">Emergency Medical Technician and Paramedic</a></li>' +
														  '<li><a href="<?php echo base_path(); ?>careerdetails?onetcode=31-1011.00">Home Health Aide</a></li>' +
														  '<li><a href="<?php echo base_path(); ?>careerdetails?onetcode=39-9021.00">Personal Care Aide</a></li>' +
														  '</ul>' +
														  'However, don\'t worry. <a href="<?php echo base_path(); ?>online-courses/take-online?state=A" toptions="type = iframe, width = 1000, height = 550, resizable = 1, layout=flatlook, title=Take a Course Online, scrolling=yes, shaded=1">Click here</a> to find the information that can help you obtain a High School diploma or GED.';
}



</script>
<script type="text/javascript" src="<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/javascripts/top_up-min.js"></script>
<script type="text/javascript">
  //TopUp.host = "http://<?php //echo $_SERVER["SERVER_NAME"]; /";?>
  TopUp.host = 	window.location.protocol+"//"+window.location.host+"/";
  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";
  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";
</script>


<div id="training-content" class="panel-2col panel-col-first">
	<?php echo $content['main'];?>

	<table class="vcn-table find-learning" style="margin-top:0px;">

 	<thead>
   		<tr valign="top">
        	<th align="left" width="240px">Career Moves</th>
         	<th align="left" width="240px">Explanation</th>
    	</tr>
   	</thead>
   	<tr>
		<td class="left">
		<p><label class="fl-input" for="highorged"><strong>Do you have a High School Diploma or a GED?</strong></label>
		</p>
		<p>
		<select class="fl-input" name="highorged" id="highorged" style="width:100px;margin-left:68px;">
			<option value=""></option>
			<option value="Yes" <?php if ($gedvalue=="Yes") echo 'selected="selected"'; ?>>Yes</option>
			<option value="No" <?php if ($gedvalue=="No") echo 'selected="selected"'; ?>>No</option>
		</select>
		</p>	
		<p>
		<a href="javascript:void(0);" class="fl-select" onclick="highorgedtext(document.getElementById('highorged').value);"></a>
		</p>		
		</td>
		<td class="right">
		<div id="high-or-ged-text"></div>
		</td>
	</tr>
	<tr>		
   		<td class="left">
   			<p><strong>View Professional Credentials and Requirements</strong></p>
   			<p>
   			<label class="fl-label"  for="fl-occ1"><strong>Career:</strong></label>
   			<select style="position:absolute; height:30px;" class="fl-input wide" name="fl-occ1" id="fl-occ1" onblur="$('#onetcode').val(this.value);" <?php if (strstr($browser, 'Chrome')) echo 'style="width:189px;"'; ?>>
   			<option value='' selected>Select a Career</option>
   			<?php
   				foreach ($occupationslistsorted as $key=>$value)
   				{
   					echo '<option value="'.$key.'">'.$value.'</option>';
   				}
   			?>
   			</select>
   			</p>
			<br/><br/>
   			<p>
    		<label class="fl-label" for="fl-zip1"><strong>Zip:</strong></label>
   			<input class="fl-input" type="text" name="fl-zip1" id="fl-zip1" maxlength="5" onblur="$('#zip').val(this.value);" onkeypress="return numericonly(event);" onkeydown="if (event.keyCode==13) { vcn_validateFindLearning(1); }" value="<?php echo $vars['zip'];?>" />
   			</p>
   			<p><a href="javascript:void(0);" class="fl-select" onclick="vcn_validateFindLearning(1);"></a></p>

   		</td><td class="right">
    		<p id="select1div">Find out if an industry-based certification, license, legal, physical and medical/health requirements are required in your state based on the career you have chosen.</p>

    		<div id="fl-mintraining" class="fl-links1 off"></div>
     		<div id="fl-licenses" class="fl-links1 off"></div>
    		<a id="fl-licenselink" class="fl-links1 off" onclick="gotourl('l');" href="" alt="licenses" title="licenses">View More Licenses</a>
    		<br />
    		<div id="fl-legal" class="fl-links1 off"></div>
    	 	<br />
    	 	<div id="fl-medical" class="fl-links1 off"></div>
    		<br />
    		<div id="fl-certifications" class="fl-links1 off"></div>
      		<a id="fl-certificationlink" class="fl-links1 off" onclick="gotourl('c');" href="" style="display:none;">View More Certifications</a>
     	</td>
   	</tr>
   	<tr>
   		<td>
   			<p><strong>Choose Your Program & School</strong></p>
    		<p>
   			<label class="fl-label" for="fl-occ2"><strong>Career:</strong></label>
   			<select style="position:absolute; height:30px;" class="fl-input wide" name="fl-occ2" id="fl-occ2" onblur="$('#onetcode').val(this.value);" <?php if (strstr($browser, 'Chrome')) echo 'style="width:189px;"'; ?>>
   			<option value='' selected><strong>Select a Career</option>
   			<?php
   				foreach ($occupationslistsorted as $key=>$value)
   				{
   					echo '<option value="'.$key.'">'.$value.'</option>';


   				}
   			?>
   			</select>
   			</p>
			<br/><br/><br/>
   			<label class="fl-label"  for="fawlevel"><strong>Award<br/> Level:</strong></label>
   			<select style="position:absolute; height:30px; <?php if (strstr($browser, 'MSIE 8.0')) echo 'margin-left:68px;'; ?>" class="fl-input wide" id="fawlevel" onchange="$('#awlevel').val(this.value);"<?php if (strstr($browser, 'Chrome')) echo 'style="width:189px;"'; ?>>
   			<option value='0'>All Award Levels</option>
			
			<?php 
			$includes = drupal_get_path('module','vcn').'/includes';

			require_once($includes . '/vcn_common.inc');

			$catlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','category','list');

			$catcount=-1; foreach ($catlist->category as $k=>$v): $catcount++; if ($catlist->category[$catcount]->educationcategoryid<4) continue;  ?>
			<option value="<?php echo $catlist->category[$catcount]->educationcategoryid; ?>"><?php echo $catlist->category[$catcount]->educationcategoryname; ?></option>
			<?php endforeach; ?>	

    		</select>

   			</p>
			<br/><br/>
   			<p>
   			<label class="fl-label"  for="fl-zip2"><strong>Zip:</strong></label>
   			<input class="fl-input" type="text" name="fl-zip2" id="fl-zip2" maxlength="5" onkeypress="return numericonly(event);" onkeydown="if (event.keyCode==13) { vcn_validateFindLearning(2); }" onblur="$('#fzip').val(this.value);$('#zip').val(this.value);" value="<?php echo $vars['zip'];?>" />
   			</p>

  			<p>
			<label for="fl-distance" class="fl-label"><strong>Radius:</strong></label>
 			<select id="fl-distance" name="fl-distance" onchange="$('#distance').val(this.value);" style="padding:4px 5px; border:1px solid #000;">
	 		<?php
				$distance_array = array('5','15','25','50','100','250','500');
				foreach ($distance_array AS $key) {
					$selected = (array_key_exists('distance',$vars) && trim($vars['distance'] == $key ) ) ? 'selected="selected"' : false;
					echo '<option value="'.$key.'" '.$selected.'>'.$key.' miles</option>';
				}
			?>
	 		</select>
   			</p>

   		<!-- 	<p><a href="" class="fl-select"  onclick="$('#zip').val($('#fl-zip2').val());$('#fl-zip1').val($('#fl-zip2').val()); $('#onetcode').val($('#fl-occ2').val()); $('#fl-occ1').val($('#fl-occ2').val()); return vcn_validateFindLearning(2);"></a></p>
   			-->
   				<p><a href="javascript:void(0);" class="fl-select" onclick="vcn_validateFindLearning(2);"></a></p>

   		</td>
   		<td class="right">
   			<p id="select2div">Find accredited schools and instructional programs near you based on the career and professional credential you choose.<br>
   			<a href="javascript:popit('http://caahep.org/content.aspx?ID=64')">Things to consider before choosing a program in healthcare.</a></p>
      	  	<div id="fl-programs" class="fl-links2 off"></div>

      	  	<br />
      		<a id="fl-programlink" class="fl-links2 off" onclick="gotourl('p');" href="<?php echo base_path();?>find-learning/results/programs" alt="programs" title="programs">View More Programs</a>
     		</td>
 	</tr><tr>
   		<td>
   			<strong>Financial Aid</strong>
			<br/>
			Find out how much college costs and how you can get help paying for your education and training.
			<!-- 
			<br/><br/>
			(Hint: You might want to explore the federally-funded resources in the right most column first)
			<br />
			 -->
   		</td><td class="right">
   			<p><strong>Need help paying for education and training?</strong><br />
   			<a href="<?php echo base_path();?>find-learning/financialaid" alt="financial aid" title="financial aid">Learn about financial aid options</a>
   			</p>
    	</td>
   	</tr>
	<tr>
   		<td>
   			<strong>Apply Now</strong>
   			<br />
   			When you are ready, the VCN can help you complete your college application.  
   			Click on one or more of the resources in the box to the right.
   		</td><td class="right">
   		 	<div id="fl-courses" class="fl-links2 off">
   		  	</div>
   			<ul>
				<li>
    			<a id="fl-courselink3" class="fl-links1 " href="javascript:popit('http://www.collegeboard.com/student/apply/the-application/115.html')" alt="courses" title="courses">College Board</a>
				</li>

				<li>
   				<a id="fl-courselink" class="fl-links1" href="javascript:popit('http://admissionpossible.com/Completing_Applications.html')" alt="courses" title="courses">Admission Possible</a>
				</li>

				<li>
    			<a id="fl-courselink2" class="fl-links1 " href="javascript:popit('http://www.drexel.com/tools/transcript.aspx?process=alpha&letter=A')" alt="courses" title="courses">Where to get Transcripts</a>
				</li>
			</ul>
      	</td>
   	</tr>
   	</table>
</div>

<div id="training-sidebar" class="panel-2col panel-col-last">
	<?php echo $content['sidebar']; ?>
</div>

<div style="display: none;" id="zipod">


</div>