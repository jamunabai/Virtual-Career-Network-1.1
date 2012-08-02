<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">

var myoccs = ['15-1121-01','15-2041-01','19-2041-00','19-4011-02','19-4092-00','21-1015-00','21-1022-00','29-1031-00','29-1071-00','29-1071-01','29-1122-00','29-1122-01','29-1123-00','29-1124-00','29-1125-01','29-1126-00','29-1141-00','29-1141-01','29-1141-03','29-1141-04','29-1151-00','29-1171-00','29-1181-00','29-2011-00','29-2011-02','29-2011-03','29-2012-00','29-2021-00','29-2031-00','29-2032-00','29-2033-00','29-2034-00','29-2041-00','29-2051-00','29-2052-00','29-2053-00','29-2054-00','29-2055-00','29-2057-00','29-2061-00','29-2071-00','29-2081-00','29-2091-00','29-2092-00','29-2099-01','29-2099-05','29-2099-06','29-9011-00','29-9012-00','29-9092-00','29-9099-01','31-1011-00','31-1013-00','31-1014-00','31-1015-00','31-2011-00','31-2012-00','31-2021-00','31-2022-00','31-9011-00','31-9091-00','31-9092-00','31-9093-00','31-9094-00','31-9095-00','31-9099-01','31-9099-02','39-9021-00','39-9031-00','43-4051-03','43-6013-00','49-9062-00','51-9081-00','51-9082-00','51-9083-00','53-3011-00','21-1094-00','21-1091-00','11-9111-00'];

function deleteit(url,cmaCareerId) {
	//loadhere.location.href = url;
	 
	
	var count=0;
	var star = '';
	var seconddiv ='';

	for (var i in myoccs) {
		if (document.getElementById('onet-'+myoccs[i])) {
			count++;			
				
			if (document.getElementById('onet-'+myoccs[i]).innerHTML.indexOf("*")>0)
				star = 'onet-'+myoccs[i];
			else			
				seconddiv=myoccs[i];
				
		}
	}
	
		var newtarget = seconddiv.split("-");
		var temptarget = newtarget;
		
		newtarget = newtarget[0]+'-'+newtarget[1]+'.'+newtarget[2];
		
		var temptargetstar = star.split("-");
		
		temptargetstar = temptargetstar[1]+'-'+temptargetstar[2]+'.'+temptargetstar[3];
		
		
		
		var sentonet = cmaCareerId.split("-");
		sentonet = sentonet[1]+'-'+sentonet[2]+'.'+sentonet[3];
		
		var twotoone = 0;
		
	if (count==2) {		
		
		if (sentonet==temptargetstar)
			twotoone = 1;
			
		var targetthis = '#onet-'+myoccs[2];
	}

	if (count>2 && sentonet==temptargetstar && star) {
		red_error_box("delete");
		return;
	}
	
	
	$.ajax({
		   type: "POST",
		   url: url,
		   cache: false,
		   dataType: "html",
		   success: function (html) {
			//alert(html);
		   },
		   error: function (xmlhttp) {
		    // alert('An error occured: ' + xmlhttp.status);
		   }
	});
//	myRef = window.open(url,'loadhere');
	//alert ('Career Deleted from Notebook');
	
	
	$(cmaCareerId).empty().remove();	
	
	
	if (twotoone) {
		var targeturl = '<?php echo base_path(); ?>cma/notebook/target/career/'+newtarget;
		//w = window.open(targeturl,'loadhere');
		$.ajax({
			   type: "POST",
			   url: targeturl,
			   cache: false,
			   dataType: "html",
			   success: function (html) {
				//alert(html);
			   },
			   error: function (xmlhttp) {
				// alert('An error occured: ' + xmlhttp.status);
			   }
		});		

		$(document).ready(function() {
			$('#onet-'+seconddiv).children(":first").append('*');
		});
		
	
	}
	
}

function countit() {

	var count=0;
	for (var i in myoccs) {
		if (document.getElementById('onet-'+myoccs[i]))
			count++;
	}

	if ($('#current_activity').val()==1 && count>0)
		$('#snapshot').append('We noticed that there are already a few items in your Wish List. You may choose to keep them or remove them by clicking on the remove link next to each item.');

}
</script>
 
<div id="sidebar-height-container" style="width:90%; padding-left:11px; height:125px;">
<span class="vcn-gs-heading-black">My Career Wish List</span>
<br/><br/>
<?php

  $cp = dirname(dirname(drupal_get_path('module','occupations_detail')));

  require_once($cp . '/vcn.rest.inc');

  $rest = new vcnRest;

  $rest->setSecret('');
  $rest->setBaseurl(getBase());
  $rest->setService('cmasvc');
  $rest->setModule('notebook');
  
  $cma = vcnCma::getInstance();
     
  $rest->setAction('get-notebook-items?user_id='.$cma->userid);

  // standard filters
  $rest->setRequestKey('apikey','apikey');
  $rest->setRequestKey('format','xml');


  //$cma = vcnCma::getInstance();
  

  $rest->setMethod('post');

  $content = $rest->call();

  $content = new SimpleXMLElement($content);

$rowcount = $content->status->rowcount;

  if ($content->data->notebookresults->item[0]->itemid != $content->data->contentresults->item[0]->onetcode) {
  
	//$content2->data->contentresults->item[0]=$content->data->contentresults->item[$rowcount-1];
	for ($i=0; $i<$rowcount; $i++) {
		$ionet = md5($content->data->notebookresults->item[$i]->itemid);

		for ($j=0; $j<$rowcount; $j++) {
		
				$jonet = md5($content->data->contentresults->item[$j]->onetcode);
				
				if ($jonet == $ionet) {
					$content2->data->contentresults->item[$i] = $content->data->contentresults->item[$j];
					$content2->data->contentresults->item[$i]->itemrank = $content->data->notebookresults->item[$i]->itemrank;
				}
		
		}
		
		//$content2->data->contentresults->item[$i] = $content->data->contentresults->item[$i];
		
	}
  
  }
	

   $content = $content2->data->contentresults;

echo '<div class="cmacontainer" id="ey">';

for ($count=0; $count<$rowcount; $count++):

$onetcode =  $content->item[$count]->onetcode;
$pieces = explode ('.',$onetcode);
$onetcode = $pieces[0].'-'.$pieces[1];

if ($content->item[$count]->onetcode && $count<4) {
?>
<div id="onet-<?php echo $onetcode; ?>">
<div style="float:left; width:153px; padding-bottom:15px;">
<?php 
echo $content->item[$count]->displaytitle; if ($content->item[$count]->itemrank==1) echo "*";   ?>
</div>
<div style="float:right;">
<a href="javascript:void(0);" onclick="deleteit('<?php echo base_path(); ?>cma/notebook/remove/career/<?php echo $content->item[$count]->onetcode; ?>','#onet-<?php echo $onetcode; ?>');">Remove</a>
</div>
<br/>
</div>


<?php } else {  //echo "<script>deleteit('".base_path()."cma/notebook/remove/career/".$content->item[$count]->onetcode."','#onet-".$onetcode."');</script>"; 
} 
	endfor; ?>
</div></div>
<script>countit();</script>