<?php

defined('COT_CODE') or die('Wrong URL.');

// Requirements
require_once cot_langfile('affiliate', 'plug');


/*
 * Получаем массив процентов соответствующих реферальных уровней
 */
function affiliate_cfg_levelpays(){
	global $cfg;
	
	$upays_array = explode('|', $cfg['plugin']['affiliate']['levelpay']);
	if(is_array($upays_array)){
		foreach ($upays_array as $upays){
			$upay_array = explode(',', $upays);
			$level = 1;
			foreach ($upay_array as $i => $value){
				if($i == 0){
					$userid = $value;
				}else{
					$levelpays[$userid][$level] = $value;
					$level++;
				}
			}
		}
	}
	
	return $levelpays;
}

/*
 * Получаем дерево привлеченных рефералов
 */
function affiliate_getreferals($userid){
	global $db, $db_users;
	
	$referals = array();
	
	$sql = $db->query("SELECT user_id FROM $db_users WHERE user_referal=".$userid);
	while($referal = $sql->fetch()){
		$referals[$referal['user_id']] = affiliate_getreferals($referal['user_id']);
	}
	
	return $referals;
}


/*
 * Получаем цепочку аффилиатов
 */
function affiliate_getaffiliates($userid, $level = 1){
	global $db, $db_users;
	
	$affiliates = array();
	
	$affiliate = $db->query("SELECT user_referal FROM $db_users WHERE user_referal!=0 AND user_id=".$userid)->fetchColumn();
	if($affiliate){
		$affiliates[$level] = $affiliate;
		$nextaffs = affiliate_getaffiliates($affiliate, $level + 1);
		if(is_array($nextaffs)){
			$affiliates += $nextaffs;
		}
	}
	
	return $affiliates;
}


/*
 * Генерация реферального дерева
 */
function affiliate_referalstree($partnerid, $userid, $template = '', $level = 0){
	global $cfg;
	
	$level++;
	
	$referals = affiliate_getreferals($userid);
	
	if(!empty($referals)){
		$levelpays = affiliate_cfg_levelpays($partnerid);
		
		$t = new XTemplate(cot_tplfile(array('affiliate', 'level', $template), 'plug'));

		foreach ($referals as $referalid => $subreferals){
			$t->assign(cot_generate_usertags($referalid, 'REFERAL_ROW_USER_'));
			$t->assign(array(
				'REFERAL_ROW_LEVEL' => $level,
				'REFERAL_ROW_PERCENT' => ($levelpays[$partnerid][$level] > 0) ? $levelpays[$partnerid][$level] : $levelpays[0][$level],
			));

			if(count($subreferals) != 0 && ($level < $cfg['plugins']['affiliate']['maxlevelstoshow'] || $cfg['plugins']['affiliate']['maxlevelstoshow'] == 0)){
				$t->assign('REFERAL_ROW_SUBREFERALS', affiliate_referalstree($partnerid, $referalid, $template, $level));
			}else{
				$t->assign('REFERAL_ROW_SUBREFERALS', '');
			}
			$t->parse('REFERALS.REFERAL_ROW');
		}

		$t->parse('REFERALS');
		
		return $t->text('REFERALS');
	}else{
		return false;
	}
}