<?php
/**
 * 2.5.2:
 */

defined('COT_CODE') or die('Wrong URL');

global $db_x, $db_users, $db_usercategories, $db_usercategories_users;

$db_usercategories = (isset($db_usercategories)) ? $db_usercategories : $db_x . 'usercategories';
$db_usercategories_users = (isset($db_usercategories_users)) ? $db_usercategories_users : $db_x . 'usercategories_users';

require_once cot_incfile('usercategories', 'plug');
require_once cot_incfile('extrafields');
require_once cot_incfile('structure');

// Add field if missing
if (!$db->fieldExists($db_users, "user_cats"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_cats` TEXT collate utf8_unicode_ci NOT NULL");
}

$sql = $db->query("SELECT * FROM $db_usercategories WHERE 1");
while($cat = $sql->fetch()){
	$rcat['structure_area'] = 'usercategories';
	$rcat['structure_title'] = $cat['cat_title'];
	$rcat['structure_code'] = $cat['cat_code'];
	$rcat['structure_path'] = $cat['cat_path'];
	cot_structure_add('usercategories', $rcat);
	$config_values = array(
	  array(
            'name' => 'metatitle',
            'type' => COT_CONFIG_TYPE_STRING,
            'default' => $cat['cat_desc']
          ),
          array(
            'name' => 'metadesc',
            'type' => COT_CONFIG_TYPE_STRING,
            'default' => $cat['cat_metadesc']
          ),
          array(
            'name' => 'keywords',
            'type' => COT_CONFIG_TYPE_STRING,
            'default' => $cat['cat_keywords']
          )
	);
	cot_config_add('usercategories', $config_values, false, $rcat['structure_code']);
}

$sql = $db->query("SELECT user_id FROM $db_users WHERE 1");
while($urr = $sql->fetch()){
	$ucats = $db->query("SELECT * FROM $db_usercategories_users WHERE ucat_userid=".$urr['user_id'])->fetchAll();
	if(is_array($ucats)){
		foreach ($ucats as $ucat){
			$rusercats[] = $ucat['ucat_cat'];
		}
		if(is_array($rusercats)){
			$ruser['user_cats'] = implode(',', $rusercats);
			$db->update($db_users, $ruser, "user_id=".$urr['user_id']);
		}
	}
	unset($rusercats);
}

$db->query("DROP TABLE IF EXISTS $db_usercategories");
$db->query("DROP TABLE IF EXISTS $db_usercategories_users");
