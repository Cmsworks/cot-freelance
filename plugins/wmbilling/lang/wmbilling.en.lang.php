<?php
/**
 * wmbilling plugin
 *
 * @package wmbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */
$L['cfg_webmoney_purse'] = array('Webmoney кошелек');
$L['cfg_webmoney_wmid'] = array('Webmoney WMID');
$L['cfg_webmoney_skey'] = array('Webmoney Sekret key');
$L['cfg_webmoney_mode'] = array('Test mode');
$L['cfg_webmoney_hashmethod'] = array('Hash method');
$L['cfg_webmoney_rate'] = array('Exchange rate');

$L['wmbilling_title'] = 'Webmoney';

$L['wmbilling_formtext'] = 'Now you will be redirected to the payment system Webmoney for payment. If not, click the "Go to payment".';
$L['wmbilling_formbuy'] = 'Go to payment';
$L['wmbilling_error_paid'] = 'Payment was successful. In the near future the service will be activated!';
$L['wmbilling_error_done'] = 'Payment was successful.';
$L['wmbilling_error_incorrect'] = 'The signature is incorrect!';
$L['wmbilling_error_otkaz'] = 'Failure to pay.';
$L['wmbilling_error_title'] = 'Result of the operation of payment';
$L['wmbilling_error_fail'] = 'Payment is not made! Please try again. If the problem persists, contact your site administrator';

$L['wmbilling_redirect_text'] = 'Now will redirect to the page of the paid services. If it does not, click <a href="%1$s">here</a>.';