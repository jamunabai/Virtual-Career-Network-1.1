/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 

// JavaScript Document

function CloseWindow() {
       ww = window.open(window.location, "_self");
       ww.close();
}

function confirmation() {
	var answer = confirm("Click OK to close the window and open the link sent to your Email.");
	if (answer){
		//alert("Thank You for registering");
		//window.location = "http://www.google.com/";
		CloseWindow();
	}
	else{
		//alert("Thank You for registering but Please close this window and use the link sent to your Email.");
	}
}

function close_moz(){
	ww = window.open(window.location, "_self");
    ww.close();
}
//alert("Welcome User.", close_moz());

confirmation();

/*window.onbeforeunload = confirmExit;
function confirmExit(){
	if(confirm("Do you really want to close?")){
		//CloseWindow();
		//window.close();
		this.focus();self.opener = this;self.close();
	}
}*/




