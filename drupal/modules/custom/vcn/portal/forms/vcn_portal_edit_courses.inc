<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
function vcn_portal_edit_courses_form_validate($form_id, $form_values) {

}

function vcn_portal_edit_courses_form_submit($form_id, $form_values) {

    if ($form_values['values']['op'] != 'Cancel') {
        $cma = vcnCma::getInstance();
        if ($cma->updateHistoryItem('education', $form_values['values']))
        {
            drupal_set_message(t('Career Management Account Updated: '));
        }
        else
        {
            drupal_set_message(t('Career Management Account Not Updated: '));
        }
    }
	drupal_goto('cma/history/education/list');
}

function vcn_portal_edit_courses_form(&$form_state, $data=false,$action_arr = array()) {
	$form['#attributes']['class'] = 'vcn-form';
	 $form['course_id'] = array(
      '#type' => 'hidden',
      '#default_value' => isset($data->courseid) ? $data->courseid : '',
      '#required' => false,
    );
 
    $form['course_code'] = array(
      '#type' => 'textfield',
      '#title' => t('Course Code'),
      '#default_value' => isset($data->coursecode) ? $data->coursecode : '',
      '#size' => 20,
      '#maxlength' => 10,
      '#required' => false,
    );
    $form['unitid'] = array(
 	    '#type' => 'select',
	    '#title' => t('School'),
      	'#default_value' => isset($data->unitid) ? $data->unitid : '',
		'#options' => vcn_get_stfips(),
	    '#description' => t('Fips'),
	);
	$form['course_type'] = array(
 	    '#type' => 'select',
	    '#title' => t('Course Type'),
      	'#default_value' => isset($data->coursetype) ? $data->coursetype : '',
		'#options' => vcn_get_course_type(),
	    '#description' => t('Fips'),
	);
	$form['course_type'] = array(
 	    '#type' => 'select',
	    '#title' => t('Course Type'),
      	'#default_value' => isset($data->coursetype) ? $data->coursetype : '',
		'#options' => vcn_get_course_type(),
	    '#description' => t('Fips'),
	);
	
    $form['description'] = array(
      '#type' => 'textarea',
      '#title' => t('Description'),
      '#default_value' => isset($data->description) ? $data->description : '',
      '#rows' => 3,
      '#maxlength' => 500,
   	  '#required' => FALSE,
    );
    $form['duration'] = array(
      '#type' => 'textfield',
      '#title' => t('Duration'),
      '#default_value' => isset($data->duration) ? $data->duration : '',
      '#size' => 60,
      '#maxlength' => 20,
      '#required' => false,
    );
    $form['version'] = array(
      '#type' => 'textfield',
      '#title' => t('Version'),
      '#default_value' => isset($data->version) ? $data->version : '',
      '#size' => 20,
      '#maxlength' => 10,
      '#required' => false,
    );
	$form['base_course_id'] = array(
 	    '#type' => 'select',
	    '#title' => t('Base Course'),
      	'#default_value' => isset($data->basecourseid) ? $data->basecourseid : '',
		'#options' => vcn_get_base_course(),
	    '#description' => t('base course'),
	);
	$form['subject_area'] = array(
 	    '#type' => 'select',
	    '#title' => t('Subject Area'),
      	'#default_value' => isset($data->subjectarea) ? $data->subjectarea : '',
		'#options' => vcn_get_subject_area(),
	    '#description' => t('subject area'),
	);
	$form['delivery_mode'] = array(
 	    '#type' => 'select',
	    '#title' => t('Delivery Mode'),
      	'#default_value' => isset($data->deliverymode) ? $data->deliverymode : '',
		'#options' => vcn_get_delivery_mode(),
	    '#description' => t('delivery mode'),
	);
 	$form['language_code'] = array(
 	    '#type' => 'select',
	    '#title' => t('Language'),
      	'#default_value' => isset($data->language_code) ? $data->language_code : '',
		'#options' => vcn_get_language_code(),
	    '#description' => t('language code'),
	);
    $form['course_info_url'] = array(
      '#type' => 'textarea',
      '#title' => t('Course Info Url'),
      '#default_value' => isset($data->courseinfourl) ? $data->courseinfourl : '',
      '#rows' => 1,
      '#maxlength' => 300,
   	  '#required' => FALSE,
    );
    $form['online_course_url'] = array(
      '#type' => 'textarea',
      '#title' => t('Online Course Url'),
      '#default_value' => isset($data->onlinecourseurl) ? $data->onlinecourseurl : '',
      '#rows' => 1,
      '#maxlength' => 300,
   	  '#required' => FALSE,
    );
    $form['tuition_in_state'] = array(
      '#type' => 'textfield',
      '#title' => t('Tuition In-State'),
      '#default_value' => isset($data->tuitioninstate) ? $data->tuitioninstate : '',
      '#size' => 20,
      '#maxlength' => 20,
      '#required' => false,
    );
   $form['tuition_out_state'] = array(
      '#type' => 'textfield',
      '#title' => t('Tuition Out-State'),
      '#default_value' => isset($data->tuitionoutstate) ? $data->tuitionoutstate : '',
      '#size' => 20,
      '#maxlength' => 20,
      '#required' => false,
    );
   $form['total_credits'] = array(
      '#type' => 'textfield',
      '#title' => t('Total Credits'),
      '#default_value' => isset($data->totalcredits) ? $data->totalcredits : '',
      '#size' => 20,
      '#maxlength' => 4,
      '#required' => false,
    );
 
    return $form;
}