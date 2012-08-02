/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 


function snapshot(title,desc,skills,education,tools,tech,onet,dashonet) {
	desc = desc.substr(0,175);
        
        // next 2 lines added to remove hard coded drupal addresses
        myurl1 = snapShotRoot + '/careerdetails?onetcode=';
        myurl2 = snapShotRoot + '/cma/notebook/save/career/';
		
		if (desc.length<2)
			desc = 'Not available';
		if (skills.length<2)
			skills = 'Not available';
		if (tech.length<2)
			tech = 'Not available';
		if (tools.length<2)
			tools = 'Not available';
		if (education.length<2)
			education = 'Not available';

	// original line replaced with line that removes drupal hard coded addresses
	//document.getElementById('snapshot').innerHTML = '<span class="vcn-gs-heading-black">Career Snapshot</span><br/><br/><b>'+title+'</b><br/><br/><b>Description</b><br/>'+desc+'<br/><br/><b>Typical Skills</b><br/>'+skills+'<br/><br/><b>Tools and Technology</b><br/><br/><b>Tools:</b> '+tools+'<br/><br/><b>Technology:</b> '+tech+'<br/><br/><b>Education and Training Required</b><br/>'+education+'<br/><br/><center><a target="_blank" href="/drupal/careerdetails?onetcode='+onet+'">View Career Details</a><br/><br/><a href="javascript:void(0);" onclick="saveit(\'/drupal/cma/notebook/save/career/'+onet+'\',\''+title+'\', \''+onet+'\', \''+dashonet+'\');" >Add to My Wish List</a></center>';

        // new line that uses myurl1 and myurl2 variables instead of hard coded /drupal names
	document.getElementById('snapshot').innerHTML = '<span class="vcn-gs-heading-black">Career Snapshot</span><br/><br/><b>'+title+'</b><br/><br/><b>Description</b>'+desc+'<br/><br/><b>Typical Skills</b><br/>'+skills+'<br/><br/><b>Tools</b><br/>'+tools+'<br/><br/><b>Technology</b><br/>'+tech+'<br/><br/><b>Education and Training Required</b><br/>'+education+'<br/><br/><center><a target="_blank" href="'+myurl1+onet+'">View Career Details</a><br/><br/><a href="javascript:void(0);" onclick="saveit(\''+myurl2+onet+'\',\''+title+'\', \''+onet+'\', \''+dashonet+'\');" >Add to My Wish List</a></center>';
}

