<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.query
 * Order=2
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

$sqlorder = (strstr($sqlorder, "ispro")) ? $sqlorder.", user_userpoints DESC" : "user_userpoints DESC";

?>