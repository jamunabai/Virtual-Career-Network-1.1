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
 * Support file for cma.module containing publication form methods/functions.
 */

/**
 * @todo validation rules need to be defined
 */
function cma_publication_form_validate($form_id, $form_values) {
	
}

function cma_publication_form_submit($form_id, $form_values) {

    if ($form_values['values']['op'] != 'Cancel') {
        $cma = vcnCma::getInstance();
        if ($cma->updateHistoryItem('publication', $form_values['values']))
        {
            drupal_set_message(t('Career Management Account Updated: '));
        }
        else
        {
            drupal_set_message(t('Career Management Account Not Updated: '));
        }
    }
	drupal_goto('cma/history/publication/list');
}


function cma_publication_form(&$form_state,$action_arr = array()) {

    $cma = vcnCma::getInstance();

    $delete_action = (isset($action_arr['mode']) && $action_arr['mode'] == 'D') ? true : false;
    if (isset($action_arr['id'])) {
        if (!$cma->getHistoryItem('publication',$action_arr['id'])) {
            drupal_set_title('CMA Publication Record not found');
            drupal_goto('cma/history/publication/list');
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


    $form['#attributes']['class'] = 'cma-publication_form';


    $form['publication-name'] = array(
      '#type' => 'textfield',
      '#title' => t('Publication Name'),
      '#default_value' => isset($cma->publication->publicationname) ?
                                $cma->publication->publicationname  :
                                '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => FALSE,
    );
    
    $form['publication-description'] = array(
      '#type' => 'textarea',
      '#title' => t('Description'),
      '#default_value' => isset($cma->publication->publicationdescription) ?
                                $cma->publication->publicationdescription  :
                                '',
      '#rows' => 5,
      '#maxlength' => 500,
      '#required' => FALSE,
    );

    $form['contribution'] = array(
      '#type' => 'textarea',
      '#title' => t('Contribution'),
      '#default_value' => isset($cma->publication->contribution) ?
                                $cma->publication->contribution  :
                                '',
      '#rows' => 5,
      '#maxlength' => 500,
      '#required' => FALSE,
    );

    $form['published-date'] = array(
      '#type' => 'textfield',
      '#title' => t('Published Date'),
      '#default_value' => isset($cma->publication->publisheddate) ?
                                $cma->publication->publisheddate  :
                                '',
      '#size' => 60,
      '#maxlength' => 100,
      '#required' => FALSE,
    );    
    
    $form['publisher-name'] = array(
      '#type' => 'textarea',
      '#title' => t('Publisher\'s Name'),
      '#default_value' => isset($cma->publication->publishername) ?
                                $cma->publication->publishername  :
                                '',
      '#rows' => 3,
      '#maxlength' => 500,
      '#required' => FALSE,
    );

    $form['comments'] = array(
      '#type' => 'textarea',
      '#title' => t('Comments'),
      '#default_value' => isset($cma->publication->comments) ?
                                $cma->publication->comments  :
                                '',
      '#rows' => 5,
      '#maxlength' => 500,
      '#required' => FALSE,
    );

    if ($delete_action) {
        $form['comments']['#readonly'] = true;
        $form['publisher-name']['#readonly'] = true;
        $form['published-date']['#readonly'] = true;
        $form['contribution']['#readonly'] = true;
        $form['publication-description']['#readonly'] = true;
        $form['publication-name']['#readonly'] = true;

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

