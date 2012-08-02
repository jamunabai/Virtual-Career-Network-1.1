<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
function vcn_portal_edit_contacts_form_validate($form_id, $form_values) {

}

function vcn_portal_edit_contacts_form_submit($form_id, $form_values) {

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

function vcn_portal_edit_contacts_form(&$form_state, $data=false,$action_arr = array()) {
	$form['#attributes']['class'] = 'vcn-form';
	
    $form['contactid'] = array(
      '#type' => 'hidden',
      '#default_value' => isset($data->unitid) ? $data->unitid : '',
      '#required' => false,
    );
	$form['user_id'] = array(
	    '#type' => 'select',
	    '#title' => t('User'),
      	'#default_value' => isset($data->userid) ? $data->userid : '',
		'#options' => vcn_get_users(),
	    '#description' => t('users'),
	);
    
    $form['user'] = array(
      '#type' => 'textfield',
      '#title' => t('School Name'),
      '#default_value' => isset($data->instnm) ? $data->instnm : '',
      '#size' => 60,
      '#maxlength' => 255,
      '#required' => false,
    );
    $form['addr'] = array(
      '#type' => 'textfield',
      '#title' => t('Address'),
      '#default_value' => isset($data->addr) ? $data->addr : '',
      '#size' => 60,
      '#maxlength' => 255,
      '#required' => true,
    );
    $form['city'] = array(
      '#type' => 'textfield',
      '#title' => t('City'),
      '#default_value' => isset($data->city) ? $data->city : '',
      '#size' => 60,
      '#maxlength' => 50,
      '#required' => false,
    );
	$form['stabbr'] = array(
	    '#type' => 'select',
	    '#title' => t('State'),
      	'#default_value' => isset($data->stabbr) ? $data->stabbr : '',
		'#options' => vcn_get_states(),
	    '#description' => t('State.'),
	);
    $form['zip'] = array(
      '#type' => 'textfield',
      '#title' => t('Zip'),
      '#default_value' => isset($data->zip) ? $data->zip : '',
      '#size' => 20,
      '#maxlength' => 20,
      '#required' => false,
    );
	
	$form['fips'] = array(
	    '#type' => 'select',
	    '#title' => t('Fips'),
      	'#default_value' => isset($data->fips) ? $data->fips : '',
		'#options' => vcn_get_stfips(),
	    '#description' => t('Fips'),
	);
	$form['obereg'] = array(
	    '#type' => 'select',
	    '#title' => t('OBEREG'),
      	'#default_value' => isset($data->obereg) ? $data->obereg : '',
		'#options' => vcn_get_ipeds_lookup('OBEREG'),
	    '#description' => t('obereg'),
	);
    $form['chfnm'] = array(
      '#type' => 'textfield',
      '#title' => t('CHFNM'),
      '#default_value' => isset($data->chfnm) ? $data->chfnm : '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => false,
    );
    $form['chftitle'] = array(
      '#type' => 'textfield',
      '#title' => t('CHFTITLE'),
      '#default_value' => isset($data->chftitle) ? $data->chftitle : '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => false,
    );
    $form['gentele'] = array(
      '#type' => 'textfield',
      '#title' => t('Telephone'),
      '#default_value' => isset($data->gentele) ? vcn_format_phone((string)$data->gentele) : '',
      '#size' => 60,
      '#maxlength' => 15,
      '#required' => false,
    );
    $form['ein'] = array(
      '#type' => 'textfield',
      '#title' => t('EIN'),
      '#default_value' => isset($data->ein) ? $data->ein : '',
      '#size' => 60,
      '#maxlength' => 15,
      '#required' => false,
    );
      
    $form['adminurl'] = array(
      '#type' => 'textarea',
      '#title' => t('Admin Url'),
      '#default_value' => '',
      '#rows' => 3,
      '#maxlength' => 500,
      '#default_value' => isset($data->adminurl) ? $data->adminurl : '',
	  '#required' => FALSE,
    );

    $form['institution-contact'] = array(
      '#type' => 'textfield',
      '#title' => t('Contact Name'),
      '#default_value' => '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => FALSE,
    );

    $form['institution-url'] = array(
      '#type' => 'textfield',
      '#title' => t('School URL'),
      '#default_value' => '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => FALSE,
    );

    $form['education_level_desc'] = array(
      '#type' => 'textfield',
      '#title' => t('Education Level'),
      '#default_value' => '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => FALSE,
    );

	$form['graduated'] = array(
	'#type' => 'radios',
	'#title' => t('Graduated'),
	'#description' => t('Graduated'),
	'#options' => array(t('Yes'),t('No')),
	'#required' => TRUE,
      '#default_value' => '',
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