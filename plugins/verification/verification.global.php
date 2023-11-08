<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

/**
 * Verification of the identity of the freelancers. Checks the scanned passport.
 *
 * @plugin Verification
 * @version 1.0
 * @author Dr2005alex
 * @copyright Copyright (c) Dr2005alex
 *
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('verification', 'plug');
require_once cot_incfile('verification', 'plug', 'resources');
list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'verification');

$glb_vrf_link = cot_rc('vrf_link',array('url' => cot_url('plug', 'e=verification'),'txt' => $L['ver_vrf_txt'], 'title' => $L['ver_vrf_txt_title']));
$glb_vrf_link_user = (!$usr['profile']['user_verification_status']) ?  $glb_vrf_link : '';
$glb_vrf_link_admin = ($cfg['verification_plug']['verification_count'] > 0 && $auth_admin) ?  cot_rc('vrf_link',array('url' => cot_url('admin', 'm=other&p=verification'),'txt' => $L['ver_tools_add_scan'].$cfg['verification_plug']['verification_count'], 'title' => $L['ver_tools_add_scan'])):'';


