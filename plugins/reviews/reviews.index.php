<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=index.tags
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

if (cot::$usr['id'] > 0) {
	$scores = cot_getreview_scores(cot::$usr['id']);
	$t->assign(array(
		"USERINFO_REVIEWS_NEGATIVE_SUMM" => $scores['neg']['summ'],
		"USERINFO_REVIEWS_POZITIVE_SUMM" => $scores['poz']['summ'],
		"USERINFO_RATING" => !empty(cot::$usr['profile']['user_rating']) ? cot::$usr['profile']['user_rating'] : 0,
	));
}