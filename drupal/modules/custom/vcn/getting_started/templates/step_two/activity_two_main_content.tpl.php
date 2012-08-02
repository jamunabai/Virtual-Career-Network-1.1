<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<style>
select {
	width: 215px; /* Or whatever width you want. */
}
select.expand {
	width: auto;
}

</style>
<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-two');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','2');
</script>
<script type="text/javascript" src="/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/javascripts/top_up-min.js"></script>
<script type="text/javascript">
  TopUp.players_path = "/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/players/";
  TopUp.images_path = "/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/images/top_up/";
</script>


<?php $cma = vcnCma::getInstance(); ?>
<script type="text/javascript">

 $(document).ready(function() {
	 if ($.browser.msie) $('select.wide')
		.bind('focus mouseover', function() { $(this).addClass('expand').removeClass('clicked'); })
		.bind('click', function() { $(this).toggleClass('clicked');  })
		.bind('mouseout', function() { if (!$(this).hasClass('clicked')) { $(this).removeClass('expand'); }})
		.bind('blur', function() { $(this).removeClass('expand clicked'); });
		
		$('select.wide').change(function() { $(this).removeClass('expand');	});		
});
	

function noError(){return true;}
window.onerror = noError;

function thedefault(thisvalue) {
		$('#loading').removeClass('off');
		
		document.getElementById('thetable').style.display = 'block';
		thisvalue = thisvalue.replace(/ /g, "+");
		$("#thetable").load("/careerladder/table.php?zip=<?php echo $vars['zip']; ?>&usersession=<?php echo $cma->usersession; ?>&jobtitle="+thisvalue, function() {
		 $('#loading').addClass('off'); browserlocation();

		});
		
		/*
		var theurl = "/careerladder/table.php?zip=<?php echo $vars['zip']; ?>&usersession=<?php echo $cma->usersession; ?>&a=1&jobtitle="+thisvalue;
		

  $.get(theurl, function(result){
    $("#thetable").html(result); 
	
	$('#loading').addClass('off'); browserlocation();
  });
  
  */
  
		/*
          $.ajax({
            type: "POST",
            url: theurl,
            dataType: "html",
            success: function (html) {
           alert('yes it works');
            },
            error: function (xmlhttp) {
              alert('An error occured: ' + xmlhttp.status);
            }
          });

*/

	
}


function none() {
	document.getElementById('thetable').style.display = 'none';
}



function gettable(value,keyboard) {
	$('#loading').removeClass('off');
	
	
	document.getElementById('thetable').style.display = 'block';
	
	var thetext = document.getElementById('thetext').value;
	thetext = thetext.replace(/ /g, "+");
	
	var cat1 = document.getElementById('category1').value;
	var cat2 = document.getElementById('category2').value;
 
	if (value=='lab' || value=='ofc' || value=='mdn' || value=='ctp' || value=='vsh' || value=='all2') {


		if (cat2=='all3') {
			
			$("#thetable").load("/careerladder/table.php?zip=<?php echo $vars['zip']; ?>&usersession=<?php echo $cma->usersession; ?>&jobtitle="+thetext+"&type="+value, function() {
 $('#loading').addClass('off'); 
browserlocation(value);
});
		}
		else {
			
			$("#thetable").load("/careerladder/table.php?zip=<?php echo $vars['zip']; ?>&usersession=<?php echo $cma->usersession; ?>&jobtitle="+thetext+"&ed="+cat2+"&type="+value, function() {
 $('#loading').addClass('off'); 
 browserlocation(value);
});		
		}
	}
	
	else if (value>0 || value=='all3' || keyboard) { 
		if (value=='all3')
			value='';

	if (cat1=='all2' && keyboard!=1) {
		
		$("#thetable").load("/careerladder/table.php?zip=<?php echo $vars['zip']; ?>&usersession=<?php echo $cma->usersession; ?>&jobtitle="+thetext+"&ed="+value, function() {
		$('#loading').addClass('off'); 
		browserlocation(value);
	});	
	}
	else {
		$("#thetable").load("/careerladder/table.php?zip=<?php echo $vars['zip']; ?>&usersession=<?php echo $cma->usersession; ?>&jobtitle="+thetext+"&type="+cat1+"&ed="+cat2, function() {
		$('#loading').addClass('off'); 
		if (keyboard==1)
			browserlocation(value,'1');
		else
			browserlocation(value);	
	});			
	}
	
	}
	

	//document.getElementById('brdiv').innerHTML='<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';

 


}

function browserlocation(value,from) {
document.getElementById('greentext').innerHTML='Click on the title of a career listed here to view its Career Snapshot to the right. This is also where you add a career to your "Career Wish list".';
 $('#brdiv').val('hey');
 var browser = navigator.appVersion;
 if (browser.toLowerCase().indexOf('msie 7') > -1)	
	$('#brdiv').height($('#thetable').height()+12);
 window.scroll(0,215);
//alert('f'+from + ' v'+value);



	var jt = document.getElementById('thetext').value;
	
	jt = jt.replace(/ /g, "+");
	document.getElementById('nocareer').innerHTML='';

	
	//$("#countdiv").load("/careerladder/jobcount22.php?jobtitle="+jt, function() {

	//alert(document.getElementById('category1').value+' ' +document.getElementById('category2').value);

$("#typicaleducationth").click();
	
	if ($('.seventeen').hasClass('seventeen')==true) {
	
		document.getElementById('nocareer').innerHTML='We were unable to find a suitable career match for the job you entered so the complete list of healthcare careers for the selected category and education level is presented.<br/><br/>';
		$('#nocareer').css('color', '#A71E29');
		$('#nocareer').css('font-weight', 'bold');
		$('#nocareer').css('margin-top', '15px');	
	}
	else { 
		
			document.getElementById('nocareer').innerHTML='';

	}
	

//});



	
}

function onloadtable() {
	$('#loading').removeClass('off');
	
	$("#thetable").load("/careerladder/table.php?zip=<?php echo $vars['zip']; ?>&usersession=<?php echo $cma->usersession; ?>&type=lab&ed=10", function() {
 $('#loading').addClass('off');
 

});
}

function checkenter(event,inputString) {
			var keycode;
			if (window.event) keycode = window.event.keyCode;
						
			if (event.keyCode == 13) 
				thedefault(inputString);

}

</script>



<div id="test2" style="display:none;"></div>
<!-- span class="vcn-gs-heading">
Enter Your Experiences & Preferences
</span-->
<br/>
<!--<script>onloadtable();</script>-->


<div id="thequestions" style="float:left;">
Search for a career using one, two, or all three of these options.

<p style="margin-top:-2px; color:#A71E28">[Hint:  continue to change the various options to see different results]</p>

<!--  u onclick="gettable();">Jobs That You Like</u-->


Name a job you had that you enjoyed doing.<br/>
<div style="position:absolute; height: 40px;">
<div style="position:relative; float: left;">
<label for="thetext">
<input style="height:20px; width:388px;" type="text" name="job" id="thetext" onkeyup="checkenter(event,this.value);" onclick="document.getElementById('snapshot').innerHTML='<span class=\'vcn-gs-heading-black\' style=\'margin-left:-5px;\'>Career Snapshot</span>';" />
</label>
</div>
<div style="position:relative; float: left; margin-top:-3px; margin-left:3px;">

<div style="margin-top:-39px; margin-left:43px;">

</div>		
</div>	
</div>
<br/><br/>

Healthcare Category <br/>
<label><select style="width:392px;" name="category1" id="category1" class="wide">
					<option   value="all2">All</option>
					<option value="mdn">Medical, Dental & Nursing</option>
					<option value="ctp">Counseling, Therapy & Pharmacy</option>
					<option value="vsh">Vision, Speech/Hearing & Diet</option>
					<option value="lab">Lab Work & Imaging</option>
					<option value="ofc">Office & Research Support</option>
</select><br /><br/></label>

<?php 
$includes = drupal_get_path('module','vcn').'/includes';

require_once($includes . '/vcn_common.inc');

$catlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','category','list');


?>
Education Required for Job<br/>
<label><select style="width:392px;" name="category2" id="category2"  class="wide">
					<option value="all3">All</option>
					<?php $catcount=-1; foreach ($catlist->category as $k=>$v): $catcount++; ?>
					<option value="<?php echo $catlist->category[$catcount]->educationcategoryid; ?>"><?php echo $catlist->category[$catcount]->educationcategoryname; ?></option>
					<?php endforeach; ?>					

</select></label>
<p style ="margin-top:3px;"><i>Search results include careers at this level and lower <font color = "#A71E28">education</font> levels.</i></p>

<a href="javascript:void(0);" onclick="gettable(document.getElementById('thetext').value,'1');">
<input type="image" src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/getting_started/images/go.png"  style="margin-top:3px;" alt="Go" title="Go" /></a>

<div id="nocareer"><br/></div>
<strong class="cg_highlight" id="greentext"></strong>
<br/>
<div id="thetable" style="position:relative; float: left; width: 116%; margin-left:-33px;"></div>
<div id="brdiv"></div>

</div>
<iframe name="loadhere" src="" style="height: 0px; width: 0px; border: 0px;"></iframe>

<div id="countdiv" style="display:none;"></div>

<?php
session_start();
// store session data
$_SESSION['url']='getting-started/step-two/2';
?>
