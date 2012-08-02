<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>

<script>
function numericonly(evt) {

	var key = (evt.which) ? evt.which : event.keyCode;
	
	if (key==13) {
		if ( !$.browser.msie )
			zipvalidation();
		
		return true;
	}
	
	if (key!=45 && key > 31 && (key < 48 || key > 57))
		return false;

	return true;

	//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
}

function removetest(tsi,tti) {

	var answer = confirm("Are you sure you want to remove this test session?")
	if (answer){
		$.ajax({
			type: "POST",
			url: '/careerladder/removetest.php?tsi='+tsi+'&tti='+tti,
			cache: false,
			dataType: "html",
			success: function (html) {
				window.location.reload();
			},
			error: function (xmlhttp) {
			  alert('An error occured: ' + xmlhttp.status);
			}

				  
		});
	}
	else{
		return;
	}

}

function zipvalidation() {

	  $.ajax({
		type: "POST",
		url: '/careerladder/zipvalidation.php?zipcode='+$('#testzipcode').val(),
		dataType: "html",
		success: function (html) {
			if (html=='true') {
				var iftest='';
				
				if ($('#alltests').val()>0)
					iftest='&test='+$('#alltests').val();
					
				window.open('<?php echo base_path(); ?>tests/testtaker?zipcode='+$('#testzipcode').val()+iftest,'_self');
			}
			else {
				alert('Please enter a valid US ZIP Code'); 
				$("#testzipcode").addClass("redborder"); 
				$('#testzipcode').focus();
			}
		},
		error: function (xmlhttp) {
		  alert('An error occured: ' + xmlhttp.status);
		}

			  
	});

}

function reserve(qsi,tti,pi,oi,tsi,officename,date,time,endtime,proctorname,officelocation,email,testname) {
	qsi = $('#alltests').val();

	  $.ajax({
		type: "POST",
		url: '/careerladder/reservetest.php?qsi='+qsi+'&tti='+tti+'&pi='+pi+'&oi='+oi+'&tsi='+tsi,
		cache: false,
		dataType: "html",
		success: function (html) {
			if (html=='toomany') {
				alert('Sorry, the time slot is no longer available, please choose another time slot.');
					$('#reserve'+tsi+'on').hide();
					$('#reserve'+tsi+'off').show();	
			} else {			

				
				qsi=$('#alltests').val();
				testname=$("#alltests option:selected").text();

				var theurl = '/careerladder/takentest.php?uid='+tti+'&nid='+qsi;
				
				$.ajax({
					url: theurl,
					cache: false,
					dataType: "html",
					success: function(data) { 
						$('#testtakennum').text(data);
				
					//alert(theurl+ ' - ' + $('#testtakennum').text()); return;
					var answer='';
				
					if ($('#testtakennum').text()>0) {
					
						var answer = confirm("You have already passed the test for the course. Would you like to take the test again? Please Click OK to confirm, otherwise click Cancel.");
						if (answer){
							$('#testtakennum').text("0");
						}
						else{
							return;
						}	
					}
					
					if ($('#testtakennum').text()<=0) {
			
						
						if (answer) {
							$('#reserve'+tsi+'on').hide();
							$('#reserve'+tsi+'off').show();								
							window.open('<?php echo base_path(); ?>tests/schedule-confirmation?qsi='+qsi+'&tti='+tti+'&pi='+pi+'&oi='+oi+'&tsi='+tsi+'&officename='+officename+'&date='+date+'&time='+time+'&endtime='+endtime+'&proctorname='+proctorname+'&officelocation='+officelocation+'&email='+email+'&testname='+testname,'_self');
						} else {
						
							var answer2 = confirm("You are about to reserve a time slot for the test. Please click OK to confirm that you will be able to appear for the test on the scheduled time. If you do not wish to reserve the time at this time, please click Cancel.");
							if (answer2) {
								$('#reserve'+tsi+'on').hide();
								$('#reserve'+tsi+'off').show();										
								window.open('<?php echo base_path(); ?>tests/schedule-confirmation?qsi='+qsi+'&tti='+tti+'&pi='+pi+'&oi='+oi+'&tsi='+tsi+'&officename='+officename+'&date='+date+'&time='+time+'&endtime='+endtime+'&proctorname='+proctorname+'&officelocation='+officelocation+'&email='+email+'&testname='+testname,'_self');
							} else {
							
								return;
							
							}
						
						}
						
					}
				} });
				

			}
		},
		error: function (xmlhttp) {
		  alert('An error occured: ' + xmlhttp.status);
		}

			  
	});
	
}

function request(proctorname,officelocation,tti,qsi,email,k,courseid) {
	qsi = $('#alltests').val();
	
	if (!email) {
		alert('An email cannot be sent to this proctor.');
		return;
	}

	var theurl = '/careerladder/takentest.php?uid='+tti+'&nid='+courseid;
	
		$.ajax({
			url: theurl,
			cache: false,
			dataType: "html",
			success: function(data) { 
				$('#testtakennum').text(data);
		//alert(theurl+ ' - ' + $('#testtakennum').text()); return;
		var answer='';
		if ($('#testtakennum').text()>0) {
		
			var answer = confirm("You have already passed the test for the course. Would you like to take the test again? Please Click OK to confirm, otherwise click Cancel.")
			if (answer){
				$('#testtakennum').text("0");
			}
			else{
				return;
			}	
		}
		
		if ($('#testtakennum').text()<=0) {
	
			if (!answer)
				var answer2 = confirm("You are trying to request a proctor to schedule a test for you. Please click OK to confirm. If you do not wish to send a request to the proctor at this time, please click Cancel.");
			else
				answer2 = 'true';
			if (answer2) {
				$('#request'+k+'on').hide();
				$('#request'+k+'off').show();										
				$.ajax({
					type: "POST",
					url: '<?php echo base_path(); ?>testrequest?proctorname='+proctorname+'&proctoremail='+email+'&officelocation='+officelocation+'&tti='+tti+'&qsi='+qsi+'&courseid='+courseid,
					cache: false,
					dataType: "html",
					success: function (html) {
						alert('An email has been sent to the proctor.');
					},
					error: function (xmlhttp) {
					  alert('An error occured: ' + xmlhttp.status);
					}

						  
				});
			} else {
			
				return;
			
			}			
			

			
		}
	} });	
	

	
}

</script>

<?php 

function normaltime($t) {

$xh = explode(":",$t);

$h = $xh[0];

if ($h>12)
	$h-=12;
	
$newtime = $h.':'.$xh[1];

if ($xh[0]>12)
	$newtime.=" PM";
else
	$newtime.=" AM";
	
return $newtime;

}

?>

<style type="text/css">
table.sample {
	border-width: 0px;
	border-spacing: 0px;
	border-style: solid;
	border-color: black;
	background-color: white;
	width: 100%;
}
table.sample th {
	border-width: 1px;
	padding: 1px;
	border-style: inset;
	border-color: black;
	background-color: white;
}
table.sample td {
	border-width: 1px;
	padding: 0px;
	border-style: ridge;
	border-style: inset;
	border-color: black;
	/*background-color: white;*/
	padding: 10px;
}
.headtd {
	background-color: #189AB0; 
	font-weight: bold;
	color: #ffffff;
}
</style>
<?php

global $user;

$profile = profile_load_profile($user);

if (!$user->uid)
	header('Location: '.base_path());
	
	
	
	$file = "..".$GLOBALS['hvcp_config_default_base_path']."sites/default/hvcp.functions.inc";

	require_once($file);

	//echo "Ganappa <br />";
	
	
	
 	$coords = vcn_get_zip_code_lat_lon($_GET['zipcode']);
	$latitude = $coords["latitude"];
	$longitude = $coords["longitude"]; 	
	
	$conn = vcn_connect_to_db();
	
$ziptrue=0;	
$queryt = "select * from hvcp.zipxarea where zipcode='".$_GET['zipcode']."'"; 
$resultt = mysql_query($queryt);
while($rowt = mysql_fetch_object($resultt))
	$ziptrue++;	
		

if (strlen($_GET['zipcode'])==5 && $ziptrue) { 
	$query0 = "select *,c.course_title as ct, vts.test_taker_id as tti,
	VCNGetDistanceBetweenTwoPoints( $latitude, $longitude, mz.latitude, mz.longitude ) as distance
	from hvcp.vcn_proctor_time_slot vpts
  inner join hvcp.vcn_test_session vts on vts.TIME_SLOT_ID = vpts.TIME_SLOT_ID 
  inner join hvcp.vcn_course c on vts.question_set_id = c.drupal_test_id 
  inner join hvcp.vcn_proctor vp on vts.office_id=vp.office_id 
  inner join hvcp.vcn_office_partners vop on vop.office_id=vts.office_id 
  JOIN vcn_master_zipcode mz ON (mz.zip = vop.zipcode)
  where mz.zip IS NOT NULL AND mz.latitude IS NOT NULL and vpts.NUMBER_OF_SESSIONS>0 and vpts.NUMBER_OF_SESSIONS<=3 and vpts.BY_APPOINTMENT='N' and vts.test_taker_id='".$user->uid."' and DATE(vpts.time_slot_date) >= DATE(NOW()) and vop.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER') ORDER BY vpts.time_slot_date ASC";
  
  $result0 = mysql_query($query0);
  $removecount = mysql_num_rows($result0);
  
  while($row0 = mysql_fetch_object($result0))
	$resultcopy0[] = $row0;

	$query = "select *, vp.email as proctoremail, vts.time_slot_id as tsi, vts.question_set_id as qsi, c.drupal_test_id as dti, c.course_title as ct, vts.test_taker_id as tti,
	vp.proctor_id as PROCTOR_ID, vp.office_id as OFFICE_ID, vpts.time_slot_id as TIME_SLOT_ID,
	VCNGetDistanceBetweenTwoPoints( $latitude, $longitude, mz.latitude, mz.longitude ) as distance  from hvcp.vcn_office_zipcode voz 
	inner join hvcp.vcn_proctor vp on voz.office_id=vp.office_id 
	inner join hvcp.vcn_office_partners vop on vop.office_id=vp.office_id 
	inner join hvcp.vcn_proctor_time_slot vpts on vpts.proctor_id=vp.proctor_id and DATE(vpts.time_slot_date) >= DATE(NOW()) and vpts.time_slot_id>0 
	left join hvcp.vcn_test_session vts on vpts.time_slot_id = vts.time_slot_id  and vts.test_taker_id='".$user->uid."'
	left join hvcp.vcn_course c on vts.question_set_id = c.drupal_test_id 
	JOIN vcn_master_zipcode mz ON (mz.zip = vop.zipcode) 
	
	where mz.zip IS NOT NULL AND mz.latitude IS NOT NULL and voz.ZIPCODE='".$_GET['zipcode']."' and vpts.BY_APPOINTMENT='N' and vop.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER') ORDER BY vpts.time_slot_date ASC, vpts.start_time ASC";
	$result = mysql_query($query);
 	$count = mysql_num_rows($result);

	if ($count < 1) {
		$sql = "SELECT op.office_id, VCNGetDistanceBetweenTwoPoints( $latitude, $longitude, mz.latitude, mz.longitude ) as distance 
				FROM vcn_office_partners op 
			
				JOIN vcn_master_zipcode mz ON (mz.zip = op.zipcode)  
				WHERE mz.zip IS NOT NULL 
				AND mz.latitude IS NOT NULL  and op.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER')
				ORDER BY distance ASC  
				LIMIT 1 ";	

		$resultid = mysql_query($sql);// or die("Error getting closest Office Partner: " . mysql_error());
		$row = mysql_fetch_object($resultid);

		$query1 = "	select *, 
					vp.email as proctoremail, vts.time_slot_id as tsi, vts.question_set_id as qsi, c.drupal_test_id as dti, c.course_title as ct, vts.test_taker_id as tti,
					vp.proctor_id as PROCTOR_ID, vp.office_id as OFFICE_ID, vpts.time_slot_id as TIME_SLOT_ID,
					VCNGetDistanceBetweenTwoPoints( $latitude, $longitude, mz.latitude, mz.longitude ) as distance 
					FROM hvcp.vcn_proctor vp
					join vcn_office_partners op on vp.OFFICE_ID = op.OFFICE_ID
					inner join hvcp.vcn_proctor_time_slot vpts on vpts.proctor_id = vp.proctor_id and DATE(vpts.time_slot_date) >= DATE(NOW()) and vpts.time_slot_id > 0 
					left join hvcp.vcn_test_session vts on vpts.time_slot_id = vts.time_slot_id and vts.test_taker_id='".$user->uid."'
					left join hvcp.vcn_course c on vts.question_set_id = c.drupal_test_id 						
					JOIN vcn_master_zipcode mz ON (mz.zip = op.zipcode)  
					WHERE mz.zip IS NOT NULL AND mz.latitude IS NOT NULL and vp.office_id = '$row->office_id' and vpts.BY_APPOINTMENT='N' and op.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER')
					ORDER BY vpts.time_slot_date ASC, vpts.start_time ASC"; 


		$result = mysql_query($query1) or die("Error getting closest Office Partner: " . mysql_error());

	} 	
	
	
	$query2="select * from hvcp.vcn_test_session vts where vts.test_taker_id='".$user->uid."'";
	$result2 = mysql_query($query2);
	


	$tsiar=array();
	while($row2 = mysql_fetch_object($result2)) {
		$tsiar[]=$row2->TIME_SLOT_ID;
	}
	
	
	
	$queryp = "select *, p.EMAIL as proctoremail from hvcp.vcn_office_zipcode voz inner join hvcp.vcn_office_partners vop on voz.OFFICE_ID = vop.OFFICE_ID inner join hvcp.vcn_proctor p on p.OFFICE_ID = vop.OFFICE_ID where voz.zipcode = '".$_GET['zipcode']."' and vop.CATEGORY in ('Proctor_Goodwill','Proctor_IAJVS','Proctor_SER')";
	$resultp = mysql_query($queryp);
	
	$exist=0;
	$teacherar  = array();
	$k=0;
	while($row = mysql_fetch_object($resultp)) {	
		

		if (($row->AVAILABLE_ON_DEMAND=='y' || $row->AVAILABLE_ON_DEMAND=='Y' )) {
			if (strlen($row->CITY)&&strlen($row->STATE)) {
				$teacherar[$k]['address']=$row->ADDRESS."<br/>".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE;
				$teacherar[$k]['address1line']=$row->ADDRESS." ".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE;
			}
			$teacherar[$k]['proctor']=$row->PROCTOR_NAME;
			$teacherar[$k]['email']=$row->proctoremail;
			
			$exist++;
		}	
	
		$k++;
	}

	

} 

	$query3 = "select c.* from hvcp.vcn_course c right join drupal.node n on c.DRUPAL_TEST_ID = n.nid where c.drupal_test_id > 0 order by c.course_title asc";
	$result3 = mysql_query($query3);

vcn_disconnect_from_db($conn);

?>
<br/>
Please note that this is <strong>not an online activity</strong>. The test will be conducted at the office site and you have to attend in-person. Please note the office address and the distance.


<br/><br/>
Following is a list of upcoming tests you have already scheduled. In case you are unable to make any of them, you may click "Remove" to take it out of your schedule.
<br/><br/>
<?php $testcount=0;
if (strlen($_GET['zipcode'])==5 && $result) {
	$testcount = mysql_num_rows($result);
	
	while($row = mysql_fetch_object($result))
		$resultcopy[] = $row;


}

?>
<?php if (!$removecount): ?>
<br/><br/>
<?php endif; ?>

<?php if ($removecount): ?>
<br/>
<?php endif; ?>

<h5 style="margin-top:-10px;">Time Slots Reserved</h5>
<?php if ($removecount): ?>
<table class="sample"> 
<tr>
<td class="headtd" width="67">Date</td>
<td class="headtd" width="204">Course Name</td>
<td class="headtd" width="195">Office Address</td>
<td class="headtd" width="40">Distance</td>
<td class="headtd" width="85">Proctor</td>
<td class="headtd" width="65">Start Time</td>
<td class="headtd" width="65">End Time</td>
<td width="71" class="headtd">Action</td>
</tr>
<?php if (strlen($_GET['zipcode'])==5) { foreach ($resultcopy0 as $row) {  if (($row->NUMBER_OF_SESSIONS>=3 && !in_array($row->TIME_SLOT_ID,$tsiar)) || $row->NUMBER_OF_SESSIONS<1 || !in_array($row->TIME_SLOT_ID,$tsiar) || ($user->uid!=$row->tti && $row->NUMBER_OF_SESSIONS>0)) continue; ?>
<tr>
<td><?php $date = getdate(strtotime($row->TIME_SLOT_DATE)); $thedate=$date['mon'].'/'.$date['mday'].'/'.$date['year']; echo $thedate; ?></td>
<td><?php echo $row->ct; ?></td>
<td><?php $a1l = $row->ADDRESS." ".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; 
	if (strlen($row->CITY)&&strlen($row->STATE)) echo $row->ADDRESS."<br/>".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; ?></td>
<td><?php echo number_format($row->distance, 1, '.', ','); ?> miles</td>
<td><?php echo $row->PROCTOR_NAME; ?></td>
<td><?php echo normaltime($row->START_TIME); ?></td>
<td><?php echo normaltime($row->END_TIME); ?></td>
<td>
<div>
<a href="javascript:void(0);" onclick="removetest('<?php echo $row->TIME_SLOT_ID; ?>','<?php echo $user->uid; ?>');"><img alt="Reserve" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/tests/images/remove.png" /></a>
</div>
</td>
</tr>
<? } } ?>
</table>
<br/><br/>
<?php else: ?>

None<br/><br/>

<?php endif; ?>


<?php if (!$removecount): ?>
<br/><br/>
<?php endif; ?>
To find allocated timeslots and/or possible appointments available, please enter your zip code and the course below. 



<div style="margin-top:30px; margin-bottom:40px;">
	<div style="float:left;">
	<strong>Zip Code</strong> <label><input type="text" id="testzipcode" style="width:50px;" maxlength="5" onkeypress="return numericonly(event);" value="<?php if (strlen($_GET['zipcode'])==5) echo $_GET['zipcode']; ?>" /></label> 
	</div>
	
	<div style="float:left; margin-left:10px;">
	<strong>Course Name</strong>
	<label><select id="alltests">
	  <?php while($row3 = mysql_fetch_object($result3)) { ?>
	  <option <?php if ($_GET['test']==$row3->DRUPAL_TEST_ID) {echo 'selected="selected"'; $qsi=$row3->DRUPAL_TEST_ID; $testname=$row3->COURSE_TITLE; } ?> value="<?php echo $row3->DRUPAL_TEST_ID; ?>"><?php echo $row3->COURSE_TITLE; ?></option>
	  <?php } ?>
	</select></label> 
	</div>	
	
	<div style="margin-top:-2px;float:left; margin-left:10px;">
	<label><input type="image" onclick="zipvalidation();" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/ocupations_search/search.png" title="Search" alt="Search" name="Search" id="Search"></label>
	</div>

</div>

<?php if (!$testcount): ?>
<br/><br/><br/><span style='color:#FF0000;'>There are no tests available in this area.</span><br/><br/>
<?php endif; ?>

<?php 
$realtestcount=0;
foreach ($resultcopy as $row) { 

if ($row->NUMBER_OF_SESSIONS!=0 && $row->NUMBER_OF_SESSIONS<3 && in_array($row->TIME_SLOT_ID,$tsiar) || ($row->NUMBER_OF_SESSIONS>=3 && in_array($row->TIME_SLOT_ID,$tsiar))) 
	continue;
	
$realtestcount++;
}

if ($testcount && !$realtestcount): ?>
<br/><br/><br/><span style='color:#FF0000;'>No time slots available</span><br/><br/>
<?php endif; ?>

<?php if ($testcount && $realtestcount): ?>
<br/><br/><br/>

Following is a list of allocated time slots for next 4 weeks at the office nearest to you. To reserve an available time slot please click "Reserve" in that line.<br/><br/>

<table class="sample"> 
<tr>
<td class="headtd" width="67">Date</td>
<td class="headtd" width="204">Course Name</td>
<td class="headtd" width="195">Office Address</td>
<td class="headtd" width="40">Distance</td>
<td class="headtd" width="85">Proctor</td>
<td class="headtd" width="65">Start Time</td>
<td class="headtd" width="65">End Time</td>
<td width="71" class="headtd">Action</td>
</tr>
<?php if (strlen($_GET['zipcode'])==5) { foreach ($resultcopy as $row) { if ($row->NUMBER_OF_SESSIONS!=0 && $row->NUMBER_OF_SESSIONS<3 && in_array($row->TIME_SLOT_ID,$tsiar) || ($row->NUMBER_OF_SESSIONS>=3 && in_array($row->TIME_SLOT_ID,$tsiar))) continue; ?>
<tr>
<td><?php $date = getdate(strtotime($row->TIME_SLOT_DATE)); $thedate=$date['mon'].'/'.$date['mday'].'/'.$date['year']; echo $thedate; ?></td>
<td><script>document.write($('#alltests option:selected').text());</script></td>
<td><?php $a1l = $row->ADDRESS." ".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; 
	if (strlen($row->CITY)&&strlen($row->STATE)) echo $row->ADDRESS."<br/>".trim($row->CITY).", ".$row->STATE." ".$row->ZIPCODE; ?></td>
<td><?php echo number_format($row->distance, 1, '.', '.'); ?> miles</td>
<td><?php echo $row->PROCTOR_NAME; ?></td>
<td><?php echo normaltime($row->START_TIME); ?></td>
<td><?php echo normaltime($row->END_TIME); ?></td>
<td>
<?php if ($row->NUMBER_OF_SESSIONS<3 && !in_array($row->TIME_SLOT_ID,$tsiar)): ?>
<div id="reserve<?php echo $row->TIME_SLOT_ID; ?>on">
<?php $officename = str_replace("'", "", $row->OFFICE_NAME); ?>
<a href="javascript:void(0);" onclick="reserve('<?php echo $qsi; ?>','<?php echo $user->uid; ?>','<?php echo $row->PROCTOR_ID; ?>','<?php echo $row->OFFICE_ID; ?>','<?php echo $row->TIME_SLOT_ID; ?>','<?php echo $officename; ?>','<?php echo $thedate; ?>','<?php echo $row->START_TIME; ?>','<?php echo $row->END_TIME; ?>','<?php echo $row->PROCTOR_NAME; ?>','<?php echo $a1l; ?>','<?php echo $row->proctoremail; ?>','<?php echo $testname; ?>');"><img alt="Reserve" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/tests/images/btn_reserve.png" /></a>
</div>
<?php endif; ?>
<div id="reserve<?php echo $row->TIME_SLOT_ID; ?>off" <?php if ($row->NUMBER_OF_SESSIONS<3  && !in_array($row->TIME_SLOT_ID,$tsiar)) echo 'style="display: none;"'; ?>>
<img alt="Reserve" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/tests/images/btn_reserve_grey.png" />
</div>
</td>
</tr>
<? } } ?>
</table>

<?php endif; //main if ?>


<br/><br/><br/>


<?php if ($exist): ?>
For the following Office/Proctor, you can schedule a test only by appointment. Please click "Request" corresponding to the office/proctor to send a request for appointment. The proctor will schedule the test and you will receive a confirmation email.

<br/><br/>

<table class="sample"> 
<tr>
<td class="headtd">Office</td>
<td class="headtd">Proctor</td>
<td class="headtd">Email</td>
<td width="50px" class="headtd">Action</td>
</tr>
<?php foreach ($teacherar as $k=>$v): ?>
<tr>
<td><?php echo $teacherar[$k]['address']; ?></td>
<td><?php echo $teacherar[$k]['proctor']; ?></td>
<td><?php echo $teacherar[$k]['email']; ?></td>
<td>
<div id="request<?php echo $k; ?>on">
<a href="javascript:void(0);" onclick="request('<?php echo $teacherar[$k]['proctor']; ?>', '<?php echo $teacherar[$k]['address1line']; ?>','<?php echo $user->uid; ?>', $('#alltests option:selected').text(), '<?php echo $teacherar[$k]['email']; ?>','<?php echo $k; ?>',$('#alltests').val() );"> 
<img alt="Request" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/tests/images/btn_request.png" />
</a>
</div>
<div id="request<?php echo $k; ?>off" style="display:none;">
<img alt="Request" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/tests/images/btn_request_grey.png" />
</div>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<div id="testtakennum" style="display:none;"></div>