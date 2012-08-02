<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php echo $content['search'];?>

<h2>LIST COURSE</h2>
 
<?php if ($data) : ?>
	<table class="vcn-table">
		<thead>
   		<tr valign="top">
        	<th class="sortable<?php if ($vars['order_courses'] == 'instnm') echo $vars['direction_courses']; ?>" align="left" width="240px">School Name</th>
      		<th class="<?php if (array_key_exists('zip', $vars) AND $vars['zip'] !== '') echo 'sortable'; if ($vars['order_courses'] == 'distance') echo $vars['direction']; ?>" align="left" width="70px">Distance</th>
        	<th class="sortable<?php if ($vars['order_courses'] == 'course_title') echo $vars['direction_courses']; ?>" align="left" width="240px">Course Title</th>
        	<th class="sortable<?php if ($vars['order_courses'] == 'delivery_mode') echo $vars['direction_courses']; ?>" align="left" width="75px">Type</th>
			<th class="sortable<?php if ($vars['order_courses'] == 'subject_area') echo $vars['direction_courses']; ?>" align="left" width="135px">Subject Area</th>
        	<th width="145px">&nbsp;</th>
       	</tr>
	</thead>
	
	<?php $count = 0; ?>
	<?php foreach ( $data AS $row ) : ?>
   		<?php $class = (++$count%2 == 0) ? 'odd' : 'even';?>      
 	 	<tr class="<?php echo $class; ?>"  valign="top">
        	<td>
          	<span class="grid-school">
             <?php 
              if ((string)$row->provider->webaddr !== 'NULL' AND trim((string)$row->provider->webaddr) !== '') 
             {
           		$webaddr = substr_compare( 'http',(string)$row->provider->webaddr,0,4,true) ? 'http://'. (string)$row->provider->webaddr : (string)$row->provider->webaddr;
             	echo '<a target="_blank" href="'.$webaddr.'">'.$row->provider->instnm.'</a>';
             }
             ?>
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
        <td>
           <span class="grid-distance">
           	<?php 
           		if ((string)$row->distance !== 'NULL' AND trim((string)$row->distance) !== '')
           			echo $row->distance . ' m'; 
           	?>
           </span>
        </td>
       <td>
          	<?php 
       		 	echo '<a href="/drupal/find-learning/detail/courses/course_id/'
       					.$row->courseid
       					.'" alt = "'.$row->coursetitle.'">';
          	 	echo '<span class="cipcode-title">'.$row->coursetitle.'</span>';
          	 	echo '</a>';
        		echo '<br /><br />' ;
      
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
	           	<?php 
		            if (user_access('edit vcn_portal courses'))
		            {
		            	echo '<button>Edit</button>';
		            }
		        ?>
    	
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
 	 			echo '<a class="small" target="'.$target.'" href="'.$ocourseurl.'">Take Online</a><br />';         	
			} 
		?>
 	
    	
    	</td>
      	
      </tr>		
		
	<?php endforeach; ?>
	</table>
<div class="pagination">
	<?php echo $content['pagination']; ?>
</div>	
<?php else: ?>
	<p>No Courses matching criteria</p>
<?php endif; ?> 