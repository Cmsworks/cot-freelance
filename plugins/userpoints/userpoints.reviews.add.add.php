<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=reviews.add.add.done
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
$plusneg = ($ritem['item_score'] > 0) ? 'reviewplus' : 'reviewminus';
cot_setuserpoints($cfg['plugin']['userpoints'][$plusneg], $plusneg, $ritem['item_touserid']);

?>