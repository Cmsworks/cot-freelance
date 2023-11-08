<?php

/**
 * support plugin
 *
 * @package support
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('support', 'plug');

// Registering tables and fields
cot::$db->registerTable('support_tickets');
cot::$db->registerTable('support_messages');

if(empty($cfg['plugin']['support']['email'])){
	$cfg['plugin']['support']['email'] = $cfg['adminemail'];
}