<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.register.tags
 * [END_COT_EXT]
 */

/**
 * User Agreement plugin
 *
 * @package useragreement
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('useragreement', 'plug'); 
$t->assign(array(
	"USERS_REGISTER_USERAGREEMENT" => cot_checkbox(0, 'ruseragreement', '').cot_rc_link(cot_url('plug', 'e=useragreement'), $L['useragreement_agree'], 'target="blank"')
));
?>