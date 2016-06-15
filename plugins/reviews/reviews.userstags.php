<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
 * [END_COT_EXT]
 */
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

if(is_array($user_data)){
	$scores = cot_getreview_scores($user_data['user_id']);

	$temp_array['REVIEWS_NEGATIVE_SUMM'] = $scores['neg']['summ'];
	$temp_array['REVIEWS_POZITIVE_SUMM'] = $scores['poz']['summ'];
	$temp_array['REVIEWS_SUMM'] = $scores['poz']['summ'] + $scores['neg']['summ'];
}