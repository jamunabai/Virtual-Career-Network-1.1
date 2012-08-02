<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

function getSimilars($data) {

	$key=-1;
	foreach ($data->relatedoccupation as $value) {
		$key++;
		if ($key<3) {
			$thisonetcode = $data->relatedoccupation[$key]->occupation->onetcode;
			$thistitle = $data->relatedoccupation[$key]->occupation->title;
			$thistraining = $data->relatedoccupation[$key]->typicaltraining->title;
			$entry = intval($data->relatedoccupation[$key]->occupation->wageocc->item[1]->pct25);
			$experience = intval($data->relatedoccupation[$key]->occupation->wageocc->item[1]->pct75);
			$thissalary = "$".number_format($entry,0,'.',',')." - $".number_format($experience,0,'.',',');

			if (!number_format($entry,0,'.',',') || !number_format($experience,0,'.',','))
				$thissalary = 'Not available.';

			$output .= "<b><a href='".base_path()."careerdetails?onetcode=$thisonetcode'>$thistitle</a></b><br/>";
			$output .= "<b>Typical Education:</b> ".getTraining($thistraining)."<br/>";
			$output .= "<b>Salary:</b> ".$thissalary."<br/><br/>";
		}

	}

	return $output;


}
$onetcode = $_GET['onetcode'];

if (!$onetcode)
$onetcode = $_POST['onetcode'];

if (!$onetcode)
	$doesitwork = "No data found";

if ($onetcode) {

  $cp = dirname(dirname(drupal_get_path('module','occupations_similar')));

  require_once($cp . '/vcn.rest.inc');

  $rest = new vcnRest;

  $rest->setSecret('');
  $rest->setBaseurl(getBase());
  $rest->setService('occupationsvc');
  $rest->setModule('relatedoccupations');
  $rest->setAction('list');

  // standard filters
  $rest->setRequestKey('apikey','apikey');
  $rest->setRequestKey('format','xml');
  $rest->setRequestKey('onetcode',$onetcode);

  $rest->setMethod('post');

  $content = $rest->call();


  if (isset($content['NODATA'])) {
    $content = new SimpleXMLElement($content);
//    $content = json_decode($content);


if ($content->status->code=="fail")
	$doesitwork="No data found";
else
	$doesitwork="";

    $content = $content->data;

	//print_r($content->relatedoccupation[0]->occupation); exit;

  if (isset($_GET['debug'])) {
    echo "<div style='border: 1px black solid;'><p><pre>";
    print_r($content);
    echo "</pre></p></div>";
  }

    //$videoImage = getVideoImage($onetcode);
    //$annualSalary = getAnnualSalary($content->VCN_WageOcc);
    //$hourlyWage = getHourlyWage($content->VCN_WageOcc);

  }

}
?>

<?php if ($content->relatedoccupation) : ?>
<div style="margin-left:27px;">
<br/>
<span class="lineunder">Similar Careers</span>
<br/><br/>
<div>


                                <div id="similar">
                                                <?php echo getSimilars($content); ?>
                                </div>


(Data Drawn from O*NET)


</div>
</div>
  <?php endif; ?>