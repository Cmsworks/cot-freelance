<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=pagetags.main
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

$mavatar = new mavatar('page', $page_data['page_cat'], $page_data['page_id']);
$mavatars_tags = $mavatar->generate_mavatars_tags();

$temp_array['MAVATAR'] = $mavatars_tags;
$temp_array['MAVATARCOUNT'] = count($mavatars_tags);
