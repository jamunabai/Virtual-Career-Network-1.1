<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php if ($data['programs']) : ?>	
<?php foreach ( $data['programs'] AS $training ) : ?>
 	
 	<?php 
 		if ((string)$training->provider->adminurl !== 'NULL' AND trim((string)$training->provider->adminurl) != '')
	   	{
	     	$adminurl = substr_compare( 'http',(string)$training->provider->adminurl,0,4,true) ? 'http://'. (string)$training->provider->adminurl : (string)$training->provider->adminurl;
	    	echo '<p><strong class="cg_highlight"><a target="_blank" href="'.$adminurl.'">Click here</a> to apply to the ' . $training->programname . ' program at ' . $training->provider->instnm . '.</strong></p>';
	    }	
   	?> 
 
	<p><strong><?php echo $training->programname; ?></strong></p>
<!-- 
	<p><?php echo $training->programdescription; ?></p>
-->			
	<span class="detail-school">
	<?php 
    	if ((string)$training->provider->webaddr !== 'NULL' AND trim((string)$training->provider->webaddr) !== '') 
        {
        	$webaddr = substr_compare( 'http',(string)$training->provider->webaddr,0,4,true) ? 'http://'. (string)$training->provider->webaddr : (string)$training->provider->webaddr;
            echo '<a target="_blank" href="'.$webaddr.'">'.$training->provider->instnm.'</a>';
        }
        else 
        {
        	echo $training->provider->instnm;
        }
    ?>
	</span> 
	<br />
	<?php 
   		if ((string)$training->provider->addr !== 'NULL'  AND trim((string)$training->provider->addr) !== '' )  echo $training->provider->addr.'<br />'; 
	    if ((string)$training->provider->city !== 'NULL'  AND trim((string)$training->provider->city) !== '' ) echo $training->provider->city; 
	    if ((string)$training->stabbr !== 'NULL' ) 
	    {
			if ((string)$training->provider->city !== 'NULL' AND trim((string)$training->provider->city) !== '' )  echo ', '; 
	       		echo $training->provider->stabbr; 
		}
		if ((string)$training->provider->zip !== 'NULL' AND trim((string)$training->provider->zip) !== '' )  echo ' '. $training->provider->zip;
		echo '<br />';
	    if ((string)$training->provider->gentele !== 'NULL' AND trim((string)$training->provider->gentele) !== '' ) echo ' '. vcn_format_phone( $training->provider->gentele ).'<br />';
	
	    if ((string)$training->provider->applurl !== 'NULL' AND trim((string)$training->provider->applurl) != '')
	   	{
	     	$appurl = substr_compare( 'http',(string)$training->provider->applurl,0,4,true) ? 'http://'. (string)$training->provider->applurl : (string)$training->provider->applurl;
	    	echo '<a class="" target="_blank" href="'.$appurl.'">Admissions</a><br />';
	    }	
	    if ((string)$training->provider->faidurl !== 'NULL' AND trim((string)$training->provider->faidurl) !== '')  
	  	{ 
	     	$faidurl = substr_compare( 'http',(string)$training->provider->faidurl,0,4,true) ? 'http://'. (string)$training->provider->faidurl : (string)$training->provider->faidurl;
	   		echo '<a class="" target="_blank"  href="'.$faidurl.'">Financial Aid</a><br />';
		}
	?>
   
   
<?php endforeach; ?>
<br><br>
Useful tips on completing College application can be found at following sites:
<br><br>
- <a href="javascript:popit('http://www.collegeboard.com/student/apply/the-application/115.html')">College Board</a><br/>
- <a href="javascript:popit('http://admissionpossible.com/Completing_Applications.html')">Admission Possible</a><br/>
- <a href="javascript:popit('http://www.drexel.com/tools/transcript.aspx?process=alpha&letter=A')">Where to get Transcripts</a>
</ul>
<?php endif; ?>