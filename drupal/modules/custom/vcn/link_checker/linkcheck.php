<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

function readContents($url)
  {
  $content=file_get_contents($url);
  return $content;
  }

if (isset($_POST['submitted'])) {

	$url = $_POST['url'];
	$valid = @fsockopen("$url", 80, $errno, $errstr, 30);

	$page = $_SERVER['PHP_SELF'];

	$content = readContents($url);

	if (!$valid && $content=="") {

		// Output Error Message
		echo '<h3>'.$url.'</h3>
		<p><span style="color:#EE0000">Sorry, but that link is <b>not</b> valid.</span></p>
		<p>Would you like to <a href="'.$page.'">check another link?</a>';

	} else {

		// Output Success Message!
		echo '<h3>'.$url.'</h3>
		<p><span style="color:#458B00">The link you have entered, is valid!</span></p>';

		echo '<p>Would you like to <a href="'.$page.'">check another link?</a>';

	}
} else {
?>

<h3>Link Verifier</h3>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<p><b>URL :</b> <input type="text" name="url" size="30" value="Input Link" /></p>
<div align="center"><input type="submit" name="submit" value="Check" /></div>
<input type="hidden" name="submitted" value="TRUE" />
</form>

<?php
}
?>
