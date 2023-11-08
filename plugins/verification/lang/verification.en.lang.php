<?php

/**
 * English Language File for  Verification plugin
 *
 * @plugin Verification
 * @version 1.0
 * @author Dr2005alex
 * @copyright Copyright (c) Dr2005alex
 *
 */
defined('COT_CODE') or die('Wrong URL.');
/**
 * Plugin Info
 */
$L['ver_txt1'] = 'We invite you to participate in the verification - the process of voluntary users confirm their passport details.';
$L['ver_txt2'] = 'Verification is recommended for all users of the resource - both employers and Free-Lancer.';
$L['ver_txt3'] = 'We verified the user is displayed next to the Text a special badge ';
$L['ver_txt4'] = ' - &laquo;identity confirmed&raquo;.';
$L['ver_txt5'] = 'This allows the user to enhance the credibility of other users.';
$L['ver_txt6'] = 'Negotiation advantage is always given to the verified user (customer or contractor).';
$L['ver_name1'] = 'Marina Don';
$L['ver_name2'] = 'Vasily Petrov';

$L['ver_vrf_txt'] =  'Pass the verification';
$L['ver_vrf_status'] =  'User status';
$L['ver_vrf_txt_title'] =  'Confirm the identity of the account';

$L['ver_checked_user'] =  'Verified users';
$L['ver_checked'] =  'Verified';
$L['ver_nochecked'] =  'Unverified';
$L['ver_confirm'] =  'I confirm my consent to the processing and storage of personal data transmitted by me in the course of verification.';
$L['ver_confirm_error'] =  'To continue, you must confirm the consent to the processing of personal data !';



$L['ver_confirm_title']='Confirm the identity';
$L['ver_exist_title']='You have already sent a copy of the passport.';
$L['ver_statusexist_title']='Your identity has been confirmed.';
$L['ver_statusexist_desc']='You are a verified user. No need to go through the verification again.';
$L['ver_exist_desc']='Your copy of the passport is on moderation. Please wait while the administration of the site will check your copy and change your status.';
$L['ver_file_send_mess']='File sent for review.';
$L['ver_file_send_mess_desc']='Moderator will check your passport copy in the near future.<br /> After checking your status will be changed to &laquo;identity confirmed&raquo; and next to the text icon will be displayed <img src="'.$cfg['plugins_dir'].'/verification/img/ver_icon.png" width="15" height="15" alt="identity confirmed" border="0">';
$L['ver_file_title']='Select a scanned passport photo';
$L['ver_file_ext']='Allowed file extensions';
$L['ver_file_max']='The maximum image size';

$L['ver_mnotif_ttl']='New request for verification.';
$L['ver_mnotif_txt']='User %1$s, added scan passports to check.';

$L['info_desc'] = 'Proof of identity free-Lancer. Sending a scan of the passport for moderation.';

/**
 * Plugin Config
 */

$L['cfg_img_ext'] = 'Extension of uploaded files';
$L['cfg_img_max_size'] = 'The maximum image size (Mb)';
$L['cfg_mail_notify'] = array('Email for alerts on new applications.','Leave blank if you do not want to be notified.');

/**
 * Plugin tools
 */

$L['ver_tools_title'] = 'Administration passport data users.';
$L['ver_tools_help'] = 'After approval, the scan passport photos transferred to the folder &laquo;'.$ver_file_patch_new.'&raquo;';
$L['ver_tools_link_img'] = 'Link to scan passports';
$L['ver_tools_view_img'] = 'See photos at full size';
$L['ver_tools_close'] = 'Close';
$L['ver_tools_admin_action'] = 'Action';
$L['ver_tools_admin_action_confirm'] = 'Activate status';
$L['ver_tools_admin_action_done'] = ' «identity confirmed»';
$L['ver_tools_delete_confirm'] = 'Are you sure you want to delete the copy of your passport ?';
$L['ver_tools_yes'] = 'Yes';
$L['ver_tools_no'] = 'No';
$L['ver_tools_delete_confirm_done'] = 'Copy of passport removed.';
$L['ver_tools_add_scan'] = "Requests for verification ";
/**
 * Plugin errors
 */
$L['ver_filemimemissing'] = 'Error loading: Loading a file with the extension %1$s prohibited.';
$L['ver_imgnotvalid'] = 'This picture is not a real image %1$s.';
$L['ver_nofile'] = 'Unspecified image.';


$L['verification_help'] = '';
