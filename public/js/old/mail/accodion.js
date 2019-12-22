/* ===================================================================

 - Accodion

======================================================================*/

$(document).ready(function() {

	var HPG = HPG || {};

	HPG = {
		toggleCondition: function(target) {
			var //$acdHead = $('.acdHead'),
					//$acdBody = $('.acdBody'),
				$target = $(target),
				$targetParents = $target.parents('div.acdArea'),
				$targetHead = $targetParents.find('div.acdHead'),
				$targetBody = $targetParents.find('div.acdBody');

			if ($targetBody.css('display') === 'block') {
				$targetBody.slideUp(100, function() {
					$targetHead.addClass('acdClosed');
					$('img[name!=block][name!=noblock]').protectImage();
				});
			} else {
				$targetBody.slideDown(200, function() {
					$targetHead.removeClass('acdClosed');
					$('img[name!=block][name!=noblock]').protectImage();
				});
			}
		}
	};

	var $acdHead = $('.acdHead'),
			$acdBody = $('.acdBody');

	$acdHead.delegate('a', 'click', function(e) {
		e.preventDefault();
		HPG.toggleCondition(this);
	});
});


