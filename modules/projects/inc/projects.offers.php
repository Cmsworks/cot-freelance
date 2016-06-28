<?php
 
/**
 * projects module
 *
 * @package projects
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

$userid = cot_import('userid', 'G', 'INT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin'], $usr['auth_offers']) = cot_auth('projects', $item['item_cat'], 'RWA1');

if($cfg['projects']['offersperpage'] > 0)
{
	list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['projects']['offersperpage']);
}

/* @var $db CotDB */
/* @var $cache Cache */
/* @var $t Xtemplate */

if ($a == 'addoffer')
{

	cot_shield_protect();
	
	$sql = $db->query("SELECT * FROM $db_projects_offers WHERE offer_pid=" . $id . " AND offer_userid=" . $usr['id'] . "");
	cot_block($usr['auth_offers'] && $sql->fetchColumn() == 0 && $usr['id'] != $item['item_userid']);

	/* === Hook === */
	foreach (cot_getextplugins('projects.offers.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$roffer['offer_cost_min'] = (int)cot_import('costmin', 'P', 'NUM');
	$roffer['offer_cost_max'] = (int)cot_import('costmax', 'P', 'NUM');
	$roffer['offer_time_min'] = (int)cot_import('timemin', 'P', 'INT');
	$roffer['offer_time_max'] = (int)cot_import('timemax', 'P', 'INT');
	$roffer['offer_time_type'] = (int)cot_import('timetype', 'P', 'INT');
	$roffer['offer_hidden'] = (int)cot_import('hidden', 'P', 'BOL');
	$roffer['offer_text'] = cot_import('offertext', 'P', 'HTM');
	
	$roffer['offer_pid'] = (int)$id;
	$roffer['offer_userid'] = (int)$usr['id'];
	$roffer['offer_date'] = (int)$sys['now'];

	// Extra fields
	foreach ($cot_extrafields[$db_projects_offers] as $exfld)
	{
		$roffer['offer_'.$exfld['field_name']] = cot_import_extrafields('roffer'.$exfld['field_name'], $exfld, 'P', $roffer['offer_'.$exfld['field_name']]);
	}
	
	/* === Hook === */
	foreach (cot_getextplugins('projects.offers.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	cot_check(empty($roffer['offer_text']), $L['offers_empty_text']);

	/* === Hook === */
	foreach (cot_getextplugins('projects.offers.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	if (!cot_error_found())
	{
		$db->insert($db_projects_offers, $roffer);
		$offerid = $db->lastInsertId();
		
		$urlparams = empty($item['item_alias']) ?
			array('c' => $item['item_cat'], 'id' => $item['item_id']) :
			array('c' => $item['item_cat'], 'al' => $item['item_alias']);

		$rsubject = cot_rc($L['project_added_offer_header'], array('prtitle' => $item['item_title']));
		$rbody = cot_rc($L['project_added_offer_body'], array(
			'user_name' => $item['user_name'],
			'offeruser_name' => $usr['profile']['user_name'],
			'prj_name' => $item['item_title'],	
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('projects', $urlparams, '', true)
		));
		cot_mail ($item['user_email'], $rsubject, $rbody);

		$offerscount = $db->query("SELECT COUNT(*) FROM $db_projects_offers WHERE offer_pid=" . (int)$id . "")->fetchColumn();
		$db->update($db_projects, array("item_offerscount" => (int)$offerscount), "item_id=" . (int)$id);

		/* === Hook === */
		foreach (cot_getextplugins('projects.offers.add.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
		cot_message($L['offers_add_done'], 'ok');
		cot_redirect(cot_url('projects', 'm=show&id=' . $id, '', true));
		exit;
	}
}

if ($a == 'setperformer' && !empty($userid))
{	
	cot_check_xg();
	
	$urr = $db->query("SELECT * FROM $db_users WHERE user_id=" . (int)$userid . "")->fetch();
	
	// находим предыдущего выбранного исполнителя, если есть
	$lastperformer = $db->query("SELECT u.* FROM $db_projects_offers AS o
		LEFT JOIN $db_users AS u ON u.user_id=o.offer_userid 
		WHERE offer_pid=" . (int)$id . " AND offer_choise='performer'")->fetch();
	
	/* === Hook === */
	foreach (cot_getextplugins('projects.offers.setperformer.error') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	// Выбор исполнителя
	if ($usr['id'] == $item['item_userid'] && (int)$userid > 0 && !cot_error_found())
	{
		if($db->update($db_projects_offers, array("offer_choise" => 'performer', "offer_choise_date" => (int)$sys['now_offset']), "offer_pid=" . (int)$id . " AND offer_userid=" . (int)$userid)){
			$db->update($db_projects, array("item_performer" => $userid), "item_id=" . (int)$id);
		}
		
		$urlparams = empty($item['item_alias']) ?
			array('c' => $item['item_cat'], 'id' => $item['item_id']) :
			array('c' => $item['item_cat'], 'al' => $item['item_alias']);
		
		$rsubject = cot_rc($L['project_setperformer_header'], array('prtitle' => $item['item_title']));
		$rbody = cot_rc($L['project_setperformer_body'], array(
			'user_name' => $item['user_name'],
			'offeruser_name' => $urr['user_name'],
			'prj_name' => $item['item_title'],	
			'sitename' => $cfg['maintitle'],	
			'link' => COT_ABSOLUTE_URL . cot_url('projects', $urlparams, '', true)
		));
		cot_mail($urr['user_email'], $rsubject, $rbody);
		cot_message(cot_rc($L['performer_set_done'],array('username' => $urr['user_name'])), 'ok');
		if(!empty($lastperformer))
		{
			// Если исполнителем был другой пользователь, то ему отказ
			$db->update($db_projects_offers, array("offer_choise" => 'refuse', "offer_choise_date" => (int)$sys['now_offset']), "offer_pid=" . (int)$id . " AND offer_choise='performer' AND offer_userid=" . (int)$lastperformer['user_id']);

			$urlparams = empty($item['item_alias']) ?
				array('c' => $item['item_cat'], 'id' => $item['item_id']) :
				array('c' => $item['item_cat'], 'al' => $item['item_alias']);

			$rsubject = cot_rc($L['project_refuse_header'], array('prtitle' => $item['item_title']));
			$rbody = cot_rc($L['project_refuse_body'], array(
				'user_name' => $item['user_name'],
				'offeruser_name' => $lastperformer['user_name'],
				'prj_name' => $item['item_title'],	
				'sitename' => $cfg['maintitle'],	
				'link' => COT_ABSOLUTE_URL . cot_url('projects', $urlparams, '', true)
			));
			cot_mail($lastperformer['user_email'], $rsubject, $rbody);
			cot_message(cot_rc($L['performer_set_refuse'],array('username' => $lastperformer['user_name'])), 'warning');
			/* === Hook === */
			foreach (cot_getextplugins('projects.offers.setperformer.refuselastperformer') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
		
		/* === Hook === */
		foreach (cot_getextplugins('projects.offers.setperformer') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
	cot_redirect(cot_url('projects', 'm=show&id=' . $id, '', true));
	exit;
}
if ($a == 'refuse' && !empty($userid))
{	
	cot_check_xg();
	
	$urr = $db->query("SELECT * FROM $db_users WHERE user_id=" . (int)$userid . "")->fetch();
	
	/* === Hook === */
	foreach (cot_getextplugins('projects.offers.refuse.error') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	// Отказать исполнителю
	if ($usr['id'] == $item['item_userid'] && (int)$userid > 0 && !cot_error_found())
	{
		if($db->update($db_projects_offers, array('offer_choise' => 'refuse', 'offer_choise_date' => (int)$sys['now_offset']), "offer_pid=" . $id . " AND offer_userid=" . (int)$userid . "")){
			if($userid == $item['item_performer'])
			{
				$db->update($db_projects, array("item_performer" => 0), "item_id=" . (int)$id);
			}
		}

		$urlparams = empty($item['item_alias']) ?
			array('c' => $item['item_cat'], 'id' => $item['item_id']) :
			array('c' => $item['item_cat'], 'al' => $item['item_alias']);
		
		$rsubject = cot_rc($L['project_refuse_header'], array('prtitle' => $item['item_title']));
		$rbody = cot_rc($L['project_refuse_body'], array(
			'user_name' => $item['user_name'],
			'offeruser_name' => $urr['user_name'],
			'prj_name' => $item['item_title'],	
			'sitename' => $cfg['maintitle'],	
			'link' => COT_ABSOLUTE_URL . cot_url('projects', $urlparams, '', true)
		));
		cot_mail($urr['user_email'], $rsubject, $rbody);
		cot_message(cot_rc($L['performer_set_refuse'],array('username' => $urr['user_name'])), 'warning');
			
		/* === Hook === */
		foreach (cot_getextplugins('projects.offers.refuse') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
	cot_redirect(cot_url('projects', 'm=show&id=' . $id, '', true));
	exit;
}
if ($a == 'addpost')
{
	cot_shield_protect();
	
	$offer_post['post_pid'] = (int)$id;
	$offer_post['post_oid'] = (int)cot_import('oid', 'G', 'INT');
	$offer_post['post_userid'] = (int)$usr['id'];
	$offer_post['post_date'] = (int)$sys['now'];
	$offer_post['post_text'] = cot_import('posttext', 'P', 'TXT');

	$offer = $db->query("SELECT * FROM $db_projects_offers AS o 
		LEFT JOIN $db_users AS u ON u.user_id=o.offer_userid
		WHERE offer_id=" . $offer_post['post_oid'] . " LIMIT 1")->fetch();
	
	/* === Hook === */
	foreach (cot_getextplugins('projects.offers.addpost.error') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	if (!empty($offer_post['post_text']) && (in_array($usr['id'], array($offer['offer_userid'], $item['item_userid'])) || $usr['isadmin']) && !cot_error_found())
	{

		$db->insert($db_projects_posts, $offer_post);

		if ($usr['id'] == $offer['offer_userid'])
		{
			$urlparams = empty($item['item_alias']) ?
				array('c' => $item['item_cat'], 'id' => $item['item_id']) :
				array('c' => $item['item_cat'], 'al' => $item['item_alias']);
			
			$rsubject = cot_rc($L['project_added_post_header'], array('prtitle' => $item['item_title']));
			$rbody = cot_rc($L['project_added_post_body'], array(
				'user_name' => $item['user_name'],
				'postuser_name' => $usr['profile']['user_name'],
				'prj_name' => $item['item_title'],	
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . cot_url('projects', $urlparams, '', true)
			));
			cot_mail($item['user_email'], $rsubject, $rbody);
		}
		else
		{
			$urlparams = empty($item['item_alias']) ?
				array('c' => $item['item_cat'], 'id' => $item['item_id']) :
				array('c' => $item['item_cat'], 'al' => $item['item_alias']);

			$rsubject = cot_rc($L['project_added_post_header'], array('prtitle' => $item['item_title']));
			$rbody = cot_rc($L['project_added_post_body'], array(
				'user_name' => $offer['user_name'],
				'postuser_name' => $usr['profile']['user_name'],
				'prj_name' => $item['item_title'],	
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . cot_url('projects', $urlparams, '', true)
			));
			cot_mail($offer['user_email'], $rsubject, $rbody);
		}
		cot_message($L['offers_add_post'], 'ok');
		/* === Hook === */
		foreach (cot_getextplugins('projects.offers.addpost.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
	cot_redirect(cot_url('projects', 'id=' . $id, '', true));
	exit;
}



$t_o = new XTemplate(cot_tplfile(array('projects', 'offers', $structure['projects'][$item['item_cat']]['tpl'])));
// Вычисление выбранного исполнителя по проекту
if ($item['item_performer'])
{
	$t_o->assign(cot_generate_usertags($item['item_performer'], 'PRJ_PERFORMER_'));
}

$where = array();
$order = array();

// Показать не автору только видимые проедложения:
if ($usr['id'] != $item['item_userid'] && !$usr['isadmin'])
{
	$where['forshow'] = "(o.offer_hidden!=1 OR o.offer_userid=" . $usr['id'] . ")";
}
// ==================================================

$where['pid'] = "o.offer_pid=" . $id;

$order['date'] = "o.offer_date DESC";

$query_limit = ($cfg['projects']['offersperpage'] > 0) ? "LIMIT $d, ".$cfg['projects']['offersperpage'] : '';

/* === Hook === */
foreach (cot_getextplugins('projects.offers.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$totaloffers = $db->query("SELECT COUNT(*) FROM $db_projects_offers AS o 
	" . $where . "")->fetchColumn();

$sql = $db->query("SELECT * FROM $db_projects_offers AS o LEFT JOIN $db_users AS u ON u.user_id=o.offer_userid
	" . $where . " 
	" . $order . "
	" . $query_limit . "");

if($cfg['projects']['offersperpage'] > 0)
{
	$urlparams = empty($item['item_alias']) ?
		array('c' => $item['item_cat'], 'id' => $id) :
		array('c' => $item['item_cat'], 'al' => $item['item_alias']);

	$offersnav = cot_pagenav('projects', $urlparams, $d, $totaloffers, $cfg['projects']['offersperpage']);

	$t_o->assign(array(
		"OFFERSNAV_PAGES" => $offersnav['main'],
		"OFFERSNAV_PREV" => $offersnav['prev'],
		"OFFERSNAV_NEXT" => $offersnav['next'],
		"OFFERSNAV_COUNT" => $totaloffers,
	));
}

$alloffers_count = $db->query("SELECT COUNT(*) FROM $db_projects_offers WHERE offer_pid=" . $id)->fetchColumn();

$t_o->assign(array(
	"ALLOFFERS_COUNT" => $alloffers_count,
));

/* === Hook === */
$extp1 = cot_getextplugins('projects.offers.choise.first');
$extp2 = cot_getextplugins('projects.offers.choise');
$extp3 = cot_getextplugins('projects.offers.posts.loop');
$extp4 = cot_getextplugins('projects.offers.loop');
/* ===== */

while ($offer = $sql->fetch())
{  
  	$t_o->assign(cot_generate_usertags($offer, 'OFFER_ROW_OWNER_'));
	$t_o->assign(array(
		"OFFER_ROW_DATE" => cot_date('d.m.Y H:i', $offer['offer_date']),
		"OFFER_ROW_DATE_STAMP" => $offer['offer_date'],
		"OFFER_ROW_TEXT" => cot_parse($offer['offer_text']),
		"OFFER_ROW_COSTMIN" => (floor($offer['offer_cost_min']) != $offer['offer_cost_min']) ? number_format($offer['offer_cost_min'], '2', '.', ' ') : number_format($offer['offer_cost_min'], '0', '.', ' '),
		"OFFER_ROW_COSTMAX" => (floor($offer['offer_cost_max']) != $offer['offer_cost_max']) ? number_format($offer['offer_cost_max'], '2', '.', ' ') : number_format($offer['offer_cost_max'], '0', '.', ' '),
		"OFFER_ROW_TIMEMIN" => $offer['offer_time_min'],
		"OFFER_ROW_TIMEMAX" => $offer['offer_time_max'],
		"OFFER_ROW_TIMETYPE" => $L['offers_timetype'][$offer['offer_time_type']],
		"OFFER_ROW_HIDDEN" => $offer['offer_hidden'],
		"OFFER_ROW_CHOISE" => $offer['offer_choise'],
	));
	
	// Extrafields
	if (isset($cot_extrafields[$db_projects_offers]))
	{
		foreach ($cot_extrafields[$db_projects_offers] as $exfld)
		{
			$uname = mb_strtoupper($exfld['field_name']);
			$t_o->assign(array(
				'OFFER_ROW_' . $uname . '_TITLE' => isset($L['offers_' . $exfld['field_name'] . '_title']) ? $L['offers_' . $exfld['field_name'] . '_title'] : $exfld['field_description'],
				'OFFER_ROW_' . $uname => cot_build_extrafields_data('offers', $exfld, $offer['item_' . $exfld['field_name']])
			));
		}
	}

	$choise_enabled = true;
	
	/* === Hook - Part1 : Include === */
	foreach ($extp1 as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($usr['id'] == $item['item_userid'] && $choise_enabled)
	{
		$t_o->assign(array(
			"OFFER_ROW_SETPERFORMER" => cot_url('projects', 'id=' . $id . '&a=setperformer&userid=' . $offer['user_id'] . '&' . cot_xg()),
			"OFFER_ROW_REFUSE" => cot_url('projects', 'id=' . $id . '&a=refuse&userid=' . $offer['user_id'] . '&' . cot_xg()),
		));
		
		/* === Hook - Part2 : Include === */
		foreach ($extp2 as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		$t_o->parse("MAIN.ROWS.CHOISE");
	}

	if ($usr['id'] == $offer['offer_userid'] || $usr['id'] == $item['item_userid'] || $usr['isadmin'])
	{
		$sql_prjposts = $db->query("SELECT * FROM $db_projects_posts as p LEFT JOIN $db_users as u ON u.user_id=p.post_userid
			WHERE post_pid=" . $id . " AND post_oid=" . $offer['offer_id'] . " ORDER BY post_date ASC");

		while ($posts = $sql_prjposts->fetch())
		{
			$t_o->assign(cot_generate_usertags($posts, 'POST_ROW_OWNER_'));
			$t_o->assign(array(
				"POST_ROW_TEXT" => cot_parse($posts['post_text']),
				"POST_ROW_DATE" => cot_date('d.m.y H:i', $posts['post_date']),
				"POST_ROW_DATE_STAMP" => $posts['post_date'],
			));
			/* === Hook - Part3 : Include === */
			foreach ($extp3 as $pl)
			{
				include $pl;
			}
			/* ===== */	
			$t_o->parse("MAIN.ROWS.POSTS.POSTS_ROWS");
		}

		$t_o->assign(array(
			"ADDPOST_ACTION_URL" => cot_url('projects', 'id=' . $id . '&oid=' . $offer['offer_id'] . '&a=addpost'),
			"ADDPOST_TEXT" => cot_textarea('posttext',  $offer_post['post_text'], 3, 60),
			"ADDPOST_OFFERID" => $offer['offer_id'],
		));
		$t_o->parse("MAIN.ROWS.POSTS.POSTFORM");

		$t_o->parse("MAIN.ROWS.POSTS");
	}
	
	/* === Hook - Part4 : Include === */
	foreach ($extp4 as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$t_o->parse("MAIN.ROWS");
}


$addoffer_enabled = true;

/* === Hook === */
foreach (cot_getextplugins('projects.addofferform.main') as $pl)
{
	include $pl;
}
/* ===== */

$sql = $db->query("SELECT * FROM $db_projects_offers WHERE offer_pid=" . $id . " AND offer_userid=" . $usr['id'] . "");
if ($sql->fetchColumn() == 0 && $addoffer_enabled && $usr['auth_offers'] && $usr['id'] != $item['item_userid'] && empty($performer))
{
	$t_o->assign(array(
		"OFFER_FORM_COSTMIN" => cot_inputbox('text', 'costmin', $roffer['offer_cost_min'], 'size="7"'),
		"OFFER_FORM_COSTMAX" => cot_inputbox('text', 'costmax', $roffer['offer_cost_max'], 'size="7"'),
		"OFFER_FORM_TIMEMIN" => cot_inputbox('text', 'timemin', $roffer['offer_time_min'], 'size="7"'),
		"OFFER_FORM_TIMEMAX" => cot_inputbox('text', 'timemax', $roffer['offer_time_max'], 'size="7"'),
		"OFFER_FORM_TEXT" => cot_textarea('offertext', $roffer['offer_text'], 7, 40),
		"OFFER_FORM_HIDDEN" =>  cot_checkbox(0, 'hidden', $L['offers_hide_offer']),
		"OFFER_FORM_ACTION_URL" => cot_url('projects', 'id=' . $id . '&a=addoffer'),
		"OFFER_FORM_TIMETYPE" => cot_selectbox($timetype, 'timetype', array_keys($L['offers_timetype']), array_values($L['offers_timetype']), false),
	));

	// Extra fields
	foreach($cot_extrafields[$db_projects_offers] as $exfld)
	{
		$uname = strtoupper($exfld['field_name']);
		$exfld_val = cot_build_extrafields('roffer'.$exfld['field_name'], $exfld, $roffer['offer_'.$exfld['field_name']]);
		$exfld_title = isset($L['offers_'.$exfld['field_name'].'_title']) ?  $L['offers_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
		$t_o->assign(array(
			'OFFER_FORM_'.$uname => $exfld_val,
			'OFFER_FORM_'.$uname.'_TITLE' => $exfld_title,
			'OFFER_FORM_EXTRAFLD' => $exfld_val,
			'OFFER_FORM_EXTRAFLD_TITLE' => $exfld_title
			));
		$t_o->parse('MAIN.EXTRAFLD');
	}
	
	/* === Hook === */
	foreach (cot_getextplugins('projects.addofferform.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t_o->parse("MAIN.ADDOFFERFORM");
}

// Error and message handling
cot_display_messages($t_o);

$t_o->parse("MAIN");

$t->assign('OFFERS', $t_o->text('MAIN'));