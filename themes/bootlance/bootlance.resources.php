<?php

$R['code_title_page_num'] = ' (' . $L['Page'] . ' {$num})';
$R['link_pagenav_current'] = '<li class="active"><a href="{$url}"{$event}{$rel}>{$num}</a></li>';
$R['link_pagenav_first'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_first'].'</a></li>';
$R['link_pagenav_gap'] = '<li class="disabled"><a href="javascript:void();">...</a></li>';
$R['link_pagenav_last'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_last'].'</a></li>';
$R['link_pagenav_main'] = '<li><a href="{$url}"{$event}{$rel}>{$num}</a></li>';
$R['link_pagenav_next'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_next'].'</a></li>';
$R['link_pagenav_prev'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_prev'].'</a></li>';

$R['input_radio'] = '<label class="radio inline"><input type="radio" name="{$name}" value="{$value}"{$checked}{$attrs} /> {$title}</label>';

$R['notices_link'] = '<li><a href="{$url}" title="{$title}">{$title}</a></li>';
