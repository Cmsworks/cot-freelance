<?php

/**
 * folio module
 *
 * @package folio
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');
$r = cot_import('r', 'G', 'ALP');

$c = cot_import('c', 'G', 'TXT');
if (!empty($c) && !isset($structure['folio'][$c]))
{
	$c = '';
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('folio', 'any', 'RWA');
cot_block($usr['auth_write']);

/* === Hook === */
$extp = cot_getextplugins('folio.add.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$sys['parser'] = $cfg['folio']['parser'];
$parser_list = cot_get_parsers();

if ($a == 'add')
{
	cot_shield_protect();

	$ritem = array();
	
	/* === Hook === */
	foreach (cot_getextplugins('folio.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$ritem = cot_folio_import('POST', array(), $usr);
	
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('folio', $ritem['item_cat']);
	cot_block($usr['auth_write']);

	/* === Hook === */
	foreach (cot_getextplugins('folio.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_folio_validate($ritem);

	/* === Hook === */
	foreach (cot_getextplugins('folio.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		$id = cot_folio_add($ritem, $usr);
		
		switch ($ritem['item_state'])
		{
			case 0:
				$urlparams = empty($ritem['item_alias']) ?
					array('c' => $ritem['item_cat'], 'id' => $id) :
					array('c' => $ritem['item_cat'], 'al' => $ritem['item_alias']);
				$r_url = cot_url('folio', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('folio', 'm=preview&id=' . $id, '', true);
				break;
			case 2:
				$urlparams = empty($ritem['item_alias']) ?
					array('c' => $ritem['item_cat'], 'id' => $id) :
					array('c' => $ritem['item_cat'], 'al' => $ritem['item_alias']);
				$r_url = cot_url('folio', $urlparams, '', true);

				if (!$usr['isadmin'])
				{
					$rbody = cot_rc($L['folio_senttovalidation_mail_body'], array( 
						'user_name' => $usr['profile']['user_name'],
						'prd_name' => $ritem['item_title'],
						'sitename' => $cfg['maintitle'],
						'link' => COT_ABSOLUTE_URL . $r_url
					));
					cot_mail($usr['profile']['user_email'], $L['folio_senttovalidation_mail_subj'], $rbody);
				}

				if ($cfg['folio']['notiffolio_admin_moderate'])
				{
					$nbody = cot_rc($L['folio_notif_admin_moderate_mail_body'], array( 
						'user_name' => $usr['profile']['user_name'],
						'prd_name' => $ritem['item_title'],
						'sitename' => $cfg['maintitle'],
						'link' => COT_ABSOLUTE_URL . $r_url
					));
					cot_mail($cfg['adminemail'], $L['folio_notif_admin_moderate_mail_subj'], $nbody);
				}	
				break;
		}
		
		cot_redirect($r_url);
		exit;
	}
	else
	{
		cot_redirect(cot_url('folio', 'm=add&c='.$c, '', true));
	}
}

if (empty($ritem['item_cat']) && !empty($c))
{
	$ritem['item_cat'] = $c;
	$usr['isadmin'] = cot_auth('folio', $ritem['item_cat'], 'A');
}

if (empty($ritem['item_type']) && !empty($type))
{
	$ritem['item_type'] = $type;
}

$out['subtitle'] = $L['folio_add_work_title'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['folio'][$c]['title'];

$mskin = cot_tplfile(array('folio', 'add', $structure['folio'][$ritem['item_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('folio.add.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

// Error and message handling
cot_display_messages($t);

$t->assign(array(
	"PRDADD_FORM_SEND" => cot_url('folio', 'm=add&c='.$c.'&a=add'),
	"PRDADD_FORM_CAT" => cot_selectbox_structure('folio', $ritem['item_cat'], 'rcat'),
	"PRDADD_FORM_CATTITLE" => (!empty($c)) ? $structure['folio'][$c]['title'] : '',
	"PRDADD_FORM_TITLE" => cot_inputbox('text', 'rtitle', $ritem['item_title'], 'size="56"'),
	"PRDADD_FORM_ALIAS" => cot_inputbox('text', 'ralias', $ritem['item_alias'], array('size' => '32', 'maxlength' => '255')),
	"PRDADD_FORM_TEXT" => cot_textarea('rtext', $ritem['item_text'], 10, 60, 'id="formtext"', ($folioeditor) ? 'input_textarea_'.$folioeditor : ''),
	"PRDADD_FORM_COST" => cot_inputbox('text', 'rcost', $ritem['item_cost'], 'size="10"'),
	"PRDADD_FORM_PARSER" => cot_selectbox($cfg['folio']['parser'], 'rparser', $parser_list, $parser_list, false),
));

// Extra fields
foreach($cot_extrafields[$db_folio] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('ritem'.$exfld['field_name'], $exfld, $ritem['item_'.$exfld['field_name']]);
	$exfld_title = isset($L['folio_'.$exfld['field_name'].'_title']) ?  $L['folio_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'PRDADD_FORM_'.$uname => $exfld_val,
		'PRDADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'PRDADD_FORM_EXTRAFLD' => $exfld_val,
		'PRDADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

/* === Hook === */
foreach (cot_getextplugins('folio.add.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');