<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=folio.edit.delete.done
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

cot_comments_remove('folio', $id);