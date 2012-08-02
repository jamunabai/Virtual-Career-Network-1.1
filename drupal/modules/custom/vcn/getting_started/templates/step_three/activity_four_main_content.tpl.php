<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<!-- div class="vcn-gs-heading">Choose School/Program</div-->

<p>Displayed below are the schools near you that offer instructional programs that lead to the credential you need 
for entry into your chosen career.  You can narrow the number of schools and programs displayed by selecting the desired Education Level/length of the instructional 
program -- less than 2 years for a certificate program, 2 years for an Associate's Degree, or 4 years for a Bachelor's 
Degree.</p>
<p><strong class="cg_highlight">To view information about the school, click on the school name; from there, you can also click on a link to the 
school's website.   To view further information about the program, click on the program name.</strong>  </p>
<p>In order to continue in the CareerGuide, you will need to choose a specific instructional program; this selects 
the school offering that program by default.  <strong class="cg_highlight">To complete this section, click on the "Make This My Target Program" 
link in the Program Details section (on the right of the screen) of the instructional program that best fits your 
needs and preferences.</strong> </p>
<p><a href="http://caahep.org/content.aspx?ID=64" target="_blank">Things to consider before choosing a program in 
healthcare.</a></p>

<!-- note: we put these radio buttons in a hidden div because we don't want them right now but we need the selected radio button as the default (at least until we can come back around and clean this up) -->
<div style="display:none;">
<input type="radio" id="ftype_ecb" name="ftype_ecb" value="" onclick="$('#type_ecb').val(this.value); updateGettingStartedActivity('<?php echo $vars['current_step'];?>', <?php echo $vars['current_activity'];?>);" <?php if (!$vars['type_ecb']) echo 'checked="checked"';?> /><label for="ftype_ecb">All</label>
<br />
<input type="radio" id="ftype_ecb_c" name="ftype_ecb" value="C" onclick="$('#type_ecb').val(this.value); updateGettingStartedActivity('<?php echo $vars['current_step'];?>', <?php echo $vars['current_activity'];?>);" <?php if ($vars['type_ecb'] == 'C') echo 'checked="checked"';?> /><label for="ftype_ecb_c">Classroom</label>
<br />
<input type="radio" id="ftype_ecb_e" name="ftype_ecb" value="E" onclick="$('#type_ecb').val(this.value); updateGettingStartedActivity('<?php echo $vars['current_step'];?>', <?php echo $vars['current_activity'];?>);" <?php if ($vars['type_ecb'] == 'E') echo 'checked="checked"';?> /><label for="ftype_ecb_e">E-learning</label>
</div>