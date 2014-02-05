<?php 

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('paypro', 'plug');
require_once cot_incfile('projects', 'module');

global $db_projects;

cot_extrafield_add($db_projects, 'forpro', 'checkbox', $R['input_checkbox'],'','','','', '','');

?>