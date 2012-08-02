<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
/*
 * Common Core Functions
 */
	
  /*
   * include common css and js
   */
	$vcn_path = drupal_get_path('module','vcn');
 	drupal_add_css($vcn_path.'/css/vcn.css', 'module','all');
 	drupal_add_js ($vcn_path. '/js/vcn.js');

	/*
	 * get valid arguments for rest calls
	 * @args module $type $key
	 * 
	 */

	function vcn_include_module_common($module)
	{
		$includes  = drupal_get_path('module','vcn_'.$module).'/includes';
 		if (file_exist($includes .'/vcn_'.$module.'_common.inc'))
		require_once($includes .'/vcn_'.$module.'_common.inc');
  	}
	
	/*
	 * get valid arguments for rest calls
	 * @args module $type $key
	 * 
	 */

	function vcn_get_valid ($type=false, $key=false, $module=false) 
	{
		$valid = array();
		if ($key) 
		{
			$valid['occupations']    = array('onetcode'=>'key');
  		  	$valid['programs']       = array('program_id'=>'key','onetcode'=>'valid','zip'=>'valid','distance'=>'valid','unitid'=>'valid','cipcode'=>'valid','awlevel'=>'valid','hbcu'=>'valid','aacc_yn'=>'valid','vhs_yn'=>'valid','type_ecb'=>'valid');
		 	$valid['certifications'] = array('cert_id'=>'key','onetcode'=>'valid','org_id'=>'valid');
		 	$valid['licenses']  = array('licenseid'=>'key','onetcode'=>'valid','stfips'=>'valid','soconetcod'=>'valid','zip'=>'valid');	
  			$valid['courses']   = array('course_id'=>'key','program_id'=>'valid','cipcode'=>'valid','course_code'=>'valid','unitid'=>'valid','language_code'=>'valid', 'base_course_id'=>'valid','subject_area'=>'valid','course_type'=>'valid','delivery_mode'=>'valid', 'keyword'=>'valid' );
  			$valid['vhs']       = array('provider_id'=>'key','stabbr'=>'valid');
  			$valid['tests']     = array('program_id'=>'key','unitid'=>'key');
  			$valid['providers'] = array('unitid'=>'key','city'=>'valid','stabbr'=>'valid','zip'=>'valid',
								  		'fips'=>'valid','obereg'=>'valid','ein'=>'valid','duns'=>'valid',
								  		'opeid'=>'valid','opeflag'=>'valid','sector'=>'valid','iclevel'=>'valid',
								  		'control'=>'valid','hloffer'=>'valid','ugoffer'=>'valid','groffer'=>'valid',
								  		'fpoffer'=>'valid','hdeoffr'=>'valid','deggrant'=>'valid','hbcu'=>'valid',
								  		'hospital'=>'valid','medical'=>'valid','tribal'=>'valid','locale'=>'valid',
								  		'openpubl'=>'valid','act'=>'valid','newid'=>'valid','deathyr'=>'valid',
								  		'closedat'=>'valid','cyactive'=>'valid','postsec'=>'pseflag','pset4flg'=>'valid',
								  		'rptmath'=>'valid','instcat'=>'valid','ccbasic'=>'valid','ccipug'=>'valid',
								  		'ccipgrad'=>'valid','ccugprof'=>'valid','ccenrprf'=>'valid','ccsizset'=>'valid',
								  		'carnegie'=>'valid','tenursys'=>'valid','landgrant'=>'valid','instsize'=>'valid',
								  		'cbsa'=>'valid','csa'=>'valid','necta'=>'valid','dfrcgid'=>'valid',
								  		'latitude'=>'valid','longitude'=>'valid','countycd'=>'valid','cngdstcd'=>'valid',
								  		'source'=>'valid','verified_yn'=>'valid','verified_by'=>'valid','ipeds_yn'=>'valid',
								  		'aacc_yn'=>'valid','vhs_yn'=>'valid','type_ecb'=>'valid','created_by'=>'valid',
								  		'updated_by'=>'valid','created_time'=>'valid','updated_time'=>'valid');
 		}
		else 
		{
			$valid['occupations']    = array('onetcode'=>'valid');
		  	$valid['programs'] = array('program_id'=>'valid','onetcode'=>'valid','zip'=>'valid','distance'=>'valid','unitid'=>'valid','cipcode'=>'valid','awlevel'=>'valid','hbcu'=>'valid','type_ecb'=>'valid');
			$valid['certifications'] = array('cert_id'=>'valid','onetcode'=>'valid','org_id'=>'valid');
		 	$valid['licenses'] = array('licenseid'=>'valid','onetcode'=>'valid','stfips'=>'valid','soconetcod'=>'valid','zip'=>'valid');	
  			$valid['courses'] = array('course_id'=>'valid','program_id'=>'valid','cipcode'=>'valid','course_code'=>'valid','unitid'=>'valid','language_code'=>'valid', 'base_course_id'=>'valid','subject_area'=>'valid','course_type'=>'valid','delivery_mode'=>'valid', 'keyword'=>'valid' );
  			$valid['vhs'] = array('provider_id'=>'valid','stabbr'=>'valid','zip'=>'valid','distance'=>'valid');
  			$valid['tests'] = array('program_id'=>'valid','unitid'=>'valid');
  			$valid['providers'] = array('unitid'=>'valid','city'=>'valid','stabbr'=>'valid','zip'=>'valid',
								  		'fips'=>'valid','obereg'=>'valid','ein'=>'valid','duns'=>'valid',
								  		'opeid'=>'valid','opeflag'=>'valid','sector'=>'valid','iclevel'=>'valid',
								  		'control'=>'valid','hloffer'=>'valid','ugoffer'=>'valid','groffer'=>'valid',
								  		'fpoffer'=>'valid','hdeoffr'=>'valid','deggrant'=>'valid','hbcu'=>'valid',
								  		'hospital'=>'valid','medical'=>'valid','tribal'=>'valid','locale'=>'valid',
								  		'openpubl'=>'valid','act'=>'valid','newid'=>'valid','deathyr'=>'valid',
								  		'closedat'=>'valid','cyactive'=>'valid','postsec'=>'pseflag','pset4flg'=>'valid',
								  		'rptmath'=>'valid','instcat'=>'valid','ccbasic'=>'valid','ccipug'=>'valid',
								  		'ccipgrad'=>'valid','ccugprof'=>'valid','ccenrprf'=>'valid','ccsizset'=>'valid',
								  		'carnegie'=>'valid','tenursys'=>'valid','landgrant'=>'valid','instsize'=>'valid',
								  		'cbsa'=>'valid','csa'=>'valid','necta'=>'valid','dfrcgid'=>'valid',
								  		'latitude'=>'valid','longitude'=>'valid','countycd'=>'valid','cngdstcd'=>'valid',
								  		'source'=>'valid','verified_yn'=>'valid','verified_by'=>'valid','ipeds_yn'=>'valid',
								  		'aacc_yn'=>'valid','vhs_yn'=>'valid','type_ecb'=>'valid','created_by'=>'valid',
								  		'updated_by'=>'valid','created_time'=>'valid','updated_time'=>'valid');
  			
		}
  		if ($type)
 			return $valid[$type];
 		else	
 			return $valid;
	}
	
 	function vcn_get_vars_post (&$vars, $post)
	{
 		if (!$post) return $vars;
 		foreach ($post as $key => $value) {
 			$key = strtolower(trim($key));
 	   	 	if ( $key ) $vars[$key] = $value;
 		}
 		return $vars;
 	}
  	
	function vcn_get_vars_get (&$vars, $get)
	{
 		if (!$get) return $vars;
		foreach ($get as $key => $value) {
 			$key = strtolower(trim($key));
 		 	if ( $key ) $vars[$key] = $value;
  		}
  		return $vars;
 	} 	
 
	function vcn_get_vars_arg (&$vars, $args)
	{
		if (!$args) return $vars;
		for ($i=3; $i < sizeof($args)+1; $i++) {
			$key = strtolower(trim($args[$i]));
 			if ( $key ) $vars[$key] = $args[++$i];
	  	} 	
 	  	return $vars;
	}
	

	function vcn_get_vars_set (&$vars = array(), $module=false)
	{
		$vars['cma']= vcnCma::getInstance();
	  
		if (!$_POST) {
			// set some defaults
			$vars['stabbr']   = (array_key_exists('stabbr', $vars) AND $vars['stabbr']) ? $vars['stabbr'] : $vars['cma']->state;
			$vars['zip']      = (array_key_exists('zip', $vars) AND $vars['zip']) ? $vars['zip'] : $vars['cma']->zipcode;
			$vars['distance'] = (array_key_exists('distance', $vars) AND $vars['distance']) ? $vars['distance'] : 100;
	 	}
		
		// GET GETTING STARTED USER KEYS
		if ($module)
		{
			$key_category = strtoupper(str_replace('_','', $module));
	 		$result = $vars['cma']->getUserKeyList(array('key_category'=>$key_category));
			if (!empty($result->cma)) {
	  		   foreach ($result->cma AS $userkey) 
			   {
		 		   $key   = (string) $userkey->keyname;
		 		   $value = (string) $userkey->keyvalue;
		  		   $vars[$key_category][$key] = $value ;
		 	   }	
			}
		}
		
		// set targets
		$result = $vars['cma']->getNotebookTargetList();
		if (!empty($result->cma)) {
			foreach ($result->cma AS $target)
			{
				switch (strtolower($target->itemtype))
				{
					case 'occupation':
						$vars['target_onetcode']         = (string)$target->occupation->item->onetcode;
						$vars['target_occupation-title'] = (string)$target->occupation->item->displaytitle;
					break;
					case 'program':
						$vars['target_program_id']       = (string)$target->program->item->programid;
						//TODO STFIPS BEING USED FOR CIPCODE
						$vars['target_program_cipcode']  = (string)$target->stfips;
						$vars['target_programname']      = ((string)$target->program->item->programname) ? 
						                                    (string)$target->program->item->programname : 		(string)$target->program->item->programcipcode->item->cipcodedetail->ciptitle;	
						break;
					case 'certificate':
						$vars['target_cert_id']  = (string)$target->certification->item->certid;
						$vars['target_certname'] = (string)$target->certification->item->certname;
						break;
					case 'license':
						$vars['target_licenseid']   = (string)$target->license->item->licenseid;
						$vars['target_stfips']      = (string)$target->license->item->stfips;
						$vars['target_licensename'] = (string)$target->license->item->lictitle;
						break;
	 			    case 'vhs':
						break;
	 			        default:
	 		    }	 
	 	    }		
		}
 	 	return $vars;
	}
 	 
	function vcn_format_phone ($number)
	{
		$number = preg_replace('/[^\d]/', '', $number);
		switch (strlen($number))
		{
			case '7':
				return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $number);
			break;
			case '10':
				return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $number);
			break;
			default:
				return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4}) ([0-9])/", "($1) $2-$3 $4", $number);
				
		}
		return false;
	}
	
	
	function vcn_sanity_check ( &$errors, $vars, $valid ) 
	{
   		foreach ($valid as $key=>$type)
		{
			if ($type == 'key')
			{
	 	 		if (!array_key_exists($key,$vars) OR !$vars[$key] ) 
		 		{
 					$errors[] = 'Select a '.vcn_key_labels($key);
					return false;
  				}
			} 
		}
		return true;
	}
	
	function vcn_key_labels ( $key, $case = false)
	{
		$text = '';
		switch ($key)
		{
			case 'program_id':
				$text = 'program';
			break;
 			break;
			case 'cert_id':
				$text = 'certification';
			break;
		 	break;
			case 'licenseid':
				return 'License';
			break;
			case 'vhs':
				$text = 'virtual high school';
			break;
			default:
				$text = $key;
		}
		return  $text ;
	}
	function vcn_get_yes_no ()
	{
		$yes_no_array = array('Y'=>'Yes','N'=>'No',);
		return $states_array;
 	}
	function vcn_get_type_ecb ()
	{
		$type_ecb_array = array('E'=>'E-Learning','C'=>'Classroom','B'=>'Both',);
		return $$type_ecb_array;
 	}
  	function vcn_get_states ()
	{
		$states_array = array('AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IO'=>'Iowa','KS'=>'Kansas','KT'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming' );
		return $states_array;
 	}
	function vcn_get_stfips()
	{
		$stfips_array = array('01'=>'Alabama','02'=>'Alaska','04'=>'Arizona','05'=>'Arkansas','06'=>'California','08'=>'Colorado','09'=>'Connecticut','10'=>'Delaware','11'=>'District of Columbia','12'=>'Florida','13'=>'Georgia','15'=>'Hawaii','16'=>'Idaho','17'=>'Illinois','18'=>'Indiana','19'=>'Iowa','20'=>'Kansas','21'=>'Kentucky','22'=>'Louisiana','23'=>'Maine','24'=>'Maryland','25'=>'Massachusetts','26'=>'Michigan','27'=>'Minnesota','28'=>'Mississippi','29'=>'Missouri','30'=>'Montana','31'=>'Nebraska','32'=>'Nevada','33'=>'New Hampshire','34'=>'New Jersey','35'=>'New Mexico','36'=>'New York','37'=>'North Carolina','38'=>'North Dakota','39'=>'Ohio','40'=>'Oklahoma','41'=>'Oregon','42'=>'Pennsylvania','44'=>'Rhode Island','45'=>'South Carolina','46'=>'South Dakota','47'=>'Tennessee','48'=>'Texas','49'=>'Utah','50'=>'Vermont','51'=>'Virginia','53'=>'Washington','54'=>'West Virginia','55'=>'Wisconsin','56'=>'Wyoming','60'=>'American Samoa','66'=>'Guam','69'=>'Northern Mariana Islands','72'=>'Puerto Rico','78'=>'Virgin Islands');
		return $states_array;
  	}
	function vcn_get_ipeds_lookup($col, $val=false ) {
		$ipeds_array = false;
		switch (strtoupper($col))
		{
			case 'AWLEVEL':
			$ipeds_array=array ('1'=> 'Award of less than 1 academic year',
								'2'=> 'Award of at least 1 but less than 2 academic years',
								'3'=> 'Associate\'s degree',
								'4'=> 'Award of at least 2 but less than 4 academic years',
								'5'=> 'Bachelor\'s degree',
								'6'=> 'Postbaccalaureate certificate',
								'7'=> 'Master\'s degree',
								'8'=> 'Post-master\'s certificate',
								'9'=> 'Doctor\'s degree',
								'10'=> 'First-professional degree',
								'11'=> 'First-professional certificate',
								'17'=> 'Doctor\'s degree - research/scholarship',
								'Doctor\'s degree - professional practice',
								'19'=> 'Doctor\'s degree - other',
							);
 			break;		
			case 'CONTROL':
			$ipeds_array=array ('-3', '{Not available}',
								'1', 'Public',
								'2', 'Private not-for-profit',
								'3', 'Private for-profit',
							);
  			break;
			case 'DEGGRANT':
			$ipeds_array=array ('1'=> 'Degree-granting',
								'2'=> 'Nondegree-granting=> primarily postsecondary',
 							);
 			break;
			case 'GROFFER':
			$ipeds_array=array ('-3'=> '{Not available}',
								'1'=> 'Graduate degree or certificate offering',
								'2'=> 'No graduate offering',
 							);
 			break;
			case 'HBCU':
			$ipeds_array=array ( '1'=> 'Yes',
								'2'=> 'No',
 							);
 			break;
			case 'HDEGOFFR':
			$ipeds_array=array (  '-3'=> '{Not available}',
								'0'=> 'Non-degree granting',
								'11'=> 'Doctor\'s degree - research/scholarship and professional practice',
								'12'=> 'Doctor\'s degree - research/scholarship',
								'13'=> 'Doctor\'s degree - professional practice',
								'14'=> 'Doctor\'s degree - other',
								'20'=> 'Master\'s degree',
								'30'=> 'Bachelor\'s degree',
								'40'=> 'Associate\'s degree',
 							);
 			break;
			case 'HLOFFER':
			$ipeds_array=array ('-3'=> '{Not available}',
								'1'=> 'Award of less than one academic year',
								'2'=> 'At least 1=> but less than 2 academic years',
								'3'=> 'Associate\'s degree',
								'4'=> 'At least 2=> but less than 4 academic years',
								'5'=> 'Bachelor\'s degree',
								'6'=> 'Postbaccalaureate certificate',
								'7'=> 'Master\'s degree',
								'8'=> 'Post-master\'s certificate',
								'9'=> 'Doctor\'s degree',

 							);
 			break;
			case 'ICLEVEL':
			$ipeds_array=array ('-3'=> '{Not available}',
								'1'=> 'Four or more years',
								'2'=> 'At least 2 but less than 4 years',
								'3'=> 'Less than 2 years (below associate)',
 							);
 			break;
			case 'INSTSIZE':
			$ipeds_array=array ('-2'=> 'Not applicable',
								'-1'=> 'Not reported',
								'1'=> 'Under 1=>000',
								'2'=> '1=>000 - 4=>999',
								'3'=> '5=>000 - 9=>999',
								'4'=> '10=>000 - 19=>999',
								'5'=> '20=>000 and above',
 							);
 			break;
			case 'LOCALE':
			$ipeds_array=array ('-3'=> '{Not available}',
								'11'=> 'City: Large',
								'12'=> 'City: Midsize',
								'13'=> 'City: Small',
								'21'=> 'Suburb: Large',
								'22'=> 'Suburb: Midsize',
								'23'=> 'Suburb: Small',
								'31'=> 'Town: Fringe',
								'32'=> 'Town: Distant',
								'33'=> 'Town: Remote',
								'41'=> 'Rural: Fringe',
								'42'=> 'Rural: Distant',
								'43'=> 'Rural: Remote',
 							);
 			break;
			case 'MEDICAL':
			$ipeds_array=array ('-2'=> 'Not applicable',
								'-1'=> 'Not reported',
								'1'=> 'Yes',
								'2'=> 'No',
 							);
 			break;
			case 'OBEREG':
			$ipeds_array=array ('0'=> 'US Service schools',
								'1'=> 'New England',
								'2'=> 'Mid East',
								'3'=> 'Great Lakes',
								'4'=> 'Plains',
								'5'=> 'Southeast',
								'6'=> 'Southwest',
								'7'=> 'Rocky Mountains',
								'8'=> 'Far West',
								'9'=> 'Outlying areas',
 							);
 			break;
			case 'SECTOR':
			$ipeds_array=array ('0'=> 'Administrative Unit',
								'1'=> 'Public=> 4-year or above',
								'2'=> 'Private not-for-profit=> 4-year or above',
								'3'=> 'Private for-profit=> 4-year or above',
								'4'=> 'Public=> 2-year',
								'5'=> 'Private not-for-profit=> 2-year',
								'6'=> 'Private for-profit=> 2-year',
								'7'=> 'Public=> less-than 2-year',
								'8'=> 'Private not-for-profit=> less-than 2-year',
								'9'=> 'Private for-profit=> less-than 2-year',
								'99'=> 'Sector unknown (not active)',
 							);
 			break;
			case 'TRIBAL':
			$ipeds_array=array ('1'=> 'Yes',
								'2'=> 'No',
 							);
 			break;
			case 'UGOFFER':
			$ipeds_array=array ('-3'=> '{Not available}',
								'1'=> 'Undergraduate degree or certificate offering',
								'2'=> 'No undergraduate offering',
 							);
 			break;
 			default:
		}
		
		if ($val)
		{
 			return $ipeds_array[$val];
		}
		else 
		{
			return $ipeds_array;
		}
		return false;
	}
	function vcn_get_laytitles($reset=false, $vars=false)
	{
		// Process if needed
 	 	$result = vcn_get_data ($errors, $vars, array(),'occupationsvc',onetlaytitles,'count' );
        $laytitles_count = (string) $result->count;
 
       	// get the list
 		$result = vcn_get_data ($errors, $vars, array(),'occupationsvc',onetlaytitles,'list', $laytitles_count,'', 'laytitle' );
    	$laytitles = array();
 
	  	foreach ($result->onetlaytitle AS $laytitle)
	  	{
 	  	 	 $title    = (string) $laytitle->laytitle;
	  	 	 $onetcode = (string) $laytitle->newonetcode;
	   		 $laytitles[$title] = $onetcode;
 	  	}
 
 	  	return $laytitles;
  	}	
 
	function vcn_get_base_course($reset=false, $vars=false) {
		$base_course_array = false;
		$valid = vcn_get_valid('courses');
		$vars['base_course_id'] = 'is null';
		$result = vcn_get_data ($errors, $vars, $valid, 'trainingsvc', 'courses', 'list', $limit=false, $offset=false, $order='course_title', $direction='asc', $format='xml', $method='post' ) ;
		foreach ($result->courses AS $row)
		{
 	 		$base_course_array[(string)$row->courseid] = (string)$row->coursename;
 		}
		
		return $base_course_array;
	}
	function vcn_get_course_type($reset=false, $vars=false) {
		$course_type_array = false;
		$valid = false;
	 	$result = vcn_get_data ($errors, $vars, $valid, 'trainingsvc', 'courses', 'list-course-type', $limit=false, $offset=false, $order='description', $direction='asc', $format='xml', $method='post' ) ;
	 	foreach ($result->courses AS $row)
		{
			
 	 		$course_type_array[(string)$row->coursetype] = (string)$row->description;
 		}
	 	return $course_type_array;
 	}
	function vcn_get_subject_area($reset=false, $vars=false) {
		$subject_area_array = false;
		$valid = false;
	 	$result = vcn_get_data ($errors, $vars, $valid, 'trainingsvc', 'courses', 'list-subject-area', $limit=false, $offset=false, $order='description', $direction='asc', $format='xml', $method='post' ) ;
	    
	 	foreach ($result->courses AS $row)
		{
 	 		$subject_area_array[(string)$row->subjectarea] = (string)$row->description;
 		}
 	  	return $subject_area_array;	
	}
	function vcn_get_delivery_mode($reset=false, $vars=false) {
		$delivery_mode_array = false;
		$valid = false;
	 	$result = vcn_get_data ($errors, $vars, $valid, 'trainingsvc', 'courses', 'list-delivery-mode', $limit=false, $offset=false, $order='name', $direction='asc', $format='xml', $method='post' ) ;
 
	 	foreach ($result->courses AS $row)
		{
 	 		$delivery_mode_array[(string)$row->deliverymode] = (string)$row->name;
 		}
	 	
	 	return $delivery_mode_array;	
	}
	function vcn_get_language_code($reset=false, $vars=false) {
		$language_code_array = false;
		$valid = false;
	 	$result = vcn_get_data ($errors, $vars, $valid, 'trainingsvc', 'courses', 'list-language-code', $limit=false, $offset=false, $order='name', $direction='asc', $format='xml', $method='post' ) ;
		 	foreach ($result->courses AS $row)
		{
 	 		$language_code_array[(string)$row->languagecode] = (string)$row->name;
 		}
	 	return $language_code_array;	
	}
	function vcn_get_users($reset=false, $vars=false) {
	}
	function vcn_get_providers($reset=false, $vars=false) {
	}
	function vcn_get_occupations($reset=false, $vars=false, $mintraining = false, $which) {
		if (!$which)
			$which='list';

		$occupations_array = false;
		$valid = vcn_get_valid('occupations');
 		$result = vcn_get_data ($errors, $vars, $valid, 'occupationsvc', 'occupation', $which, $limit=false, $offset=false, $order='display_title', $direction='asc', $format='xml', $method='post' ) ;
 
	 
		if ($mintraining)
		{
		
			foreach ($result->occupation AS $row)
			{
			/*	print_r($row->onetxwalk->eductrainexp->item->educationlevel);
				print '<br /><br />';
				print $row->onetxwalk->eductrainexp->item->educationlevel->awlevelcode;
				exit;
				*/
				//print_r($row); exit;
				
	 			$occupations_array[(string)$row->onetcode]['title'] = (string)$row->displaytitle;
				$occupations_array[(string)$row->onetcode]['awlevel'] = (string)$row->eductrainexp->item->educationlevel->awlevelcode;
				$occupations_array[(string)$row->onetcode]['education'] = (string)$row->typicaltraining->title;
				
				if ($which=='list-short') {
					$occupations_array[(string)$row->onetcode]['awlevel'] = (string)$row->vwoneteducationdistribution->educategory->educationlevel;
					$occupations_array[(string)$row->onetcode]['education'] = (string)$row->vwoneteducationdistribution->educategory->educationcategoryname;

					$occupations_array[(string)$row->onetcode]['minawlevel'] = (string)$row->educategorymin->educationlevel;
					$occupations_array[(string)$row->onetcode]['mineducation'] = (string)$row->educategorymin->educationcategoryname;						
				}
		
 			}
		}
		else 
		{
			foreach ($result->occupation AS $row)
			{
	 			$occupations_array[(string)$row->onetcode] = (string)$row->displaytitle;
 			}
		}
		return $occupations_array;
	}
	
	


	function vcn_get_data (&$errors, &$vars, $valid, $service, $module, $action, $limit=false, $offset=false, $order=false, $direction=false, $format='xml', $method='post' ) 
	{
		$data = false;
		$cma = vcnCma::getInstance();

		if (!$valid) $valid = array();
 		$rest = new vcnWebServices;
  
		$rest->setSecret(hvcp_get_rest_secret()); 
		$rest->setBaseurl(hvcp_get_rest_server()); 
		$rest->setMethod($method);
			
 	 	$rest->setService($service);
		$rest->setModule($module);
 		$rest->setAction($action);
		 	
	  	$rest->setRequestKey('apikey',hvcp_get_rest_apikey());
	  	$rest->setRequestKey('format',$format);
 		$rest->setRequestKey('user_id',$cma->userid); 
 		$rest->setRequestKey('session_id',$cma->usersessionid); 
	  	
	  	
		if ($limit) 	$rest->setRequestKey('limit',$limit);
		if ($offset) 	$rest->setRequestKey('offset',$offset);
		if ($order) 	$rest->setRequestKey('order',$order);
		if ($direction) $rest->setRequestKey('direction',$direction);

		if (isset($vars['education_category_id_less']) && $action!='detail')
			$valid['education_category_id_less'] = 'valid';

		if (isset($vars['education_category_id_less_2']) && $action!='detail')
			$valid['education_category_id_less_2'] = 'valid';
		
		if ($vars)
		{
			foreach ($vars as $key => $value) { if ($value AND array_key_exists($key, $valid) ) {   $rest->setRequestKey($key,$value); } } 
		}
		

		if ($vars['zipcode']>1 && strlen($vars['zipcode'])==5)
			 $rest->setRequestKey('zipcode',$vars['zipcode']);	



		//echo "what: ".$method. " ". $service. " ". $module." ".$action." vcn get data<br/><br/>";
		//print_r($vars); //exit;		

		if ( ($module=='occupation' && $action=='list' && !$vars) ||
			 ($module=='occupation' && $action=='list-short' && !$vars)
			)
		{
			$use_appcache = true;
			$cid = $module."-".$action;
			$cached_content = null;

			//print "OCCUPATIONS LIST: before call to rest data " . udate("H:i:s:u") . "<br />";
			if ($use_appcache) {
			 $cached = cache_get($cid,'cache_content');
			 $ser_content = $cached->data;
			 if (!empty($ser_content)) {
				$cached_content = unserialize($ser_content);
				//print "using cached data for " . $cid . "<br />";
			 }
			}

			if (empty($cached_content)) {
			 $content = $rest->call();
			 if ($use_appcache) {
			   // save data to cache
			   $ser_content = serialize($content);
			   cache_set($cid, $ser_content, 'cache_content', $CACHE_PERMANENT);
			   //print "setting cache for " . $cid . "<br />";
			}
			} else {
			 $content = $cached_content; 
			}		
		} else {
			$content = $rest->call();
		}
		
		$result = new SimpleXMLElement($content);


		
		
  	 	$status = $result->status->code;
	  	$params = $result->params;
		$data   = $result->data ; 

		// check for derived params
		if ((array) $params && $valid && $vars)
		{
			foreach ((array) $params as $key=>$value)
			{
				if (!array_key_exists($key, $vars) OR !$vars[$key])
				{
					if (array_key_exists($key, $valid))$vars[$key] = $value;
				}	
			}
		}
	    if ($status == 'success') { $data = $result->data ; }
	     	
 	 	return $data;
	}
	
class vcnWebServices
{
  protected $_secret = '';
  protected $_baseurl = 'http://x.x.1.139/rest/public/';
  protected $_method = 'post';
  protected $_service;
  protected $_module;
  protected $_action;
  protected $_request = array();


  public function getSecret() { return $this->_secret; }
  public function setSecret($val) { $this->_secret = $val; }

  public function getBaseurl() { return $this->_baseurl; }
  public function setBaseurl($val) { $this->_baseurl = $val; }

  public function getMethod() { return $this->_method; }
  public function setMethod($val) { $this->_method = $val; }

  public function getService() { return $this->_service; }
  public function setService($val) { $this->_service = $val; }

  public function getModule() { return $this->_module; }
  public function setModule($val) { $this->_module = $val; }

  public function getAction() { return $this->_action; }
  public function setAction($val) { $this->_action = $val; }

  public function getRequest() { return $this->_request; }
  public function setRequest($val = array()) { $this->_request = $val; }

  public function getRequestKey($key) { return $this->_request[$key]; }
  public function setRequestKey($key, $val, $append = false) {
  if ($append) {
  		$this->_request[$key][] = $val;
  	}
  	else {
  		$this->_request[$key] = $val;
  	}
  }


  public function call() {
    $auth    = $this->_signArgs($this->_request, $this->_secret);
    $this->setRequestKey('auth',$auth);
    $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
    $method  = $this->_method;
    $url     = $this->_baseurl."$this->_service/$this->_module/$this->_action/";


// the value of $str is actually bool(true), not empty string ''
//var_dump($str);

    $content = drupal_http_request($url, $headers, strtoupper($method), http_build_query($this->_request,'','&') );

    if (isset($_GET['debug'])) {
      echo "<div style='border: 1px black solid;'><p><pre>";
      echo "REST parameters: <br>";
      echo "url: " . $url . "<br>";
      echo "headers: " . print_r($headers,true) . "<br>";
      echo "method: " . strtoupper($method) . "<br>";
      echo "request: " . print_r($this->_request,true) . "<br>";
      echo "raw results: " . print_r($content,true) . "<br>";
      echo "</pre></p></div>";
    }
     if ($content->data) {
      $data = $content->data;
    } else {
	  if (empty($this->request)) {
	     $data['NODATA'] = 'No data found for request: ' . $url;
	  } else {
         $data['NODATA'] = 'No data found for request: ' . $url . http_build_query($this->request,'','&');
	  }
    }

     return $data;
  }

  private function _signArgs($args, $secret) {

		ksort($args);
    	$a = '';
    	foreach($args as $k => $v)
      	{
         	$a .= $k . $v;
    	}
   		return md5($secret.$a);
	}
}

// udate prints date with microsecond detail

function udate($format, $utimestamp = null)
{
    if (is_null($utimestamp))
        $utimestamp = microtime(true);

    $timestamp = floor($utimestamp);
    $milliseconds = round(($utimestamp - $timestamp) * 1000000);

    return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
}


function drupal_provider_mail($module, $key, $to, $language, $params = array(), $from = NULL, $send = TRUE) {
  $default_from = variable_get('site_mail', ini_get('sendmail_from'));

  
  
  // Bundle up the variables into a structured array for altering.
  $message = array(
    'id'       => $module .'_'. $key,
    'to'       => $to,
    'from'     => isset($from) ? $from : $default_from,
    'language' => $language,
    'params'   => $params,
    'subject'  => $params['subject'],
    'body'     => $params['body']
  );

  // Build the default headers
  $headers = array(
    'MIME-Version'              => '1.0',
    'Content-Type'              => 'text/html; charset=UTF-8; format=flowed; delsp=yes',
    'Content-Transfer-Encoding' => '8Bit',
    'X-Mailer'                  => 'Drupal'
  );
  if ($default_from) {
    // To prevent e-mail from looking like spam, the addresses in the Sender and
    // Return-Path headers should have a domain authorized to use the originating
    // SMTP server. Errors-To is redundant, but shouldn't hurt.
    $headers['From'] = $headers['Sender'] = $headers['Return-Path'] = $headers['Errors-To'] = $default_from;
  }
  if ($from) {
    $headers['From'] = $from;
  }
  $message['headers'] = $headers;

  // Build the e-mail (get subject and body, allow additional headers) by
  // invoking hook_mail() on this module. We cannot use module_invoke() as
  // we need to have $message by reference in hook_mail().
  if (function_exists($function = $module .'_mail')) {
    $function($key, $message, $params);
  }

  // Invoke hook_mail_alter() to allow all modules to alter the resulting e-mail.
  drupal_alter('mail', $message);

  // Concatenate and wrap the e-mail body.
  $message['body'] = is_array($message['body']) ? drupal_wrap_mail(implode("\n\n", $message['body'])) : drupal_wrap_mail($message['body']);

  // Optionally send e-mail.
  if ($send) {
    $message['result'] = drupal_mail_send($message);

    // Log errors
    if (!$message['result']) {
      watchdog('mail', 'Error sending e-mail (from %from to %to).', array('%from' => $message['from'], '%to' => $message['to']), WATCHDOG_ERROR);
      //to disable the message for the email not valid because only xpand email is working as of now
      //drupal_set_message(t('Unable to send e-mail. Please contact the site administrator if the problem persists.'), 'error');
    }
  }

  return $message;
}

function vcn_get_zip_code_lat_lon($zip) {
	$conn = vcn_connect_to_db();

	$sql = ' SELECT latitude, longitude ' .
		   ' FROM vcn_master_zipcode ' . 
		   ' WHERE zip = \'' . $zip . '\' ';

	$result = mysql_query($sql) or die("Error getting lat lon for zip: " . mysql_error());

	$rec = mysql_fetch_object($result);

	$coords = array("latitude" => $rec->latitude,
					"longitude" => $rec->longitude);

	vcn_disconnect_from_db($conn);

	return $coords;
}
function vcn_get_one_stop_webservice_key() {
	$conn = vcn_connect_to_db();

	$sql = ' SELECT value ' .
           ' FROM vcn_app_properties ' . 
           ' WHERE ID = 1 ';

	$key = '';

	$result = mysql_query($sql) or die("Error getting app property: " . mysql_error());

	$rec = mysql_fetch_object($result);
	$key = $rec->value;

	vcn_disconnect_from_db($conn);

	return $key;
}
function vcn_get_db_server() {
	$dbserver = $GLOBALS['hvcp_config_db_server_name'];
	return $dbserver;
}

function vcn_connect_to_db() {
	$dbserver = $GLOBALS['hvcp_config_db_server_name'];
	
	$conn = mysql_connect($dbserver, 'hvcp', 'hvcpapp')
	or die("Error making database connection: ".mysql_error());
	$db = mysql_select_db('hvcp',$conn)
	or die("Error selecting database: ".mysql_error());

	return $conn;
}

function vcn_disconnect_from_db(&$conn) {
	if(isset($conn)) {
		mysql_close($conn);
	}
}

function vcn_build_link_window_opener($url, $text, $display=true, $isExternal=true, $title='', $class='extlink') {
	
	if (strlen($title) < 1) {
		$externalText = '';
		if ($isExternal) {
			$externalText = 'External link: ';
		}
		$title = $externalText . $url;
	}
	
	$sHtml = '<a href="' . $url . '" class="' . $class . '" title="' . $title . '">' . $text . ' <img src="' . base_path() . 'sites/all/modules/custom/vcn/images/popout3.png" alt="pop out link icon" title="' . $externalText . $url . '" style="vertical-align:middle; border:none;"/></a>';

	if ($display) {
		echo $sHtml;
	}

	return $sHtml;
}
