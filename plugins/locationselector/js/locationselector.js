
$('#locselectcountry').live("change", function(){
	var parent = $(this).closest('.locselect');
	var region = $(parent).find('#locselectregion');
	var region_name = $(region).attr('name');
	var city = $(parent).find('#locselectcity');
	var val = $(this).val();
	
	var cityoptionfirst = $(city).find('option:first').text();
	var regionoptionfirst = $(region).find('option:first').text();
	if(val != '0')
	{
		$.get('index.php?r=locationselector', {country: val},
		function(data){
			$(region).replaceWith(data).attr('name');
			$(parent).find('#locselectregion').attr('name', region_name);
			$(city).html('<option value="0">' + cityoptionfirst + '</option>');
			$(city).attr('disabled', 'disabled');
		});
	}
	else
	{
		$(region).html('<option value="0">' + regionoptionfirst + '</option>');
		$(region).attr('disabled', 'disabled');
		$(city).html('<option value="0">' + cityoptionfirst + '</option>');
		$(city).attr('disabled', 'disabled');
	}
	
});

$('#locselectregion').live("change", function(){
	var parent = $(this).closest('.locselect');
	var city = $(parent).find('#locselectcity');
	var city_name = $(city).attr('name');
	var val = $(this).val();
	
	if(val != '0')
	{	
		$.get('index.php?r=locationselector', {region: val},
		function(data){
			$(city).replaceWith(data).attr('name', city_name);
			$(parent).find('#locselectcity').attr('name', city_name);
		});
	}
	else
	{
		var cityoptionfirst = $(city).find('option:first').text();
		$(city).html('<option value="0">' + cityoptionfirst + '</option>');
		$(city).attr('disabled', 'disabled');
	}
});