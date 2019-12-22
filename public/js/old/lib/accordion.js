/* ===================================================================

 - Accodion

======================================================================*/

$(function() {

	var HPG = HPG || {};

	HPG = {
		toggleCondition: function(target) {
			var target = $(target);
			var targetParents = target.parents('div.acdArea');
			var targetHead = targetParents.find('div.acdHead');
			var targetBody = targetParents.find('div.acdBody');

			if (targetBody.css('display') === 'block') {
				targetBody.slideUp(100, function() {
					targetHead.addClass('acdClosed');
				});
			} else {
				targetBody.slideDown(200, function() {
					targetHead.removeClass('acdClosed');
				});
			}
		}
	};

	$('.acdHead').delegate('a', 'click', function(e) {
		e.preventDefault();
		HPG.toggleCondition(this);
	});
});


