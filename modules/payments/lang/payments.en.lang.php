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
$L['cfg_transfers_enabled'] = array('Enable transfers between users');
$L['cfg_transfertax'] = array('Charges for transfers between users', '%');
$L['cfg_transfermin'] = array('The minimum amount for transfer', $cfg['payments']['valuta']);
$L['cfg_transfermax'] = array('The maximum amount for transfer', $cfg['payments']['valuta']);
$L['cfg_transfertaxfromrecipient'] = array('Charge a commission to the recipient');
$L['cfg_payouts_enabled'] = array('Enable requests of payout');
$L['cfg_payouttax'] = array('Commission for payout', '%');
$L['cfg_payoutmin'] = array('The minimum amount for payout', $cfg['payments']['valuta']);
$L['cfg_payoutmax'] = array('The maximum amount for payout', $cfg['payments']['valuta']);
$L['cfg_clearpaymentsdays'] = array('Clean the base of unpaid bills after', 'дней');

$L['payments_mybalance'] = 'My balance';
$L['payments_balance'] = 'Balance';
$L['payments_paytobalance'] = 'To deposit';
$L['payments_history'] = 'History';
$L['payments_payouts'] = 'Payout';
$L['payments_balance_payouts_button'] = 'New request';
$L['payments_balance_payout_error_summ'] = 'Amount empty';
$L['payments_balance_payout_list'] = 'Requests';
$L['payments_balance_payout_title'] = 'Payout request';
$L['payments_balance_payout_desc'] = 'Payout';
$L['payments_balance_payout_summ'] = 'Amount';
$L['payments_balance_payout_tax'] = "Commission";
$L['payments_balance_payout_total'] = "Amount to be deducted";
$L['payments_balance_payout_details'] = 'Details';
$L['payments_balance_payout_error_details'] = 'Details is empty';
$L['payments_balance_payout_error_balance'] = 'A very large amount';
$L['payments_balance_payout_error_min'] = 'Amount shall not be less than %1$s %2$s';

$L['payments_balance_billing_error_summ'] = 'Amount empty';
$L['payments_balance_billing_desc'] = 'Account funding';
$L['payments_balance_billing_summ'] = 'Enter the amount';

$L['payments_balance_billing_admin_subject'] = 'Recharge deposit';
$L['payments_balance_billing_admin_body'] = 'Hi,

User %1$s recharged the deposit on the site.

Details:

Amount: %2$s
Transaction number: %3$s.
Transaction date: %4$s.

';

$L['payments_balance_payout_admin_subject'] = 'Request of payout ';
$L['payments_balance_payout_admin_body'] = 'Hi,

User %1$s leave request to payout from his account on the site. 

Details: 

Amount: %2$s 
Request number: %3$s 
Request date: %4$s 
Details: %5$s.

';

$L['payments_balance_transfer_admin_subject'] = 'Transfer for user';
$L['payments_balance_transfer_admin_body'] = 'Hi,

User %1$s sent transfer for user %2$s.

Details:

Amount: %3$s %7$s
Commission: %4$s %7$s
Eliminated from the sender: %5$s %7$s
Posted to the recipient: %6$s %7$s
Date: %8$s
Comment: %9$s

';

$L['payments_balance_transfer_recipient_subject'] = 'Transfer for you';
$L['payments_balance_transfer_recipient_body'] = 'Hi, %2$s

User %1$s sent transfer for your account on site

Details:

Amount: %3$s %7$s
Commission: %4$s %7$s
Posted to you: %6$s %7$s
Date: %8$s
Comment: %9$s

';

$L['payments_transfer'] = 'Transfer for user';
$L['payments_balance_transfer_desc'] = "Transfer from %1\$s to %2\$s (%3\$s)";
$L['payments_balance_transfer_comment'] = "Comment";
$L['payments_balance_transfer_summ'] = "Amount";
$L['payments_balance_transfer_tax'] = "Commission";
$L['payments_balance_transfer_total'] = "Amount to be deducted";
$L['payments_balance_transfer_username'] = "User login";
$L['payments_balance_transfer_error_username'] = "User not found";
$L['payments_balance_transfer_error_summ'] = 'Amount empty';
$L['payments_balance_transfer_error_balance'] = 'Sum exceeds your account balance';
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