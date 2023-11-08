<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=folio.list.tags
Tags=folio.list.tpl:{LIST_COMMENTS},{LIST_COMMENTS_DISPLAY}
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
	'LIST_COMMENTS' => cot_comments_link('folio', 'c='.$c, 'folio', $c),
	'LIST_COMMENTS_COUNT' => cot_comments_count('folio', $c),
	'LIST_COMMENTS_DISPLAY' => cot_comments_display('folio', $c, $c)
));