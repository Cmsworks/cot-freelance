<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');
require_once cot_incfile('marketorders', 'plug');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'marketorders', 'RWA');
cot_block($usr['auth_read']);

$m = cot_import('m','G','ALP');
$id = cot_import('id','G','INT');
$key = cot_import('key', 'G', 'TXT');

if($m == 'download'){

	if ($id > 0)
	{
		$sql = $db->query("SELECT * FROM $db_market_orders  AS o
			LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
			WHERE order_id=".$id." LIMIT 1");
	}

	if (!$id || !$sql || $sql->rowCount() == 0)
	{
		cot_die_message(404, TRUE);
	}
	$marketorder = $sql->fetch();

	cot_block($usr['isadmin'] || $usr['id'] == $marketorder['order_userid'] || $usr['id'] == $marketorder['order_seller'] || !empty($key) && $usr['id'] == 0);

	if($usr['id'] == 0)
	{
		$hash = sha1($marketorder['order_email'].'&'.$marketorder['order_id']);
		cot_block($key == $hash);
	}
	
	$file = $cfg['plugin']['marketorders']['filepath'].'/'.$marketorder['item_file'];
	
	if(file_exists($file) && ($marketorder['order_status'] == 'paid' || $marketorder['order_status'] == 'done') || $usr['isadmin'] || $usr['id'] == $marketorder['order_seller']){
		marketorders_file_download($file, $mimetype='application/octet-stream');
	}else{
		cot_block();
	}
}
