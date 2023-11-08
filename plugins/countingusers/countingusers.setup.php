<?php
/* ====================
[BEGIN_COT_EXT]
Name=Counting Users
Code=Counting Users
Description=Подсчет и отображение количества пользователей, проектов, товаров для Фриланс биржи
Version=0.5
Date=2014-jun-16
Author=CrazyFreeMan
Copyright=(c) CrazyFreeMan (simple-website.in.ua)
Notes=BSD License
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
Requires_modules=users
Requires_plugins=
Recommends_modules=projects,market
Recommends_plugins=
[END_COT_EXT]
  
[BEGIN_COT_EXT_CONFIG]
count_usr=01:radio:0,1:0
user_maingrp_count=02:string::4,7
user_count_all=03:radio:0,1:0
count_prj=04:radio:0,1:1
projects_item_state=05:string::0
projects_from=06:string::86400
market_count=07:radio:0,1:0
cache_db=08:radio:0,1:0
cache_db_ttl=09:string::3600
[END_COT_EXT_CONFIG]
 
==================== */