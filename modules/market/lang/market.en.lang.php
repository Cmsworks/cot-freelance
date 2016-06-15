<?php

/**
 * market module
 *
 * @package market
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
$L['cfg_marketsitemap'] = 'Enable on Sitemap';
$L['cfg_marketsitemap_freq'] = 'Sitemap frequency';
$L['cfg_marketsitemap_freq_params'] = $sitemap_freqs;
$L['cfg_marketsitemap_prio'] = array('Priority on Sitemap');
$L['cfg_description'] = array('Description');
$L['cfg_marketsearch'] = array('Enable search');
$L['cfg_warranty'] = array('Warranty period (days)');
$L['cfg_tax'] = array('Selling commission (%)');
$L['cfg_ordersperpage'] = array('Orders per page');
$L['cfg_notifmarket_admin_moderate'] = array('Notify on new product at checkout','Send email for new product in the pre-moderation');
$L['cfg_prdeditor'] = 'Configurable visual editor';
$L['cfg_prdeditor_params'] = 'Minimal set of buttons, Standard set of buttons, Advanced set of buttons';


$L['info_desc'] = 'Online market';

$L['market_select_cat'] = "Select Section";
$L['market_locked_cat'] = "Selected category blocked";
$L['market_empty_title'] = "The title can not be empty";
$L['market_empty_text'] = "Text is empty";
$L['market_large_img'] = "Image too large";

$L['market_forreview'] = 'Your product is submitted for review';

$L['market'] = 'Shop';
$L['market_myproducts'] = 'My products';

$L['market_catalog'] = 'Catalog';
$L['market_add_product'] = 'Add product';
$L['market_edit_product'] = 'Edit product';
$L['market_add_product_title'] = 'Adding product to market';
$L['market_edit_product_title'] = 'Edit product in market';

$L['market_hidden'] = 'Product is not active';
$L['market_location'] = 'Location';
$L['market_price'] = 'Price';
$L['market_image_limit'] = 'Allow formats jpeg, gif, jpg and png. Maximum size of 1MB. ';
$L['market_aliascharacters'] = 'Characters \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' are not allowed in aliases';

$L['market_costasc'] = 'Price Ascending';
$L['market_costdesc'] = 'Price descending';
$L['market_mostrelevant'] = 'The most urgent';

$L['market_notfound'] = 'Products no found';
$L['market_empty'] = 'No products';

$L['market_added_mail_subj'] = 'Your product has been published';
$L['market_senttovalidation_mail_subj'] = 'Your product is submitted for review';
$L['market_admin_home_valqueue'] = 'In validation';
$L['market_admin_home_public'] = 'Published';
$L['market_admin_home_hidden'] = 'Hidden';

$L['market_added_mail_body'] = 'Hello, {$user_name}. '."\n\n".'Your product "{$prd_name}" has been published on the website {$sitename} - {$link}';
$L['market_senttovalidation_mail_body'] = 'Hello, {$user_name}. '."\n\n".'Your product "{$prd_name}" is submitted for review. A moderator will check it as soon as possible.';

$L['market_notif_admin_moderate_mail_subj'] = 'The new product for review';
$L['market_notif_admin_moderate_mail_body'] = 'Hi, '."\n\n".'User {$user_name} submit new product "{$prd_name}".'."\n\n".'{$link}';

$L['market_status_published'] = 'Published';
$L['market_status_moderated'] = 'Moderated';
$L['market_status_hidden'] = 'Hidden';

$L['plu_market_set_sec'] = 'Products categories';
$L['plu_market_res_sort1'] = 'Date';
$L['plu_market_res_sort2'] = 'Title';
$L['plu_market_res_sort3'] = 'Popularity';
$L['plu_market_res_sort3'] = 'Category';
$L['plu_market_search_names'] = 'Search in titles';
$L['plu_market_search_text'] = 'Search in text';
$L['plu_market_set_subsec'] = 'Include subcategories';

$Ls['market_headermoderated'] = "товар на проверке,товара на проверке,товаров на проверке";