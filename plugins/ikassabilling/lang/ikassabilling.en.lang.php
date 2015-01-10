<?php
/**
 * ikassabilling plugin
 *
 * @package ikassabilling
 * @version 2.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_shop_id'] = array('Shop ID (Checkout ID)', '');
$L['cfg_test_key'] = array('Test key', '');
$L['cfg_secret_key'] = array('Secret key', '');
$L['cfg_enablepost'] = array('Enable POST');
$L['cfg_rate'] = array('Exchange rate', '');
$L['cfg_currency'] = array('Currency', '');

$L['ikassabilling_title'] = 'Interkassa';

$L['ikassabilling_formtext'] = 'Now you will be redirected to the payment system Interkassa for payment. If not, click the "Go to payment".';
$L['ikassabilling_formbuy'] = 'Go to payment';
$L['ikassabilling_error_paid'] = 'Payment was successful. In the near future the service will be activated!';
$L['ikassabilling_error_done'] = 'Payment was successful.';
$L['ikassabilling_error_incorrect'] = 'The signature is incorrect!';
$L['ikassabilling_error_otkaz'] = 'Failure to pay.';
$L['ikassabilling_error_title'] = 'Result of the operation of payment';
$L['ikassabilling_error_wait'] = 'Payment is pending. Please wait.';
$L['ikassabilling_error_canceled'] = 'Transfer canceled payment system. Please try again. If the problem persists, contact your site administrator.';
$L['ikassabilling_error_fail'] = 'Payment is not made! Please try again. If the problem persists, contact your site administrator.';

$L['ikassabilling_redirect_text'] = 'Now will redirect to the page of the paid services. If it does not, click <a href="%1$s">here</a>.';