<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<style>
.fhc { float:left; padding:10px; margin-right:15px; height:25px;}
.fhc.gray { background:#999;}
#training-search-container {width:97%;}
		#suggestions { background-color: #FFFFFF; border: 1px solid #558BE3; color: #000; font-family: Arial,Helvetica,sans-serif; font-size: 11px; margin:0; padding: 0; position: absolute; min-width:200px; max-width: 300px; z-index:10;  }
		#suggestions ul {list-style:none; padding:0; margin-top:0; margin-bottom:0;}
		#suggestions ul li { padding:5px;}
		#suggestions ul li:hover { background:#D5E2FF; }
		
.squiggle
{
background-image:url("squiggle.gif");
background-repeat:repeat-x;
background-position:left bottom;
padding-bottom:2px;
vertical-align:text-top;
font-style:italic;
}
.containerline
{
border:1px solid #a5a5a5;
overflow-x: hidden;
width: 100%;
color: windowtext;
height: 18px;
background-color: window
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
		
	?>
 
	<script language="javascript" type="text/javascript">
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
							count++;
						}
						
							if (fwcount==1) {
								count=10;
								//alert(l.toLowerCase());
							}
			
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
				
 	 	 		if (((index > -1) || (index2 > -1 ))	   && count<=9 )
  	  	 	 	   {
						if (index > -1)
							newl = l.substr(0,(index+1)) + '<strong style="color: #f16b4e;">' + l.substr((index+1),inputString.length) + '</strong>' + l.substr((index+1+inputString.length));
						else if (index2 > -1 )
							newl = l.substr(0,(index2)) + '<strong style="color: #f16b4e;">' + l.substr((index2),inputString.length) + '</strong>' + l.substr((index2+inputString.length));
  	  	  	 	 		string = string + '<li id="li'+count+'" onClick="setonet(\'' + laytitles[l] + '\'); fill(\'' + l + '\'); ">' + newl +'</li>';
  	  	  	 	 		count++;
  	  	 	 		
  	  	 	 	   }   
				   

  	  	 	 	   if (count > 9 )   
  	 	 	 	   break;
 	 	 	    }

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
			//document.searchform.jobtitle.focus();
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
		function checkonet(thisValue,onetcode) { 
			var all='';
			var oldValue = thisValue;
			var thisValue = thisValue.toLowerCase();
			for (var key in laytitles) {
					keyms = key.toLowerCase().substr(0,key.length-1);
			
			//key.toLowerCase()==thisValue || 
				if (keyms==thisValue) {  
					document.getElementById('onetcode').value = laytitles[key]; 
					
					//(document.getElementById('onetcode').value.indexOf('-')>0 && document.getElementById('onetcode').value.indexOf('.')>0)  || 
					if ( keyms==thisValue ) {
						window.open ("<?php echo base_path(); ?>careerdetails?onetcode="+laytitles[key]+"&value="+oldValue,"_self");

					}
					
					//alert(key);
					return false;
				}
			}

			if (thisValue.length>0) {
				window.open("<?php echo base_path(); ?>careergrid?jobtitle="+document.getElementById('jobtitle').value,"_self");
				/*
				//document.getElementById('onetcode').value = '';
				document.getElementById('onetcodelist').value = suggestcodes(thisValue);
				var occ = document.getElementById('jobtitle').value;
				occ = occ.replace(/ /g, "+"); 

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
						if ( li0.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0 || li1.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0 || li2.indexOf(document.getElementById('jobtitle').value.toLowerCase())>0 || li0!=''  ) {

							 
							window.open("<?php echo base_path(); ?>careergrid?jobtitle="+occ,"_self");
							
							
							
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

				*/

			} else { 
				document.getElementById('jobtitle').style.border='2px solid red';
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
					document.searchform.jobtitle.focus();
				} else {
					checkonet(document.getElementById('jobtitle').value,document.getElementById('onetcode').value);
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
				var jtval = suggestionslist(document.getElementById('jobtitle').value,document.getElementById('keycount').value);
				if (jtval)
					document.getElementById('jobtitle').value = jtval;
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

			if (stringcodes[number]) {
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
			}
			
			return text;
			//return string[number];
		
		}
		
		function setvalues() {
			$('#suggestions').fadeOut();
			//document.getElementById('jobtitle').value='';
			document.getElementById('onetcode').value='';
			document.getElementById('keycount').value='-1';
			document.searchform.action = "javascript:void(0);";		
		}
		
		function alphaonly(event) {			
				

				var key = (event.which) ? event.which : event.keyCode;

			if ((key < 65 ||  key > 122) && key!=8 && key!=32 && key!=37 && key!=39 && key!=46 && key!=9)
				return false;

			return true;			

			//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
		}		
		
 	</script>
	<div class="training-filters">
		 <?php  
		 $browser = $_SERVER['HTTP_USER_AGENT'];
		  ?>
			
		<form name="searchform" action="javascript:void(0);" id="form" method="post">
		<div id="suggest" class="fhcsearch rndcrnr">
		<b>Advanced Search</b><br/>
			<label for="jobtitle"><input style="<?php if (stristr($browser, 'MSIE')) echo 'width:156px;'; else echo 'width:166px;'; ?> height:16px;font-size: 12px;" id="jobtitle" name="jobtitle" autocomplete="off" onblur="fill();getonet(this.value);" onkeypress="return alphaonly(event);" onclick="setvalues();suggest(this.value); keyboard(event,this.value);" onkeyup="suggest(this.value); keyboard(event,this.value);" size="40" maxlength="60" type="text" value="" /></label>&nbsp;

			<?php if (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7')) $tempvar='style="margin-top:-22px; margin-left:282px; height:19px;"'; else $tempvar='id="explore-search-jobtitle"'; ?>
			
			
			<div <?php echo $tempvar; ?>>
			<input id="Search" name="Search" type="image" alt="Search" title="Search" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/getting_started/images/go.png" onclick="checkonet(document.getElementById('jobtitle').value,document.getElementById('onetcode').value);" />
			</div>
			<input id="keycount" name="keycount" type="hidden" value="-1" />
			
			<label for="onetcode"><input id="onetcode" name="onetcode" type="hidden" value="" style="width:3px; border:0px; color:#f2f2f2; background-color:#f2f2f2;" /></label>
			
			<input id="jobtitle2" name="jobtitle2" type="hidden" value="" />
			<input id="onetcodelist" name="onetcodelist" type="hidden" value="" />
 			<div class="suggestionsBox" id="suggestions" style="display: none;">
				<div class="suggestionList" id="suggestionsList">suggestion list</div>
			</div>
		</div>	
		</form>
	</div>
<br/><br/><br/><br/>
	
	<?php

$modpath = base_path()."sites/all/modules/custom/vcn/occupations/occupations_layout"; ?>


<!--
<script type="text/javascript" src="/jquery.js"></script><script>
function suggest(inputString){
		if(inputString.length == 0) {
			$('#suggestions').fadeOut();
		} else {
		$('#country').addClass('load');
			$.post("/autosuggest.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').fadeIn();
					$('#suggestionsList').html(data);
					$('#country').removeClass('load');
				}
			});
		}
	}

	function fill(thisValue) {
		$('#country').val(thisValue);
		document.searchform.action = "/drupal/careergrid"; 
		setTimeout("$('#suggestions').fadeOut();", 600);
	}
	function getonet(thisValue) {
		$('#onetcode').val(thisValue);		
		document.searchform.action = "/drupal/careerdetails";
	}

</script>

<div class="fhc"><span style="font-size: 12px;"><strong>Find healthcare careers</strong></span><form name="searchform" action="" id="form" method="post">
<div id="suggest">
<input id="country" onblur="fill();" onclick="this.value='';" onkeyup="suggest(this.value);" size="25" type="text" value="" autocomplete="off" />&nbsp;
<input id="Search" name="Search" type="submit" value="Search" />
<input id="onetcode" name="onetcode" onblur="getonet();" size="25" type="hidden" value="" />

<div class="suggestionsBox" id="suggestions" style="display: none;">



<div class="suggestionList" id="suggestionsList">&nbsp;</div></div></div></form></div> -->

<div id ="loadhere" style="display:none;"></div>