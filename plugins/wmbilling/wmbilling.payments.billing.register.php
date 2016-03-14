<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=payments.billing.register
 * [END_COT_EXT]
 */
/**
 * Webmoney billing Plugin
 *
 * @package wmbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('wmbilling', 'plug');

$cot_billings['webmoney'] = array(
	'plug' => 'wmbilling',
	'title' => $L['wmbilling_title'],
	'icon' => $cfg['plugins_dir'] . '/wmbilling/images/webmoney.png'
);