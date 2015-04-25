<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=ajax
  [END_COT_EXT]
  ==================== */

/**
 * news admin usability modification
 *
 * @package news
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2012
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$m = cot_import('m', 'G', 'TXT');

// Mode choice
if (!in_array($m, array('thumb')))
{
	$m = 'upload';
}

require_once cot_incfile('mavatars', 'plug', $m);