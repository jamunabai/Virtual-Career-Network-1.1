<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 

$onetcode = $_GET['onetcode'];

if (!$onetcode)
$onetcode = $_POST['onetcode'];

$dir = base_path() . drupal_get_path('module','occupations_ladder');

$path = "..".$dir."/images/".$onetcode.".jpg";

if (file_exists($path)): ?>

<a toptions="type = iframe, title=Career Pathway, shaded = 1, width=945, height=600, scrolling=no, resizable = 0" title="Career Pathway" href="/careerladder/careerladder.php?onetcode=<?php echo $onetcode; ?>"><img style="margin-left:25px; margin-top:-21px;" alt="See all career steps from here" src="<?php echo $dir; ?>/btn_see_career_pathway_map.png" /></a>

<br/><br/>

<?php endif; ?>
