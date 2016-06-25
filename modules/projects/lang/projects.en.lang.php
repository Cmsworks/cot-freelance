<?php

/**
 * projects module
 *
 * @package projects
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_pagelimit'] = array('Items count in lists');
$L['cfg_indexlimit'] = array('Items count on index');
$L['cfg_offersperpage'] = array('Offers count on project page');
$L['cfg_shorttextlen'] = array('Text limit in lists');
$L['cfg_prevalidate'] = array('Enable prevalidation');
$L['cfg_preview'] = array('Enable preview');
$L['cfg_prjsitemap'] = 'Enable on Sitemap';
$L['cfg_prjsitemap_freq'] = 'Sitemap frequency';
$L['cfg_prjsitema_freq_params'] = $sitemap_freqs;
$L['cfg_prjsitemap_prio'] = array('Priority on Sitemap');
$L['cfg_description'] = array('Description');
$L['cfg_prjsearch'] = array('Enable search');
$L['cfg_license'] = array('License key');
$L['cfg_default_type'] = array('Default projects type');
$L['cfg_notif_admin_moderate'] = array('Notify on new projects at checkout','Send email for new projects in the pre-moderation');
$L['cfg_prjeditor'] = 'Configurable visual editor';
$L['cfg_prjeditor_params'] = 'Minimal set of buttons, Standard set of buttons, Advanced set of buttons';

$L['info_desc'] = 'Module publishing projects';

$L['projects_select_cat'] = "Select the category of project";
$L['projects_locked_cat'] = "Selected category blocked";
$L['projects_empty_title'] = "Title is empty";
$L['projects_empty_text'] = "Text of project is empty";

$L['projects_forreview'] = 'Your project is submitted for review';
$L['projects_isrealized'] = 'Executed!';

$L['projects'] = 'Projects catalog';
$L['projects_projects'] = 'Projects';
$L['projects_myprojects'] = 'My projects';
$L['catalog'] = 'Catalog';
$L['projects_add_to_catalog'] = 'Add project';
$L['projects_edit_project'] = 'Edit project';
$L['projects_add_project_title'] = 'Adding project';
$L['projects_edit_project_title'] = 'Editing project';

$L['projects_hidden'] = 'Project is not active';
$L['projects_success_projects'] = 'Successful projects';
$L['projects_next'] = 'Next';
$L['projects_reputation'] = 'Reputation';
$L['projects_aliascharacters'] = 'Characters \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' are not allowed in aliases';

$L['projects_status_published'] = 'Published';
$L['projects_status_moderated'] = 'Moderated';
$L['projects_status_hidden'] = 'Hidden';
$L['projects_admin_home_valqueue'] = 'In validation';
$L['projects_admin_home_public'] = 'Published';
$L['projects_admin_home_hidden'] = 'Hidden';

$L['project_added_mail_subj'] = 'Your project has been published';
$L['project_senttovalidation_mail_subj'] = 'Your project is submitted for review';

$L['project_added_mail_body'] = 'Hello, {$user_name}. '."\n\n".'Your project "{$prj_name}" has been published on the website {$sitename} - {$link}';
$L['project_senttovalidation_mail_body'] = 'Hello, {$user_name}. '."\n\n".'Your project "{$prj_name}" is submitted for review. A moderator will check it as soon as possible.';

$L['projects_price'] = 'Sted';

$L['projects_types_edit'] = 'Edit types';
$L['projects_types_new'] = 'Create category';
$L['projects_types_editor'] = 'Editor project types';
$L['projects_price'] = 'Price';

$L['projects_sendoffer'] = 'Add an offer';
$L['projects_step2_title'] = 'Project preview';
$L['projects_step2_buy'] = 'Buy';
$L['projects_step2_selectproject'] = 'Select a project';
$L['projects_nomoney'] = 'You have insufficient funds in the account to pay for the service.';

$L['projects_costasc'] = 'Price Ascending';
$L['projects_costdesc'] = 'Price descending';
$L['projects_mostrelevant'] = 'The most urgent';

$L['projects_notfound'] = 'Projects not found';
$L['projects_empty'] = 'No projects';

$L['offers_timetype'] = array('hours', 'days', 'months');

$L['offers_text_predl'] = 'Offer text';
$L['offers_hide_offer'] = 'Make offer only visible to the customer';
$L['offers_for_guest'] = 'Leave your suggestions on the project can only registered users with an account specialist.';


$L['offers_view_all'] = 'See all';
$L['offers_add_offer'] = 'Add an offer';
$L['offers_upload'] = 'Upload';
$L['offers_offers'] = 'Offers';
$L['offers_useroffers'] = 'My offers';
$L['offers_budget'] = 'Budget';
$L['offers_sroki'] = 'Time';
$L['offers_ot'] = '';
$L['offers_do'] = 'to';
$L['offers_otkazat'] = 'Refuse';
$L['offers_otkazali'] = 'Denied';
$L['offers_ispolnitel'] = 'Performer';
$L['offers_vibran_ispolnitel'] = 'Marked as performer';
$L['offers_ostavit_predl'] = 'Leave your offer';
$L['offers_add_predl'] = 'Add an offer';
$L['offers_empty'] = 'No offers';

$L['offers_useroffers_none'] = 'Not evaluated';
$L['offers_useroffers_performer'] = 'Performer';
$L['offers_useroffers_refuse'] = 'Refused';

$L['offers_empty_text'] = 'Offer text is empty';
$L['offers_add_done'] = 'Offer send';
$L['offers_add_post'] = 'Message send';

$L['performer_set_done'] = '{$username} chosen contractor';
$L['performer_set_refuse'] = 'Being denied {$username}';

$L['offers_add_msg'] = 'Send a message';
$L['offers_posts_title'] = 'Posts';

$L['project_added_offer_header'] = 'New msg of project «{$prtitle}»';
$L['project_added_offer_body'] = 'Hi, {$user_name}. '."\n\n".'.{$offeruser_name} sent offer for your project "{$prj_name}".'."\n\n".'{$link}';

$L['project_added_post_header'] = 'New msg of project "{$prtitle}"';
$L['project_added_post_body'] = 'Hi, {$user_name}. '."\n\n".'.{$postuser_name} sent message for your project "{$prj_name}".'."\n\n".'{$link}';

$L['project_setperformer_header'] = 'You have been selected for the project "{$prtitle}"';
$L['project_setperformer_body'] = 'Hi, {$offeruser_name}. '."\n\n".'You have chosen contractor for the project "{$prj_name}".'."\n\n".'{$link}';

$L['project_refuse_header'] = 'Being denied the project «{$prtitle}»';
$L['project_refuse_body'] = 'Hi, {$offeruser_name}. '."\n\n".'Being denied the project "{$prj_name}".'."\n\n".'{$link}';

$L['project_notif_admin_moderate_mail_subj'] = 'The new draft for review';
$L['project_notif_admin_moderate_mail_body'] = 'Hi, '."\n\n".'User {$user_name} submit new project "{$prj_name}".'."\n\n".'{$link}';

$L['project_realized'] = 'Mark executed';
$L['project_unrealized'] = 'Mark unexecuted';

$L['projects_license_error'] = 'Your license key is specified with an error or does not exist! Please enter a valid license key in the Projects module settings.';

$L['plu_prj_set_sec'] = 'Porjects categories';
$L['plu_prj_res_sort1'] = 'Date';
$L['plu_prj_res_sort2'] = 'Title';
$L['plu_prj_res_sort3'] = 'Popularity';
$L['plu_prj_res_sort3'] = 'Category';
$L['plu_prj_search_names'] = 'Search in titles';
$L['plu_prj_search_text'] = 'Search in projects text';
$L['plu_prj_set_subsec'] = 'Include subcategories';

$Ls['projects_headermoderated'] = "moderated project,project on moderation,projects in moderation";