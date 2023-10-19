<?php

defined('COT_CODE') or die('Wrong URL.');

$L['cfg_levelpay'] = array('Размер вознаграждения за пополнение счета (в процентах для каждого уровня партнеров)', '');
$L['cfg_maxlevelstoshow'] = array('Число уровней рефералов доступных для просмотра партнеру', '');
$L['cfg_refpoints'] = array('Количество начисляемых баллов за приглашенного реферала', '');
$L['cfg_userpageref'] = array('Учитывать рефералов при переходе на страницу пользователя', '');

$L['affiliate'] = 'Affiliate programm';
$L['affiliate_payment_paydesc'] = 'Affiliate payment';

$L['affiliate_link_title'] = 'Referral link';
$L['affiliate_tree_title'] = 'Your referrals';
$L['affiliate_payments_title'] = 'Affiliate payments';

$L['affiliate_partner'] = 'Partner';
$L['affiliate_referal'] = 'Referral';
$L['affiliate_partner_summ'] = 'Payment for partner';

$L['affiliate_mail_newreferal_subject'] = 'New referral';
$L['affiliate_mail_newreferal_body'] = "Congratulations, you have a new referral to login: %1\$s.";

$L['affiliate_mail_newpayment_subject'] = 'Affiliate payout';
$L['affiliate_mail_newpayment_body'] = 'Congratulations to your account payment on an affiliate program of: %1$s '.$cfg['payments']['valuta'];

$L['affiliate_refpay_desc'] = 'Payment for the invitation';
$L['affiliate_refpay_mail_subject'] = 'Payment for the invitation';
$L['affiliate_refpay_mail_body'] = "Hi, %1\$s.\nTo your account fee for inviting new referral.";