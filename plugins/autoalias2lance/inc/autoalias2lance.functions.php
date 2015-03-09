<?php
/**
 * AutoAlias2lance functions
 *
 * @package Auto Alias 2 Freelance
 * @copyright (c) CrazyFreeMan, CMSworks.ru
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('autoalias2', 'plug');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('market', 'module');
require_once cot_incfile('folio', 'module');

/**
 * Updates an alias for a specific Projects | Market | Folio
 *
 * @param string $title Projects | Market | Folio
 * @param int $id Projects | Market | Folio
 */
function autoalias2lance_update($title, $id, $aliasfor)
{
	global $cfg, $db, $db_projects, $db_market, $db_folio;
	$duplicate = false;
	do
	{
		$alias = autoalias2_convert($title, $id, $duplicate);

		switch ($aliasfor) {
			case 'projects':				
				$queryToDB = "SELECT COUNT(*) FROM $db_projects WHERE item_alias = '$alias' AND item_id != $id";
				break;
			case 'market':				
				$queryToDB = "SELECT COUNT(*) FROM $db_market WHERE item_alias = '$alias' AND item_id != $id";
				break;
			case 'folio':				
				$queryToDB = "SELECT COUNT(*) FROM $db_folio WHERE item_alias = '$alias' AND item_id != $id";
				break;		
			default:
				# WTF?
				break;
		}
		if (!$cfg['plugin']['autoalias2']['prepend_id']
			&& $db->query($queryToDB)->fetchColumn() > 0)
		{
			$duplicate = true;
		}
		else
		{
			switch ($aliasfor) {
				case 'projects':
					$db->update($db_projects, array('item_alias' => $alias), "item_id = $id");
					break;
				case 'market':
					$db->update($db_market, array('item_alias' => $alias), "item_id = $id");
					break;
				case 'folio':
					$db->update($db_folio, array('item_alias' => $alias), "item_id = $id");
					break;		
				default:
					# WTF?
					break;
			}			
			$duplicate = false;
		}
	}
	while ($duplicate && !$cfg['plugin']['autoalias2']['prepend_id']);
	return $alias;
}