<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.add.add.done,page.edit.update.done
 * [END_COT_EXT]
 */

/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 1.00
 * @author  esclkm, graber
 * @copyright (c) 2011 esclkm, graber
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('mavatars', 'plug');

if (!cot_error_found())
{
	$mavatar = new mavatar('page', $rpage['page_cat'], $id);
	$mavatar->update();
	$mavatar->upload();	
}