<?php

/**
 * Payments module
 *
 * @package payments
 * @version 1.1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('payments', 'any', 'RWA');
cot_block($usr['auth_read']);

$t = new XTemplate(cot_tplfile('payments.default', 'module'));

$t->parse('MAIN');
$module_body = $t->text('MAIN');
?>