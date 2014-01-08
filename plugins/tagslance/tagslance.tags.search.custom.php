<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=tags.search.custom
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

if ($a == 'folio' && cot_module_active('folio'))
{
	if(empty($qs))
	{
		// Form and cloud
		cot_tag_search_form('folio');
	}
	else
	{
		// Search results
		cot_tag_search_folio($qs);
	}
}

if ($a == 'market' && cot_module_active('market'))
{
	if(empty($qs))
	{
		// Form and cloud
		cot_tag_search_form('market');
	}
	else
	{
		// Search results
		cot_tag_search_market($qs);
	}
}

if ($a == 'projects' && cot_module_active('projects'))
{
	if(empty($qs))
	{
		// Form and cloud
		cot_tag_search_form('projects');
	}
	else
	{
		// Search results
		cot_tag_search_projects($qs);
	}
}
