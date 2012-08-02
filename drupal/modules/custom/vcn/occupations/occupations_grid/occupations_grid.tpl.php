<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
/**
 * This section uses the phpsniff routine loaded in the onet_assessment module to detect the browser
 */
$timer =& new phpTimer();
$timer->start('client1');
$sniffer_settings = array('check_cookies'=>$GET_VARS['cc'],
                          'default_language'=>$GET_VARS['dl'],
                          'allow_masquerading'=>$GET_VARS['am']);
$client =& new phpSniff($GET_VARS['UA'],$sniffer_settings);
$timer->stop('client1');

if($debug==3) echo "client browser is ".$client->property('browser')."<br />";
if($debug==3) echo "client browser version is ".$client->property('version')."<br />";
/* end section*/

  //header( 'Cache-Control: private, max-age=10800, pre-check=10800' );  ?>

<style>
.fhc { float:left; padding:10px; margin-right:15px; height:25px;}
.fhc.gray { background:#999;}
#training-search-container {width:97%;}
		#suggestions { background-color: #FFFFFF; border: 1px solid #558BE3; color: #000; font-family: Arial,Helvetica,sans-serif;
		font-size: 11px; margin:0; padding: 0; position: absolute; min-width:200px; max-width: 300px; z-index:10; margin-left:67px; margin-top:-28px;
		}
		#suggestions ul {list-style:none; padding:0; margin-top:0; margin-bottom:0;}
		#suggestions ul li { padding:5px;}
		#suggestions ul li:hover { background:#D5E2FF; }
		

select {
	width: 242px; /* Or whatever width you want. */
}
select.expand {
	width: auto;
}

</style>

	<?php

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

		
	////////////////////////////////////////////////////////////////////////////////////////////////////
	  $use_appcache = true;
	  $cid = "grid-laytitle-count" ;
	  $cached_content = null;
	  
	  //print "OCCUPATIONS DETAIL: before call to rest data " . udate("H:i:s:u") . "<br />";
	  if ($use_appcache) {
		 $cached = cache_get($cid,'cache_content');
		 $ser_content = $cached->data;
		 if (!empty($ser_content)) {
			$cached_content = unserialize($ser_content);
			//print "using cached data for " . $cid . "<br />";
		 }
	  }
	  
	  if (empty($cached_content)) {
		 $restcontent = $rest->call();
		 if ($use_appcache) {
		   // save data to cache
		   $ser_content = serialize($restcontent);
		   cache_set($cid, $ser_content, 'cache_content', $CACHE_PERMANENT);
		   //print "setting cache for " . $cid . "<br />";
		}
	  } else {
		 $restcontent = $cached_content; 
	  }
	  //print "OCCUPATIONS DETAIL: after call to rest data " . udate("H:i:s:u") . "<br />";	
	////////////////////////////////////////////////////////////////////////////////////////////////////		
	
		$result =  new SimpleXMLElement($restcontent);
		
        $laytitles_count = (string) $result->data->count;


		// get the list
	    $rest->setAction('list');
 	    $rest->setRequestKey('order','laytitle');
 	 	$rest->setRequestKey('limit',$laytitles_count);
		
		
		
	////////////////////////////////////////////////////////////////////////////////////////////////////
	  $use_appcache = true;
	  $cid = "grid-laytitle-list-".$laytitles_count;
	  $cached_content = null;
	  
	  //print "OCCUPATIONS DETAIL: before call to rest data " . udate("H:i:s:u") . "<br />";
	  if ($use_appcache) {
		 $cached = cache_get($cid,'cache_content');
		 $ser_content = $cached->data;
		 if (!empty($ser_content)) {
			$cached_content = unserialize($ser_content);
			//print "using cached data for " . $cid . "<br />";
		 }
	  }
	  
	  if (empty($cached_content)) {
		 $restcontent = $rest->call();
		 if ($use_appcache) {
		   // save data to cache
		   $ser_content = serialize($restcontent);
		   cache_set($cid, $ser_content, 'cache_content', $CACHE_PERMANENT);
		   //print "setting cache for " . $cid . "<br />";
		}
	  } else {
		 $restcontent = $cached_content; 
	  }
	  //print "OCCUPATIONS DETAIL: after call to rest data " . udate("H:i:s:u") . "<br />";	
	////////////////////////////////////////////////////////////////////////////////////////////////////			

		
	  	$result = new SimpleXMLElement($restcontent);
	  	$ldata = $result->data->onetlaytitle;

    	$laytitles = array();
	  	foreach ($ldata AS $laytitle)
	  	{
  	  	 	 $title    = (string) $laytitle->laytitle;
	  	 	 $onetcode = (string) $laytitle->newonetcode;
	   		 $laytitles[$title] = $onetcode;
 	  	}

	?>

	<script language="javascript" type="text/javascript">
	 $(document).ready(function() {
		var whichwage='.wageradioa';
	 
		if (sessionStorage.getItem("thewage"))
			whichwage = sessionStorage.getItem("thewage");
		
		$(whichwage).click();
		
		 if ($.browser.msie) $('select.wide')
			.bind('focus mouseover', function() { $(this).addClass('expand').removeClass('clicked'); })
			.bind('click', function() { $(this).toggleClass('clicked');  })
			.bind('mouseout', function() { if (!$(this).hasClass('clicked')) { $(this).removeClass('expand'); }})
			.bind('blur', function() { $(this).removeClass('expand clicked'); });
			
			$('select.wide').change(function() { $(this).removeClass('expand');	});		
			
//document.getElementById('training').value=='/category/0' && document.getElementById('worktype').value=='worktypecode/0'
		//if ( document.getElementById('jobtitle').value!='' )
		//	$("table").tablesorter( { sortList: [] });
	
	});
	
		var laytitles = <?php echo json_encode($laytitles); ?>;
		function suggest(inputString){
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
				
				document.getElementById('onetcodelist').value='';

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
							string = string + '<li id="li'+count+'" onClick="setonet(\'' + laytitles[l] + '\'); fill(\'' + l + '\'); ">' + newl +'</li>';
							
							if (document.getElementById('onetcodelist').value.indexOf(laytitles[l])<0)
								document.getElementById('onetcodelist').value+=laytitles[l]+',';
							
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
						newl = l.substr(0,(index2)) + '<strong style="color: #f16b4e;">' + l.substr((index2),inputString.length) + '</strong>' + l.substr((index2+inputString.length));
						string = string + '<li id="li'+count+'" onClick="setonet(\'' + laytitles[l] + '\'); fill(\'' + l + '\'); ">' + newl +'</li>';
						
						if (document.getElementById('onetcodelist').value.indexOf(laytitles[l])<0)
							document.getElementById('onetcodelist').value+=laytitles[l]+',';						
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
						if (string.indexOf(newl)<=0 && newl.length>1 && count<=9) {
							string = string + '<li id="li'+count+'" onClick="setonet(\'' + laytitles[l] + '\'); fill(\'' + l + '\'); ">' + newl +'</li>';
							
							if (document.getElementById('onetcodelist').value.indexOf(laytitles[l])<0)
								document.getElementById('onetcodelist').value+=laytitles[l]+',';
								
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
  	  	  	 	 		string = string + '<li id="li'+count+'" onClick="setonet(\'' + laytitles[l] + '\'); fill(\'' + l + '\'); ">' + newl +'</li>';
						
						if (document.getElementById('onetcodelist').value.indexOf(laytitles[l])<0)
							document.getElementById('onetcodelist').value+=laytitles[l]+',';						
  	  	  	 	 		count++;

  	  	 	 	   }


  	  	 	 	   if (count > 9 )
  	 	 	 	   break;
 	 	 	    }

				document.getElementById('onetcodelist').value = document.getElementById('onetcodelist').value.substring(0, document.getElementById('onetcodelist').value.length-1);

				
 	 	 	    if (string) {
 	 	 	 	    string = '<ul>'+ string + '</ul>';
 	 	 	  		$('#suggestions').html(string);
 	  	 			//$('#suggestions').fadeIn();
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
			$('#jobtitle').val(thisValue);

			setTimeout("$('#suggestions').fadeOut();", 500);
			if (document.getElementById('keycount').value>-1)
				checkKeycode();
			document.getElementById('keycount').value=-1;
			document.traininglist.jobtitle.focus();
 		}
		function setonet(thisValue) {
			$('#onetcode').val(thisValue);
		}
		function setonetkey(event,thisValue) {
			$('#onetcode').val(thisValue);
			//if (event.keyCode==13)
				//alert(event.keyCode);
		}

		function getonet(thisValue) {
			$('#onetcode').val($('#suggestionsList').val());


			//document.searchform.action = "<?php echo base_path(); ?>careerdetails";
		}
		function checkonet(thisValue,onetcode) {
			var all='';
			var thisValue = thisValue.toLowerCase();
			for (var key in laytitles) {

				if (key.toLowerCase()==thisValue) {
					document.getElementById('onetcode').value = laytitles[key];
					if ((document.getElementById('onetcode').value.indexOf('-')>0 && document.getElementById('onetcode').value.indexOf('.')>0)) {
						//document.searchform.action = "<?php echo base_path(); ?>careerdetails";

					}

					//alert(key);
					return false;
				}
			}
			if (thisValue.length>0) {
				//document.getElementById('onetcode').value = '';
				document.getElementById('onetcodelist').value = suggestcodes(thisValue);
				var occ = document.getElementById('jobtitle').value;
				occ = occ.replace(" ", "+");

				//if (!(document.getElementById('onetcode').value.indexOf('-')>0 && document.getElementById('onetcode').value.indexOf('.')>0)) {
					//$("#loadhere").load("/careerladder/jobsearch.php?jobtitle="+occ, function() {

					if (document.getElementById('li0')) {
						var li0=''; var li1=''; var li2='';
					
						if (document.getElementById('li0'))
							var li0 = document.getElementById('li0').innerHTML.toLowerCase();
						
						if (document.getElementById('li1'))
							var li1 = document.getElementById('li1').innerHTML.toLowerCase();
						
						if (document.getElementById('li2'))
							var li2 = document.getElementById('li2').innerHTML.toLowerCase();
						
						//if (li0.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0) {
						if ( li0.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0 || li1.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0 || li2.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0  ) {

							 
							window.open("<?php echo base_path(); ?><?php echo base_path(); ?>careergrid<?php if ($origtitle) echo '?jobtitle='.$origtitle; ?>","_self");
							
							
							
						}
						else {
									alert('No occupations found.');
									return false;
						}						
								
					}
					else {
								alert('No occupations found.');
								return false;
					}	
					//});

				//}



			} else {
				alert('Search is blank.');
				return false;
			}

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
					locationchange();
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
				//document.searchform.action = "javascript:return false;";
				document.getElementById('onetcode').value = stringcodes[number];
			}

			var text = '';

			if (document.getElementById('li'+number)) {
				text = document.getElementById('li'+number).innerHTML;

				text = text.replace('<STRONG style="COLOR: #f16b4e">', '');
				text = text.replace('</STRONG>', '');

				text = text.replace('<strong style="color: #f16b4e;">', '');
				text = text.replace('</strong>', '');
			}

			return text;
			//return string[number];

		}

		function setvalues() {
			$('#suggestions').fadeOut();
			//document.getElementById('jobtitle').value='';
			document.getElementById('onetcode').value='';
			document.getElementById('keycount').value='-1';
			//document.searchform.action = "javascript:return false;";
		}

		function alphaonly(event) {


				var key = (event.which) ? event.which : event.keyCode;

			if ((key < 65 ||  key > 122) && key!=8 && key!=32 && key!=37 && key!=39 && key!=46 && key!=9)
				return false;

			return true;

			//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
		}
		function numericonly(evt) {

			var key = (evt.which) ? evt.which : event.keyCode;

			if (key!=45 && key > 31 && (key < 48 || key > 57))
				return false;

			return true;

			//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
		}

 	</script>



<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
	function getVideoLink($onetcode,$oldonetcode) {

	//if ($onetcode!=$oldonetcode)
	//$onetcode=$oldonetcode;

	$dir = base_path() . drupal_get_path('module','occupations_detail') . "/videos/";
	$path = "..".$dir.$onetcode.".flv";

	if (file_exists($path))
	return $dir.$onetcode.".flv";
	else
	return '';

	}

  function getAnnualSalary($wageocc)
  {
    foreach ($wageocc AS $wage)
    {
      if ( $wage->ratetype == 4) { return "$".number_format(intval($wage->pct25), 0, '.', ',')." - $".number_format(intval($wage->pct75), 0, '.', ','); }
    }
    return false;
  }

  function getHourlyWage($wageocc)
  {
    foreach ($wageocc AS $wage)
    {
      if ( $wage->ratetype == 1) { return "$".number_format(floatval($wage->pct25), 0, '.', ',')." - $".number_format(floatval($wage->pct75), 0, '.', ','); }
    }
    return false;
  }

function getTrainingGrid($training) {

	$pieces = explode(" - ", $training);
	$training = $pieces[0];

	$pieces = explode(" (", $training);
	$training = $pieces[0];

	return $training;

}



  static $occupation_count = 0;
  $limit = 8;

  $cp = dirname(dirname(drupal_get_path('module','occupations_detail')));

  require_once($cp . '/vcn.rest.inc');

  $rest = new vcnRest;

  $rest->setSecret('');
  $rest->setBaseurl(getBase());
  $rest->setService('occupationsvc');
  $rest->setModule('occupation');

  $categoryparam = get_clean_url_paired_parameter('education_category_id_less');

   $searchcodes = $_GET['jobtitle'];

   if ($_POST['jobtitle'])
	$searchcodes=$_POST['jobtitle'];

$thetitle = $searchcodes;

//echo "TITLE=".$_POST['jobtitle'].$_GET['jobtitle'];
 if ($searchcodes) {
	$origtitle = $searchcodes;
	$occlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','occupation','list-short');
	$searchcodes_list = vcn_onetcodes_match($thetitle);
	
	$searchcodes='';
	foreach ($searchcodes_list as $v) {
		$searchcodes.=$v.',';
	}
	
	$searchcodes = substr($searchcodes, 0, -1);
	
	if (strstr($searchcodes, '9999'))
		$searchcodes="blank";
}


 $onetpieces = explode(",",$searchcodes);


  $getpieces = explode("/", $_POST['training']);
  if ($getpieces[2]>0)
	$categoryparam = $getpieces[2];

  if ($categoryparam)
	$rest->setRequestKey('education_category_id_less',$categoryparam);


  $wtcodeparam = get_clean_url_paired_parameter('worktypecode');
  $wtscoreparam = get_clean_url_paired_parameter('score');

/*
   if (($_POST['worktype']=="/worktypecode/mdn/score/high"))
    $wtcodeparam=8;

   if (($_POST['worktype']=="/worktypecode/ctp/score/high"))
    $wtcodeparam=14;

   if (($_POST['worktype']=="/worktypecode/vsh/score/high"))
	$wtcodeparam=13;

   if (($_POST['worktype']=="/worktypecode/lab/score/high"))
    $wtcodeparam=1;

   if (($_POST['worktype']=="/worktypecode/ofc/score/high"))
    $wtcodeparam=6;
*/

  $rest->setRequestKey('laytitles','on');

  $wtpieces = explode("/", $_POST['worktype']);

  if (isset($wtpieces[2]) && isset($wtpieces[4])) {
	$wtcodeparam = $wtpieces[2];
	$wtscoreparam = $wtpieces[4];
  }

  if ($wtcodeparam)
	$rest->setRequestKey('worktypecode',$wtcodeparam);

  if ($wtscoreparam)
	$rest->setRequestKey('score',$wtscoreparam);

  $groupidparam = get_clean_url_paired_parameter('group_id');
 // if (!$groupidparam)
	//$groupidparam = $_POST['group_id'];

  if ($groupidparam)
	$rest->setRequestKey('group_id',$groupidparam);

  if ($occupation_count == 0) {
    $rest->setAction('count');

    // standard filters
    $rest->setRequestKey('apikey','apikey');
    $rest->setRequestKey('format','xml');


    $rest->setMethod('post');
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	  $use_appcache = true;
	  $cid = "occupation-gridcount-" . $thetitle . '-' . $categoryparam . $wtcodeparam . $groupidparam ;
	  $cached_content = null;
	  
	  //print "OCCUPATIONS DETAIL: before call to rest data " . udate("H:i:s:u") . "<br />";
	  if ($use_appcache) {
		 $cached = cache_get($cid,'cache_content');
		 $ser_content = $cached->data;
		 if (!empty($ser_content)) {
			$cached_content = unserialize($ser_content);
			//print "using cached data for " . $cid . "<br />";
		 }
	  }
	  
	  if (empty($cached_content)) {
		 $count_results = $rest->call();
		 if ($use_appcache) {
		   // save data to cache
		   $ser_content = serialize($count_results);
		   cache_set($cid, $ser_content, 'cache_content', $CACHE_PERMANENT);
		   //print "setting cache for " . $cid . "<br />";
		}
	  } else {
		 $count_results = $cached_content; 
	  }
	  //print "OCCUPATIONS DETAIL: after call to rest data " . udate("H:i:s:u") . "<br />";	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	
    $count_results = new SimpleXMLElement($count_results);


    if (isset($_GET['debug'])) {
      echo "<div style='border: 1px black solid;'><p><pre>REST Count Results: <br>";
      print_r($count_results);
      echo "</pre></p></div>";
    }
    $occupation_count = $count_results->data->count;


  }

  //$page = ($_GET['page']) ? $_GET['page'] : 1;
  $page = get_clean_url_paired_parameter('page');
  if (!$page)
	$page = 1;

  //echo $page . "<br>";

  $total_pages = ceil($occupation_count / $limit);

  //echo $occupation_count . "/" . $limit . " = " . $total_pages . "<br>";





	//echo 'piece1='. $getpieces[2];

	//| ".$_POST['worktype'];


  if ($page > $total_pages) { $page = $total_pages; }
  if ($page < 1) { $page = 1; }

  $offset = ($page * $limit) - ($limit);
   //echo "offset = ".$offset."<br/>";
  // echo "url = "; print_r(curPageURL());


   //echo "limit = ".$_GET['limit'];


  $rest->setAction('list');

  // standard filters
  $rest->setRequestKey('apikey','apikey');
  $rest->setRequestKey('format','xml');
 // $rest->setRequestKey('limit',8);
 if ($searchcodes=="blank")
	$rest->setRequestKey('limit',0);
  $rest->setRequestKey('offset',$offset);

   $cma = vcnCma::getInstance();
  /*
	$tzipcode=intval($cma->zipcode);

	if (strlen($tzipcode)==4)
		$tzipcode='0'.$tzipcode;
*/



  if(preg_match("/^[0-9]{5}$/",$cma->zipcode) && strlen($cma->zipcode) && $_POST['frompage']!="true") {
	$zipcode = $cma->zipcode;

  }

  if(preg_match("/^[0-9]{5}$/",$_SESSION['zipcode']) && strlen($_SESSION['zipcode']))  {
	$zipcode = $_SESSION['zipcode'];

  }

  if(preg_match("/^[0-9]{5}$/",$_GET['zipcode']) && strlen($_GET['zipcode'])) {
	$zipcode = $_GET['zipcode'];
	if ($zipcode=="00000")
		$zipcode="";

  }

	if (($_POST['frompage']=="true" && !preg_match("/^[0-9]{5}$/",$_GET['zipcode'])))
		$zipcode="";

	if (strlen($zipcode)==5)
		$rest->setRequestKey('zipcode',$zipcode);
	//if(!isset($_SESSION))
		session_start();


	  if (isset($_SESSION['cma'])) {
		if ($cma->zipcode!=$_SESSION['cma'])
			$zipcode = $cma->zipcode;
	  }
	  $_SESSION['cma']=$cma->zipcode;

	$_SESSION['zipcode']=$zipcode;
	$_SESSION['firsttime']="no";

  $rest->setMethod('post');



/*
  $param = get_clean_url_paired_parameter('page');
  if ($param)
	$rest->setRequestKey('category',$param);


   $paramsarr=curPageURL();
   $count=0;
   foreach ($paramsarr as $key => $value) {
		$count++;
		if ($count%2) {
			$value2 = urldecode($paramsarr[$key+1]);

			$rest->setRequestKey($value,$value2);
		}

   }
   */

 //print_r($rest); exit;
 
 
 //////////////////////////////////////////////////////////////////////////////////////////

	  $use_appcache = true;
	  $cid = "occupation-gridlist-" . $thetitle . '-' . $categoryparam . $wtcodeparam . $groupidparam . '-'. $zipcode;
	  $cached_content = null;
	  
	  //print "OCCUPATIONS DETAIL: before call to rest data " . udate("H:i:s:u") . "<br />";
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
	
 //////////////////////////////////////////////////////////////////////////////////////////


?>

<h3>Choose a Career - Results</h3>

<?php
    if (isset($_GET['debug'])) {
      echo "<div style='border: 1px black solid;'><p><pre>REST Results: <br>";
      print_r($content);
      echo "</pre></p></div>";
    }
  if (isset($content['NODATA'])) {
    $content = new SimpleXMLElement($content);

if ($onetpieces[0]=='null') {
	unset($content->data->occupation);
	unset($onetpieces[0]);
	$occupation_count=0;
}


if ($onetpieces[0]) {
	for ($x=0; $x<=10; $x++) {
		for ($y=0; $y<=90; $y++) {
			if (!in_array($content->data->occupation[$y]->onetcode, $onetpieces)) {
			 unset($content->data->occupation[$y]);
			}

		}

	}

	for ($y=0; $y<=90; $y++) {
		$oc=-1;
		foreach ($content->data->occupation as $items) {
			$oc++;
			if ($content->data->occupation[$oc]->onetcode==$onetpieces[$y]) {
			//echo $onetcodelist[$y]."YES - ".$y."AND OC IS ".$oc."<br/><br/>";
				$content2->data->occupation[$y] =$content->data->occupation[$oc];
			}

		}
	}



	//for ($kcd=0; $kcd<=90; $kcd++)
		 //unset($content->data->occupation[$kcd]);


$content->data = $content2->data;


	$occupation_count = count($content->data->occupation);
	$total_pages = ceil($occupation_count / $limit);
	if ($searchcodes=="blank")
		$occupation_count = 0;
} else {

$content2=$content;

}

    if (isset($_GET['debug'])) {
      echo "<div style='border: 1px black solid;'><p><pre>REST Results: <br>";
      print_r($content);
      echo "</pre></p></div>";
    }
  }

  if ($groupidparam)
	echo "<span style='font-size:12px;'>Based on your quiz results...<br/></span>";


  if (!strlen($occupation_count))
	$occupation_count = 0;

  echo "<span style='font-size:12px;'>".$occupation_count." healthcare career";
  
  if ($occupation_count>1 || $occupation_count<1 || !$occupation_count)
	echo "s  ";

  if ($_GET['jobtitle'])
	echo " for <b>".$thetitle."</b>";
	
	if ($occupation_count==79 && strlen($thetitle)>1)
		echo '<br/><br/><span style="color:#A71E29; font-weight:bold;">We were unable to find a suitable match for the career you entered so the complete list of healthcare careers is presented.</span>';


  //if ($groupidparam)
     //echo " for occupations related to <b>".$content->data->occupation[0]->group->title."</b>";
/*
	 $posted=0;

   if (($_POST['worktype']=="/worktypecode/mdn/score/high" || $groupidparam==8) && !$posted) {
	echo " for occupations related to <b>Medical, Dental & Nursing</b>";
	$posted=1;
    $wtcodeparam="mdn";
	$wtscoreparam="high";
   }
   if (($_POST['worktype']=="/worktypecode/ctp/score/high" || $groupidparam==14) && !$posted) {
	echo " for occupations related to <b>Counseling, Therapy & Pharmacy</b>";
	$posted=1;
    $wtcodeparam="ctp";
	$wtscoreparam="high";
   }
   if (($_POST['worktype']=="/worktypecode/vsh/score/high" || $groupidparam==13) && !$posted) {
	echo " for occupations related to <b>Vision, Speech/Hearing & Diet</b>";
	$posted=1;
	$wtcodeparam="vsh";
	$wtscoreparam="high";
   }
   if (($_POST['worktype']=="/worktypecode/lab/score/high" || $groupidparam==1) && !$posted) {
	echo " for occupations related to <b>Lab Work & Imaging</b>";
	$posted=1;
    $wtcodeparam="lab";
	$wtscoreparam="high";
   }
   if (($_POST['worktype']=="/worktypecode/ofc/score/high" || $groupidparam==6) && !$posted) {
	echo " for occupations related to <b>Office & Research Support</b>";
	$posted=1;
    $wtcodeparam="ofc";
	$wtscoreparam="high";
   }
*/
  echo "<br/><hr style='border-top: 1px dotted; border-bottom: 0px;' /></span>";

?>

<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/chili-1.8b.js"></script>
<script type="text/javascript" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/docs.js"></script>


<script type="text/javascript" language="javascript" src="/careerladder/script.js"></script>
<!--

	$(function() {
		$("#tablesorter-demo").tablesorter({sortList:[[0,0]], widgets: ['zebra']});
		$("#options").tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});
	});

	-->
<script type="text/javascript">


	$(function() {
		$("table")
			.tablesorter({widthFixed: true, widgets: ['zebra']})
			.tablesorterPager({container: $("#pager")});
			

	});

</script>

<?php $cma = vcnCma::getInstance(); ?>
<script type="text/javascript">

function openurl(url) {
	var isuser = '<?php global $user; $logged_in = $user->uid; if ($logged_in) echo "U"; else echo "S"; ?>';
	var cmaid = '<?php echo $cma->userid; ?>';
	loadhere.location.href = url;


	if (!document.getElementById('wish_list_icon').innerHTML && isuser!='U')
		document.getElementById('wish_list_icon').innerHTML="<a href=\"http://<?php echo $_SERVER['SERVER_NAME'].base_path(); ?>cma/notebook/careers\" title=\"Wish List\" alt=\"Wish List\"><img id=\"header-cma\" src=\"<?php echo base_path().drupal_get_path('module','vcn_header'); ?>/images/btn_wish_list.png\" alt=\"Wish List\" /></a>";

	var theurl = '/careerladder/careercount.php?userid='+cmaid;


	$.ajax({
		url: '/careerladder/careercount.php?userid='+cmaid,
		cache: false,
		dataType: "html",
		success: function(data) {
			var count = data;

			if (isuser!='U') {
				if (count<4)
					not_logged_in(isuser,'Career Saved temporarily in your wish list.');
				else
					red_error_box('4');
			} else {
				if (count<4)
					alert('Career is saved in Career Management Account.');
				else
					red_error_box('4');
			}
		}
	});

}

function targeturl(url,onetcode) {
	var cmaid = '<?php echo $cma->userid; ?>';
	var isuser = '<?php global $user; $logged_in = $user->uid; if ($logged_in) echo "U"; else echo "S"; ?>';

	$.ajax({
		url: '/careerladder/getcareeronetcodes.php?userid='+cmaid,
		cache: false,
		dataType: "html",
		success: function(data) {
			var data1 = data.split("###");
			var found = jQuery.inArray(onetcode, data1);
			var arrlength = data1.length;
			//alert('found-->'+found+'data -->'+ data1+'array length -->'+arrlength+ 'onetcode -->'+ onetcode);
				if (arrlength > 4 && found == -1){
					red_error_box('4');
					return false;
				}


			loadhere.location.href = url;

			if (!document.getElementById('wish_list_icon').innerHTML && isuser!='U')
				document.getElementById('wish_list_icon').innerHTML="<a href=\"http://<?php echo $_SERVER['SERVER_NAME'].base_path(); ?>cma/notebook/careers\" title=\"Wish List\" alt=\"Wish List\"><img id=\"header-cma\" src=\"<?php echo base_path().drupal_get_path('module','vcn_header'); ?>/images/btn_wish_list.png\" alt=\"Wish List\" /></a>";

			if (isuser!='U') {
				not_logged_in(isuser,'Career targeted temporarily in your wish list.');
			} else {
				alert('Career is Targeted in Career Management Account.');
			}

		}
	});


}

function getcurpage() {
		//var pageinfo2 = document.getElementById('pagedisplay').value;
		//var pieces2=pageinfo2.split("/");
		//var nextpage2=parseInt(pieces2[0],10)+1;
		//var lastpage2=parseInt(pieces2[1]);
		var tp = '';
		 if (document.getElementById('training'))
			tp = 't';
		else
			tp = 'f';

		return tp;
}



function changewages(id) {
	/*var thispage = 0;
	if (id=='one')
		thispage=1;
	if (id=='two')
		thispage=2;
	if (id=='three')
		thispage=3;
	if (id=='four')
		thispage=4;
	if (id=='five')
		thispage=5;
	if (id=='six')
		thispage=6;
	if (id=='seven')
		thispage=7;
	if (id=='eight')
		thispage=8;
	if (id=='nine')
		thispage=9;
	if (id=='ten')
		thispage=10;

	var first = (8*(thispage-1))+1;

	for (i=first; i<=first+8; i++) {*/
	for (i=1; i<=80; i++) {
		if (document.getElementById('wageradio').value=="annual") {
			if (document.getElementById('annual'+i)) {
				document.getElementById('annual'+i).style.display = '';
				document.getElementById('hourly'+i).style.display = 'none';
			}
		}

		if (document.getElementById('wageradio').value=="hourly") {
			if (document.getElementById('annual'+i)) {
				document.getElementById('annual'+i).style.display = 'none';
				document.getElementById('hourly'+i).style.display = '';
			}
		}

	}
}

function getpages() {

var pages = document.getElementById('pagedisplay').value;

return pages;

}

function locationchange() {

sessionStorage.setItem("mykeygrid", 1)

var gotourl = "<?php echo base_path(); ?>careergrid/";

gotourl+=$('#worktype').val();

gotourl+=$('#training').val();

gotourl+= "?jobtitle="+document.getElementById('jobtitle').value;

window.open(gotourl,'_self');
return;

document.traininglist.action = gotourl;
document.forms["traininglist"].submit();
return;
//var zipvalueinoccupationdetail = document.getElementById('zipcode').value;

//$('#zipod').load('/careerladder/zipvalidation.php?zipcode='+zipvalueinoccupationdetail, function() {
                 // var zval = document.getElementById("zipod").innerHTML;
                //  if(zval == 'true' || zipvalueinoccupationdetail == '' || zipvalueinoccupationdetail == 'Zip code'){
						//document.traininglist.action = "<?php echo base_path(); ?>careergrid";

						if (!document.getElementById('jobtitle')) {
							document.traininglist.action = "<?php echo base_path(); ?>careergrid?within="+document.getElementById('within').value+"&zipcode="+document.getElementById('zipcode').value;
						}
						else {
									if (document.getElementById('li0')) {
										var li0=''; var li1=''; var li2='';
									
										if (document.getElementById('li0'))
											var li0 = document.getElementById('li0').innerHTML.toLowerCase();
										
										if (document.getElementById('li1'))
											var li1 = document.getElementById('li1').innerHTML.toLowerCase();
										
										if (document.getElementById('li2'))
											var li2 = document.getElementById('li2').innerHTML.toLowerCase();
										
										//if (li0.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0) {
										if ( li0.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0 || li1.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0 || li2.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0 || li0!=''  ) {

											 
											document.traininglist.action = "<?php echo base_path(); ?>careergrid?jobtitle="+document.getElementById('jobtitle').value+"&within="+document.getElementById('within').value+"&zipcode="+document.getElementById('zipcode').value;
											
											
											
											
										}
										else {
													document.traininglist.jobtitle.focus();
													alert('No occupations found.');
													return false;
										}						
												
									}
									else {
												document.traininglist.jobtitle.focus();
												alert('No occupations found.');
												return false;
									}


						}

						document.forms["traininglist"].submit();

            //});



	//window.open("careergrid?within="+document.getElementById('within').value+"&zipcode="+document.getElementById('zipcode').value,"_self");
	//window.open("careergrid?jobtitle="+document.getElementById('jobtitle').value+"&within="+document.getElementById('within').value+"&zipcode="+document.getElementById('zipcode').value,"_self");

}


function rememberpage(id, theclass) {
	id++;

	if (theclass.indexOf('Down')>0)
		id = id * 10;
	

	sessionStorage.setItem("gridpageno", id);

}
</script>
<script type="text/javascript" src="<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/javascripts/top_up-min.js"></script>
<script type="text/javascript">
  //TopUp.host = "http://<?php //echo $_SERVER["SERVER_NAME"]; /";?>
  TopUp.host = 	window.location.protocol+"//"+window.location.host+"/";
  TopUp.players_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/players/";
  TopUp.images_path = "<?php echo base_path() . drupal_get_path('module','occupations_detail'); ?>/images/top_up/";
</script>

<?php
$thirdwidth=248; 
//if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0'))
	//$thirdwidth=226;
?>

<div id="occupation-grid">
<div style="padding-bottom:3px;">
<div style="width: 254px; float: left; "><b>Typical Education</b></div>
<div style="width: <?php echo $thirdwidth; ?>px; float: left; "><b>Type of Work</b></div>
<div style="width: 300px; float: left; "><b>Enter a healthcare career that interests you</b></div>
</div><br/>

<?php 
$includes = drupal_get_path('module','vcn').'/includes';

require_once($includes . '/vcn_common.inc');

$catlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','category','list');


?>

<div class = "helpus" style="width: 92%; float: left; margin-right: 10px;">
<form id="traininglist" name="traininglist" method="post" action="javascript:void(0);">

<div style="float:left;">
	<label for="training">
    <select name="training" id="training" class="wide">
      <option value="/education_category_id_less/0">Any education level</option>
	  <?php $catcount=-1; foreach ($catlist->category as $k=>$v): $catcount++; ?>
	  <option <?php if ($categoryparam==$catlist->category[$catcount]->educationcategoryid) echo 'selected="selected"'; ?> value="/education_category_id_less/<?php echo $catlist->category[$catcount]->educationcategoryid; ?>"><?php echo $catlist->category[$catcount]->educationcategoryname; ?></option>
	  <?php endforeach; ?>
    </select>
	</label>
</div>
<div style="float:left; margin-left:5px;">
	<label for="worktype">
    <select name="worktype" id="worktype">
      <option value="worktypecode/0">All</option>
	  <option <?php if ($wtcodeparam=="mdn" && $wtscoreparam=="high") echo 'selected="selected"'; ?> value="/worktypecode/mdn/score/high">Medical, Dental & Nursing</option>
	  <option <?php if ($wtcodeparam=="ctp" && $wtscoreparam=="high") echo 'selected="selected"'; ?> value="/worktypecode/ctp/score/high">Counseling, Therapy & Pharmacy</option>
	  <option <?php if ($wtcodeparam=="vsh" && $wtscoreparam=="high") echo 'selected="selected"'; ?> value="/worktypecode/vsh/score/high">Vision, Speech/Hearing & Diet</option>
	  <option <?php if ($wtcodeparam=="lab" && $wtscoreparam=="high") echo 'selected="selected"'; ?> value="/worktypecode/lab/score/high">Lab Work & Imaging</option>
	  <option <?php if ($wtcodeparam=="ofc" && $wtscoreparam=="high") echo 'selected="selected"'; ?> value="/worktypecode/ofc/score/high">Office & Research Support</option>
    </select>
	</label>
</div>

<div style="float:left;" id="suggest" class="noresize">
	<div style="float:left; margin-left:5px;">
	<label for="jobtitle"><input id="jobtitle" name="jobtitle" autocomplete="off" onblur="getonet(this.value);" onkeypress="return alphaonly(event);" onclick="setvalues();suggest(this.value); keyboard(event,this.value);" onkeyup="suggest(this.value); keyboard(event,this.value);" size="40" type="text" value="<?php echo $thetitle; ?>" /></label>
	</div>
	
	<input id="keycount" name="keycount" type="hidden" value="-1" />
	<label for="onetcode"><input id="onetcode" name="onetcode" type="text" value="" style="display:none;width:3px; border:0px; color:#f2f2f2; background-color:#f2f2f2;" /></label>

	<input id="jobtitle2" name="jobtitle2" type="hidden" value="" />
	<input id="onetcodelist" name="onetcodelist" type="hidden" value="<?php echo $_POST['onetcodelist']; ?>" style="width:555px;" />
	<div class="suggestionsBox" id="suggestions" style="display: none;">
		<div class="suggestionList" id="suggestionsList">suggestion list</div>
	</div>	
</div>

<input onclick="locationchange();" style="margin-left:18px;" type="image" src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/occupations/ocupations_search/search.png" alt="Search" title="Search" />
</div>


</form>
<?php if (strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox/2')): ?>
<br/><br/><br/><br/><br/>
<?php endif; ?>

<br/><br/><br/><br/>Hint: Arrows to the right of a heading allow users to sort the column below, e.g., from lowest to highest under the "Typical Education" column.<br/>

  <table cellspacing="0" cellpadding="0" id="tablesorter-demo" class="tablesorter">
    <thead>
      <tr>
        <th rowspan="2" class="sortable_career_grid" width="340" style="border-bottom: 0px" onclick="rememberpage('0',$(this).attr('class')); javascript: setTimeout(function(){changewages()},100);">
          Career
        </th>
		<th class="sortable_career_grid" width="150" style="border-bottom: 0px" onclick="rememberpage('1',$(this).attr('class')); javascript: setTimeout(function(){changewages()},100);">
          Typical Salary
        </th>
        <th rowspan="2" class="sortable_career_grid" id="typical-education-th" width="150" style="border-bottom: 0px; padding-left: 10px; text-align: left;" onclick="rememberpage('2',$(this).attr('class')); javascript: setTimeout(function(){changewages()},100);">
          Typical Education
        </th>
        <td rowspan="2" class="unsortable_career_grid" style="border-bottom: 0px;padding-left: 10px; text-align: center;" onclick="rememberpage('3',$(this).attr('class')); javascript: setTimeout(function(){changewages()},100);">
          Actions
        </td>
      </tr>
	  <tr style="background-color: #189AB0;">
	  <!-- <td style="border-right: 1px solid #ffffff;  border-left: 1px solid #ffffff;"></td> -->
	  <td style="background-color: #189AB0; color: #FFFFFF; border-right: 1px solid #ffffff;border-left:1px solid #ffffff;"><form>
	  <label for="wageradio">
	  <input type="radio" class="wageradioa" id="wageradio" checked="checked" name="wageradio"
		onclick="sessionStorage.setItem('thewage', '.wageradioa'); javascript:document.getElementById('wageradio').value = 'annual';
		<?php for ($i=1; $i<=$occupation_count; $i++) {
				echo "javascript: if (document.getElementById('annual$i')) document.getElementById('annual$i').style.display = '';";
				echo "javascript: if (document.getElementById('hourly$i')) document.getElementById('hourly$i').style.display = 'none';";
				}
		?>" value="annual" />
		</label>
		<!-- <script>document.write(getcurpage());</script> -->

		Annual&nbsp;<input type="radio" class="wageradioh" id="wageradio" name="wageradio" onclick="sessionStorage.setItem('thewage', '.wageradioh'); javascript:document.getElementById('wageradio').value = 'hourly';

		<?php for ($i=1; $i<=$occupation_count; $i++) {
				echo "javascript: if (document.getElementById('annual$i')) document.getElementById('annual$i').style.display = 'none';";
				echo "javascript: if (document.getElementById('hourly$i')) document.getElementById('hourly$i').style.display = '';";
				}
		?>" value="hourly" />Hourly

		</form></td>

		<!-- <td style="border-right: 1px solid #ffffff; border-left: 1px solid #ffffff;">
		<script>document.getElementById('wageradio').checked=true;</script>
		</td> -->

		<!-- <td style="border-right: 1px solid #ffffff; border-left: 1px solid #ffffff;"></td> -->
		<!-- <td style="border-right: 1px solid #ffffff; border-left: 1px solid #ffffff;"></td> -->
		</tr>
    </thead>
    <tbody>
      <?php 
	  $count=0; foreach ($content2->data->occupation as $occupation) : $count++; ?>
	  <?php if ($occupation->onetcode): ?>
      <tr>
        <td>
              <a href="<?php echo base_path(); ?>careerdetails?onetcode=<?php echo $occupation->onetcode; ?>"><strong><?php echo $occupation->displaytitle; ?></strong></a>
          <br>
            <?php
			$laytitlecount=-1;
			$lowerjobtitle = strtolower($thetitle);
			//$lowerjobtitle = 'optitian';
			//echo $lowerjobtitle;

			$laytitleprint=0;
			$done=0;

			foreach ($occupation->onetsoclaytitle->item as $lk => $lv) {
				$laytitlecount++;

				$found=0;
				$thelaytitle = strtolower($occupation->onetsoclaytitle->item[$laytitlecount]->laytitle);
				$laytitle2 = explode(" ",$thelaytitle);
				$firstword = $laytitle2[0];

				for ($i=0; $i<strlen($lowerjobtitle); $i++) {
					if ($lowerjobtitle[$i]==$thelaytitle[$i])
						$found++;
				}



				if (((strtolower($occupation->onetsoclaytitle->item[$laytitlecount]->laytitle)==$lowerjobtitle || $found>strlen($lowerjobtitle)-3))  && ($found!=strlen($firstword)  || $found==strlen($thelaytitle) )) {
					$done++;

					if ($found>strlen($lowerjobtitle)-3 && $done<=1 && $found!=strlen($thelaytitle)) {
						$whole = explode(" ",$occupation->onetsoclaytitle->item[$laytitlecount]->laytitle);
						$wholetext='(';
						foreach ($whole as $w1=>$w2) {
							if (stristr($lowerjobtitle,$w2))
								$wholetext.='<b>'.$w2.'</b> ';
							else
								$wholetext.=$w2.' ';
						}
						$wholetext=substr($wholetext,0,-1);
						
						$wholetext.=')';
						
						echo $wholetext;
						//echo '('.$occupation->onetsoclaytitle->item[$laytitlecount]->laytitle.')';
					} elseif ($done<=1) {
						echo '(<b>'.$occupation->onetsoclaytitle->item[$laytitlecount]->laytitle.'</b>)';
					}


				}
			}

			$laytitlecount=-1;

			$laytitlecomp='';
			foreach ($occupation->onetsoclaytitle->item as $lk => $lv) {
				$laytitlecount++;
				
				$lowerlaytitle = strtolower($occupation->onetsoclaytitle->item[$laytitlecount]->laytitle);

				if ((!empty($lowerlaytitle)) && (!empty($lowerjobtitle))) {
				   if (strstr($lowerlaytitle,$lowerjobtitle) && !$done) {
					  $laytitleprint++;

					  $laytitlecomp.=$occupation->onetsoclaytitle->item[$laytitlecount]->laytitle;

					  $laytitle2 = $occupation->onetsoclaytitle->item[$laytitlecount]->laytitle;
					  $laytitle2 = explode(" ",$laytitle2);

					  $laytitle3='';
					  foreach ($laytitle2 as $k=>$v) {

					     if ( (!empty($lowerjobtitle)) && (!empty($v)) ) {
						    if ( strstr($lowerjobtitle,strtolower($v)) || strstr(strtolower($v),$lowerjobtitle) ) {
						 	  $v="<b>".$v."</b>";
						    }
						 }

						 $laytitle3.=$v." ";

					  }

					  $laytitle3 = substr($laytitle3, 0, -1);

					  if ($laytitleprint==1)
						 echo '('.$laytitle3;
					  elseif ($laytitleprint<=3 && strlen($laytitlecomp)<52)
						 echo ', '.$laytitle3;
				   }
				}
			}

			if ($laytitleprint && !$done) {
				echo ')';
				$done++;
			}
			//if ($done || $laytitleprint)
			//	echo '<br/><br/>';
			
			if (!$done) {
				$k=-1;
				foreach ($occupation->onetsoclaytitle->item as $v) {
					$k++;
					$whole = $occupation->onetsoclaytitle->item[$k]->laytitle;
					$whole = explode(" ",$whole);
					
					$jtx=explode(" ",$lowerjobtitle);
					
					$b=0;
					foreach ($whole as $k2=>$v2) {
						if (stristr($lowerjobtitle,$whole[$k2])) {						
							$b++;
							
						}
					}
					
					if ($b==count($jtx))
						break;
					
					
				}
				
				echo '('.$occupation->onetsoclaytitle->item[$k]->laytitle.')';
			}

			$description="";
			$pieces = explode(" ",$occupation->detaileddescription);
			for ($i=0; $i<=13; $i++) {
				if ($i<13)
					$description.=$pieces[$i]." ";
				else
					$description.=$pieces[$i];
			}

			echo $description."..."; ?>

        </td>
        <td>
          <?php 
			$annualWage = getAnnualSalary($occupation->wageocc->item);
            $hourlyWage = getHourlyWage($occupation->wageocc->item);
			?>
			<div id="annual<?php echo $count; ?>"><?php echo $annualWage; ?></div>
			<div id="hourly<?php echo $count; ?>" style="display: none;"><?php echo $hourlyWage; ?></div>
        </td>
        <td>
          <?php echo '<div style="display:none;">'.$occupation->typicaltraining->awlevelcode.'</div>'.$occupation->typicaltraining->title;

			if (!getTrainingGrid($occupation->typicaltraining->title))
				echo "Not Available";
		  ?>
		  <br/>
		  <?php
		  if (!$_GET['within'])
			$_GET['within'] = 100;

		if (preg_match("/^[0-9]{5}$/",$zipcode) &&  strlen($zipcode)==5 && $zipcode!="00000")
			echo '<a href="'.base_path().'find-learning/results/programs/onetcode/'.$occupation->onetcode.'/zip/'.$zipcode.'/distance/'.$_GET['within'].'">Get Qualified in '.$zipcode.'</a>';
		else
		    echo '<a href="'.base_path().'find-learning/results/programs/onetcode/'.$occupation->onetcode.'/zip/Zip code">Get Qualified</a>';
		  ?>

        </td>
        <td>

          <div style="margin-top: 15px;"><center>
		  
				<a href="/careerladder/overview.php?onetcode=<?php echo $occupation->onetcode; ?>" title ="Career Overview" toptions="type = iframe, title=Career Overview, shaded = 1, width=800, height=600, scrolling=yes, resizable = 1"><img alt="Career Overview" src="/careerladder/table-images/blue.png"></a>

				<?php $yellow = base_path()."sites/all/modules/custom/vcn/occupations/occupations_ladder/images/".$occupation->onetcode.".jpg";	
				if (file_exists("..".$yellow)): ?>
				<a toptions="type = iframe, title=Career Pathways, shaded = 1, width=945, height=600, scrolling=no, resizable = 0" title="Career Pathways" href="/careerladder/careerladder.php?onetcode=<?php echo $occupation->onetcode; ?>"><img alt="Career Pathways" src="/careerladder/table-images/yellow.png"></a><?php else: ?><img alt="No Career Pathway" src="/careerladder/table-images/grey_square.png"><? endif; ?>				

			
				<a href="<?php echo getVideoLink($occupation->onetcode,$occupation->onetcode); ?>" title="Career Video" alt="<?php echo $occupation->displaytitle; ?>" toptions="width = 425, height = 344, resizable = 1, layout=flatlook, title=<?php echo $occupation->displaytitle; ?>, shaded=1"><img alt="Career Video" src="/careerladder/table-images/red.png"></a>
					
				
				
				<a href='<?php echo base_path(); ?>findworkresults?onetcode=<?php echo $occupation->onetcode; ?>&onetcode2=<?php echo $occupation->onetcode; ?>' title ="Find Jobs"><img alt="Find Jobs" src="/careerladder/table-images/jobs.png"></a>
				
				
				<a href="javascript:void(0);" onclick="openurl('<?php echo base_path(); ?>cma/notebook/save/career/<?php echo $occupation->onetcode; ?>');">
				<img alt="Save" title="Save" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/save.png" /></a>

				<a href="javascript:void(0);" onclick="targeturl('<?php echo base_path(); ?>cma/notebook/target/career/<?php echo $occupation->onetcode; ?>','<?php echo $occupation->onetcode; ?>');">
				<img alt="Make My Target" title="Make My Target" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_grid/target.png" /></a>


		  </center></div>
        </td>
      </tr>
	  <?php endif; ?>
      <?php endforeach;  ?>
    </tbody>
  </table>
  <hr style="border-top: 1px dotted; border-bottom: 0px;" />
  <div id="pager" class="pager" style="position: relative;">
	<form>
		<input type="hidden" class="pagedisplay" id="pagedisplay" />
		<input type="hidden" class="pagesize" value="8">
	</form>

  <?php

		if ($occupation_count>0) {
			for ($thispage=0; $thispage<=($total_pages+1); $thispage++) {
					if ($thispage==($total_pages+1)) {
						$pageicon="<img alt=\"Next\" src=\"".base_path() . drupal_get_path('module','occupations_grid') ."/redarrow.jpg\">";
						$gotopage=$page+1;
					} else {
						$pageicon=$thispage;
						$gotopage=$thispage;
					}

					if ($thispage==0) {
						$textnum="prev";
						if($client->property('browser')=='sf'){
							$pageicon="<img style =\" margin-left:33px;\"alt=\"Previous\" src=\"".base_path() . drupal_get_path('module','occupations_grid') ."/redarrow0.jpg\">";
						}else{
							$pageicon="<img alt=\"Previous\" src=\"".base_path() . drupal_get_path('module','occupations_grid') ."/redarrow0.jpg\">";
						}
					}
					if ($thispage==1) {
						$textnum="one";
						echo '&nbsp;&nbsp;';
					}
					if ($thispage==2)
						$textnum="two";
					if ($thispage==3)
						$textnum="three";
					if ($thispage==4)
						$textnum="four";
					if ($thispage==5)
						$textnum="five";
					if ($thispage==6)
						$textnum="six";
					if ($thispage==7)
						$textnum="seven";
					if ($thispage==8)
						$textnum="eight";
					if ($thispage==9)
						$textnum="nine";
					if ($thispage==10)
						$textnum="ten";
					if ($thispage==$total_pages+1)
						$textnum="next";

					if ($thispage==0)
						echo '<span style="float:left;">Page </span>';

					if ($total_pages==1 && $textnum=="next"){ } else {

						echo '<span class = "'.$textnum.'" onclick="bold(\''.$textnum.'\');"';

						if ($thispage==0)
							echo "style=\"position: absolute; margin-top:-5px; margin-left:-5px;\"";

						echo '><a id = "'.$textnum.'" href="javascript:void(0)" style="text-decoration: none;';

						if ($thispage==0)
							echo ' display:none;';

						echo '">'.$pageicon.'</a></span>';
					}





			}
		}


	?>
	</div>
</div>

<div id="zipod" style="display:none;"></div>
  <iframe name="loadhere" src="" style="height: 0px; width: 0px; border: 0px;">&nbsp;</iframe>


<div id="loadcareercount" style="display:none;"></div>


<div style="float:right;"><a target="_blank" href="http://www.careeronestop.org"><img alt="COS" src="<?php echo base_path(); ?>sites/all/themes/zen_hvcp/images/careeronestoplogo.png"></a></div>