<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-two');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','4');
</script>
<?php //echo"G got it <br />";
$cma = vcnCma::getInstance();
function webserviceforcmaga($userid, $item_type='OCCUPATION'){
	    $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('notebook');
        $rest->setAction('get-notebook-items');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $userid);
         $rest->setRequestKey('item_type', $item_type);
       // $rest->setRequestKey('session_id', $this->sessionId);

        $rest->setMethod('post');


        $content = $rest->call();

        $content = new SimpleXMLElement($content);

        return $content;
}
	$careerfound = webserviceforcmaga($cma->userid,'career');

	$careerrank = $careerfound->data->notebookresults->item->itemrank;

	$careertargeted = $careerfound->data->notebookresults->item->itemid; // this is the targeted career's id

	$careercontent = $careerfound->data->contentresults->item;

	
	$carrr = $careerfound->data->contentresults;
	
	$count=-1;
	foreach($careercontent as $temp){
		$count++;
		$onetcode = $careerfound->data->contentresults->item[$count]->onetcode;
		//echo $onetcode.'<br>';
		//echo $careertargeted.'targetcareer'.'<br>';
		if((string)$careertargeted == (string)$onetcode){
			$finaltarget = $onetcode;
			$finalcount = $count;
			//echo 'careertargeted'.$finaltarget.'<br>';
			//echo 'onetcode'.$onetcode.'<br>';
		}
		//echo $careerfound->data->contentresults->item[$finalcount]->$finaltarget;
		//echo $finaltarget.'<br>';
	}
	//echo $careerfound->data->contentresults->item[$finalcount]->displaytitle;
	//echo 'rank'; print_r((string)$careerrank);

?>

<table border="0">
<tr>
  	<td>*Target Career : </td>
  	<td>
  	<?php
	if((string)($careerrank)==1) //if condition for the target is selected or not 
	{
		echo $careerfound->data->contentresults->item[$finalcount]->displaytitle;
	}
	else 
	{
	echo "No Career Targeted";
	?>
	<script type="text/javascript">
	//this is to disable the next buttons if no career is targeted 
	$(document).ready(function() {
		$('#vcn-gs-btn-next').addClass('off');
		$("#vcn-gs-btn-next").attr('disabled',true);
		$('#vcn-gs-btn-ano-next').addClass('off');
		$("#vcn-gs-btn-ano-next").attr('disabled',true);
	});
	</script>
	<?php 		
	}	//end of if condition for the target is selected or not
	?>
	</td>
  	<td>
		<?php $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
		$base_path = base_path(); ?>
		<a href="<?php echo $base_path.'getting-started/step-two/3';?>" style="color:#A71E28;" id="various1">Edit</a>  	
	</td>
</tr>   



</table>

<p>
<b>* Required Field :</b> Without required information you will not be able to go to the next step. 
</p>


<script type="text/javascript">
//To disable the activities in the step
$(document).ready(function(){	
$('#vcn-gs-sidebar-detail').hide().prev().hide().next().next().hide();
//$('#vcn-gs-sidebar-status').hide().prev().hide().next().next().hide();
});
</script>