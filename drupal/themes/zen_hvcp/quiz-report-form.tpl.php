<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
// $Id: quiz-report-form.tpl.php,v 1.1.2.3 2010/11/05 16:14:48 falcon Exp $

/**
 * @file
 * Themes the question report
 *
 * Available variables:
 * $form - FAPI array
 *
 * All questions are in form[x] where x is an integer.
 * Useful values:
 * $form[x]['question'] - the question as a FAPI array(usually a form field of type "markup")
 * $form[x]['score'] - the users score on the current question.(FAPI array usually of type "markup" or "textfield")
 * $form[x]['max_score'] - the max score for the current question.(FAPI array of type "value")
 * $form[x]['response'] - the users response, usually a FAPI array of type markup.
 * $form[x]['#is_correct'] - If the users response is correct(boolean)
 * $form[x]['#is_evaluated'] - If the users response has been evaluated(boolean)
 */
// $td_classes = array('quiz-report-odd-td', 'quiz-report-even-td');
// $td_class_i = 0;
$p = drupal_get_path('module', 'quiz') .'/theme/';
$q_image = $p. 'question_bg.png';

$student_name = $_SESSION['student_name'][0];

if (empty($student_name)) {
   print "Invalid Student<br />";
} else {
   ?>

   <h2><?php print t('Question Results');?></h2>

   <dl class="quiz-report">

   <?php
   foreach ($form as $key => $sub_form):
     if (!is_numeric($key) || isset($sub_form['#no_report'])) continue;
     unset($form[$key]);
     $c_class = ($sub_form['#is_evaluated']) ? ($sub_form['#is_correct']) ? 'q-correct' : 'q-wrong' : 'q-waiting';
     $skipped = $sub_form['#is_skipped'] ? '<span class="quiz-report-skipped">'. t('(skipped)') .'</span>' : ''?>

	   <dt>
	     <div class="quiz-report-score-container <?php print $c_class?>">
	  	   <span>
	         <?php print t('Score')?>
		     <?php print drupal_render($sub_form['score'])?>
		     <?php print t('of') .' '. $sub_form['max_score']['#value']?>
		     <?php print '<br><em>'. $skipped .'</em>'?>
		   </span>
         </div>

	     <p class="quiz-report-question"><strong><?php print t('Question')?>: </strong></p>
	     <?php print drupal_render($sub_form['question']);?>
	   </dt>

       <dd>
	     <p><strong><?php print t('Response')?>: </strong></p>

         <?php print drupal_render($sub_form['response']); ?>
       </dd>

   <?php endforeach; ?>
   </dl>

   <div style="float:right;"><?php print drupal_render($form);?></div>
   <?php
   }
?>