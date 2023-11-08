<!-- BEGIN: MAIN -->

<div class="block">
	<h5><i class="fa fa-plug"></i> Статистика регистраций пользователей</h5>
	
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
			['Дата', 'Рег.'],
			<!-- BEGIN: REG_ROW -->
			['{REG_ROW_DAY|cot_date('d.m.Y', $this)}',  {REG_ROW_COUNT}],
			<!-- END: REG_ROW -->
        ]);

        var options = {
			title: '',
			hAxis: {title: 'Дата',  titleTextStyle: {color: '#333'}},
			vAxis: {minValue: 0},
			seriesType: "bars",
			series: {5: {type: "line"}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<div id="chart_div" style="width: 95%; height: 400px;"></div>
</div>

<!-- END: MAIN -->