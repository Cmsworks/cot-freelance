<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=folio.add.add.done
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

if(!$cfg['folio']['preview'] && !$cfg['folio']['prevalidate'])
{
	if($ritem['item_state'] == 0)
	{
		cot_setuserpoints($cfg['plugin']['userpoints']['portfolioaddtocat'], 'portfolioaddtocat', $ritem['item_userid'], $id);
	}
	else
	{
		cot_setuserpoints(-$cfg['plugin']['userpoints']['portfolioaddtocat'], 'portfoliodeltocat', $ritem['item_userid'], $id);
	}
}