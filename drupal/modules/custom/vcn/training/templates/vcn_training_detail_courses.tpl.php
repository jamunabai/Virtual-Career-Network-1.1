<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php if ($errors) : ?>
	<div class="errors">
<?php foreach ($errors AS $error):?>
		<span class="error"><?php echo $error . '<br />'; ?></span>
<?php endforeach;?>
	</div>
<?php endif; ?>
 
<form id="training-form" name="trainingform" method="post" autocomplete="off"  action="javascript:void(0);" onsubmit="caction('1'); return filterTraining(this);" > 
<input type = "hidden" id="occupation-title-one" name="occupation-title-one" value="<?php echo $data->programname; ?>" />
</form>
<?php if (!$data) : ?>
 	<span class="message">Course not found</span>
	
<?php else: ?>
 	<div id="training-detail" class="panel-2col panel-col-first">
	 	
		<h2>Course</h2>
   		<span class="training-title"><?php echo $data->coursetitle; ?></span>
		<br/>

		<div class="training-detail-left">
			<p><?php echo $data->description; ?></p>
<?php if ((string)$data->coursedeliverymode->name !== 'VCN'):?>			
			<span class="detail-school">
			<a href="<?php echo base_path();?>find-learning/detail/school/unitid/<?php echo $data->provider->unitid; ?>" 
   			alt="<?php echo $data->provider->instnm;?>" title="<?php echo $data->provider->instnm;?>" >
   			<?php echo $data->provider->instnm; ?></a>
           	</span> 
           	<br />
         	<?php 
             if ((string)$data->provider->addr !== 'NULL'  AND trim((string)$data->provider->addr) !== '' )  echo $data->provider->addr.'<br />'; 
             if ((string)$data->provider->city !== 'NULL'  AND trim((string)$data->provider->city) !== '' ) echo $data->provider->city; 
             if ((string)$data->stabbr !== 'NULL' ) {
             	if ((string)$data->provider->city !== 'NULL' AND trim((string)$data->provider->city) !== '' )  echo ', '; 
             	echo $data->provider->stabbr; 
             }
             if ((string)$data->provider->zip !== 'NULL' AND trim((string)$data->provider->zip) !== '' )  echo ' '. $data->provider->zip;
             echo '<br />';
             if ((string)$data->provider->gentele !== 'NULL' AND trim((string)$data->provider->gentele) !== '' ) echo ' '. vcn_format_phone( $data->provider->gentele ).'<br />';

           	 if ((string)$data->provider->admnurl !== 'NULL' AND trim((string)$data->provider->admnurl) != '')
           	 {
           	 	$appurl = substr_compare( 'http',(string)$data->provider->admnurl,0,4,true) ? 'http://'. (string)$data->provider->admnurl : (string)$data->provider->admnurl;
           		echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
           	 }	
           	 if ((string)$data->provider->faidurl !== 'NULL' AND trim((string)$data->provider->faidurl) !== '')  
           	 { 
           		$faidurl = substr_compare( 'http',(string)$data->provider->faidurl,0,4,true) ? 'http://'. (string)$data->provider->faidurl : (string)$data->provider->faidurl;
           	 	echo '<a class="small" target="_blank" href="'.$faidurl.'">Financial Aid</a><br />';
           	 }
           	 
           	 echo '<p><strong>Accredited By:</strong><br />';
           	 if (!(array)$data->courseaccreditor) 
           	 {
           	 	echo "No accreditation information available.";
           	 }
           	 else 
           	 {
		         foreach ($data->courseaccreditor->item as $accreditor)
		         {
	 
		         	if ((string)$accreditor->accreditor->websiteurl !== 'NULL' AND trim((string)$accreditor->accreditor->websiteurl) != '')
		           	 {
		           	 	$appurl = substr_compare( 'http',(string)$accreditor->accreditor->websiteurl,0,4,true) ? 'http://'. (string)$accreditor->accreditor->websiteurl : $accreditor->accreditor->websiteurl;
		           		echo '<a class="small" target="_blank" href="'.$appurl.'">' . $accreditor->accreditor->name . '</a><br />';
		           	 }	
				 	 else 
				 	 {
				 		echo $accreditor->accreditor->name;
				 	 } 
				 	
				 	 echo '</p>';
	      	 	}
           	 }  

           	echo '<p>';
           	?>
<?php endif; ?>
		<h3>More Information</h3>

		<?php 
		echo '<p>';
  			if ((string)$data->courseinfourl !== 'NULL' AND trim((string)$data->courseinfourl) !== '')  
			{ 
				$dataurl = substr_compare( 'http',(string)$data->courseinfourl,0,4,true) ? 'http://'. (string)$data->courseinfourl : (string)$data->courseinfourl;
				echo '<a  target="_blank" href="'.$dataurl.'">More Info</a><br />';
			}
			           	 	  			
			if ((string)$data->onlinecourseurl !== 'NULL' AND trim((string)$data->onlinecourseurl !== '') ) 
			{
 				if ((string)$data->coursedeliverymode->name == 'VCN')
				{
		 			$target =  '_self';
					$ocourseurl =  base_path().(string)$data->onlinecourseurl;
				}
				else 
				{
					$target =  '_blank';
			    	$ocourseurl = substr_compare( 'http',(string)$data->onlinecourseurl,0,4,true) ? 'http://'. (string)$data->onlinecourseurl : (string)$data->onlinecourseurl;
				}
			 	//echo '<a  target="'.$target.'" href="http://' .$_SERVER['SERVER_NAME'].$ocourseurl.'">Take Online</a><br />';
			 	echo '<a  target="'.$target.'" href="'.hvcp_moodle_server().$ocourseurl.'">Take Online</a><br />';         	
			} 
			echo '<a onclick="$(\'#subject_area\').val('.$data->subjectarea.'); return backToResults(\'course_id\')" href="'.base_path().'find-learning/results/courses">Find Similar Courses in your area</a>';
			echo '</p>';
    		?>
		</div>
	
		<div class="training-detail-right gray">
		<p>
	      	<?php 
	      	 if ((string)$data->totalcredits !== 'NULL' AND trim((string)$data->totalcredits) !== '') {
		      	 echo '<p><strong>Total Credits:</strong><br />';
	       		 echo $data->totalcredits .'</p>';
	      	 }  
	      	 if ((string)$data->subject->description !== 'NULL' AND trim((string)$data->subject->description) !== '') {
		      	 echo '<p><strong>Subject Area:</strong><br />';
	       		 echo $data->subject->description .'</p>';
	      	 }  
	    	 if ((string)$data->language->name !== 'NULL' AND trim((string)$data->language->name) !== '') {
		      	 echo '<p><strong>Language Name:</strong><br />';
	       		 echo $data->language->name .'</p>';
	      	 }  	
	      	 if ((string)$type->description !== 'NULL' AND trim((string)$type->description) !== '') {
		      	 echo '<p><strong>Course Type:</strong><br />';
	       		 echo $type->description .'</p>';
	      	 }  
	      	 if ((array)$data->accessibility !== 'NULL' AND trim((array)$data->accessibility !== '') )
	      	 {
		      	 echo '<p><strong>Accessibility:</strong><br />';
		      	 foreach ($data->accessibility->item as $access)
		      	 {
	       		 	echo $access->access->description . '<br />';
		      	 }
	       		 echo '</p>';
	      	 }  		

	      	 if ((string)$data->coursedeliverymode->description !== 'NULL' AND trim((string)$data->coursedeliverymode->description !== 'NULL')  ) {
		      	 echo '<p><strong>Delivery:</strong><br />';
	       		 echo  $data->coursedeliverymode->description .'</p>';
	      	 }  	 
	      	 if ((string)$data->othercost !== 'NULL' AND trim((string)$data->othercost) !== '') {
		      	 echo '<p><strong>Other Cost:</strong><br />';
	       		 echo '$'.$data->othercost .'</p>';
	      	 }  	

	      	 ?>
		</div>
		
		
		<div id="training-detail-details">
		
			<h3>Keywords</h3>
			<p>Click on any keyword below to find other similar courses.</p>
			
			<?php 
				 if ((array)$data->keywords !== 'NULL' AND trim((array)$data->keywords !== '') )
			   	 {
			   	 	$sep = '';
					foreach ($data->keywords->item as $keywords)
				  	{
				  		echo $sep.'<a alt="' . $keywords->keyword->keyword . '"'
				  		    .' href="'.base_path().'find-learning/results/courses/keyword/' . $keywords->keyword->keyword . '">'
				  		    . $keywords->keyword->keyword  .'</a>';
			       		$sep = ', ';
				  	}
			 	} 
			 	else 
			 	{
			 		echo "No keywords";
			 	}
			?>
			
			
 
		</div>
		
	</div>	
	
	<?php

global $user;

$logged_in = $user->uid;

$cma->usersession =  $logged_in ? 'U' : 'S';

?>

	
	<div id="training-sidebar" class="panel-2col panel-col-last" style="margin-left:766px; position: absolute;">
	    <a class="save-to-notebook large<?php if ($user->uid=='U') echo 'u'; ?>" alt="Save this course" title="Save this course"  onclick="not_logged_in('<?php echo $cma->usersession; ?>','Course Saved temporarily in your wish list');return vcn_saveOrTargetToCMA (this,'courses', 'course_id', '<?php echo $data->courseid; ?>');"   href="<?php echo base_path(); ?>cma/notebook/save/course/<?php echo $data->courseid; ?>"> </a>
<!-- 
	    <a class="target-to-notebook large" alt="Target this course" title="Target this course"  onclick="return vcn_saveOrTargetToCMA (this,'courses', 'course_id', '<?php echo $data->courseid; ?>');"   href="<?php echo base_path(); ?>cma/notebook/target/course/<?php echo $data->courseid; ?>"> </a>
    	<a class="in-my-neighborhood" alt="Show programs in my neighborhood" onclick="return filterTraining();" href=""> </a>
    	<br /><br />
-->    
		<?php echo $content['sidebar']; ?>
 	</div>	
			
<?php endif; ?>