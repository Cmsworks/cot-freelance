<?php

/**
 * Payments module
 *
 * @package payments
 * @version 1.1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('payments', 'any', 'RWA');
cot_block($usr['auth_read']);

$msg = cot_import('msg', 'G', 'INT');

$t = new XTemplate(cot_tplfile('payments.error', 'module'));

$t->assign('ERROR_TEXT', $L['payments_error_message_'.$msg]);

$t->parse('MAIN');
$module_body = $t->text('MAIN');