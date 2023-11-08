<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=folio.tags
Tags=folio.tpl:{PRD_COMMENTS},{PRD_COMMENTS_DISPLAY},{PRD_COMMENTS_COUNT},{PRD_COMMENTS_RSS}
[END_COT_EXT]
==================== */

/**
 * Comments system for Folio (Cotonti)
 *
 * @package commentsfolio
 * @version 1.0
 * @author CrazyFreeMan, Cmsworks
 * @copyright Copyright (c) CrazyFreeMan 2015, Cmsworks.ru, 2017
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('comments', 'plug');

$t->assign(array(
	'PRD_COMMENTS' => cot_comments_link('folio', $pageurl_params, 'folio', $item['item_id'] , $item['item_cat'], $pag),
	'PRD_COMMENTS_DISPLAY' => cot_comments_display('folio', $item['item_id'] , $item['item_cat']),
	'PRD_COMMENTS_COUNT' => cot_comments_count('folio',$item['item_id'] , $pag),
	'PRD_COMMENTS_RSS' => cot_url('rss', 'm=comments&id=' . $item['item_id'])
));