<!-- BEGIN: MAIN -->

<div class="breadcrumb">{SBRADD_TITLE}</div>
<h1>{SBRADD_SUBTITLE}</h1>
<div class="row">
	<div class="span12">
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form action="{SBRADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="sbrform" id="sbrform">
			<input type="hidden" name="stagescount" value="{PHP.stagescount}"/>
			<div class="well">
				<table class="table customform">
					<tr>
						<td class="width30"><b>{PHP.L.sbr_title}</b></td>
						<td class="width70"><input type="text" name="rsbrtitle" value="{SBR_PROJECT_SHORTTITLE}"/></td>
					</tr>
					<tr>
						<td class="width30"><b>{PHP.L.sbr_performer}</b></td>
						<td class="width70">
							<!-- IF {PHP.uid} -->
							<a href="{SBR_PERFORMER_DETAILSLINK}" target="blank">{SBR_PERFORMER_NICKNAME}</a>
							<!-- ELSE -->
							{SBRADD_FORM_PERFORMER}
							<!-- ENDIF -->
						</td>
					</tr>
				</table>
			</div>		
			<div id="sbrstageslist">
				<!-- BEGIN: STAGE_ROW -->
				<div class="stageblock<!-- IF {STAGEADD_FORM_NUM} == {PHP.stagescount} --> laststage<!-- ENDIF --> well">
					<div class="removestage pull-right<!-- IF {STAGEADD_FORM_NUM} == 1 --> hidden<!-- ENDIF -->"><i class="icon icon-remove" onclick="SbrRemoveStage(this); return false;"></i></div>
					<h5>{PHP.L.sbr_stage} № <span class="stagenum">{STAGEADD_FORM_NUM}</span></h5>
					<table class="table customform">
						<tr>
							<td class="width30"><b>{PHP.L.sbr_stagetitle}</b></td>
							<td class="width70">{STAGEADD_FORM_TITLE}</td>
						</tr>
						<tr>
							<td class="width30"><b>{PHP.L.sbr_stagetext}</b></td>
							<td class="width70">
								{STAGEADD_FORM_TEXT}
								<div class="stagefiles">
									<ol class="fileslist">
									</ol>
									<a href="javascript:void(0);" onclick="StageFileAdd(this); return false;">Прикрепить файл</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class="width30"><b>{PHP.L.sbr_stagecost} ({PHP.cfg.payments.valuta})</b>
								<!-- IF {PHP.cfg.plugin.sbr.mincost} > 0 -->
								<p class="small">{PHP.L.sbr_mincost} {PHP.cfg.plugin.sbr.mincost} {PHP.cfg.payments.valuta}</p>
								<!-- ENDIF -->
							</td>
							<td>{STAGEADD_FORM_COST}</td>
						</tr>
						<tr>
							<td class="width30"><b>{PHP.L.sbr_stagedays} ({PHP|cot_declension(0, 'Days', true)})</b>
								<!-- IF {PHP.PHP.cfg.plugin.sbr.maxdays} > 0 -->
								<p class="small">{PHP.L.sbr_maxdays} {PHP.cfg.plugin.sbr.maxdays|cot_declension($this, 'Days')}</p>
								<!-- ENDIF -->
							</td>
							<td>{STAGEADD_FORM_DAYS}</td>
						</tr>
					</table>
				</div>
				<!-- END: STAGE_ROW -->
			</div>
			<p>
				<a href="javascript:void(0);" onclick="SbrAddNewStage(); return false;"><i class="icon icon-plus"></i>{PHP.L.sbr_addstagelink}</a>
			</p>
			<div class="well">
				<h4>{PHP.L.sbr_calc_title}</h4>
				<table class="table">
					<tr>
						<td class="width30"><b>{PHP.L.sbr_calc_summ}</b></td>
						<td class="width70"><span id="summ">0</span> {PHP.cfg.payments.valuta}</td>
					</tr>
					<tr>
						<td class="width30"><b>{PHP.L.sbr_calc_tax}</b></td>
						<td class="width70"><span id="taxsumm">0</span> {PHP.cfg.payments.valuta}</td>
					</tr>
					<tr>
						<td class="width30"><b>{PHP.L.sbr_calc_total}</b></td>
						<td><span id="total">0</span> {PHP.cfg.payments.valuta}</td>
					</tr>
				</table>
			</div>

			<p>
			<button type="submit" name="rsbrsubmit" class="btn btn-success" value="send">{PHP.L.sbr_sendtoconfirm}</button>
			</p>
		</form>
	</div>
</div>

<script>
	
	$().ready(function() {
		$('#sbrform').bind('change click keyup', function (){
			var stagescost = 0;
			var taxsumm = 0;
			var tax = {PHP.cfg.plugin.sbr.tax};
			$('.stagecost').each(function(i) {
				var stagecost = parseInt($(this).val());
				stagecost = (stagecost > 0) ? stagecost : 0;
				stagescost += stagecost;
			});
			
			if(tax > 0)
			{
				taxsumm = stagescost*tax/100;
			}
			$('#summ').html(stagescost);
			$('#taxsumm').html(taxsumm);
			$('#total').html(stagescost + taxsumm);
		});
	});

	function SbrRemoveStage(obj)
	{
		$(obj).parent().parent().remove();
		$('.stageblock').removeClass('laststage');
		$('.stageblock:last').addClass('laststage');
		
		var laststagenum = 0;
		$('.stageblock').each(function(i, elem) {
			laststagenum++;
			$(elem).children().children('.stagenum').text(laststagenum);
			
			$(elem).find('input, textarea, select').each(function(j) {
				var newfieldname = $(this).attr('name').replace(/(.*\[)(\d+)(\])/, function(f, p1, p2, p3) {
					return p1 + laststagenum + p3;
				});
				$(this).attr('name', newfieldname);
			});
		});
		$('input[name="stagescount"]').val(laststagenum);
	}

	function SbrAddNewStage()
	{
		var laststagenum = $('.stagenum:last').text();
		$('.laststage').clone().insertAfter('.laststage').show();	
		$('.stageblock').removeClass('laststage');
		$('.stageblock:last').addClass('laststage');
		$('.laststage').find('input').val('');
		$('.laststage').find('textarea').val('');
		$('.laststage').find('.fileslist').html('');
		$('.laststage').find('.error').addClass('hidden');
		laststagenum++;
		$('input[name="stagescount"]').val(laststagenum);
		$('.stagenum:last').text(laststagenum);
		$('.removestage:last').removeClass('hidden');

		$('.laststage').find('input, textarea, select').each(function(j) {
			var newfieldname = $(this).attr('name').replace(/(.*\[)(\d+)(\])/, function(f, p1, p2, p3) {
				return p1 + laststagenum + p3;
			});
			$(this).attr('name', newfieldname);
		});

	}
	
	function StageFileAdd(obj)
	{
		var stagenum = $(obj).closest('.stageblock').find('.stagenum').text();
		$(obj).parent().children('.fileslist').append('<li>\n\
			<a href="javascript:void(0);" onclick="StageFileRemove(this); return false;" class="pull-right"><i class="icon icon-remove"></i></a>\n\
			<input type="file" name="rstagefiles[' + stagenum + '][]" />\n\
		</li>');
	}
	
	function StageFileRemove(obj)
	{
		$(obj).parent().remove();
	}


</script>

<!-- END: MAIN -->