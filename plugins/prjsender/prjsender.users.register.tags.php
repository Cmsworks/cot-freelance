<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.register.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

$allcats = cot_structure_children('projects', '', true);
$prjcats = array();
$prjcats_titles = array();
foreach($allcats as $cat)
{
    $prjcats[] = $cat;
    $prjcats_titles[] = $structure['projects'][$cat]['title'];
}

if (count($prjcats) > 0) {
    $t->assign(array(
        'USERS_REGISTER_PRJSENDER_CATS' => cot_checklistbox($rcats, 'cats', $prjcats, $prjcats_titles, '', '', false),
    ));
}