<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script>
      $(document).ready(function() {
        $("#tr10").delay(800).fadeIn("slow");
		 $("#tr9").delay(1600).fadeIn("slow");
		  $("#tr8").delay(2400).fadeIn("slow");
		   $("#tr7").delay(3200).fadeIn("slow");
		    $("#tr6").delay(4000).fadeIn("slow");		   
		     $("#tr5").delay(4800).fadeIn("slow");			
		      $("#tr4").delay(5600).fadeIn("slow");			 
		       $("#tr3").delay(6400).fadeIn("slow");			 
		        $("#tr2").delay(7200).fadeIn("slow");			   
		          $("#tr1").delay(8000).fadeIn("slow");				
      });
    </script>
	
	<?php
    $topup_js = drupal_get_path('module','occupations_detail') . "/javascripts/top_up-min.js";
    drupal_add_js($topup_js);
//    $topup_js = "<script type='text/javascript' src='http://gettopup.com/releases/latest/top_up-min.js'></script>";
//    drupal_set_html_head($topup_js);
?>

<script type="text/javascript">
  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";
  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";
</script>

<?php

  $cp = dirname(dirname(drupal_get_path('module','occupations_similar')));

  require_once($cp . '/vcn.rest.inc');

  $rest = new vcnRest;

  $rest->setSecret('');
  $rest->setBaseurl(getBase());
  $rest->setService('occupationsvc');
  $rest->setModule('occupation');
  $rest->setAction('list');

  // standard filters
  $rest->setRequestKey('apikey','apikey');
  $rest->setRequestKey('format','xml');
  $rest->setRequestKey('order','pchg');
  $rest->setRequestKey('direction','desc');
  $rest->setRequestKey('limit','10');

  $rest->setMethod('post');

	$use_appcache = true;
	$cid = 'top-10-growth-number';
	$cached_content = null;

	//print "OCCUPATIONS LIST: before call to rest data " . udate("H:i:s:u") . "<br />";
	if ($use_appcache) {
	 $cached = cache_get($cid,'cache_content');
	 $ser_content = $cached->data;
	 if (!empty($ser_content)) {
		$cached_content = unserialize($ser_content);
		//print "using cached data for " . $cid . "<br />";
	 }
	}

	if (empty($cached_content)) {
	 $content = $rest->call();
	 if ($use_appcache) {
	   // save data to cache
	   $ser_content = serialize($content);
	   cache_set($cid, $ser_content, 'cache_content', $CACHE_PERMANENT);
	   //print "setting cache for " . $cid . "<br />";
	}
	} else {
	 $content = $cached_content; 
	}


  if (isset($content['NODATA'])) {
    $content = new SimpleXMLElement($content);
//    $content = json_decode($content);


if ($content->status->code=="fail")
	$doesitwork="No data found";
else
	$doesitwork="";

    $content = $content->data;

	//print_r($content->relatedoccupation[0]->occupation); exit;

  if (isset($_GET['debug'])) {
    echo "<div style='border: 1px black solid;'><p><pre>";
    print_r($content);
    echo "</pre></p></div>";
  }

    //$videoImage = getVideoImage($onetcode);
    //$annualSalary = getAnnualSalary($content->VCN_WageOcc);
    //$hourlyWage = getHourlyWage($content->VCN_WageOcc);

  }


//print_r($content->occupation[1]); exit;
//print($content->occupation[0]->wageocc->item[0]->median); exit;
?>
<!-- THIS IS THE "BY GROWTH NUMBER" MODULE. --->

<h2>Top 10 Fastest Growing Healthcare Careers</h2>
<p>As the population ages, there will be an increasing demand for healthcare positions. The following healthcare jobs are among the fastest growing occupations in the nation as shown by their growth rates.</p>
<!--<p>People are different. For some, having job security is key. For others, it's pay. This page shows the <b>fastest growing</b> VCN occupations. </p>

<p><strong>Note:</strong> Openings are for the period 2010-2020.</p> -->
<ol>
	
	  <style type="text/css">
	  
		table.data
		  {
		  width: 450px;
		  border-width: 1px;
		  border-spacing: 0px;
		  border-style: solid;
		  border-color: gray;
		  /*border-collapse: separate;*/
		  background-color: white;
		  margin-left:-40px;
		  }
		table.data th
		  {
		  border-width: 1px;
		  padding: 10px;
		  border-style: solid;
		  border-color: white;
		  background-color: #189AB0;
		  color: white;
		  -moz-border-radius: ;
		  }
		table.data td
		  {
		  border-width: 1px;
		  padding: 5px;
		  border-style: solid;
		  border-color: white;
	/* background-color: white; */
		  -moz-border-radius: ;
		  }
		</style>

<?php
	  echo "<table class=\"data\">";
	  echo "<tr><th>Ranking</th><th><center>Careers</center></th><th>Growth Rate</th></tr>";
	  $count=0;
	  foreach ($content->occupation as $occupation)
	    {
	    $count++;
		
		$percent = intval($occupation->jobgrowth->percent); 
		
		$percent = round($percent,2,PHP_ROUND_HALF_UP);
	    if ($count%2)
			echo "<tr id='tr".$count."' style='display:none;'>";
		else
			echo "<tr id='tr".$count."' style='background: #d6d6d6;display:none;'>";
	    echo "<td align=\"center\" width=\"80\">".$count."</td>";
	    echo "<td><a toptions='type = iframe, width = 720, height = 600, resizable = 1, layout=flatlook, title=Career Details, scrolling=yes, shaded=1' href=" . base_path() . "careerdetails?onetcode=". $occupation->onetcode .">". $occupation->title."</a></td>";
	    echo "<td align=\"center\" width=\"95\">".$percent."%</td>";
	    echo "</tr>";
	    }
	  echo "</table>";
	?>

</ol>

<p class="small">(Growth Rates Source: Bureau of Labor Statistics, Office of Occupational Statistics and Employment Projections, 2008-2018 BLS Projections)</p>




<script type="text/javascript">

$('#content').css("width","450px");


$(document).ready(function() {

                                var r = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
                                
                                if (r.indexOf("getting-started")>0 || r.indexOf("explorecareers")>0) {
                                                document.getElementById('vcn-header').style.display = 'none';
                                                document.getElementById('vcn-footer').style.display = 'none';
                                                document.getElementById('copyright').style.display = 'none';
                                                
                                               // document.getElementById('dronoff').innerHTML = document.getElementById('video-link').innerHTML;
                                                
                                                //document.getElementById('dronoff').style.display = 'none';
                                                
                                                //document.getElementById('video-link').style.display = 'block';
                                                
                                                $('#page').css("margin-left","20px");
                                                
                                                $('.breadcrumb').css("display","none");

                                                
                                                
                                }
                                                
                
                });


</script>