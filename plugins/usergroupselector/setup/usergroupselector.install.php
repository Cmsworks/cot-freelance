<?php
/**
 * plugin User Group Selector for Cotonti Siena
 * 
 * @package usergroupselector
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 *  */

defined('COT_CODE') or die('Wrong URL');

global $db_users, $db_groups, $db_auth, $db_config;

require_once cot_incfile('auth');

// Add field if missing
if (!$db->fieldExists($db_users, "user_usergroup"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_usergroup` int(11) NOT NULL default '0'");
}

// Переносим значение из старого поля user_role в новое поле для группы по-умолчанию
if(cot_plugin_active('freelancers'))
{
	if (!$db->fieldExists($db_users, "user_role"))
	{
		$dbres = $db->query("UPDATE `$db_users` SET user_usergroup=user_role WHERE 1");
	}
}

// Дальше проверяем наличие групп в базе, если их нет, то создаем
$group_exists = (bool)$db->query("SELECT grp_id FROM $db_groups WHERE grp_id=4")->fetch();
if($group_exists)
{
	$rgroups['grp_name'] = 'Фрилансеры';
	$rgroups['grp_title'] = 'Фрилансер';
	$rgroups['grp_alias'] = 'freelancer';

	$db->update($db_groups, $rgroups, 'grp_id=4');
	$db->update($db_auth, array('auth_rights' => 5), "auth_groupid=4 AND auth_code='projects'"); // Устанавливаем права только на создание предложений в проектах
}

$group_exists = (bool)$db->query("SELECT grp_id FROM $db_groups WHERE grp_alias='employer'")->fetch();
if(!$group_exists)
{
	$rgroups['grp_name'] = 'Работодатели';
	$rgroups['grp_title'] = 'Работодатель';
	$rgroups['grp_desc'] = '';
	$rgroups['grp_icon'] = '';
	$rgroups['grp_alias'] = 'employer';
	$rgroups['grp_level'] = 1;
	$rgroups['grp_disabled'] = 0;
	$rgroups['grp_maintenance'] = 0;
	$rgroups['grp_skiprights'] = 0;
	$rgroups['grp_ownerid'] = 1;

	$db->insert($db_groups, $rgroups);
	$employer_grp_id = $db->lastInsertId();
	cot_auth_add_group($employer_grp_id, 4);
	$db->update($db_auth, array('auth_rights' => 3), "auth_groupid=".$employer_grp_id." AND auth_code='projects'"); // Устанавливаем права только на создание проектов
}

// Переносим настройки из плагина Freelancers, чтобы не потерялись на работающих сайтах
if(!empty($cfg['plugin']['freelancers']['roles']))
{
	$rconfig['config_value'] = $cfg['plugin']['freelancers']['roles'];
	$db->update($db_config, $rconfig, "config_cat='usergroupselector' AND config_name='groups'");
}

if(!empty($cfg['plugin']['freelancers']['rolereq']))
{
	$rconfig['config_value'] = $cfg['plugin']['freelancers']['rolereq'];
	$db->update($db_config, $rconfig, "config_cat='usergroupselector' AND config_name='required'");
}

if(!empty($cfg['plugin']['freelancers']['allowchange']))
{
	$rconfig['config_value'] = $cfg['plugin']['freelancers']['allowchange'];
	$db->update($db_config, $rconfig, "config_cat='usergroupselector' AND config_name='allowchange'");
}