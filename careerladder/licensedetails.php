<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
require_once('vcn.rest.inc');

$rest = new vcnRest;

$rest->setService('trainingsvc');
$rest->setModule('licenses');
$rest->setAction('list');

// standard filters
$rest->setRequestKey('format','xml');

$rest->setRequestKey('licenseid',$_GET['id']);

$rest->setMethod('post');

$content = $rest->call();

$content = new SimpleXMLElement($content);

$content = $content->data;
?>
<body bgcolor="#ffffff">
<div id="pagediv" style="background : #ffffff; width : 764px; overflow : auto; font-family : Verdana; font-size: 12px; padding:10px;">

<?php echo $content->licenses->licdesc; ?>

</div>