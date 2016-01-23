<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.add.tags,page.edit.tags
 * Tags=page.add.tpl:{PAGEADD_FORM_MAVATARTITLE}, {PAGEADD_FORM_MAVATAR};page.edit.tpl:{PAGEEDIT_FORM_MAVATARTITLE}, {PAGEEDIT_FORM_MAVATARFILE}, {PAGEEDIT_FORM_MAVATAR}, {PAGEEDIT_FORM_MAVATARDELETE}
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

if ((int) $id > 0)
{
	$code = $id;
	$category = $pag['page_cat'];
	$mavpr = 'EDIT';
}
else
{
	$code = '';
	$category = $rpage['page_cat'];
	$mavpr = 'ADD';
}
$mavatar = new mavatar('page', $category, $code, 'edit');

$t->assign('PAGE'.$mavpr.'_FORM_MAVATAR', $mavatar->upload_form());