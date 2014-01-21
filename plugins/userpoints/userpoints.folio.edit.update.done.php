<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=folio.edit.update.done
 * [END_COT_EXT]
 */
/**
 * UserPoints plugin
 *
 * @package userpoints
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('userpoints', 'plug');

if($ritem['item_state'] != $item['item_state'])
{
	if($ritem['item_state'] == 0)
	{
		cot_setuserpoints($cfg['plugin']['userpoints']['portfolioaddtocat'], 'portfolioaddtocat', $item['item_userid'], $id);
	}
	else
	{
		cot_setuserpoints(-$cfg['plugin']['userpoints']['portfolioaddtocat'], 'portfoliodeltocat', $item['item_userid'], $id);
	}
}
