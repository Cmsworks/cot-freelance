<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.list.tags
Tags=market.list.tpl:{LIST_COMMENTS},{LIST_COMMENTS_DISPLAY}
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

require_once cot_incfile('comments', 'plug');

$t->assign(array(
	'LIST_COMMENTS' => cot_comments_link('market', 'c='.$c, 'market', $c),
	'LIST_COMMENTS_COUNT' => cot_comments_count('market', $c),
	'LIST_COMMENTS_DISPLAY' => cot_comments_display('market', $c, $c)
));