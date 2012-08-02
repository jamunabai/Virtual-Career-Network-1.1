<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

	<?php
	global $user;
	$path1 = $_SERVER['SERVER_NAME'];
	$path2 = $_SERVER['REQUEST_URI'];
	$path3 = explode('/', $path2);
	//print_r($path1);print_r($path2); exit;
	//echo($path);
	 //$url = (!empty($_SERVER['HTTPS'])) ? "https": "http";
	 $url = "https";
if (!($user->uid)):?>
	
<div class="vcn-gs-heading">Status : Not Logged In</div>
<p style="margin-left:10px; margin-right:10px">Do not have an account yet? &nbsp <br />  <b><a href="<?php  echo $url.'://'.$path1.'/'.$path3[1].'/user/register';?>">Click here </a> to Register. </b></p> 
<p style="margin-left:10px; margin-right:10px">Have an account already? &nbsp <br /> <b><a href="<?php  echo $url.'://'.$path1.'/'.$path3[1].'/user';?>">Click here </a> to Log in. </b></p>
<?php else:?>
<div class="vcn-gs-heading">Status : Logged In</div>
<?php endif; ?>

