var num = 1;

function changecats()
{
	var newstext = '';
	var unsetcats = '';
	num = $('#catgenerator .newscat').length;

	$('#catgenerator .newscat').each(function(i) {
		var ca_ext = $(this).find('.ca_ext').val();
		var ca_cat = $(this).find('.ca_cat').val();
		var ca_path = $(this).find('.ca_path').val();
		var ca_thumb = $(this).find('.ca_thumb').val();
		var ca_req = ($(this).find('.ca_req').attr('checked')) ? 1 : 0;
		var ca_fileext = $(this).find('.ca_fileext').val();
		var ca_size = $(this).find('.ca_size').val();
		

		if ($(this).length && ca_path != '')
		{

			newstext += ca_ext + '|' + ca_cat + '|' + ca_path + '|' + ca_thumb + '|' + ca_req + '|' + ca_fileext + '|' + ca_size;
			if (i < num) newstext +=  '\r\n';
			num++;
		}
	});
	$('[name=set]').val(newstext);
}

$(".deloption").live("click", function () {
	$(this).closest('tr').remove();
	changecats();
	return false;
});

$('#addoption').live("click", function(){
	var object = $('.newscat').last().clone();
	$(object).find('.deloption').show();
	$(object).find('input[type=text]').val('');
	$(object).find('input[type=checkbox]').attr('checked', false);
	$(object).insertBefore('#addtr').show();
	changecats();
	return false;
});
	
$('input[type=text], input[type=checkbox]').live("change", function(){
	changecats();
});
$('input[type=checkbox]').live("click", function(){
	changecats();
});

$(document).ready(function(){
	$('#catgenerator').show().prependTo($('form#saveconfig'));
	$('[name=set]').closest('tr').hide();

	$('#catgenerator .newscat').each(function(i) {
		if(i > 0) $(this).find('.deloption').show();

	});

	changecats();
});