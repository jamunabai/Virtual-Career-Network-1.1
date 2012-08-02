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
 * Support file for cma.module containing association form methods/functions.
 */

/**
 * @todo validation rules need to be defined
 */
function cma_association_form_validate($form_id, $form_values) {
	
}

function cma_association_form_submit($form_id, $form_values) {
 
    if ($form_values['values']['op'] != 'Cancel') {
        $cma = vcnCma::getInstance();
   //     error_log('cma_association_form_submit - form_values: ' . print_r($form_values,TRUE));
        if ($cma->updateHistoryItem('association', $form_values['values']))
        {
            drupal_set_message(t('Career Management Account Updated: '));
        }
        else
        {
            drupal_set_message(t('Career Management Account Not Updated: '));
        }
	}
	drupal_goto('cma/history/association/list');
}


function cma_association_form(&$form_state,$action_arr = array()) {

    $cma = vcnCma::getInstance();

    $delete_action = (isset($action_arr['mode']) && $action_arr['mode'] == 'D') ? true : false;
    if (isset($action_arr['id'])) {
        if (!$cma->getHistoryItem('association',$action_arr['id'])) {
            drupal_set_title('CMA Association Record not found');
            drupal_goto('cma/history/association/list');
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

    $form['#attributes']['class'] = 'cma-association_form';


    $form['association-name'] = array(
      '#type' => 'textfield',
      '#title' => t('Association Name'),
      '#default_value' => isset($cma->association->associationname) ?
                                $cma->association->associationname  :
                                '',
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => FALSE,
    );
    
    $form['description'] = array(
      '#type' => 'textarea',
      '#title' => t('Description'),
      '#default_value' => isset($cma->association->description) ?
                                $cma->association->description  :
                                '',
      '#rows' => 5,
      '#maxlength' => 500,
      '#required' => FALSE,
    );    
    
    $form['join-date'] = array(
      '#type' => 'textfield',
      '#title' => t('Start Date'),
      '#default_value' => isset($cma->association->joindate) ?
                                $cma->association->joindate  :
                                '',
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => FALSE,
    );    
    
    $form['end-date'] = array(
      '#type' => 'textfield',
      '#title' => t('End Date'),
      '#default_value' => isset($cma->association->enddate) ?
                                $cma->association->enddate  :
                                '',
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => FALSE,
    );    
    
    if ($delete_action) {
        $form['association-name']['#readonly'] = true;
        $form['description']['#readonly'] = true;
        $form['start-date']['#readonly'] = true;
        $form['end-date']['#readonly'] = true;

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

