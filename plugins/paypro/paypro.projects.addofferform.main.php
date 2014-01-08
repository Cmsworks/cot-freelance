<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.addofferform.main
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paypro', 'plug');

$upro = $usr['profile']['user_pro'];
if (!$upro)
{
	if ($cfg['plugin']['paypro']['offerslimit'] > 0)
	{
		$countoffersofuser = cot_getcountoffersofuser($usr['id']);
		if ($countoffersofuser >= $cfg['plugin']['paypro']['offerslimit'])
		{
			$addoffer_enabled = false;
			$t_o->parse("MAIN.OFFERSLIMITEMPTY");
		}
	}
}
?>