<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=folio.list.query
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

global $db_com;

require_once cot_incfile('comments', 'plug');

$join_columns .= ", (SELECT COUNT(*) FROM `$db_com` WHERE com_area = 'folio' AND com_code = f.item_id) AS com_count";