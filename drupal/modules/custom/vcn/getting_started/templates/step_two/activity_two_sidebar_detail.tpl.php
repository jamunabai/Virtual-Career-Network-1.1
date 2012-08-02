<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php $cma = vcnCma::getInstance(); ?>


<script type="text/javascript">

	var myoccs = ['15-1121-01','15-2041-01','19-2041-00','19-4011-02','19-4092-00','21-1015-00','21-1022-00','29-1031-00','29-1071-00','29-1071-01','29-1122-00','29-1122-01','29-1123-00','29-1124-00','29-1125-01','29-1126-00','29-1141-00','29-1141-01','29-1141-03','29-1141-04','29-1151-00','29-1171-00','29-1181-00','29-2011-00','29-2011-02','29-2011-03','29-2012-00','29-2021-00','29-2031-00','29-2032-00','29-2033-00','29-2034-00','29-2041-00','29-2051-00','29-2052-00','29-2053-00','29-2054-00','29-2055-00','29-2057-00','29-2061-00','29-2071-00','29-2081-00','29-2091-00','29-2092-00','29-2099-01','29-2099-05','29-2099-06','29-9011-00','29-9012-00','29-9092-00','29-9099-01','31-1011-00','31-1013-00','31-1014-00','31-1015-00','31-2011-00','31-2012-00','31-2021-00','31-2022-00','31-9011-00','31-9091-00','31-9092-00','31-9093-00','31-9094-00','31-9095-00','31-9099-01','31-9099-02','39-9021-00','39-9031-00','43-4051-03','43-6013-00','49-9062-00','51-9081-00','51-9082-00','51-9083-00','53-3011-00','21-1094-00','21-1091-00','11-9111-00'];
	
function saveit(url,thisv,onet,onetdash) { 
	//loadhere.location.href = url;
	<?php /* not_logged_in('<?php global $user; $logged_in = $user->uid; if ($logged_in) echo "U"; else echo "S"; ?>','Career saved.'); */?> 
	//thisv = thisv.substr(0,21);

	var count=0;
	var star = '';

	for (var i in myoccs) {
		if (document.getElementById('onet-'+myoccs[i])) {
			count++;
			if (document.getElementById('onet-'+myoccs[i]).innerHTML.indexOf("*")>0)
				star = 'onet-'+myoccs[i];
				
		}
	}


	

	if (count>3) {
		red_error_box('4'); 
		return;
		
		var last = $('.cmacontainer div:last-child').attr('id');
		if (!document.getElementById('onet-'+onetdash))
			$('#'+last).remove();



	}
		w = window.open(url,'loadhere');
		if (!document.getElementById('onet-'+onetdash)) { 
			if (!count)
				thisv = thisv+'*';
				
			if (star) {
				$('.cmacontainer').append('<div id="onet-'+onetdash+'"><div style="float:left; width:150px; padding-bottom:15px;">'+thisv+'</div><div style="float:right;"><a href="javascript:void(0);" onclick="deleteit(\'<?php echo base_path(); ?>cma/notebook/remove/career/'+onet+'\',\'#onet-'+onetdash+'\');">Remove</a></div><br/></div>');
			}
			else {
				$('.cmacontainer').append('<div id="onet-'+onetdash+'"><div style="float:left; width:150px; padding-bottom:15px;">'+thisv+'</div><div style="float:right;"><a href="javascript:void(0);" onclick="deleteit(\'<?php echo base_path(); ?>cma/notebook/remove/career/'+onet+'\',\'#onet-'+onetdash+'\');">Remove</a></div><br/></div>');
			}
			
		}
			
		//var logged_in = '<?php echo $logged_in;  ?>';
	  //if (logged_in==1)
	//	alert('Career saved.');		

	var height = $('#vcn-gs-sidebar-status').height();
	$('#sidebar-height-container').height() = height;

	//alert(height);		

	
	
}



</script>

<div id="snapshot" style="width:92%; height:620px; margin-left:15px;">
<span class="vcn-gs-heading-black" style="margin-left:-5px">Career Snapshot</span>

</div>