<?php

defined('COT_CODE') or die('Wrong URL.');

$L['cfg_levelpay'] = array('Размер вознаграждения за пополнение счета (в процентах для каждого уровня партнеров)', '');
$L['cfg_maxlevelstoshow'] = array('Число уровней рефералов доступных для просмотра партнеру', '');
$L['cfg_refpoints'] = array('Количество начисляемых баллов за приглашенного реферала', '');
$L['cfg_userpageref'] = array('Учитывать рефералов при переходе на страницу пользователя', '');

$L['affiliate'] = 'Рефералы';
$L['affiliate_payment_paydesc'] = 'Партнерская выплата';

$L['affiliate_link_title'] = 'Реферальная ссылка';
$L['affiliate_tree_title'] = 'Приглашенные рефералы';
$L['affiliate_payments_title'] = 'Партнерские выплаты';

$L['affiliate_partner'] = 'Партнер';
$L['affiliate_referal'] = 'Реферал';
$L['affiliate_partner_summ'] = 'Выплата партнеру';

$L['affiliate_mail_newreferal_subject'] = 'Новый реферал';
$L['affiliate_mail_newreferal_body'] = "Здравствуйте, %1\$s.\nПоздравляем, у вас появился новый реферал с логином: %2\$s.";

$L['affiliate_mail_newpayment_subject'] = 'Партнерская выплата';
$L['affiliate_mail_newpayment_body'] = 'Поздравляем, на ваш счет поступила выплата по партнерской программе в размере: %1$s '.$cfg['payments']['valuta'];

$L['affiliate_refpay_desc'] = 'Вознаграждение за нового реферала';
$L['affiliate_refpay_mail_subject'] = 'Вознаграждение за нового реферала';
$L['affiliate_refpay_mail_body'] = "Здравствуйте, %1\$s.\nНа ваш счет поступило вознаграждение за приглашение нового реферала.";
