<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
     // var check
   	$vars  = isset($vars) ? $vars : array() ;
	$hide_search  = ( array_key_exists('hide_search', $vars) AND $vars['hide_search']) ? true : false ;
	$laytitles = $data['laytitles'];
	$vars['distance'] = ($vars AND array_key_exists('distance',$vars)) ? $vars['distance'] : 100;
	$cma = $vars['cma'];


 ?>
<style>

select.wide {
	width: 222px; /* Or whatever width you want. */
}
select.expand {
	width: auto;
}

</style>
	<script type="text/javascript">

		$(document).ready(function() {
			if (document.getElementById('fawlevel'))
				document.getElementById('awlevel').value = document.getElementById('fawlevel').value;

			if (document.getElementById('fdistance'))
				document.getElementById('distance').value = document.getElementById('fdistance').value;

			if (document.getElementById('fzip'))
				document.getElementById('zip').value = document.getElementById('fzip').value;

			if (document.getElementById('fstfips'))
				document.getElementById('stfips').value = document.getElementById('fstfips').value;
				
		 if ($.browser.msie) $('select.wide')
			.bind('focus mouseover', function() { $(this).addClass('expand').removeClass('clicked'); })
			.bind('click', function() { $(this).toggleClass('clicked');  })
			.bind('mouseout', function() { if (!$(this).hasClass('clicked')) { $(this).removeClass('expand'); }})
			.bind('blur', function() { $(this).removeClass('expand clicked'); });
			
			$('select.wide').change(function() { $(this).removeClass('expand');	});					
		});

		var cma = <?php echo json_encode($cma); ?>;


		function numericonly(evt) {

			var key = (evt.which) ? evt.which : event.keyCode;

			if (key!=45 && key > 31 && (key < 48 || key > 57))
				return false;



			return true;

			//	return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key == 8) || (key == 9) || (key == 109) || (key == 189));
		}

		function caction(value) {

			if (document.getElementById('fawlevel'))
				var awlevel = document.getElementById('fawlevel').value;
			else
				var awlevel = document.getElementById('awlevel').value;

			if (document.getElementById('fdistance'))
				var distance = document.getElementById('fdistance').value;
			else
				var distance = document.getElementById('distance').value;

			if (document.getElementById('fzip'))
				var zip = document.getElementById('fzip').value;
			else
				var zip = document.getElementById('zip').value;

			if (!zip)
				var zip = 'Zip code';

var zipvalueinoccupationdetail = zip;

$('#zipod').load('/careerladder/zipvalidation.php?zipcode='+zipvalueinoccupationdetail, function() {
                  var zval = document.getElementById("zipod").innerHTML;
				  var isl = "<?php echo $vars['type']; ?>";
				// alert(awlevel);
                  if(zval == 'true' || isl=='licenses' || zip=='Zip code'){

						if (value==1 || zip=='Zip code') {
							var url = "<?php echo base_path(); ?>find-learning/results/<?php echo $vars['type']; ?>/onetcode/<?php echo $vars['onetcode']; ?>/zip/"+zip+"/distance/"+distance;

							if (document.getElementById('fstfips'))
								url+="/stfips/"+document.getElementById('fstfips').value;

							if (awlevel>0)
								url+="/awlevel/"+awlevel;

							//document.trainingform.action = url;
							//document.forms["trainingform"].submit();
							window.open(url,'_self');

						} else {
							return false;
						}

                          }
              else
                          {
							if (value!=1)
								return false;

							$("#fzip").addClass("redborder");
							alert('Please enter a valid US ZIP Code');
							document.searchform.fzip.focus();
                            return false;
                          }
            });

		}

	</script>
<div id="training-search" >
<form id="training-form" name="trainingform" method="post" autocomplete="off"  action="javascript:void(0);" onsubmit="caction('1'); return filterTraining(this);" >
<input type="hidden" id="onetcode" name="onetcode" value="<?php echo $vars['onetcode']; ?>" />
<input type="hidden" id="target_onetcode" name="target_onetcode" value="<?php echo $vars['target_onetcode']; ?>" />
<input type="hidden" id="type" name="type" value="<?php echo $vars['type']; ?>" />
<input type="hidden" id="occupation-title" name="occupation-title" value="<?php echo $vars['occupation-title']; ?>" />
<input type="hidden" id="target_occupation-title" name="target_occupation-title" value="<?php echo $vars['target_occupation-title']; ?>" />

<input type="hidden" id="limit" name="limit" value="<?php echo $vars['limit']; ?>" />
<input type="hidden" id="pg" name="pg" value="<?php echo $vars['pg']; ?>" />
<input type="hidden" id="order" name="order" value="<?php echo $vars['order']; ?>" />
<input type="hidden" id="direction" name="direction" value="<?php echo $vars['direction']; ?>" />

<input type="hidden" id="count_programs" name="count_programs" value="<?php echo $vars['count_programs']; ?>" />
<input type="hidden" id="order_programs" name="order_programs" value="<?php echo $vars['order_programs']; ?>" />
<input type="hidden" id="direction_programs" name="direction_programs" value="<?php echo $vars['direction_programs']; ?>" />
<input type="hidden" id="limit_programs" name="limit_programs" value="<?php echo $vars['limit_programs']; ?>" />
<input type="hidden" id="pg_programs" name="pg_programs" value="<?php echo $vars['pg_programs']; ?>" />
<input type="hidden" id="program_id"  name="program_id" value="<?php echo $vars['program_id']; ?>" />
<input type="hidden" id="unitid"  name="unitid" value="<?php echo $vars['unitid']; ?>" />
<input type="hidden" id="cipcode" name="cipcode" value="<?php echo $vars['cipcode']; ?>" />
<input type="hidden" id="awlevel" name="awlevel" value="<?php if (is_int($vars['awlevel'])) echo $vars['awlevel']; ?>" />
<input type="hidden" id="hbcu" name="hbcu" value="<?php echo $vars['hbcu']; ?>" />
<input type="hidden" id="distance" name="distance" value="<?php echo $vars['distance']; ?>" />
<input type="hidden" id="zip" name="zip" value="<?php echo $vars['zip']; ?>" />

<input type="hidden" id="count_certifications" name="count_certifications" value="<?php echo $vars['count_certifications']; ?>" />
<input type="hidden" id="order_certifications" name="order_certifications" value="<?php echo $vars['order_certifications']; ?>" />
<input type="hidden" id="direction_certifications" name="direction_certifications" value="<?php echo $vars['direction_certifications']; ?>" />
<input type="hidden" id="limit_certifications" name="limit_certifications" value="<?php echo $vars['limit_certifications']; ?>" />
<input type="hidden" id="pg_certifications" name="pg_certifications" value="<?php echo $vars['pg_certifications']; ?>" />
<input type="hidden" id="cert_id"  name="cert_id" value="<?php echo $vars['cert_id']; ?>" />
<input type="hidden" id="org_id" name="org_id" value="<?php echo $vars['org_id']; ?>" />

<input type="hidden" id="count_licenses" name="count_licenses" value="<?php echo $vars['count_licenses']; ?>" />
<input type="hidden" id="order_licenses" name="order_licenses" value="<?php echo $vars['order_licenses']; ?>" />
<input type="hidden" id="direction_licenses" name="direction_licenses" value="<?php echo $vars['direction_licenses']; ?>" />
<input type="hidden" id="limit_licenses" name="limit_licenses" value="<?php echo $vars['limit_licenses']; ?>" />
<input type="hidden" id="pg_licenses" name="pg_licenses" value="<?php echo $vars['pg_licenses']; ?>" />
<input type="hidden" id="stfips" name="stfips" value="<?php echo $vars['stfips']; ?>" />
<input type="hidden" id="licenseid" name="licenseid" value="<?php echo $vars['licenseid']; ?>" />
<input type="hidden" id="soconetcod" name="soconetcod" value="<?php echo $vars['soconetcod']; ?>" />

<input type="hidden" id="count_courses" name="count_courses" value="<?php echo $vars['count_courses']; ?>" />
<input type="hidden" id="order_courses" name="order_courses" value="<?php echo $vars['order_courses']; ?>" />
<input type="hidden" id="direction_courses" name="direction_courses" value="<?php echo $vars['direction_courses']; ?>" />
<input type="hidden" id="limit_courses" name="limit_courses" value="<?php echo $vars['limit_courses']; ?>" />
<input type="hidden" id="pg_courses" name="pg_courses" value="<?php echo $vars['pg_courses']; ?>" />
<input type="hidden" id="course_id" name="course_id" value="<?php echo $vars['course_id']; ?>" />
<input type="hidden" id="subject_area"  name="subject_area" value="<?php echo $vars['subject_area']; ?>" />
<input type="hidden" id="course_type"  name="course_type" value="<?php echo $vars['course_type']; ?>" />


<input type="hidden" id="count_vhs" name="count_vhs" value="<?php echo $vars['count_vhs']; ?>" />
<input type="hidden" id="order_vhs" name="order_vhs" value="<?php echo $vars['order_vhs']; ?>" />
<input type="hidden" id="direction_vhs" name="direction_vhs" value="<?php echo $vars['direction_vhs']; ?>" />
<input type="hidden" id="limit_vhs" name="limit_vhs" value="<?php echo $vars['limit_vhs']; ?>" />
<input type="hidden" id="pg_vhs" name="pg_vhs" value="<?php echo $vars['pg_vhs']; ?>" />
<input type="hidden" id="stabbr" name="stabbr" value="<?php echo $vars['stabbr']; ?>" />
 				 	<input id="keycount" name="keycount" type="hidden" value="-1" />

<?php /***************** RESULT FILTERS START HERE **********************************/ ?>
<?php if (!$hide_search ) : ?>
<?php if (!$vars['onetcode'] AND in_array($vars['type'], array('programs','certifications','licenses' ) )) :?>
 	<div class="training-filters">
 		<p class="training-search-label"><label class="training-search-label" for="fjobtitle">Find <?php echo vcn_key_labels($vars['type']); ?> by career</label></p>
 	 	<div id="suggest" class="fhc rndcrnr">
	 	 	<div class="suggestionsBox" id="suggestions" style="display: none;">
				<div class="suggestionList" id="suggestionsList">
 					<select id="suggestions" size="10" onclick="alert(this.value);"></select>
				</div>
			</div>
			<input id="fjobtitle" name="fjobtitle" autocomplete="off" onclick="this.value='';" onkeyup="$('#occupation-title').val(this.value); return suggest(this.value, event);  " size="25" type="text" value="" />&nbsp;
			<input id="Search" name="Search" type="submit" value="Search"  />

		</div>
	</div>
	<script>
		var laytitles   = <?php echo json_encode($laytitles); ?>;
	</script>
<?php endif; ?>


<?php if ($vars['type'] == 'programs') :?>
	<div class="training-filters">
		<p class="training-search-label"><label for="fawlevel">Award Level</label></p>
		<div id="filter-program-length" class="fhc rndcrnr">
			<select id="fawlevel" name="fawlevel" class="wide" style="height:22px;">
			
				<?php 
				$includes = drupal_get_path('module','vcn').'/includes';

				require_once($includes . '/vcn_common.inc');

				$catlist = vcn_get_data($errors, $vars, $valid,'occupationsvc','category','list');


				?>			
				<?php if (isset($vars['awlevel'][1])): ?>
					<?php if ($vars['awlevel'][0]=="1" && $vars['awlevel'][1]=="2" && $vars['awlevel'][2]=="3"): ?>
						<option value='' selected="selected">All</option>
					<?php else: ?>
						<option value=''>All</option>
					<?php endif; ?>

				<?php else: ?>
					<option value=''>All</option>
				<?php endif; ?>

				<?php $catcount=-1; foreach ($catlist->category as $k=>$v): $catcount++;  if ($catlist->category[$catcount]->educationcategoryid<4) continue; 
				$selected = (array_key_exists('awlevel',$vars) && trim($vars['awlevel'] == $catlist->category[$catcount]->educationcategoryid)  ) ? 'selected="selected"' : false;
				?>				
				<option value="<?php echo $catlist->category[$catcount]->educationcategoryid; ?>" <?php echo $selected; ?>><?php echo $catlist->category[$catcount]->educationcategoryname; ?></option>
				<?php endforeach; ?>				
				<?php
				/*
			   		$awlevel_array = array(124=>'Certificate',3=>'Associate\'s Degree(2 year)',5=>'Bachelor\'s Degree(4 year)',7=>'Master\'s Degree');
			    	foreach ($awlevel_array AS $key=>$value) {
			    		$selected = (array_key_exists('awlevel',$vars) && trim($vars['awlevel'] == $key)  ) ? 'selected="selected"' : false;

						if (isset($vars['awlevel'][1])) {
							if ($vars['awlevel'][0]=="1" && $vars['awlevel'][1]=="2" && $vars['awlevel'][2]=="4" && $value=="Certificate")
								$selected = 'selected="selected"';
							else
								$selected = '';
						}

			 			echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
			    	}
				*/
			   ?>
			</select>

		</div>
	</div>
<?php endif; ?>


<?php if ( in_array($vars['type'], array('programs')) OR $vars['type'] == false) :?>
	<div class="training-filters">
		<p class="training-search-label">Location</p>
		<div id="filter-location" class="fhc gray rndcrnr">
			<label for="fdistance" class="training-search-label">Within&nbsp;</label>
 			<select id="fdistance" name="fdistance">
	 		<?php
				$distance_array = array('5','15','25','50','100','250','500');
				foreach ($distance_array AS $key) {
					$selected = (array_key_exists('distance',$vars) && trim($vars['distance'] == $key ) ) ? 'selected="selected"' : false;
					echo '<option value="'.$key.'" '.$selected.'>'.$key.' miles</option>';
				}
			?>
	 		</select>
	 		<label for="fzip" class="training-search-label">&nbsp;of</label>
	 		<input type="text" name="fzip" id="fzip" size="8" onclick="if (this.value=='Zip code') this.value='';" onkeypress="return numericonly(event);" maxlength="5" value="<?php if (!$vars['zip'] || $vars['zip']>99999 || strlen($vars['zip'])!=5) $vars['zip']='Zip code'; echo $vars['zip']; ?>" />
		</div>
	</div>

	<input type="image" title="Go" alt="Go" style="position:relative; top:26px;" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/getting_started/images/go.png">
<?php endif; ?>



<?php if ($vars['type'] == 'licenses' ) :?>
	<div class="training-filters">
 		<p class="training-search-label"><label for="fstfips">Select State</label></p>
		<div id="filter-state" class="fhc rndcrnr">
			<select id="fstfips" name="fstfips">
				<?php
					$states_array = array('vcn-no-filter'=>'All States','01'=>'Alabama','02'=>'Alaska','04'=>'Arizona','05'=>'Arkansas','06'=>'California','08'=>'Colorado','09'=>'Connecticut','10'=>'Delaware','11'=>'District of Columbia','12'=>'Florida','13'=>'Georgia','15'=>'Hawaii','16'=>'Idaho','17'=>'Illinois','18'=>'Indiana','19'=>'Iowa','20'=>'Kansas','21'=>'Kentucky','22'=>'Louisiana','23'=>'Maine','24'=>'Maryland','25'=>'Massachusetts','26'=>'Michigan','27'=>'Minnesota','28'=>'Mississippi','29'=>'Missouri','30'=>'Montana','31'=>'Nebraska','32'=>'Nevada','33'=>'New Hampshire','34'=>'New Jersey','35'=>'New Mexico','36'=>'New York','37'=>'North Carolina','38'=>'North Dakota','39'=>'Ohio','40'=>'Oklahoma','41'=>'Oregon','42'=>'Pennsylvania','44'=>'Rhode Island','45'=>'South Carolina','46'=>'South Dakota','47'=>'Tennessee','48'=>'Texas','49'=>'Utah','50'=>'Vermont','51'=>'Virginia','53'=>'Washington','54'=>'West Virginia','55'=>'Wisconsin','56'=>'Wyoming','60'=>'American Samoa','66'=>'Guam','69'=>'Northern Mariana Islands','72'=>'Puerto Rico','78'=>'Virgin Islands');
	 				foreach ($states_array AS $key=>$value) {
						$selected = (array_key_exists('stfips',$vars) && trim($vars['stfips'] == $key ) ) ? 'selected="selected"' : false;
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				?>
				<option value=''></option>

	 		</select>
	 		<input type="image" alt="Go" style="vertical-align:middle;" src="<?php echo base_path()."sites/all/modules/custom/vcn/getting_started/images/go.png"; ?>" value="Go" />
 		</div>
	</div>
<?php endif; ?>


<?php if ($vars['type'] == 'vhs' ) :?>
	<div class="training-filters">
		<p class="training-search-label"><label for="fstabbr">Select State</label></p>
		<div id="filter-state" class="fhc rndcrnr">
			<select id="fstabbr" name="fstabbr" onchange="$('#stabbr').val(this.value);">
				<option value=''>All States</option>
				<?php
					$states_array = array('AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut',
					'DE'=>'Delaware','DC'=>'District of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois',
					'IN'=>'Indiana','IO'=>'Iowa','KS'=>'Kansas','KT'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts',
					'MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana',
					'NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey',
					'NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota',
					'OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island',
					'SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas',
					'UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia',
					'WI'=>'Wisconsin','WY'=>'Wyoming' );
 	 				foreach ($states_array AS $key=>$value) {
						$selected = (array_key_exists('stabbr',$vars) && trim($vars['stabbr'] == $key ) ) ? 'selected="selected"' : false;
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
 				?>
	 		</select>
	 		<input type="submit" value="Go" />
 		</div>
	</div>
 <?php endif; ?>



<?php if ($vars['type'] == 'courses' AND 0) : //turn this off?>
  	<div class="training-filters">
 		<p class="training-search-label"><label for="fsubject_area">Subject Area</label></p>
		<div id="filter-subject_area" class="fhc rndcrnr">
			<select id="fsubject_area" name="fsubject_area" onchange="$('#subject_area').val(this.value);">
				<option value=''>All Subjects</option>
				<?php
  	 				$subject_area_array = vcn_get_subject_area();
 					foreach ($subject_area_array AS $key=>$value) {
						$selected = (array_key_exists('subject_area',$vars) && strtolower(trim($vars['subject_area']) == strtolower($key) ) ) ? 'selected="selected"' : false;
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}

				?>
 			</select>
 			<input type="submit" value="Go" />

		</div>
	</div>
<?php endif; ?>

<?php endif; /* end show form */ ?>
</div>
</form>


<div style="display: none;" id="zipod">


</div>