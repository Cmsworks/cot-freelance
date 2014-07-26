<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('paypro', 'plug');

$t = new XTemplate(cot_tplfile('paypro.admin', 'plug', true));

$id = cot_import('id', 'G', 'INT');

if ($a == 'add')
{
	$username = cot_import('username', 'P', 'TXT', 100, TRUE);
	$months = cot_import('months', 'P', 'INT');
	$urr = $db->query("SELECT * FROM $db_users WHERE user_name='" . $username . "'")->fetch();

	cot_check(empty($username), 'paypro_error_username');
	cot_check(empty($urr['user_id']), 'paypro_error_userempty');
	cot_check(empty($months), 'paypro_error_monthsempty');

	if (!cot_error_found())
	{
		$rpro['user_pro'] = ($urr['user_pro'] > $sys['now']) ? $urr['user_pro'] + $months * 30 * 24 * 60 * 60 : $sys['now'] + $months * 30 * 24 * 60 * 60;
		$db->update($db_users, $rpro, "user_id=" . $urr['user_id']);
	}
	cot_redirect(cot_url('admin', 'm=other&p=paypro', '', true));
}

if ($a == 'delete')
{
	$db->update($db_users, array("user_pro" => 0), "user_id=?", array($id));
	cot_redirect(cot_url('admin', 'm=other&p=paypro', '', true));
}

$prousers = $db->query("SELECT * FROM $db_users AS u WHERE user_maingrp>3 ORDER BY user_pro DESC, user_name ASC")->fetchAll();
foreach ($prousers as $urr)
{
	if($id == $urr['user_id']) $username = $urr['user_name'];
	if($urr['user_pro'] > 0)
	{
		$t->assign(cot_generate_usertags($urr, 'PRO_ROW_USER_'));
		$t->assign(array(
			'PRO_ROW_EXPIRE' => $urr['user_pro'],
		));
		$t->parse('MAIN.PRO_ROW');
	}else
	{
		$otherusers[] = $urr['user_name'];
	}
}

cot_display_messages($t);

if(is_array($otherusers))
{
	$t->assign(array(
		'PRO_FORM_ACTION_URL' => cot_url('admin', 'm=other&p=paypro&a=add'),
		'PRO_FORM_PERIOD' => cot_selectbox($months, 'months', array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
										array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12), false),
		'PRO_FORM_SELECTUSER' => cot_selectbox($username, 'username', $otherusers)
	));
}

$t->parse('MAIN');
$adminmain = $t->text('MAIN');