<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
Drupal.behaviors.cmaNotebookSaveCareerAjax = function(context) {

	  // Bind an AJAX callback to our link
	  $('.save-to-notebook').click(function(event) {
	    // Get the URL without the query string - this is
	    // so that we can distinguish between GET and POST
	    // requests.
	    var cmaNotebookSaveCareerUrl = $(this).attr('href').split('?');

	    // Prevent the default link action - we don't
	    // want to trigger a synchronous response.
	    event.preventDefault();

	    // Perform the ajax request - the configurations
	    // below can be modified to suit your needs:
	    // http://docs.jquery.com/Ajax/jQuery.ajax#options
	    //To make sure the login is through /user not through /user/login	 
        // window.location = "<?php // echo base_path(); user/login";?>
   
	    $.ajax({
	      type: "POST",
	      url: cmaNotebookSaveCareerUrl[0],
	      dataType: "html",
	      success: function (html) {
	          if (html[0] == ':') {
	              var want2login = html.substring(1) + '\n\nYou do not appear to be logged in. Would you like to log in now?';
	              var answer = confirm(want2login);
	              if (answer) {
	                window.location = "<?php echo base_path(); ?>user";	                
	              }
	          } else
	            alert(html);
	      },
	      error: function (xmlhttp) {
		    	//Todo get this one back
	        //alert('An error occured: ' + xmlhttp.status);
	      }
	    });
	  });
	}


function gogetit(thisv,onet,onetdash) {
	if (document.getElementById('cmacontainer6'))
		document.getElementById('cmacontainer6').innerHTML='';
	$('#cmacontainer6').append('<div id="onet-'+onetdash+'"><div style="float:left; width:231px;">'+thisv+'</div>');
	
}

</script>

<div id="snapshot" style="width:92%; height:620px; font-size:14px; margin-left:15px;">
<span class="vcn-gs-heading-black" style="margin-left:-5px">Career Snapshot</span>
</div>