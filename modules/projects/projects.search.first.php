<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=search.first
 * [END_COT_EXT]
 */

/**
 * projects module
 *
 * @package projects
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if (cot::$cfg['projects']['prjsearch']) {
	$rs['prjtitle'] = !empty($rs['prjtitle']) ? cot_import($rs['prjtitle'], 'D', 'INT') : 0;
	$rs['prjtext'] = !empty($rs['prjtext']) ? cot_import($rs['prjtext'], 'D', 'INT') : 0;
	$rs['prjsort'] = !empty($rs['prjtext']) ? cot_import($rs['prjsort'], 'D', 'ALP') : '';
	$rs['prjsort'] = (empty($rs['prjsort'])) ? 'date' : $rs['prjsort'];
    $rs['prjsort2'] = !empty($rs['prjsort2']) ? cot_import($rs['prjsort2'], 'D', 'ALP') : 'DESC';
    $rs['prjsort2'] = ($rs['prjsort2'] == 'DESC') ? 'DESC' : 'ASC';
	$rs['projectssub'] = !empty($rs['projectssub']) ? cot_import($rs['projectssub'], 'D', 'ARR') : null;
    $rs['projectssubcat'] = isset($rs['projectssubcat']) ? cot_import($rs['projectssubcat'], 'D', 'BOL') : 0;
    $rs['projectssubcat'] = $rs['projectssubcat'] ? 1 : 0;

	if ($rs['prjtitle'] < 1 && $rs['prjtext'] < 1) {
		$rs['prjtitle'] = 1;
		$rs['prjtext'] = 1;
	}

	if (($tab == 'projects' || empty($tab)) && cot_module_active('projects')) {
		require_once cot_incfile('projects', 'module');

		// Making the category list
		$projects_cat_list['all'] = cot::$L['plu_allcategories'];
		foreach (cot::$structure['projects'] as $cat => $x) {
			if (
                $cat != 'all' &&
                $cat != 'system' &&
                cot_auth('projects', $cat, 'R') &&
                (empty($x['group']) || $x['group'] == 0)
            ) {
				$projects_cat_list[$cat] = $x['tpath'];
				$prj_catauth[] = cot::$db->prep($cat);
			}
		}
		if (!is_array($rs['projectssub']) || $rs['projectssub'][0] == 'all') {
			$rs['projectssub'] = array();
			$rs['projectssub'][] = 'all';
		}

		/* === Hook === */
		foreach (cot_getextplugins('projects.search.catlist') as $pl) {
			include $pl;
		}
		/* ===== */

		$t->assign(array(
			'PLUGIN_PROJECTS_SEC_LIST' => cot_selectbox($rs['projectssub'], 'rs[projectssub][]', array_keys($projects_cat_list), array_values($projects_cat_list), false, 'multiple="multiple" style="width:50%"'),
			'PLUGIN_PROJECTS_RES_SORT' => cot_selectbox(
                $rs['prjsort'],
                'rs[prjsort]',
                array('date', 'title', 'count', 'cat'),
                array(cot::$L['plu_prj_res_sort1'], cot::$L['plu_prj_res_sort2'], cot::$L['plu_prj_res_sort3'], cot::$L['plu_prj_res_sort4']),
                false
            ),
			'PLUGIN_PROJECTS_RES_SORT_WAY' => cot_radiobox($rs['prjsort2'], 'rs[prjsort2]', array('DESC', 'ASC'), array($L['plu_sort_desc'], $L['plu_sort_asc'])),
			'PLUGIN_PROJECTS_SEARCH_NAMES' => cot_checkbox(($rs['prjtitle'] == 1 || count($rs['projectssub']) == 0), 'rs[prjtitle]', $L['plu_prj_search_names']),
			'PLUGIN_PROJECTS_SEARCH_TEXT' => cot_checkbox(($rs['prjtext'] == 1 || count($rs['projectssub']) == 0), 'rs[prjtext]', $L['plu_prj_search_text']),
			'PLUGIN_PROJECTS_SEARCH_SUBCAT' => cot_checkbox($rs['projectssubcat'], 'rs[projectssubcat]', $L['plu_prj_set_subsec']),
		));
		if ($tab == 'projects' || (empty($tab) && $cfg['plugin']['search']['extrafilters']))
		{
			$t->parse('MAIN.PROJECTS_OPTIONS');
		}
	}
}