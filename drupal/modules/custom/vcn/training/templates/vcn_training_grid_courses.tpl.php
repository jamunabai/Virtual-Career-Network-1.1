<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php // header( 'Cache-Control: private, max-age=10800, pre-check=10800' ); ?>

<?php $cma   = $vars['cma'];?>
<?php  if (!$data) :?>
	<tr><td colspan = "5" class="message"><font color="#A71E28">No Course found</font></td></tr>  
	
<?php else: ?>
 
  <?php $count = 0; ?>
  <?php foreach ( $data AS $row ) : ?>
   	 <?php $class = (++$count%2 == 0) ? 'odd' : 'even';?>      
      <tr class="<?php echo $class; ?>"  valign="top">
        <td>
           <span class="grid-school">
         	<a href="<?php echo base_path();?>find-learning/detail/school/unitid/<?php echo $row->provider->unitid; ?>" 
   			alt="<?php echo $row->provider->instnm;?>" title="<?php echo $row->provider->instnm;?>" >
   			<?php echo $row->provider->instnm; ?></a>
           </span> 
          
           <br />
             <?php 
             if ((string)$row->provider->addr !== 'NULL' AND trim((string)$row->provider->addr)) echo $row->provider->addr.'<br />'; 
             if ((string)$row->provider->city !== 'NULL' AND trim((string)$row->provider->city)) echo $row->provider->city; 
             if ((string)$row->provider->stabbr !== 'NULL' AND trim((string)$row->provider->stabbr)) {
             	if ((string)$row->provider->city !== 'NULL' AND trim((string)$row->provider->city) ) echo ', '; 
             	echo $row->provider->stabbr; 
             }
             if ((string)$row->provider->zip !== 'NULL' AND trim((string)$row->provider->zip) !== '') echo ' '. $row->provider->zip;
             echo '<br />';
             if ((string)$row->provider->gentele !== 'NULL' AND trim((string)$row->provider->gentele) !== '') echo ' '. vcn_format_phone( $row->provider->gentele) .'<br />';


         	 if ((string)$row->provider->admnurl !== 'NULL' AND trim((string)$row->provider->admnurl) !== '') 
         	 {
           		$appurl = substr_compare( 'http',(string)$row->provider->webaddr,0,4,true) ? 'http://'. (string)$row->provider->admnurl : (string)$row->provider->admnurl;
         	 	echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
         	 }
         	 if ((string)$row->provider->faidurl !== 'NULL' AND trim((string)$row->provider->faidurl) !== '')  
         	 {
           		$faidurl = substr_compare( 'http',(string)$row->provider->webaddr,0,4,true) ? 'http://'. (string)$row->provider->faidurl : (string)$row->provider->faidurl;
         	 	echo '<a class="small" target="_blank" href="'.$faidurl.'">Financial Aid</a><br />' ;
         	 }
             ?>
         
          </td>
<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '' AND !(strstr($_SERVER['REQUEST_URI'],'courses/course_type'))): ?>  
       <!-- <td>
           <span class="grid-distance">
           	<?php 
           		if ((string)$row->distance !== 'NULL' AND trim((string)$row->distance) !== '')
           			echo $row->distance . ' m'; 
           	?>
           </span>
        </td> -->
<?php endif; ?>   
       <td>
          	<?php 
       		 	//echo '<a href="'. base_path() .'find-learning/detail/courses/course_id/'
       			//		.$row->courseid
       			//		.'" alt = "'.$row->coursetitle.'">';

          	 	echo '<span class="cipcode-title">'.$row->coursetitle.'</span>';
          	 	//echo '</a>';
        		echo '<br /><br />' ;
      
			?>
        </td>
        <td>
        	<?php
          		if ((string)$row->type->description !== 'NULL' AND trim((string)$row->type->description !== 'NULL')  ) {
		     		echo  $row->type->description;
	      	 	}  
	      	?>
        </td>   
        <td>
        	<?php 
        		if ((string)$row->coursedeliverymode->description !== 'NULL' AND trim((string)$row->coursedeliverymode->description !== 'NULL')  ) {
		     		echo  $row->coursedeliverymode->description;
	      	 	}  
	      	?>
        </td>
		
        <td>
        	<?php 
        	 if ((string)$row->subject->description !== 'NULL' AND trim((string)$row->subject->description !== 'NULL')  ) {
		     	 echo  $row->subject->description;
	      	 }  
	      	 ?>
		</td>
        <td>
 	    <a class="save-to-notebook" alt="Save this course" title="Save this course"  onclick="return vcn_saveOrTargetToCMA (this,'courses', 'course_id', '<?php echo $row->courseid; ?>');" href="<?php echo base_path(); ?>cma/notebook/save/course/<?php echo $row->courseid; ?>"> </a>
    	<!--  	
    	<a class="target-to-notebook" alt="Target this course" title="Target this course"  onclick="return vcn_saveOrTargetToCMA (this,'courses', 'course_id', '<?php echo $row->courseid; ?>');"  href="<?php echo base_path(); ?>cma/notebook/target/course/<?php echo $row->courseid; ?>"> </a>
    	-->
    	<br class="clear"/><br />
    	
    	<?php 
			if ((string)$row->courseinfourl !== 'NULL' AND trim((string)$row->courseinfourl) !== '')  
			{ 
				$dataurl = substr_compare( 'http',(string)$row->courseinfourl,0,4,true) ? 'http://'. (string)$row->courseinfourl : (string)$row->courseinfourl;
				echo '<a class="small" target="_blank" href="'.$dataurl.'">More Info</a><br />';
			}
			           	 	  			
			if ((string)$row->onlinecourseurl !== 'NULL' AND trim((string)$row->onlinecourseurl !== '') ) 
			{
 			 	if ((string)$row->deliverymode == '3')
				{
		 			$target =  '_self';
					$ocourseurl =  base_path().(string)$row->onlinecourseurl;
				}
				else 
				{
					$target =  '_blank';
			    	$ocourseurl = substr_compare( 'http',(string)$row->onlinecourseurl,0,4,true) ? 'http://'. (string)$row->onlinecourseurl : (string)$row->onlinecourseurl;
				}
 	 			echo '<a class="small" target="'.$target.'" href="' .base_path().$ocourseurl.'">Take Online</a><br />';     	
			} 
		?>
 	
    	
    	</td>
      	
      </tr>
<?php endforeach; ?>

<tr><td colspan="6">
<div class="pagination">
	<?php echo $content['pagination']; ?>
</div>
</td></tr>
<?php endif; ?>
  
 
	 