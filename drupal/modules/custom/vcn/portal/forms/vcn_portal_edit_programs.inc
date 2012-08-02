<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
function vcn_portal_edit_programs_form_validate($form_id, $form_values) {

}

function vcn_portal_edit_programs_form_submit($form_id, $form_values) {

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

function vcn_portal_edit_programs_form(&$form_state, $data=false,$action_arr = array()) {
	$form['#attributes']['class'] = 'vcn-form';
	
    $form['program_id'] = array(
      '#type' => 'hidden',
      '#default_value' => isset($data->programid) ? $data->programid : '',
      '#required' => false,
    );
    $form['unitid'] = array(
      '#type' => 'textfield',
      '#title' => t('School Name'),
      '#default_value' => isset($data->unitid) ? $data->unitid : '',
      '#size' => 60,
      '#maxlength' => 255,
      '#required' => false,
    );
  	$form['awlevel'] = array(
	    '#type' => 'select',
	    '#title' => t('Award Level'),
      	'#default_value' => isset($data->awlevel) ? $data->awlevel : '',
		'#options' => vcn_get_ipeds_lookup('AWLEVEL'),
	    '#description' => t('award level'),
	);
    $form['program_code'] = array(
      '#type' => 'textfield',
      '#title' => t('Program Code'),
      '#default_value' => isset($data->programcode) ? $data->programcode : '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => false,
    );
    $form['program_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Program Name'),
      '#default_value' => isset($data->programname) ? $data->programname : '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => false,
    );
    $form['program_description'] = array(
      '#type' => 'textarea',
      '#title' => t('Program Description'),
      '#default_value' => '',
      '#rows' => 3,
      '#maxlength' => 500,
      '#default_value' => isset($data->programdescription) ? $data->programdescription : '',
	  '#required' => FALSE,
    );
    $form['admission_url'] = array(
      '#type' => 'textfield',
      '#title' => t('Admission Url'),
      '#default_value' => isset($data->admissionurl) ? $data->admissionurl : '',
      '#size' => 60,
      '#maxlength' => 250,
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
    $form['total_courses'] = array(
      '#type' => 'textfield',
      '#title' => t('Total Courses'),
      '#default_value' => isset($data->totalcourses) ? $data->totalcourses : '',
      '#size' => 20,
      '#maxlength' => 4,
      '#required' => false,
    );
    $form['tuition_in_state'] = array(
      '#type' => 'textfield',
      '#title' => t('Tuition In-State'),
      '#default_value' => isset($data->tuitioninstate) ? $data->tuitioninstate : '',
      '#size' => 20,
      '#maxlength' => 20,
      '#required' => false,
    );
   $form['other_cost'] = array(
      '#type' => 'textfield',
      '#title' => t('Other Costs'),
      '#default_value' => isset($data->othercost) ? $data->othercost : '',
      '#size' => 20,
      '#maxlength' => 20,
      '#required' => false,
    );
    $form['duration'] = array(
      '#type' => 'textfield',
      '#title' => t('Duration'),
      '#default_value' => isset($data->duration) ? $data->duration : '',
      '#size' => 60,
      '#maxlength' => 20,
      '#required' => false,
    );
  	$form['accredited_yn'] = array(
      '#type' => 'radios',
      '#title' => t('Accredited'),
      '#default_value' =>  isset($data->accreditedyn) ? $data->accreditedyn : '',
      '#options' => vcn_get_yes_no(),
      '#description' => t('accredited.'),
  	);
    $form['legal_req'] = array(
      '#type' => 'textarea',
      '#title' => t('Legal Requirements'),
      '#default_value' => '',
      '#rows' => 3,
      '#maxlength' => 500,
      '#default_value' => isset($data->legalreq) ? $data->legalreq : '',
	  '#required' => FALSE,
    );
  
	$form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Update'),
        );
    
    $form['cancel'] = array(
        '#type' => 'submit',
        '#value' => t('Cancel'),
    );

    return $form;
}