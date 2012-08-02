<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-two');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','3');
function thedefault(thisvalue) {
	if (thisvalue=="nurse")
		document.getElementById('thedefault').style.display = 'block';
	document.getElementById('ofc').style.display = 'none';
	document.getElementById('hlp').style.display = 'none';
	document.getElementById('college').style.display = 'none';
}
function ofc() {
	document.getElementById('ofc').style.display = 'block';
	document.getElementById('hlp').style.display = 'none';
	document.getElementById('thedefault').style.display = 'none';
	document.getElementById('college').style.display = 'none';

	if ($('input[name=group4]:checked').val()=='college')
		college();
}

function hlp() {
	document.getElementById('ofc').style.display = 'none';
	document.getElementById('hlp').style.display = 'block';
	document.getElementById('thedefault').style.display = 'none';
	document.getElementById('college').style.display = 'none';

	if ($('input[name=group4]:checked').val()=='college')
		college();
}

function college() {
	document.getElementById('college').style.display = 'block';
	document.getElementById('ofc').style.display = 'none';
	document.getElementById('hlp').style.display = 'none';
	document.getElementById('thedefault').style.display = 'none';

}

function none() {
	document.getElementById('ofc').style.display = 'none';
	document.getElementById('hlp').style.display = 'none';
	document.getElementById('thedefault').style.display = 'none';
	document.getElementById('college').style.display = 'none';
}


function csrn() {
	document.getElementById('snapshot').innerHTML = '<span class="vcn-gs-heading-black" style="margin-left:10px">Career Snapshot</span><br/><br/><b>Registered Nurse</b><br/><br/><b>Description</b><br/>Assess patient health problems and needs, develop and implement nursing care plans, and maintain medical records.<br/><br/><b>Typical Skills</b><br/>Social Perceptiveness, Coordination, Monitoring, Reading Comprehension, Active Listening<br/><br/><b>Tools and Technology</b><br/><br/><b>Tools:</b> Vacutainer tubes, Vacuum extractors, Venous Oxygen Saturation SVO2 monitors, Ventilators<br/><br/><b>Technology:</b> DoctorsPartner EMR, Drug guide software, Eclipsys software, Eclipsys Sunrise Clinical Manager<br/><br/><b>Education and Training Required</b><br/>Associate\'s Degree<br/><br/><center><a href="javascript:void(0);" onclick="saveit(\'<?php echo base_path(); ?>cma/notebook/target/career/29-1141.00\'); gogetit(\'Registered Nurse\', \'29-1141.00\', \'29-1141-00\');" >Make This My Chosen Target Career 1 </a></center>';

}

function cspt() {
	document.getElementById('snapshot').innerHTML = '<span class="vcn-gs-heading-black" style="margin-left:10px">Career Snapshot</span><br/><br/><b>Pharmacy Technician</b><br/><br/><b>Description</b><br/>Prepare medications under the direction of a pharmacist. May measure, mix, count out, label, and record amounts and dosages of medications.<br/><br/><b>Typical Skills</b><br/>Active Listening, Reading Comprehension, Critical Thinking, Service Orientation, Speaking<br/><br/><b>Tools and Technology</b><br/><br/><b>Tools:</b> Agar slides, Autoclaves, Automatic bottle filling machines<br/><br/><b>Technology:</b> Billing and reimbursement software, Cardinal Health Pyxis CII Safe, Compounder software, Database software, Drug compatibility software<br/><br/><b>Education and Training Required</b><br/>Post-Secondary Certificate<br/><br/><center><a target="_blank"  href="<?php echo base_path(); ?>careerdetails?onetcode=29-2052.00">View Career Details</a><br/><br/><a href="javascript:void(0);" onclick="saveit(\'<?php echo base_path(); ?>cma/notebook/target/career/29-2052.00\'); gogetit(\'Pharmacy Technician\', \'29-2052.00\', \'29-2052-00\');" >Make This My Chosen Target Career 2 </a></center>';

}

function csmt() {
	document.getElementById('snapshot').innerHTML = '<span class="vcn-gs-heading-black" style="margin-left:10px">Career Snapshot</span><br/><br/><b>Medical Transcriptionist</b><br/><br/><b>Description</b><br/>Use transcribing machines with headset and foot pedal to listen to recordings by physicians and other healthcare professionals dictating a variety of medical reports, such as emergency room visits, diagnostic imaging studies, operations, chart reviews, and final summaries.<br/><br/><b>Typical Skills</b><br/>Reading Comprehension, Active Listening, Writing, Monitoring, Speaking<br/><br/><b>Tools and Technology</b><br/><br/><b>Tools:</b> Desktop computers, Desktop transcribers, Dictaphones, Fax machines, Laser printers<br/><br/><b>Technology:</b> Boston Bar Systems Corporation Sonnet, Bytescribe Development Company WavPlayer, Calendar software, Corel WordPerfect software, Crescendo Systems Corporation MedRite-XL<br/><br/><b>Typical Training Required</b><br/>Some College Courses<br/><br/><center><a href="javascript:void(0);" onclick="saveit(\'<?php echo base_path(); ?>cma/notebook/save/career/31-9094.00\'); gogetit(\'Medical Transcriptionist\', \'31-9094.00\', \'31-9094-00\');" >Add to My Wish List</a></center>';

}

function snapshotold(title,desc,skills,education,tools,tech,onet,dashonet) {
	document.getElementById('snapshot').innerHTML = '<span class="vcn-gs-heading-black" style="margin-left:10px">Career Snapshot</span><br/><br/><b>'+title+'</b><br/><br/><b>Description</b><br/>'+desc+'<br/><br/><b>Typical Skills</b><br/>'+skills+'<br/><br/><b>Tools</b><br/>'+tools+'<br/><br/><b>Technology</b><br/>'+tech+'<br/><br/><b>Education and Training Required</b><br/>'+education+'<br/><br/><center><a target="_blank" href="<?php echo base_path(); ?>careerdetails?onetcode='+onet+'">View Career Details</a><br/><br/><a href="javascript:void(0);" onclick="saveit(\'<?php echo base_path(); ?>cma/notebook/target/career/'+onet+'\'); gogetit(\''+title+'\', \''+onet+'\', \''+dashonet+'\');" >Make This My Chosen Target Career 3 </a></center>';
}

function snapshot(title,desc,skills,education,tools,tech,onet,dashonet) {
	desc = desc.substr(0,225);

	document.getElementById('snapshot').innerHTML = '<span class="vcn-gs-heading-black" style="margin-left:-5px">Career Snapshot</span><br/><br/><br/><b>'+title+'</b><br/><br/><b>Description</b> <span id="sixdesc" onclick="showhidega(\'sixdesctext\',1);" style="cursor:pointer;">[+]</span><div id="sixdesctext" style="display:none; margin-bottom:-15px;">'+desc+'</div><br/><br/><b>Typical Skills</b> <span id="sixskills" onclick="showhidega(\'sixskillstext\',1);" style="cursor:pointer;">[+]</span><div id="sixskillstext" style="display:none; margin-bottom:-15px;">'+skills+'</div><br/><br/><b>Tools</b> <span id="sixtools" onclick="showhidega(\'sixtoolstext\',1);" style="cursor:pointer;">[+]</span><div id="sixtoolstext" style="display:none; margin-bottom:-15px;">'+tools+'</div><br/><br/><b>Technology</b> <span id="sixtech" onclick="showhidega(\'sixtechtext\',1);" style="cursor:pointer;">[+]</span><div id="sixtechtext" style="display:none; margin-bottom:-15px;">'+tech+'</div><br/><br/><b>Education & Training Required</b> <span id="sixed" onclick="showhidega(\'sixedtext\',1);" style="cursor:pointer;">[+]</span><div id="sixedtext" style="display:none; margin-bottom:-15px;">'+education+'</div><br/><br/><center><a target="_blank" toptions="type = iframe, width = 720, height = 750, resizable = 1, layout=flatlook, title=Career Details, scrolling=yes, shaded=1" href="<?php echo base_path(); ?>careerdetails?onetcode='+onet+'">View Career Details</a><br/><br/><a href="javascript:void(0);" onclick="window.scroll(0,0); saveit(\'<?php echo base_path(); ?>cma/notebook/target/career/'+onet+'\'); gogetit(\''+title+'\', \''+onet+'\', \''+dashonet+'\');" ><img alt="Make This My Chosen Target Career" title="Make This My Chosen Target Career" style = "margin-left:-7px;" alt="Bright" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/getting_started/templates/step_two/target_career.png" /></a></center>';
}

function showhidega(value,onoff) {

	var first = (value.substr(0,value.length-4));

	if (document.getElementById(value).style.display=='none') {
		document.getElementById(value).style.display='block';
		document.getElementById(first).innerHTML='[-]';
	}
	else {
		document.getElementById(value).style.display='none';
		document.getElementById(first).innerHTML='[+]';
	}

}


function saveit(url) {
	//loadhere.location.href = url;
<?php /* not_logged_in('<?php global $user; $logged_in = $user->uid; if ($logged_in) echo "U"; else echo "S"; ?>','Career targeted.'); */ ?>
	myRef = window.open(url,'loadhere');
  //$('#vcn-gs-btn-next').removeClass('off');
  //$("#vcn-gs-btn-next").attr('disabled',false);

  //$('#vcn-gs-btn-ano-next').removeClass('off');
  //$('#vcn-gs-btn-ano-next').attr('disabled',false);
 // var logged_in = '<?php echo $logged_in;  ?>';
 // if (logged_in==1)
//	alert('Career targeted.');
	//alert ('Career Saved to Notebook');
}

//vcn_gs_buttons_off();


//salert('should be off');
/*
$(document).ready(function() {
  $('#vcn-gs-btn-next').addClass('off');
  $("#vcn-gs-btn-next").attr('disabled',true);

  $('#vcn-gs-btn-ano-next').addClass('off');
  $('#vcn-gs-btn-ano-next').attr('disabled',true);
});
*/

function gogetit3(thisv,onet,onetdash) {

	$(document).ready(function() {

		if (document.getElementById('cmacontainer6'))
			document.getElementById('cmacontainer6').innerHTML='';
		$('#cmacontainer6').append('<div id="onet-'+onetdash+'"><div style="float:left; width:231px;">'+thisv+'</div>');


	});

}

</script>
<script type="text/javascript" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/javascripts/top_up-min.js"></script>
<script type="text/javascript">
  TopUp.players_path = "/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/players/";
  TopUp.images_path = "/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/images/top_up/";
</script>

<?php
// this function looks to be deprecated!
function joblistings($title) {

        $objDOM = new DOMDocument();
        ini_set('display_errors', 'Off');
		if (strlen($_SESSION['zipcode'])==5)
			$zipcode=$_SESSION['zipcode'];
		else
			$zipcode=0;



$timeout = 2; // seconds
$url = "www.jobcentral.com";
$fp = fsockopen($url, 80, $errNo, $errString, $timeout); // stops connecting after 2 seconds, and stores the error Number in $errNo and the error String in $errStr

if (!$fp)
	return '0';



        for ($j = 1; $j <= 7; $j++) {
            if ($objDOM->load($GLOBALS['hvcp_config_dea_web_service_url'] . "?kw=$title&zc1=$zipcode&rd1=1000&rs=0&re=1000&cn=100&key=" . $GLOBALS['hvcp_config_dea_web_service_key'] . "&so=initdate"))
                break;
            else
                sleep(1);


        }


        $note = $objDOM->getElementsByTagName("job");

        $jobnos = $objDOM->getElementsByTagName("recordcount");
        $recordcount = $jobnos->item(0)->nodeValue;

        ini_set('display_errors', 'On');

        if ($j == 7)
            throw new Exception("Webservice is down.");

        return $recordcount;
}



function getTraining6($training) {

	$pieces = explode(" - ", $training);
	$training = $pieces[0];

	$pieces = explode(" (", $training);
	$training = $pieces[0];

	return $training;

}

function goodImplode6($data, $max, $type) {

	$count=0;

	foreach ($data as $value) {
		$count+=1;
		if ($count<=$max) {
				if ($type=="br")
					$output .= $value."<br/>";
				else
					$output .= $value.", ";
		}
	}

	$output[strlen($output)-2]=' ';

	if (!$count)
		return "Not available.";
	else
		return $output;


}

function getdetails6($onetcode,$zipcode) {

	$drest = new vcnRest;

	$drest->setSecret('');
	$drest->setBaseurl(getBase());
	$drest->setService('occupationsvc');
	$drest->setModule('occupation');
	$drest->setAction('list');

	// standard filters
	$drest->setRequestKey('onetcode',$onetcode);
	$drest->setRequestKey('skills','on');
	$drest->setRequestKey('tt','on');
	//$drest->setRequestKey('jl','on');

	if (strlen($zipcode)==5)
		$drest->setRequestKey('zipcode',$zipcode);

	$drest->setRequestKey('apikey','apikey');
	$drest->setRequestKey('format','xml');

	$drest->setMethod('post');

	$content = $drest->call();

	$content = new SimpleXMLElement($content);

	return $content->data;

}

function yorn($type,$onetcode,$zipcode) {
	$frest = new vcnRest;

	$frest->setSecret('');
	$frest->setBaseurl(getBase());
	$frest->setService('trainingsvc');
	$frest->setModule($type);
	$frest->setAction('count');

	// standard filters
	$frest->setRequestKey('onetcode',$onetcode);
	//$frest->setRequestKey('stfips','');
	$frest->setRequestKey('zip',$zipcode);
	$frest->setRequestKey('apikey','apikey');
	$frest->setRequestKey('format','xml');

	$frest->setMethod('post');

	$content = $frest->call();

	$content = new SimpleXMLElement($content);

	return $content->data->count;

}

  $cp = dirname(dirname(drupal_get_path('module','occupations_detail')));

  require_once($cp . '/vcn.rest.inc');

  $rest = new vcnRest;

  $rest->setSecret('');
  $rest->setBaseurl(getBase());
  $rest->setService('cmasvc');
  $rest->setModule('notebook');

  $cma = vcnCma::getInstance();

  $rest->setAction('get-notebook-items?user_id='.$cma->userid);

  // standard filters
  $rest->setRequestKey('apikey','apikey');
  $rest->setRequestKey('format','xml');


  //$cma = vcnCma::getInstance();


  $rest->setMethod('post');

  $content = $rest->call();

  $content = new SimpleXMLElement($content);

  $rowcount=0;
  foreach ($content->data->contentresults->item as $rows)
	$rowcount++;

//only show 4 rows
	if ($rowcount>4)
		$rowcount=4;


  if ($content->data->notebookresults->item[0]->itemid != $content->data->contentresults->item[0]->onetcode) {

	//$content2->data->contentresults->item[0]=$content->data->contentresults->item[$rowcount-1];
	for ($i=0; $i<$rowcount; $i++) {
		$ionet = md5($content->data->notebookresults->item[$i]->itemid);

		for ($j=0; $j<$rowcount; $j++) {

				$jonet = md5($content->data->contentresults->item[$j]->onetcode);

				if ($jonet == $ionet) {
					$content2->data->contentresults->item[$i] = $content->data->contentresults->item[$j];
					$content2->data->contentresults->item[$i]->itemrank = $content->data->notebookresults->item[$i]->itemrank;
				}

		}

		//$content2->data->contentresults->item[$i] = $content->data->contentresults->item[$i];

	}





  }




	$c=-1;
	$o='nothing';



	foreach ($content->data->notebookresults->item as $nr) {
		$c++;
		if ((string)$content->data->notebookresults->item[$c]->itemrank==1)
			$o = (string)$content->data->notebookresults->item[$c]->itemid;

	}


	$content = $content2->data->contentresults;

 ?>


<!-- span class="vcn-gs-heading">Choose Your Target Career</span-->

<br/>
<span style="font-size:14px;">
A side-by-side comparison of key information for each career in your Wish List is displayed below. 
<strong class="cg_highlight">Click on the title of a career listed here to view its Career Snapshot to the right.</strong> This is also where you 
designate/change a career as your "Target Career". This is the key decision you will need to make before proceeding further.
</span>
<br/><br/>
<table width="100%" cellpadding="5" border="1" style="margin-left:-16px; font-size:12px; border:1px solid #000000;" id="two-six-table">
<tr>
<td bgcolor="#e8e8e8"><b>Title</b></td>
<?php 
for ($count=0; $count<$rowcount; $count++):


$onetcode =  $content->item[$count]->onetcode;

if ($content->item[$count]->displaytitle) {
		$occupation = getdetails6($onetcode,$vars['zip']);
		$pieces = explode ('.',$onetcode);
		$onetcode = $pieces[0].'-'.$pieces[1];

		$tempdesc=str_replace("'", "\'", $occupation->occupation->detaileddescription);
		$pieces = explode ('.',$tempdesc);
		if ($pieces[0])
			$desc=$pieces[0].".";
		//if ($pieces[1])
			//$desc.=$pieces[1].".";
		if (strlen($desc)>225)
			$dots = "";
		$desc = substr($desc, 0, 225);
		if ($dots)
			$desc .= $dots;
		if (stristr($desc,'<p>'))
			$desc = substr($desc, 3, strlen($desc)-3);
		$skills=goodImplode6($occupation->occupation->skills->item,'5','comma');
		$education=str_replace("'", "\'", $occupation->occupation->typicaltraining->title);

		$edarray[$count]=$education;
		
		$ear[$count] = getTraining6($occupation->occupation->typicaltraining->title);

		$tools=goodImplode6($occupation->occupation->toolstechnology->tools->item,'2','comma');
		$tech=goodImplode6($occupation->occupation->toolstechnology->technology->item,'2','comma');
		$onet=$content->item[$count]->onetcode;
		$dashonet=str_replace(".", "-", $onet);

		if (strlen($education)<1)
			$education="Not available.";

			
		$desc = str_replace('"',"''",$desc);
		//$desc = str_replace("'","\'",$desc);
		
		$desc = trim($desc);
		$tools = trim($tools);
		$tech = trim($tech);			
			
if (strlen($skills)<1)
	$skills="Not available.";
if (strlen($tools)<1)
	$tools="Not available.";
if (strlen($tech)<1)
	$tech="Not available.";
if (strlen($desc)<1)
	$desc="Not available.";

?>
<td><b><a href="javascript:void(0);" onclick="snapshot('<?php echo $content->item[$count]->displaytitle; ?>','<?php echo $desc; ?>','<?php echo $skills; ?>','<?php echo $education; ?>','<?php echo $tools; ?>','<?php echo $tech; ?>','<?php echo $onet; ?>','<?php echo $dashonet; ?>')"><?php echo $content->item[$count]->displaytitle; ?></a></b>
<?php
if ($onet==$o) {  echo "<script>gogetit3('".$content->item[$count]->displaytitle."', '".$onet."','".$dashonet."');</script>"; }
?>
</td>
<?php } endfor; ?>
</tr>

<tr>
<td bgcolor="#e8e8e8"><b>Job Outlook</b></td>
<?php
for ($count=0; $count<$rowcount; $count++):

$onetcode =  $content->item[$count]->onetcode;
$pieces = explode ('.',$onetcode);
$onetcode = $pieces[0].'-'.$pieces[1];

if ($content->item[$count]->displaytitle) {
if (stristr($content->item[$count]->jobgrowth->text, 'faster')) {
?>
<td><center><img alt="Bright" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/getting_started/templates/step_two/bright.png" /></center></td>
<?php } else { ?>
<td><center><img alt="Grey" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/getting_started/templates/step_two/grey.png" /></center></td>
 <?php } } endfor; ?>
</tr>

<tr>
<td bgcolor="#e8e8e8"><b># Jobs In Your Area</b></td>
<?php
for ($count=0; $count<$rowcount; $count++):

$onetcode =  $content->item[$count]->onetcode;


$occupation2 = getdetails6($onetcode,$vars['zip']);
//$jl = joblistings($occupation2->occupation->displaytitle);
$thewages[$count]=(($occupation2->occupation->wageocc->item[0]->entrywg+$occupation2->occupation->wageocc->item[0]->experience)/2);

$jl = number_format(floatval($occupation2->occupation->jobgrowth->aopent), 0, '.', ',');

if ($jl=="")
	$jl=0;
//if ($jl>=500)
//	$jl='500+';

$pieces = explode ('.',$onetcode);
$onetcode = $pieces[0].'-'.$pieces[1];


?>
<td><?php echo $jl; ?></td>


 <?php endfor; ?>
</tr>

<tr>
<td bgcolor="#e8e8e8"><b>Wages</b></td>
<?php
for ($count=0; $count<$rowcount; $count++):

$onetcode =  $content->item[$count]->onetcode;
$pieces = explode ('.',$onetcode);
$onetcode = $pieces[0].'-'.$pieces[1];

if ($content->item[$count]->displaytitle) {
?>
<td><?php

//$occupation2->occupation
$wage = $thewages[$count];
//$wage = (($content->item[$count]->wageocc->item[0]->entrywg+$content->item[$count]->wageocc->item[0]->experience)/2);
$wage = number_format(floatval($wage), 0, '.', ',');

if ($wage)
	$wage= '$'.$wage.'/hr';
else
	$wage='N/A';

echo $wage; ?></td>
<?php } endfor; ?>
</tr>

<tr>
<td bgcolor="#e8e8e8"><b>Education and Training</b></td>
<?php
for ($count=0; $count<$rowcount; $count++):

$onetcode =  $content->item[$count]->onetcode;
$pieces = explode ('.',$onetcode);
$onetcode = $pieces[0].'-'.$pieces[1];

	$t = $ear[$count];

	if ($t=="Bachelor's Degree")
		$t = "Bachelor's Degree<br/>(4 year)";

	if ($t=="Associate's Degree")
		$t = "Associate's Degree (2 year)";

	if (strstr($t,"Certificate"))
		$t = "Certificate";


if ($content->item[$count]->displaytitle) {
?>
<td><?php $education = str_replace("\'", "'", $edarray[$count]); echo $education; ?></td>
<?php } endfor; ?>
</tr>

<tr>
<td bgcolor="#e8e8e8"><b>State License Required</b></td>
<?php
for ($count=0; $count<$rowcount; $count++):

$onetcode =  $content->item[$count]->onetcode;
$pieces = explode ('.',$onetcode);
$onetcode = $pieces[0].'-'.$pieces[1];

if ($content->item[$count]->displaytitle) {

	if (yorn('licenses',$content->item[$count]->onetcode,$vars['zip'])>0)
		echo "<td>Yes</td>";
	else
		echo "<td>No</td>";

}

endfor; ?>
</tr>
<tr>
<td bgcolor="#e8e8e8"><b>Certification Required</b></td>
<?php
for ($count=0; $count<$rowcount; $count++):

$onetcode =  $content->item[$count]->onetcode;
$pieces = explode ('.',$onetcode);
$onetcode = $pieces[0].'-'.$pieces[1];

if ($content->item[$count]->displaytitle) {

	if (yorn('certifications',$content->item[$count]->onetcode,$vars['zip'])>0)
		echo "<td>Yes</td>";
	else
		echo "<td>No</td>";

}

endfor; ?>
</tr>

</table>
<iframe name="loadhere" src="" style="height: 0px; width: 0px; border: 0px;"></iframe>

<script>

var twidth = $('#two-six-table').width() + 30;
var tmargin = (465-twidth)/2;
$('#two-six-table').css("margin-left",tmargin);

//alert(twidth);
</script>


<?php
session_start();
// store session data
$_SESSION['url']='getting-started/step-two/6';
?>