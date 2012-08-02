/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 


// functions for font resizing

function fontsize12() { 
   $('span').not('.noresize').css('font-size','12px');
   $('div').not('.noresize').css('font-size','12px');
   $('center').not('.noresize').css('font-size','12px');
   $('p').not('.noresize').css('font-size','12px');
   $('li').not('.noresize').css('font-size','12px');
   $('td').not('.noresize').css('font-size','12px');
   //$('#blueborder').css('background-image','url(/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/main_671.png)');
   $('#blueborder').css('height','405px');
   $('#bbimage').css('height','405px');
   $('.xouter').css('margin-top','-408px');
   $('#under-search').css('margin-top','-367px');
   $('#under-search').css('height','400px');
};

function fontsize15() { 
   $('span').not('.noresize').css('font-size','15px');
   $('div').not('.noresize').not('[class^="progressBar"]').css('font-size','15px');
   $('center').not('.noresize').css('font-size','15px');
   $('p').not('.noresize').css('font-size','15px');
   $('li').not('.noresize').css('font-size','15px');
   $('td').not('.noresize').css('font-size','15px');
   //$('#blueborder').css('background-image','url(/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/main_671x580.png)');
   $('#blueborder').css('height','533px');
   $('#bbimage').css('height','533px');
   $('.xouter').css('margin-top','-687px');
   $('#under-search').css('margin-top','-567px');
   $('#under-search').css('height','600px');
};

function fontsize18() { 
   $('span').not('.noresize').css('font-size','18px');
   $('div').not('.noresize').not('[class^="progressBar"]').css('font-size','18px');
   $('center').not('.noresize').css('font-size','18px');
   $('p').not('.noresize').css('font-size','18px');
   $('li').not('.noresize').css('font-size','18px');
   $('td').not('.noresize').css('font-size','18px');
   //$('#blueborder').css('background-image','url(/drupal/sites/all/modules/custom/vcn/occupations/occupations_worktypes/images/main_671x580.png)');
   $('#blueborder').css('height','696px');
   $('#bbimage').css('height','805px');
   $('.xouter').css('margin-top','-940px');
   $('#under-search').css('margin-top','-885px');
   $('#under-search').css('height','100px');
};

function fontsize() { // set to current size based on cookie
   var currcookie = $.cookie('fontsize');
   if (currcookie == 'normal') {
      fontsize12();
   } else if (currcookie == 'larger') {
      fontsize15();
   } else if (currcookie == 'largest') {
      fontsize18();
   }
}

function fontresize() { // change to new font size based on current size
   var currcookie = $.cookie('fontsize');
   if ((currcookie==null) || (currcookie == 'normal')) {
      fontsize15();
      $.cookie('fontsize', 'larger', { expires: 1 });
   } else if (currcookie == 'larger') {
      fontsize18();
      $.cookie('fontsize', 'largest', { expires: 1 });
   } else if (currcookie == 'largest') {
      fontsize12();
      $.cookie('fontsize', 'normal', { expires: 1 });
   }
};

function alertfirstvisit(){
	

	//Pop up for Beta Site 5763
	//Alert message once script- By JavaScript Kit
	//Credit notice must stay intact for use
	//Visit http://javascriptkit.com for this script
	//$.cookie('fontsize', 'normal', { expires: 1 });
	var firstvisit = $.cookie("firstvisit");

	//specify message to alert
	if (firstvisit != "no"){
		//var alertmessage="Welcome to the VCN. This is a beta site still undergoing testing and we would appreciate your input. Please provide feedback on your experience by clicking the \"Tell us what you think\" button at the bottom of this page.\n\nThe production site is live at www.vcn.org"
		var alertmessage="Welcome to the VCN. This is a beta site still undergoing testing and we would appreciate your input. Please provide feedback on your experience by clicking the \"Tell us what you think\" button at the bottom of this page."
		alert(alertmessage);
		$.cookie("firstvisit", "no");
	}

	//end of 
	//Alert message once script- By JavaScript Kit
	//Credit notice must stay intact for use
	//Visit http://javascriptkit.com for this script
}
// jquery invoke

// This function is used to popup an window to display external links.  This will eventually 
// supercede the popit function currently used. The PHP function, vcn_build_external_link_opener, should be
// called to autogenerate code to build the AHREF that uses this function.
function openExternalSite(anchorElement) {
    var url = anchorElement.href;
    if (url.length > 0) {
        window.open(url, "externallinkwindow", "height=480, width=640, toolbar=0, resizable=1, scrollbars=1, menubar=1, status=0");
    }
}

$(document).ready(function() {
    fontsize();
    
    // this onclick event handler is used for opening external links in a small popup window
    $('.extlink').click(function(event) { 
        event.preventDefault(); 
        openExternalSite(event.currentTarget); 
    });
});

