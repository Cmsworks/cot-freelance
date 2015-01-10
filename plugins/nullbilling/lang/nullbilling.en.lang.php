<?php
/**
 * nullbilling plugin
 *
 * @package nullbilling
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');


$L['nullbilling_title'] = 'Test payment system';

$L['nullbilling_error_paid'] = 'Payment was successful. In the near future the service will be activated!';
$L['nullbilling_error_done'] = 'Payment was successful.';
$L['nullbilling_error_incorrect'] = 'The signature is incorrect!';
$L['nullbilling_error_otkaz'] = 'Failure to pay.';
$L['nullbilling_error_title'] = 'Result of the operation of payment';
$L['nullbilling_error_fail'] = 'Payment is not made! Please try again. If the problem persists, contact your site administrator';

$L['nullbilling_redirect_text'] = 'Now will redirect to the page of the paid services. If it does not, click <a href="%1$s">here</a>.';