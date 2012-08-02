<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
function changeoptions(value,ready) {
	
	for (var i=0; i<=7; i++)
		if (document.getElementById('training2'+i))
			$('#training2'+i).attr("disabled", false);	

	for (var i=0; i<=document.getElementById('training1').value; i++) 
		if (document.getElementById('training2'+i) && document.getElementById('training2'+i).value.indexOf)
			$('#training2'+(i-1)).attr("disabled", true);
			
			//document.getElementById('training2'+i).style.display='none';	
	
	//if (value<7 && !ready)
	//	value++;
	//else
	//	$('#training2'+i).attr("disabled", false);

	document.getElementById('training2').value = value;


}

$(document).ready(function() {
  changeoptions(document.getElementById('training2').value,'ready');
});

function matchurl() {

window.open('<?php echo base_path(); ?>educationmatchpopup/current/'+document.getElementById('training1').value+'/towards/'+document.getElementById('training2').value,'_self');

}

</script>


<?php 
$includes = drupal_get_path('module','vcn').'/includes';

require_once($includes . '/vcn_common.inc');

$catlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','category','list');

$post1='';
$post2='';

$xurl=explode('/',$_SERVER['REQUEST_URI']);

foreach ($xurl as $k=>$v) {

	if ($v=='current')
		$post1=$xurl[$k+1];
		
	if ($v=='towards')
		$post2=$xurl[$k+1];		

}

$vars['education_category_id_less_2'] = strlen($post1)?$post1:1; 
$trainingone = vcn_get_data($errors, $vars, $valid,'occupationsvc','occupation','list',false,false,'display_title','asc');

$train2val = 1;
if (strlen($post2)) {
	$train2val = $post2;
}

$vars['education_category_id_less_2'] = $train2val; 
$trainingtwo = vcn_get_data($errors, $vars, $valid,'occupationsvc','occupation','list',false,false,'display_title','asc');
?>

<h3>Match Your Education to Careers</h3>

<p style="none;">Please provide the following information to determine the careers suitable for you.</p>


<div id="grey-match-box">
		
		
		<div style="padding-bottom: 3px; font-size: 12px;">
			<div style="width: 400px; float: left; font-size: 12px;">
				<b>Your Current Education Level</b>
			</div>
			<div style="width: 500px; float: left; font-size: 12px;">
				<b>Education Level that you will work towards</b>
			</div>
		</div>
	<br />		
<div style="float:left;">
		
	<div style="width: 400px; float: left; font-size: 12px;">		
		<label for="training1">
		<select name="training1" id="training1" style="width:370px; height:23px; border: 1px solid #189AB0;" onchange="changeoptions(this.value);">
		  <?php $catcount=-1; foreach ($catlist->category as $k=>$v): $catcount++; ?>
		  <option id="training1<?php echo $catlist->category[$catcount]->educationcategoryid; ?>" <?php if ($post1==$catlist->category[$catcount]->educationcategoryid) echo 'selected="selected"'; ?> value="<?php echo $catlist->category[$catcount]->educationcategoryid; ?>"><?php echo $catlist->category[$catcount]->educationcategoryname; ?></option>
		  <?php endforeach; ?>
		</select>
		</label>
	</div>

		
	<div style="width: 400px; float: left; font-size: 12px;">
		<label for="training2">
		<select name="training2" id="training2" style="width:370px; height:23px; border: 1px solid #189AB0;">
		  <?php $catcount=-1; foreach ($catlist->category as $k=>$v): $catcount++; ?>
		  <option id="training2<?php echo $catlist->category[$catcount]->educationcategoryid; ?>" <?php if ($post2==$catlist->category[$catcount]->educationcategoryid) echo 'selected="selected"'; ?> value="<?php echo $catlist->category[$catcount]->educationcategoryid; ?>"><?php echo $catlist->category[$catcount]->educationcategoryname; ?></option>
		  <?php endforeach; ?>
		</select>
		</label>
	</div>
</div>
	
	<div style="float:left; margin-left:0px;">
	<input type="image" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/getting_started/images/go.png" alt="Submit" onclick="matchurl();" /> 	
	</div>
	
</div>

<p><b>Hint:</b> Healthcare careers often require attainment of specific academic credentials. Holding an Associate's or Bachelor's Degree in a non-healthcare related field might not substitute for the degree requirement in a specific healthcare field.</p>
<br/><br/>

<b>Careers that you could pursue now:</b>

<?php $titlear=array(); ?>
<ul>
<?php for ($i=0; $i<=82; $i++): if ($trainingone->occupation[$i]->displaytitle): ?>
<li>
<a href="/careerladder/overview_with_back.php?onetcode=<?php echo $trainingone->occupation[$i]->onetcode; ?>" title ="Career Overview">
<?php echo $trainingone->occupation[$i]->displaytitle; ?></a></li>
<?php $titlear[]=(string)$trainingone->occupation[$i]->onetcode; ?>
<?php endif; endfor; ?>
</ul>
<!--
<div style="margin-left:20px;">
<a href="javascript:void(0);" onclick="window.open('<?php echo base_path(); ?>careergrid/education_category_id_less_2/'+document.getElementById('training1').value,'_self');">(see all)</a>
</div>
-->
<br/>
<br/>

<div id="work-towards">

	<b>Careers that you could pursue after obtaining the higher education level that you have indicated:</b>

	<ul>
	<?php 
	$foundone = false;
	for ($i=0; $i<=82; $i++): 
		if ($trainingtwo->occupation[$i]->displaytitle && !in_array((string)$trainingtwo->occupation[$i]->onetcode,$titlear)): 
			$foundone = true;
	?>
	<li><a href="/careerladder/overview_with_back.php?onetcode=<?php echo $trainingtwo->occupation[$i]->onetcode; ?>"><?php echo $trainingtwo->occupation[$i]->displaytitle; ?></a></li>
	<?php 
		endif; 
	endfor; 
	
	if (!$foundone) {
		echo 'None';	
	}
	?>
	</ul>
<br/>
<br/>

</div>

<!--a href="javascript:history.back()">Back</a -->
