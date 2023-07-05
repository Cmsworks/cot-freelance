<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.main
 * Order=80
 * [END_COT_EXT]
 */
/**
 * plugin User Group Selector for Cotonti Siena
 * 
 * @package usergroupselector
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 * */
defined('COT_CODE') or die('Wrong URL.');

$subtitle = !empty($subtitle) ? $subtitle : '';
if (cot::$cfg['plugin']['usergroupselector']['grptitle']){
    cot::$out['subtitle'] = (!empty(cot::$out['subtitle'])) ? $subtitle . ' - ' . cot::$out['subtitle'] : $subtitle;

} elseif(empty($cat)) {
    cot::$out['subtitle'] = $subtitle;
}
