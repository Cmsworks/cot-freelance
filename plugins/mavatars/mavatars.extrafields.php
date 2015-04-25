<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 1.00
 * @author  esclkm, graber
 * @copyright (c) 2011 esclkm, graber
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('mavatars', 'plug');

$extra_whitelist[$db_mavatars] = array(
	'name' => $db_mavatars,
	'caption' => $L['Plugin'].' Mavatars',
	'type' => 'plug',
	'code' => 'mavatars',
	'tags' => array()
);
