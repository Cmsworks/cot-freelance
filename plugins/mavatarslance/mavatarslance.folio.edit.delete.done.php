<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=folio.edit.delete.done
 * [END_COT_EXT]
 */

/**
 * mavatarslance for Cotonti CMF
 *
 * @version 1.2.1
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 */
defined('COT_CODE') or die('Wrong URL');

global $cfg;

if (cot_plugin_active('mavatars') && $cfg['plugin']['mavatarslance']['folio'])
{
	require_once cot_incfile('mavatars', 'plug');	
	$mavatar = new mavatar('folio', $ritem['item_cat'], $id, 'edit');
	$mavatar->delete_all_mavatars();
	$mavatar->get_mavatars();
}
