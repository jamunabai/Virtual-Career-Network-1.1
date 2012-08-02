<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

$tabsArray=array();

$tabsArray['pla']=array();
$tabsArray['college']=array();
$tabsArray['military']=array();
$tabsArray['business']=array();
$tabsArray['exam']=array();
$tabsArray['transcript']=array();

$tabsArray['pla']['active']=drupal_get_path('module','pla_main')."/images/03_blue.png";
$tabsArray['pla']['inactive']=drupal_get_path('module','pla_main')."/images/03_grey.png";

$tabsArray['college']['active']=drupal_get_path('module','pla_main')."/images/tab_cc_on.png";
$tabsArray['college']['inactive']=drupal_get_path('module','pla_main')."/images/tab_cc_off.png";

$tabsArray['military']['active']=drupal_get_path('module','pla_main')."/images/tab_mt_on.png";
$tabsArray['military']['inactive']=drupal_get_path('module','pla_main')."/images/tab_mt_off.png";

$tabsArray['business']['active']=drupal_get_path('module','pla_main')."/images/tab_pt_on.png";
$tabsArray['business']['inactive']=drupal_get_path('module','pla_main')."/images/tab_pt_off.png";

$tabsArray['exam']['active']=drupal_get_path('module','pla_main')."/images/tab_ne_on.png";
$tabsArray['exam']['inactive']=drupal_get_path('module','pla_main')."/images/tab_ne_off.png";

$tabsArray['transcript']['active']=drupal_get_path('module','pla_main')."/images/tab_mli_on.png";
$tabsArray['transcript']['inactive']=drupal_get_path('module','pla_main')."/images/tab_mli_off.png";

$content .= "<style>
div.tab0
  {
  float:left;
  width: 131px;
  height: 65px;
  background-image:url('".$tabsArray['pla']['inactive']."');
  }
div.tab0:hover
  {
  background-image:url('".$tabsArray['pla']['active']."');
  width: 131px;
  height: 65px;
  }
  
div.tab1
  {
  width: 131px;
  height: 65px;
  float:left;
  background-image:url('".$tabsArray['college']['inactive']."');
  }
div.tab1:hover
  {
  float: left;
  background-image:url('".$tabsArray['college']['active']."');
  width: 131px;
  height: 65px;
  }
  
div.tab2
  {
  float:left;
  width: 131px;
  height: 65px;
  background-image:url('".$tabsArray['military']['inactive']."');
  }
div.tab2:hover
  {
  background-image:url('".$tabsArray['military']['active']."');
  width: 131px;
  height: 65px;
  }

div.tab3
  {
  float:left;
  width: 131px;
  height: 65px;
  background-image:url('".$tabsArray['business']['inactive']."');
  }
div.tab3:hover
  {
  float:left;
  background-image:url('".$tabsArray['business']['active']."');
  width: 131px;
  height: 65px;
  }
  
div.tab4
  {
  float:left;
  width: 131px;
  height: 65px;
  background-image:url('".$tabsArray['exam']['inactive']."');
  }
div.tab4:hover
  {
  float: left;
  background-image:url('".$tabsArray['exam']['active']."');
  width: 131px;
  height: 65px;
  }


div.tab5
  {
  float:left;
  width: 131px;
  height: 65px;
  background-image:url('".$tabsArray['transcript']['inactive']."');
  }
div.tab5:hover
  {
  float: left;
  background-image:url('".$tabsArray['transcript']['active']."');
  width: 131px;
  height: 65px;
  }

.tabnav
  {
  margin-bottom: -2px;
  height: 65px;
  }
</style>";




if(strpos($_SERVER['REQUEST_URI'],"e-transcript")!==false)
  $content .= "<div class=\"tabnav\" style=\"height:67px;\">";
else
  $content .= "<div class=\"tabnav\">";
  

if(strpos($_SERVER['REQUEST_URI'],"pla")!==false && !stristr($_SERVER['REQUEST_URI'],"placement"))
  $content .= "<div class=\"tab0\"><a href=\"pla\"><img alt=\"military\" src=\"".$tabsArray['pla']['active']."\" /></a></div>";
else
  $content .= "<div class=\"tab0\"><a href=\"pla\"><img alt=\"military\" width=\"131px\" height=\"65px\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></a></div>";
$content .= "<div style=\"float:left;\"><img width=\"4px\" alt=\"spacer image\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></div>";

if(strpos($_SERVER['REQUEST_URI'],"college-courses")!==false)
  $content .= "<div class=\"tab1\"><a href=\"college-courses\"><img alt=\"college courses\" src=\"".$tabsArray['college']['active']."\" /></a></div>";
else
  $content .= "<div class=\"tab1\"><a href=\"college-courses\"><img alt=\"college courses\" width=\"131px\" height=\"65px\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></a></div>";
$content .= "<div style=\"float:left;\"><img width=\"4px\" alt=\"spacer image\" height=\"65px\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></div>";

if(strpos($_SERVER['REQUEST_URI'],"military-credit")!==false)
  $content .= "<div class=\"tab2\"><a href=\"military-credit\"><img alt=\"military\" src=\"".$tabsArray['military']['active']."\" /></a></div>";
else
  $content .= "<div class=\"tab2\"><a href=\"military-credit\"><img alt=\"military\" width=\"131px\" height=\"65px\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></a></div>";
$content .= "<div style=\"float:left;\"><img width=\"4px\" alt=\"spacer image\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></div>";

if(strpos($_SERVER['REQUEST_URI'],"employer-training")!==false)
  $content .= "<div class=\"tab3\"><a href=\"employer-training\"><img alt=\"employer training\" src=\"".$tabsArray['business']['active']."\" /></a></div>";
else
  $content .= "<div class=\"tab3\"><a href=\"employer-training\"><img alt=\"employer training\" width=\"131px\" height=\"65px\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></a></div>";
$content .= "<div style=\"float:left;\"><img width=\"4px\" alt=\"spacer image\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></div>";

if(strpos($_SERVER['REQUEST_URI'],"placement-exams")!==false )
  $content .= "<div class=\"tab4\"><a href=\"placement-exams\"><img alt=\"placement exams\" src=\"".$tabsArray['exam']['active']."\" /></a></div>";
else
  $content .= "<div class=\"tab4\"><a href=\"placement-exams\"><img alt=\"placement exams\" width=\"131px\" height=\"65px\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></a></div>";
$content .= "<div style=\"float:left;\"><img width=\"4px\" alt=\"spacer image\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></div>";

if(strpos($_SERVER['REQUEST_URI'],"e-transcript")!==false)
  $content .= "<div class=\"tab5\"><a href=\"e-transcript\"><img alt=\"e-transcript\" src=\"".$tabsArray['transcript']['active']."\" /></a></div>";
else
  $content .= "<div class=\"tab5\"><a href=\"e-transcript\"><img alt=\"e-transcript\" width=\"131px\" height=\"65px\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></a></div>";
if(strpos($_SERVER['REQUEST_URI'],"e-transcript")===false)
$content .= "<div><img width=\"4px\" height=\"65px\" alt=\"spacer image\" src=\"".drupal_get_path('module','pla_main')."/images/transparent_pixel.gif\" /></div>";
$content .="</div><!-- end div tabnav -->";

//$content .= "<div style=\"clear:both;\"></div>";

if(strpos($_SERVER['REQUEST_URI'],"e-transcript")===false)
  $content .= "<br />";



?>