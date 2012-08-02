<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript" src="/careerladder/js/jquery-latest.js"></script>

<script language="javascript" type="text/javascript">
	function showhideladdertext(what) {
		document.getElementById('eltext').style.display='none';
		document.getElementById('bstext').style.display='none';
		document.getElementById('doctest').style.display='none';

			if (document.getElementById(what).style.display=="none")
				document.getElementById(what).style.display='block';
			else
				document.getElementById(what).style.display='none';

			
	
	}

	
$(document).ready(function() {

			if (screen.width<1300) { 
				var pix = '580px';
				if (navigator.appName.indexOf('Internet Explorer')>0)
					pix = '546px';
			
				$('#ladder_container').css("overflow-x","hidden");
				$('#ladder_container').css("overflow-y","auto");
				$('#ladder_container').css("height",pix);
				$('#ladder_left').css("height",pix);
				$('#ladder_right').css("height",pix);
			}

});	

</script>

<style type="text/css"> body {background-color: #ffffff; font-family: Verdana; font-size:11px;} #ladder_container{ overflow: none; height: 565px; position: relative; width:100%;  }  </style>


<div id="ladder_container">
	<div id="ladder_left" style="float:left; width:800px; height:565px; text-align: center;">
		<img src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_ladder/images/<?php echo $_GET['onetcode']; ?>.jpg" width="800" alt="Career Pathway" />
	</div>
	
	<div id="ladder_right" style="float:left; width:100px; height:565px; padding-left: 10px; margin-top:-10px; padding-top:10px; border-left:2px solid #000000;"><!--
	<a href="javascript: void(0);" onclick="showhideladdertext('eltext');">EL</a><br/>
	<a href="javascript: void(0);" onclick="showhideladdertext('bstext');">BS</a><br/>
	<a href="javascript: void(0);" onclick="showhideladdertext('doctest');">Doctor of Medicine</a>
	<br/><br/>
	-->
		<strong>Pathway Note:<br/><br/></strong>
		<div id="eltext"  style="display:block;">
			<b>"EL"</b> symbol means entry-level occupation requiring two years or less of postsecondary education and includes some occupations for which only a high school diploma or GED certificate may be needed.  <br/><br>
		</div>
		
		<div id="bstext"  style="display:block;">
			<b>"BS"</b> symbol means entry-level occupation requiring a Bachelor's degree, usually requiring four years to attain.<br/><br>
		</div>
		
		
		<div id="doctest"  style="display:block;">
			<b>No symbol</b> means five years or more of specialized education and results in an academic degree (i.e. Master of Science) or a professional degree (i.e. Doctor of Medicine).
		</div>
		<!--<br/><br/>The bottom row of occupations takes the least amount of time for education and training, including on-the-job-training. <br/><br/>Any occupation with the" EL" symbol above the bottom row can also be an entry-level choice if one invests more time for education and training, but it also is the next-step-up-the-ladder. -->
	
	</div>

</div>