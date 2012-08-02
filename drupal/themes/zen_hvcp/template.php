<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
// $Id: template.php,v 1.21 2009/08/12 04:25:15 johnalbin Exp $

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to zen_hvcp_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: zen_hvcp_breadcrumb()
 *
 *   where zen_hvcp is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */

// trying to set the cache to public
ini_set('session.cache_limiter','public');

/**
 * Implementation of HOOK_theme().
 */
function zen_hvcp_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  //For the new login form
  $hooks['user_login'] = array(
        'template' => 'user-login',
        'arguments' => array('form' => NULL)
  );
  
  //Hook for the registration form 
  $hooks['user_register'] = array(
        'template' => 'user-register',
        'arguments' => array('form' => NULL)
  );  
  
  //Hook for the forgot password page
  
  $hooks['user_pass'] = array(
      'template' => 'user-pass',
      'arguments' => array('form' => NULL)
  );
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}


/**
 * 
 * This is the preprocess function for the login form
 */
function zen_hvcp_preprocess_user_login(&$variables) {
  $variables['intro_text'] = t('To use the Provider Portal to access the information on the VCN related to your institution, you must first register and go through a validation process. This is to safeguard the integrity of the information in the VCN. Click \'Create new account\'  below to begin.  If you have already registered and have an account, please click \'Log in\'. ');
  $variables['rendered'] = drupal_render($variables['form']);
}

/**
 * This is the preprocess function for the registrattion form 
 * 
 */

function zen_hvcp_preprocess_user_register(&$variables) {
  $variables['intro_text'] = t('This is my super aaaawwwwesome reg form');
  $variables['rendered'] = drupal_render($variables['form']);
}

/**
 * This is the preprocess function for the password request form 
 * 
 */

function zen_hvcp_preprocess_user_pass(&$variables) {
  $variables['intro_text'] = t('Forgot Password for Provider Portal');
  $variables['rendered'] = drupal_render($variables['form']);
}


/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function zen_hvcp_menu_local_tasks() {
  $output = '';

  // CTools requires a different set of local task functions.
  if (module_exists('ctools')) {
    ctools_include('menu');
    $primary = ctools_menu_primary_local_tasks();
    $secondary = ctools_menu_secondary_local_tasks();
    $tertiary = ctools_menu_local_tasks(2);
  }
  else {
    $primary = menu_primary_local_tasks();
    $secondary = menu_secondary_local_tasks();
    $tertiary = menu_local_tasks(2);
  }

  if ($primary) {
    $output .= '<div class="primary-tabs"><div class="primary-tabs-inner"><ul class="tabs primary clearfix">' . $primary . '</ul></div></div>';
  }
  if ($secondary) {
    if(strpos($_SERVER['REQUEST_URI'],"cma/history/publication")!==false)
      $secondary=str_replace('<a href="/drupal/cma/history/publication','<a class="active" href="/drupal/cma/history/publication',$secondary);
    if(strpos($_SERVER['REQUEST_URI'],"cma/history/employment")!==false)
      $secondary=str_replace('<a href="/drupal/cma/history/employment','<a class="active" href="/drupal/cma/history/employment',$secondary);
    if(strpos($_SERVER['REQUEST_URI'],"cma/history/education")!==false)
      $secondary=str_replace('<a href="/drupal/cma/history/education','<a class="active" href="/drupal/cma/history/education',$secondary);
    if(strpos($_SERVER['REQUEST_URI'],"cma/history/certification")!==false)
      $secondary=str_replace('<a href="/drupal/cma/history/certification','<a class="active" href="/drupal/cma/history/certification',$secondary);
    if(strpos($_SERVER['REQUEST_URI'],"cma/history/association")!==false)
      $secondary=str_replace('<a href="/drupal/cma/history/association','<a class="active" href="/drupal/cma/history/association',$secondary);
    $output .= '<div class="secondary-tabs"><div class="secondary-tabs-inner"><ul class="tabs secondary clearfix">' . $secondary . '</ul></div></div>';
  }

  if ($tertiary) {
    $output .= '<div class="tertiary-tabs"><div class="tertiary-tabs-inner"><ul class="tabs tertiary clearfix">' . $tertiary . '</ul></div></div>';
  }

  return $output;
}



/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function zen_hvcp_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function zen_hvcp_preprocess_page(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function zen_hvcp_preprocess_node(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // zen_hvcp_preprocess_node_page() or zen_hvcp_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $vars['node']->type;
  if (function_exists($function)) {
    $function($vars, $hook);
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function zen_hvcp_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function zen_hvcp_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 *
 * @param <type> $element
 * @return <type>
 * this function ensures that only error messages are shown to the admin and the other status message displayed in
 * yellow box will be shown to the non admin users
 * it is conflicting with tommy's login error messages, So I am commenting this out
 */
/*

function phptemplate_status_messages($display = NULL) {
  $output = '';
   global $user;
 $is_admin = user_access('access administration pages');
  foreach (drupal_get_messages($display) as $type => $messages) {

  	if($is_admin == 0 && $type == 'error'){ //echo $is_admin.'>>'.$type.'<br>';
   // $output = '';
  	}else{
  		$output .= "<div class=\"messages $type\" >\n";
  		 if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
      	if($is_admin){
      		 $output .= '  <li>'. $message ."  </li>\n";
    	}else{
      			if($type == 'status')
      		    $output .= '  <li>'. $message ."  </li>\n";
      	}
      }
      $output .= " </ul>\n";
    }
    else {
    if($is_admin){
         $output .= $messages[0];
     	}else{
     		if($type == 'status'  ){ //echo $is_admin.' eslse >>'.$type.'<br>';
      		$output .= $messages[0];
     		}
     	}

    }

    $output .= "</div>\n";
  	}

  }
  //echo '>>>'.$output.'<<<';
  return $output;
}*/

function zen_hvcp_image_button($element) {
  // Make sure not to overwrite classes.
  if (isset($element['#attributes']['class'])) {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'] .' '. $element['#attributes']['class'];
  }
  else {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'];
  }

  $retval = '<input type="image" name="'. $element['#name'] .'" '.
    (!empty($element['#value']) ? ('value="'. check_plain($element['#value']) .'" ') : '') .
    'id="'. $element['#id'] .'" '.
    drupal_attributes($element['#attributes']) .
    ' src="'. base_path() . $element['#src'] .'" '.
    (!empty($element['#title']) ? 'alt="'. check_plain($element['#title']) .'" title="'. check_plain($element['#title']) .'" ' : '' ) .
    "/>";
  if ($element['#name']=="createcancel") {
    	$retval .= "<br /><br /><b>Note: An e-mail will be sent for your confirmation.</b>\n";
    	$retval .= "<br /><br /><i>Items with an asterisk(*) must be filled in.</i>";
    }
  elseif ($element['#name']=="cancel") {
    	$retval .= "<br /><br /><i>Items with an asterisk(*) must be filled in.</i>";
    }

  return $retval;
}

/**
* Override or insert PHPTemplate variables into the search_theme_form template.
*
* @param $vars
*   A sequential array of variables to pass to the theme template.
* @param $hook
*   The name of the theme function being called (not used in this case.)
*/
function zen_hvcp_preprocess_search_block_form(&$vars, $hook) {
  // Set a default value for text inside the search box field.
  $vars['form']['search_block_form']['#value'] = t('Search');
  
  // Add a custom class and placeholder text to the search box.
  $vars['form']['search_block_form']['#attributes'] = array('class' => 'NormalTextBox txtSearch', 'onblur' => "if (this.value == '') { this.value = '".$vars['form']['search_block_form']['#value']."'; this.style.fontWeight = 'bold'; this.style.color = '#bbbbbb'; }", 'onfocus' => "if (this.value == '".$vars['form']['search_block_form']['#value']."') {this.value = ''; this.style.fontWeight = 'normal'; this.style.color = '#000000'; }" );
  
  // Rebuild the rendered version (search form only, rest remains unchanged)
  unset($vars['form']['search_block_form']['#printed']);
  $vars['search']['search_block_form'] = drupal_render($vars['form']['search_block_form']);
    
  // Collect all form elements to make it easier to print the whole form.
  $vars['search_form'] = implode($vars['search']);
}

/**
 * Theme output of user signature.
 *
 * @ingroup themeable
 */
function zen_hvcp_user_signature($signature) {
  $output = '';
  if ($signature) {
    $output .= '<div class="clear">';
    $output .= '<div> </div>';
    $output .= $signature;
    $output .= '</div>';
  }
  return $output;
}

/*
 * theme quiz 
 */
 
function zen_hvcp_quiz_view_stats($node) {
  // Fetch data
  $stats = array(
    array(
      'title' => t('Questions'),
      'data' => $node->number_of_questions,
    ),
  );
  if ($node->show_attempt_stats) {
    $takes = $node->takes == 0 ? t('Unlimited') : $node->takes;
    $stats[] = array(
      'title' => t('Attempts allowed'),
      'data' => $takes,
    );
  }
  if ($node->quiz_always) {
    $stats[] = array(
      'title' => t('Available'),
      'data' => t('Always'),
    );
  }
  else {
    $stats[] = array(
      'title' => t('Opens'),
      'data' => format_date($node->quiz_open, 'small'),
    );
    $stats[] = array(
      'title' => t('Closes'),
      'data' => format_date($node->quiz_close, 'small'),
    );
  }
  if (!empty($node->pass_rate)) {
    $stats[] = array(
      'title' => t('Pass rate'),
      'data' => $node->pass_rate .' %',
    );
  }
  if (!empty($node->time_limit)) {
    $stats[] = array(
      'title' => t('Time limit'),
      'data' => _quiz_format_duration($node->time_limit),
    );
  }
  $stats[] = array(
    'title' => t('Backwards navigation'),
    'data' => $node->backwards_navigation ? t('Allowed') : t('Forbidden'),
  );
  // Format and output the data
  $out = '<table id="quiz-view-table">' . "\n";
  foreach ($stats as $stat) {
    $out .= '<tr><td class="quiz-view-table-title"><strong>'. $stat['title'] .':</strong></td><td class="quiz-view-table-data"><em>'. $stat['data'] .'</em></td></tr>' . "\n";
  }
  $out .= '</table>' . "\n";
  $out = "<div id=\"quiz_progress\"><b>This test contains " . $node->number_of_questions . " multiple choice questions.  There is only one correct answer for each question. You may skip questions and return to them at any point during the test.  Once you reach the last question and click \"Finish\" the test will be closed and you will not be able to make any further changes.</b></div><br />";
  return $out;
}

function zen_hvcp_quiz_take_summary($quiz, $questions, $score, $summary) {
  // Set the title here so themers can adjust.
  drupal_set_title(check_plain($quiz->title));

  // Display overall result.
  $output = '<div id="proctored_quiz_results" style="display:none">';
  if (!empty($score['possible_score'])) {
    if (!$score['is_evaluated']) {
      $msg = t('Parts of this @quiz have not been evaluated yet. The score below is not final.', array('@quiz' => QUIZ_NAME));
      drupal_set_message($msg, 'warning');
    }
    $output .= '<div id="quiz_score_possible">'. t('You got %num_correct of %question_count possible points.', array('%num_correct' => $score['numeric_score'], '%question_count' => $score['possible_score'])) .'</div>'."\n";
    $output .= '<div id="quiz_score_percent">'. t('Your score: %score %', array('%score' => $score['percentage_score'])) .'</div>'."\n";
  }
  if (isset($summary['passfail']))
    $output .= '<div id="quiz_summary">'. $summary['passfail'] .'</div>'."\n";
  if (isset($summary['result']))
    $output .= '<div id="quiz_summary">'. $summary['result'] .'</div>'."\n";
  // Get the feedback for all questions. These are included here to provide maximum flexibility for themers
  if ($quiz->display_feedback) {
    $output .= drupal_get_form('quiz_report_form', $questions);
  }
  $output .= '</div>';
  $output = ""; // ignore above summary
  
  // get required data for proctor validation
  
  $percentscore = $score['percentage_score'];
  $_SESSION['test_score'] = array($percentscore);
  global $user;
  $proctor_name_check = null;
  $proctor_pass_check = null;
  if ($user->uid>0) {
     $proctor_query = "select name, md5(pass) encryptedpass from users where uid = " . $user->uid;
	 $proctor_results = db_query($proctor_query);
	 while ($row = db_fetch_array($proctor_results)) {
        $proctor_name_check = strtolower($row['name']);
		$proctor_pass_check = $row['encryptedpass'];
     }
  }
  
  // create javascript function to validate proctor id, password and validated field
  
  if (empty($proctor_name_check) || empty($proctor_pass_check)) {
    $validate_script = 
     "function validateProctorForm() {
	     return false; 
	  };";
  } else {
    // since this will be exposed, we will get the MD5 of password (stored as MD5) from SQL, and must double-MD5 the input password here to match it
    $validate_script = 
       "function validateProctorForm() {
	       var proctor_name = document.forms['proctor_save']['proctor_name'].value.toLowerCase();
		   var proctor_check = MD5(MD5(document.forms['proctor_save']['proctor_pass'].value));
		   var proctor_validate = document.forms['proctor_save']['proctor_validated'].value;
		   
		   if ((proctor_name=='" . $proctor_name_check . "') && 
		       (proctor_check=='" . $proctor_pass_check . "') && 
			   (proctor_validate=='Yes')) {
			  return true;
		   } else {
			  alert('Please try again.');
			  return false;
		   }
	    };";
  }
  $output .= "<script type=\"text/javascript\">";
  $output .= $validate_script;
  $output .= "</script>";
  
  // display form for proctor final step

  $output .= "<b>PROCTOR: Please enter all fields below to complete the test process.  All fields must be filled out correctly for the score to be registered.</b><br /><br />";
  $output .= '<form id="proctor_save" name="proctor_save" action="/healthcare/proctored_quiz_process" onsubmit="return validateProctorForm()">';
  $output .= '<b>Proctor ID:</b> <label><input id="proctor_name" type="textfield" size="20" /></label><br />';
  $output .= '<b>Proctor Password:</b> <label><input id="proctor_pass" type="password" size="20" /></label><br />';
  //$output .= '<b>Test Completed Successfully?</b> <label><select id="proctor_validated"><option value="No" selected>No</option><option value="Yes">Yes</option></select></label><br />';
  $output .= '<input type="hidden" id="proctor_validated" name="proctor_validated" value="Yes" />';
//$output .= '<input type="submit" value="Sign Off" />';
  $output .= '<input alt="Sign Off" type="image" value="Sign Off" src="'.base_path().'sites/all/themes/zen_hvcp/images/signoff.png" />';
  $output .= '</form>';
  return $output;
}

// Andrew's more_link function for the forum

function zen_hvcp_more_link($url, $title) {
	if (stristr($url,'/forum')) {
		return '';
	} else { 
		return '<div class="more-link">' . t('<a href="@link" title="@title">more</a>', array('@link' => check_url($url), '@title' => $title)) . '</div>';
	}
}
