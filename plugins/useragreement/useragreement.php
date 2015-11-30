<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

/**
 * User Agreement plugin
 *
 * @package useragreement
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('useragreement', 'plug');

$out['subtitle'] = $L['useragreement'];

$t->assign(array(
	'USERAGREEMENT' => $cfg['plugin']['useragreement']['text']
));
?>