<?php

/**
 * simproducts plugin
 *
 * @package simproducts
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');

global $db_market;

$db->query("ALTER TABLE $db_market ADD FULLTEXT(item_title)");
