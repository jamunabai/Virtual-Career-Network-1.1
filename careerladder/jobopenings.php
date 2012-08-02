<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
require_once('../drupal/sites/default/hvcp.config.inc');
        
error_reporting(0);

function get_dsp($zipcode) {

	require_once('vcn.rest.inc');
	
	$rest = new vcnRest;
	
	$rest->setService('occupationsvc');
	$rest->setModule('occupation');
	$rest->setAction('list');
	$rest->setRequestKey('jl','on');
	$rest->setRequestKey('dl','desc');
	
	if ($zipcode)
	$rest->setRequestKey('zipcode',$zipcode);
	
	// standard filters
	$rest->setRequestKey('format','xml');
	$rest->setRequestKey('limit','10');
	
	$rest->setMethod('post');
	
	$content = $rest->call();
	
	$content = new SimpleXMLElement($content);
	
	$content = $content->data;
	
	return $content;
 
}

//change the maxjob in the function for the variable $jobpagemax to make sure that you are getting $maxjob number of jobs
$maxjob = 100;
function jobopenings($occtitle,$zipcode){

    if (!$zipcode || $zipcode=="") {
        $zipcode=0;
    }

    $distance=50;
    $jobpagemin = 1;
    $jobpagemax=100;

      $objDOM = new DOMDocument();
      $objDOM2 = '';
      
      if ($objDOM->load($GLOBALS['hvcp_config_dea_web_service_url'] . "?kw=patient+representatives&kw=clinical+nurse+specialists&kw=home+health+aides&kw=personal+care+aides&kw=medical+assistants+physician&kw=licensed+practical&kw=licensed+vocational+nurses&zc1=$zipcode&rd1=$distance&rs=$jobpagemin&re=$jobpagemax&cn=100&key=" . $GLOBALS['hvcp_config_dea_web_service_key'] . "&so=initdate") === true) {
      	for ($j=0; $j<3; $j++) {
        	sleep(1);
            if ($objDOM->load($GLOBALS['hvcp_config_dea_web_service_url'] . "?kw=patient+representatives&kw=clinical+nurse+specialists&kw=home+health+aides&kw=personal+care+aides&kw=medical+assistants+physician&kw=licensed+practical&kw=licensed+vocational+nurses&zc1=$zipcode&rd1=$distance&rs=$jobpagemin&re=$jobpagemax&cn=100&so=initdate&key=" . $GLOBALS['hvcp_config_dea_web_service_key']) === true) {
            	break;
			}
        }
      	$objDOM2 = new DOMDocument();
      	$objDOM2->loadXML(str_replace('&', ' ', $objDOM->saveXML()));
      }
          
      if ($objDOM2) {
	      $note = $objDOM2->getElementsByTagName("job");
	      return $note;
      } else {
      	  return false;
      }
}

$zipcode=$_GET['zipcode'];
    
for ($i=0; $i<79; $i++) {
	$content[$i]='someoccupation';    	
}

$noteListing = jobopenings($content[0],$zipcode);

if ($noteListing) {
	// to get the job count to display the message
	$jobcount=0;
	    
	$nb = $noteListing->length;
	for ($i=0; $i < $nb; $i++) {
		$jobcount++;
	}
	    
	echo '<div id="job_listing" style="display:inline;">';
	echo '    <div class="vcn-gs-heading">Job Openings</div>';
	 
	if($jobcount >= 1) {
	    echo"<p>Review these job openings to learn more about each of these jobs.</p>";
	} else {
	    echo"<p>Jobs not found for ZIP Code entered.</p>";
	}  
	echo '<table width="100%" cellpadding="12" style="font-size:12.5px" style="font-style:arial">';
	    
	$count=3;
	$occcount=0;
	
	foreach ($content as $occupation):
	    $occcount++;
		
		if ($occcount>1) {
			break;
		}
	
		echo '<tr><td>';
	
	    $jobcount=0;
	              
		if ($occcount==1) {
		    echo '<div style = "display:block;" id = "occupation'.$occcount.'">';
		} else {
		    echo '<div style = "display:block;" id = "occupation'.$occcount.'">';
		}
	
		$alljobs = array();
		$templocationarray = array();
		
		$jobnumberten=0;
	
		for ($i=0; $i < $nb; $i++) {
			$noteNode = $noteListing->item( $i );
	
			$jobcount++;
			$titles = $noteNode->getElementsByTagName("title");
			$title  = $titles->item(0)->nodeValue;
		
			$companies = $noteNode->getElementsByTagName("company");
			$company  = $companies->item(0)->nodeValue;
		
			$locations = $noteNode->getElementsByTagName("location");
			$location  = $locations->item(0)->nodeValue;
		
			$datesacquired = $noteNode->getElementsByTagName("dateacquired");
			$dateacquired  = $datesacquired->item(0)->nodeValue;
		
			$urls = $noteNode->getElementsByTagName("url");
			$url  = $urls->item(0)->nodeValue;
		
			$title = substr( $title, 0, 25);
		
			if(strlen($titles->item(0)->nodeValue) > 25)
			$title = $title.'...';
		
			if ($jobcount<=$maxjob) {
		
				if ($jobcount>0) {
		
					$countar = array(0,0,0,0,0,0,0,0,0,0,0,0);
		
					for ($jcu=1; $jcu<$jobcount; $jcu++) {
						$samecount=0;
						$old = strtolower($alljobs[$jobcount-$jcu]);
						$new = strtolower($title."|".$location ."|".$url);
						 
						for ($jc=0; $jc<=10; $jc++) {
							// this is the number of charecters that should be compared for each of the jobs
							$arraykey = strlen(key($new));
							if($old[$jc]==$new[$jc]){
								$countar[$jcu]++;
							}
						}
					}
		
					if (in_array('11', $countar))
					$samecount=11;
					else
					$samecount=0;
		
					if ($samecount<10){
						// this is the number of charecters that should be compared for each of the jobs
						$jobnumberten++;
						$alljobs[$jobcount] = $title."|".$location ."|".$url;
					} else {
						$jobcount--;
					}
				} else {
					$alljobs[$jobcount] = $title."|".$location ."|".$url;
				}
			}
		
			if ($jobnumberten == 10){
				// this is the number of jobs that should be displayed in the step
				break;
			}
		}
		
		
		$alljobsu = array_unique($alljobs);
		$elsecount = 0;
		
		for ($i=0; $i<$maxjob; $i++){
			if (!$alljobsu[$i]) {
				continue;
			} else {
				$temp = explode('|', $alljobsu[$i]);
				$temptitle = $temp[0];
				$templocation= $temp[1];
				$tempurl[] = $temp[2];
				$templocationarray[] = $templocation;
				$temptitlearray[] = $temptitle;
			}
		}
		for($i=0; $i<$maxjob; $i++) {
			if(!empty($temptitlearray[$i])) {
				echo "<li>  <a href=\"".$tempurl[$i]."\" target=\"_blank\">".$temptitlearray[$i]."</a></li>\n";
			}
		}
	
		echo '</div>';
		
		$jobcount=0;
		
		// this DIV is used in the getCountryCallback function in activity_three_sidebar_detail.tpl.php
		// to display the locations of the jobs on the map 
		echo '<div style = "display:none;" id = "job-locations">';
		if ($occcount==1) {
			for ($i=0; $i<10; $i++) {
				echo "'".$templocationarray[$i]."'"."#";
			}
		}
		echo '</div>';
	
	    echo '</td></tr>';
	
	endforeach; 
}

echo '</table>';
echo '</div>';
?>
