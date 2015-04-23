<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.first
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paypro', 'plug');

if(!cot_getuserpro() && $cfg['plugin']['paypro']['projectslimit'] > 0 && $cfg['plugin']['paypro']['projectslimit'] <= cot_getcountprjofuser($usr['id'])){
	cot_block();
}