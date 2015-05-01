<!-- BEGIN: MAIN -->
	<h4><!-- IF {PHP.usr.id} == {PHP.urr.user_id} AND {ADDPRD_SHOWBUTTON} --><div class="pull-right"><a href="{PRD_ADDPRD_URL}" class="btn btn-success">{PHP.L.market_add_product}</a></div><!-- ENDIF -->{PHP.L.market}</h4>
	
	<ul class="nav nav-pills">
	  <li>
	 	  <a href="{PHP.urr.user_id|cot_url('users', 'm=details&id=$this&tab=market')}">{PHP.L.All}</a>
	  </li>
	  	<!-- BEGIN: CAT_ROW -->
	  		<li class="centerall <!-- IF {PRD_CAT_ROW_SELECT} -->active<!-- ENDIF -->">
	  				<a href="{PRD_CAT_ROW_URL}">
	  						<!-- IF {PRD_ROW_CAT_ICON} -->
	  							<img src="{PRD_CAT_ROW_ICON}" alt="{PRD_CAT_ROW_TITLE} ">
	  						<!-- ENDIF -->
	  						{PRD_CAT_ROW_TITLE} 
	  					<span class="badge badge-inverse">{PRD_CAT_ROW_COUNT_MARKET}</span>
	  				</a>
	  		</li>
	  	<!-- END: CAT_ROW -->
	</ul>
	<hr>
	<div class="row">
	<!-- BEGIN: PRD_ROWS -->
		<div class="span3 pull-left">
			<h5><a href="{PRD_ROW_URL}">{PRD_ROW_SHORTTITLE}</a></h5>
			<!-- IF {PRD_ROW_USER_IS_ADMIN} --><span class="label label-info">{PRD_ROW_LOCALSTATUS}</span><!-- ENDIF -->
			<!-- IF {PRD_ROW_MAVATAR.1} -->
			<a href="{PRD_ROW_URL}"><img src="{PRD_ROW_MAVATAR.1|cot_mav_thumb($this, 200, 200, crop)}" /></a>
			<!-- ENDIF -->
			<!-- IF {PRD_ROW_COST} > 0 --><div class="cost">{PRD_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF -->
		</div>
	<!-- END: PRD_ROWS -->
	</div>
	
	<!-- IF {PAGENAV_COUNT} > 0 -->	
	<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>
	<!-- ELSE -->
	<div class="alert">{PHP.L.market_empty}</div>
	<!-- ENDIF -->

<!-- END: MAIN -->