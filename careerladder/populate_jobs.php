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

 function joblistings($jlarray) {
      $onetcodes=""; 
	  
			$count=0;
			/*
            foreach ($jlarray as $value) {
					$count++;
                  $onetcodes .= $value.",";
				 if ($count>40)
					break;
			}
            
            $onetcodes = substr($onetcodes, 0, -1);
          //  echo $onetcodes; exit;
		  
		  */
		  
		  $onetcodes = $jlarray;
		  $zipcode='';
		  $jlarray = array();
		  $jlarray[0] = $onetcodes;
            
        $objDOM = new DOMDocument();
        ini_set('display_errors', 'Off');
        for ($j = 1; $j <= 7; $j++) {
            if ($objDOM->load($GLOBALS['hvcp_config_dea_web_service_url'] . "?key=&onets=$onetcodes&zc1=$zipcode&rd1=50&tm=100&rc=1"))
                break;
            else
                sleep(1);
        }
		

            $title="";
        $jobnos = $objDOM->getElementsByTagName("item");
        $count=-1; 
        foreach ($jobnos as $value) {
            $count++;
            $titles = $value->getElementsByTagName("recordcount");
                  $title  = $titles->item(0)->nodeValue;
                  $jlarray[$count] = $title;
            
        }

        ini_set('display_errors', 'On');
            
        if ($j>7)
            $jlarray=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ');
            
        return $jlarray;

}
	
$dbserver = $GLOBALS['hvcp_config_db_server_name'];
$dbuser = $GLOBALS['hvcp_config_db_username'];
$dbpass = $GLOBALS['hvcp_config_db_password'];
$dbname = $GLOBALS['hvcp_config_db_name'];

$link = mysql_connect($dbserver, $dbuser, $dbpass);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$result = mysql_query("SELECT * from hvcp.vcn_occupation_job_count where ONETCODE_OLD!=0");

$jar=array();
while ($row = mysql_fetch_assoc($result)) {
	$new = $row['ONETCODE_OLD'];
	$jar[]=$new;


}



$k=-1;

//print_r($jar);

echo '<br/><br/>';

$jarl = array();


foreach ($jar as $v) {
	$k++;
	
	$temp = joblistings($jar[$k]);
	
	$jarl[$k] = $temp[0];
	
	//if ($k>3)
		//break;
}


//print_r($jarl);	


$count=-1;
foreach ($jarl as $v) {

	$count++;
	
	//if ($count == 1) {
		// BE CAREFUL HERE
	
		$update = "UPDATE hvcp.vcn_occupation_job_count SET job_count='".$jarl[$count]."' WHERE onetcode_old='".$jar[$count]."'";
		mysql_query($update) or die(mysql_error());  
		
		
	//}

}
echo "Done with everything";
	mysql_close($link);
?>
