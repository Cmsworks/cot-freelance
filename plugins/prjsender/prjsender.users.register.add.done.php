<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.register.add.done
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

if ($userid > 0) {

    $allcats = cot_structure_children('projects', '', true);
    $prjcats = array();
    $prjcats_titles = array();
    foreach($allcats as $cat)
    {
        $prjcats[] = $cat;
    }

    $rcats = cot_import('cats', 'P', 'ARR');

    if(count($rcats) == count($prjcats)) {
        $rcats = '';
    }elseif(!empty($rcats)){
        $rcats = implode(',', $rcats);
    }else{
        $rcats = '-1';
    }

    $db->update($db_users, array('user_prjsendercats' => $rcats, 'user_prjsenderdate' => $sys['now']), "user_id=".$userid);
}