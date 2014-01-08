<!-- BEGIN: MAIN -->
<div class="breadcrumb">{PRD_TITLE}</div>
<h1><!-- IF {PRD_COST} > 0 --><div class="pull-right cost">{PRD_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF -->{PRD_SHORTTITLE}</h1>
<div class="row">
	<div class="span9">
		<div class="media">
			<!-- IF {PRD_MAVATAR.1} -->
			<div class="pull-left">
				<a href="{PRD_MAVATAR.1.FILE}"><div class="thumbnail"><img src="{PRD_MAVATAR.1|cot_mav_thumb($this, 200, 200, crop)}" /></div></a>

				
				<!-- IF {PRD_MAVATARCOUNT} -->
				<p>&nbsp;</p>
				<div class="row">
					<!-- FOR {KEY}, {VALUE} IN {PRD_MAVATAR} -->
					<!-- IF {KEY} != 1 -->
					<a href="{VALUE.FILE}" class="span1 pull-left"><img src="{VALUE|cot_mav_thumb($this, 200, 200, crop)}" /></a>
					<!-- ENDIF -->
					<!-- ENDFOR -->
				</div>
				<!-- ENDIF -->
			</div>
			<!-- ENDIF -->		
			<p class="date">[{PRD_DATE}]</p>
			<p class="location">{PRD_COUNTRY} {PRD_REGION} {PRD_CITY}</p>
			<p class="text">{PRD_TEXT}</p>
			<hr/>
			<p>
				<a href="{PRD_SAVE_URL}" class="btn btn-success"><span>{PHP.L.Publish}</span></a> 
				<a href="{PRD_EDIT_URL}" class="btn btn-info"><span>{PHP.L.Edit}</span></a>
			</p>	
		</div>	
	</div>
	<div class="span3">	
		<div class="row">
			<div class="span1">{PRD_OWNER_AVATAR}</div>
			<div class="span2">
				<div class="pull-right"><span class="label label-info">{PRD_OWNER_USERPOINTS}</span></div>
				<div class="owner">{PRD_OWNER_NAME}</div>
			</div>
		</div>	
	</div>
</div>

<!-- END: MAIN -->