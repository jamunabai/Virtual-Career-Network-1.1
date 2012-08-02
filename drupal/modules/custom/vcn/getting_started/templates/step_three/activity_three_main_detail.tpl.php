<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

function getreqs($onetcode, $zipcode) {

	$cp = dirname(dirname(drupal_get_path('module','occupations_detail')));

	require_once($cp . '/vcn.rest.inc');

	$rest = new vcnRest;

	$rest->setSecret('');
	$rest->setBaseurl(getBase());
	$rest->setService('occupationsvc');
	$rest->setModule('occupation');
	$rest->setAction('detail');

	// standard filters
	$rest->setRequestKey('apikey','apikey');
	$rest->setRequestKey('format','xml');
	
	$rest->setRequestKey('onetcode',$onetcode);
	$rest->setRequestKey('zipcode',$zipcode);

	$rest->setMethod('post');

	$content = $rest->call();	

	$content = new SimpleXMLElement($content);

	$content = $content->data;

	return $content;

}
  

 
 
$reqs = getreqs($vars['onetcode'],$vars['zip']);


?> 
<br/>
<b>Medical Requirement</b>
<br/>
<?php echo $reqs->occupation->healthrequirement; ?>

<br/><br/>
<b>Legal Requirement (<?php echo $reqs->occupation->occupationlegalrequirement->item[0]->state; ?>)</b>
<br/>
<?php if (strlen($reqs->occupation->occupationlegalrequirement->item[0]->legalrequirement)) echo $reqs->occupation->occupationlegalrequirement->item[0]->legalrequirement."<br/><br/>"; ?>
<?php if (strlen($reqs->occupation->occupationlegalrequirement->item[0]->absoluteprohibitions))  echo $reqs->occupation->occupationlegalrequirement->item[0]->absoluteprohibitions."<br/><br/>"; ?>
<?php if (strlen($reqs->occupation->occupationlegalrequirement->item[0]->healthissues))  echo $reqs->occupation->occupationlegalrequirement->item[0]->healthissues."<br/><br/>"; ?>
<?php if (strlen($reqs->occupation->occupationlegalrequirement->item[0]->genericrequirements))  echo $reqs->occupation->occupationlegalrequirement->item[0]->genericrequirements."<br/><br/>"; ?>

<?php
if (strlen($reqs->occupation->occupationlegalrequirement->item[0]->associatedurl)>1)
	echo "For additional information, <a target='_blank' href='".$reqs->occupation->occupationlegalrequirement->item[0]->associatedurl."'>click here</a>";
						
?>					