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
 * Support file for cma.module containing ajax called functions.
 */

//$cp = './' . drupal_get_path('module','vcn_cma');

//require_once $cp . '/vcn_cma.class.inc';


/**
 * AJAX function for saving an item to notebook for CMA
 */
function cma_save_to_notebook($item_type, $item_id = NULL, $item_stfips = NULL)
{
 //   error_log('cma_save_to_notebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $item_stfips . ':');

    // If no onetcode is passed, we create an appropriate message
    if (!isset($item_id)) {
        return "Missing " . ucfirst($item_type) . " Id, nothing saved";
    }

    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

//    $output = $cma->saveCareerToNotebook($onetcode);
    $output = $cma->saveToNotebook($item_type,$item_id,$item_stfips);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}


/**
 * AJAX function for removing an item from notebook for CMA
 */
function cma_remove_from_notebook($item_type, $item_id = NULL, $item_stfips = NULL)
{
//    error_log('cma_remove_to_notebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $item_stfips . ':');

    // If no onetcode is passed, we create an appropriate message
    if (!isset($item_id)) {
        return "Missing " . ucfirst($item_type) . " Id, nothing removed";
    }

    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

//    $output = $cma->saveCareerToNotebook($onetcode);
    $output = $cma->removeFromNotebook($item_type,$item_id,$item_stfips);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}


/**
 * AJAX function for removing an document
 */
function cma_remove_documents($item_id = NULL)
{
//    error_log('cma_remove_to_notebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $item_stfips . ':');

    // If no onetcode is passed, we create an appropriate message
    if (!isset($item_id)) {
        return "Missing document Id, nothing removed";
    }

    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

//    $output = $cma->saveCareerToNotebook($onetcode);
    $output = $cma->removedocument($item_id);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}

/**
 * AJAX function for removing an document
 */
function cma_remove_jobs($job_id = NULL)
{
//    error_log('cma_remove_to_notebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $item_stfips . ':');

    // If no onetcode is passed, we create an appropriate message
    if (!isset($job_id)) {
        return "Missing Job Id, nothing removed";
    }

    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

    $output = $cma->removejobs($job_id);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}


/**
 * AJAX function for count an jobs
 */
function cma_count_jobs($user_id = NULL)
{
//    error_log('cma_remove_to_notebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $item_stfips . ':');

    // If no onetcode is passed, we create an appropriate message
    if (!isset($user_id)) {
        return "Missing User Id, nothing done";
    }

    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

    $output = $cma->countjobs($user_id);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}

/**
 * AJAX function for toggle active_yn  
 */
function cma_activeyn_jobs($job_scout_id = NULL, $active_yn = NULL)
{
//    error_log('cma_remove_to_notebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $item_stfips . ':');

    // If no onetcode is passed, we create an appropriate message
    if (!isset($job_scout_id)) {
        return "Missing User Id, nothing done";
    }

    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

    $output = $cma->activeynjobs($job_scout_id, $active_yn);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}


/**
 * AJAX function for toggle share_yn in vcn_cma_user_document table in HVCP database
 */
function cma_shareyn_documents($document_id = NULL, $share_yn = NULL)
{
//    error_log('cma_remove_to_notebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $item_stfips . ':');

    // If no onetcode is passed, we create an appropriate message
    if (!isset($document_id)) {
        return "Missing User Id, nothing done";
    }

    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

    $output = $cma->shareyndocuments($document_id, $share_yn);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}


/**
 * AJAX function for toggle active_yn 
 */
function cma_alldata_jobs($user_id = NULL, $zip = NULL, $distance = NULL, $onetcode = NULL, $keyword = NULL, $active_yn = NULL, $created_time = NULL)
{
//    error_log('cma_remove_to_notebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $item_stfips . ':');

    // If no onetcode is passed, we create an appropriate message
    if (!isset($user_id)) {
        return "Missing User Id, nothing done";
    }

    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

    $output = $cma->alldatajobs($user_id, $zip, $distance, $onetcode, $keyword, $active_yn, $created_time);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}
/**
 * AJAX function for targeting an item in a notebook for CMA
 */
function cma_target_notebook_item($item_type, $item_id = NULL, $item_stfips = NULL)
{
//    error_log('cma_target_notebook_item - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $item_stfips . ':');

    // If no onetcode is passed, we create an appropriate message
    if (!isset($item_id)) {
        return "Missing " . ucfirst($item_type) . " Id, nothing targeted";
    }

    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();
 
    $output = $cma->targetNotebookItem($item_type,$item_id,$item_stfips);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}

/**
 * AJAX function for saving item to CMA USER KEY
 */
function cma_save_user_key($key_category, $key_name, $key_value=false, $key_id=false)
{
 
	if (!$key_category) {
    	echo "Missing user key category information,  nothing saved.";
    	die;
 	}
	if (!$key_name) {
   		echo "Missing user key name information,  nothing saved.";
   		die;
	}
        
 
    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

    $output = $cma->saveUserKey($key_category, $key_name, $key_value, $key_id);

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}

/**
 * AJAX function for deleting item from CMA USER KEY
 */
function cma_delete_user_key($key_category, $key_name, $key_value=false, $key_id=false)
{
 	if ( !$key_id )
  	{
		if (!$key_category) {
	     	echo "Missing user key category information,  nothing saved";
	     	die;
	   	}
	 	if (!$key_name) {
	    	echo "Missing user key name information,  nothing saved";
	    	die;
		}
	}
 
    $output = '';

    $cma = vcnCma::getInstance();

    $cma->getCmaUserInfo();

    $output = $cma->deleteUserKey( $key_category, $key_name, $key_value, $key_id );

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}


/**
 * AJAX function for deleting item from CMA Info
 */
function cma_update_user_info($name, $value=false)
{
 	if ( !name )
  	{
 		echo "Missing user information,  nothing saved";
	 	die;
 	}
    $output = '';
    $cma = vcnCma::getInstance();
    $cma->$name = $value;
     $output = $cma->updateCmaUserInfo( );

    echo $output;
    die; // this prevents theming and such, returning just the results of the rest call....
}


