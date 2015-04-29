<?php 

defined('COT_CODE') or die('Wrong URL');

global $db_config;

$mavatars_set = $cfg['plugin']['mavatars']['set']."\r\nprojects||datas/projects|datas/projects|0||\r\nmarket||datas/market|datas/market|0||\r\nfolio||datas/folio|datas/folio|0||";
$db->update($db_config, array('config_value' => $mavatars_set), "config_cat='mavatars' AND config_name='set'");