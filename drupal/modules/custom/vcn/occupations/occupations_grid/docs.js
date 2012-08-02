/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 

/* Stop IE flicker */
if ($.browser.msie == true) document.execCommand('BackgroundImageCache', false, true);
ChiliBook.recipeFolder     = "js/chili/";
ChiliBook.stylesheetFolder = "js/chili/"

jQuery.fn.antispam = function() {
  return this.each(function(){
	var email = $(this).text().toLowerCase().replace(/\sdot/g,'.').replace(/\sat/g,'@').replace(/\s+/g,'');
	var URI = "mailto:" + email;
	$(this).hide().before(
		$("<a></a>").attr("href",URI).addClass("external").text(email)
	);
  });
};


$(function() {
	$("pre.javascript").chili();
	$("pre.html").chili();
	$("pre.css").chili();
	$("a.external").each(function() {this.target = '_new'});	
	$("span.email").antispam();
});