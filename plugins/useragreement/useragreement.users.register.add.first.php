<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.register.add.first
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

$ruseragreement = cot_import('ruseragreement', 'P', 'BOL') ? true : false;

if (!$ruseragreement)
{
	cot_error($L['useragreement_need_agree'], 'ruseragreement');
}
?>