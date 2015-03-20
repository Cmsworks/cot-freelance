<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=admin.structure.first
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('usercategories', 'plug');
$extension_structure[] = 'usercategories';