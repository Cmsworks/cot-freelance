<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=input
 * [END_COT_EXT]
 */
 
/**
 * Interkassa billing Plugin
 *
 * @package ikassabilling
 * @version 1.0
 * @author Yusupov, esclkm
 * @copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');


if(($_GET['e'] == 'mavatars' || $_GET['r'] == 'mavatars') && $_GET['m'] == 'upload' && $_SERVER['REQUEST_METHOD'] == 'POST')
{
//	define('COT_NO_ANTIXSS', TRUE) ;
//	$cfg['referercheck'] = false;
}


?>