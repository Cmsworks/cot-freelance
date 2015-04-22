<?php
/**
 * Paypro plugin
 *
 * @package payrpo
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_cost'] = array('Cosr per month', '');
$L['cfg_offerslimit'] = array('Offers limit count for simple users', '');
$L['cfg_projectslimit'] = array('Projects limit count for simple users', '');

$L['info_desc'] = 'Pro-accounts';

$L['paypro_forpro'] = 'Only for PRO';

$L['paypro_buypro_title'] = 'Buy Pro-account';
$L['paypro_buypro_paydesc'] = 'Buy Pro-account';
$L['paypro_costofmonth'] = 'Cost per month';
$L['paypro_error_months'] = 'Specify the time';

$L['paypro_buy'] = 'Buy';
$L['paypro_month'] = 'month';

$L['paypro_header_buy'] = 'Buy PRO';
$L['paypro_header_expire'] = 'PRO is available to';
$L['paypro_header_expire_short'] = 'PRO to';
$L['paypro_header_extend'] = 'Extend';

$L['paypro_warning_projectslimit_empty'] = 'You can no longer publish projects. Maximum number of projects for the publication is: '.$cfg['plugin']['paypro']['projectslimit'].' night. To remove this restriction, use PRO-service account.';
$L['paypro_warning_offerslimit_empty'] = 'You can no longer post project proposals. The maximum number of responses to the projects is: '.$cfg['plugin']['paypro']['offerslimit'].' night. To remove this restriction, use PRO-service account.';
$L['paypro_warning_onlyforpro'] = 'You can not leave suggestions for this project, as it is only available for users with PRO-account. To remove this restriction, use PRO-service account.';

$L['paypro_error_username'] = 'Login empty';
$L['paypro_custom_error_userempty'] = 'User not found';
$L['paypro_error_monthsempty'] = 'Months is empty';
$L['paypro_addproacc'] = 'Adding PRO-accaout for user';

$L['paypro_giftpro'] = 'Gift PRO';
$L['paypro_giftfor'] = 'Gift for user';
$L['paypro_giftpro_paydesc'] = 'Buying PRO to gift for ';
$L['paypro_error_user'] = 'User not found to gift PRO';
