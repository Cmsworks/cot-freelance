<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=header.tags,header.user.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paypro', 'plug');

$t1 = new XTemplate(cot_tplfile('paypro.header', 'plug'));

$upro = cot_getuserpro();

$t1->assign(array(
	'USER_ISPRO' => ($upro) ? TRUE : FALSE,
	'USER_PROEXPIRE' => $upro
));

$t1->parse('MAIN');
$t->assign('HEADER_PAYPRO', $t1->text('MAIN'));

$t->assign('HEADER_USER_PROEXPIRE', $upro);

?>