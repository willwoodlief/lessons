(function ($) {
	'use strict';
	
	var course = {};
	eltdf.modules.course = course;
	
	course.eltdfOnDocumentReady = eltdfOnDocumentReady;
	
	$(document).ready(eltdfOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function eltdfOnDocumentReady() {
		eltdfInitCommentRating();
	}
	
	function eltdfInitCommentRating() {
		var ratingInput = $('#eltdf-rating'),
			ratingValue = ratingInput.val(),
			stars = $('.eltdf-star-rating');
		
		var addActive = function () {
			for (var i = 0; i < stars.length; i++) {
				var star = stars[i];
				if (i < ratingValue) {
					$(star).addClass('active');
				} else {
					$(star).removeClass('active');
				}
			}
		};
		
		addActive();
		
		stars.click(function () {
			ratingInput.val($(this).data('value')).trigger('change');
		});
		
		ratingInput.change(function () {
			ratingValue = ratingInput.val();
			addActive();
		});
	}
	
})(jQuery);