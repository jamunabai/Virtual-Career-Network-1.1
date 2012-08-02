<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

if (!empty($_SERVER['HTTPS'])){
    $url_prot="https://";
} else {
    $url_prot="http://";
}

?>
<script type="text/javascript">
function registerFromMoodleFrame() {
   // set location for a Create Account link inside the moodle frame so that when we return to the page after
   // creating the account, we remain on the framing page
   location = "/healthcare/user/register";
}
function forgotFromMoodleFrame() {
   // set location for a Create Account link inside the moodle frame so that when we return to the page after
   // creating the account, we remain on the framing page
   location = "/healthcare/user/password";
}
</script>

<?php

$courseID=$_GET['id'];
/*
$url = 'http://hvcp2-qa-portal.hvcp.local/moodle/course/view.php?id='.$courseID;
*/
   
//$url_prot = "https://"; // always use https for moodle
$url = '/moodle19/course/view.php?id=' . $courseID;

//$url = hvcp_moodle_server().'/moodle/course/view.php?id='.$courseID;
//print "IFRAME URL IS " . $url . "<br />";
?>
<iframe id="moodleframe" name="moodleframe" src="<?php echo $url; ?>" scrolling="auto" frameborder="0" style="background-color: #f2f2f2" width="1044" height="3800">
</iframe>








