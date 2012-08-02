<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 

// header( 'Cache-Control: private, max-age=10800, pre-check=10800' );


    // var check
   	$vars  = isset($vars) ? $vars : array() ;
   	$data  = isset($data) ? $data : array() ;
   	$cma   = $vars['cma'];
   	
   	$count_programs     = (isset($vars['count_programs']) AND $vars['count_programs']) ? $vars['count_programs'] : 0;
 	$order_programs     = (isset($vars['order_programs']) AND $vars['order_programs']) ? $vars['order_programs'] : '';
 	$direction_programs = (isset($vars['direction_programs']) AND $vars['direction_programs']) ? $vars['direction_programs'] : ''; 	
   	$limit_programs     = (isset($vars['limit_programs']) AND $vars['limit_programs']) ? $vars['limit_programs'] : 8; 	
  	$pg_programs        = (isset($vars['pg_programs']) AND $vars['pg_programs']) ? $vars['pg_programs'] : 1;
	
?>

<?php  if (!$data) :?>
	<tr><td colspan = "5" class="message">No Programs found</td></tr>  
	
<?php else: ?>
 
  <?php $count = 0; ?>
  <?php foreach ( $data AS $row ) : ?>
    	 <?php  $class = (++$count%2 == 0) ? 'odd' : 'even'; ?> 
   	      
      <tr class="<?php echo $class; ?>"  valign="top">
       	<td>
       		<a 
       		  href="<?php echo base_path();?>find-learning/detail/programs/program_id/<?php echo $row->programid?>/cipcode/<?php echo $row->programcipcode->item->cipcode?>/onetcode/<?php echo $vars['onetcode'];?>"
			  alt = "<?php echo $row->programname; ?>" >
          	  <span class="cipcode-title"><?php echo $row->programname; ?></span>
          	</a>
        	<br /><br />
        </td>
        <td>
       		<?php echo truncateText($row->programdescription, 250, " "); ?>
        </td>
        <td>
           	<?php 
        		$awlevel = (string)$row->awlevel;
       			$program_length = false;
       				
         		switch ($awlevel) {
          	 		case '1':
          	 			$program_length = 'Less than 1 year';
          	 		break;
          	 		case '2':
          	 			$program_length = 'Less than 2 years';
          	 		break;
          	 		case '3':
          	 			$program_length = '2 years';
          	 		break;
          	 		case '4':
          	 			$program_length = 'Less than 4 years';	
          	 		break;
          	 		case '5':
          	 			$program_length = '4 years';	
          	 		break;
          	 		case '6':
          	 			$program_length = 'Undetermined';
          	 		break;
          	 		case '7':
          	 			$program_length = '6 years';
          	 		break;
            	 		default:
          	 	}
       			echo '<span class="program-length">'.$program_length.'</span>';
        		echo '<br /><br />';
			?>
        </td>
		
        <td>
			<?php 
				if (isset($vars['awlevel'][1])) {
				
					if ($awlevel==1 || $awlevel==2 || $awlevel==4)
						echo '<span class="cipcode-title">Certificate</span>';
					else
						echo '<span class="cipcode-title">'.$row->ipedslookup->codedesc.'</span>';

				} else {
					echo '<span class="cipcode-title">'.$row->ipedslookup->codedesc.'</span>';
				}
        		echo '<br /><br />';
			?>
		</td>
       	<td><center>
       		<?php echo $row->provider->status; ?>
        </center></td>
      </tr>
<?php endforeach; ?>

<tr><td colspan="6">
<div class="pagination" style="width:950px;">
	<?php echo $content['pagination']; ?>
</div>
</td></tr>
<?php endif; ?>

<?php
function truncateText($string, $limit, $break=".", $pad=" ...")
{
	// return with no change if string is shorter than $limit
	if(strlen($string) <= $limit) return $string;

	// is $break present between $limit and the end of the string?
	if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		if($breakpoint < strlen($string) - 1) {
			$string = substr($string, 0, $breakpoint) . $pad;
		}
	}

	return $string;
}
?>
<script>

/*  	$(document).ready(function(){

		var type = "<?php echo $vars['type']; ?>";
//alert($("#pawlevel").attr("class"));
		if (type=='programs' && $("#pawlevel").attr("class")=="sortableAsc") {  
			$("#pawlevel").click();
		}
		
			
	 });  */

	$(document).ready(function(){

		var type = "<?php echo $vars['type']; ?>";
		
		if (type=='programs' && $("#pawlevel").attr("class")=="sortableAsc" && 
		
		( ($('.sortable').text()=='School NameProgram NameAward Level'  && $('.sortableDesc').text().indexOf('Distance')<0 && $('.sortableAsc').text().indexOf('Distance')<0)
		
		|| $('.sortable').text()=='School NameDistanceProgram NameAward Level')
		
		) { 
			$("#pawlevel").click();
		}
		
			
	 });	 
	 
</script>