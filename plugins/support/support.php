<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'support');

if(!$usr['auth_write']){
	if($usr['id'] == 0){
		$id = cot_import('id', 'G', 'INT');
		cot_redirect(cot_url('login', 'redirect='.base64_encode(cot_url('support', 'id='.$id)), '', true));
	}else{
		cot_block();
	}
}

require_once cot_incfile('support', 'plug');
require_once cot_incfile('extrafields');
require_once cot_incfile('forms');

// Mode choice
if (!in_array($m, array('newticket')))
{
	if (isset($_GET['id']))
	{
		$m = 'ticket';
	}
	else
	{
		$m = 'list';
	}
}

require_once cot_incfile('support', 'plug', $m);