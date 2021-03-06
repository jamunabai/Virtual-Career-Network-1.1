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



	  

		$occlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','occupation','list',false,false);
		
		$ok=-1;
		$laytitlesshort = array();
		foreach($occlist->occupation as $ov) {
			$ok++;
  	  	 	 $title    = (string) $occlist->occupation[$ok]->displaytitle;
	  	 	 $onetcode = (string) $occlist->occupation[$ok]->onetcode;
	   		 $laytitlesshort[$title] = $onetcode;	
			 $laytitles[$title] = (string) $occlist->occupation[$ok]->onetcode;
		}
		ksort($laytitlesshort);
	
		  $cma = vcnCma::getInstance();


			if(preg_match("/^[0-9]{5}$/",$cma->zipcode) && strlen($cma->zipcode))
			$zipcode = $cma->zipcode;

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


	?>

	<script language="javascript" type="text/javascript">
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
								$("#selectacareer").addClass("redborder");
								return;
							}		

							if (which==2 && !document.getElementById('jobtitle').value) {
								alert('Please enter a keyword.');
								$("#jobtitle").addClass("redborder");
								document.getElementById('jobtitle').focus();
								return;
							}									
 				  
							if (thisValue.length>0 || which==1) {
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
										document.searchform.action = "<?php echo base_path(); ?>findworkresults?onetcode="+document.getElementById('selectacareer').value+"&onetcode2="+document.getElementById('selectacareer').value;									
									else 
										document.searchform.action = "<?php echo base_path(); ?>findworkresults?jobtitle2="+document.getElementById('jobtitle').value+"&onetcode2="+onetcode2;		
									
									document.forms["searchform"].submit();
								//}


							}
/*
							else { alert('Please enter a ZIP Code'); document.getElementById('zipcode').focus();
								if (document.getElementById('jobtitle').value.length<3) {
									$("#jobtitle").addClass("redborder");
									alert('Please enter a keyword.');
								}
								return false;
							}
*/


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

	<div>
		<div style="background-color:transparent; width:700px; float:left; position:relative;">
			<div style="width:670px;">
				<p>Find healthcare job openings in your geographic area by simply entering the requested information into the search box below and clicking "Search".</p>
		
				<h3 style="margin-top:20px;">Before You Begin</h3>
		
				<p>At this point in your path towards getting a job in healthcare, you should have
(1) identified a specific healthcare career which you have chosen as your target and (2) completed (or in the process of taking) the necessary education or training to earn the credential(s) you will need to start that career.  </p>
<p>
Use the resources listed in red on the right to support and expand your job search.  You may also want to consult the online <a href="<?php echo base_path(); ?>jobseekers">Job Seekers Guide</a>.</p>
		
				<h3 style="margin-top:30px;">Search for Jobs</h3>
				
				
 Use the fields below to search for healthcare jobs.  First, enter a zip code and select the distance from that location that you want to search.  Then you can select one of two types of search strategies.  The <strong>Healthcare Careers</strong> drop down box allows you to select one of the 82 specific careers in the healthcare field covered by the VCN.  The <strong>Job Title</strong> text box allows you to enter keywords that might appear in a job title.  As you type, common healthcare job titles are displayed below as an aid.  Complete your entry or select a title as it appears. <br/><br/>				
				<div class="training-filters" style = "width: 100%;">
	
					<form name="searchform" action="javascript:void(0);" id="form" method="post">
					<div id="suggest" class="fhcsearch rndcrnr noresize" style="width:96%">
						
						<div style="margin-bottom:5px;">
							<div style="float:left;">
							<b>ZIP Code:</b>
							<label for="zipcode"><input id="zipcode" name="zipcode" type="text" value="<?php echo $zipcode;?>" size="7" maxlength="5" onkeypress="return numericonly(event);" /></label>
							</div>
							
							<div style="float:left; margin-left:25px;">
							<label for="distance"><b>Distance:</b></label>
								<select id="distance" name="distance">
									<option value="5">5 miles</option>
									<option value="15">15 miles</option>
									<option value="25">25 miles</option>
									<option value="50">50 miles</option>
									<option value="100" selected="selected">100 miles</option>
									<option value="250">250 miles</option>
									<option value="500">500 miles</option>
								</select>	
							</div>
						</div>
						<br/><br/>
							<hr style="border-top:1px solid #a8a8a8; border-bottom:none; border-left:none; border-right:none; margin-top:9px;" />
						<br/>
						<b>Healthcare Careers:</b><br/>
						<label><select id="selectacareer" style="width: 579px;">
						<option value='' selected>Select a Career</option>
						<?php
							foreach ($laytitlesshort as $key=>$value)
							{
								echo '<option value="'.$value.'">'.$key.'</option>';
							}
						?>
						</select></label>	

						<div class="noresize" style="margin-top:-24px; height:40px; margin-left:589px;">
							<input id="Search" name="Search" type="image" alt="Search" title="Search" src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/occupations/ocupations_search/search.png"  onclick="checkonet(document.getElementById('jobtitle').value,document.getElementById('onetcode').value,1);" />
						</div>						
						<center><strong>OR</strong></center>

						<b>Job Title:</b><br/>
							<label for="jobtitle"><input id="jobtitle" name="jobtitle" autocomplete="off" onblur="$('#suggestions').fadeOut();" onkeypress="return alphaonly(event);" onkeyup="suggest(this.value);keyboard(event,this.value);" maxlength="60" style="width:573px;" type="text" value="" /></label>&nbsp;
							<input id="keycount" name="keycount" type="hidden" value="-1" />
							<label for="onetcode"><input id="onetcode" name="onetcode" type="text" value="" style="width:3px; border:0px; color:#f2f2f2; background-color:#f2f2f2; display:none;" /></label>
							<input id="jobtitle2" name="jobtitle2" type="hidden" value="" />

		
							<input id="onetcodelist" name="onetcodelist" type="hidden" value="" />
							<div class="noresize" style="margin-top:-24px; height:40px; margin-left:589px;">
								<input id="Search" name="Search" type="image" alt="Search" title="Search" src="<?php echo base_path(); ?>/sites/all/modules/custom/vcn/occupations/ocupations_search/search.png"  onclick="checkonet(document.getElementById('jobtitle').value,document.getElementById('onetcode').value,2);" />
							</div>
							<div class="suggestionsBox noresize" id="suggestions" style="display: none; 
							<?php if (stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome')) echo 'margin-top:5px;'; ?> 
							<?php if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 9')) echo 'top:177px;'; else echo 'top:172px;'; 
								  if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8') || stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome')) echo 'top:174px;'; 
								  if ((stristr($_SERVER['HTTP_USER_AGENT'], 'Firefox/8') || stristr($_SERVER['HTTP_USER_AGENT'], 'Firefox/7')) && stristr($_SERVER['HTTP_USER_AGENT'], 'WOW64')  ) echo 'top:186px;';
								  ?>">
								<div class="suggestionList" id="suggestionsList">suggestion list</div>
							</div>
					</div>
					</form>
					
				</div>
				<br/><br/><br/><br/><br/><br/><br/>
				<div style="margin-top:125px;">
				<strong>Hint:</strong>  If you want to search for an exact job title, enclose it in quotation marks, e.g., "physician assistant" or "home health aide".
				</div>
				
			</div>	
		</div>

		<div id="findworkright" style="background-color:transparent; width:257px; float:left; position:relative;">
				<img alt="Jobs Image" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_findwork/jobs.jpg" style="border:1px solid;" />
				<br/><br/><br/><br/>
				<div style="background-color:transparent; height:135px; width:257px;">
					<h3 style="margin-top:-0.2em;">Job Search Help</h3>
					<ul style="padding:5px; margin-left:20px;">
						<li style="font-size:12px; font-family: verdana;"><a href="<?php echo base_path(); ?>findwork/job_search_plan">Plan your Job Search</a></li>
						<li style="font-size:12px; font-family: verdana;"><a href="<?php echo base_path(); ?>findwork/research_employers">Research Employers</a></li>
						<li style="font-size:12px; font-family: verdana;"><a href="<?php echo base_path(); ?>findwork/use_network">Use your Network</a></li>
						<li style="font-size:12px; font-family: verdana;"><a href="<?php echo base_path(); ?>findwork/network_online">Network Online</a></li>
						<li style="font-size:12px; font-family: verdana;"><a href="<?php echo base_path(); ?>findwork/resume">Build a Resume</a></li>
						<li style="font-size:12px; font-family: verdana;"><a href="<?php echo base_path(); ?>findwork/interviews">Ace your Interviews</a></li>
						<li style="font-size:12px; font-family: verdana;"><a href="<?php echo base_path(); ?>findwork/jobsinfo">Find more Jobs Information</a></li>
						<li style="font-size:12px; font-family: verdana;"><a href="javascript:popit('http://onchitjobs.himss.org/home/index.cfm?site_id=12238')">Healthcare Jobs</a></li>	
					</ul>
					<br />
					<br />
					<h3 style="margin-top:-0.2em;">Employer Help</h3>
					<p style="font-size:12px; font-family: verdana;">Are you a business that employs healthcare workers?  
					Would you like to see your jobs listed where newly credentialed healthcare workers can find them?
					<a href="<?php echo base_path(); ?>findwork/findjobs">Click here</a> to post a job opening on the VCN.</p>
				</div>
		</div>

	</div>


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
		document.searchform.action = "<?php echo base_path(); ?>careergrid";
		setTimeout("$('#suggestions').fadeOut();", 600);
	}
	function getonet(thisValue) {
		$('#onetcode').val(thisValue);
		document.searchform.action = "<?php echo base_path(); ?>careerdetails";
	}

</script>

<div class="fhc"><span style="font-size: 12px;"><strong>Find work</strong></span><form name="searchform" action="" id="form" method="post">
<div id="suggest">
<input id="country" onblur="fill();" onclick="this.value='';" onkeyup="suggest(this.value);" size="25" type="text" value="" autocomplete="off" />&nbsp;
<input id="Search" name="Search" type="submit" value="Search" />
<input id="onetcode" name="onetcode" onblur="getonet();" size="25" type="hidden" value="" />

<div class="suggestionsBox" id="suggestions" style="display: none;">



<div class="suggestionList" id="suggestionsList">&nbsp;</div></div></div></form></div> -->
<div id="zipod" style="display:none;"></div>