<?php

/**
 * Reviews plugin
 *
 * @package reviews
 * @version 2.2.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

global $cot_extrafields;
// Tables
cot::$db->registerTable('reviews');

/**
 * Вывод "oчков" пользователя
 *
 * @param int $userid id пользователя
 * @return array
 */
function cot_getreview_scores($userid)
{
	global $db_reviews, $db;
	$scores = array();
	$scores['total']['count'] = 0;
	$scores['total']['summ'] = 0;
	$scores['neg']['count'] = 0;
	$scores['neg']['summ'] = 0;
	$scores['poz']['count'] = 0;
	$scores['poz']['summ'] = 0;
	$sql = $db->query("SELECT COUNT(item_score) AS cnt, item_score FROM $db_reviews WHERE item_touserid=" . (int) $userid . " 
		GROUP BY item_score ORDER BY item_score ASC");
	while ($scr = $sql->fetch())
	{
		$scr['item_score'] = (int)$scr['item_score'];
		$summ = $scr['cnt'] * $scr['item_score'];
		$scores[$scr['item_score']]['count'] = $scr['cnt'];
		$scores[$scr['item_score']]['summ'] = $summ;
		$scores['total']['count'] += $scr['cnt'];
		$scores['total']['summ'] += $summ;
		if ($scr['item_score'] != 0)
		{
			$pozneg = ($scr['item_score'] > 0) ? 'poz' : 'neg';
			$scores[$pozneg]['count'] += $scr['cnt'];
			$scores[$pozneg]['summ'] += abs($summ);
		}
	}
	return $scores;
}

/**
 * Форма просмара отзывов /добавление отзыва
 *
 * @param int $userid id пользователя
 * @param string $area модуль/плагин
 * @param string $code код
 * @param string $name URL Module or script name
 * @param mixed $params URL parameters as array or parameter string
 * @param string $tail URL postfix, e.g. anchor
 * @param bool $showall show all reviews
 * @return string
 */
function cot_reviews_list($userid, $area, $code='', $name='', $params='', $tail='', $showall = false)
{
	global $db_reviews, $db_users, $db, $L, $usr, $cfg;
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'reviews', 'RWA');
	if ($usr['auth_read'])
	{
		$t1 = new XTemplate(cot_tplfile(array('reviews', $area), 'plug'));

		require_once cot_langfile('reviews', 'plug');
		
		if (!$showall)
		{
			$sqlcode = !empty($code) ? " AND item_code='" . $db->prep($code) . "'" : '';
			$sqlarea = " AND item_area='".$db->prep($area)."'";
		}
		$sql = $db->query("SELECT * FROM $db_reviews as r LEFT JOIN $db_users as u ON u.user_id=r.item_userid 
			WHERE item_touserid=" . (int)$userid . $sqlarea . $sqlcode . " ORDER BY item_date ASC");
		
		if(is_array($params))
		{
			$params2 = array();
			foreach ($array as $key => $value)
			{
				$params2[$key] = str_replace(array('$userid', '$area', '$code'), array('$userid', $area, $code), $value);
			}
			$params = $params2;
		}
		else
		{
			$params = str_replace(array('$userid', '$area', '$code'), array('$userid', $area, $code), $params);
		}
		$redirect = cot_url($name, $params, $tail, true);
		$redirect = base64_encode($redirect);

		while ($item = $sql->fetch())
		{
			if ($usr['id'] == $item['item_userid'] || $usr['isadmin'])
			{
				$t1->assign(array(
					'REVIEW_FORM_ID' => $item['item_id'],
					'REVIEW_FORM_SEND' => cot_url('plug', 'r=reviews&a=update&area='.$area.'&code='.$code.'&touser='.$userid.'&redirect='.$redirect.'&itemid=' . $item['item_id']),
					'REVIEW_FORM_TEXT' => cot_textarea('rtext', $item['item_text'], 5, 50),
					'REVIEW_FORM_SCORE' => cot_radiobox($item['item_score'], 'rscore', $L['reviews_score_values'], $L['reviews_score_titles']),
					'REVIEW_FORM_USERID' => $item['item_userid'],
					'REVIEW_FORM_DELETE_URL' => cot_url('plug', 'r=reviews&a=delete&area='.$area.'&code='.$code.'&touser='.$userid.'&redirect='.$redirect.'&itemid=' . $item['item_id']),
				));
        
        /* === Hook === */
        foreach (cot_getextplugins('reviews.edit.tags') as $pl)
        {
        	include $pl;
        }
        /* ===== */
        
				$t1->parse('MAIN.REVIEWS_ROWS.EDITFORM');
			}
			
			$t1->assign(cot_generate_usertags($item, 'REVIEW_ROW_'));
			$t1->assign(array(
				'REVIEW_ROW_ID' => $item['item_id'],
				'REVIEW_ROW_TEXT' => $item['item_text'],
				'REVIEW_ROW_TOUSER' => $item['item_touser'],
				'REVIEW_ROW_OWNERID' => $item['item_userid'],
				'REVIEW_ROW_OWNER' => cot_build_user($item['item_userid'], htmlspecialchars($item['user_name'])),
				'REVIEW_ROW_SCORE' => ($item['item_score'] > 0) ? '+' . $item['item_score'] : $item['item_score'],
				'REVIEW_ROW_AREA' => $item['item_area'],
				'REVIEW_ROW_CODE' => $item['item_code'],
				'REVIEW_ROW_DATE' => $item['item_date'],
				'REVIEW_ROW_DELETE_URL' => ($usr['id'] == $item['item_userid'] || $usr['isadmin']) ? cot_url('plug', 'r=reviews&a=delete&area='.$area.'&code='.$code.'&itemid=' . $item['item_id'] . '&redirect='.$redirect) : '',
			));
      
      /* === Hook === */
      foreach (cot_getextplugins('reviews.list.tags') as $pl)
      {
      	include $pl;
      }
      /* ===== */

			if($item['item_area'] == 'projects' && !empty($item['item_code']))
			{
				require_once cot_incfile('projects', 'module');
				global $db_projects;
				
				$prj = $db->query("SELECT * FROM $db_projects WHERE item_id=".$item['item_code'])->fetch();
				$t1->assign(cot_generate_projecttags($prj, 'REVIEW_ROW_PRJ_'));
			}
			
			$t1->parse('MAIN.REVIEWS_ROWS');
		}

		if($cfg['plugin']['reviews']['checkprojects'] && cot_module_active('projects') && $usr['id'] > 0 && $usr['auth_write'] && $usr['id'] != $userid)
		{
			require_once cot_incfile('projects', 'module');
			global $db_projects_offers, $db_projects;
			
			$prj_reviews_sql = $db->query("SELECT item_code FROM $db_reviews WHERE item_area='projects' AND item_userid=".$usr['id']);
			while($row = $prj_reviews_sql->fetch())
			{
				$prjreviews[] = $row['item_code'];
			}
			
			$prjreviews_string = (count($prjreviews) > 0) ? "AND o.offer_pid NOT IN (".implode(",", $prjreviews).")" : '';
			
			$bothprj_count = $db->query("SELECT COUNT(*) FROM  $db_projects_offers AS o
				LEFT JOIN $db_projects AS p ON p.item_id=o.offer_pid
				WHERE ((p.item_userid = '".$userid."' AND o.offer_userid='".$usr['id']."')
					OR (p.item_userid = '".$usr['id']."' AND o.offer_userid='".$userid."')) 
					AND o.offer_choise='performer' 
					$prjreviews_string
					")->fetchColumn();
			
			if($bothprj_count > 0)
			{
				$bothprj_sql = $db->query("SELECT * FROM  $db_projects_offers AS o
				LEFT JOIN $db_projects AS p ON p.item_id=o.offer_pid
				WHERE ((p.item_userid = '".$userid."' AND o.offer_userid='".$usr['id']."')
					OR (p.item_userid = '".$usr['id']."' AND o.offer_userid='".$userid."')) 
					AND o.offer_choise='performer' 
					$prjreviews_string
					");
				while($bprj = $bothprj_sql->fetch())
				{
					$prj_ids[] = $bprj['offer_pid'];
					$prj_titles[] = $bprj['item_title'];
				}
			}
			
			$area = 'projects';
			
			$usr['auth_write'] = ((int)$bothprj_count == 0) ? false : $usr['auth_write'];
		}
		else
		{
			$sqlcode = !empty($code) ? " AND item_code='" . $db->prep($code) . "'" : '';
			$sqlarea = " AND item_area='".$db->prep($area)."'";
			$reviews_count = $db->query("SELECT COUNT(*) FROM $db_reviews 
				WHERE item_userid=" . (int)$usr['id'] . "
					AND item_touserid=" . (int)$userid . $sqlarea . $sqlcode)->fetchColumn();
			$usr['auth_write'] = ($reviews_count > 0) ? false : $usr['auth_write'];
		}
		
		if ($usr['auth_write'] && $usr['id'] != $userid)
		{
			cot_display_messages($t1);
			
			$t1->assign(array(
				'REVIEW_FORM_SEND' => cot_url('plug', 'r=reviews&a=add&area='.$area.'&touser='.$userid.'&redirect='.$redirect),
				'REVIEW_FORM_TEXT' => cot_textarea('rtext', $ritem['item_text'], 5, 50),
				'REVIEW_FORM_SCORE' => cot_radiobox($ritem['item_score'], 'rscore', $L['reviews_score_values'], $L['reviews_score_titles']),
				'REVIEW_FORM_PROJECTS' => ($cfg['plugin']['reviews']['checkprojects'] && cot_module_active('projects') && $bothprj_count > 0) ? cot_selectbox($pid, 'code', $prj_ids, $prj_titles, false) : '',
				'REVIEW_FORM_ACTION' => 'ADD',
			));
      
      /* === Hook === */
      foreach (cot_getextplugins('reviews.add.tags') as $pl)
      {
      	include $pl;
      }
      /* ===== */
      
			$t1->parse('MAIN.FORM');
		}
		$t1->parse('MAIN');
		return $t1->text('MAIN');
	}
	return '';
}
?>