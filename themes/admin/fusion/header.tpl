<!-- BEGIN: HEADER -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="generator" content="Cotonti http://www.cotonti.com">
<meta http-equiv="expires" content="Fri, Apr 01 1974 00:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{HEADER_BASEHREF}
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/bootstrap/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/bootstrap/css/bootstrap-responsive.css" type="text/css">
<link rel="stylesheet" href="{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/{PHP.cfg.admintheme}.css" type="text/css">
<title>{HEADER_TITLE}</title>
<script src="js/jquery.min.js"></script>
<script src="{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/bootstrap/js/bootstrap.js"></script>
{HEADER_BASEHREF}
{HEADER_HEAD}
</head>
<body>
	
<div id="wrapper">
	
	<div class="navbar navbar-inverse navbar-static-top">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="{PHP|cot_url('admin')}">{PHP.cfg.maintitle}</a>
				<div class="nav-collapse collapse">
					<p class="navbar-text pull-right">
						<a class="navbar-link" href="{PHP|cot_url('index')}" title="{PHP.cfg.maintitle} {PHP.cfg.separator} {PHP.cfg.subtitle}">{PHP.L.Website}</a> | 
						<a class="navbar-link" href="{PHP.sys.xk|cot_url('login', 'out=1&x=$this')}">{PHP.L.Logout}</a>
					</p>
					<ul class="nav">
						<li class="<!-- IF !{PHP.m} -->active<!-- ENDIF -->"><a href="{PHP|cot_url('admin')}" title="{PHP.L.Administration}">{PHP.L.Home}</a></li>
						<li class="<!-- IF {PHP.m} == 'config' -->active<!-- ENDIF -->"><a href="{PHP|cot_url('admin', 'm=config')}" title="{PHP.L.Configuration}">{PHP.L.Configuration}</a></li>
						<li class="<!-- IF {PHP.m} == 'structure' -->active<!-- ENDIF -->"><a href="{PHP|cot_url('admin', 'm=structure')}" title="{PHP.L.Structure}">{PHP.L.Structure}</a></li>
						<li class="<!-- IF {PHP.m} == 'extensions' -->active<!-- ENDIF -->"><a href="{PHP|cot_url('admin', 'm=extensions')}" title="{PHP.L.Extensions}">{PHP.L.Extensions}</a></li>
						<li class="<!-- IF {PHP.m} == 'users' -->active<!-- ENDIF -->"><a href="{PHP|cot_url('admin', 'm=users')}" title="{PHP.L.Users}">{PHP.L.Users}</a></li>
						<li class="<!-- IF {PHP.m} == 'other' -->active<!-- ENDIF -->"><a href="{PHP|cot_url('admin', 'm=other')}" title="{PHP.L.Other}">{PHP.L.Other}</a></li>
					</ul>
				</div>
			</div>
		</div>
    </div>
	
	<div class="container">
		
<!-- END: HEADER -->