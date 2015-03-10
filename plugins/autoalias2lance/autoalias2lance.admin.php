<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

/**
 * Creates aliases in existing projects, market, folio with empty alias
 *
 * @package AutoAlias2lance
 * @copyright (c) CrazyFreeMan, CMSwork
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('autoalias2lance', 'plug');
require_once cot_langfile('autoalias2lance', 'plug');
require_once cot_langfile('autoalias2', 'plug');

$t = new XTemplate(cot_tplfile('autoalias2lance.admin', 'plug', true));

$adminsubtitle = $L['AutoAlias2lance'];

if ($a == 'create')
{	
	$for = cot_import('aliasfor', 'G', 'TXT');
	switch ($for) {
		case 'projects':
			$queryToDB = "SELECT item_title, item_id FROM $db_projects WHERE item_alias = ''";
			break;
		case 'market':
			$queryToDB = "SELECT item_title, item_id FROM $db_market WHERE item_alias = ''";
			break;
		case 'folio':
			$queryToDB = "SELECT item_title, item_id FROM $db_folio WHERE item_alias = ''";
			break;		
		default:
			# WTF?
			break;
	}

	$count = 0;
	$res = $db->query($queryToDB);
	foreach ($res->fetchAll() as $row)
	{
		autoalias2lance_update($row['item_title'], $row['item_id'], $for);
		$count++;
	}
	$res->closeCursor();
	cot_message(cot_rc('aliases_written', $count));
	cot_redirect(cot_url('admin', 'm=other&p=autoalias2lance', '', true));
}
$t->assign(array(
	'AUTOALIAS_PROJECTS_CREATE' => cot_url('admin', 'm=other&p=autoalias2lance&a=create&aliasfor=projects'),
	'AUTOALIAS_MARKET_CREATE' => cot_url('admin', 'm=other&p=autoalias2lance&a=create&aliasfor=market'),
	'AUTOALIAS_FOLIO_CREATE' => cot_url('admin', 'm=other&p=autoalias2lance&a=create&aliasfor=folio')
	));
cot_display_messages($t);

$t->parse();
$plugin_body = $t->text('MAIN');
