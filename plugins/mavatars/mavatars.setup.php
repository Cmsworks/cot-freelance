<?php

/**
 * [BEGIN_COT_EXT]
 * Code=mavatars
 * Name=MAvatars
 * Description=Adding files for cotonti modules
 * Version=2.2.3
 * Date=08-jan-2015
 * Author=esclkm littledev.ru
 * Copyright=(c)esclkm
 * Notes=
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=RW
 * Lock_members=
 * Recommends_modules=page
 * [END_COT_EXT]

 * [BEGIN_COT_EXT_CONFIG]
 * items=01:select:0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16:8:Attachments per post (max.)
 * set=99:textarea::||datas/mavatars|datas/mavatars|0||:Format settings cat|path|thumb path|reqiured|ext|mazfilesize
 * turnajax=02:radio::1:
 * turncurl=03:radio::0:
 * filecheck=04:radio::1:
 * separator_viewer=90:separator:0:0:Viewer config
 * width=91:string::800:Image width* 
 * height=92:string::640:Image height
 * method=93:select:crop,width,height,auto:width:Resize Method
 * [END_COT_EXT_CONFIG]
 */
/**
 * MAVATAR for Cotonti CMF
 *
 * @version 1.00
 * @author  esclkm, graber
 * @copyright (c) 2011 esclkm, graber
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
