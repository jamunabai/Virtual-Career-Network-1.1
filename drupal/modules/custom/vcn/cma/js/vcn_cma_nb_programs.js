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
Drupal.behaviors.cmaNotebookRemoveProgramAjax = function(context) {

  // Bind an AJAX callback to our link
  $('.program-remove-button').click(function(event) {
    // Get the URL without the query string - this is
    // so that we can distinguish between GET and POST
    // requests.
	var cmaid = $(this).attr('careercmaid');
    var cmaNotebookRemoveProgramUrl = $(this).attr('href').split('?');
    

 //   var cmaProgramId = '#onet-' + cmaNotebookRemoveProgramUrl[0].split('/').pop().replace('.','-');
    var cmaProgramId  = cmaNotebookRemoveProgramUrl[0].split('/');
    cmaProgramId  = '#onet-' + cmaProgramId[6] + cmaProgramId[7];
    cmaProgramId  = cmaProgramId.replace('.','-');
    // Prevent the default link action - we don't
    // want to trigger a synchronous response.
    event.preventDefault();

    // Perform the ajax request - the configurations
    // below can be modified to suit your needs:
    // http://docs.jquery.com/Ajax/jQuery.ajax#options
    $.ajax({
      type: "POST",
      url: cmaNotebookRemoveProgramUrl[0],
      dataType: "html",
      success: function (html) {
        $(cmaProgramId).empty().remove();
          if (html[0] == ':') {
              //var want2login = html.substring(1) + '\n\nYou do not appear to be logged in. Would you like to log in now?';
              //var answer = confirm(want2login);
			  not_logged_in('S','Program Removed from your Wish List.');
              if (answer) {
                  //window.location = base_path+"user/login";
              	//To make sure the login is through /user not through /user/login
              	  window.location = base_path+"user";
              }
          } else
            alert(html);
      },
      error: function (xmlhttp) {
        alert('An error occured: ' + xmlhttp.status);
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
Drupal.behaviors.cmaNotebookTargetProgramAjax = function(context) {

  // Bind an AJAX callback to our link
  $('.program-target-button').click(function(event) {
    // Get the URL without the query string - this is
    // so that we can distinguish between GET and POST
    // requests.
    var cmaNotebookTargetProgramUrl = $(this).attr('href').split('?');
 //   var cmaProgramId = '#onet-' + cmaNotebookTargetProgramUrl[0].split('/').pop().replace('.','-');
    var cmaProgramId  = cmaNotebookTargetProgramUrl[0].split('/');
    cmaProgramId  = '#onet-' + cmaProgramId[6] + cmaProgramId[7];
    cmaProgramId  = cmaProgramId.replace('.','-');
    var target_program_id = '#target_program_'+cmaNotebookTargetProgramUrl[0].split('/').pop().replace('.','-');   
    //alert('target_program_id'+' '+target_program_id);
    //alert(cmaProgramId);
    // Prevent the default link action - we don't
    // want to trigger a synchronous response.
    event.preventDefault();

    // Perform the ajax request - the configurations
    // below can be modified to suit your needs:
    // http://docs.jquery.com/Ajax/jQuery.ajax#options
    $.ajax({
      type: "POST",
      url: cmaNotebookTargetProgramUrl[0],
      dataType: "html",
      success: function (html) {
        $(cmaProgramId).parent().prepend($(cmaProgramId));
          if (html[0] == ':') {
             // var want2login = html.substring(1) + '\n\nYou do not appear to be logged in. Would you like to log in now?';
            //  var answer = confirm(want2login);
			not_logged_in('S','Program targeted.');
              if (answer) {
                  //window.location = base_path+"user/login";
              	//To make sure the login is through /user not through /user/login
              	  window.location = base_path+"user";
              }
          } else
          $('.target_program').empty();         
          $(target_program_id).text('(This is the Targeted Program)');         	  
          html = html.split('###');
          alert(html[1]);
      },
      error: function (xmlhttp) {
        alert('An error occured: ' + xmlhttp.status);
      }
    });
  });
}
