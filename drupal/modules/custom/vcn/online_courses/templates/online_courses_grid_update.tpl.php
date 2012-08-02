<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php  if (!$data) :?>
	<tr><td colspan = "5" class="message">No Course found</td></tr>  
	
<?php else: ?>
 
  <?php $count = 0; ?>
  <?php foreach ( $data AS $course ) : ?>
   	 <?php $class = (++$count%2 == 0) ? 'odd' : 'even';?>      
      <tr class="<?php echo $class; ?>"  valign="top">

       <td>
          	<?php 
       		 	echo '<a href="'.base_path().'find-learning/detail/courses/course_id/'
       					.$course->courseid
       					.'" alt = "'.$course->coursetitle.'">';
          	 	echo '<span class="cipcode-title">'.$course->coursetitle.'</span>';
          	 	echo '</a>';
        		echo '<br /><br />' ;
      
			?>
        </td>
        
        <td>
        	<?php 
        		if ((string)$course->coursedeliverymode->description !== 'NULL' AND trim((string)$course->coursedeliverymode->description !== 'NULL')  ) {
		     		echo  $course->coursedeliverymode->description;
	      	 	}  
	      	?>
        </td>
		
        <td>
        	<?php 
        	 if ((string)$course->subject->description !== 'NULL' AND trim((string)$course->subject->description !== 'NULL')  ) {
		     	 echo  $course->subject->description;
	      	 }  
	      	 ?>
		</td>
        <td>
 	    <a class="save-to-notebook" alt="Save this course" title="Save this course"  onclick="return vcn_saveOrTargetToCMA (this,'courses', 'course_id', <?php echo $course->courseid; ?>);" href="<?php echo base_path(); ?>cma/notebook/save/course/<?php echo $course->courseid; ?>"> </a>
     	<a class="target-to-notebook" alt="Target this course" title="Target this course"  onclick="return vcn_saveOrTargetToCMA (this,'courses', 'course_id', <?php echo $course->courseid; ?>);"  href="<?php echo base_path(); ?>cma/notebook/target/course/<?php echo $course->courseid; ?>"> </a>
    	<br class="clear"/><br />
    	
    	<?php 
			if ((string)$course->courseinfourl !== 'NULL' AND trim((string)$course->courseinfourl) !== '')  
			{ 
				$dataurl = substr_compare( 'http',(string)$course->courseinfourl,0,4,true) ? 'http://'. (string)$course->courseinfourl : (string)$course->courseinfourl;
				echo '<a class="small" target="_blank" href="'.$dataurl.'">More Info</a><br />';
			}
			           	 	  			
			if ((string)$course->onlinecourseurl !== 'NULL' AND trim((string)$course->onlinecourseurl !== '') ) 
			{

				if ((string)$course->deliverymode == '3')
				{
		 			$target =  '_self';
					$ocourseurl =  base_path().(string)$course->onlinecourseurl;
				}
				else 
				{
					$target =  '_blank';
			    	$ocourseurl = substr_compare( 'http',(string)$course->onlinecourseurl,0,4,true) ? 'http://'. (string)$course->onlinecourseurl : (string)$course->onlinecourseurl;
				}
				echo '<a class="small" target="'.$target.'" href="'.$ocourseurl.'">Take Online</a><br />';         	
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
  
 
	 