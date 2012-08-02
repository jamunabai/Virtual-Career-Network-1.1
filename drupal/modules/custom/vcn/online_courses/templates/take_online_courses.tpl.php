<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

function getSchools() {

		$rest = new vcnRest;

		$rest->setSecret('');
		$rest->setBaseurl(getBase());
		$rest->setService('trainingsvc');
		$rest->setModule('providers');
		$rest->setAction('list');

		// standard filters
		$rest->setRequestKey('apikey','apikey');
		$rest->setRequestKey('format','xml');
		$rest->setRequestKey('vhs_yn','Y');


		$rest->setMethod('post');


		$content = $rest->call();


		$content = new SimpleXMLElement($content);


		$content = $content->data->providers;


		return $content;
}

$content = getSchools();

$state_list = array('AL'=>"Alabama",
                'AK'=>"Alaska",
                'AZ'=>"Arizona",
                'AR'=>"Arkansas",
                'CA'=>"California",
                'CO'=>"Colorado",
                'CT'=>"Connecticut",
                'DE'=>"Delaware",
                'DC'=>"District Of Columbia",
                'FL'=>"Florida",
                'GA'=>"Georgia",
                'HI'=>"Hawaii",
                'ID'=>"Idaho",
                'IL'=>"Illinois",
                'IN'=>"Indiana",
                'IA'=>"Iowa",
                'KS'=>"Kansas",
                'KY'=>"Kentucky",
                'LA'=>"Louisiana",
                'ME'=>"Maine",
                'MD'=>"Maryland",
                'MA'=>"Massachusetts",
                'MI'=>"Michigan",
                'MN'=>"Minnesota",
                'MS'=>"Mississippi",
                'MO'=>"Missouri",
                'MT'=>"Montana",
                'NE'=>"Nebraska",
                'NV'=>"Nevada",
                'NH'=>"New Hampshire",
                'NJ'=>"New Jersey",
                'NM'=>"New Mexico",
                'NY'=>"New York",
                'NC'=>"North Carolina",
                'ND'=>"North Dakota",
                'OH'=>"Ohio",
                'OK'=>"Oklahoma",
                'OR'=>"Oregon",
                'PA'=>"Pennsylvania",
                'RI'=>"Rhode Island",
                'SC'=>"South Carolina",
                'SD'=>"South Dakota",
                'TN'=>"Tennessee",
                'TX'=>"Texas",
                'UT'=>"Utah",
                'VT'=>"Vermont",
                'VA'=>"Virginia",
                'WA'=>"Washington",
                'WV'=>"West Virginia",
                'WI'=>"Wisconsin",
                'WY'=>"Wyoming");
?>

<style>
<?php //.breadcrumb {display: none;} ?>
.indentonline{padding-left:15px;}
</style>
<?php // header( 'Cache-Control: private, max-age=10800, pre-check=10800' ); ?>

<?php
$base_url = base_path();
$path=$base_url . "/sites/all/themes/zen_hvcp/js/boxover.js";
$path2=$base_url . "/sites/default/files/images/links/";
echo "<script type=\"text/javascript\" src=\"$path\"></script> ";
?>

<script type="text/javascript">
var dge=document.getElementById;
function cl_expcol(a)
  {
  if(!dge)return;
    document.getElementById(a).style.display =
      (document.getElementById(a).style.display=='none')?
      'block':'none';

	 if (document.getElementById(a).style.display=='none')
		document.getElementById(a+'operator').innerHTML='[+]';
	else
		document.getElementById(a+'operator').innerHTML='[-]';

  }
function cl_colall()
  {
  if(!dge)return;
  for(i=1;document.getElementById('expand'+i);i++)
    {
    document.getElementById('expand'+i).style.display='none';
    }
  }
function OpenCloseStates(state, anchorObj)
{
	if (document.getElementById(state).style.display == 'inline') {
		document.getElementById(state).style.display = 'none';
		anchorObj.innerHTML = '[+]';
		anchorObj.title = 'Click to Open';
	} else {
		document.getElementById(state).style.display = 'inline';
		anchorObj.innerHTML = '[-]';
		anchorObj.title = 'Click to Close';
	}
}

$(document).ready(function() {

	var r2 = '<?php echo $_GET['state']; ?>';

	if (r2.length > 0) {
		document.getElementById('vcn-header').style.display = 'none';
		document.getElementById('vcn-footer').style.display = 'none';
		document.getElementById('copyright').style.display = 'none';

		$('#page').css("width","980px");
		$('#page').css("height","550px");
		$('#page').css("overflow-x","hidden");
		$('#page').css("overflow-y","scroll");
		
		$('.breadcrumb').css("display","none");
	}
});
</script>

<style>
.title2
  {
  font-size: 16px;
  font-family: arial, helvetica, sans-serif;
  font-weight: bold;
  border: 1px solid black;
  background-color: #189AB0;
  color: white;
  }

.container
  {
  font-size: 14px;
  font-family: arial, helvetica, sans-serif;
  }

.strong
  {
  font-weight: bold;
  padding-top: 10px;
  padding-bottom: 10px;
  list-style-type: none;
  }

td
  {
  font-size: 14px;
  font-family: arial, helvetica, sans-serif;
  }

.nodot
  {
  list-style-type: none;
  }

.disc
  {
  list-style-type: disc;
  }

.tt-head
  {
  width:310px;
  color: white;
  background: #189AB0;
  border:1px solid #663300;
  text-align: center;
  }

.tt-body
  {
  width:300px;
  background: #FEF5FE;
  font-size: 10px;
  border-left:1px solid #663300;
  border-right:1px solid #663300;
  border-bottom:1px solid #663300;
  padding: 5px;
  }

span.hint
  {
  float: right;
  padding-top: 4px;
  padding-right: 5px;
  text-align: right;
  font-size: 12px;
  }

</style>

<!-- <body onload='cl_colall()'> -->
<?php 
//$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
$url = "http://".$_SERVER['SERVER_NAME'];
$base_path = base_path();

// Function to populate the alphabet array so it knows how many schools are in each state letter
function GetStateLetterCount(&$alphabetArr, $schools)
{
	foreach ($schools as $school) {
		if (!$school->instnm) {
			break;
		}
		$letter = strtoupper(substr($school->stabbr, 0, 1));
		$alphabetArr[$letter] += 1;
	}
}

?>


<div class="container">
<?php 
if (strlen($_GET['state'])>0): 
?>
<ul style="margin:0; padding:0;">
<li style="cursor:pointer; list-style-type: none; margin:0; padding: 5px 0 5px 0;" onclick="javascript:cl_expcol('expand1');"><div class="title2"><a id='expand1operator' title="expand/collapse list" style="font-family:monospace;color: rgb(255,255,255); text-decoration:none;"><font color="FFFFFF">[-]</font></a> Virtual High Schools </div></li>

    <ul id="expand1"><p style="width: 100%;">Don't have a high school diploma or GED? Don't worry if you do not. We can help. A "virtual" high school
    is one you can attend online to get your diploma. Click on the name of the virtual high school in your state to find detailed information about
    what you need to do; most "virtual" high school programs are free to state residents. This information will be saved in your Career Management Account.
    </p>
      <div>
      <?php
      // Defines the array of state characters as key and count of course as value.
      // Will need to call the GetStateLetterCount function to populate values
      $alphabet = array('A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0, 'F' => 0, 'G' => 0, 'H' => 0, 'I' => 0,
      	                  'J' => 0, 'K' => 0, 'L' => 0, 'M' => 0, 'N' => 0, 'O' => 0, 'P' => 0, 'Q' => 0, 'R' => 0,
      	                  'S' => 0, 'T' => 0, 'U' => 0, 'V' => 0, 'W' => 0, 'X' => 0, 'Y' => 0, 'Z' => 0);

      // Set a default state character to have opened
      $char = 'A';

      // Check to see if a user clicked on a state character
      if (isset($_GET['state']) && strlen($_GET['state']) && in_array(strtoupper($_GET['state']), $alphabet)) {
      	$char = strtoupper($_GET['state']);
      }

      // Call the function to populate the alphabet array
      GetStateLetterCount($alphabet, $content);

      // Build the alphabet line to allow users to click on a specific letter to see those states
      $alphabetListing = '<div><strong>State Name Starting with:</strong> <span style="padding-left:10px;">';

      // Lay out the letters: gray if no schools in the letter, bold if selected letter, hyperlink if not selected letter
      foreach ($alphabet as $key => $value) {
      	if ($value === 0) {
      		$alphabetListing .= '<span style="color:gray;">' . $key . '</span>';
      	} elseif ($char == $key) {
      		$alphabetListing .= '<strong>' . $key . '</strong>';
      	} else {
      		$alphabetListing .= '<a href="?state=' . $key . '">' . $key .'</a>';
      	}
      	$alphabetListing .= ' | ';
      }

      // Strip off the last pipe (|) character
      $index = strripos($alphabetListing, '|');
      if ($index !== false) {
      	$alphabetListing = substr_replace($alphabetListing, '', $index);
      }

      // Close out the alphabet DIV
      $alphabetListing .= '</span></div><br/>';

      // Print out the alphabet HTML
	  echo $alphabetListing;

      $stateCounter = 0;
      $count = 0;
      $currentState = '';
      $schoolsHTML = '<table style="width: 90%;">' . "\n";

      // Build the divs to hold the schools per state for the letter selected by looping through each
      // school in the XML content.  Display the state name with a (+) to allow the user to click to
      // expand to see all the schools in that state.
      foreach ($content as $school) {
          if (!$school->instnm) {
      	     break;
          }

          // Check to see if the current school first letter matches the users selected letter
      	  if (strtoupper(substr($school->stabbr, 0, 1)) == $char) {
      	  	  // If current state code doesn't match the current school state code then make sure we add the state
              if ($currentState != (string)$school->stabbr) {
                  $stateCounter = 0;
      			  $stateName = $state_list[(string)$school->stabbr];

                  if ($count > 0) {
                      $schoolsHTML .= '</td></tr>' . "\n";
                  }
                  $schoolsHTML .= '<td  class="indentonline" style="width: 30%;">' . "\n";
                  $schoolsHTML .= '<li class="nodot"><strong>' . $stateName . '</strong> <a href="javascript:void(0);" onclick="OpenCloseStates(\'exp' . $stateName . '\', this);" style="font-family:monospace;text-decoration:none;" title="Click to Open">[+]</a></li>' . "\n";
                  $schoolsHTML .= '<br/><div id="exp' . $stateName . '" style="display:none;">' . "\n";
              }

              // Add the school for the current state code but make sure it doesnt have
              // any quotes or double quotes and that it contains http at the front
              $webAddress = str_replace('"', '', $school->webaddr);
              $webAddress = str_replace("'", '', $webAddress);
              if (strpos($webAddress, 'http') === false) {
              	$webAddress = 'http://' . $webAddress;
              }
              $schoolsHTML .= '<a href="javascript:popit(\'' . $webAddress . '\')">' . $school->instnm . '</a><br/><br/>' . "\n";

              $currentState = (string)$school->stabbr;
              $stateCounter++;
          }
          $count++;
      }

      $schoolsHTML .= '</div>' . "\n";
      $schoolsHTML .= '</td></tr>' . "\n";
      $schoolsHTML .= '</table>' . "\n";

      echo $schoolsHTML;
	  
      ?>

      </div>
  </ul>
</ul>

<ul style="margin:0; padding:0;">
  <li style="cursor:pointer; list-style-type: none; margin:0; padding: 5px 0 5px 0;" onclick="javascript:cl_expcol('expand2');"><div class="title2"><a id='expand2operator' title="expand/collapse list" style="font-family:monospace;color: rgb(255,255,255); text-decoration:none;"><font color="FFFFFF">[-]</font></a> General Educational Development, or GED Test</div></li>
	<ul id="expand2">
    <div>
	<p>Another alternative is to earn a GED certificate (equivalent to a high school diploma) by passing a test. Information about obtaining a GED and taking the GED test can be found by 
      	<a href="javascript:popit('http://www.acenet.edu/AM/Template.cfm?Section=GED_TS')">clicking here.</a> 
      	Or <a href="javascript:popit('/careerladder/Resourcespdfs/GED_Testing_Program_Fact_Sheet_v2_2010.pdf')">click here</a> for a printable fact sheet.
      	</p>
    </div>
  </ul>
</ul>
<?php else: ?>
<br/>
More and more people are getting their education through online courses. 
<a href="javascript:popit('/careerladder/Resourcespdfs/Distance_Learning.pdf')">Click here</a> 
to learn more about "Online Learning". Through the VCN Learning Exchange, you can improve your Reading 
and Math Skills.  You can also take courses online for credit or as refresher courses to improve the 
skills you will need when taking college level courses. 
<br/>
<br/>

<ul style="margin:0; padding:0;">
  <li style="cursor:pointer; list-style-type: none; margin:0; padding: 5px 0 5px 0;" onclick="javascript:cl_expcol('expand3');"><div class="title2"><a id='expand3operator' title="expand/collapse list" style="font-family:monospace;color: rgb(255,255,255); text-decoration:none;"><font color="FFFFFF">[-]</font></a> VCN Learning Exchange </div></li>
    <ul id="expand3">
   Take a free course through the VCN Learning Exchange. Doing so can help prepare you for the education or training program you have selected <u>and</u> earn you college credit. The courses are organized by whether any credit associated with them or not.<br/><br/>  
<strong><a href="<?php echo base_path(); ?>online-courses/non-credit-courses">Non-Credit Refresher Courses</a></strong><br/><br/>
<div style="margin-left:25px;">Click on the above link to find a list of refresher courses offered through the VCN.  These courses have been designed to cover basic foundation subject matter, such as English and Math.</div><br/>
<strong><a href="<?php echo base_path(); ?>online-courses/for-credit-courses">For-Credit Courses</a></strong><br/><br/>
<div style="margin-left:25px;">Click on the above link to find a list of "for-credit" courses and programs offered by the VCN. You will also find information on how to arrange to take the examination needed to qualify for the credit recommended by ACE.</div><br/>
<strong><a href="<?php echo base_path(); ?>online-courses/hit">Healthcare Information Technology Program</a></strong><br/><br/>
<div style="margin-left:25px; margin-bottom:10px;">Click on the above link to find details of the program offered by VCN. You will also find information on how to take a test to get certification etc when applicable.</div> 
	  </ul>
    </ul>
    
<ul style="margin:0; padding:0;">
  <li style="cursor:pointer; list-style-type: none; margin:0; padding: 5px 0 5px 0;" onclick="javascript:cl_expcol('expand5');"><div class="title2"><a id='expand5operator' title="expand/collapse list" style="font-family:monospace;color: rgb(255,255,255); text-decoration:none;"><font color="FFFFFF">[-]</font></a> Intelligent Reading Tutor </div></li>
	<ul id="expand5">
    	<div>
			<p>Improve your reading ability by 2-3 grade levels in just a few weeks and learn about healthcare at the same time. </p>
			<p><a href="http://www.i-a-i.com/gradations/aacc" target="_blank">Click here</a> to go to the Reading Tutor.</p>
			
    	</div>
	</ul>
</ul>

    
<ul style="margin:0; padding:0;">
  <li style="cursor:pointer; list-style-type: none; margin:0; padding: 5px 0 5px 0;" onclick="javascript:cl_expcol('expand6');"><div class="title2"><a id='expand6operator' title="expand/collapse list" style="font-family:monospace;color: rgb(255,255,255); text-decoration:none;"><font color="FFFFFF">[-]</font></a> NTER's Online Courses </div></li><br />
    <ul id="expand6">
    	<div>
			The VCN also operates as a "node" on the National Training and Education Resource (NTER) developed by the US Department of Energy.  NTER is designed to revolutionize how online training and education is accessed, created, shared, and delivered.  <a href="javascript:popit('/careerladder/Resourcespdfs/NTER_Data_Sheet_4-24-2012.pdf')">Click here</a> to learn more about NTER.  
			<p><a href="https://nter.vcn.org/" target="_blank">Click here</a> to go to the VCN's NTER Node.</p>
			<p>Note: In case you receive a warning for Certificate error, page with a heading of "There is a problem with this Web site's security Certificate", click on the "Continue to this Website". That will take you to NTER site.</p>
			
    	</div>
   </ul>
</ul>      
    
<ul style="margin:0; padding:0;">
  <li style="cursor:pointer; list-style-type: none; margin:0; padding: 5px 0 5px 0;" onclick="javascript:cl_expcol('expand4');"><div class="title2"><a id='expand4operator' title="expand/collapse list" style="font-family:monospace;color: rgb(255,255,255); text-decoration:none;"><font color="FFFFFF">[-]</font></a> Free Online Courses </div></li><br />
    <ul id="expand4">
      <table><tr><td>
        Need to brush up on your fundamentals, like language, science or math?  Or, do you just want to learn more about a subject important to you?
        Take a free refresher or developmental course online from one of the following external providers:
      <tr>
        <td style="width: 50%;"><li class="strong">High School Level Coursework (Non-Credit)</li></td>
        <td>&nbsp;</td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://www.gcflearnfree.org/')">Goodwill's GCFLearnFree</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://free-ed.net/free-ed/FreeEdMain01.asp')">The Free Education Network</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://www.hoagiesgifted.org/online_hs.htm#collect')">Hoagies Gifted Education</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript: popit('http://www.qedoc.org/en/index.php?title=Main_Page')">Qedoc</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://www.openculture.com/')">Open Culture</a></td>
      </tr><tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://sofia.fhda.edu/gallery/')">Foothill CC</a></td>
      </tr>
	  <tr>
        <td style="width: 110%;"><li class="strong">Lectures on Math Science, Finance and the Humanities (Non-Credit)</li></td>
        <td>&nbsp;</td>
      </tr><tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://www.khanacademy.org/')">Khan Academy</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://www.hippocampus.org/')">Hippo Academy</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://www.merlot.org/merlot/index.htm')">Merlot</a></td>
      </tr>
	   <tr>
        <td style="width: 50%;"><li class="strong">College Level Coursework and Lectures (Non-Credit)</li></td>
        <td>&nbsp;</td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('https://www.coursera.org/')">Coursera</a></td>
		
	  </tr>
	  <tr>
	  
		<td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://ocw.jhsph.edu/')" >Johns Hopkins University</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://ocw.mit.edu/index.htm')">Massachusetts Institute of Technology</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://ocw.njit.edu/csla/index.php')"> New Jersey Institute of Technology</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://ocw.nd.edu/')">Notre Dame University</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://openlearn.open.ac.uk/')">Open University</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://cnx.org/')">Rice University</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://ocw.tufts.edu/')">Tufts University</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://www.udacity.com/')">Udacity</a></td>
		
	  </tr>
	  <tr>
		<td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://webcast.berkeley.edu/')">University of California at Berkeley</a></td>
      </tr>
	  <tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://open.umich.edu/')">University of Michigan</a></td>
      </tr><tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://www.pitt.edu/~super1/')">University of Pittsburgh</a></td>
      </tr><tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://ocw.usu.edu/index.html')">Utah State University</a></td>
      </tr><tr>

        <td class="indentonline" style="width: 50%;"><a href="javascript:popit('http://oyc.yale.edu/')">Yale University</a></td>
      </tr>

      </td></tr></table></ul>
    </ul>

<?php endif; ?>
</div><!-- end <div class="container"> -->
