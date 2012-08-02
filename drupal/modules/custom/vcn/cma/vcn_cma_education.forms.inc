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
 * Support file for cma.module containing education form methods/functions.
 */

/**
 * @todo validation rules need to be defined
 */
function cma_education_form_validate($form_id, $form_values) {

}

function cma_education_form_submit($form_id, $form_values) {

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

function cma_education_form(&$form_state,$action_arr = array()) {

    $cma = vcnCma::getInstance();

    $delete_action = (isset($action_arr['mode']) && $action_arr['mode'] == 'D') ? true : false;
    if (isset($action_arr['id'])) {
        if (!$cma->getHistoryItem('education',$action_arr['id'])) {
            drupal_set_title('CMA Education Record not found');
            drupal_goto('cma/history/education/list');
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

    $form['#attributes']['class'] = 'cma-education_form';

    $form['institution-name'] = array(
      '#type' => 'textfield',
      '#title' => t('School Name'),
      '#default_value' => isset($cma->education->institutionname) ?
                                $cma->education->institutionname  :
                                '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => FALSE,
    );

    $form['institution-address'] = array(
      '#type' => 'textarea',
      '#title' => t('School Address'),
      '#default_value' => isset($cma->education->institutionaddress) ?
                                $cma->education->institutionaddress  :
                                '',
      '#rows' => 3,
      '#maxlength' => 500,
      '#required' => FALSE,
    );

    $form['institution-contact'] = array(
      '#type' => 'textfield',
      '#title' => t('Contact Name'),
      '#default_value' => isset($cma->education->institutioncontact) ?
                                $cma->education->institutioncontact  :
                                '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => FALSE,
    );

    $form['institution-url'] = array(
      '#type' => 'textfield',
      '#title' => t('School URL'),
      '#default_value' => isset($cma->education->institutionurl) ?
                                $cma->education->institutionurl  :
                                '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => FALSE,
    );

    $form['education_level_desc'] = array(
      '#type' => 'textfield',
      '#title' => t('Education Level'),
      '#default_value' => isset($cma->education->educationleveldesc) ?
                                $cma->education->educationleveldesc  :
                                '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => FALSE,
    );
    
	$form['graduated'] = array(
	'#type' => 'radios',
	'#title' => t('Graduated'),
	'#description' => t('Graduated'),
	'#options' => array('Y'=>t('Yes'),'N'=>t('No')),
	'#required' => TRUE,
      '#default_value' => isset($cma->education->graduated) ?
                                $cma->education->graduated  :
                                '',
	); 
	    
    $form['year-started'] = array(
	'#type' => 'textfield',
	'#title' => t('Year Started'),
      '#default_value' => isset($cma->education->yearstarted) ?
                                $cma->education->yearstarted  :
                                '',
	'#size' => 60,
	'#maxlength' => 4,
	'#required' => FALSE,
    );

    $form['year-graduated'] = array(
	'#type' => 'textfield',
	'#title' => t('Year Graduated'),
      '#default_value' => isset($cma->education->yeargraduated) ?
                                $cma->education->yeargraduated  :
                                '',
	'#size' => 60,
	'#maxlength' => 128,
	'#required' => FALSE,
    );

    $form['years-attended'] = array(
	'#type' => 'textfield',
	'#title' => t('Years Attended'),
      '#default_value' => isset($cma->education->yearsattended) ?
                                $cma->education->yearsattended  :
                                '',
	'#size' => 60,
	'#maxlength' => 128,
	'#required' => FALSE,
    );

    $form['major-desc'] = array(
    '#type' => 'textfield',
	'#title' => t('Major'),
      '#default_value' => isset($cma->education->majordesc) ?
                                $cma->education->majordesc  :
                                '',
	'#size' => 60,
	'#maxlength' => 128,
	'#required' => TRUE,
    );

    $form['minor-desc'] = array(
    '#type' => 'textfield',
	'#title' => t('Minor'),
      '#default_value' => isset($cma->education->minordesc) ?
                                $cma->education->minordesc  :
                                '',
	'#size' => 60,
	'#maxlength' => 128,
	'#required' => FALSE,
    );
    
    $form['program-desc'] = array(
      '#type' => 'textarea',
      '#title' => t('Program'),
      '#default_value' => isset($cma->education->programdesc) ?
                                $cma->education->programdesc  :
                                '',
      '#rows' => 5,
      '#maxlength' => 500,
      '#required' => FALSE,
    );

    $form['other-qualification'] = array(
      '#type' => 'textarea',
      '#title' => t('Other Qualification'),
      '#default_value' => isset($cma->education->otherqualification) ?
                                $cma->education->otherqualification  :
                                '',
      '#rows' => 5,
      '#maxlength' => 500,
      '#required' => FALSE,
    );

/**
 * TODO  need a file upload element and the required storage functionality
 *
 *     not really certain about how that is done in drupal
 *
    $form['transcript-file-name'] = array(
      '#type' => 'textfield',
      '#title' => t('Transcript File Name'),
	'#default_value' => '',
	'#size' => 60,
	'#maxlength' => 128,
	'#required' => FALSE,
    );
  */
    if ($delete_action) {
        $form['other-qualification']['#readonly'] = true;
        $form['program-desc']['#readonly'] = true;
        $form['minor-desc']['#readonly'] = true;
        $form['major-desc']['#readonly'] = true;
        $form['major-desc']['#required'] = false;
        $form['years-attended']['#readonly'] = true;
        $form['year-graduated']['#readonly'] = true;
        $form['year-started']['#readonly'] = true;
        $form['graduated']['#readonly'] = true;
        $form['graduated']['#required'] = false;
        $form['education-level-desc']['#readonly'] = true;
        $form['institution-url']['#readonly'] = true;
        $form['institution-contact']['#readonly'] = true;
        $form['institution-address']['#readonly'] = true;
        $form['institution-name']['#readonly'] = true;

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