/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 


	
var base_path = vcn_base_path();

function vcn_base_path()
{
	var pathname = location.pathname.split('/');
	var base_path = '/'+ pathname[1] + '/';
	return base_path;
}

// Unified autosuggest
(function($){
	$.fn.vcn_autoSuggest = function(data, options) {
		var defaults = { 
 		};  
		var opts = $.extend(defaults, options);	 	
			
	
	}
})(jQuery); 


 

// Trying simpler approach
function vcn_saveOrTargetToCMA (link, type, idname, id, ignorealert, message, cmaid)
{ 
 	// check if type is program
	var onetrequired = {'programs':'','certifications':'','licenses':''}
	 
 	// check programming filter which is required
	var onetcode = $('#onetcode').val();
	if($('#occupation-title-one').val() != undefined){
		var occupation_title = $('#occupation-title-one').val();
	}else{
		var occupation_title = $('#occupation-title').val();
	}
	//document.getElementById('occupation-title').innerHTML;
	var target_onetcode  = $('#target_onetcode').val();
	var target_occupation_title = $('#target_occupation-title').val();
	var cmaUrl ;
	var tempvar = document.location.href;
	tempvar = tempvar.split('/');
	
	if (!document.getElementById('wish_list_icon').innerHTML && ignorealert=='S')
		{
			document.getElementById('wish_list_icon').innerHTML="<a href=\"http://"+tempvar[2]+"/"+tempvar[3]+"/cma/notebook/careers\" title='Wish List' alt='Wish List'><img src='/drupal/sites/all/modules/custom/vcn/header/images/btn_wish_list.png' alt='Wish List'></img></a>";
			
		}
		//document.getElementById('wish_list_icon').innerHTML="<a href=\"https://<?php echo $_SERVER['SERVER_NAME'].base_path(); ?>cma/notebook/careers\" title=\"Wish List\" alt=\"Wish List\"><img id=\"header-cma\" src=\"<?php echo base_path().drupal_get_path('module','vcn_header'); ?>/images/btn_wish_list.png\" alt=\"Wish List\" /></a>";
	
	if (link.href) { cmaUrl = link.href.split('?'); }
	else { cmaUrl = link.split('?'); }
	 
	var target = cmaUrl[0].toLowerCase().search('target');
 	if ( type in onetrequired && target > -1 )
	{
	 	if (target_onetcode == '')
		{
	 		//vcn_saveOrTargetToCMA('http://'+location.host+'/drupal/cma/notebook/target/career/'+onetcode,'careers','onetcode',onetcode);
			vcn_saveOrTargetToCMA(base_path+'cma/notebook/target/career/'+onetcode,'careers','onetcode',onetcode, true);
		}	
		else if (onetcode !== target_onetcode)
		{	
			
			if (ignorealert!='U')
				ModalPopupsCancel2();
				
			var text = 'The '+ type.substring(0, type.length-1)  + ' you are selecting is for a career as a '+ occupation_title;
					    text = text + ' which is not your currently targeted career of ' +  target_occupation_title;
					    text = text + '. Click OK to change your targeted career or CANCEL to continue browsing programs.';
			var answer = confirm(text);

			
			if (answer)
			{
				var counturl = '/careerladder/getcareeronetcodes.php?userid='+cmaid;
				$.ajax({    
					type: "POST",					
					url: counturl,     
					dataType: "html",  
					cache: false,
					success: function(data) { 
					
					var data1 = data.split("###");
					var found = jQuery.inArray(onetcode, data1);
					var arrlength = data1.length;

					
						if (arrlength > 4 && found == -1){ // more than 4 careers and targeting a career which is not saved
							red_error_box('4');
							}else{
							vcn_saveOrTargetToCMA(base_path+'cma/notebook/target/career/'+onetcode,'careers','onetcode',onetcode, true);
							if(type == 'programs'|| 'certifications'||'licenses'){
							  	$.ajax({
									   type: "POST",
									   url: link,
									   dataType: "html",
									   success: function (html) {
							  		//vcn_saveOrTargetToCMA(link, type, 'onetcode',onetcode, true);
									$.ajax({
									type: "POST",
									url: link,
									dataType: "html",
									success: function (html) {
									}
									});
							  	}
							  	});
							}
								if (ignorealert!='U'){
									not_logged_in('S',message);
								}
							$('#target_onetcode').val(onetcode);
							$('#target_occupation-title').val(occupation_title);
							}
						}
				});

			}
			else
			{ 		
				return false;
			}
		}
	}	

  	$.ajax({
		   type: "POST",
		   url: link,
		   dataType: "html",
		   success: function (html) {
  			return_html = html;
  			return_array = Array();
  			return_array = return_html.split('###');
  			if(return_array[0] > 0){
  				alert(return_array[1]);
  				}
		   },
		   error: function (xmlhttp) {
		     alert('An error occured: ' + xmlhttp.status);
		   }
	});
 	

	return false;
}
