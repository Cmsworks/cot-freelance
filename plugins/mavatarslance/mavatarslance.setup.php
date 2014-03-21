<?php

/**
 * [BEGIN_COT_EXT]
 * Code=mavatarslance
 * Name=MAvatars for freelance2 package
 * Description=Adding files for cotonti modules
 * Version=1.2.2
 * Date=08-aug-2013
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * Notes=
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=RW
 * Lock_members=
 * Requires_plugins=mavatars
 * [END_COT_EXT]

 * [BEGIN_COT_EXT_CONFIG]
 * folio=02:radio::1:
 * market=03:radio::1:
 * projects=04:radio::1:
 * [END_COT_EXT_CONFIG]
 */
/**
 * MAVATAR for Cotonti CMF
 *
 * @version 1.2.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 */
/* setup
 * insert into page.add template
  <!-- BEGIN: MAVATAR_ROW -->
  <div>{PAGEADD_FORM_MAVATAR} {PHP.L.Description}: {PAGEADD_FORM_MAVATARDESC_INPUT} {PHP.L.Key}: {PAGEADD_FORM_MAVATARKEY_INPUT}</div>
  <!-- END: MAVATAR_ROW -->
  {PAGEADD_FORM_MAVATAR}
 * 
 * page.edit.tpl
  <!-- BEGIN: MAVATAR_ROW -->
  <div>{PAGEEDIT_FORM_MAVATARDESC} - {PAGEEDIT_FORM_MAVATARFILE}
  <br />{PAGEEDIT_FORM_MAVATAR} {PHP.L.Description}: {PAGEEDIT_FORM_MAVATARDESC_INPUT} {PHP.L.Key}: {PAGEEDIT_FORM_MAVATARKEY_INPUT}
  <!-- IF {PAGEEDIT_FORM_MAVATARDELETE} -->
  {PHP.L.Delete} {PAGEEDIT_FORM_MAVATARDELETE}
  <!-- ENDIF -->	<hr /></div>
  <!-- END: MAVATAR_ROW -->
  {PAGEEDIT_FORM_MAVATAR}
 * 
 * page.tpl
  <!-- IF {PAGE_MAVATARCOUNT} -->
  <div class="block">	<div class="grey-line-thin" style=" margin-top:5px;"></div>
  <!-- FOR {KEY}, {VALUE} IN {PAGE_MAVATAR} -->
  <a style="padding-right:10px;" href="{VALUE.FILE}" title="{VALUE.DESC}"><img class="mavatar-catalog" src="{VALUE.S_}" /></a>
  <!-- ENDFOR -->
  </div>
  <!-- ENDIF -->
 * 
 * page.list.ptl
  <!-- IF {LIST_ROW_MAVATARCOUNT} -->
  <div class="katalogpic<!-- IF {LIST_TOP_TOTALLINES} == {LIST_ROW_NUM}--> lastel<!-- ELSE --> allel<!-- ENDIF -->">
  <!-- FOR {KEY}, {VALUE} IN {LIST_ROW_MAVATAR} -->
  <a style="display:block" href="{VALUE.FILE}" title="{VALUE.DESC}"><img class="mmavatar-catalog" src="{VALUE.FILE}" /></a>
  <!-- ENDFOR -->
  </div>
  <!-- ENDIF -->
 * 
 */
defined('COT_CODE') or die('Wrong URL');
