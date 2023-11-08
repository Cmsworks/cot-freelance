<?php
/**
 * Verification of the identity of the freelancers. Checks the scanned passport.
 *
 * @plugin Verification
 * @version 1.0
 * @author Dr2005alex
 * @copyright Copyright (c) Dr2005alex
 *
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('verification', 'plug', 'config');
global  $db_users, $R;

if(!file_exists($ver_file_patch)) mkdir($ver_file_patch);
if(!file_exists($ver_file_patch_new)) mkdir($ver_file_patch_new);

// add extradields
cot_extrafield_add($db_users, 'verification_status', 'inputint', $R['input_default'],'','','','', 'Verification_status','');

require_once cot_incfile('configuration');
cot_config_add('verification_plug', array('0'=>array('order' => '99', 'name' => 'verification_count','type' => '0', 'default' => '0')),true);



?>
