<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PAGE_TITLE}</div>
<h1>{PAGE_SHORTTITLE}</h1>
<div class="row">
	<div class="span9">
		<div class="clear textbox">{PAGE_TEXT}</div>
		{PAGE_COMMENTS_DISPLAY}
	</div>

	<div class="span3">
	<!-- BEGIN: PAGE_ADMIN -->
		<div class="block">
			<div class="mboxHD admin">{PHP.L.Adminpanel}</div>
			<ul class="nav nav-tabs nav-stacked">
				<!-- IF {PHP.usr.isadmin} -->
				<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
				<!-- ENDIF -->
				<li><a href="{PAGE_CAT|cot_url('page','m=add&c=$this')}">{PHP.L.page_addtitle}</a></li>
				<li>{PAGE_ADMIN_UNVALIDATE}</li>
				<li>{PAGE_ADMIN_EDIT}</li>
				<li>{PAGE_ADMIN_DELETE}</li>
			</ul>
		</div>
	<!-- END: PAGE_ADMIN -->
	<!-- BEGIN: PAGE_MULTI -->
		<div class="block">
			<div class="mboxHD info">{PHP.L.Summary}:</div>
			{PAGE_MULTI_TABTITLES}
			<p class="paging">{PAGE_MULTI_TABNAV}</p>
		</div>
	<!-- END: PAGE_MULTI -->
	</div>
</div>

<!-- END: MAIN -->