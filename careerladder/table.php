<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<style type="text/css">
table.tablesorter a { color:#A61E28; }
#pager { text-align: left; }


/*body,div,h1{font-family:'trebuchet ms', verdana, arial;margin:0;padding:0;}*/

h1{font-size:large;font-weight:400;margin:0;}
h2{color:#333;font-size:small;font-weight:400;margin:0;}
pre{background-color:#eee;border:1px solid #ffffff;border-left-width:5px;color:#333;font-size:small;overflow-x:auto;padding:15px;}
pre.normal{background-color:transparent;border:none;border-left-width:0;overflow-x:auto;}
#logo{background:url(images/jq.png);display:block;float:right;height:31px;margin-right:10px;margin-top:10px;width:110px;}
/* #main{margin:0 20px 20px;padding:0 15px 15px 0;} */
#content{padding:20px;}
#busy{background-color:#e95555;border:1px ridge #ffffff;color:#eee;display:none;padding:3px;position:absolute;right:7px;top:7px;}
hr{height:1px;}
code{font-size:108%;font-style:normal;padding:0;}
ul{color:#333;list-style:square;}
#banner{margin:20px;padding-bottom:10px;text-align:left;}
#banner *{color:#232121;font-family:Georgia, Palatino, Times New Roman;font-size:30px;font-style:normal;font-weight:400;margin:0;padding:0;}
#banner h1{display:block;float:left;}
#banner h1 em{color:#6cf;}
#banner h2{float:right;font-size:26px;margin:10px 10px -10px -10px;}
#banner h3{clear:both;display:block;font-size:12px;margin-top:-20px;}
#banner a{border-top:1px solid #ffffff;display:block;font-size:14px;margin:5px 0 0;padding:10px 0 0;text-align:right;width:auto;}
a.external{background-image:url(../img/external.png);background-position:center right;background-repeat:no-repeat;padding-right:12px;}
form{font-size:10pt;margin-bottom:20px;width:auto;}
form fieldset{padding:10px;text-align:left;width:140px;}
div#main h1{border-bottom:1px solid #ffffff;display:block;margin-top:20px;padding:10px 0 2px;}
table#tablesorter-demo {margin: 10px 0 0 0;}
table#options *{font-size:small;}
p.tip em {padding: 2px; background-color: #6cf; color: #FFF;}
p.tip.update em {background-color: #FF0000;}
div.digg {float: right;}

/* tables */
table.tablesorter {
	font-family:arial;
	background-color: #CDCDCD;
	margin:10px 0pt 15px;
	font-size: 8pt;
	width: 100%;
	text-align: left;
}
table.tablesorter thead tr th, table.tablesorter tfoot tr th {
	background-color: #A61E28;
	border: 1px solid #FFF;
	font-size: 8pt;
	padding: 4px;
	color: #ffffff;
}
table.tablesorter thead tr .header {
	background-image: url(/drupal/sites/all/modules/custom/vcn/occupations/occupations_grid/bg.jpg);
	background-repeat: no-repeat;
	background-position: center right;
	cursor: pointer;
}
table.tablesorter tbody td {
	color: #3D3D3D;
	padding: 4px;
	background-color: #FFF;
	vertical-align: top;
}
table.tablesorter tbody {
	border-left: 1px solid #FFFFFF;
}
table.tablesorter tbody tr.odd td {
	background-color:#FFFFFF;
}
table.tablesorter tbody tr.even td {
	background-color:#F0F0F6;
}
table.tablesorter thead tr .headerSortUp {
	background-image: url(/drupal/sites/all/modules/custom/vcn/occupations/occupations_grid/desc.jpg);
	color: #ffffff;
}
table.tablesorter thead tr .headerSortDown {
	background-image: url(/drupal/sites/all/modules/custom/vcn/occupations/occupations_grid/asc.jpg);
	color: #ffffff;
}
table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
background-color: #A61E28;
}
</style>

<?php

require_once('../drupal/sites/default/hvcp.functions.inc');


$basepath = $GLOBALS['hvcp_config_default_base_path'];

function getVideoLink($onetcode,$oldonetcode) {

$dir = "/drupal/sites/all/modules/custom/vcn/occupations/occupations_detail/videos/";

$path = "..".$dir.$onetcode.".flv";

if (file_exists($path))
	return $dir.$onetcode.".flv";
else
	return '';

}

function goodImplode($data, $max, $type) {

	$count=0;

	foreach ($data as $value) {
		$count+=1;
		if ($count<=$max) {
				if ($type=="br")
					$output .= $value."<br/>";
				else
					$output .= $value.", ";
		}
	}

	$output[strlen($output)-2]=' ';

	if (!$count)
		return "Not available.";
	else
		return $output;


}

function hlp($onetcodelist,$type,$ed,$zip) {

	require_once('vcn.rest.inc');

	$rest = new vcnRest;

	$rest->setService('occupationsvc');
	$rest->setModule('occupation');
	$rest->setAction('list');

	// standard filters
	$rest->setRequestKey('format','xml');
	//$rest->setRequestKey('limit','20');
	$rest->setRequestKey('skills','on');
	$rest->setRequestKey('tnt','on');
	
	if (strlen($zip)==5)
		$rest->setRequestKey('zipcode',$zip);

	if (strlen($type)==3) {
		$rest->setRequestKey('worktypecode',$type);
		$rest->setRequestKey('score','high');
	}

	if ($ed>0) {
		$rest->setRequestKey('education_category_id_less',$ed);
	}

	$rest->setMethod('post');

	$content = $rest->call();

	$content = new SimpleXMLElement($content);

	if ($onetcodelist[0]) {
			for ($x=0; $x<=10; $x++) {
				for ($y=0; $y<=90; $y++) {
					if (!in_array($content->data->occupation[$y]->onetcode, $onetcodelist)) {

					 unset($content->data->occupation[$y]);

					}

				}

			}

			//$content2 = $content;
			//unset($content2->data);


			for ($y=0; $y<=90; $y++) {
				$oc=-1;
				foreach ($content->data->occupation as $items) {
					$oc++;
					if ($content->data->occupation[$oc]->onetcode==$onetcodelist[$y]) {
					//echo $onetcodelist[$y]."YES - ".$y."AND OC IS ".$oc."<br/><br/>";
						$content2->data->occupation[$y] =$content->data->occupation[$oc];
					}

				}
			}

			//	print_r($content2);


	} else {

		$content2 = $content;

	}


	$content = $content2->data;

  return $content;

}

function getTraining($training) {

	$pieces = explode(" - ", $training);
	$training = $pieces[0];

	$pieces = explode(" (", $training);
	$training = $pieces[0];

	return $training;

}



error_reporting(0);

require_once('vcn.rest.inc');
$onetcodes = vcn_onetcodes_match($_GET['jobtitle']);


$type = $_GET['type'];
$ed = $_GET['ed'];
$zip= $_GET['zip'];

$content = hlp($onetcodes,$type,$ed,$zip);
//print_r($content);
?>

<script type="text/javascript">


function bold(id) {

		var fifty=["one","two","three","four","five","six","seven","eight","nine","ten","eleven","twelve","thirteen","fourteen","fifteen","sixteen","seventeen","eightteen","nineteen","twenty",
		"twentyone","twentytwo","twentythree","twentyfour","twentyfive","twentysix","twentyseven","twentyeight","twentynine","thirty","thirtyone","thirtytwo","thirtythree","thiryfour","thirtyfive",
		"thirtysix","thirtyseven","thirtyeight","thirtynine","fourty","fourtyone","fourtytwo","fourtythree","fourtyfour","fourtyfive","fourtysix","fourtyseven","fourtyeight","fourtynine","fifty","fiftyone"];

		var key=0;

		var pageinfo = document.getElementById('pagedisplay').value;
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

function snapshot(title,desc,skills,education,tools,tech,onet,dashonet) {
	desc = desc.substr(0,225);
	//window.scroll(0,215);
	

	document.getElementById('snapshot').innerHTML = '<span class="vcn-gs-heading-black" style="margin-left:-5px">Career Snapshot</span><br/><br/><br/><b>'+title+'</b><br/><br/><b>Description</b> <span id="sixdesc" onclick="showhidega(\'sixdesctext\',1);" style="cursor:pointer;">[+]</span><div id="sixdesctext" style="display:none; margin-bottom:-15px;">'+desc+'</div><br/><br/><b>Typical Skills</b> <span id="sixskills" onclick="showhidega(\'sixskillstext\',1);" style="cursor:pointer;">[+]</span><div id="sixskillstext" style="display:none; margin-bottom:-15px;">'+skills+'</div><br/><br/><b>Tools</b> <span id="sixtools" onclick="showhidega(\'sixtoolstext\',1);" style="cursor:pointer;">[+]</span><div id="sixtoolstext" style="display:none; margin-bottom:-15px;">'+tools+'</div><br/><br/><b>Technology</b> <span id="sixtech" onclick="showhidega(\'sixtechtext\',1);" style="cursor:pointer;">[+]</span><div id="sixtechtext" style="display:none; margin-bottom:-15px;">'+tech+'</div><br/><br/><b>Education & Training Required</b> <span id="sixed" onclick="showhidega(\'sixedtext\',1);" style="cursor:pointer;">[+]</span><div id="sixedtext" style="display:none; margin-bottom:-15px;">'+education+'</div><br/><br/><center><a target="_blank" toptions="type = iframe, width = 720, height = 750, resizable = 1, layout=flatlook, title=Career Details, scrolling=yes, shaded=1" href="<?php echo $basepath; ?>careerdetails?onetcode='+onet+'">View Career Details</a><br/><br/><a href="javascript:void(0);" onclick=" window.scroll(0,215); saveit(\'<?php echo $basepath; ?>cma/notebook/save/career/'+onet+'\',\''+title+'\', \''+onet+'\', \''+dashonet+'\');" ><img alt="Add to My Career Wishlist" title="Add to My Career Wishlist" src="/careerladder/add_to_wish_list.png"></a></center>';
}

function showhidega(value,onoff) {

	var first = (value.substr(0,value.length-4));

	if (document.getElementById(value).style.display=='none') {
		document.getElementById(value).style.display='block';
		document.getElementById(first).innerHTML='[-]';
	}
	else {
		document.getElementById(value).style.display='none';
		document.getElementById(first).innerHTML='[+]';
	}

}


function snapshotold(title,desc,skills,education,tools,tech,onet,dashonet) {
	desc = desc.substr(0,225);

	document.getElementById('snapshot').innerHTML = '<span class="vcn-gs-heading-black">Career Snapshot</span><br/><br/><b>'+title+'</b><br/><br/><b>Description</b><br/>'+desc+'<br/><br/><b>Typical Skills</b><br/>'+skills+'<br/><br/><b>Tools</b><br/>'+tools+'<br/><br/><b>Technology</b><br/>'+tech+'<br/><br/><b>Education and Training Required</b><br/>'+education+'<br/><br/><center><a target="_blank" href="<?php  echo $basepath; ?>careerdetails?onetcode='+onet+'">View Career Details</a><br/><br/><a href="javascript:void(0);" onclick="saveit(\'<?php echo $basepath; ?>cma/notebook/save/career/'+onet+'\',\''+title+'\', \''+onet+'\', \''+dashonet+'\');" >Add to My Wish List</a></center>';
}

</script>
<style>
a:focus {
    outline: none;
}

#tt {position:absolute; display:block; background:url(/careerladder/images/tt_left.gif) top left no-repeat}
#tttop {display:block; height:5px; margin-left:5px; background:url(/careerladder/images/tt_top.gif) top right no-repeat; overflow:hidden}
#ttcont {display:block; padding:2px 12px 3px 7px; margin-left:5px; background:#666; color:#FFF}
#ttbot {display:block; height:5px; background:url(/careerladder/images/tt_bottom.gif) top right no-repeat; overflow:hidden}
.hotspot { padding-bottom:1px;  cursor:pointer}


</style>



<script type="text/javascript" src="/careerladder/js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="/careerladder/js/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="/careerladder/js/chili-1.8b.js"></script>
<script type="text/javascript" src="/careerladder/js/docs.js"></script>

<script type="text/javascript" src="/careerladder/script.js"></script>

<script type="text/javascript">


	$(function() {
		$("table")
			.tablesorter({widthFixed: true, widgets: ['zebra']})
			.tablesorterPager({container: $("#pager")});
	});

</script>

<table width="100%">
<thead>
<tr bgcolor="#e8e8e8">
<th style="cursor: pointer; text-align:center;" title="Click to Sort by Career Name"><strong style="text-decoration:underline;">Career Name</strong></th>
<th style="cursor: pointer; text-align:center;" title="Click to Sort by Job Outlook"><strong style="text-decoration:underline;">Job Outlook</strong></th>
<th style="cursor: pointer; text-align:center;" title="Click to Sort by Typical Wage"><strong style="text-decoration:underline;">Typical Wage</strong></th>
<th style="cursor: pointer; text-align:center;" title="Click to Sort by Typical Education" id="typicaleducationth"><strong style="text-decoration:underline;">Typical Education</strong></th>
<td style="cursor: pointer; text-align:center;"><strong style="text-decoration:underline;">Additional Information</strong></td>
</tr>
</thead>
<tbody>
<?php
$count=0;
foreach ($content->occupation as $occupation)
	if ($occupation->onetcode)
		$count++;

if ($count) {
	$count2=0;
	foreach ($content->occupation as $occupation):
		$count2++;

		$tempdesc=str_replace("'", "\'", $occupation->detaileddescription);
		$pieces = explode ('.',$tempdesc);
		if ($pieces[0])
			$desc=$pieces[0].".";
		//if ($pieces[1])
			//$desc.=$pieces[1].".";
		if (stristr($desc,'<p>'))
			$desc = substr($desc, 3, strlen($desc)-3);
		$skills=goodImplode($occupation->skills->item,'5','comma');
		$education=str_replace("'", "\'", $occupation->typicaltraining->title);
		$tools=goodImplode($occupation->toolstechnology->tools->item,'2','comma');
		$tech=goodImplode($occupation->toolstechnology->technology->item,'2','comma');
		$onet=$occupation->onetcode;
		$dashonet=str_replace(".", "-", $onet);
		
		$desc = str_replace('"',"''",$desc);
		
		$desc = trim($desc);
		$tools = trim($tools);
		$tech = trim($tech);

		if (strlen($education)<1)
			$education="Not available.";
/*
	if ($education=="Bachelor\'s Degree")
		$education = "Bachelor\'s Degree<br/>(4 year)";

	if ($education=="Associate\'s Degree")
		$education = "Associate\'s Degree<br/>(2 year)";

	if (strstr($education,"Certificate"))
		$education = "Certificate";
*/
	?>
	<tr>
	<td><a onclick="snapshot('<?php echo $occupation->displaytitle; ?>','<?php echo $desc; ?>','<?php echo $skills; ?>','<?php echo $education; ?>','<?php echo $tools; ?>','<?php echo $tech; ?>','<?php echo $onet; ?>','<?php echo $dashonet; ?>')"><?php echo $occupation->displaytitle; ?></a></td>
	<td style="text-align:center;"><?php if (stristr($occupation->jobgrowth->text, 'faster')) 
	echo '<div style="display:none;"> a </div> <img alt="bright" src="'.$basepath.'sites/all/modules/custom/vcn/getting_started/templates/step_two/bright.png">';
				else
				echo '<div style="display:none;"> b </div> <img alt="grey" src="'.$basepath.'sites/all/modules/custom/vcn/getting_started/templates/step_two/grey.png">'; ?></td>
	<?php if (intval($occupation->wageocc->item[1]->entrywg)): ?>

	<td style="text-align:center;">$<?php echo number_format(intval($occupation->wageocc->item[1]->pct25), 0, '.', ','); ?> to  $<?php echo number_format(intval($occupation->wageocc->item[1]->pct75), 0, '.', ','); ?></td>

	<?php else: ?>

	<td>Not available</td>

	<?php endif; ?>
	<td style="text-align:center;">
	<div style="display:none;"><?php echo $occupation->typicaltraining->awlevelcode; ?></div>
	<?php
	$t = $occupation->typicaltraining->title;

	/*
	if ($t=="Bachelor's Degree")
		$t = "Bachelor's Degree<br/>(4 year)";

	if ($t=="Associate's Degree")
		$t = "Associate's Degree<br/>(2 year)";

	if (strstr($t,"Certificate"))
		$t = "Certificate";
	*/

	if (!$t) echo "Not available"; else echo $t; ?></td>
	<td style="text-align:center;">
		<div id="videoimages">
		</div>
		<a href="/careerladder/overview.php?onetcode=<?php echo $occupation->onetcode; ?>" title ="Career Overview" toptions="type = iframe, title=Career Overview, shaded = 1, width=800, height=600, scrolling=yes, resizable = 1"><img src="/careerladder/table-images/blue.png" alt="Career Overview"></a>&nbsp;<?php $yellow = "/drupal/sites/all/modules/custom/vcn/occupations/occupations_ladder/images/".$occupation->onetcode.".jpg";	if (file_exists("..".$yellow)): ?><a toptions="type = iframe, title=Career Pathway, shaded = 1, width=945, height=600, scrolling=no, resizable = 0" title="Career Pathways" href="/careerladder/careerladder.php?onetcode=<?php echo $occupation->onetcode; ?>"><img src="/careerladder/table-images/yellow.png" alt="Career Pathways"></a><?php else: ?><img src="/careerladder/table-images/grey_square.png" alt="No Career Pathways"><?php endif; ?>&nbsp;<a href="<?php echo getVideoLink($occupation->onetcode,$occupation->onetcode); ?>" title="Career Video" alt="<?php echo $occupation->displaytitle; ?>" toptions="width = 425, height = 344, resizable = 1, layout=flatlook, title=<?php echo $occupation->displaytitle; ?>, shaded=1"><img src="/careerladder/table-images/red.png" alt="Career Video"></a>
	</td>
	</tr>

	<? endforeach;
} else {
echo '<tr height="35"><td></td><td></td><td></td><td></td></tr>';
}
?>
</tbody>
</table>
<div id="pager-table">
<div id="pager" class="pager" style="float:left;">
	<form>
		<input type="hidden" class="pagedisplay" id="pagedisplay" />
		<input type="hidden" class="pagesize" value="5">
	</form>
	 <?php

		$fifty= array("one","two","three","four","five","six","seven","eight","nine","ten","eleven","twelve","thirteen","fourteen","fifteen","sixteen","seventeen","eightteen","nineteen","twenty",
		"twentyone","twentytwo","twentythree","twentyfour","twentyfive","twentysix","twentyseven","twentyeight","twentynine","thirty","thirtyone","thirtytwo","thirtythree","thiryfour","thirtyfive",
		"thirtysix","thirtyseven","thirtyeight","thirtynine","fourty","fourtyone","fourtytwo","fourtythree","fourtyfour","fourtyfive","fourtysix","fourtyseven","fourtyeight","fourtynine","fifty","fiftyone");

		$total_pages=ceil($count/5);
		/* old code
		$total_pages=intval($count/5);
		if ($count%5>0 && $count>5)
			$total_pages++;
		*/

		if ($count>1) {
			for ($thispage=0; $thispage<=($total_pages+1); $thispage++) {
					if ($thispage==($total_pages+1)) {
						$pageicon="<img alt=\"Next\" style=\"padding-top: 5px;\" src=\"".$basepath."sites/all/modules/custom/vcn/occupations/occupations_grid/redarrow.jpg\">";
						$gotopage=$page+1;
					} else {
						$pageicon=$thispage;
						$gotopage=$thispage;
					}

					$textnum = $fifty[$thispage-1];
					if ($thispage==0) {
						$textnum="prev";
						$pageicon="<img alt=\"Previous\" src=\"".$basepath."sites/all/modules/custom/vcn/occupations/occupations_grid/redarrow0.jpg\">";
					}
					if ($thispage==1) {
						$textnum="one";
						//echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					}



					if ($thispage==$total_pages+1)
						$textnum="next";

					if ($thispage==0)
						echo '<span style="margin-top:6px; float:left;">Page </span>';

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