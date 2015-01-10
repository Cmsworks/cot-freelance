<?php
/**
 * roboxbilling plugin
 *
 * @package roboxbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */
$L['cfg_mrh_login'] = array('Логин в Робокассе');
$L['cfg_mrh_pass1'] = array('Пароль #1 в Робокассе');
$L['cfg_mrh_pass2'] = array('Пароль #2 в Робокассе');
$L['cfg_testmode'] = array('Тестовый режим');
$L['cfg_enablepost'] = array('Enable POST');
$L['cfg_rate'] = array('Exchange rate');

$L['roboxbilling_title'] = 'Robokassa';

$L['roboxbilling_error_paid'] = 'Payment was successful. In the near future the service will be activated!';
$L['roboxbilling_error_done'] = 'Payment was successful.';
$L['roboxbilling_error_incorrect'] = 'The signature is incorrect!';
$L['roboxbilling_error_otkaz'] = 'Failure to pay.';
$L['roboxbilling_error_title'] = 'Result of the operation of payment';
$L['roboxbilling_error_fail'] = 'Payment is not made! Please try again. If the problem persists, contact your site administrator';

$L['roboxbilling_redirect_text'] = 'Now will redirect to the page of the paid services. If it does not, click <a href="%1$s">here</a>.';