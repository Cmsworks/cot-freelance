<!-- BEGIN: MAIN -->
<div class="block"> 
  <!-- IF {PHP.cfg.plugin.profitstats.pfst_graf} --> 
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_sbr} -->['{PHP.L.Profits_sbr}: {SBR_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',     {SBR_SUMM}],
          ['{PHP.L.Profits_sbrtax}: {SBR_TAX_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',      {SBR_TAX_SUMM}],
          ['{PHP.L.Profits_sbrtax}: {SBR_TAX_PERFORMER_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',      {SBR_TAX_PERFORMER_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_pro} -->['{PHP.L.Profits_pro}: {PRO_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {PRO_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_market} -->['{PHP.L.Profits_market}: {MARKET_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {MARKET_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_paymarketbold} -->['{PHP.L.Profits_paymarketbold}: {PAYMARKETBOLD_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {PAYMARKETBOLD_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_paymarkettop} -->['{PHP.L.Profits_paymarkettop}: {PAYMARKETTOP_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {PAYMARKETTOP_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_payprjtop} -->['{PHP.L.Profits_payprjtop}: {PAYPRJTOP_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {PAYPRJTOP_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_payprjbold} -->['{PHP.L.Profits_payprjbold}: {PAYPRJBOLD_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {PAYPRJBOLD_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_paytop} -->['{PHP.L.Profits_paytop}: {PAYTOP_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {PAYTOP_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_paytop} -->['{PHP.L.Profits_paytopmarket}: {PAYTOPMARKET_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {PAYTOPMARKET_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_paytop} -->['{PHP.L.Profits_paytopprojects}: {PAYTOPPROJECTS_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {PAYTOPPROJECTS_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_paytop} -->['{PHP.L.Profits_paytopusers}: {PAYTOPUSERS_SUMM|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {PAYTOPUSERS_SUMM}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_outs} -->['{PHP.L.Profits_outstax}: {OUTS_TAX|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {OUTS_TAX}],<!-- ENDIF -->
          <!-- IF {PHP.cfg.plugin.profitstats.pfst_transfers} -->['{PHP.L.Profits_transfers}: {TRANSFER_TAX|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}',  {TRANSFER_TAX}],<!-- ENDIF -->
          
        ]);

        var options = {
          title: '{PHP.L.Profits_stat}',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  
    <div id="piechart_3d" style="width: 100%; height: 400px;"></div>
    <!-- IF {PHP.cfg.plugin.profitstats.pfst_total_amount} -->{PHP.L.Profits_total_amount}: {TOTAL_AMOUNT|number_format($this, '0', '.', ' ')} {PHP.cfg.payments.valuta}<!-- ENDIF -->
  <!-- ELSE -->
  <table class="table table-hover">
  <h3><i class="fa fa-plug"></i> {PHP.L.Profits_stat}</h3>
  <tr>
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_sbr} -->
      <td>{PHP.L.Profits_sbr}: <b>{SBR_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <td>{PHP.L.Profits_sbrtax}: <b>{SBR_TAX_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF --> 
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_pro} -->
      <td>{PHP.L.Profits_pro}: <b>{PRO_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF --> 
  </tr>
  <tr>
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_paytop} -->
      <td>{PHP.L.Profits_paytop}: <b>{PAYTOP_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <td>{PHP.L.Profits_paytopprojects}: <b>{PAYTOPPROJECTS_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <td>{PHP.L.Profits_paytopusers}: <b>{PAYTOPUSERS_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF --> 
  </tr>
  <tr>
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_paytop} -->
      <td>{PHP.L.Profits_paytopmarket}: <b>{PAYTOPMARKET_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF --> 
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_paymarketbold} -->
      <td>{PHP.L.Profits_paymarketbold}: <b>{PAYMARKETBOLD_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF --> 
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_paymarkettop} -->
      <td>{PHP.L.Profits_paymarkettop}: <b>{PAYMARKETTOP_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF -->
  </tr>
  <tr>
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_payprjbold} -->
      <td>{PHP.L.Profits_payprjbold}: <b>{PAYPRJBOLD_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF -->
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_payprjtop} -->
      <td>{PHP.L.Profits_payprjtop}: <b>{PAYPRJTOP_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF --> 
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_market} -->
      <td>{PHP.L.Profits_market}: <b>{MARKET_SUMM|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF -->
  </tr>
  <tr>
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_transfers} -->
      <td>{PHP.L.Profits_transfers}: <b>{TRANSFER_TAX|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF -->
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_outs} -->
      <td>{PHP.L.Profits_outstax}: <b>{OUTS_TAX|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF -->
      <!-- IF {PHP.cfg.plugin.profitstats.pfst_total_amount} -->
      <td style='color: #1dc116;'>{PHP.L.Profits_total_amount}: <b>{TOTAL_AMOUNT|number_format($this, '0', '.', ' ')}</b> {PHP.cfg.payments.valuta}</td>
      <!-- ENDIF -->
  </tr>
  </table>
  <!-- ENDIF -->   
</div>
<!-- END: MAIN -->