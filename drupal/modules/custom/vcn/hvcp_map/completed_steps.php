<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
echo "You have completed the following steps: <br /><br />";

$steps=array(
            "LOGIN"=>"You have created a user account and/or logged in.",
            "OCCUPATION"=>"You have saved an career in your Career Management Account",
            "INTERESTS"=>"You have matched your interests against some careers",
            "TARGET"=>"You have targeted a career in your Career Management Account to focus on",
            "PROGRAM"=>"You have added an education program to your Career Management Account",
            "CERTIFICATE"=>"You have added a certificate you are interested in to your Career Management Account",
            "LICENSE"=>"You have added a license you are interested in to your Career Management Account"
            );

$keys=array_keys($steps);

$doneList="";
$todoList="";

foreach($keys as $key)
  {
  $done=0;
  foreach($_GET as $getItem=>$getValue)
    {
    if($getItem==$key)$done=1;
    }
  if($done==1) $doneList .= "<li>".$steps[$key]."</li>";
  else $todoList .= "<li>".$steps[$key]."</li>";
  }

echo "<ul>$doneList</ul>";
echo "You have yet to do the following:<br /><br />";
echo "<ul> $todoList </ul>";


?>