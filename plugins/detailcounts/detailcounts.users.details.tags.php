<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=users.details.tags
Tags=users.details.tpl:{USERS_DETAILS_DETAILCOUNTS_TITLE},{USERS_DETAILS_DETAILCOUNTS}
[END_COT_EXT]
==================== */
require_once cot_langfile('detailcounts', 'plug');
$t->assign(array(
	'USERS_DETAILS_DETAILCOUNTS_TITLE' => $L["detailcounts_title"],
	'USERS_DETAILS_DETAILCOUNTS' => $urr["user_detailcounts"]
));