<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=payments.billing.register
 * [END_COT_EXT]
 */
/**
 * Ikassa billing Plugin
 *
 * @package ikassabilling
 * @version 2.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('ikassabilling', 'plug');

$cot_billings['ikassa'] = array(
	'plug' => 'ikassabilling',
	'title' => $L['ikassabilling_title'],
	'icon' => $cfg['plugins_dir'] . '/ikassabilling/images/ikassa.png'
);