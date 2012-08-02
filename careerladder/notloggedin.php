<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
require_once('../drupal/sites/default/hvcp.functions.inc');

$basepath = $GLOBALS['hvcp_config_default_base_path']; 
?>
<body bgcolor="#F2F2F2" style="font-family: Verdana; font-size:12px;">
The career has been saved in your wish list.<br/>
If you are a new user, we encourage you to create an account by <a href="<?php echo $basepath; ?>user/register" target="_top">clicking here</a>.<br/>
If you already have an account, please <a href="<?php echo $basepath; ?>user/login" target="_top">click here</a> to login.
</body>