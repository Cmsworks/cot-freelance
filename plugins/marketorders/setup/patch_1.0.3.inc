<?php
/**
 * 1.0.3
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');
require_once cot_incfile('marketorders', 'plug');

global $db_market, $cfg;

cot_extrafield_add($db_market, 'file', 'file', $R['input_file'],'zip,rar','','','', '','datas/marketfiles');

if(!file_exists('datas/marketfiles')) mkdir('datas/marketfiles');