/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 

// Drupal.behavors ensures that our new binding can be
// applied to any new occurances of #example-ajax
// created on the fly by other scripts.
Drupal.behaviors.cmaNotebookRemoveCareerAjax = function(context) {

  // Bind an AJAX callback to our link
  $('.snapshot-remove-button').click(function(event) {
    // Get the URL without the query string - this is
    // so that we can distinguish between GET and POST
    // requests.
    var cmaNotebookRemoveCareerUrl = $(this).attr('href').split('?');
    var secondcareeronet = $(this).attr('secondcareeronet');
    var secondcareeronetdash = secondcareeronet.split('/').pop().replace('.','-');
    var careercount = $(this).attr('careercount');
    var countvariable = $(this).attr('countvariable'); // this is to decide whether the career deleted is a target or not .. getting this from the theme file 
    var cmaid = $(this).attr('careercmaid');

    var cmaCareerId = '#onet-' + cmaNotebookRemoveCareerUrl[0].split('/').pop().replace('.','-');
    var cmacareeriddash = cmaNotebookRemoveCareerUrl[0].split('/').pop().replace('.','-');
    // Prevent the default link action - we don't
    // want to trigger a synchronous response.
    event.preventDefault();

    // Perform the ajax request - the configurations
    // below can be modified to suit your needs:
    // http://docs.jquery.com/Ajax/jQuery.ajax#options
		  
              
		  var counturl = '/careerladder/careercount.php?userid='+cmaid;
		  
			$.ajax({    
				type: "POST",					
				url: counturl,     
				dataType: "html",  
				cache: false,
				success: function(data) {         
				var count = data;
				 // alert('countvariable'+countvariable+'count'+count);
				if (count > 2 && countvariable == 1){ // more than 2 careers and deleting the target
					red_error_box('cantdelete');
					return false;
				} // end : more than 2 careers and deleting the target
				else if(countvariable == 1 && count == 2){   // one targeted career and one saved career .. deleting the target 
					var careeridurl = window.location.protocol+'//'+window.location.host+'/careerladder/careerid.php?userid='+cmaid;
					$.ajax({
						type: "POST",
						url: careeridurl,
						dataType: "html",
						cache: false,
						success: function (careerid1) {
							var secondcareerid = careerid1;
							//var originalonet = secondcareerid.split('-');
							var secondcareeridcss = secondcareerid.split('/').pop().replace('.','-');
							//var origianalonet1 = originalonet[0]+'-'+originalonet[1]+'.'+originalonet[2];
										var thetargeturl = window.location.protocol+'//'+window.location.host+base_path+'cma/notebook/target/career/'+secondcareerid;
									  	$.ajax({
									  			type: "POST",
									          	url: thetargeturl,
									          	dataType: "html",
												success: function (html) {
													    $.ajax({
															type: "POST",
															url: cmaNotebookRemoveCareerUrl[0],
															dataType: "html",
															success: function (html) {
															$(cmaCareerId).empty().remove();
																if (html[0] == ':') {
																not_logged_in('S','Career Removed from your Wish List.');
																} else
																alert(html);
															},
																error: function (xmlhttp) {
																alert('An error occured: ' + xmlhttp.status);
																}
														});	
												document.getElementById('target_careers_'+secondcareeridcss).innerHTML = '(This is the Targeted Career)';
												//$.('#target_careers_'+secondcareerid).html('This is the Targeted Career');
												}
								}); 									  	
						}
					});	
				} //  end : one targeted career and one saved career .. deleting the target 
				else
				{    
					$.ajax({
						type: "POST",
						url: cmaNotebookRemoveCareerUrl[0],
						dataType: "html",
						success: function (html) {
							$(cmaCareerId).empty().remove();
							if (html[0] == ':') {
								not_logged_in('S','Career Removed from your Wish List.');
								} else
								alert(html);
							},
						error: function (xmlhttp) {
						alert('An error occured: ' + xmlhttp.status);
						}
					});	
				}
            }
			});  			
			
			

				$.ajax({
					type: "POST",
					url: window.location.protocol+'//'+window.location.host+'/careerladder/notebookitemcount.php?userid='+cmaid,
					dataType: "html",
					success: function (htmlcount) {
					if(htmlcount == 1){
						document.getElementById('wish_list_icon').innerHTML="";
					}
				}
				});
		  });

}

// Drupal.behavors ensures that our new binding can be
// applied to any new occurances of #example-ajax
// created on the fly by other scripts.
Drupal.behaviors.cmaNotebookTargetCareerAjax = function(context) {

  // Bind an AJAX callback to our link
  $('.snapshot-target-button').click(function(event) {
    // Get the URL without the query string - this is
    // so that we can distinguish between GET and POST
    // requests.
    var cmaNotebookTargetCareerUrl = $(this).attr('href').split('?');
    var cmaCareerId = '#onet-' + cmaNotebookTargetCareerUrl[0].split('/').pop().replace('.','-');
    var target_career_id = '#target_careers_'+cmaNotebookTargetCareerUrl[0].split('/').pop().replace('.','-');
    //alert(target_career_id);
    // Prevent the default link action - we don't
    // want to trigger a synchronous response.
    event.preventDefault();

    // Perform the ajax request - the configurations
    // below can be modified to suit your needs:
    // http://docs.jquery.com/Ajax/jQuery.ajax#options
    $.ajax({
      type: "POST",
      url: cmaNotebookTargetCareerUrl[0],
      dataType: "html",
      success: function (html) {
        $(cmaCareerId).parent().prepend($(cmaCareerId));
          if (html[0] == ':') {
              //var want2login = html.substring(1) + '\n\nYou do not appear to be logged in. Would you like to log in now?';
              //var answer = confirm(want2login);
			  not_logged_in('S','Career targeted.');
              if (answer) {
                //window.location = base_path+"user/login";
              	//To make sure the login is through /user not through /user/login
            	  window.location = base_path+"user";            	  
              }
          } else
        	  $('.target_careers').empty();         
           //   $(target_career_id).text('(This is the Targeted Career)');
        	html = html.split('###');
            alert(html[1]);
      },
      error: function (xmlhttp) {
        alert('An error occured: ' + xmlhttp.status);
      }
    });
  });
}
