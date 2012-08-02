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
Drupal.behaviors.cmaNotebookRemoveCertificateAjax = function(context) {

  // Bind an AJAX callback to our link
  $('.certificate-remove-button').click(function(event) {
    // Get the URL without the query string - this is
    // so that we can distinguish between GET and POST
    // requests.
    var cmaNotebookRemoveCertificateUrl = $(this).attr('href').split('?');
    var cmaid = $(this).attr('careercmaid');
    var cmaCertificateId = '#certificate-' + cmaNotebookRemoveCertificateUrl[0].split('/').pop().replace('.','-');

    // Prevent the default link action - we don't
    // want to trigger a synchronous response.
    event.preventDefault();

    // Perform the ajax request - the configurations
    // below can be modified to suit your needs:
    // http://docs.jquery.com/Ajax/jQuery.ajax#options
    $.ajax({
      type: "POST",
      url: cmaNotebookRemoveCertificateUrl[0],
      dataType: "html",
      success: function (html) {
        $(cmaCertificateId).empty().remove();
          if (html[0] == ':') {
             // var want2login = html.substring(1) + '\n\nYou do not appear to be logged in. Would you like to log in now?';
             // var answer = confirm(want2login);
			 not_logged_in('S','Certificate Removed from your Wish List.');
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
Drupal.behaviors.cmaNotebookTargetCertificateAjax = function(context) {

  // Bind an AJAX callback to our link
  $('.certificate-target-button').click(function(event) {
    // Get the URL without the query string - this is
    // so that we can distinguish between GET and POST
    // requests.
    var cmaNotebookTargetCertificateUrl = $(this).attr('href').split('?');
    var cmaCertificateId = '#certificate-' + cmaNotebookTargetCertificateUrl[0].split('/').pop().replace('.','-');
    var target_certificate_id = '#target_certificate_'+cmaNotebookTargetCertificateUrl[0].split('/').pop().replace('.','-');

    // Prevent the default link action - we don't
    // want to trigger a synchronous response.
    event.preventDefault();

    // Perform the ajax request - the configurations
    // below can be modified to suit your needs:
    // http://docs.jquery.com/Ajax/jQuery.ajax#options
    $.ajax({
      type: "POST",
      url: cmaNotebookTargetCertificateUrl[0],
      dataType: "html",
      success: function (html) {
        $(cmaCertificateId).parent().prepend($(cmaCertificateId));
          if (html[0] == ':') {
              //var want2login = html.substring(1) + '\n\nYou do not appear to be logged in. Would you like to log in now?';
              //var answer = confirm(want2login);
			  not_logged_in('S','Certificate targeted.');
              if (answer) {
                  //window.location = base_path+"user/login";
              	//To make sure the login is through /user not through /user/login
              	  window.location = base_path+"user";
              }
          } else
          $('.target_certificate').empty();         
          $(target_certificate_id).text('(This is the Targeted Certification)');        	  
          html = html.split('###');
          alert(html[1]);
      },
      error: function (xmlhttp) {
        alert('An error occured: ' + xmlhttp.status);
      }
    });
  });
}
