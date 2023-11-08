<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.list.loop
Tags=market.list.tpl:{LIST_ROW_COMMENTS}
[END_COT_EXT]
==================== */

/**
 * Comments system for Market (Cotonti)
 *
 * @package commentsmarket
 * @version 1.0
 * @author CrazyFreeMan
 * @copyright Copyright (c) CrazyFreeMan 2015
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$page_urlp = empty($item['item_alias']) ? array('c' => $item['item_cat'], 'id' => $item['item_id']) : array('c' => $item['item_cat'], 'al' => $item['item_alias']);
$t->assign(array(
	'LIST_ROW_COMMENTS' => cot_comments_link('market', $page_urlp, 'market', $item['item_id'], $c, $pag),
	'LIST_ROW_COMMENTS_COUNT' => cot_comments_count('market', $item['item_id'], $pag)

));