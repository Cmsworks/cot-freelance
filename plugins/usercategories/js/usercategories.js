$(function(){
	$('li :checkbox').on('click', function () {
		var $chk = $(this),
			$li = $chk.closest('li'),
			$ul, $parent;
		if ($li.has('ul')) {
			$li.find(':checkbox').not(this).prop('checked', this.checked);
		}
		do {
			$ul = $li.parent();
			$parent = $ul.siblings(':checkbox');
			if ($chk.is(':checked')) {
				$parent.prop('checked', $ul.has(':checkbox:not(:checked)').length == 0);
			} else {
				$parent.prop('checked', false);
			}
			$chk = $parent;
			$li = $chk.closest('li');
		} while ($ul.is(':not(.someclass)'));
	});
});