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
Drupal.behaviors.cmaNotebookRemoveVhsAjax = function(context) {

  // Bind an AJAX callback to our link
  $('.vhs-remove-button').click(function(event) {
    // Get the URL without the query string - this is
    // so that we can distinguish between GET and POST
    // requests.
    var cmaNotebookRemoveVhsUrl = $(this).attr('href').split('?');

    var cmaVhsId = '#vhs-' + cmaNotebookRemoveVhsUrl[0].split('/').pop().replace('.','-');

    // Prevent the default link action - we don't
    // want to trigger a synchronous response.
    event.preventDefault();

    // Perform the ajax request - the configurations
    // below can be modified to suit your needs:
    // http://docs.jquery.com/Ajax/jQuery.ajax#options
    $.ajax({
      type: "POST",
      url: cmaNotebookRemoveVhsUrl[0],
      dataType: "html",
      success: function (html) {
        $(cmaVhsId).empty().remove();
          if (html[0] == ':') {
             // var want2login = html.substring(1) + '\n\nYou do not appear to be logged in. Would you like to log in now?';
             // var answer = confirm(want2login);
			 not_logged_in('S','VHS Removed from your Wish List.');
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
  });
}

// Drupal.behavors ensures that our new binding can be
// applied to any new occurances of #example-ajax
// created on the fly by other scripts.
Drupal.behaviors.cmaNotebookTargetVhsAjax = function(context) {

  // Bind an AJAX callback to our link
  $('.vhs-target-button').click(function(event) {
    // Get the URL without the query string - this is
    // so that we can distinguish between GET and POST
    // requests.
    var cmaNotebookTargetVhsUrl = $(this).attr('href').split('?');
    var cmaVhsId = '#vhs-' + cmaNotebookTargetVhsUrl[0].split('/').pop().replace('.','-');

    // Prevent the default link action - we don't
    // want to trigger a synchronous response.
    event.preventDefault();

    // Perform the ajax request - the configurations
    // below can be modified to suit your needs:
    // http://docs.jquery.com/Ajax/jQuery.ajax#options
    $.ajax({
      type: "POST",
      url: cmaNotebookTargetVhsUrl[0],
      dataType: "html",
      success: function (html) {
        $(cmaVhsId).parent().prepend($(cmaVhsId));
          if (html[0] == ':') {
             // var want2login = html.substring(1) + '\n\nYou do not appear to be logged in. Would you like to log in now?';
             // var answer = confirm(want2login);
			 not_logged_in('S','VHS targeted.');
              if (answer) {
                  //window.location = base_path+"user/login";
              	//To make sure the login is through /user not through /user/login
              	  window.location = base_path+"user";
              }
          } else
          html = html.split('###');
          alert(html[1]);
      },
      error: function (xmlhttp) {
        alert('An error occured: ' + xmlhttp.status);
      }
    });
  });
}
