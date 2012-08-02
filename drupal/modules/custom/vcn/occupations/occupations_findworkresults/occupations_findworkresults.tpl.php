<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
function nothing() {
var t =4;

}

function bold(id) {

		var fifty=["one","two","three","four","five","six","seven","eight","nine","ten","eleven","twelve","thirteen","fourteen","fifteen","sixteen","seventeen","eightteen","nineteen","twenty",
		"twentyone","twentytwo","twentythree","twentyfour","twentyfive","twentysix","twentyseven","twentyeight","twentynine","thirty","thirtyone","thirtytwo","thirtythree","thiryfour","thirtyfive",
		"thirtysix","thirtyseven","thirtyeight","thirtynine","fourty","fourtyone","fourtytwo","fourtythree","fourtyfour","fourtyfive","fourtysix","fourtyseven","fourtyeight","fourtynine","fifty","fiftyone"];

		var key=0;
		if (document.getElementById('pagedisplay'))
			var pageinfo = document.getElementById('pagedisplay').value;
		else
			return;
		var pieces=pageinfo.split("/");
		var prevpage=parseInt(pieces[0],10)-1;
		var nextpage=parseInt(pieces[0],10)+1;
		var lastpage=parseInt(pieces[1]);
		var pagesession = parseInt(pieces[0]);
		if (!lastpage && !document.getElementById('two'))
			lastpage=1;
		//alert(id);
		/*
		To store the page value in the seesion variable "mykey" so that it can be used further
		*/
		var persistedval = '';
		if (window.sessionStorage){
			sessionStorage.setItem("mykey", pagesession) //store data using setItem()
			persistedval=sessionStorage.getItem("mykey") //returns "Some Value"
		}

		for (i=0; i<=lastpage; i++) {
			if(fifty[i]==id || id==i) {
				key=i+1;
				break;
			}
		}

		var key2 = key;
		if (key2<1)
			key2 = nextpage;
		if (!key2)
			key2=1;
		var lower = key2 - (key2%10);
		var higher = key2 + (10-(key2%10));				//alert(lower+ ' '+key2+ ' '+higher);

		if (lower==key2 || (prevpage%10==9 && id=='prev') || (prevpage%10==0 && id=='prev')) {
			lower-=10;
			higher-=10;
		}

		for (i=1; i<=50; i++)
			$('#'+fifty[i-1]).css("color","#A61E28");

		if (id=='prev')
			$('#'+fifty[prevpage-1]).css("color","#000000");
		else
			$('#'+fifty[key2-1]).css("color","#000000");


		//alert(id + ' '+key2+ ' '+lastpage);
		if (id=='one' || (id=='prev' && prevpage<=1))
			document.getElementById('prev').style.display = 'none';
		else
			document.getElementById('prev').style.display = 'block';

		if (key2>10)
			document.getElementById('one').style.display = 'none';
		else
			document.getElementById('one').style.display = 'block';

		if (id=='prev' && prevpage<=10)
			document.getElementById('one').style.display = 'block';


		if (key2==lastpage && id!='prev')
			document.getElementById('next').style.display = 'none';
		else
			document.getElementById('next').style.display = 'block';

		for (i=1; i<=50; i++) {

			if (document.getElementById(fifty[i])) {
				if (i<lower || i>=higher)
					document.getElementById(fifty[i]).style.display = 'none';
				else
					document.getElementById(fifty[i]).style.display = 'block';

			}


		}





}

function getpages() {

var pages = document.getElementById('pagedisplay').value;

return pages;

}

function pvalidation(which, issave) {
		if (!issave || issave=='undefined')
			issave='';
			

					

        var zipvalueinoccupationdetail = document.getElementById('zipcode').value;
            $('#zipod').load('/careerladder/zipvalidation.php?zipcode='+zipvalueinoccupationdetail, function() {
                  var zval = document.getElementById("zipod").innerHTML;
				 /* 
				if (which==2 && !document.getElementById('onetcode').value) {
					alert('Valid keyword required.');
					return;
				}	
				*/		

			
                  if(zval == 'true' || zipvalueinoccupationdetail == '' || zipvalueinoccupationdetail == 'Zip code'){
							var theonet = document.getElementById('selectacareer').value; 
							var occtitle = document.getElementById('jobtitle').value;
							
							if (which==1 && !theonet) {
								alert('Please select a career.');
								return;
							}
							
							if (which==2 && document.getElementById('jobtitle').value.length<3) {
								alert('Please enter a keyword.');
								$("#jobtitle").addClass("redborder");
								setTimeout("document.getElementById('jobtitle').focus()", 1000);
								return;
							}								

							var onetcode2 = document.getElementById('onetcode').value;
							
							for (var l in laytitles)
								if (l.toLowerCase()==document.getElementById('jobtitle').value.toLowerCase())
									onetcode2=laytitles[l];		
									
							if (which==1)
								var thepath = '<?php echo base_path(); ?>findworkresults?onetcode='+$('#selectacareer option:selected').val()+'&onetcode2='+$('#selectacareer option:selected').val()+issave;
							else
								var thepath = '<?php echo base_path(); ?>findworkresults?jobtitle2='+occtitle+'&onetcode2='+onetcode2+issave;
							document.searchform.action = thepath;
							document.searchform.submit();
                      }
					else
                          {
						$("#zipcode").addClass("redborder");
						alert('Please enter a valid US ZIP Code.');
						document.getElementById('zipcode').focus();
                        return false;
                          }					  
            });




}



</script>
<?php

function convertdate($date) {

$pieces = explode(' ',$date);
$newdate = $pieces[0];

$pieces = explode('-', $newdate);
$newdate = $pieces[1]."/".$pieces[2]."/".$pieces[0];

return $newdate;
}

//$occtitle = $_POST['jobtitle2'];

if (!$occtitle)
$occtitle = $_GET['jobtitle2'];

//if ($occtitle=="undefined")
//$occtitle = $_POST['jobtitle'];

  //echo "post = ".$_POST['zipcode']."<br/>";
  //echo "session = ".$_SESSION['zipcode']."<br/>";
  //echo "frompage = ".$_POST['frompage']."<br/>";

if (preg_match("/^[0-9]{5}$/",$_SESSION['zipcode']))
	$zipcode = $_SESSION['zipcode'];

if (preg_match("/^[0-9]{5}$/",$_POST['zipcode']))
	$zipcode = $_POST['zipcode'];

if (!$zipcode)
$zipcode = $_GET['zipcode'];

if ($zipcode=="00000")
	$zipcode="";

//if(!isset($_SESSION))


	if (($_POST['frompage']=="true" && !preg_match("/^[0-9]{5}$/",$_POST['zipcode'])))
		$zipcode="";

session_start();
$_SESSION['zipcode']=$zipcode;
$_SESSION['firsttime']="no";

  $jobpagemin = 1;
  $jobpagemax = 500;

   $onetcode = $_GET["onetcode"];
 $distance = $_POST["distance"];

if (!$distance)
 $distance = $_GET["distance"];

if (!$distance)
$distance = 100;


if (!$onetcode) { $onetcode=$_POST['onetcode']; }


  // DOMElement->getElementsByTagName() -- Gets elements by tagname
  // nodeValue : The value of this node, depending on its type.
  // Load XML File. You can use loadXML if you wish to load XML data from a string

	//if (!ereg('[^A-Za-z]', $occtitle))
		
		
	/////////////////------------////////////////////////////	
		
		
		
				// get all the options and titles and pass them to jscript
		if (!$rest)
		{
			$cp = dirname(dirname(drupal_get_path('module','occupations_similar')));
			require_once($cp . '/vcn.rest.inc');
	 		$rest = new vcnRest;

		 // standard filters
		 	$rest->setSecret('');
		    $rest->setBaseurl(getBase());
		  // $rest->setBaseurl('http://localhost/rest/public/');
		}

		// clear the request

		$rest->setService('occupationsvc');
	 	$rest->setModule('onetlaytitles');
	 	$rest->setAction('get');
		$rest->setMethod('post');
		$rest->setRequestKey('apikey','apikey');
	 	$rest->setRequestKey('format','xml');
	 	$rest->setAction('count');
	 	$result =  new SimpleXMLElement( $rest->call());
        $laytitles_count = (string) $result->data->count;


		// get the list
	    $rest->setAction('list');
 	    $rest->setRequestKey('order','laytitle');
 	 	$rest->setRequestKey('limit',$laytitles_count);
	  	$result = new SimpleXMLElement( $rest->call());
	  	$ldata = $result->data->onetlaytitle;

    	$laytitles = array();
	  	foreach ($ldata AS $laytitle)
	  	{
  	  	 	 $title    = (string) $laytitle->laytitle;
	  	 	 $onetcode = (string) $laytitle->newonetcode;
	   		 $laytitles[$title] = $onetcode;
 	  	}
		

		//--//
			
				$occlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','occupation','list',false,false);
			
			$ok=-1;
			//$laytitles2 = array();
			foreach($occlist->occupation as $ov) {
				$ok++;
				 $title    = (string) $occlist->occupation[$ok]->displaytitle;
				 //$o = (string) $occlist->occupation[$ok]->onetxwalk->onetcodeold;
				 $onew0 = (string) $occlist->occupation[$ok]->onetcode;
				 //$laytitles2[$title] = $o;	
				 
				// if ($onetcode==$o)
				//	$occtitle=$title;
					
				if ($onew0==$_GET['onetcode'] || (stristr($_GET['jobtitle2'],$title) && strlen($_GET['jobtitle2'])==strlen($title))) {
				//	$realtitle=$title;
					$_GET['onetcode2']=$onew0;
				}
			}		

			//echo 'it is '.$_GET['onetcode2'];
	//$occlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','occupation','list',false,false);

	$ok=-1;
	$laytitlesdisplay = array();
	foreach($occlist->occupation as $ov) {
		$ok++;
		 $title    = (string) $occlist->occupation[$ok]->displaytitle;
		 $onetcode = (string) $occlist->occupation[$ok]->onetcode;
		 $laytitlesdisplay[$title] = $onetcode;	
		 
		 $laytitles[$title] = (string) $occlist->occupation[$ok]->onetcode;
	}  
	ksort($laytitlesdisplay); 
			
	//////////////////////------------////////////////////////////////////////	

		$laystringar=array();
		
		foreach ($laytitles as $key=>$value) {
			if ($value==$_GET['onetcode2']) {
				$tkey=$key;
				$tkey=str_replace('or','',$tkey); 
				$tkey=str_replace('and','',$tkey); 
				$tkey=str_replace('OR','',$tkey); 
				$tkey=str_replace('AND','',$tkey); 
				$tkey=str_replace('not','',$tkey); 
				$tkey=str_replace('NOT','',$tkey); 				
				
				$laystringar[]=$tkey;
			}
		}
		
		foreach ($laystringar as $k=>$v) {
			$laystringx=explode(' ',$laystringar[$k]);
			$laystring.='';
			foreach ($laystringx as $k2=>$v2) {
				if (strlen($v2)>1)
					$laystring.='title:'.$v2.' ';
			}
			
			if ($k<=count($laystringar)-2)
				$laystring.=' or ';
		}
		
	
		$occtitletemp=str_replace('"','\"',$occtitle); 
		
		$occtitletempx=explode(' ',$occtitletemp);
		
		$occtitletemp='';
		
		$evenodd=0;
		foreach($occtitletempx as $k=>$v) {
			
			if (strstr($v,'\"'))
				$evenodd++;
		
			if ($v!='and' && $v!='or' && $v!='not' && ($evenodd<=1) )				
				$occtitletemp.="title:".$v." ";
			else
				$occtitletemp.=" ".$v." ";
		
		
			if ($evenodd==1)
				$evenodd=1.5;
				
			if ($evenodd>=2)
				$evenodd=0;
		}
		
		//echo '=> '.$occtitletemp;
		
		$laystring=str_replace('(','',$laystring); 
		$laystring=str_replace(')','',$laystring); 
		$laystring=str_replace("'","",$laystring); 
		
		$occtitletemp=str_replace('\"','"',$occtitle); 

		if (strlen($laystring)>2 && strlen($_GET['onetcode2'])==10)
			$jurl = $GLOBALS['hvcp_config_dea_web_service_url'] . '?kw='.$laystring.'&zc1='.$zipcode.'&rd1='.$distance.'&rs='.$jobpagemin.'&re='.$jobpagemax.'&cn=100&key=' . $GLOBALS['hvcp_config_dea_web_service_key'];
		else 
			$jurl = $GLOBALS['hvcp_config_dea_web_service_url'] . '?kw=title:'.$occtitletemp.'&zc1='.$zipcode.'&rd1='.$distance.'&rs='.$jobpagemin.'&re='.$jobpagemax.'&cn=100&key=' . $GLOBALS['hvcp_config_dea_web_service_key'];
	
		

  $objDOM = new DOMDocument();
  if (!$objDOM->load($jurl)) {
for ($j=0; $j<3; $j++) {
sleep(1);
if ($objDOM->load($jurl))
break;



}

}


  $note = $objDOM->getElementsByTagName("job");

  $jobnos = $objDOM->getElementsByTagName("endrow");
  $recordcount  = $jobnos->item(0)->nodeValue;

  
  
  // for each note tag, parse the document and get values for
  // tasks and details tag.


//$vars is the array to pass into the ajax url to save the job search criteria   
	$cma = vcnCma::getInstance();
	$vars['user_id']=$cma->userid;


	if ($zipcode) {
	$vars['zip']=$zipcode;
	} else {
	$vars['zip']="null";
	}

	if ($distance) {
	$vars['distance']=$distance;
	} else {
	$vars['distance']="null";
	}

	if ($_GET['onetcode2']) {
	$vars['onetcode']=$_GET['onetcode2'];
	} elseif ($_GET['onetcode']) {
	$vars['onetcode']=$_GET['onetcode'];
	} else {
	$vars['onetcode']="null";
	}

	if (strlen($_GET['jobtitle2'])) {
	$vars['keyword']=$_GET['jobtitle2'];
	} else {
	$vars['keyword']="null";	
	}

	$vars['active_yn']='y';

	$vars['date'] = date("m-d-y");


//print_r($vars);exit;

/* if (strlen($_GET['save']))
	$documentinfo = vcn_get_data ($errors, $vars, $valid, 'cmasvc', 'CmaUserJobScout', 'put', $limit=false, $offset=false); 
 */
 ?>

 <script type="text/javascript">
function jobcount() {

var user_id = '<?php echo $vars['user_id']; ?>';
var zip = '<?php echo $vars['zip']; ?>';
var distance = '<?php echo $vars['distance']; ?>';
var onetcode = '<?php echo $vars['onetcode']; ?>';
var keyword = '<?php echo $vars['keyword']; ?>';
var active_yn = '<?php echo $vars['active_yn']; ?>';
var date = '<?php echo $vars['date']; ?>';

var keyUrl = base_path+'cma/count/jobs';
    $.ajax({
      type: "POST",
      url: keyUrl,
      dataType: "html",
      success: function (data) {
		if(data < 5){
			var url = base_path+'cma/alldata/jobs/'+user_id+'/'+zip+'/'+distance+'/'+onetcode+'/'+keyword+'/'+active_yn+'/'+date;
			$.ajax({
			  type: "POST",
			  url: url,
			  dataType: "html",
			  success: function (data1) {	  
				alert(data1);
			},
				  error: function (xmlhttp) {
					alert(' 1 An error occured: ' + xmlhttp.status);
				  }
				});
		} else {
			alert('You already have 5 Job Scouts saved to your Career Management Account.  Please delete one before adding a new one.');
		}
      },
      error: function (xmlhttp) {
        alert('An error occured: ' + xmlhttp.status);
      }
    });
}
</script>
 
 
 <h3>Find Jobs - Results</h3>
 
 <?php 
global $user;
if($user->uid){

$image_mt = '-15px';

if (stristr($_SERVER['HTTP_USER_AGENT'],'Chrome') || stristr($_SERVER['HTTP_USER_AGENT'],'Safari'))
	$image_mt = '-29px';

?>
	<div  style ="margin-left: 689px; margin-right: 61px; margin-top: -36px; margin-bottom:25px;">
	Save this job criteria to my<br /> Career Management Account
	<a href="javascript:void(0);" onclick="jobcount();"><img style="float:right; margin-top: <?php echo $image_mt; ?>; margin-left: 3px;" border="0" src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/occupations/occupations_findworkresults/save.png" alt="save button"></a>
	<!--a href="javascript:void(0);" onclick="<?php /* if (strlen($_GET['onetcode'])) echo 'pvalidation(1,\'&save=true\');'; else echo 'pvalidation(2,\'&save=true\');'; */ ?> jobcount();"><img style="float:right; margin-top: -15px;" border="0" src="<?php /* echo base_path(); */ ?>/sites/all/modules/custom/vcn/occupations/occupations_findworkresults/save.png" alt="save button"></a-->
	</div>
<?php 
} //$user->uid
?>

<?php

$i=0;
foreach( $note as $value )
  { $i++; }

if (!$i) {
echo "<b>0</b> jobs found";

if (strlen($zipcode)==5)
	echo "";
	//echo " in <b>$zipcode</b> (within $distance miles)";

} else {
    if ($recordcount == 1) {
    	echo "<b>$recordcount</b> job found";
    } else {
    	echo "<b>$recordcount</b>";

		if ($recordcount==500)
			echo "<b>+</b>";
		
		echo " jobs found";
    }
	
	
    //if (strlen($zipcode)==5)
    //echo " in <b>$zipcode</b> (within $distance miles)";



}


echo " - The results provided through the VCN are limited to listings sourced through state and federal funded job banks. Accordingly, this may not be a complete list of job openings in your area.<br/><br/>";



	

//$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];	
?>





<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_findworkresults/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/chili-1.8b.js"></script>
<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/docs.js"></script>
<script type="text/javascript">


	$(function() {
		$("table")
			.tablesorter({widthFixed: true, widgets: ['zebra']})
			.tablesorterPager({container: $("#pager")});
	});

</script>

<form name="searchform" action="javascript:void(0);" id="form" method="post" onsubmit="javascript:void(0);">
			<div id="leftbluebox">
			<input id="jobtitle2" name="jobtitle2" type="hidden" value="" />



<div style="display: table;">
  <div style="display: table-row;">
    <div style="display: table-cell; padding-right:10px;">
	
		<b>ZIP Code:</b>
		
    </div>
    <div style="display: table-cell;">
		
		<label for="distance"><b>Distance:</b></label></strong>
		
    </div>
  </div>
  <div style="display: table-row;">
    <div style="display: table-cell;  padding-right:10px;">
	
		<label for="zipcode"><input id="zipcode" name="zipcode" type="text" value="<?php echo $zipcode; ?>" maxlength="5" style="width:100px;" onkeypress="return numericonly(event);" /></label>
		
    </div>
    <div style="display: table-cell;">

		<select id="distance" name="distance">
			<option <?php if ($distance==5) echo "selected"; ?> value="5">5 miles</option>
			<option <?php if ($distance==15) echo "selected"; ?> value="15">15 miles</option>
			<option <?php if ($distance==25) echo "selected"; ?> value="25">25 miles</option>
			<option <?php if ($distance==50) echo "selected"; ?> value="50">50 miles</option>
			<option <?php if ($distance==100) echo "selected"; ?> value="100">100 miles</option>
			<option <?php if ($distance==250) echo "selected"; ?> value="250">250 miles</option>
			<option <?php if ($distance==500) echo "selected"; ?> value="500">500 miles</option>
		</select>	

    </div>
  </div>
</div>

			
			
			
			

			</div>
			<div id="middlebluebox">
				<div>
				 <div style="display: table-row;">
					<div style="display: table-cell;">
					
						<b>Healthcare Careers:</b>
						
					</div>
					<div style="display: table-cell;">
					</div>
				</div>
				  <div style="display: table-row;">
					<div style="display: table-cell;">

						<label><select id="selectacareer" style="width:322px; position:absolute; height:20px;">
						<option value='' selected>Select a Career</option>
						<?php
							foreach ($laytitlesdisplay as $key=>$value)
							{
								$selected='';
								
								if ($value==$_GET['onetcode'] && $_GET['onetcode'])
									$selected='selected="selected"';
									
								echo '<option value="'.$value.'" '.$selected.'>'.$key.'</option>';
							}
						?>
						</select></label>

					</div>		
					<div style="display: table-cell;">
						<input id="Search" style="position:absolute; margin-top:-2px; <?php $mlx='margin-left:185px;'; if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome')) $mlx='margin-left:183px;'; echo $mlx; ?>" name="Search" type="image" src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/occupations/ocupations_search/search.png" alt="Search" title="Search" onclick="pvalidation(1);" />
						<input type="hidden" name="frompage" id="frompage" value="true" />
					</div>
				  </div>
				</div>			
			
			

			</div>
			
			<div id="rightbluebox">
			
			
			
			
			
				<div>
				 <div style="display: table-row;">
					<div style="display: table-cell;">
					
						<b>Job Title:</b>
						
					</div>
					<div style="display: table-cell;">
					</div>
				</div>
				  <div style="display: table-row;">
					<div style="display: table-cell;">

						
						<label for="jobtitle"><input id="jobtitle" name="jobtitle" autocomplete="off" onblur="$('#suggestions').fadeOut();" onkeypress="return alphaonly(event);" onkeyup="suggest(this.value);keyboard(event,this.value); " maxlength="60" style="position:absolute; width:168px;" type="text" value="<?php $_GET['jobtitle2']=str_replace('"','&quot;',$_GET['jobtitle2']);  if (strlen($_GET['onetcode'])<2) echo $_GET['jobtitle2']; ?>" /></label>&nbsp;
						<input id="keycount" name="keycount" type="hidden" value="-1" />
						<label for="onetcode"><input id="onetcode" name="onetcode" type="text" value="" style="width:3px; border:0px; color:#f2f2f2; background-color:#f2f2f2; display:none;" /></label>
						<input id="jobtitle2" name="jobtitle2" type="hidden" value="" />

	<?php if (stristr($_SERVER['HTTP_USER_AGENT'],'Chrome')) $mpx=7; else $mpx=5; ?>
						<input id="onetcodelist" name="onetcodelist" type="hidden" value="" />
						<div class="suggestionsBox noresize" id="suggestions" style="display: none; margin:<?php echo $mpx; ?>px 0; z-index:1;">
							<div class="suggestionList" id="suggestionsList">suggestion list</div>
						</div>						

					</div>		
					<div style="display: table-cell;">
					
						<input id="Search" name="Search" type="image" style="position:absolute; <?php if (!stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome')) echo 'margin-top:-15px;'; ?> <?php if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) $ml='margin-left:107px;'; else $ml='margin-left:118px;'; if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8')) $ml='margin-left:121px;'; echo $ml; ?>" src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/occupations/ocupations_search/search.png" alt="Search" title="Search" onclick="pvalidation(2); " />
						<input type="hidden" name="frompage" id="frompage" value="true" />
						
						
						<?php //onclick="checkonet(document.getElementById('jobtitle').value,document.getElementById('onetcode').value,2);" ?>
					</div>
				  </div>
				</div>			
						
					
			
			

			</div>			
</form>

<?php if (strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox/2')): ?>
<br/><br/><br/><br/><br/>
<?php endif; ?>

<?php if ($i): ?>

<table cellspacing="0" cellpadding="0" id="tablesorter-demo" class="tablesorter" style="<?php if (stristr($_SERVER['HTTP_USER_AGENT'], 'Firefox/7') || stristr($_SERVER['HTTP_USER_AGENT'], 'Firefox/8')) echo 'margin-top:20px;'; else echo 'margin-top:80px;'; ?>">
    <thead>
      <tr>
        <th width="600" style="border-bottom: 0px; vertical-align: middle;">
          Job Title
        </th>
		<th width="350" style="border-bottom: 0px; vertical-align: middle;">
          Company
        </th>
        <th width="200" style="border-bottom: 0px; vertical-align: middle;">
          Location
        </th>
        <th width="170" style="border-bottom: 0px; vertical-align: middle;">
          Date <br />Posted
		</th>
		<!--
        <th width="150" style="border-bottom: 0px; vertical-align: middle;" id="savejobth">
          Save Job
		</th>
		-->
      </tr>
    </thead>
	<tbody>

<?php
  foreach( $note as $value )
  {
    $titles = $value->getElementsByTagName("title");
    $title  = $titles->item(0)->nodeValue;

    $companies = $value->getElementsByTagName("company");
    $company  = $companies->item(0)->nodeValue;

    $locations = $value->getElementsByTagName("location");
    $location  = $locations->item(0)->nodeValue;

    $datesacquired = $value->getElementsByTagName("dateacquired");
    $dateacquired  = $datesacquired->item(0)->nodeValue;

    $urls = $value->getElementsByTagName("url");
    $url  = $urls->item(0)->nodeValue;
	
	
	if (strlen($title)<3 || strlen($company)<3 || strlen($location)<3)
		continue;
?>
<tr><td><a target='_blank' href='<?php echo $url; ?>'><strong><?php echo $title; ?></strong></a></td>
<td><?php echo $company; ?></td>
<td><?php echo $location; ?></td>
<td><?php echo convertdate($dateacquired); ?></td>
<!--
<td>
<center><img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/save.png" alt="Save this occupation" />
<img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/target.png" alt="Target Occupation" />
</center></td>
-->
</tr>

<?php
}
?>
</tbody>
</table>
<div id="pager" class="pager">
	<form>
		<input type="hidden" class="pagedisplay" id="pagedisplay" />
		<input type="hidden" class="pagesize" value="10">
	</form>





<?php



$fifty= array("one","two","three","four","five","six","seven","eight","nine","ten","eleven","twelve","thirteen","fourteen","fifteen","sixteen","seventeen","eightteen","nineteen","twenty",
		"twentyone","twentytwo","twentythree","twentyfour","twentyfive","twentysix","twentyseven","twentyeight","twentynine","thirty","thirtyone","thirtytwo","thirtythree","thiryfour","thirtyfive",
		"thirtysix","thirtyseven","thirtyeight","thirtynine","fourty","fourtyone","fourtytwo","fourtythree","fourtyfour","fourtyfive","fourtysix","fourtyseven","fourtyeight","fourtynine","fifty","fiftyone");


$total_pages = ceil($recordcount / 10);
		if ($recordcount>0) {
			for ($thispage=0; $thispage<=($total_pages+1); $thispage++) {
					if ($thispage==($total_pages+1)) {
						$pageicon="<img alt=\"Next\" src=\"".base_path() . drupal_get_path('module','occupations_grid') ."/redarrow.jpg\">";
						$gotopage=$page+1;
					} else {
						$pageicon=$thispage;
						$gotopage=$thispage;
					}

					$textnum = $fifty[$thispage-1];
					if ($thispage==0) {
						$textnum="prev";
						$pageicon="<img alt=\"Previous\" src=\"".base_path() . drupal_get_path('module','occupations_grid') ."/redarrow0.jpg\">";
					}
					if ($thispage==1) {
						$textnum="one";
						//echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					}



					if ($thispage==$total_pages+1)
						$textnum="next";

					if ($thispage==0)
						echo '<span style="margin-top: 6px; float:left;">Page </span>';

					echo '<span style="float:left;" class = "'.$textnum.'" onclick="bold(\''.$textnum.'\');"';

					if ($thispage==0)
						echo "style=\"margin-top:-5px; margin-left:-5px;\"";

					echo '><a id = "'.$textnum.'" href="javascript:void(0)" style="text-decoration: none;';

					if ($thispage==0)
						echo ' display:none;';

					echo '">'.$pageicon.'</a></span>';




			}
		}


	?>

 </div>

                     <script type="text/javascript" language="javascript">
					persistedval=sessionStorage.getItem("mykey") //returns "Some Value"
					//alert(persistedval);
					var tem_id="";
					if (persistedval==1)
						tem_id="one";
					if (persistedval==2)
						tem_id="two";
					if (persistedval==3)
						tem_id="three";
					if (persistedval==4)
						tem_id="four";
					if (persistedval==5)
						tem_id="five";
					if (persistedval==6)
						tem_id="six";
					if (persistedval==7)
						tem_id="seven";
					if (persistedval==8)
						tem_id="eight";
					if (persistedval==9)
						tem_id="nine";
					if (persistedval>=10)
						tem_id="ten";

						//if(tem_id!="")
							//bold(tem_id);
						//else
							bold('one');
                    </script>
					<script>$(document).ready(function() {
								var theonet='<?php echo $_GET["onetcode"]; ?>';
								
								if (theonet)
									$('#selectacareer').val(theonet);
									
								$("#savejobth").removeClass("header");
							});

								function numericonly(evt) {

									var key = (evt.which) ? evt.which : event.keyCode;
									/*
									if (key==13) {
										var thepath = '<?php echo base_path(); ?>findworkresults?jobtitle2=<?php echo $occtitle; ?>';
										document.searchform.action = thepath;
										document.searchform.submit();
									}
									*/
									if (key!=45 && key > 31 && (key < 48 || key > 57))
										return false;

									return true;

									//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
								}


					</script>
<?php endif; ?>
<div style="display: none;" id="zipod">

</div>
<script>
var laytitles = <?php echo json_encode($laytitles); ?>;

		function suggest(inputString){
			document.getElementById('onetcode').value='';
		    inputString = inputString.toLowerCase();
		    //$('#onetcode').val('');
		    var len = inputString.length;

		 	if(len == 0)
 	 	 	{
 	 			$('#suggestions').fadeOut();
 	 	 	}
 	 	 	else
 	 	 	{
 	 	 	  	var string = '';
 	 	 	    var count  = 0;
				var index = '';
				var index2 = '';
 	 	 	  	var newl = '';
				var i = 0;
				var memcount = 9;

				var fwcount = 0;
				
				for (var l in laytitles) {

					var firstwordlengtharr = l.toLowerCase().split(" ");
					if (firstwordlengtharr[0]==inputString)
						fwcount++;
				}


				for (var l in laytitles) {
					var firstwordlengtharr = l.toLowerCase().split(" ");
					if (l.toLowerCase()==inputString+'s' || firstwordlengtharr[0]==inputString) {
						newl = l.substr(0,(index2)) + '<strong style="color: #f16b4e;">' +l.substr((index2),inputString.length) + '</strong>' + l.substr((index2+inputString.length));
						if (count<9) {
							l=l.replace("'","`");
							string = string + '<li id="li'+count+'" onClick="setonet(\'' + laytitles[l] + '\'); fill(\'' + l + '\'); ">' + newl +'</li>';
							count++;
						}

							if (fwcount==1) {
								count=10;
								//alert(l.toLowerCase());
							}

					}
				}

				for (var l in laytitles) {
					if (l.toLowerCase()==inputString+'s') {
						l=l.replace("'","`");
						newl = l.substr(0,(index2)) + '<strong style="color: #f16b4e;">' + l.substr((index2),inputString.length) + '</strong>' + l.substr((index2+inputString.length));
						string = string + '<li id="li'+count+'" onClick="setonet(\'' + laytitles[l] + '\'); fill(\'' + l + '\'); ">' + newl +'</li>';
						count++;
					}


				}

				var similar=0;

				for (var l2 in laytitles) {
					if (l2.toLowerCase().indexOf(inputString.toLowerCase())>0) {
						similar=-100;
					}
				}

				for (var l in laytitles) { 
					index2 = l.toLowerCase().search(inputString);


					var firstwordlengtharr = l.toLowerCase().split(" ");
					firstwordlength = firstwordlengtharr[0].length;

					var firstword = firstwordlengtharr[0];
					var secondword = firstwordlengtharr[1];

					var isw = inputString.toLowerCase().split(" ");
					var secondwordis = isw[1];

						
					if (similar>=0) {
						similar=0;
						var similarletter=0;

						for (var scount=0; scount<=firstwordlength; scount++) {
							if (inputString[scount]==l.toLowerCase()[scount])
								similarletter++;

							if (firstword.toLowerCase().indexOf(inputString.toLowerCase()[scount])>0)
								similar=similar+1;


						}

						var fsimilar = similar;
						if (similar/firstwordlength>.5)
							similar=1;
						else
							similar=0;

						if (inputString.toLowerCase()[0]!=l.toLowerCase()[0] && similarletter<4)
							similar=0;

						if (similar<0)
							similar=0;
						


					}
					if (l.toLowerCase()==inputString+'s')
						continue;



					if (((index2 > -1 ) && !l.substr(0,(index2))) || similar>0)	 {


						if (index2 > -1 ) {
							newl = l.substr(0,(index2)) + '<strong style="color: #f16b4e;">' + l.substr((index2),inputString.length) + '</strong>' + l.substr((index2+inputString.length));
						}
						else if (similar>0) {
							if (!secondword)
								secondword=' ';

							if (secondwordis && (secondword.indexOf(secondwordis)>0 || secondword[0]==secondwordis[0])) {
								var secondpart = '';
								for (var lc=0; lc<isw.length; lc++) {
									if (lc>0) {
										if (lc==1) {
											secondpart+=isw[lc];
										}
										else {
											var secondpartl = l.substr(index3,(secondpart.length));
											secondpartl = inputString.toLowerCase().split(" ");

											if (l.toLowerCase().search(isw[lc])>-1)
												secondpart+=' '+isw[lc];
										}
									}
								}

								var index3 = l.toLowerCase().search(secondwordis);
								if (index3>0)
									newl = l.substr(index,index3) + '<strong style="color: #f16b4e;">' + l.substr(index3,(secondpart.length)) + '</strong>' + l.substr(index3 +secondpart.length);
								else
									newl=l;
							} else if (!secondwordis) {
								//newl =  similarletter + ' '+fsimilar + ' '+firstwordlength+ ' '+l;
								newl=l;
							}

						}
						if (string.indexOf(newl)<=0 && newl.length>1  && count<=9) {
							l=l.replace("'","`");
							string = string + '<li id="li'+count+'" onClick="setonet(\'' + laytitles[l] + '\'); fill(\'' + l + '\'); ">' + newl +'</li>';
							count++;
						}

					}

					if (count > 9 )
					   break;


				}



 	 	 	  	for (var l in laytitles)
 	 	 	    {
				index = l.toLowerCase().search(' '+inputString);
				index2 = l.toLowerCase().search(inputString);

				if (l.toLowerCase()==inputString+'s' || ((index2 > -1 ) && !l.substr(0,(index2))))
					continue;

 	 	 		if (((index > -1) || (index2 > -1 ))	  && count<=9 )
  	  	 	 	   {
						if (index > -1)
							newl = l.substr(0,(index+1)) + '<strong style="color: #f16b4e;">' + l.substr((index+1),inputString.length) + '</strong>' + l.substr((index+1+inputString.length));
						else if (index2 > -1 )
							newl = l.substr(0,(index2)) + '<strong style="color: #f16b4e;">' + l.substr((index2),inputString.length) + '</strong>' + l.substr((index2+inputString.length));
						l=l.replace("'","`");
  	  	  	 	 		string = string + '<li id="li'+count+'" onClick="setonet(\'' + laytitles[l] + '\'); fill(\'' + l + '\'); ">' + newl +'</li>';
  	  	  	 	 		count++;

  	  	 	 	   }


  	  	 	 	   if (count > 9 )
  	 	 	 	   break;
 	 	 	    }

 	 	 	    if (string) { 
 	 	 	 	    string = '<ul>'+ string + '</ul>';
 	 	 	  		$('#suggestions').html(string);
 	  	 			$('#suggestions').fadeIn();
 	 	 	    }
 	 	 	    else
 	 	 	    {
 	 	 	    	$('#suggestions').fadeOut();
 	 	 	    }
 	 	 	}
  		}
		function suggestcodes(inputString) {
		    inputString = inputString.toLowerCase();
		    var len = inputString.length;

			var string = '';
			var count  = 0;
			var index = '';
			var index2 = '';
			var newl = '';
			var i = 0;
			for (var l in laytitles) {
				index = l.toLowerCase().search(' '+inputString);
				index2 = l.toLowerCase().search(inputString);
				if ((index > -1) || (index2 > -1 ))	{
						if (string.indexOf(laytitles[l])<0) {
							string = string + laytitles[l] + ',';
							count++;
						}

				}

				if (count > 80 )
				   break;
			}
			string = string.substr(0,string.length-1);
			if (!count) {
				string = 'null';
			}

			return string;
		}

		function fill(thisValue) {
			thisValue=thisValue.replace("`","'");
			$('#jobtitle').val(thisValue);
			setTimeout("$('#suggestions').fadeOut();", 500);
			if (document.getElementById('keycount').value>-1)
				checkKeycode();
			document.getElementById('keycount').value=-1;
			document.getElementById('jobtitle2').value = thisValue;
			document.searchform.jobtitle.focus();
 		}
		function setonet(thisValue) {
			$('#onetcode').val(thisValue);
		}
		function setonetkey(event,thisValue) {
			$('#onetcode').val(thisValue);
			//if (event.keyCode==13)
				alert(event.keyCode);
		}

		function getonet(thisValue) {
			$('#onetcode').val($('#suggestionsList').val());


			//document.searchform.action = "<?php echo base_path(); ?>careerdetails";
		}

		function pvalidate(zipvalueinoccupationdetail) {

		//var zipvalueinoccupationdetail = document.getElementById('zipcode').value;
/*
		$('#zipod').load('/careerladder/zipvalidation.php?zipcode='+zipvalueinoccupationdetail, function() {
                  var zval = document.getElementById("zipod").innerHTML;
                  if(zval == 'true'  || zipvalueinoccupationdetail == 'Zip code'){
					return 1;
                  }
              else
                          {

				$("#zipcode").addClass("redborder");
				alert('Please enter a valid US Zipcode');
				document.searchform.zipcode.focus();

                        return 0;
                          }
            });

*/
			if (zipvalueinoccupationdetail.length==5)
				return true;
			else
				return false;


		}

		function checkonet(thisValue,onetcode,which) {


			$("#zipcode").removeClass("redborder");
			$("#jobtitle").removeClass("redborder");


			var all='';
			var thisValue = thisValue.toLowerCase();
			var zipcode = document.getElementById('zipcode').value;
			for (var key in laytitles) {

				if (key.toLowerCase()==thisValue) {
					document.getElementById('onetcode').value = laytitles[key];
					//if ((document.getElementById('onetcode').value.indexOf('-')>0 && document.getElementById('onetcode').value.indexOf('.')>0 && (zipcode.length==5 || zipcode.length==10) )) {
						//document.searchform.action = "<?php echo base_path(); ?>findworkresults";

					//}


					/*
					if (zipcode.length!=5) {
						$("#zipcode").addClass("redborder");
						alert('Please enter a valid zipcode.');
						document.searchform.zipcode.focus();
					}
					*/
					//alert(key);
					//return false;
				}
			}


			if (document.getElementById('jobtitle').value.length<=3 && (zipcode.length>=1) && which==2) {
				if (!onetcode || document.getElementById('jobtitle').value.length<=3) {
					$("#jobtitle").addClass("redborder");
						alert('Please enter a keyword.');
						document.searchform.jobtitle.focus();
				}
				return false;
			}

			/*
			if ((!onetcode || document.getElementById('jobtitle').value.length>3)) {
				document.searchform.jobtitle.focus();

				var testrun=0;
				var jt = document.getElementById('jobtitle').value;

				if (document.getElementById('jobtitle').value.length>3 && zipcode.length==5 && jt!='acu' && jt!='acut' && jt!='acute')
					testrun=1;


				if (document.getElementById('jobtitle').value.length>3 && !onetcode && zipcode.length!=5 && jt!='acu' && jt!='acut' && jt!='acute')
					testrun=1;



				if (document.getElementById('jobtitle').value.length>3 && testrun==0) {
					//return false;
				}

			}
			if (document.getElementById('jobtitle').value.length<=3) {
				if (!onetcode || document.getElementById('jobtitle').value.length==3) {
					$("#jobtitle").addClass("redborder");
					alert('Please enter a keyword.');
					document.searchform.jobtitle.focus();
				}
				return false;
			}

			if ((!zipcode || (zipcode.length!=5)) && !onetcode) {
				$("#zipcode").addClass("redborder");
				alert('Please enter a valid zipcode.');
				document.searchform.zipcode.focus();
				return false;

			}
			*/

var zipvalueinoccupationdetail = document.getElementById('zipcode').value;
            $('#zipod').load('/careerladder/zipvalidation.php?zipcode='+zipvalueinoccupationdetail, function() {
                  var zval = document.getElementById("zipod").innerHTML;
                  if(zval == 'true' || zipvalueinoccupationdetail==''){

							if (which==1 && !document.getElementById('selectacareer').value) {
								alert('Please select a career.');
								return;
							}		
							/*
							if (which==2 && !document.getElementById('onetcode').value) {
								alert('Valid keyword required.');
								return;
							}									
							*/
							if (thisValue.length>3 || which==1 || zipcode=='' && document.getElementById('jobtitle').value.length>=3) {
								//document.getElementById('onetcode').value = '';
								//document.getElementById('onetcodelist').value = suggestcodes(thisValue);
								document.getElementById('onetcodelist').value='';
								//if (!(document.getElementById('onetcode').value.indexOf('-')>0 && document.getElementById('onetcode').value.indexOf('.')>0)) {

									//window.open ("<?php echo base_path(); ?>findworkresults?jobtitle2="+document.getElementById('jobtitle').value,"_self");
									
									var onetcode2 = document.getElementById('onetcode').value;
									
									for (var l in laytitles)
										if (l.toLowerCase()==document.getElementById('jobtitle').value.toLowerCase())
											onetcode2=laytitles[l];									
									
									
									if (document.getElementById('selectacareer').value && which==1)									
										document.searchform.action = "<?php echo base_path(); ?>findworkresults?onetcode="+document.getElementById('selectacareer').value;									
									else
										document.searchform.action = "<?php echo base_path(); ?>findworkresults?jobtitle2="+document.getElementById('jobtitle').value+"&onetcode2="+onetcode2;

									
									
									document.forms["searchform"].submit();
								//}


							} else { 
								if (document.getElementById('zipcode').value!='') {
									alert('Please enter a ZIP Code'); document.getElementById('zipcode').focus();
								}
								if (document.getElementById('jobtitle').value.length<3) {
									$("#jobtitle").addClass("redborder"); 
									alert('Please enter a keyword.');
									document.getElementById('jobtitle').focus();
								}
								return false; 
							}



                  }
              else
                          {
						$("#zipcode").addClass("redborder");
						alert('Please enter a valid US ZIP Code.');
						document.getElementById('zipcode').focus();
                        return false;
                          }
            });




		}

		function countsuggestions() {
			var count=0;
			for (var i=0; i<10; i++) {
				if (document.getElementById('li'+i))
					count++;
			}

			return count;

		}

		function keyboard(event,inputString) {

			if ((event.keyCode==38 || event.keyCode==40) && inputString) {
				if (event.keyCode==38 && document.getElementById('keycount').value>0) {
					document.getElementById('keycount').value--;
					document.getElementById('jobtitle2').value = suggestionslist(inputString,document.getElementById('keycount').value);
				}
				if (event.keyCode==40 && document.getElementById('keycount').value>=-1 && document.getElementById('keycount').value<=9) {
					var lastone = countsuggestions();


					document.getElementById('keycount').value++;

					if (document.getElementById('keycount').value>=lastone || document.getElementById('keycount').value>9)
						document.getElementById('keycount').value=0;

					if (document.getElementById('keycount').value<lastone-1)
						document.getElementById('jobtitle2').value = suggestionslist(inputString,document.getElementById('keycount').value);

				}

				document.getElementById('li'+document.getElementById('keycount').value).style.background = '#D5E2FF';
			}

			//document.onkeydown = checkKeycode
			//if (window.event.keyCode != 78 && window.event.keyCode != 40)
				//alert('enter');


			if (event.keyCode == 13) {
				if (suggestionslist(inputString,document.getElementById('keycount').value)) {
					document.getElementById('jobtitle').value = suggestionslist(inputString,document.getElementById('keycount').value);

				} else {
					document.getElementById('zipcode').focus();
					pvalidation(2);
					
				}
				
				document.getElementById('keycount').value=-1;
				$('#suggestions').fadeOut();
			}


		}

		function checkKeycode() {
			var keycode;
			if (window.event) keycode = window.event.keyCode;

			//if (keycode == 13 && suggestionslist(document.getElementById('jobtitle').value,document.getElementById('keycount').value)) {
			//alert (inputString+ ' '+keycount); return;
				document.getElementById('jobtitle').value = suggestionslist(document.getElementById('jobtitle').value,document.getElementById('keycount').value);
				document.getElementById('keycount').value=-1;
			//}
		}


		function suggestionslist(inputString,number) {
			var count=0;
			var string=new Array();
			var stringcodes=new Array();
			inputString = inputString.toLowerCase();
			for (var l in laytitles) {
				index = l.toLowerCase().search(' '+inputString);
				index2 = l.toLowerCase().search(inputString);
 	 	 		if ((index > -1) || (index2 > -1 )) {
						string[count] = l;
						stringcodes[count] = laytitles[l];
  	  	  	 	 		count++;
  	  	 	 	}
  	  	 	 	if (count > 9 ) {
					break;
				}
 	 	 	}

			if (count==10 && stringcodes[number]) {
				document.searchform.action = "javascript:void(0);";
				document.getElementById('onetcode').value = stringcodes[number];
			}

			var text = '';

			if (document.getElementById('li'+number)) {
				text = document.getElementById('li'+number).innerHTML;

				text = text.replace('<STRONG style="COLOR: #f16b4e">', '');
				text = text.replace('</STRONG>', '');

				text = text.replace('<strong style="color: #f16b4e;">', '');
				text = text.replace('</strong>', '');
				
				text = text.replace('<strong style="color: rgb(241, 107, 78);">', '');
				text = text.replace('</strong>', '');				
				
			}

			return text;


		}

		function setvalues() {
			$('#suggestions').fadeOut();
			//document.getElementById('jobtitle').value='';
			//document.getElementById('onetcode').value='';
			suggest(document.getElementById('jobtitle').value);
			document.getElementById('keycount').value='-1';
			document.searchform.action = "javascript:void(0);";
		}

		function numericonly(evt) {

			var key = (evt.which) ? evt.which : event.keyCode;

			if (key!=45 && key > 31 && (key < 48 || key > 57))
				return false;

			return true;

			//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
		}

		function alphaonly(event) {


				var key = (event.which) ? event.which : event.keyCode;

			if ((key < 65 ||  key > 122) && key!=8 && key!=32  && key!=39 && key!=46 && key!=9 && key!=222 && key!=34)
				return false;
			
			if (key==92)
				return false;
			
			return true;

			//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
		}


</script>