<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.list.query
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

global $db_com;

require_once cot_incfile('comments', 'plug');

$join_columns .= ", (SELECT COUNT(*) FROM `$db_com` WHERE com_area = 'market' AND com_code = m.item_id) AS com_count";