<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=folio.list.loop
Tags=folio.list.tpl:{LIST_ROW_COMMENTS}
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

$page_urlp = empty($item['item_alias']) ? array('c' => $item['item_cat'], 'id' => $item['item_id']) : array('c' => $item['item_cat'], 'al' => $item['item_alias']);
$t->assign(array(
	'LIST_ROW_COMMENTS' => cot_comments_link('folio', $page_urlp, 'folio', $item['item_id'], $c, $pag),
	'LIST_ROW_COMMENTS_COUNT' => cot_comments_count('folio', $item['item_id'], $pag)
));