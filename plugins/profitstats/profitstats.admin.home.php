<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.home.mainpanel
  Order=1
  [END_COT_EXT]
  ==================== */

/**
 * Profit stats
 *
 * @version 1.0
 * @author 
 * @copyright Copyright (c) 
 * */
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('profitstats', 'plug');

switch ($cfg['plugin']['profitstats']['pfst_period']) {
    case 'week':
        $pro_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='pro' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $paytop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.top' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $paytopmarket_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.market' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $paytopprojects_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.projects' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $paytopusers_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.users' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $paymarketbold_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='market.bold' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $paymarkettop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='market.top' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $payprjbold_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='prj.bold' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $payprjtop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='prj.top' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $sbr_summ = $db->query("SELECT SUM(sbr_cost) AS summ FROM $db_sbr WHERE sbr_status='done' AND sbr_done >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $sbr_summ_tax = $db->query("SELECT SUM(sbr_tax) AS summ FROM $db_sbr WHERE sbr_status='done' AND sbr_done >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $sbr_summ_tax_performer = $db->query("SELECT SUM(sbr_performer) AS summ FROM $db_sbr WHERE sbr_status='done' AND sbr_done >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $out1 = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='payout' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $out2 = $db->query("SELECT SUM(out_summ) AS summ FROM $db_payments_outs WHERE out_status='done' AND out_date >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $market_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='marketorders' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        $transfer_summ = $db->query("SELECT SUM(p2.pay_summ) AS summ FROM $db_payments p1 LEFT JOIN {$db_payments} p2 ON p2.pay_code=p1.pay_id WHERE p1.pay_area='transfer' AND p1.pay_status='done' AND p2.pay_userid=p1.pay_code AND p1.pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY))")->fetch();
        break;

    case 'month':
        $pro_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='pro' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $paytop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.top' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $paytopmarket_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.market' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $paytopprojects_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.projects' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $paytopusers_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.users' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $paymarketbold_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='market.bold' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $paymarkettop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='market.top' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $payprjbold_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='prj.bold' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $payprjtop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='prj.top' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $sbr_summ = $db->query("SELECT SUM(sbr_cost) AS summ FROM $db_sbr WHERE sbr_status='done' AND sbr_done >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $sbr_summ_tax = $db->query("SELECT SUM(sbr_tax) AS summ FROM $db_sbr WHERE sbr_status='done' AND sbr_done >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $sbr_summ_tax_performer = $db->query("SELECT SUM(sbr_performer) AS summ FROM $db_sbr WHERE sbr_status='done' AND sbr_done >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $out1 = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='payout' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $out2 = $db->query("SELECT SUM(out_summ) AS summ FROM $db_payments_outs WHERE out_status='done' AND out_date >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $market_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='marketorders' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        $transfer_summ = $db->query("SELECT SUM(p2.pay_summ) AS summ FROM $db_payments p1 LEFT JOIN {$db_payments} p2 ON p2.pay_code=p1.pay_id WHERE p1.pay_area='transfer' AND p1.pay_status='done' AND p2.pay_userid=p1.pay_code AND p1.pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))")->fetch();
        break;

    case 'year':
        $pro_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='pro' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $paytop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.top' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $paytopmarket_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.market' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $paytopprojects_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.projects' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $paytopusers_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.users' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $paymarketbold_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='market.bold' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $paymarkettop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='market.top' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $payprjbold_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='prj.bold' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $payprjtop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='prj.top' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $sbr_summ = $db->query("SELECT SUM(sbr_cost) AS summ FROM $db_sbr WHERE sbr_status='done' AND sbr_done >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $sbr_summ_tax = $db->query("SELECT SUM(sbr_tax) AS summ FROM $db_sbr WHERE sbr_status='done' AND sbr_done >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $sbr_summ_tax_performer = $db->query("SELECT SUM(sbr_performer) AS summ FROM $db_sbr WHERE sbr_status='done' AND sbr_done >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $out1 = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='payout' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $out2 = $db->query("SELECT SUM(out_summ) AS summ FROM $db_payments_outs WHERE out_status='done' AND out_date >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $market_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='marketorders' AND pay_status='done' AND pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        $transfer_summ = $db->query("SELECT SUM(p2.pay_summ) AS summ FROM $db_payments p1 LEFT JOIN {$db_payments} p2 ON p2.pay_code=p1.pay_id WHERE p1.pay_area='transfer' AND p1.pay_status='done' AND p2.pay_userid=p1.pay_code AND p1.pay_adate >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR))")->fetch();
        break;

    default :
        $pro_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='pro' AND pay_status='done' ")->fetch();
        $sbr_summ = $db->query("SELECT SUM(sbr_cost) AS summ FROM $db_sbr WHERE sbr_status='done'")->fetch();
        $sbr_summ_tax_performer = $db->query("SELECT SUM(sbr_performer) AS summ FROM $db_sbr WHERE sbr_status='done'")->fetch();
        $sbr_summ_tax = $db->query("SELECT SUM(sbr_tax) AS summ FROM $db_sbr WHERE sbr_status='done'")->fetch();
        $out1 = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='payout' AND pay_status='done'")->fetch();
        $out2 = $db->query("SELECT SUM(out_summ) AS summ FROM $db_payments_outs WHERE out_status='done'")->fetch();
        $paytop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.top' AND pay_status='done' ")->fetch();
        $paytopmarket_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.market' AND pay_status='done' ")->fetch();
        $paytopprojects_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.projects' AND pay_status='done' ")->fetch();
        $paytopusers_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='paytop.users' AND pay_status='done' ")->fetch();
        $paymarketbold_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='market.bold' AND pay_status='done' ")->fetch();
        $paymarkettop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='market.top' AND pay_status='done' ")->fetch();
        $payprjbold_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='prj.bold' AND pay_status='done' ")->fetch();
        $payprjtop_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='prj.top' AND pay_status='done' ")->fetch();
        $market_summ = $db->query("SELECT SUM(pay_summ) AS summ FROM $db_payments WHERE pay_area='marketorders' AND pay_status='done' ")->fetch();
        $transfer_summ = $db->query("SELECT SUM(p2.pay_summ) AS summ FROM $db_payments p1 LEFT JOIN {$db_payments} p2 ON p2.pay_code=p1.pay_id WHERE p1.pay_area='transfer' AND p1.pay_status='done' AND p2.pay_userid=p1.pay_code ")->fetch();
}


$payments_tax = ($cfg["payments"]["transfertax"]);
$payments_summ_tax['summ'] = ($transfer_summ['summ'] * $payments_tax) / 100;

$market_tax = $cfg["plugin"]["marketorders"]["tax"];
$market_summ_tax['summ'] = ($market_summ['summ'] * $market_tax) / 100;

$out_summ = $out1['summ'] - $out2['summ'];
$total_amount = $sbr_summ_tax['summ'] +
        $sbr_summ_tax_performer ['summ'] +
        #$sbr_summ['summ'] +
        $pro_summ['summ'] +
        $market_summ_tax['summ'] +
        $paytop_summ['summ'] +
        $paytopmarket_summ['summ'] +
        $paytopprojects_summ['summ'] +
        $paytopusers_summ['summ'] +
        $paymarketbold_summ['summ'] +
        $paymarkettop_summ['summ'] +
        $payprjbold_summ['summ'] +
        $payprjtop_summ['summ'] +
        $payments_summ_tax['summ'] +
        $out_summ;

$pft = new XTemplate(cot_tplfile('profitstats.admin.home.mainpanel', 'plug'));

$pft->assign(array(
    'SBR_SUMM' => empty($sbr_summ['summ']) ? 0.00 : $sbr_summ['summ'],
    'SBR_TAX_SUMM' => empty($sbr_summ_tax['summ']) ? 0.00 : $sbr_summ_tax['summ'],
    'SBR_TAX_PERFORMER_SUMM' => empty($sbr_summ_tax_performer['summ']) ? 0.00 : $sbr_summ_tax_performer['summ'],
    "PRO_SUMM" => empty($pro_summ['summ']) ? 0.00 : $pro_summ['summ'],
    "MARKET_SUMM" => empty($market_summ_tax['summ']) ? 0.00 : $market_summ_tax['summ'],
    "PAYTOP_SUMM" => empty($paytop_summ['summ']) ? 0.00 : $paytop_summ['summ'],
    "PAYTOPMARKET_SUMM" => empty($paytopmarket_summ['summ']) ? 0.00 : $paytopmarket_summ['summ'],
    "PAYTOPPROJECTS_SUMM" => empty($paytopprojects_summ['summ']) ? 0.00 : $paytopprojects_summ['summ'],
    "PAYTOPUSERS_SUMM" => empty($paytopusers_summ['summ']) ? 0.00 : $paytopusers_summ['summ'],
    "PAYMARKETBOLD_SUMM" => empty($paymarketbold_summ['summ']) ? 0.00 : $paymarketbold_summ['summ'],
    "PAYMARKETTOP_SUMM" => empty($paymarkettop_summ['summ']) ? 0.00 : $paymarkettop_summ['summ'],
    "PAYPRJBOLD_SUMM" => empty($payprjbold_summ['summ']) ? 0.00 : $payprjbold_summ['summ'],
    "PAYPRJTOP_SUMM" => empty($payprjtop_summ['summ']) ? 0.00 : $payprjtop_summ['summ'],
    "OUTS_TAX" => empty($out_summ) ? 0.00 : $out_summ,
    "TRANSFER_TAX" => empty($payments_summ_tax['summ']) ? 0.00 : $payments_summ_tax['summ'],
    "TOTAL_AMOUNT" => empty($total_amount) ? 0.00 : $total_amount
));

$pft->parse('MAIN');

$line = $pft->text('MAIN');
