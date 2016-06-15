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

defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');
$type = cot_import('type', 'G', 'INT');
$r = cot_import('r', 'G', 'ALP');

$c = cot_import('c', 'G', 'TXT');
if (!empty($c) && !isset($structure['projects'][$c]))
{
	$c = '';
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', 'any', 'RWA');
cot_block($usr['auth_write']);

/* === Hook === */
$extp = cot_getextplugins('projects.add.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$sys['parser'] = $cfg['projects']['parser'];
$parser_list = cot_get_parsers();

if ($a == 'add')
{
	cot_shield_protect();

	$ritem = array();
	
	/* === Hook === */
	foreach (cot_getextplugins('projects.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$ritem = cot_projects_import('POST', array(), $usr);
	
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', $ritem['item_cat']);
	cot_block($usr['auth_write']);

	/* === Hook === */
	foreach (cot_getextplugins('projects.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_projects_validate($ritem);

	/* === Hook === */
	foreach (cot_getextplugins('projects.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		$id = cot_projects_add($ritem, $usr);
		
		switch ($ritem['item_state'])
		{
			case 0:
				$urlparams = empty($ritem['item_alias']) ?
					array('c' => $ritem['item_cat'], 'id' => $id) :
					array('c' => $ritem['item_cat'], 'al' => $ritem['item_alias']);
				$r_url = cot_url('projects', $urlparams, '', true);

				if (!$usr['isadmin'])
				{
					$rbody = cot_rc($L['project_added_mail_body'], array(
						'user_name' => $usr['profile']['user_name'],
						'prj_name' => $ritem['item_title'],
						'sitename' => $cfg['maintitle'],
						'link' => COT_ABSOLUTE_URL . $r_url
					));
					cot_mail($usr['profile']['user_email'], $L['project_added_mail_subj'], $rbody);
				}
				break;
			case 1:
				$r_url = cot_url('projects', 'm=preview&id=' . $id, '', true);
				break;
			case 2:
				$urlparams = empty($ritem['item_alias']) ?
					array('c' => $ritem['item_cat'], 'id' => $id) :
					array('c' => $ritem['item_cat'], 'al' => $ritem['item_alias']);
				$r_url = cot_url('projects', $urlparams, '', true);

				if (!$usr['isadmin'])
				{
					$rbody = cot_rc($L['project_senttovalidation_mail_body'], array( 
						'user_name' => $usr['profile']['user_name'],
						'prj_name' => $ritem['item_title'],
						'sitename' => $cfg['maintitle'],
						'link' => COT_ABSOLUTE_URL . $r_url
					));
					cot_mail($usr['profile']['user_email'], $L['project_senttovalidation_mail_subj'], $rbody);
				}

				if ($cfg['projects']['notif_admin_moderate'])
				{
					$nbody = cot_rc($L['project_notif_admin_moderate_mail_body'], array( 
						'user_name' => $usr['profile']['user_name'],
						'prj_name' => $ritem['item_title'],
						'sitename' => $cfg['maintitle'],
						'link' => COT_ABSOLUTE_URL . $r_url
					));
					cot_mail($cfg['adminemail'], $L['project_notif_admin_moderate_mail_subj'], $nbody);
				}				
				break;
		}
		
		cot_redirect($r_url);
		exit;
	}
	else
	{
		cot_redirect(cot_url('projects', 'm=add&c='.$c.'&type='.$type, '', true));
	}
}

if (empty($ritem['item_cat']) && !empty($c))
{
	$ritem['item_cat'] = $c;
	$usr['isadmin'] = cot_auth('projects', $ritem['item_cat'], 'A');
}

if (empty($ritem['item_type']) && !empty($type))
{
	$ritem['item_type'] = $type;
}

$out['subtitle'] = $L['projects_add_project_title'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['projects'][$c]['title'];

$mskin = cot_tplfile(array('projects', 'add', $structure['projects'][$ritem['item_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('projects.add.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

// Error and message handling
cot_display_messages($t);

$t->assign(array(
	"PRJADD_FORM_SEND" => cot_url('projects', 'm=add&c='.$c.'&type='.$type.'&a=add'),
	"PRJADD_FORM_CAT" => cot_selectbox_structure('projects', $ritem['item_cat'], 'rcat'),
	"PRJADD_FORM_CATTITLE" => (!empty($c)) ? $structure['projects'][$c]['title'] : '',
	"PRJADD_FORM_TYPE" => (is_array($projects_types)) ? cot_selectbox(($ritem['item_type']) ? $ritem['item_type'] : $cfg['projects']['default_type'], 'rtype', array_keys($projects_types), array_values($projects_types)) : 'empty',
	"PRJADD_FORM_TYPETITLE" => (is_array($projects_types) && !empty($type)) ? $projects_types[$type] : '',
	"PRJADD_FORM_TITLE" => cot_inputbox('text', 'rtitle', $ritem['item_title'], 'size="56"'),
	"PRJADD_FORM_ALIAS" => cot_inputbox('text', 'ralias', $ritem['item_alias'], array('size' => '32', 'maxlength' => '255')),
	"PRJADD_FORM_TEXT" => cot_textarea('rtext', $ritem['item_text'], 10, 60, 'id="formtext"', ($prjeditor) ? 'input_textarea_'.$prjeditor : ''),
	"PRJADD_FORM_COST" => cot_inputbox('text', 'rcost', $ritem['item_cost'], 'size="10"'),
	"PRJADD_FORM_PARSER" => cot_selectbox($cfg['projects']['parser'], 'rparser', $parser_list, $parser_list, false),
));

// Extra fields
foreach($cot_extrafields[$db_projects] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('ritem'.$exfld['field_name'], $exfld, $ritem['item_'.$exfld['field_name']]);
	$exfld_title = isset($L['projects_'.$exfld['field_name'].'_title']) ?  $L['projects_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'PRJADD_FORM_'.$uname => $exfld_val,
		'PRJADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'PRJADD_FORM_EXTRAFLD' => $exfld_val,
		'PRJADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

/* === Hook === */
foreach (cot_getextplugins('projects.add.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');