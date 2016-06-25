var num = 1; 

function changeareas()
{
	var areastext = '';
	var unsetareas = '';
	num = $('#areagenerator .area').length;

	$('#areagenerator .area').each(function(i) {
		var area_groupid = $(this).find('select option:selected').val();			
		var area_limit1 = $(this).find('.area_limit1').val();	
		var area_limit2 = $(this).find('.area_limit2').val();	
		if (area_groupid > 0)
		{
			areastext += area_groupid + '|' + area_limit1 + '|' + area_limit2;
			if (i + 1 < num) areastext +=  '\r\n';
		}
	});
	$('[name=catslimit]').val(areastext);
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
	
$('#areagenerator').live("change", function(){
	changeareas();
});

$(document).ready(function(){
	$('#areagenerator').show().prependTo($('form#saveconfig'));
	$('[name=catslimit]').closest('tr').hide();

	changeareas();
});