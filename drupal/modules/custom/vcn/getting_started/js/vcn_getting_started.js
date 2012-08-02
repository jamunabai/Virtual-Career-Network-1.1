/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 


$(document).ready(function(){
	$(".vcn-gs-activity-row").click(function(e) {  
		vcn_gs_select_activity($(this));
  	});
 });
var zval;
function vcn_gs_change_activity ( changetype, activity ) 
{
	//alert(window.location.protocol+'//'+window.location.host+base_path);
	// get the current activity
	current_step      = $('#current_step').val();
 	current_activity  = $('#current_activity').val();
	count_activity    = $('#count_activity').val();
	var zipvalueina1s2 = $('#zip').val();
	if (activity == undefined ) activity = current_activity;
	back_activity     = parseInt(activity) - 1;
	next_activity     = parseInt(activity) + 1;

    //To make sure that he page ends up in the top when you move from one activity to the other
    window.scroll(0,1);
    //End of To make sure that he page ends up in the top when you move from one activity to the other

    /*begin: this is to make sure that the step 1 activity 2 will proceed only if the zipcode is present in the hvcp zipcode table*/    
		if(current_step == 'step-one' && current_activity == '3' && changetype == 'nextspecial')
		{
					$('#zipresult').load('/careerladder/zipvalidation.php?zipcode='+zipvalueina1s2, function() {
						var zval = document.getElementById("zipresult").innerHTML;
						
						if(zval == 'true' || zipvalueina1s2 == ''){
							window.open(window.location.protocol+'//'+window.location.host+base_path+'getting-started/step-one/4','_self');
							
						}
					else { alert('Please enter a valid US ZIP Code to proceed');
					return false;  }});
					return false;	
		}
		/*end: this is to make sure that the step 1 activity 2 will proceed only if the zipcode is present in the hvcp zipcode table*/		

	 	switch (changetype)
		{
			case 'skip':
				if (next_activity > count_activity)  return vcn_gs_next_step ();
				activity = next_activity;
			break;
			case 'back':
	 			if ( back_activity < 1 ) return vcn_gs_back_step();
				activity = back_activity;
				// save any data from this activity?
				//vcn_gs_saveUserKey ('GETTINGSTARTED','activity',activity);	
			break;
			case 'next':
		 		if (next_activity > count_activity) return vcn_gs_next_step ();
				activity = next_activity;
				// save any data from this activity?
				//vcn_gs_saveUserKey ('GETTINGSTARTED','activity',activity);			
			break;
			default:
		}


 	
 	if (current_activity == activity) return false;
 	// preprocess
	if (activity < 1 || activity > count_activity)
	{
		alert ('Activity invalid.' + activity);
		return false;
	}
// process the activity change
/*	if (changetype!='default') {
		$('#current_activity').val(activity);
		updateGettingStartedActivity(current_step, activity);
		
		// set up activity screen
		$(".vcn-gs-activity-row").removeClass('selected');
		$("#gs-activity-"+ activity).addClass('selected');
	  
		if ($("#gs-activity-"+ activity).hasClass('off') )
			$("#gs-activity-"+ activity).removeClass('off'); 
	}
	*/
	
	/* To add the url for the ajax changing pages in the getting started page
	 */	
		 	
		$('#loading').removeClass('off');
	 	//pathArray = window.location.pathname.split('/');
	 	//pathHost = window.location.hostname.split('/');
	 	window.open(window.location.protocol+'//'+window.location.host+base_path+'/getting-started/'+current_step+'/'+activity,'_parent');
	 	//$('#loading').addClass('off'); 
	 	//$(document).ready($('#loading').addClass('off');)
	 	
 	return false;
}

/*function checkAlert(){
	var href = document.createElement('a');
	href.setAttribute('href', 'htt://www.google.com');
	href.setAttribute('target', 'new');
}*/

function vcn_gs_select_activity ( activity_row ) 
{
 	//Verify activity is available to user
 	if ( activity_row.hasClass('off') ) return false; 
 	activity = activity_row.children('.vcn-gs-activity-num').html();
 	//activity = activity_row.children('.vcn-gs-activity-button').html();
	//vcn_gs_buttons_off();
	vcn_gs_change_activity ('default', activity);
//	vcn_gs_buttons_on();
}
function vcn_gs_skip_activity () 
{
 	if ($('#vcn-gs-btn-skip').hasClass('off')) return false;
 //	vcn_gs_buttons_off();
 	vcn_gs_change_activity ('skip');
 //	vcn_gs_buttons_on();

 	return false;
}
function vcn_gs_next_activity ( step, current_activity, count_activity ) 
{
	if ($('#vcn-gs-btn-next').hasClass('off')) return false;
	if ($('#vcn-gs-btn-ano-next').hasClass('off')) return false;
//	vcn_gs_buttons_off ();
/*begin: this is to make sure that the step 1 activity 2 will proceed only if the zipcode is present in the hvcp zipcode table*/
	var cs = document.getElementById('current_step').value;
	var ca = document.getElementById('current_activity').value;
	//alert(ca + cs);
	if (ca=='3' && cs=='step-one')
		vcn_gs_change_activity ('nextspecial');
/*end: this is to make sure that the step 1 activity 2 will proceed only if the zipcode is present in the hvcp zipcode table*/	
	else
		vcn_gs_change_activity ('next');
	
// 	vcn_gs_buttons_on();
}
function vcn_gs_back_activity ( step, current_activity, count_activity )
{
	if ($('#vcn-gs-btn-back').hasClass('off')) return false;
	if ($('#vcn-gs-btn-ano-back').hasClass('off')) return false;
	
//	vcn_gs_buttons_off ();
	vcn_gs_change_activity ('back');
//	vcn_gs_buttons_on();
}	
function vcn_gs_buttons_off () 
{
	$('#vcn-gs-btn-skip').addClass('off');
	$('#vcn-gs-btn-next').addClass('off');
	$('#vcn-gs-btn-ano-next').addClass('off');
	$('#vcn-gs-btn-back').addClass('off');
	$('#vcn-gs-btn-ano-back').addClass('off');
	$("#vcn-gs-btn-back").attr('disabled',true);
	$("#vcn-gs-btn-ano-back").attr('disabled',true);
	$("#vcn-gs-btn-next").attr('disabled',true);
	$("#vcn-gs-btn-ano-next").attr('disabled',true);		
}
function vcn_gs_buttons_on () 
{
	current_step      = $('#current_step').val();
 	current_activity  = $('#current_activity').val();

  	// disable buttons
 	if (current_activity == 1 && current_step == 'step-one')
 	{
 		$("#vcn-gs-btn-back").addClass('off');
 		$("#vcn-gs-btn-back").attr('disabled',true);
 		$("#vcn-gs-btn-ano-back").addClass('off');
 		$("#vcn-gs-btn-ano-back").attr('disabled',true); 		
 	}
 	else
 	{
 		$("#vcn-gs-btn-back").removeClass('off');
 		$("#vcn-gs-btn-back").attr('disabled',false);
 		$("#vcn-gs-btn-ano-back").removeClass('off');
 		$("#vcn-gs-btn-ano-back").attr('disabled',false); 		
 	}
 	if (current_activity == 1 && current_step == 'finished')
 	{	
 		$("#vcn-gs-btn-next").addClass('off');
		$("#vcn-gs-btn-next").attr('disabled',true);
 		$("#vcn-gs-btn-ano-next").addClass('off');
		$("#vcn-gs-btn-ano-next").attr('disabled',true);		
	}
	else
	{
		$("#vcn-gs-btn-next").removeClass('off');
		$("#vcn-gs-btn-next").attr('disabled',false);
		$("#vcn-gs-btn-ano-next").removeClass('off');
		$("#vcn-gs-btn-ano-next").attr('disabled',false);		
	}

 	if (current_activity == 6 && current_step == 'step-two')
 	{	
 		$("#vcn-gs-btn-next").addClass('off');
		$("#vcn-gs-btn-next").attr('disabled',true);
 		$("#vcn-gs-btn-ano-next").addClass('off');
		$("#vcn-gs-btn-ano-next").attr('disabled',true);		
	}
}

function updateGettingStartedActivity(step, activity) {
	$('#loading').removeClass('off'); 
	vcn_gs_buttons_off();
	//$('#vcn-gs-btn-next').hide();
	//$('#vcn-gs-btn-back').hide();

	// $("button").click(function(){$("p").html("W3Schools");});
	
	//$("#vcn-gs-btn").html(eval('loading'));
	$.ajax({
	type: "POST",
	url:base_path + "getting-started/ajax/",
	data: $("#form-getting-started").serialize(),
	success: function(data)
	{
	var content = eval('(' + data + ')');
	//alert(content);
	$("#vcn-gs-main-content").html(content["gs_main_content"]);
	$("#vcn-gs-main-note").html(content["gs_main_note"]);
	$("#vcn-gs-main-detail").html(content["gs_main_detail"]);
	$("#vcn-gs-sidebar-detail").html(content["gs_sidebar_detail"]);
	$("#vcn-gs-sidebar-status").html(content["gs_sidebar_status"]);
	$("#vcn-gs-main").focus();
	
//	$('#vcn-gs-btn-next').show();
//	$('#vcn-gs-btn-back').show();
	vcn_gs_buttons_on();
	current_step      = $('#current_step').val();
 	current_activity  = $('#current_activity').val();	
	
		
	$('#loading').addClass('off'); 
	},
	error: function (xmlhttp) {
	getting_started_url = base_path + 'getting-started/' + current_step + '/' + activity;
	$('#form-getting-started').attr('action',getting_started_url) ;
	$('#form-getting-started').submit() ;
	}
	});
	return true;
	}


var getting_started_global_url = "";
current_step_val = 0;
function vcn_gs_change_step ( changetype, step ) 
{
 	// get the current step
 	current_step  = $('#current_step').val();
 	count_step    = 6;
	step_val      = 0;
 	if ( step == undefined ) step = current_step;
 	
	// pre stuff taken out those steps which are needed for the present release 
 	/*step_array    = new Array();
 	step_array[1] = "step-one";
 	step_array[2] = "step-two";
 	step_array[3] = "step-three";
 	step_array[4] = "step-four";
 	//step_array[5] = "step-five";
 	step_array[5] = "finished";*/
 
 	step_array    = new Array();
 	step_array[1] = "step-one";
 	step_array[2] = "step-two";
 	step_array[3] = "step-three";
 	step_array[4] = "step-four";
 	step_array[5] = "step-five";
 	step_array[6] = "finished";
 	step_array[7] = "start";
 	
 	for ( key in step_array ) 
 	{ 
 		if (step_array[key] == current_step)  current_step_val = step_val = key; 
 	}
   	back_step     = parseInt(step_val) - 1;
	next_step     = parseInt(step_val) + 1;
  	
  	switch (changetype)
	{
 		case 'start_over':
 			step_val = 1;
 		break;
 		case 'back':
 			var activity = 1;
 			if(step_val == 2){if(logged_in == true){activity = 4;} else {activity = 5;}} 
 			else if(step_val == 3){activity = 4;}
 			else if(step_val == 4){activity = 7;}
 			else if(step_val == 5){activity = 7;}
 			else if(step_val == 6){activity = 6;}
 			else {activity = 1;}
  			step_val = back_step;
  		break;
		case 'next':
			var activity = 1;
			step_val = next_step;
		break;
		default:

	}
 	
 	// update the new step 
 	step = step_array[step_val];
  	//if ( current_step == step ) return false;
	
	// pre process the step change
 	if ($("#step").hasClass('off') ) return false;
	if (step_val < 1 || step > count_step)
	{
		alert ('Step invalid.');
		return false;
	}
	
	//vcn_gs_saveUserKey ('GETTINGSTARTED','module ',step_array[step_val]);
	//vcn_gs_saveUserKey ('GETTINGSTARTED','activity','1');

	// process the step change
	$('#current_step').val(step);
	$('#current_activity').val(1);
	
	getting_started_global_url = base_path + 'getting-started/'+ step + '/' + activity;  
 
	temp2 = 5 - current_step_val;
	
	if (step_val > current_step_val)
	{
		if(current_step_val == 6){
  				var result = submit_getting_started();
		}else if((current_step_val == 1 && current_activity == 5) || (current_step_val == 1 && current_activity == 4)){
				submit_getting_started();
		}else if (current_step_val == 2 && current_activity == 6){
 			submit_getting_started();
		}
		else 
			submit_getting_started();
 	 }
	 else
	 {
 	 	// set up activity screen
	 	getting_started_url = base_path + 'getting-started/' + step+ '/' + activity ;
	 	$('#form-getting-started').attr('action',getting_started_url) ;
	 	$('#form-getting-started').submit() ;
	 }
			
 	getting_started_url = base_path + 'getting-started/' + step + '/' + activity ;
	return false;
}
function submit_getting_started(){
	$('#form-getting-started').attr('action',getting_started_global_url) ;
 	$('#form-getting-started').submit();
}

function vcn_gs_select_step ( step ) 
{
 	//Verify activity is available to user
 	if ( $('#step').hasClass('off') ) return false; 
   	return vcn_gs_change_activity ('default', step );
}
 
function vcn_gs_next_step (  ) 
{
 	return vcn_gs_change_step ('next');
}
function vcn_gs_back_step ( step, current_activity, count_activity )
{
/*	alert('backstep---'+step);
	vcn_gs_saveUserKey ('GETTINGSTARTED','module ',step);	*/
 	return vcn_gs_change_step ('back');
}	
function vcn_gs_start_over ( step, current_activity, count_activity )
{
	//Next line added to help reset the progress bar back to zero
	vcn_gs_saveUserKey ('GETTINGSTARTED','activity',1);
	vcn_gs_saveUserKey ('GETTINGSTARTED','module',1);
	$('#gs_reset').val('1'); 
  	return vcn_gs_change_step ('start_over');
}	
// HIDE SHOW STATUS DIVS
function vcn_gs_show_status_detail_div (classname, id )
{
 	$('.'+classname).addClass('off');
  	$("#"+id ).removeClass('off');
	return false;
}

function vcn_gs_toggle_main_detail_table (display)
{
 	if (display == 'off')
		$('#vcn-gs-main-detail table').addClass('off');
	else
		$('#vcn-gs-main-detail table').removeClass('off');
	return false;
}

//Trying simpler approach
function vcn_gs_saveOrTargetToCMA (link,type,idfield,id,namefield,name)
{
 	// check if type is program
	var onetrequired = {'programs':'','certifications':'','licenses':''}
	 
 	// check programming filter which is required
	var onetcode = $('#onetcode').val();
	var occupation_title = $('#occupation-title').val();
	var target_onetcode  = $('#target_onetcode').val();
	var target_occupation_title = $('#target_occupation-title').val();
	var cmaUrl ;
	if (link.href) { cmaUrl = link.href.split('?'); }
	else { cmaUrl = link.split('?'); }
	 
	var target = cmaUrl[0].toLowerCase().search('target');
 	if ( type in onetrequired && target > -1 )
	{
	 	if (target_onetcode == '')
		{
			saveOrTargetToCMA('http://'+location.host+base_path+'cma/notebook/target/career/'+onetcode,'careers','onetcode',onetcode);
		}	
		else if (onetcode !== target_onetcode)
		{	
			var text = 'The '+ type.substring(0, type.length-1)  + ' you are selecting is for a career as a '+ occupation_title;
					    text = text + ' which is not your currently targeted career of ' +  target_occupation_title;
					    text = text + '. Click OK to change your targeted career or CANCEL to continue browsing programs.';
			var answer = confirm(text);
			if (answer)
			{
				vcn_saveOrTargetToCMA('http://'+location.host+base_path+'cma/notebook/target/career/'+ onetcode,'careers','onetcode',onetcode);
				$('#target_onetcode').val(onetcode);
				$('#target_occupation-title').val(occupation_title);
			}
			else
			{
				return false;
			}
		}
	}	

	$.ajax({
		   type: "POST",
		   url: cmaUrl[0],
		   dataType: "html",
		   success: function (html) {
			$("#"+idfield).val(id);
			$("#"+namefield).val(name);	
			text='<span>'+ type + ': </span>' + name;
		    $("#vcn-gs-target-" + namefield ).html(text);
		   },
		   error: function (xmlhttp) {
			   //Todo get this one back
			   // alert('An error occured: ' + xmlhttp.status);
		   }
	});
 
	return false;
}

function vcn_gs_saveUserKey (module,label,value,key  )
{
	var name = label.toLowerCase().split(' ').join('');
  	var keyUrl = base_path+'cma/user-key/save/'+module+'/'+name+'/'+value;
	if (key) keyUrl = keyUrl+'/'+key;
	
	text='<span>'+ label + ': </span>' + value;
	$("#vcn-gs-uk-" + name ).html(text);
 	$.ajax({
 		type: "POST",
		url: keyUrl,
		dataType: "html",
			success: function (html) {
			//	alert(html);
			},
			error: function (xmlhttp) {
				//Todo get this one back
				//alert('An error occured: ' + xmlhttp.status);
			}
	});
	return false;
}

function vcn_gs_saveToCMA (name, value)
{
	var cmaUrl = base_path+'cma/user-info/update/'+name
	if(value) cmaUrl = cmaUrl +'/'+value;
  	$.ajax({
		   type: "POST",
		   url: cmaUrl,
		   dataType: "html",
		   success: function (html) {
 		//     alert(html);
		   },
		   error: function (xmlhttp) {
			 //Todo get this one back
		     //alert('An error occured: ' + xmlhttp.status);
		   }
	});
	return false;
}
/*
 * google maps for the zip code in the M1-A2 prashanth
 */
function vcn_gs_show_address(zipcode) {
	var map = new GMap2(document.getElementById("vcn-gs-map-canvas"));
	var geocoder = new GClientGeocoder();
 	var address = zipcode;
 	
	  geocoder.getLatLng( address,
	    function(point) {
	      if (!point) {
	        alert(address + " not found");
	      } else {
	        map.setCenter(point, 13);
	        var marker = new GMarker(point);
	        map.addOverlay(marker);

	        // As this is user-generated content, we display it as
	        // text rather than HTML to reduce XSS vulnerabilities.
	     //   marker.openInfoWindow();
	      }
	    }
	  );
//	  alert(zipcode);
}


 function save_zip_code_to_cma (link, id)
{

	var cmaUrl = link.href.split('?');
	value = $('#'+id).val();
	value = value.trim();
	cmaUrl = cmaUrl+value;	
 	$.ajax({
		   type: "POST",
		   url: cmaUrl,
		   dataType: "html",
		   success: function (html) {
//		     alert(html);
		   },
		   error: function (xmlhttp) {
			 //Todo get this one back
		     //alert('An error occured: ' + xmlhttp.status);
		   }
	});
	return false;
}
 
 // Samana's Section
 
 function showquestions(page)
 {

	 if (page==1)
		{
		 $('#pq1').show();
		 $('#pq2').show();
		 $('#pq3').show();
		 $('#pq4').hide();
		 $('#pq5').hide();
		 $('#pq6').hide();
		 $('#pq7').hide();
		 $('#pq8').hide();
		 $('#pq9').hide();
		 $('#pq10').hide();
		 
		 $('#quizpagination').css( "margin-top","10px" );

		 $('#quizpage1').css( "text-decoration","none" );
		 $('#quizpage1').css( "color","#000000" );
		 $('#quizpage2').css( "color","#A71E28" );
		 $('#quizpage3').css( "color","#A71E28" );
		 $('#quizpage2').css( "text-decoration","underline" );
		 $('#quizpage3').css( "text-decoration","underline" );
		 
		  $('#step-1-actvity-3-sidebar-content').height(463); 
		}
	 if (page==2)
	 	{
		 $('#pq1').hide();
		 $('#pq2').hide();
		 $('#pq3').hide();
		 $('#pq4').show();
		 $('#pq5').show();
		 $('#pq6').show();
		 $('#pq7').hide();
		 $('#pq8').hide();
		 $('#pq9').hide();
		 $('#pq10').hide();
		 
		 $('#quizpagination').css( "margin-top","4px" );
		 $('#quizpage2').css( "text-decoration","none" );
		 $('#quizpage2').css( "color","#000000" );
		 $('#quizpage1').css( "color","#A71E28" );
		 $('#quizpage3').css( "color","#A71E28" );		 
		 $('#quizpage1').css( "text-decoration","underline" );
		 $('#quizpage3').css( "text-decoration","underline" );
		 
		 $('#step-1-actvity-3-sidebar-content').height(463); 
	 	}
	 if (page==3)
	 	{
		 $('#pq1').hide();
		 $('#pq2').hide();
		 $('#pq3').hide();
		 $('#pq4').hide();
		 $('#pq5').hide();
		 $('#pq6').hide();
		 $('#pq7').show();
		 $('#pq8').show();
		 $('#pq9').show();
		 $('#pq10').show();
		 
		 $('#quizpagination').css( "margin-top","10px" );
		 $('#quizpage3').css( "text-decoration","none" );
		  $('#quizpage3').css( "color","#000000" );
		 $('#quizpage1').css( "color","#A71E28" );
		 $('#quizpage2').css( "color","#A71E28" );		  
		 $('#quizpage1').css( "text-decoration","underline" );
		 $('#quizpage2').css( "text-decoration","underline" );
		 
		 $('#step-1-actvity-3-sidebar-content').height(482); 
		 
	 	}
	 
 }
 
 //javascript:window.history.forward(1);