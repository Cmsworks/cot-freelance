var num = 1; 

function changeareas()
{
	var areastext = '';
	var unsetareas = '';
	num = $('#areagenerator .area').length;

	$('#areagenerator .area').each(function(i) {
		var area_id = $(this).find('.area_id').val();		
		var area_name = $(this).find('.area_name').val();		
		var area_cost = $(this).find('.area_cost').val();		
		var area_period = $(this).find('.area_period option:selected').val();		
		var area_count = $(this).find('.area_count').val();		

		if (area_id > '' && area_name > '' && area_cost > 0)
		{
			areastext += area_id + '|' + area_name + '|' + area_cost + '|' + area_period + '|' + area_count;
			if (i + 1 < num) areastext +=  '\r\n';
		}
	});
	if(areastext > '')
	{
		$('[name=paytopareas]').val(areastext);
	}
}

$(".deloption").live("click", function () {
	$(this).closest('tr').remove();
	changeareas();
	return false;
});

$('#addoption').live("click", function(){
	var object = $('.area').last().clone();
	$(object).find('.deloption').show();
	$(object).find('input[type=text]').val('');
	$(object).find('input[type=checkbox]').attr('checked', false);
	$(object).insertBefore('#addtr').show();
	changeareas();
	return false;
});
	
$('input[type=text], input[type=checkbox]').live("change", function(){
	changeareas();
});
$('input[type=checkbox]').live("click", function(){
	changeareas();
});
$('select').live("change", function(){
	changeareas();
});

$(document).ready(function(){
	$('#areagenerator').show().prependTo($('form#saveconfig'));
	$('[name=paytopareas]').closest('tr').hide();

	changeareas();
});