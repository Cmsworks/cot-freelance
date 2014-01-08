<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=paypro.done
 * [END_COT_EXT]
 */

/**
 * UserPoints plugin
 *
 * @package userpoints
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('userpoints', 'plug');

cot_setuserpoints($cfg['plugin']['userpoints']['pro'], 'pro', $pay['pay_code']);

?>