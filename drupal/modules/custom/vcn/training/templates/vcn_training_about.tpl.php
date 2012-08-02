<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

 <p class="intro">
 Choose from more than 10,000 courses and training programs from around the country to prepare you for a variety of healthcare careers.
 </p>
 
 
<div id="training-search-container">
 	<?php echo $content['search']; ?>
</div>
 
<div id="training-content" class="panel-2col panel-col-first">
	<?php echo $content['main'];?>
</div>

<div id="training-sidebar" class="panel-2col panel-col-last">
	<?php echo $content['sidebar']; ?>
</div>