<?php
/**
 * Reviews plugin
 *
 * @package reviews
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_checkprojects'] = 'Allow add reviews only at presence of joint projects';
$L['cfg_userall'] = 'Show on user details page all reviews';

$L['reviews_chooseprj'] = 'Choose project';
$L['reviews_reviewforproject'] = 'For';
$L['reviews_projectsonly'] = 'Reviews can be left only for the projects for which you worked.';
$L['reviews_text'] = 'Text of review';
$L['reviews_score'] = 'Score';
$L['reviews_review'] = 'Review';
$L['reviews_reviews'] = 'Reviews';
$L['reviews_add_review'] = 'Add review';
$L['reviews_edit_review'] = 'Edit eview';

$L['reviews_score_values'] = array(1, -1);
$L['reviews_score_titles'] = array('Positive', 'Negative');

$L['reviews_error_toyourself'] = 'You can not leave a review yourself';
$L['reviews_error_projectsonly'] = 'Reviews can be left only for the projects for which you worked';
$L['reviews_error_exists'] = 'Review has already been created';
$L['reviews_error_emptytext'] = 'Review can not be empty';
$L['reviews_error_emptyscore'] = 'Specify evaluation';