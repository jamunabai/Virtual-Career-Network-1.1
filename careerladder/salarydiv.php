<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

require_once('vcn.rest.inc'); 

$bp = $GLOBALS['hvcp_config_default_base_path'];

function theContent($onetcode,$zipcode) {

  $rest = new vcnRest;

  $rest->setService('occupationsvc');
  $rest->setModule('occupation');
  $rest->setAction('detail');
  
  // standard filters
  $rest->setRequestKey('format','xml');
  $rest->setRequestKey('onetcode',$onetcode);
  
  $rest->setRequestKey('zipcode',$zipcode);

  $rest->setMethod('post');

  $content = $rest->call();
  
  $content = new SimpleXMLElement($content);

  return $content;
}

function getNational($onetcode) {

		$rest = new vcnRest;

		$rest->setService('occupationsvc');
		$rest->setModule('occupation');
		$rest->setAction('detail');

		// standard filters
		$rest->setRequestKey('format','xml');
		$rest->setRequestKey('onetcode',$onetcode);

		$rest->setMethod('post');

		$content = $rest->call(); 

		$content = new SimpleXMLElement($content);

		$content = $content->data;

		return $content;
}

$onetcode = $_GET['onetcode'];

$zipcode = $_GET['zipcode'];

$content = theContent($onetcode,$zipcode);

$state = $content->params->state;
	
$content = $content->data->occupation;


?>



<span class="lineunder">Salary & Outlook</span><br/><br/>
<b>State and National Wages</b>
<br/><br/>
<?php if ($onetcode=='29-1128.00' || $onetcode=='29-2035.00' || $onetcode=='31-9097.00'): ?>

This is a new occupation for 2011 and the data is not yet available.  The information will be provided when it becomes available.

<?php endif; ?>

<?php if (!$content->wageocc->item[1]->pct10): ?>

No information available.<br/><br/><br/>

<?php endif; ?>

<?php $natdata = getNational($onetcode);  ?>

<?php if ($content->wageocc->item[1]->pct10 && $content->wageocc->item[1]->pct25 && $content->wageocc->item[1]->median && $content->wageocc->item[1]->pct75 && $content->wageocc->item[1]->pct90): ?>

<a href="javascript:void(0);" onclick="salaryonoff('wage-table');" style="font-weight: bold;" id="wage-table-link">Wage Table</a> | <a href="javascript:void(0);" onclick="salaryonoff('hourly-wage-chart');" id="hourly-wage-chart-link">Hourly Wage Chart</a> | <a href="javascript:void(0);" onclick="salaryonoff('annual-wage-chart');" id="annual-wage-chart-link">Annual Chart</a><br/><br/><br/>

<div id="wage-table">
<table width="100%" cellspacing="0" cellpadding="3" bordercolor="#000000" border="1" summary="this table displays national and state wage information for the selected occupation">
<thead> 
<tr bgcolor="#CCCCCC">
<th width="27%" align="left" rowspan="2" class="text" scope="col">Location</th>
<th width="8%" align="left" rowspan="2" class="text" scope="col">Pay<br>Period</th>
<th width="65%" align="center" colspan="5" class="text" scope="colgroup"><center><?php echo $content->wageocc->item[0]->periodyear; ?></center></th>
</tr>
<tr bgcolor="#CCCCCC">
<th width="13%" align="center" class="text" scope="colgroup"><center>10%</center></th>
<th width="13%" align="center" class="text" scope="colgroup"><center>25%</center></th>
<th width="13%" align="center" class="text" scope="colgroup"><center>Median</center></th>
<th width="13%" align="center" class="text" scope="colgroup"><center>75%</center></th>
<th width="13%" align="center" class="text" scope="colgroup"><center>90%</center></th>
</tr>
</thead> 
<tbody> 
<tr>
<td align="left" rowspan="2" class="text" scope="row"><!--SIT1-->United States<!--/SIT1--></td>
<td bgcolor="#B9D9EC" align="left" class="text">Hourly</td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[0]->pct10),0,'.',','); ?></td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[0]->pct25),0,'.',','); ?></td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[0]->median),0,'.',','); ?></td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[0]->pct75),0,'.',','); ?></td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[0]->pct90),0,'.',','); ?></td>
</tr>
<tr>
<td align="left" class="text">Yearly</td>
<td align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[1]->pct10),0,'.',','); ?></td>
<td align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[1]->pct25),0,'.',','); ?></td>
<td align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[1]->median),0,'.',','); ?></td>
<td align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[1]->pct75),0,'.',','); ?></td>
<td align="center" class="text">$<?php echo number_format(floatval($natdata->occupation->wageocc->item[1]->pct90),0,'.',','); ?></td>
</tr>
<?php if ($zipcode): ?>
<tr>
<td align="left" rowspan="2" class="text" scope="row"><!--SIT1--><?php echo $state; ?><br/>(<?php echo $zipcode; ?>)<!--/SIT1--></td>
<td bgcolor="#B9D9EC" align="left" class="text">Hourly</td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[0]->pct10),0,'.',','); ?></td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[0]->pct25),0,'.',','); ?></td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[0]->median),0,'.',','); ?></td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[0]->pct75),0,'.',','); ?></td>
<td bgcolor="#B9D9EC" align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[0]->pct90),0,'.',','); ?></td>
</tr>
<tr>
<td align="left" class="text">Yearly</td>
<td align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[1]->pct10),0,'.',','); ?></td>
<td align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[1]->pct25),0,'.',','); ?></td>
<td align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[1]->median),0,'.',','); ?></td>
<td align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[1]->pct75),0,'.',','); ?></td>
<td align="center" class="text">$<?php echo number_format(floatval($content->wageocc->item[1]->pct90),0,'.',','); ?></td>
</tr>
<?php endif;  ?>
</tbody>
</table>
<br/>
<?php if ($content->narativesalaryoutlook) echo $content->narativesalaryoutlook; ?>

</div>

<div id="hourly-wage-chart" style="display:none;">

<div align="center" style="height:40px; margin-left:115px; margin-bottom:10px; padding-right:50px; padding-top:4px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/key.jpg) no-repeat;">
<?php if (strlen($zipcode)==5): ?>
<?php echo $state; ?>(<?php echo $zipcode; ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;United States

<?php else: ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;United States
<?php endif; ?>

</div>

<div style="float:left;">
<div style="margin-top:28px;" align="right">High</div>
<div style="margin-top:44px;" align="right">Median</div>
<div style="margin-top:44px;" align="right">Low</div>
</div>
<?php 
$scount=0; 
if (floatval($natdata->occupation->wageocc->item[1]->pct90)<35000 || floatval($content->wageocc->item[1]->pct90)<35000) {
	$annualvar='.2'; 
	$hourlyvar=1/9;
	$scount=1;
}
if ((floatval($natdata->occupation->wageocc->item[1]->pct90)>35000 || floatval($content->wageocc->item[1]->pct90)>35000) && (floatval($natdata->occupation->wageocc->item[1]->pct90)<89999 || floatval($content->wageocc->item[1]->pct90)>89999)) {
	$annualvar='.22'; 
	$hourlyvar=1/6;
	$scount=1;
}

if ((floatval($natdata->occupation->wageocc->item[1]->pct90)>35000 || floatval($content->wageocc->item[1]->pct90)>35000) && (floatval($natdata->occupation->wageocc->item[1]->pct90)<89999 || floatval($content->wageocc->item[1]->pct90)>89999) && $onetcode == '29-1126.00') {
	$annualvar='.27'; 
	$hourlyvar=1/8;
	$scount=1;
}

if ((floatval($natdata->occupation->wageocc->item[1]->pct90)>35000 || floatval($content->wageocc->item[1]->pct90)>35000) && (floatval($natdata->occupation->wageocc->item[1]->pct90)<89999 || floatval($content->wageocc->item[1]->pct90)>89999) && $onetcode == '21-1022.00') {
	$annualvar='.27'; 
	$hourlyvar=1/8;
	$scount=1;
}

if (floatval($natdata->occupation->wageocc->item[1]->pct90)>90000 || floatval($content->wageocc->item[1]->pct90)>90000) {
	$annualvar='.35'; 
	$hourlyvar=1/6;
	$scount=1;
}
if (floatval($natdata->occupation->wageocc->item[1]->pct90)>120000 || floatval($content->wageocc->item[1]->pct90)>120000) {
	$annualvar='.4'; 
	$hourlyvar=1/5;
	$scount=1;
}
if (floatval($natdata->occupation->wageocc->item[1]->pct90)>135000 || floatval($content->wageocc->item[1]->pct90)>135000) {
	$annualvar='.42'; 
	$hourlyvar=1/4.5;
	$scount=1;
}
if ($scount<1) {
	$annualvar='.298';
	$hourlyvar=1/7;
}
if ((floatval($natdata->occupation->wageocc->item[1]->pct90)>35000 || floatval($content->wageocc->item[1]->pct90)>35000) && (floatval($natdata->occupation->wageocc->item[1]->pct90)<89999 || floatval($content->wageocc->item[1]->pct90)>89999) && $onetcode == '29-1128.00') {
	$annualvar='.27'; 
}
if ((floatval($natdata->occupation->wageocc->item[1]->pct90)>35000 || floatval($content->wageocc->item[1]->pct90)>35000) && (floatval($natdata->occupation->wageocc->item[1]->pct90)<89999 || floatval($content->wageocc->item[1]->pct90)>89999) && $onetcode == '29-1031.00') {
	$annualvar='.27'; 
}
if ((floatval($natdata->occupation->wageocc->item[1]->pct90)>35000 || floatval($content->wageocc->item[1]->pct90)>35000) && (floatval($natdata->occupation->wageocc->item[1]->pct90)<89999 || floatval($content->wageocc->item[1]->pct90)>89999) && $onetcode == '19-2041.00') {
	$annualvar='.45'; 
}

?>
	
<?php

$salaryhar=array();
$salaryhar[0]=floatval($natdata->occupation->wageocc->item[0]->pct90);
$salaryhar[1]=floatval($content->wageocc->item[0]->pct90);
$salaryhar[2]=floatval($natdata->occupation->wageocc->item[0]->median);
$salaryhar[3]=floatval($content->wageocc->item[0]->median);
$salaryhar[4]=floatval($natdata->occupation->wageocc->item[0]->pct10);
$salaryhar[5]=floatval($content->wageocc->item[0]->pct10);

$maxsal = max($salaryhar);
foreach ($salaryhar as $k=>$v)
	if ($v==$maxsal)
		$maxkey=$k;

//print_r($salaryhar); echo "<br/><br/>";
//echo '['.$maxkey.'] '.$maxsal; echo "<br/><br/>";

$pixelhar=array();

foreach ($salaryhar as $k=>$v) {
	if ($k==$maxkey) {
		$pixelhar[$k] = .80 * 338;
		$highestpixel = $pixelhar[$k];
	}
}

foreach ($salaryhar as $k=>$v) {
	if ($k==$maxkey)
		continue;
	
	$divide = $salaryhar[$k]/$maxsal;
	
	$pixelhar[$k] = $divide * .80 * 338;
}
		

?>
	
	
<?php if (stristr($_SERVER['HTTP_USER_AGENT'],'MSIE 9')): ?>
<div style="float:left; border:1px solid #000000; padding:10px; margin-left: 55px; width: 338px; margin-top:-160px;">
<?php else: ?>	
<div style="float:left; border:1px solid #000000; padding:10px; margin-left: 5px; width: 338px;">
<?php endif; ?>

	
	<div style="<?php if (strlen($zipcode)!=5) echo 'margin-top: 12px;'; ?> margin-left: -10px; height:25px; width: <?php echo $pixelhar[0]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryus.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($natdata->occupation->wageocc->item[0]->pct90),0,'.',',')); ?></div>
	</div>
	<?php if (strlen($zipcode)==5): ?>
	<div style="margin-left: -10px; height:25px; width: <?php echo $pixelhar[1]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryst.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($content->wageocc->item[0]->pct90),0,'.',',')); ?></div>
	</div>
	<?php endif; ?>
	<div style="height:10px;"></div>

	<div style="<?php if (strlen($zipcode)!=5) echo 'margin-top: 25px;'; ?> margin-left: -10px; height:25px; width: <?php echo $pixelhar[2]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryus.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($natdata->occupation->wageocc->item[0]->median),0,'.',',')); ?></div>
	</div>
	
	<?php if (strlen($zipcode)==5): ?>
	<div style="margin-left: -10px; height:25px; width: <?php echo $pixelhar[3]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryst.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($content->wageocc->item[0]->median),0,'.',',')); ?></div>
	</div>	
	<?php endif; ?>
	
	<div style="height:10px;"></div>
	
	<div style="<?php if (strlen($zipcode)!=5) echo 'margin-top: 25px;'; ?> margin-left: -10px; height:25px; width: <?php echo $pixelhar[4]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryus.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($natdata->occupation->wageocc->item[0]->pct10),0,'.',',')); ?></div>
	</div>
	
	<?php if (strlen($zipcode)==5): ?>
	<div style="margin-left: -10px; height:25px; width: <?php echo $pixelhar[5]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryst.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($content->wageocc->item[0]->pct10),0,'.',',')); ?></div>
	</div>		
	<?php endif; ?>
	
</div>

<ul style="padding-top:220px;"><li>High is the wage at which 90% of workers earn less and 10% earn more.</li><li>Median is the wage at which 50% of workers earn less and 50% earn more.</li><li>Low is the wage at which 10% of workers earn less and 90% earn more.</li></ul>
</div>

<div id="annual-wage-chart" style="display:none;">

<div align="center" style="height:40px; margin-left:115px; margin-bottom:10px; padding-right:50px; padding-top:4px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/key.jpg) no-repeat;">

<?php if (strlen($zipcode)==5): ?>
<?php echo $state; ?>(<?php echo $zipcode; ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;United States

<?php else: ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;United States
<?php endif; ?>
</div>

<div style="float:left;">
<div style="margin-top:28px;" align="right">High</div>
<div style="margin-top:44px;" align="right">Median</div>
<div style="margin-top:44px;" align="right">Low</div>
</div>

<?php

$salaryaar=array();
$salaryaar[0]=floatval($natdata->occupation->wageocc->item[1]->pct90);
$salaryaar[1]=floatval($content->wageocc->item[1]->pct90);
$salaryaar[2]=floatval($natdata->occupation->wageocc->item[1]->median);
$salaryaar[3]=floatval($content->wageocc->item[1]->median);
$salaryaar[4]=floatval($natdata->occupation->wageocc->item[1]->pct10);
$salaryaar[5]=floatval($content->wageocc->item[1]->pct10);

$maxsal = max($salaryaar);
foreach ($salaryaar as $k=>$v)
	if ($v==$maxsal)
		$maxkey=$k;

//print_r($salaryaar); echo "<br/><br/>";
//echo '['.$maxkey.'] '.$maxsal; echo "<br/><br/>";

$pixelaar=array();

foreach ($salaryaar as $k=>$v) {
	if ($k==$maxkey) {
		$pixelaar[$k] = .98 * 338;
		$highestpixel = $pixelaar[$k];
	}
}

foreach ($salaryaar as $k=>$v) {
	if ($k==$maxkey)
		continue;
		
	$pixelaar[$k] = ($salaryaar[$k]/$maxsal) * .98 * 338;
}
		
//print_r($pixelaar);
?>

<?php if (stristr($_SERVER['HTTP_USER_AGENT'],'MSIE 9')): ?>
<div style="float:left; border:1px solid #000000; padding:10px; margin-left: 55px; width: 338px; margin-top:-160px;">
<?php else: ?>	
<div style="float:left; border:1px solid #000000; padding:10px; margin-left: 5px; width: 338px;">
<?php endif; ?>


	<div style="<?php if (strlen($zipcode)!=5) echo 'margin-top: 12px;'; ?> margin-left: -10px; height:25px; width: <?php echo $pixelaar[0]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryus.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($natdata->occupation->wageocc->item[1]->pct90),0,'.',',')); ?></div>
	</div>
	
	<?php if (strlen($zipcode)==5): ?>
	<div style="margin-left: -10px; height:25px; width: <?php echo $pixelaar[1]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryst.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($content->wageocc->item[1]->pct90),0,'.',',')); ?></div>
	</div>
	<?php endif; ?>
	
	<div style="height:10px;"></div>

	<div style="<?php if (strlen($zipcode)!=5) echo 'margin-top: 25px;'; ?> margin-left: -10px; height:25px; width: <?php echo $pixelaar[2]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryus.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($natdata->occupation->wageocc->item[1]->median),0,'.',',')); ?></div>
	</div>
	
	<?php if (strlen($zipcode)==5): ?>
	<div style="margin-left: -10px; height:25px; width: <?php echo $pixelaar[3]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryst.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($content->wageocc->item[1]->median),0,'.',',')); ?></div>
	</div>	
	<?php endif; ?>

	<div style="height:10px;"></div>
	
	<div style="<?php if (strlen($zipcode)!=5) echo 'margin-top: 25px;'; ?> margin-left: -10px; height:25px; width: <?php echo $pixelaar[4]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryus.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($natdata->occupation->wageocc->item[1]->pct10),0,'.',',')); ?></div>
	</div>
	
	<?php if (strlen($zipcode)==5): ?>
	<div style="margin-left: -10px; height:25px; width: <?php echo $pixelaar[5]; ?>px; background:url(<?php echo $bp; ?>sites/all/modules/custom/vcn/occupations/occupations_detail/images/salaryst.jpg) no-repeat; background-size: 100% 25px;  ">
	<div align="right" style="padding-top: 4px; padding-right: 4px; font-weight: bold;">$<?php echo (number_format(floatval($content->wageocc->item[1]->pct10),0,'.',',')); ?></div>
	</div>
	<?php endif; ?>

</div>

<ul style="padding-top:220px;"><li>High is the wage at which 90% of workers earn less and 10% earn more.</li><li>Median is the wage at which 50% of workers earn less and 50% earn more.</li><li>Low is the wage at which 10% of workers earn less and 90% earn more.</li></ul>

</div>


<br/>

<?php  endif; ?>


<b>State and National Trends</b>
<br/><br/>

<?php if (

(floatval($natdata->occupation->jobgrowth->estemp) && floatval($natdata->occupation->jobgrowth->projemp) && floatval($content->jobgrowth->estemp) && floatval($content->jobgrowth->projemp))

|| (floatval($content->jobgrowth->estemp) && floatval($content->jobgrowth->projemp))

): ?>

<table width="102%" cellspacing="0" cellpadding="3" bordercolor="#000000" border="1" selected"="" occupation="" for="" data="" trends="" the="" displays="" table="" this="">
<thead>
<tr bgcolor="#CCCCCC">
<th align="left" class="text" rowspan="2" scope="col">Location</th>
<th align="center" class="text" colspan="2" scope="colgroup">Employment</th>
<th align="center" class="text" rowspan="2" scope="col">Percent <br>Change</th>
<th align="center" class="text" rowspan="2" scope="col">Job Openings</th>
</tr>
<tr bgcolor="#CCCCCC">
<th align="center" scope="col">2008</th>
<th align="center" scope="col">2018</th>
</tr>
</thead>

<?php if (floatval($natdata->occupation->jobgrowth->estemp) && floatval($natdata->occupation->jobgrowth->projemp)): ?>
<tbody><tr><td width="21%" align="left" scope="row">United States</td>
<td width="11%" align="center"><?php $n08=(number_format(floatval($natdata->occupation->jobgrowth->estemp),0,'.',',')); echo $n08; ?></td>
<td width="11%" align="center"><?php $n18=(number_format(floatval($natdata->occupation->jobgrowth->projemp),0,'.',',')); echo $n18; ?></td>
<td width="14%" align="center"><?php echo number_format(100*(floatval($natdata->occupation->jobgrowth->projemp)/floatval($natdata->occupation->jobgrowth->estemp)-1),0,'.',','); ?>%</td>
<td width="15%" align="center"><?php $a=(number_format(floatval($natdata->occupation->jobgrowth->aopent),0,'.',',')); echo $a; ?></td>
</tr>
</tbody>
<?php endif; ?>

<?php if (strlen($zipcode)==5): ?>
<!--
<thead>

<tr bgcolor="#CCCCCC">
<th align="left" class="text" rowspan="2" scope="col"><?php echo $state; ?></th>
<th align="center" class="text" colspan="2" scope="colgroup">Employment</th>
<th align="center" class="text" rowspan="2" scope="col">Percent <br>Change</th>
<th align="center" class="text" rowspan="2" scope="col">Job Openings</th>
</tr>

<tr bgcolor="#CCCCCC">
<th align="center" scope="col">2008</th>
<th align="center" scope="col">2018</th>
</tr>

</thead>
-->
<tbody><tr><td width="21%" align="left" scope="row"><?php echo $state; ?></td>
<td width="11%" align="center"><?php $n08=(number_format(floatval($content->jobgrowth->estemp),0,'.',',')); echo $n08; ?></td>
<td width="11%" align="center"><?php $n18=(number_format(floatval($content->jobgrowth->projemp),0,'.',',')); echo $n18; ?></td>
<td width="14%" align="center"><?php echo number_format(100*(floatval($content->jobgrowth->projemp)/floatval($content->jobgrowth->estemp)-1),0,'.',','); ?>%
<td width="15%" align="center"><?php $a=(number_format(floatval($content->jobgrowth->aopent),0,'.',',')); echo $a; ?></td>
</td>
</tr>
</tbody>

<?php endif; ?>

</table>
<?php else: ?>

No information available.

<?php endif; ?>



