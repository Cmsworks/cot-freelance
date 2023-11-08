<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=header.user.tags
Tags=header.tpl:{HEADER_USER_PRJ_PUBLISHED},{HEADER_USER_PRJ_OFFERS_PUBLISHED}
[END_COT_EXT]
==================== */

$t->assign(array(
			'HEADER_USER_PRJ_PUBLISHED' => cot_prj_published_count($usr['id']),
			'HEADER_USER_PRJ_OFFERS_PUBLISHED' => cot_prj_offers_published_count($usr['id']),
		));