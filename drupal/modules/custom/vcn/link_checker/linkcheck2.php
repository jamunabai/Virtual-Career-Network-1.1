<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
// time of execution up to 48hrs...
set_time_limit(172800);
//chdir('../drupal');
chdir('../../../../../..');
require_once('./includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$timestamp1=time();

if(!function_exists('connectIt'))
{
function connectIt()
  {
  //extracting database
  $dbpull .= hvcp_get_db_url();
  $tempArr1=explode("/",$dbpull);
  $tempArr2=explode(":",$tempArr1[2]);
  $dbuser=$tempArr2[0];
  $tempArr3=explode("@",$tempArr2[1]);
  $dbpass=$tempArr3[0];
  $dbserver=$tempArr3[1].":3306";
  unset($tempArr1,$tempArr2,$tempArr3);

  //For now, until we get the REST server set up, we'll just pull the data directly from the database
  $connection=mysql_connect($dbserver,$dbuser,$dbpass)
    or die("Error making database connection: ".mysql_error());
  $db=mysql_select_db('hvcp',$connection)
    or die("Error selecting database: ".mysql_error());
  return($connection);
  }
}

function urlStatus($url)
  {
  $file_headers = @get_headers($url);
  if($file_headers=="")
    {
    if(@file_get_contents($url,0,NULL,0,1))
      $message="Content Exists";
    else
      $message="Content Doesn't Exist";
    }
  else
    $message=$file_headers[0];
  return($message);
  }

function checkURL($url,$table,$column,$dateStamp,&$count,$uniqueId,$uniqueIdValue,$uniqueId2="",$uniqueIdValue2="")
  {
  $status=urlStatus($url);
  if($status!="Content Exists" && strpos($status,"200")===false)
    {
    if($status=="Content Doesn't Exist")
      {
      $errno=600;
      $errstr="Server Not Found";
      }
    else
      {
      $statusArray=explode(" ",$status);
      array_shift($statusArray);
      $errno=$statusArray[0];
      array_shift($statusArray);
      $errstr=implode(" ",$statusArray);
      }
    // Output Error Message
    $fp=fopen($dateStamp,'a');
    fwrite($fp,"\"$count\",\"$table\",\"$uniqueId\",\"$uniqueIdValue\",\"$uniqueId2\",\"$uniqueIdValue2\",\"$column\",\"$url\",\"$errno\",\"$errstr\"");
    if($errno==301)
      {
      $redirect=get_final_url($url);
      fwrite($fp,",\"$redirect\"\r\n");
      }
    else
      {
      fwrite($fp,"\r\n");
      }
    fclose($fp);
    $count++;
    }
  }// end function checkURL()

/**
 * get_redirect_url()
 * Gets the address that the provided URL redirects to,
 * or FALSE if there's no redirect.
 *
 * @param string $url
 * @return string
 */
function get_redirect_url($url)
  {
  $redirect_url = null;
  $url_parts = @parse_url($url);
  if(!$url_parts)
    return false;
  if(!isset($url_parts['host']))
    return false;

  //can't process relative URLs
  if(!isset($url_parts['path'])) $url_parts['path'] = '/';

  $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
  if(!$sock)
    return false;
  $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n";
  $request .= 'Host: ' . $url_parts['host'] . "\r\n";
  $request .= "Connection: Close\r\n\r\n";
  fwrite($sock, $request);     $response = '';
  while(!feof($sock))
    $response .= fread($sock, 8192);
  fclose($sock);

  if(preg_match('/^Location: (.+?)$/m', $response, $matches))
    {
    if( substr($matches[1], 0, 1) == "/" )
      return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
    else
      return trim($matches[1]);
    } // end if(preg_match('/^Location: (.+?)$/m', $response, $matches))
  else
    {
    return false;
    }
  } // end function get_redirect_url($url)

/**
 * get_all_redirects()
 * Follows and collects all redirects, in order, for the given URL.
 *
 * @param string $url
 * @return array
 */
function get_all_redirects($url)
  {
  $redirects = array();
  while ($newurl = get_redirect_url($url))
    {
    if (in_array($newurl, $redirects))
      {
      break;
      }
    $redirects[] = $newurl;
    $url = $newurl;
    } // end while ($newurl = get_redirect_url($url))
  return $redirects;
  } // end function get_all_redirects($url)

/**
 * get_final_url()
 * Gets the address that the URL ultimately leads to.
 * Returns $url itself if it isn't a redirect.
 *
 * @param string $url
 * @return string
 */
function get_final_url($url)
  {
  $redirects = get_all_redirects($url);
  if (count($redirects)>0)
    {
    return array_pop($redirects);
    }
  else
    {
    return $url;
    }
  } // end function get_final_url($url)

/** end functions **/

//echo "Start Processing <br />";

// array of tables that have columns of urls.
$urlTableArray=array();

$urlTableArray[]="'vcn_provider','WEBADDR','UNITID'";
$urlTableArray[]="'vcn_provider','WEBADDR','UNITID'";
$urlTableArray[]="'vcn_provider','ADMINURL','UNITID'";
$urlTableArray[]="'vcn_provider','FAIDURL','UNITID'";
$urlTableArray[]="'vcn_provider','APPLURL','UNITID'";
$urlTableArray[]="'vcn_provider_detail','MISSION_STATEMENT_URL','UNITID'";
$urlTableArray[]="'vcn_occupation','DAY_IN_LIFE_URL','ONETCODE'";
$urlTableArray[]="'vcn_occupation','PHYSICAL_REQUIREMENT_URL','ONETCODE'";
$urlTableArray[]="'vcn_occupation','WORK_EXPERIENCE_REQUIREMENT_URL','ONETCODE'";
$urlTableArray[]="'vcn_occupation_financial_aid','FINANCIAL_AID_URL','FINANCIAL_AID_ID'";
$urlTableArray[]="'vcn_occupation_interview','INTERVIEW_URL','INTERVIEW_ID'";
$urlTableArray[]="'vcn_occupation_legal_requirement','ASSOCIATED_URL','ONETCODE&STATE'";
$urlTableArray[]="'vcn_occupation_resource','RESOURCE_LINK','RESOURCE_ID'";
$urlTableArray[]="'vcn_occupation_video','VIDEO_LINK','VIDEO_ID'";
$urlTableArray[]="'vcn_program','ADMISSION_URL','PROGRAM_ID'";
$urlTableArray[]="'vcn_program','PROGRAM_URL','PROGRAM_ID'";

//initialize the error report table
$dateStamp=date("m-d-y",time()).".csv";
//echo "Date stamp is $dateStamp <br />";
chdir('sites/all/modules/custom/vcn/link_checker');
if(file_exists($dateStamp)) unlink($dateStamp);
touch("$dateStamp");

$fp=fopen($dateStamp,'a');
fwrite($fp,"\"Counter\",\"Table Name\",\"Unique ID #1\",\"Unique ID #1 Value\",\"Unique ID #2\",\"Unique ID #2 Value\",\"Column Name\",\"URL\",\"Error #\",\"Error Text\",\"Final Redirect\"\r\n");
fclose($fp);

$linkcount=0;
$count=1;
foreach($urlTableArray as $table1)
  {
  if(isset($uid1)) unset($uid1);
  if(isset($uid2)) unset($uid2);
  $table_array=explode(",",$table1);
  $table=str_replace("'","",$table_array[0]);
  $column=str_replace("'","",$table_array[1]);
  $uniqueId=str_replace("'","",$table_array[2]);
  $uid_arr=explode("&",$uniqueId);
  if(count($uid_arr)==2)
    {
    $uid1=$uid_arr[0];
    $uid2=$uid_arr[1];
    }

  //echo "Processing $table table<br />";
  if(isset($uid2))
    $query="SELECT $column,$uid1,$uid2 FROM $table";
  else
    $query="SELECT $column,$uniqueId FROM $table";
  $connection=connectIt();
  $result=mysql_query($query);
  mysql_close($connection);
  while($row=mysql_fetch_assoc($result))
    {
    extract($row);
    $linkcount++;
    if($$column != "" && $$column != NULL && $$column !="NULL")
      {
      if(strpos($$column,"http")===false) $$column="http://".$$column;
      $$column=str_replace('"',"",$$column);
      if(isset($uid2))
        checkURL($$column,$table,$column,$dateStamp,$count,$uid1,$$uid1,$uid2,$$uid2);
      else
        checkURL($$column,$table,$column,$dateStamp,$count,$uniqueId,$$uniqueId);
      }
    }
 } // end foreach

$timestamp2=time();
$timediff=$timestamp2-$timestamp1;
$hours=floor($timediff/3600);
$minutes=floor(($timediff-($hours*3600))/60);
$seconds=$timediff-(($hours*3600)+($minutes*60));

$fp=fopen($dateStamp,'a');
fwrite($fp,"$linkcount records processed. Execution time: $hours hours, $minutes minutes and $seconds seconds\r\n");
fclose($fp);
?>
