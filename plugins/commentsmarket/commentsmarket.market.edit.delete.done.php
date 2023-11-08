<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.edit.delete.done
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

cot_comments_remove('market', $id);