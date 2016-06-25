<?php

/**
 * folio module
 *
 * @package folio
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
$L['cfg_shorttextlen'] = array('Text limit in lists');
$L['cfg_prevalidate'] = array('Enable prevalidation');
$L['cfg_preview'] = array('Enable preview');
$L['cfg_foliositemap'] = 'Enable on Sitemap';
$L['cfg_foliositemap_freq'] = 'Sitemap frequency';
$L['cfg_foliositemap_freq_params'] = $sitemap_freqs;
$L['cfg_foliositemap_prio'] = array('Priority on Sitemap');
$L['cfg_description'] = array('Description');
$L['cfg_foliosearch'] = array('Enable search');
$L['cfg_notiffolio_admin_moderate'] = array('Notify on new work at checkout','Send email for new work in the pre-moderation');
$L['cfg_folioeditor'] = 'Configurable visual editor';
$L['cfg_folioeditor_params'] = 'Minimal set of buttons, Standard set of buttons, Advanced set of buttons';

$L['info_desc'] = 'Portfolio';

$L['folio_select_cat'] = "Select Section";
$L['folio_locked_cat'] = "Selected category blocked";
$L['folio_empty_title'] = "The title can not be empty";
$L['folio_empty_text'] = "Text is empty";
$L['folio_large_img'] = "Image too large";

$L['folio_forreview'] = 'Your work is submitted for review';

$L['folio'] = 'Portfolio';
$L['folio_catalog'] = 'Catalog';
$L['folio_add_to_catalog'] = 'Add work';
$L['folio_add_work'] = 'Add work';
$L['folio_edit_work'] = 'Edit work';
$L['folio_add_work_title'] = 'Adding work to Portfolio';
$L['folio_edit_work_title'] = 'Editing work in Portfolio';

$L['folio_hidden'] = 'Work is not active';
$L['folio_location'] = 'Location';
$L['folio_price'] = 'Price';
$L['folio_image_limit'] = 'Allow formats jpeg, gif, jpg and png. Maximum size of 1MB. ';
$L['folio_aliascharacters'] = 'Characters \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' are not allowed in aliases';
$L['folio_costasc'] = 'Price Ascending';
$L['folio_costdesc'] = 'Price descending';
$L['folio_mostrelevant'] = 'The most urgent';

$L['folio_notfound'] = 'Works not found';
$L['folio_empty'] = 'No works';

$L['folio_added_mail_subj'] = 'Your work has been published on portfolio';
$L['folio_senttovalidation_mail_subj'] = 'Your work is submitted for review';
$L['folio_admin_home_valqueue'] = 'In validation';
$L['folio_admin_home_public'] = 'Published';
$L['folio_admin_home_hidden'] = 'Hidden';

$L['folio_added_mail_body'] = 'Hello, {$user_name}. '."\n\n".'Your work "{$prd_name}" has been published on the website {$sitename} - {$link}';
$L['folio_senttovalidation_mail_body'] = 'Hello, {$user_name}. '."\n\n".'Your work "{$prd_name}" is submitted for review. A moderator will check it as soon as possible.';

$L['folio_notif_admin_moderate_mail_subj'] = 'The new portfolio for review';
$L['folio_notif_admin_moderate_mail_body'] = 'Hi, '."\n\n".'User {$user_name} submit new portfolio "{$prd_name}".'."\n\n".'{$link}';

$L['folio_status_published'] = 'Published';
$L['folio_status_moderated'] = 'Moderated';
$L['folio_status_hidden'] = 'Hidden';

$L['plu_folio_set_sec'] = 'Works categories';
$L['plu_folio_res_sort1'] = 'Date';
$L['plu_folio_res_sort2'] = 'Title';
$L['plu_folio_res_sort3'] = 'Popularity';
$L['plu_folio_res_sort3'] = 'Category';
$L['plu_folio_search_names'] = 'Search in titles';
$L['plu_folio_search_text'] = 'Search in text';
$L['plu_folio_set_subsec'] = 'Include subcategories';

$Ls['folio_headermoderated'] = "Portfolio on moderation,Portfolio on moderation,Portfolio on moderation";