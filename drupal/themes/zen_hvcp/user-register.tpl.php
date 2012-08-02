<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

  <?php
  if(strpos($_SERVER['HTTP_REFERER'],"provider")!==false || $_GET['type'] == 'provider'){ 
     ?>
     <!-- im closing the form  -->
     </form>
	 <?
  }
  ?>
  

<p>
<?php

//if($_GET['type'] == 'provider'){
//This style is jus make sure that the verbiage is above the login tab.
//echo"<div style=\"margin-top: -167px; position: absolute;\"> ";

        //echo $_SERVER['HTTP_REFERER'];echo"<br />";
        if(strpos($_SERVER['HTTP_REFERER'],"provider")!==false)
               // echo "The ability to Register a new account as a provider will be coming soon .. ";
        //print $intro_text;
//echo"</div>";
//}
?>
</p>
<?php
//This page is purposefuly made http because it was throwing a security warning if you send an email from a https page.
$location = "https://".$_SERVER['SERVER_NAME'].base_path()."user/register?type=provider";
//$location = base_path()."user/register?type=provider";
 if (stristr($_SERVER['HTTP_REFERER'],'provider') && !stristr($_SERVER['REQUEST_URI'],'provider') )
        header("Location: $location");

 
global $base_url;
$http_base_url = str_replace("https","http",$base_url);
?>

<div class="my-form-wrapper">
  <?php
  if(strpos($_SERVER['HTTP_REFERER'],"provider")!==false || $_GET['type'] == 'provider'){
  $astric = '<strong href= # style="color:#CC0000; text-decoration: none;">*</strong>';
  ?>
        <form name="registrationform" id="registrationform" action="https://<?php echo $_SERVER['SERVER_NAME'].base_path();?>" onsubmit="return validateForm();"  method="post">

			<LABEL for="userfirstname"><strong>First Name:<?php echo $astric; ?></strong></LABEL><br>
            <INPUT type="text" name="userfirstname" id="userfirstname"><br><br>
            <LABEL for="userlastname"><strong>Last Name:<?php echo $astric; ?></strong></LABEL><br>
            <INPUT type="text" name="userlastname" id="userlastname"><br><br>
                          
            <LABEL for="username"><strong>Username:<?php echo $astric; ?></strong></LABEL><br>
                      <INPUT type="text" name="username" id="username"><br>
                <span style="font-size:0.85em; margin-top: -3px; position: absolute;">Spaces are allowed; punctuation is not allowed except for periods, hyphens, and underscores.  </span> <br><br>
            <LABEL for="emailid"><strong>E-mail Address:<?php echo $astric; ?></strong></LABEL><br>
                      <INPUT type="email" name="emailid" id="emailid"><br>
                <span style="font-size:0.85em; margin-top: -3px; position: absolute;">A valid e-mail address from the educational institution you represent. All e-mails from the system will be sent to this address. The e-mail address is not made public and will not be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail.</span> <br><br>
            <LABEL for="phone"><strong>Phone:<?php echo $astric; ?></strong></LABEL><br>
                      <INPUT type="text" name="phone" id="phone"><br>
                      <span style="font-size:0.85em; margin-top: -3px; position: absolute;">A phone number is needed to help authorize the account.</span><br><br>
            <LABEL for="title"><strong>Title:<?php echo $astric; ?></strong></LABEL><br>
                      <INPUT type="text" name="title" id="title"><br><br>
            <LABEL for="institutionname"><strong>Institution Name:<?php echo $astric; ?></strong></LABEL><br>
                      <INPUT type="text" name="institutionname" id="institutionname"><br><br>
			<LABEL for="institutionwebsite"><strong>Institution Website:<?php echo $astric; ?></strong></LABEL><br>
                      <INPUT type="text" name="institutionwebsite" id="institutionwebsite"><br><br>
            <input id="disclaimer" name="disclaimer" type="checkbox" value="yes" /> <?php echo $astric; ?> <strong>Disclaimer:</strong> I certify that I am an authorized representative of the subject organization and accept full responsibility for the accuracy and completeness of the education program information provided.<br><br><br>  
            <INPUT type="image" src="<?php echo base_path(); ?>/sites/default/files/images/buttons/create_new_account.png" alt="reate new account" onclick="if(!document.getElementById('disclaimer').checked) { alert('You must check the disclaimer before creating your account');return false; }"> 
            <?php $providerportalhome = base_path().'/providerlogin?user=provider' ?>
			<img src="<?php echo base_path(); ?>/sites/default/files/images/buttons/cancel.png" alt="cancel" onclick="window.location='<?php echo $providerportalhome; ?>'" style="cursor:pointer;">
         </form>

		<br>
        <strong>Note: An e-mail will be sent once your registration is confirmed.</strong> <br><br>
        <i>Items with an asterisk(<?php echo $astric; ?>) must be filled in.</i>
        
<script language="JavaScript" type="text/javascript">//<![CDATA[
//You should create the validator only after the definition of the HTML form
var frmvalidator  = new Validator("registrationform");
frmvalidator.addValidation("userfirstname","req","Please enter your First Name");
frmvalidator.addValidation("userlastname","req","Please enter your Last Name");
frmvalidator.addValidation("username","req","Please enter your User Name");
frmvalidator.addValidation("emailid","req","Please enter your E-mail Address");
frmvalidator.addValidation("emailid","email","Please enter a valid E-mail Address");
frmvalidator.addValidation("institutionname","req","Please enter your Institution Name");
frmvalidator.addValidation("title","req","Please enter your Title");
frmvalidator.addValidation("phone","req","Please enter your Phone Number");
frmvalidator.addValidation("institutionwebsite","req","Please enter the Institution's Website");
frmvalidator.addValidation("disclaimer","req","Please check the disclaimer");

//]]>
</script>
  <?php



  }else{
    print $rendered;
  }

  ?>


</div>
  