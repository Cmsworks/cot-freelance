<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=market.add.add.done,market.edit.update.done
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

if (cot_plugin_active('mavatars') && $cfg['plugin']['mavatarslance']['market'])
{
	require_once cot_incfile('mavatars', 'plug');

	if (!cot_error_found())
	{
		$mavatar = new mavatar('market', $ritem['item_cat'], $id, 'edit');
		$mavatar->update();
		$mavatar->upload();	
	}
}