<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=payments.billing.register
 * [END_COT_EXT]
 */
/**
 * Robox billing Plugin
 *
 * @package roboxbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

$cot_billings['robox'] = array(
	'plug' => 'roboxbilling',
	'title' => 'Robokassa',
	'icon' => $cfg['plugins_dir'] . '/roboxbilling/images/robox.png'
);
?>