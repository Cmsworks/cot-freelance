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

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_balance_enabled'] = array('Turn on internal billings');
$L['cfg_valuta'] = array('Valuta');
$L['cfg_clearpaymentsdays'] = array('Clean the base of unpaid bills after (days)');

$L['payments_mybalance'] = 'My balance';
$L['payments_balance'] = 'Balance';
$L['payments_paytobalance'] = 'To deposit';
$L['payments_history'] = 'History';
$L['payments_payout'] = 'Payout';

$L['payments_balance_payout_error_summ'] = 'Amount empty';
$L['payments_balance_payout_list'] = 'Requests';
$L['payments_balance_payout_title'] = 'Payout request';
$L['payments_balance_payout_desc'] = 'Payout';
$L['payments_balance_payout_summ'] = 'Amount';
$L['payments_balance_payout_details'] = 'Details';
$L['payments_balance_payout_error_details'] = 'Details is empty';
$L['payments_balance_payout_error_balance'] = 'A very large amount';

$L['payments_balance_billing_error_summ'] = 'Amount empty';
$L['payments_balance_billing_desc'] = 'Account funding';
$L['payments_balance_billing_summ'] = 'Enter the amount';

$L['payments_transfer'] = 'Transfer for user';
$L['payments_balance_transfer_desc'] = "Transfer from %1\$s to %2\$s (%3\$s)";
$L['payments_balance_transfer_comment'] = "Comment";
$L['payments_balance_transfer_summ'] = "Amount";
$L['payments_balance_transfer_username'] = "User login";
$L['payments_balance_transfer_error_username'] = "User not found";
$L['payments_balance_transfer_error_summ'] = 'Amount empty';
$L['payments_balance_transfer_error_comment'] = 'Comment is empty';

$L['payments_billing_title'] = 'Billings';
$L['payments_emptybillings'] = 'At the moment, payment methods available. Please try to pay later.';

$L['payments_allusers'] = 'All users';
$L['payments_siteinvoices'] = 'Site invoices';
$L['payments_debet'] = 'Debet';
$L['payments_credit'] = 'Credit';
$L['payments_allpayments'] = 'Summ all payments';
$L['payments_area'] = 'Type';
$L['payments_code'] = 'Code';
$L['payments_desc'] = 'Desc';
$L['payments_summ'] = 'Summ';

?>