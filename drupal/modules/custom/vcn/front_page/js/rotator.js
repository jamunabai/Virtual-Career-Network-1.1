/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 

var timeInSecs=15;

var divIds=new Array(); 
divIds[0]="fp-container1"; 
divIds[1]="fp-container2"; 
divIds[2]="fp-container3"; 
divIds[3]="fp-container4";
   
function display(i) {
    for (var j = 0; j < divIds.length;j++) {
        if (j == i) {
            document.getElementById(divIds[i]).style.display = '';
        }
        else {
            document.getElementById(divIds[j]).style.display = 'none'; 
        }
    }
    if (i < divIds.length-1) {
        i++
        setTimeout('display(' + i + ')',timeInSecs*1000);
    }
    else
    {
        setTimeout('display(0)',timeInSecs*1000);
    }
}

