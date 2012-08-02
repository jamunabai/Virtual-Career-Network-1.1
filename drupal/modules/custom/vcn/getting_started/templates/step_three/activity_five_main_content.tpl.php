<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<!-- div class="vcn-gs-heading">Identify Certification</div-->

<?php if ( $data['certifications'] ) :?>
<p>The certifications associated with the target career you have chosen are shown in the box below.   
<strong class="cg_highlight">Click on 'Certification Name' to see the detailed information about that certification on the right side of 
the screen.</strong>  Note that in order to become eligible to attain some certifications, you may first be required 
to complete a certification or degree program at an accredited college or university. </p>
<?php else : ?>
<p>The Target Career you have chosen does not require certification. Move on to the next step.</p>
<?php endif; ?>