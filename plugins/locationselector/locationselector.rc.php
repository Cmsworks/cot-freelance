<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rc
 * [END_COT_EXT]
 */

/**
 * Location Selector for Cotonti
 *
 * @package locationselector
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

cot_rc_add_file($cfg['plugins_dir'] . '/locationselector/js/locationselector.js');
