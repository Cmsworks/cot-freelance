<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.edit.delete.done
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

$mavatar = new mavatar('page', $rpage['page_cat'], $rpage['page_id']);
$mavatar->delete_all_mavatars();
$mavatar->get_mavatars();
