<?php

/**
 * market module
 *
 * @package market
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');
$r = cot_import('r', 'G', 'ALP');

$c = cot_import('c', 'G', 'TXT');
if (!empty($c) && !isset($structure['market'][$c]))
{
	$c = '';
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('market', 'any', 'RWA');
cot_block($usr['auth_write']);

/* === Hook === */
$extp = cot_getextplugins('market.add.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$sys['parser'] = $cfg['market']['parser'];
$parser_list = cot_get_parsers();

if ($a == 'add')
{
	cot_shield_protect();

	$ritem = array();
	
	/* === Hook === */
	foreach (cot_getextplugins('market.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$ritem = cot_market_import('POST', array(), $usr);
	
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('market', $ritem['item_cat']);
	cot_block($usr['auth_write']);

	/* === Hook === */
	foreach (cot_getextplugins('market.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_market_validate($ritem);

	/* === Hook === */
	foreach (cot_getextplugins('market.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		$id = cot_market_add($ritem, $usr);
		
		switch ($ritem['item_state'])
		{
			case 0:
				$urlparams = empty($ritem['item_alias']) ?
					array('c' => $ritem['item_cat'], 'id' => $id) :
					array('c' => $ritem['item_cat'], 'al' => $ritem['item_alias']);
				$r_url = cot_url('market', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('market', 'm=preview&id=' . $id, '', true);
				break;
			case 2:
				$urlparams = empty($ritem['item_alias']) ?
					array('c' => $ritem['item_cat'], 'id' => $id) :
					array('c' => $ritem['item_cat'], 'al' => $ritem['item_alias']);
				$r_url = cot_url('market', $urlparams, '', true);

				if (!$usr['isadmin'])
				{
					$rbody = cot_rc($L['market_senttovalidation_mail_body'], array( 
						'user_name' => $usr['profile']['user_name'],
						'prd_name' => $ritem['item_title'],
						'sitename' => $cfg['maintitle'],
						'link' => COT_ABSOLUTE_URL . $r_url
					));
					cot_mail($usr['profile']['user_email'], $L['market_senttovalidation_mail_subj'], $rbody);
				}

				if ($cfg['market']['notifmarket_admin_moderate'])
				{
					$nbody = cot_rc($L['market_notif_admin_moderate_mail_body'], array( 
						'user_name' => $usr['profile']['user_name'],
						'prd_name' => $ritem['item_title'],
						'sitename' => $cfg['maintitle'],
						'link' => COT_ABSOLUTE_URL . $r_url
					));
					cot_mail($cfg['adminemail'], $L['market_notif_admin_moderate_mail_subj'], $nbody);
				}
				break;
		}
		
		cot_redirect($r_url);
		exit;
	}
	else
	{
		cot_redirect(cot_url('market', 'm=add&c='.$c, '', true));
	}
}

if (empty($ritem['item_cat']) && !empty($c))
{
	$ritem['item_cat'] = $c;
	$usr['isadmin'] = cot_auth('market', $ritem['item_cat'], 'A');
}

if (empty($ritem['item_type']) && !empty($type))
{
	$ritem['item_type'] = $type;
}

$out['subtitle'] = $L['market_add_product_title'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['market'][$c]['title'];

$mskin = cot_tplfile(array('market', 'add', $structure['market'][$ritem['item_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('market.add.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

// Error and message handling
cot_display_messages($t);

$t->assign(array(
	"PRDADD_FORM_SEND" => cot_url('market', 'm=add&c='.$c.'&a=add'),
	"PRDADD_FORM_CAT" => cot_selectbox_structure('market', $ritem['item_cat'], 'rcat'),
	"PRDADD_FORM_CATTITLE" => (!empty($c)) ? $structure['market'][$c]['title'] : '',
	"PRDADD_FORM_TITLE" => cot_inputbox('text', 'rtitle', $ritem['item_title'], 'size="56"'),
	"PRDADD_FORM_ALIAS" => cot_inputbox('text', 'ralias', $ritem['item_alias'], array('size' => '32', 'maxlength' => '255')),
	"PRDADD_FORM_TEXT" => cot_textarea('rtext', $ritem['item_text'], 10, 60, 'id="formtext"', ($prdeditor) ? 'input_textarea_'.$prdeditor : ''),
	"PRDADD_FORM_COST" => cot_inputbox('text', 'rcost', $ritem['item_cost'], 'size="10"'),
	"PRDADD_FORM_PARSER" => cot_selectbox($cfg['market']['parser'], 'rparser', $parser_list, $parser_list, false),
));

// Extra fields
foreach($cot_extrafields[$db_market] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('ritem'.$exfld['field_name'], $exfld, $ritem['item_'.$exfld['field_name']]);
	$exfld_title = isset($L['market_'.$exfld['field_name'].'_title']) ?  $L['market_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'PRDADD_FORM_'.$uname => $exfld_val,
		'PRDADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'PRDADD_FORM_EXTRAFLD' => $exfld_val,
		'PRDADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

/* === Hook === */
foreach (cot_getextplugins('market.add.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');