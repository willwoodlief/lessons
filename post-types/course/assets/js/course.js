(function($) {
    'use strict';

    var course = {};
    eltdf.modules.course = course;

	course.eltdfOnDocumentReady = eltdfOnDocumentReady;
	course.eltdfOnWindowLoad = eltdfOnWindowLoad;
	course.eltdfOnWindowResize = eltdfOnWindowResize;
	course.eltdfOnWindowScroll = eltdfOnWindowScroll;

    $(document).ready(eltdfOnDocumentReady);
    $(window).load(eltdfOnWindowLoad);
    $(window).resize(eltdfOnWindowResize);
    $(window).scroll(eltdfOnWindowScroll);
    
    /* 
     All functions to be called on $(document).ready() should be in this function
     */
    function eltdfOnDocumentReady() {
	    eltdfInitCoursePopup();
	    eltdfInitCoursePopupClose();
	    eltdfCompleteItem();
	    eltdfCourseAddToWishlist();
	    eltdfRetakeCourse();
	    eltdfSearchCourses();
	    eltdfInitCourseList();
	    eltdfInitAdvancedCourseSearch();
    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function eltdfOnWindowLoad() {
        eltdfInitCourseListAnimation();
        eltdfInitCoursePagination().init();
    }

    /*
     All functions to be called on $(window).resize() should be in this function
     */
    function eltdfOnWindowResize() {

    }

    /*
     All functions to be called on $(window).scroll() should be in this function
     */
    function eltdfOnWindowScroll() {
        eltdfInitCoursePagination().scroll();
    }


    function eltdfInitCoursePopup(){
	    var elements = $('.eltdf-element-link-open');
	    var popup = $('.eltdf-course-popup');
	    var popupContent = $('.eltdf-popup-content');

        if(elements.length){
	        elements.each(function(){
				var element = $(this);
		        element.on('click', function(e){
			        e.preventDefault();
			        if(!popup.hasClass('eltdf-course-popup-opened')){
				        popup.addClass('eltdf-course-popup-opened');
				        eltdf.modules.common.eltdfDisableScroll();
			        }
			        var courseId = 0;
			        if(typeof element.data('course-id') !== 'undefined' && element.data('course-id') !== false) {
				        courseId = element.data('course-id');
			        }
                    eltdfPopupScroll();
			        eltdfLoadElementItem(element.data('item-id'),courseId, popupContent);
		        });
	        });
        }
    }
	function eltdfInitCourseItemsNavigation(){
		var elements = $('.eltdf-course-popup-navigation .eltdf-element-link-open');
		var popupContent = $('.eltdf-popup-content');

		if(elements.length){
			elements.each(function(){
				var element = $(this);
				element.on('click', function(e){
					e.preventDefault();
					var courseId = 0;
					if(typeof element.data('course-id') !== 'undefined' && element.data('course-id') !== false) {
						courseId = element.data('course-id');
					}
					eltdfLoadElementItem(element.data('item-id'),courseId, popupContent);
				});
			});
		}
	}

	function eltdfInitCoursePopupClose(){
		var closeButton = $('.eltdf-course-popup-close');
		var popup = $('.eltdf-course-popup');
		if(closeButton.length){
			closeButton.on('click', function(e){
				e.preventDefault();
				popup.removeClass('eltdf-course-popup-opened');
				location.reload();
			});
		}
	}

	function eltdfLoadElementItem(id ,courseId, container){
        var preloader = container.prevAll('.eltdf-course-item-preloader');
        preloader.removeClass('eltdf-hide');
		var ajaxData = {
			action: 'eltdf_lms_load_element_item',
			item_id : id,
			course_id : courseId
		};
		$.ajax({
			type: 'POST',
			data: ajaxData,
			url: eltdfGlobalVars.vars.eltdfAjaxUrl,
			success: function (data) {
				var response = JSON.parse(data);
				if(response.status == 'success'){
					container.html(response.data.html);
					eltdfInitCourseItemsNavigation();
					eltdfCompleteItem();
					eltdfSearchCourses();
                    eltdf.modules.quiz.eltdfStartQuiz();
                    preloader.addClass('eltdf-hide');
				} else {
                    alert("An error occurred");
                    preloader.addClass('eltdf-hide');
                }

			}
		});

	}

	function eltdfCompleteItem(){

		$('.eltdf-lms-complete-item-form').on('submit',function(e) {

			e.preventDefault();
			var form = $(this);
			var itemID = $(this).find( "input[name$='eltdf_lms_item_id']").val();
			var formData = form.serialize();
			var ajaxData = {
				action: 'eltdf_lms_complete_item',
				post: formData
			};

			$.ajax({
				type: 'POST',
				data: ajaxData,
				url: eltdfGlobalVars.vars.eltdfAjaxUrl,
				success: function (data) {
					var response = JSON.parse(data);
					if(response.status == 'success'){

						form.replaceWith(response.data['content_message']);
						var elements =  $('.eltdf-section-element.eltdf-section-lesson');
						elements.each(function () {
							if($(this).data('section-element-id') == itemID){
								$(this).addClass('eltdf-item-completed')
							}
						})
					}
				}
			});
		});

	}

	function eltdfRetakeCourse(){

		$('.eltdf-lms-retake-course-form').on('submit',function(e) {

			e.preventDefault();
			var form = $(this);
			var formData = form.serialize();
			var ajaxData = {
				action: 'eltdf_lms_retake_course',
				post: formData
			};

			$.ajax({
				type: 'POST',
				data: ajaxData,
				url: eltdfGlobalVars.vars.eltdfAjaxUrl,
				success: function (data) {
					var response = JSON.parse(data);
					if(response.status == 'success'){
						alert(response.message);
                        location.reload();
					}
				}
			});
		});

	}

	function eltdfPopupScroll(){

        var mainHolder = $('.eltdf-course-popup');

        /* Content items */
        var content = $('.eltdf-popup-content');
        var contentHolder = $('.eltdf-course-popup-inner');
        var contentHeading = $('.eltdf-popup-heading');

        /* Navigation items */
        var navigationHolder = $('.eltdf-course-popup-items');
        var navigationWrapper = $('.eltdf-popup-info-wrapper');
        var searchHolder = $('.eltdf-lms-search-holder');

        if(eltdf.windowWidth > 1024) {
            if (content.length) {
                content.height(mainHolder.height() - contentHeading.outerHeight());
                content.niceScroll({
                    scrollspeed: 60,
                    mousescrollstep: 40,
                    cursorwidth: 0,
                    cursorborder: 0,
                    cursorborderradius: 0,
                    cursorcolor: 'transparent',
                    autohidemode: false,
                    horizrailenabled: false
                });
            }

            if (navigationHolder.length) {
                navigationHolder.height(mainHolder.height() - parseInt(navigationWrapper.css('padding-top')) - parseInt(navigationWrapper.css('padding-bottom')) - searchHolder.outerHeight(true));
                navigationHolder.niceScroll({
                    scrollspeed: 60,
                    mousescrollstep: 40,
                    cursorwidth: 0,
                    cursorborder: 0,
                    cursorborderradius: 0,
                    cursorcolor: 'transparent',
                    autohidemode: false,
                    horizrailenabled: false
                });
            }
        } else {
            contentHolder.find('.eltdf-grid-row').height(mainHolder.height());
            contentHolder.find('.eltdf-grid-row').niceScroll({
                scrollspeed: 60,
                mousescrollstep: 40,
                cursorwidth: 0,
                cursorborder: 0,
                cursorborderradius: 0,
                cursorcolor: 'transparent',
                autohidemode: false,
                horizrailenabled: false
            });
        }

		return true

	}

	function eltdfCourseAddToWishlist(){

		$('.eltdf-course-whishlist').on('click',function(e) {
			e.preventDefault();
			var course = $(this),
				courseId;

			if(typeof course.data('course-id') !== 'undefined') {
				courseId = course.data('course-id');
			}

            eltdfCourseWhishlistAdding(course, courseId);

		});

	}

	function eltdfCourseWhishlistAdding(course, courseId){

		var ajaxData = {
			action: 'eltdf_lms_add_course_to_wishlist',
			course_id : courseId
		};

		$.ajax({
			type: 'POST',
			data: ajaxData,
			url: eltdfGlobalVars.vars.eltdfAjaxUrl,
			success: function (data) {
				var response = JSON.parse(data);
				if(response.status == 'success'){
                    if(!course.hasClass('eltdf-icon-only')) {
                        course.find('span').text(response.data.message);
                    }
                    course.find('i').removeClass('fa-heart fa-heart-o').addClass(response.data.icon);
				}
			}
		});

		return false;

	}

	function eltdfSearchCourses(){

	    var courseSearchHolder = $('.eltdf-lms-search-holder');

        if (courseSearchHolder.length) {
            courseSearchHolder.each(function () {
                var thisSearch = $(this),
                    searchField = thisSearch.find('.eltdf-lms-search-field'),
                    resultsHolder = thisSearch.find('.eltdf-lms-search-results'),
                    searchLoading = thisSearch.find('.eltdf-search-loading'),
                    searchIcon = thisSearch.find('.eltdf-search-icon');

                searchLoading.addClass('eltdf-hidden');

                var keyPressTimeout;

                searchField.on('keyup paste', function(e) {
                    var field = $(this);
                    field.attr('autocomplete','off');
                    searchLoading.removeClass('eltdf-hidden');
                    searchIcon.addClass('eltdf-hidden');
                    clearTimeout(keyPressTimeout);

                    keyPressTimeout = setTimeout( function() {
                        var searchTerm = field.val();
                        if(searchTerm.length < 3) {
                            resultsHolder.html('');
                            resultsHolder.fadeOut();
                            searchLoading.addClass('eltdf-hidden');
                            searchIcon.removeClass('eltdf-hidden');
                        } else {
                            var ajaxData = {
                                action: 'eltdf_lms_search_courses',
                                term: searchTerm
                            };

                            $.ajax({
                                type: 'POST',
                                data: ajaxData,
                                url: eltdfGlobalVars.vars.eltdfAjaxUrl,
                                success: function (data) {
                                    var response = JSON.parse(data);
                                    if (response.status == 'success') {
                                        searchLoading.addClass('eltdf-hidden');
                                        searchIcon.removeClass('eltdf-hidden');
                                        resultsHolder.html(response.data.html);
                                        resultsHolder.fadeIn();
                                    }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    console.log("Status: " + textStatus);
                                    console.log("Error: " + errorThrown);
                                    searchLoading.addClass('eltdf-hidden');
                                    searchIcon.removeClass('eltdf-hidden');
                                    resultsHolder.fadeOut();
                                }
                            });
                        }
                    }, 500);
                });

                searchField.on('focusout', function () {
                    searchLoading.addClass('eltdf-hidden');
                    searchIcon.removeClass('eltdf-hidden');
                    resultsHolder.fadeOut();
                });
            });
        }

	}

    /**
     * Initializes course pagination functions
     */
    function eltdfInitCoursePagination(){
        var courseList = $('.eltdf-course-list-holder');

        var initStandardPagination = function(thisCourseList) {
            var standardLink = thisCourseList.find('.eltdf-cl-standard-pagination li');

            if(standardLink.length) {
                standardLink.each(function(){
                    var thisLink = $(this).children('a'),
                        pagedLink = 1;

                    thisLink.on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (typeof thisLink.data('paged') !== 'undefined' && thisLink.data('paged') !== false) {
                            pagedLink = thisLink.data('paged');
                        }

                        initMainPagFunctionality(thisCourseList, pagedLink);
                    });
                });
            }
        };

        var initLoadMorePagination = function(thisCourseList) {
            var loadMoreButton = thisCourseList.find('.eltdf-cl-load-more a');

            loadMoreButton.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                initMainPagFunctionality(thisCourseList);
            });
        };

        var initInifiteScrollPagination = function(thisCourseList) {
            var courseListHeight = thisCourseList.outerHeight(),
                courseListTopOffest = thisCourseList.offset().top,
                courseListPosition = courseListHeight + courseListTopOffest - eltdfGlobalVars.vars.eltdfAddForAdminBar;

            if(!thisCourseList.hasClass('eltdf-cl-infinite-scroll-started') && eltdf.scroll + eltdf.windowHeight > courseListPosition) {
                initMainPagFunctionality(thisCourseList);
            }
        };

        var initMainPagFunctionality = function(thisCourseList, pagedLink) {
            var thisCourseListInner = thisCourseList.find('.eltdf-cl-inner'),
                nextPage,
                maxNumPages;

            if (typeof thisCourseList.data('max-num-pages') !== 'undefined' && thisCourseList.data('max-num-pages') !== false) {
                maxNumPages = thisCourseList.data('max-num-pages');
            }

            if(thisCourseList.hasClass('eltdf-cl-pag-standard')) {
                thisCourseList.data('next-page', pagedLink);
            }

            if(thisCourseList.hasClass('eltdf-cl-pag-infinite-scroll')) {
                thisCourseList.addClass('eltdf-cl-infinite-scroll-started');
            }

            var loadMoreData = eltdf.modules.common.getLoadMoreData(thisCourseList),
                loadingItem = thisCourseList.find('.eltdf-cl-loading');

            nextPage = loadMoreData.nextPage;

            if(nextPage <= maxNumPages || maxNumPages == 0){
                if(thisCourseList.hasClass('eltdf-cl-pag-standard')) {
                    loadingItem.addClass('eltdf-showing eltdf-standard-pag-trigger');
                    thisCourseList.addClass('eltdf-cl-pag-standard-animate');
                } else {
                    loadingItem.addClass('eltdf-showing');
                }

                var ajaxData = eltdf.modules.common.setLoadMoreAjaxData(loadMoreData, 'eltdf_lms_course_ajax_load_more');

                $.ajax({
                    type: 'POST',
                    data: ajaxData,
                    url: eltdfGlobalVars.vars.eltdfAjaxUrl,
                    success: function (data) {
                        if(!thisCourseList.hasClass('eltdf-cl-pag-standard')) {
                            nextPage++;
                        }

                        thisCourseList.data('next-page', nextPage);

                        var response = $.parseJSON(data),
                            responseHtml =  response.html,
                            minValue = response.minValue,
                            maxValue = response.maxValue;

                        if(thisCourseList.hasClass('eltdf-cl-pag-standard') || pagedLink == 1) {
                            eltdfInitStandardPaginationLinkChanges(thisCourseList, maxNumPages, nextPage);
                            eltdfInitHtmlGalleryNewContent(thisCourseList, thisCourseListInner, loadingItem, responseHtml);
                            eltdfInitPostsCounterChanges(thisCourseList, minValue, maxValue);
                        } else {
                            eltdfInitAppendGalleryNewContent(thisCourseListInner, loadingItem, responseHtml);
                            eltdfInitPostsCounterChanges(thisCourseList, 1, maxValue);
                        }

                        if(thisCourseList.hasClass('eltdf-cl-infinite-scroll-started')) {
                            thisCourseList.removeClass('eltdf-cl-infinite-scroll-started');
                        }
                    }
                });
            }

            if(pagedLink == 1) {
                thisCourseList.find('.eltdf-cl-load-more-holder').show();
            }

            if(nextPage === maxNumPages){
                thisCourseList.find('.eltdf-cl-load-more-holder').hide();
            }
        };

        var eltdfInitStandardPaginationLinkChanges = function(thisCourseList, maxNumPages, nextPage) {
            var standardPagHolder = thisCourseList.find('.eltdf-cl-standard-pagination'),
                standardPagNumericItem = standardPagHolder.find('li.eltdf-cl-pag-number'),
                standardPagPrevItem = standardPagHolder.find('li.eltdf-cl-pag-prev a'),
                standardPagNextItem = standardPagHolder.find('li.eltdf-cl-pag-next a');

            standardPagNumericItem.removeClass('eltdf-cl-pag-active');
            standardPagNumericItem.eq(nextPage-1).addClass('eltdf-cl-pag-active');

            standardPagPrevItem.data('paged', nextPage-1);
            standardPagNextItem.data('paged', nextPage+1);

            if(nextPage > 1) {
                standardPagPrevItem.css({'opacity': '1'});
            } else {
                standardPagPrevItem.css({'opacity': '0'});
            }

            if(nextPage === maxNumPages) {
                standardPagNextItem.css({'opacity': '0'});
            } else {
                standardPagNextItem.css({'opacity': '1'});
            }
        };

        var eltdfInitPostsCounterChanges = function(thisCourseList, minValue, maxValue) {
            var postsCounterHolder = thisCourseList.find('.eltdf-course-items-counter');
            var minValueHolder = postsCounterHolder.find('.counter-min-value');
            var maxValueHolder = postsCounterHolder.find('.counter-max-value');
            minValueHolder.text(minValue);
            maxValueHolder.text(maxValue);
        };

        var eltdfInitHtmlGalleryNewContent = function(thisCourseList, thisCourseListInner, loadingItem, responseHtml) {
            loadingItem.removeClass('eltdf-showing eltdf-standard-pag-trigger');
            thisCourseListInner.waitForImages(function() {
                thisCourseList.removeClass('eltdf-cl-pag-standard-animate');
                thisCourseListInner.html(responseHtml);
                eltdfInitCourseListAnimation();
                eltdf.modules.common.eltdfInitParallax();
            });
        };

        var eltdfInitAppendGalleryNewContent = function(thisCourseListInner, loadingItem, responseHtml) {
            loadingItem.removeClass('eltdf-showing');
            thisCourseListInner.waitForImages(function() {
                thisCourseListInner.append(responseHtml);
                eltdfInitCourseListAnimation();
                eltdf.modules.common.eltdfInitParallax();
            });
        };

        return {
            init: function() {
                if(courseList.length) {
                    courseList.each(function() {
                        var thisCourseList = $(this);

                        if(thisCourseList.hasClass('eltdf-cl-pag-standard')) {
                            initStandardPagination(thisCourseList);
                        }

                        if(thisCourseList.hasClass('eltdf-cl-pag-load-more')) {
                            initLoadMorePagination(thisCourseList);
                        }

                        if(thisCourseList.hasClass('eltdf-cl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisCourseList);
                        }
                    });
                }
            },
            scroll: function() {
                if(courseList.length) {
                    courseList.each(function() {
                        var thisCourseList = $(this);

                        if(thisCourseList.hasClass('eltdf-cl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisCourseList);
                        }
                    });
                }
            },
            getMainPagFunction: function(thisCourseList, paged) {
                initMainPagFunctionality(thisCourseList, paged);
            }
        };
    }

    /**
     * Initializes portfolio list article animation
     */
    function eltdfInitCourseListAnimation(){
        var courseList = $('.eltdf-course-list-holder.eltdf-cl-has-animation');

        if(courseList.length){
            courseList.each(function(){
                var thisCourseList = $(this).children('.eltdf-cl-inner');

                thisCourseList.children('article').each(function(l) {
                    var thisArticle = $(this);

                    thisArticle.appear(function() {
                        thisArticle.addClass('eltdf-item-show');

                        setTimeout(function(){
                            thisArticle.addClass('eltdf-item-shown');
                        }, 1000);
                    },{accX: 0, accY: 0});
                });
            });
        }
    }

    function eltdfInitCourseList() {
        var courseLists = $('.eltdf-course-list-holder');
        if (courseLists.length) {
            courseLists.each(function () {
                var thisList = $(this);
                if (thisList.hasClass('eltdf-cl-has-filter')) {
                    eltdfInitCourseLayoutChange(thisList);
                    eltdfInitCourseLayoutOrdering(thisList);
                }
            })
        }
    }

    function eltdfInitCourseLayoutOrdering(thisList) {
        var filter = thisList.find('.eltdf-cl-filter-holder .eltdf-course-order-filter');
        filter.select2({
            minimumResultsForSearch: -1
        }).on('select2:select', function (evt) {
            var dataAtts = evt.params.data.element.dataset;
            var type = dataAtts.type;
            var order = dataAtts.order;
            thisList.data('order-by', type);
            thisList.data('order', order);
            thisList.data('next-page', 1);
            eltdfInitCoursePagination().getMainPagFunction(thisList, 1);
        });
    }

    function eltdfInitCourseLayoutChange(thisList) {
        var filter = thisList.find('.eltdf-cl-filter-holder .eltdf-course-layout-filter');
        var filterElements = filter.find('span');
        if (filter.length > 0) {
            filterElements.click(function() {
                filterElements.removeClass('eltdf-active');
                var thisFilter = $(this);
                thisFilter.addClass('eltdf-active');
                var type = thisFilter.data('type');
                thisList.removeClass('eltdf-cl-gallery eltdf-cl-simple');
                thisList.addClass('eltdf-cl-' + type);
            });
        }
    }

    function eltdfInitAdvancedCourseSearch() {
        var advancedCoursSearches = $('.eltdf-advanced-course-search');
        if (advancedCoursSearches.length) {
            advancedCoursSearches.each(function () {
                var thisSearch = $(this);
                var select = thisSearch.find('select');
                if(select.length) {
                    select.select2({
                        minimumResultsForSearch: -1
                    });
                }
            })
        }
    }

})(jQuery);