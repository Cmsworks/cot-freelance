<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.add.add.done,market.edit.update.done
[END_COT_EXT]
==================== */

/**
 * Creates alias when adding or updating a market
 *
 * @package AutoAlias2lance
 * @copyright CrazyFreeMan (simple-website.in.ua), CMSworks.ru
 */

defined('COT_CODE') or die('Wrong URL');

if($cfg['plugin']['autoalias2lance']['fl_market_alias']){

	if (empty($ritem['item_alias']))
	{
		require_once cot_incfile('autoalias2lance', 'plug');
		$ritem['item_alias'] = autoalias2lance_update($ritem['item_title'], $id, 'market');
	}
}