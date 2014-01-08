<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=tags.first
 * [END_COT_EXT]
 */
 
/**
 * plugin tagslance for Cotonti Siena
 * 
 * @package tagslance
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 *  */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('tagslance', 'plug');

if (cot_module_active('folio'))
{
	require_once cot_incfile('folio', 'module');
	$tag_areas[] = 'folio';
}
if (cot_module_active('market'))
{
	require_once cot_incfile('market', 'module');
	$tag_areas[] = 'market';
}
if (cot_module_active('projects'))
{
	require_once cot_incfile('projects', 'module');
	$tag_areas[] = 'projects';
}