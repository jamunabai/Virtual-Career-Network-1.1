<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
// $Id: vcn_cma.module, v 0.1 2011/02/02 10:23:00 hills Exp $

/**
 * @file
 * Support file for cma.module containing profile form methods/functions.
 */
require_once('vcn_cma.class.inc');
/**
 * @todo validation rules need to be defined
 */
function cma_profile_form_validate($form_id, $form_values) {
	
}

/**
* @todo: refactor?
 */
function cma_profile_form_submit($form_id, $form_values) {

    $cma = vcnCma::getInstance();

    $cma->firstname   = $form_values['values']['firstname'];
    $cma->lastname    = $form_values['values']['lastname'];
    $cma->address1     = $form_values['values']['address1'];
    $cma->address2     = $form_values['values']['address2'];
    $cma->city         = $form_values['values']['city'];
    $cma->state        = $form_values['values']['state'];
    $cma->zipcode      = $form_values['values']['zipcode'];
    $cma->homephone   = $form_values['values']['homephone'];
    $cma->cellphone   = $form_values['values']['cellphone'];

    $cma->updateCmaUserInfo();

    drupal_set_message(t('Career Management Account Updated: '));
    drupal_goto('cma/profile/view');
}


/**
 * cma profile form
 */
function cma_profile_form(&$form_state) {

    $cma = vcnCma::getInstance();
    global $user;
    if($_SERVER['HTTPS']=="ON" || $_SERVER['HTTP_FRONT_END_HTTPS']=="ON") {
    $pwpath1 = "https://";
    }else {
    $pwpath1 = "https://";}
	$pwpath2 = $_SERVER['SERVER_NAME'];
	$pwpath2 = explode('/', $pwpath2); 
	$testing = '<a href="'.base_path().'user/'.$user->uid.'/edit'.'">Click here</a> to change the Password';

//    error_log('Trying to process the form...');

    $form['#attributes']['class'] = 'cma-user-info_form';

    $form['firstname'] = array(
        '#type' => 'textfield',
        '#title' => t('First Name'),
        '#size' => 20,
        '#default_value' => isset($cma->firstname) ? $cma->firstname : '',
    );

    $form['lastname'] = array(
        '#type' => 'textfield',
        '#title' => t('Last Name'),
        '#size' => 20,
        '#default_value' => isset($cma->lastname) ? $cma->lastname : NULL,
    );

    $form['address1'] = array(
        '#type' => 'textfield',
        '#title' => t('Address 1'),
        '#size' => 20,
        '#default_value' => isset($cma->address1) ? $cma->address1 : NULL,
    );

    $form['address2'] = array(
        '#type' => 'textfield',
        '#title' => t('Address 2'),
        '#size' => 20,
        '#default_value' => isset($cma->address2) ? $cma->address2 : NULL,
    );

    $form['city'] = array(
        '#type' => 'textfield',
        '#title' => t('City'),
        '#size' => 20,
        '#default_value' => isset($cma->city) ? $cma->city : NULL,
    );

    $form['state'] = array(
        '#type' => 'textfield',
        '#title' => t('State'),
        '#size' => 2,
        '#default_value' => isset($cma->state) ? $cma->state : NULL,
    );

    $form['zipcode'] = array(
        '#type' => 'textfield',
        '#title' => t('ZIP Code'),
        '#size' => 10,
        '#default_value' => isset($cma->zipcode) ? $cma->zipcode : NULL,
    );

    $form['homephone'] = array(
        '#type' => 'textfield',
        '#title' => t('Home Phone'),
        '#size' => 10,
        '#default_value' => isset($cma->homephone) ? $cma->homephone : NULL,
    );

    $form['cellphone'] = array(
        '#type' => 'textfield',
        '#title' => t('Cell Phone'),
        '#size' => 10,
        '#default_value' => isset($cma->cellphone) ? $cma->cellphone : NULL,
    );

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Update'),
    );
    
    $form['email'] = array(
    '#type' => 'fieldset',
    '#title' => t('<b>Password Reset</b>'),
    '#description' => $testing,
  );
    return $form;
}

