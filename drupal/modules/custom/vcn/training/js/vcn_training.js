/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 


$(document).ready(function(){
	$(".sortable, .sortableAsc, .sortableDesc").click(function(e) {  
		trainingSort($(this));
  	});
 });

 
// Trying simpler approach
function _saveOrTargetToCMA (link, type, idname, id)
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
				saveOrTargetToCMA('http://'+location.host+ base_path+'cma/notebook/target/career/'+ onetcode,'careers','onetcode',onetcode);
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
		     alert(html);
		   },
		   error: function (xmlhttp) {
		     alert('An error occured: ' + xmlhttp.status);
		   }
	});
	return false;
}

function backToResults(idname) {
	// remove all ids
	$('#program_id').val('');
	$('#cipcode').val('');
	$('#cert_id').val('');
	$('#licenseid').val('');
	$('#course_id').val('');
	
  	$('#training-form').submit();
   	return false;	
}
function searchMyNeighborhood(idname) {
	$('#'+idname).val('');
	if (idname=='licenseid')
	{
		$('#stfips').val('');
	}
	$('#zip').val(cma.zipcode);
	$('#fzip').val(cma.zipcode);

 	$('#training-form').submit();
   	return false;	
}

function submitToLink(link, type, idname, id) {
 	$('#training-form').attr('action',link.href) ;
 	$('#training-form').attr('onsubmit','') ;
 	$('#training-form').submit();
  	return false;	
}
 
function selectTrainingTab(tab, url)
{

	url = url.replace(/programs/i, tab);
	url = url.replace(/certifications/i, tab);
	url = url.replace(/licenses/i, tab);

	//alert(url);
	window.open(url,'_self');
	
	return false;
 	$('#type').val(tab);
 	$('#order').val($('#order_'+tab).val());
	$('#direction').val($('#direction_'+tab).val());
	$('#pg').val($('#pg_'+ tab).val());
	//if (filterTraining($('#training-form')) == true) 
	$('#training-form').attr('action',url) ;
	$('#training-form').submit();
   	return false;
}
 
function selectTrainingPage(page,sessionpage){

$('#trpage').val(page);

	type = $('#type').val();
    $('#pg').val(page);
    $('#pg_'+ type).val(page);
	
	if (document.getElementById('fawlevel') && document.getElementById('fawlevel')) {
		document.getElementById('fawlevel').value = document.getElementById('awlevel').value;
		document.getElementById('fdistance').value = document.getElementById('distance').value;
		document.getElementById('fzip').value = document.getElementById('zip').value;
		if (!document.getElementById('awlevel').value) {

		var myDDL = $('#fawlevel');
		myDDL[0].selectedIndex = 0;

		}
		if (!document.getElementById('distance').value) {

		var myDDL = $('#fdistance');
		myDDL[0].selectedIndex = 0;

		}	
	}
	if (document.getElementById('fstfips')) {
		document.getElementById('fstfips').value = document.getElementById('stfips').value;
		if (!document.getElementById('stfips').value) {

		var myDDL = $('#fstfips');
		myDDL[0].selectedIndex = 0;

		}			
	
	}

	updateTrainingGrid();
	return false;
}

function shouldipaginate(pg) {

if ($('#trpage').val())
pg = $('#trpage').val();
	
return pg;
}
function validateZip(field) {
	$('#zip').val($('#fzip').val()); 
	
	zip = $('#zip').val();
	if (field)
	{
		zip=$('#'+field).val();
	}	
	if (zip == '' || zip == undefined)
	{
		alert('Enter a ZIP Code to filter by location.');
		return false;
	}
   $('#stfips').val(''); 
	return true;
}
function trainingSetProgramsOrder (order) { 
	 if (order == 'School Name') {
		 $('#order').val('instnm');
	 }
	 else if (order == 'Distance') {
		 $('#order').val('distance');
 	 }
	 else if (order == 'Program Name') {
		 $('#order').val('program_name');
 	 }
	 else if (order == 'Program Length') {
		 $('#order').val('awlevel');
 	 }
	 else if (order == 'Status') {
		 $('#order').val('status');
 	 }
	 else if (order == 'Program Length') {
		 $('#order').val('awlevel');
 	 }
	 else if (order == 'Program Description') {
		 $('#order').val('program_description');
 	 }	 
	 else if (order == 'Award Level') { 
		 $('#order').val('awlevel');
 	 }
	 else  {
		 $('#order').val('');
	 }	
	 $('#order_programs').val($('#order').val());
}
function trainingSetCertificationsOrder (order) {
	 if (order == 'Certification Name') {
		 $('#order').val('cert_name');
	 }
	 else if (order == 'Type') {
		 $('#order').val('cert_type_name');
	 }
	 else if (order == 'Certifying Organization') {
		 $('#order').val('org_name');
	 }
  	 else  {
		 $('#order').val('');
	 }	
	 $('#order_certifications').val($('#order').val());
}
function trainingSetLicensesOrder (order) {
	 if (order == 'License Name') {
		 $('#order').val('lictitle');
	 }
	 else if (order == 'Licensing Agency') {
		 $('#order').val('name1');
	 }
	 else  {
		 $('#order').val('');
	 }	
	 $('#order_licenses').val($('#order').val());
}
function trainingSetCoursesOrder (order) {
	 if (order == 'School Name') {
		 $('#order').val('instnm');
	 }
	 else if (order == 'Distance') {
		 $('#order').val('distance');
 	 }
	 else if (order == 'Course Title') {
		 $('#order').val('course_title');
	 }
	 else if (order == 'Type') {
		 $('#order').val('CT.description');
	 }
	 else if (order == 'Access') {
		 $('#order').val('cdm.name');
	 }
	 else if (order == 'Subject Area') {
		 //$('#order').val('SJA.subject_area');
                 $('#order').val('SJA.description');
	 }
	 else  {
		 $('#order').val('');
	 }	
	 $('#order_courses').val($('#order').val());
}
function trainingSetVhsOrder (order) {
	 if (order == 'Name') {
		 $('#order').val('instnm');
	 }
 	 else if (order == 'State') {
		 $('#order').val('stabbr');
	 }
	 else  {
		 $('#order').val('');
	 }	
	 $('#order_vhs').val($('#order').val());
}

function trainingSetDirection (obj, type, direction) {
 	if (direction == 'sortableAsc') {
		obj.attr('class','sortableDesc');
		$('#direction').val('Desc');  
  	}
	else {
	  obj.attr('class','sortableAsc');
	  $('#direction').val('Asc');  
 	}
		
	if (type == 'programs')       $('#direction_programs').val($('#direction').val());
	if (type == 'certifications') $('#direction_certifications').val($('#direction').val());
	if (type == 'licenses')       $('#direction_licenses').val($('#direction').val());
	if (type == 'vhs')            $('#direction_vhs').val($('#direction').val());
	if (type == 'courses')        $('#direction_courses').val($('#direction').val());
	  
}

function trainingSort(obj) {
 
	var type  = $('#type').val();
	var order = obj.html();
	var direction   = obj.attr('class');
	 
	$(".sortableAsc, .sortableDesc").each(function(index)  {
		$(this).attr('class','sortable');
	});

	if (type == 'programs') {
		trainingSetProgramsOrder(order);
	}
	if (type == 'certifications') {
		trainingSetCertificationsOrder(order);
	}
	if (type == 'licenses') {
  		trainingSetLicensesOrder(order);
 	}
	if (type == 'courses') {
   		trainingSetCoursesOrder(order);
 	}
	if (type == 'vhs') {
   		trainingSetVhsOrder(order);
 	}
 
	trainingSetDirection(obj,type, direction)
	updateTrainingGrid();
 
}

function updateTrainingGrid() {
	type = $('#type').val();
 
 	$.ajax({
		type: "POST",
		url: base_path+"training/training-grid/"+ type,
		data: $("#training-form").serialize(),
		   	success: function(data){
		   	$("#training-grid-data").html(data); 
		}
	});
	
	 
 	return true;  
}

function updateCoursesGrid() {
	type = $('#type').val();
  	$.ajax({
		type: "POST",
		url: base_path+"training/course-grid/"+ type,
		data: $("#course-form").serialize(),
		   	success: function(data){
		   	$("#training-grid-data").html(data); 
 		}
	});
	 
 	return true;  
}


function suggest(inputString, event)	{
 	var len = inputString.length; 
	
	if (event && event.keyCode == 13) { 
		if (suggestionslist( $('#keycount').val())) {
			$('#fjobtitle').val( suggestionslist(inputString,$('#keycount').val()) );
		}
		$('#keycount').val('-1');
		$('#suggestions').fadeOut(); 
	} 	    
 	if(len == 0) 
	{
			$('#suggestions').fadeOut();
 	}
 	else 
	{
 	  	var string = '';
	 	    var count  = 0;
		
	 	  	for (var l in laytitles)
 	 	{
		 	 	index = l.toLowerCase().search(inputString.toLowerCase());
	 	 		if (index > -1 )	 
  	 	 	{  
				newl = l.substr(0,(index)) + '<strong style="color: #f16b4e;">' + l.substr((index),len) + '</strong>' + l.substr((index + len));
	  	  	 		string = string + '<li id=li'+count+' onClick="fill(\''+ laytitles[l] + '\',\''+ l + '\'); ">' + newl +'</li>';
  	  	 	 	count++;
  	 		}   
  	 	 	if (count > 10 )   
 	 	 	break;
 		}
	 	
	 		if (string) {
	 			string = '<ul>'+ string + '</ul>';
	 	  		$('#suggestions').html(string);
 			$('#suggestions').fadeIn();
 		}
 	}
 	if (event)
 	{
	 	if ((event.keyCode==38 || event.keyCode==40) && inputString) {
			if (event.keyCode==38 && document.getElementById('keycount').value>0) {
				$('#keycount').val(parseInt($('#keycount').val()) - 1 );
				$('#jobtitle').val( suggestionslist(inputString,$('#keycount').val()) );
			}
			if (event.keyCode==40 && document.getElementById('keycount').value>=-1 && document.getElementById('keycount').value<=8) {
				$('#keycount').val(parseInt($('#keycount').val()) + 1 );
				$('#jobtitle').val( suggestionslist(inputString,$('#keycount').val()) );
			}
			$('#li'+ $('#keycount').val()).css('background','#D5E2FF');
		}
	}
 	return false;
}


function fill(onetcode, thisValue) {
	$('#onetcode').val(onetcode);
	$('#occupation-title').val(thisValue);
	$('#fjobtitle').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 5);
	if (document.getElementById('keycount').value>-1)
		checkKeycode();
	$('#keycount').val( parseInt($('#keycount').val()) + 1 );
}

function setonet(thisValue) {
  	$('#onetcode').val(thisValue);
}



function suggestionslist(inputString,number) {
	var count=0;
	var string=new Array();
	var stringcodes=new Array();
	for (var l in laytitles) {
		index = l.toLowerCase().search(' '+inputString);
		index2 = l.toLowerCase().search(inputString);
		if ((index > -1) || (index2 > -1 )) 
		{
			string[count] = l;
			stringcodes[count] = laytitles[l];
	  	 	count++;
	 	 }   
	 	 if (count > 9 ) {	break; 	 }
	}

	if (count==10 && stringcodes[number]) {
		$('#onetcode').val( stringcodes[number] );
	}
 	return string[number];
}

function checkKeycode() {
	var keycode;
	if (window.event) keycode = window.event.keyCode;
 	$('#jobtitle').val( suggestionslist($('#jobtitle').val(),$('#keycount').val()) );
	$('#keycount').val(parseInt($('#keycount').val()) - 1 );
}
/*
function setvalues() {
	$('#suggestions').fadeOut();
	$('#fjobtitle').val('');
	$('#onetcode').val('');
	$('#keycount').val('-1');
	//document.searchform.action = "javascript:return false;";		
}
*/

function filterTraining (trainingForm) {
 	var onetcode = $('#onetcode').val();
	var jobtitle = $('#occupation-title').val();
	var unitid   = $('#unitid').val();
	var type = $('#type').val();
	var trainingurl = base_path+'find-learning/results/' + type + '/';
 	var onetrequired = {'programs':'','certifications':'','licenses':''}
 	$('#zip').val($('#fzip').val()); 
 	// check programming filter which is required
	if ( onetcode == '' && unitid== '' && type in onetrequired) {
			alert('Career title required '+ type);
			return false;
	} 
	else if ( onetcode !== '' &&  type in onetrequired) {
 		// get length		
		len = jobtitle.length;
		found = false;
		for (var key in laytitles) {
    		if (key.toLowerCase() == jobtitle.toLowerCase() ) {
                onetcode=laytitles[key];
				setonet(onetcode);
				found = true;
	   		}
		}
	   	// must not have found a match. No point continuing 
  		if (found == false) {
	  	 	alert('No match found. Please try again.');
			return false;
  		}
	}
	// just one last time. if we still don't have an onet, let's just blame the user and exit.
	if (onetcode)
	{
		trainingurl = trainingurl + 'onetcode/' + onetcode + '/';
	}
 
/* 	
 * TODO Fix link
	// program filters 
	if (type == 'programs') {
 		// filter the program length
		var awlevel = $('#awlevel').val();
	 	if (awlevel !== undefined && awlevel !== '') {
	 		trainingurl = trainingurl + 'awlevel/' + awlevel + '/';
	 	}
	
		// filter zip and distance
	 	var zip = $('#zip').val()
	 	if (zip !== undefined && zip !== '') {
			trainingurl =  trainingurl + 'zip/' + zip + '/';
		
			// filter distance	
			var distance = $('#distance').val();
			if (distance !== undefined && distance !== '') {
				trainingurl =  trainingurl + 'distance/' + distance + '/';
			}
			else
			{
				trainingurl =  trainingurl + 'distance/25/';	
			}
		}
 	}
			  
	// license filters
	if (type == 'licenses')
	{ 
		// filter state
		var stfips = $('#stfips').val()
		if (stfips !== undefined && stfips !== '') {
			trainingurl =  trainingurl + 'stfips/' + stfips + '/';
		}
	}
	
	// course filters
	if (type == 'courses')
	{ 
		// filter state
	}
 */
   	$('#training-form').attr('action',trainingurl) ;
 	return true;
}

function DeleteRow(objName, index, isDelete) {
	var status = $('#' + objName + 'status' + index);
	var row = $('#' + objName + 'row' + index);

	status.val('UPDATED');
	row.css('display', 'inline');
	
	if (isDelete) {
		status.val('DELETED');
		row.css('display', 'none');
	}
}
function AddRow(objName, tableId) {
	var rows = $('#' + tableId + ' tr').length + 1;
	var textboxsize = (objName == 'test') ? '20' : '15';
	
	var html = '<tr id="' + objName + 'row' + rows + '">' +
			'	<td>' +
			'		<input type="hidden" id="' + objName + 'status' + rows + '" name="' + objName + 'status' + rows + '" value="ADDED" />' +
			'		<input type="text" size="' + textboxsize + '" value="" id="' + objName + 'name' + rows + '" name="' + objName + 'name' + rows + '">' +
			'	</td>' +
			'	<td>' +
			'		<input type="text" size="' + textboxsize + '" value="" id="' + objName + 'desc' + rows + '" name="' + objName + 'desc' + rows + '">' +
			'	</td>';
	
	if (objName == 'test') {	
		html += '	<td>' +
				'		<input type="text" size="' + textboxsize + '" value="" id="' + objName + 'minscore' + rows + '" name="' + objName + 'minscore' + rows + '">' +
				'	</td>';
	} else {
		html += '	<td>' +
				'		<input type="text" size="' + textboxsize + '" value="" id="' + objName + 'level' + rows + '" name="' + objName + 'level' + rows + '">' +
				'	</td>' +
				'	<td>' +
				'		<input type="text" size="' + textboxsize + '" value="" id="' + objName + 'mingpa' + rows + '" name="' + objName + 'mingpa' + rows + '">' +
				'	</td>';
	}      
	
	html += '	<td>' +
			'		<img id="' + objName + 'img' + rows + '" onclick="DeleteRow(\'' + objName + '\', ' + rows + ', true);" src="/drupal/sites/all/modules/custom/vcn/training/images/delete.png" alt="Change" style="cursor:pointer;" />' +
			'	</td>' +
			'</tr>';
	
	$('#' + tableId + ' tr:last').after(html);
}
function trshift(what) {
	if (what=='remove') {
		$('#satact td').click(function(){
			$(this).parent().remove();
		});
	}

	var rows = $('#satact tr:visible').length + 1;
	
	if (what=='add') {
		$('#satact tr:last').after('<tr><td><input type="text" size="20" value="" id="testname'+rows+'" name="testname'+rows+'"></td><td><input type="text" size="20" value="" id="testdesc'+rows+'" name="testdesc'+rows+'"></td><td><input type="text" size="20" value="" id="minscore'+rows+'" name="minscore'+rows+'"></td><td><a href="javascript:void(0);" onclick="trshift(\'remove\');"><img src="/drupal/sites/all/modules/custom/vcn/training/images/delete.png" alt="Delete" /></a></td></tr>');

	}
	
}

function trshift2(what) {
	if (what=='remove') {
		$('#precourses td').click(function(){
			$(this).parent().remove();
		});
	}

	var rows = $('#precourses tr:visible').length + 1;
	
	if (what=='add') {
		$('#precourses tr:last').after('<tr><td><input type="text" size="20" value="" id="coursename'+rows+'" name="coursename'+rows+'"></td><td><input type="text" size="20" value="" id="coursedesc'+rows+'" name="coursedesc'+rows+'"></td><td><input type="text" size="20" value="" id="mincoursescore'+rows+'" name="mincoursescore'+rows+'"></td><td><a href="javascript:void(0);" onclick="trshift2(\'remove\');"><img src="/drupal/sites/all/modules/custom/vcn/training/images/delete.png" alt="Delete" /></a></td></tr>');

	}
	
}



