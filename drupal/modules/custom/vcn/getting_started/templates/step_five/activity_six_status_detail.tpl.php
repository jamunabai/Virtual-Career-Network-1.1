<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<div class="vcn-gs-heading">My Choices</div>
<?php if ($vars['target_occupation-title']): ?>
<div id="vcn-gs-target-occupation-title" class="vcn-gs-target"><span>Target Career: </span><?php echo $vars['target_occupation-title']; ?></div>
<?php else : ?>
<div id="vcn-gs-target-occupation-title" class="vcn-gs-target"><span>Target Career: </span>No career targeted</div>
<? endif; ?>

<?php if ($vars['target_licensename']): ?>
<div id="vcn-gs-target-licensename" class="vcn-gs-target"><span>License: </span><?php echo $vars['target_licensename']; ?></div>
<?php else: ?>
<div id="vcn-gs-target-licensename" class="vcn-gs-target"><span>License: </span>No license targeted</div>
<?php endif;?>

<?php if ($vars['target_certname']): ?>
	<div id="vcn-gs-target-certname" class="vcn-gs-target"><span>Certification: </span><?php echo $vars['target_certname']; ?></div>
<?php else: ?>
	<div id="vcn-gs-target-certname" class="vcn-gs-target"><span>Certification: </span>No certification targeted</div>
<?php endif;?>

<?php if ($vars['target_programname']): ?>
	<div id="vcn-gs-target-programname" class="vcn-gs-target"><span>Program: </span><?php echo $vars['target_programname']; ?></div>
<?php else: ?>
	<div id="vcn-gs-target-programname" class="vcn-gs-target"><span>Program: </span>No program targeted</div>
<?php endif;?>

<?php if ($vars['GETTINGSTARTED']['hsgrad']): ?>
	<div id="vcn-gs-uk-hsgrad" class="vcn-gs-target"><span>HS Grad?: </span><?php echo $vars['GETTINGSTARTED']['hsgrad']; ?></div>
<?php else: ?>
	<div id="vcn-gs-uk-hsgrad" class="vcn-gs-target"><span>HS Grad?: </span>Yes</div>
<?php endif;?>

<?php /* if ($vars['GETTINGSTARTED']['legalrequirementsmet']): ?>
<div id="vcn-gs-uk-legalrequirementsmet" class="vcn-gs-target"><span>Legal Requirements Met: </span><?php echo $vars['GETTINGSTARTED']['legalrequirementsmet']; ?></div>
<?php else: ?>
<div id="vcn-gs-uk-legalrequirementsmet" class="vcn-gs-target"><span>Legal Requirements Met: </span>Yes</div>
<?php endif;?>

<?php if ($vars['GETTINGSTARTED']['medicalrequirementsmet']): ?>
<div id="vcn-gs-uk-medicalrequirementsmet" class="vcn-gs-target"><span>Medical Requirements Met: </span><?php echo $vars['GETTINGSTARTED']['medicalrequirementsmet']; ?></div>
<?php else: ?>
<div id="vcn-gs-uk-medicalrequirementsmet" class="vcn-gs-target"><span>Medical Requirements Met: </span>Yes</div>
<?php endif; */ ?>


<?php if ($vars['GETTINGSTARTED']['testscores']): ?>
	<div id="vcn-gs-uk-testscores" class="vcn-gs-target"><span>Test Scores: </span><?php echo $vars['GETTINGSTARTED']['testscores']; ?></div>
<?php else: ?>
	<div id="vcn-gs-uk-testscores" class="vcn-gs-target"><span>Test Scores: </span>Yes</div>
<?php endif;?>


<?php if ($vars['GETTINGSTARTED']['prequisitecourses']): ?>
	<div id="vcn-gs-uk-prequisitecourses" class="vcn-gs-target"><span>Prerequisite Courses: </span><?php echo $vars['GETTINGSTARTED']['prequisitecourses']; ?></div>
<?php else: ?>
	<div id="vcn-gs-uk-prequisitecourses" class="vcn-gs-target"><span>Prerequisite Courses: </span>No</div>
<?php endif;?>

<?php
/*  TODO Figure this out
<?php if ($vars['GETTINGSTARTED']['refreshercourses']): ?>
	<div id="vcn-gs-uk-refreshercourses" class="vcn-gs-target"><span>Refresher Courses:</span><?php echo $vars['GETTINGSTARTED']['refreshercourses']; ?></div>
<?php else: ?>
	<div id="vcn-gs-uk-refreshercourses" class="vcn-gs-target"><span>Refresher Courses: </span>No</div>
<?php endif;?>
*/
?>
