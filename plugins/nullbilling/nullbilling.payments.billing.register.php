<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=payments.billing.register
 * [END_COT_EXT]
 */
/**
 * Null billing Plugin
 *
 * @package nullbilling
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('nullbilling', 'plug');

$cot_billings['null'] = array(
	'plug' => 'nullbilling',
	'title' => $L['nullbilling_title'],
	'icon' => $cfg['plugins_dir'] . '/nullbilling/images/nullbill.png'
);