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
 * Support file for cma.module containing user hook form methods/functions.
 */

require_once('vcn_cma.class.inc');

function cma_load_cma(&$user) {
    $cma = vcnCma::getInstance();
}

function cma_form_cma ($edit, $account) {
    $cma = vcnCma::getInstance();
	//Admin user's should not over write the users zip in case admin edits users profile
	$cma->setUserId($account->uid); 
	$cma->getCmaUserInfo();
	/////
    $edit_zip = (empty($cma->zipcode)) ? (empty($edit['zipcode']))  ? '' : $edit['zipcode'] : $cma->zipcode;

    
    $fields['zipcode'] = array('#type' => 'textfield',
          '#title' => 'ZIP Code',
          '#default_value' => $edit_zip,
          '#maxlength' => 5,
          '#description' => 'This ZIP Code will be used as default value for ZIP Code based searches',
          '#required' => TRUE,
        );
  //  print_r($fields); exit;
    return $fields;
}

function cma_validate_cma($edit) {
    if (empty($edit['zipcode'])) {
      form_set_error('zipcode', t('The field %field is required.', array('%field' => 'ZIP Code')));
    }
    return $edit;
}

function cma_save_cma (&$edit, $account) {
    $cma = vcnCma::getInstance();
/*	print_r($edit);
	print_r($account); exit;*/
   // $cma->getCmaUserInfo();

    $cma->setUserId($account->uid);
    $cma->zipcode = $edit['zipcode'];
    
        $cma->firstname = $edit['firstname'];
        $cma->lastname   = $edit['lastname'];
        $cma->address1    = $edit['address1'];
        $cma->address2    = $edit['address2'];
        $cma->city        = $edit['city'];
        $cma->state       = $edit['state'];
        $cma->homephone  = $edit['homephone'];
        $cma->cellphone  = $edit['cellphone'];
        
     //error_log('_setUserInfo - cma:' . print_r($this,true));
   // $cma->city = 'xyz';
    //$cma->zipcode = $account['values']['zipcode'];

    $cma->updateCmaUserInfo();

    unset($edit['zipcode']);
}

/*function cma_profile_form_submit($form_id, $form_values) {

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
}*/