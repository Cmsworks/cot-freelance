var num = 1;

function changegroups()
{
	var groupstext = '';
	var unsetgroups = '';
	num = $('#groupgenerator .group').length;

	$('#groupgenerator .group').each(function(i) {
		var group_id = $(this).find('select option:selected').val();		

		if ($(this).length)
		{
			groupstext += group_id;
			if (i + 1 < num) groupstext +=  ',';
		}
	});
	(num == 1) ? $(".deloption").hide() : $(".deloption").show();

	$('[name=groups]').val(groupstext);
}

$(".deloption").live("click", function () {
	var nums = $('#groupgenerator .group').length;
	if(nums > 1)
	{
		$(this).closest('div').remove();
	}
	changegroups();
	return false;
});

$('#addoption').live("click", function(){
	var object = $('.group').last().clone();
	$(object).find('.deloption').show();
	$(object).find('input[type=text]').val('');
	$(object).find('input[type=checkbox]').attr('checked', false);
	$(object).insertBefore('#addtr').show();
	changegroups();
	return false;
});
	
$('input[type=text], input[type=checkbox]').live("change", function(){
	changegroups();
});
$('input[type=checkbox]').live("click", function(){
	changegroups();
});
$('select').live("change", function(){
	changegroups();
});

$(document).ready(function(){
	$('#groupgenerator').show();
	$('[name=groups]').hide();

	changegroups();
});