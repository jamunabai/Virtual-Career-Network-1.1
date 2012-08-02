<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script language="javascript" type="text/javascript" src="<?php echo base_path() . drupal_get_path('module','occupations_ladderjs'); ?>/jit-yc.js"></script>

<!--[if IE]><script language="javascript" type="text/javascript" src="<?php echo base_path() . drupal_get_path('module','occupations_ladderjs'); ?>/excanvas.js"></script><![endif]-->

<script language="javascript" type="text/javascript" src="<?php echo base_path() . drupal_get_path('module','occupations_ladderjs'); ?>/example1.js"></script>


<body onload="init();">
<div id="container">


<div id="center-container">
<div id="id-list"></div>
    <div id="infovis"></div>    
</div>

<div id="right-container">
<div id="log"></div>
<br/><br/>

<input type="radio" id="s-normal" name="selection" checked="checked" value="normal" style="display:none;" />

</div>


</div>
</body>