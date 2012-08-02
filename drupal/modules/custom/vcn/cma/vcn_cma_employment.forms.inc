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
 * Support file for cma.module containing employment form methods/functions.
 */

/**
 * @todo validation rules need to be defined
 */
function cma_employment_form_validate($form_id, $form_values) {
	
}

function cma_employment_form_submit($form_id, $form_values) {
 
    if ($form_values['values']['op'] != 'Cancel') {
        $cma = vcnCma::getInstance();
        if ($cma->updateHistoryItem('employment', $form_values['values']))
        {
            drupal_set_message(t('Career Management Account Updated: '));
        }
        else
        {
            drupal_set_message(t('Career Management Account Not Updated: '));
        }
    }
	drupal_goto('cma/history/employment/list');
}


function cma_employment_form(&$form_state,$action_arr = array()) {

    $cma = vcnCma::getInstance();

    $delete_action = (isset($action_arr['mode']) && $action_arr['mode'] == 'D') ? true : false;
    if (isset($action_arr['id'])) {
        if (!$cma->getHistoryItem('employment',$action_arr['id'])) {
            drupal_set_title('CMA Employment Record not found');
            drupal_goto('cma/history/employment/list');
        }

        $form['rec_id']   = array(
            '#type' => 'hidden',
            '#value' => $action_arr['id'],
            );
        $form['rec_mode'] = array(
            '#type' => 'hidden',
            '#value' => $action_arr['mode'],
            );
    }

    $form['#attributes']['class'] = 'cma-employment_form';


    $form['employer-name'] = array(
      '#type' => 'textfield',
      '#title' => t('Employer Name'),
      '#default_value' => isset($cma->employment->employername) ?
                                $cma->employment->employername  :
                                '',
	'#size' => 60,
	'#maxlength' => 100,
	'#required' => TRUE,
    );
    
    
    $form['address1'] = array(
      '#type' => 'textarea',
      '#title' => t('Street Address'),
      '#default_value' => isset($cma->employment->address1) ?
                                $cma->employment->address1  :
                                '',
      '#rows' => 2,
      '#maxlength' => 200,
	'#required' => FALSE,
    );    
        
	$form['address2'] = array(
      '#type' => 'textarea',
      '#title' => t('City,State (Province),ZIP (Postal)/Country'),
      '#default_value' => isset($cma->employment->address2) ?
                                $cma->employment->address2  :
                                '',
      '#rows' => 2,
      '#maxlength' => 200,
	'#required' => FALSE,
    );    
    
    $form['contact-name'] = array(
      '#type' => 'textfield',
      '#title' => t('Contact Name'),
      '#default_value' => isset($cma->employment->contactname) ?
                                $cma->employment->contactname  :
                                '',
	'#size' => 60,
	'#maxlength' => 100,
	'#required' => FALSE,
    );
    
    $form['contact-phone'] = array(
      '#type' => 'textfield',
      '#title' => t('Contact Phone'),
      '#default_value' => isset($cma->employment->contactphone) ?
                                $cma->employment->contactphone  :
                                '',
	'#size' => 60,
	'#maxlength' => 10,
	'#required' => FALSE,
    );    
    
    $form['contact-email'] = array(
      '#type' => 'textfield',
      '#title' => t('Contact Email'),
      '#default_value' => isset($cma->employment->contactemail) ?
                                $cma->employment->contactemail  :
                                '',
	'#size' => 60,
	'#maxlength' => 200,
	'#required' => FALSE,
    );
    
    $form['job-title'] = array(
      '#type' => 'textfield',
      '#title' => t('Job Title'),
      '#default_value' => isset($cma->employment->jobtitle) ?
                                $cma->employment->jobtitle  :
                                '',
      '#rows' => 2,
      '#maxlength' => 150,
	'#required' => TRUE,
    );    
    
    $form['responsibilities'] = array(
      '#type' => 'textarea',
      '#title' => t('Responsibility'),
      '#default_value' => isset($cma->employment->responsibilities) ?
                                $cma->employment->responsibilities  :
                                '',
      '#rows' => 4,
      '#maxlength' => 500,
	'#required' => TRUE,
    );    
    
    $form['start-date'] = array(
      '#type' => 'textfield',
      '#title' => t('Start Date yyyy-mm-dd'),
      '#default_value' => isset($cma->employment->startdate) ?
                                $cma->employment->startdate  :
                                '',
	'#size' => 60,
	'#maxlength' => 128,
	'#required' => TRUE,
    );    
    
    $form['end-date'] = array(
      '#type' => 'textfield',
      '#title' => t('End Date yyyy-mm-dd (blank if still there)'),
      '#default_value' => isset($cma->employment->enddate) ?
                                $cma->employment->enddate  :
                                '',
	'#size' => 60,
	'#maxlength' => 128,
	'#required' => FALSE,
    );    
    
    $form['professional-achievements'] = array(
      '#type' => 'textarea',
      '#title' => t('Professional Achievements'),
      '#default_value' => isset($cma->employment->professionalachievements) ?
                                $cma->employment->professionalachievements  :
                                '',
      '#rows' => 4,
      '#maxlength' => 500,
	'#required' => FALSE,
    );    

    if ($delete_action) {
        $form['professional-achievements']['#readonly'] = true;
        $form['end-date']['#readonly'] = true;
        $form['start-date']['#readonly'] = true;
        $form['start-date']['#required'] = false;
        $form['responsibilities']['#readonly'] = true;
        $form['responsibilities']['#required'] = false;
        $form['job-title']['#readonly'] = true;
        $form['job-title']['#required'] = false;
        $form['contact-email']['#readonly'] = true;
        $form['contact-phone']['#readonly'] = true;
        $form['contact-name']['#readonly'] = true;
        $form['address2']['#readonly'] = true;
        $form['address1']['#readonly'] = true;
        $form['employer-name']['#readonly'] = true;
        $form['employer-name']['#required'] = false;

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Remove'),
        );
    } else {
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Update'),
        );
    }
    $form['cancel'] = array(
        '#type' => 'submit',
        '#value' => t('Cancel'),
    );

    return $form;
}