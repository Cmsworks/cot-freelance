<?php

$R['sbr_statuses'] = array(
	'cancel',
	'refuse',
	'new',
	'confirm',
	'process',
	'done',
	'claim'
);

$R['sbr_localstatuses'] = array(
	$L['sbr_status_cancel'],
	$L['sbr_status_refuse'],
	$L['sbr_status_new'],
	$L['sbr_status_confirm'],
	$L['sbr_status_process'],
	$L['sbr_status_done'],
	$L['sbr_status_claim']
);

$R['sbr_labels'] = array(
	'cancel' => 'default',
	'refuse' => 'inverse',
	'new' => 'warning',
	'confirm' => 'warning',
	'process' => 'info',
	'done' => 'success',
	'claim' => 'important'
);

$R['sbr_posts_to_values'] = array('all', 'performer', 'employer');
$R['sbr_posts_to_titles'] = array($L['sbr_posts_to_all'], $L['sbr_posts_to_performer'], $L['sbr_posts_to_employer']);