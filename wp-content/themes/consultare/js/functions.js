/* global consultareScreenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */
(function($) {
    // Show the first tab and hide the rest
    $('#tabs-nav li:first-child').addClass('active');
    $('.tab-content').hide();
    $('.tab-content:first').show();

    // Click function
    $('#tabs-nav li').on('click', function() {
        $('#tabs-nav li').removeClass('active');
        $(this).addClass('active');
        $('.tab-content').hide();

        var activeTab = $(this).find('a').attr('href');
        $(activeTab).fadeIn();
        return false;
    });

    // map-toggle
    $("#map-toggle").on('click', function() {
        $(".gmap_canvas_inner").toggle();
    });

    // Add header video class after the video is loaded.
    $(document).on('wp-custom-header-video-loaded', function() {
        $('body').addClass('has-header-video');
    });

    /**
     * Functionality for scroll to top button
     */
    $(function() {
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 100) {
                $('#scrollup').fadeIn('slow');
                $('#scrollup').show();
            } else {
                $('#scrollup').fadeOut('slow');
                $("#scrollup").hide();
            }
        });

        $('#scrollup').on('click', function() {
            $('body, html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
    });

    // Fixed header.
    $(window).on('scroll', function() {
        if ($('.sticky-enabled').length && $(window).scrollTop() > $('.sticky-enabled').offset().top && !($('.sticky-enabled').hasClass('sticky-header'))) {
            $('.sticky-enabled').addClass('sticky-header');
        } else if (0 === $(window).scrollTop()) {
            $('.sticky-enabled').removeClass('sticky-header');
        }
    });

    var body, masthead, menuToggle, siteNavigation, searchNavigation, siteHeaderMenu, resizeTimer;

    function initMainNavigation(container) {
        // Add dropdown toggle that displays child menu items.
        var dropdownToggle = $('<button />', {
                'class': 'dropdown-toggle',
                'aria-expanded': false
            })
            .append(consultareScreenReaderText.icon)
            .append($('<span />', {
                'class': 'screen-reader-text',
                text: consultareScreenReaderText.expand
            }));

        container.find('.menu-item-has-children > a, .page_item_has_children > a').after(dropdownToggle);

        // Set the active submenu dropdown toggle button initial state.
        container.find('.current-menu-ancestor > button')
            .addClass('toggled-on')
            .attr('aria-expanded', 'true')
            .find('.screen-reader-text')
            .text(consultareScreenReaderText.collapse);
        // Set the active submenu initial state.
        container.find('.current-menu-ancestor > .sub-menu').addClass('toggled-on');

        // Add menu items with submenus to aria-haspopup="true".
        container.find('.menu-item-has-children').attr('aria-haspopup', 'true');

        container.find('.dropdown-toggle').on('click', function(e) {
            var _this = $(this),
                screenReaderSpan = _this.find('.screen-reader-text');

            e.preventDefault();
            _this.toggleClass('toggled-on');
            _this.next('.children, .sub-menu').toggleClass('toggled-on');

            // jscs:disable
            _this.attr('aria-expanded', _this.attr('aria-expanded') === 'false' ? 'true' : 'false');
            // jscs:enable
            screenReaderSpan.text(screenReaderSpan.text() === consultareScreenReaderText.expand ? consultareScreenReaderText.collapse : consultareScreenReaderText.expand);
        });
    }

    menuToggle = $('#primary-menu-toggle-mobile');
    siteHeaderMenu = $('#site-header-menu-mobile');
    siteNavigation = $('#site-primary-navigation-mobile');
    initMainNavigation(siteNavigation);

    // Enable menuToggle.
    (function() {

        // Return early if menuToggle is missing.
        if (!menuToggle.length) {
            return;
        }

        // Add an initial values for the attribute.
        menuToggle.add(siteNavigation).attr('aria-expanded', 'false');

        menuToggle.on('click.consultare', function() {
            $(this).add(siteHeaderMenu).toggleClass('toggled-on');

            // jscs:disable
            $(this).add(siteNavigation).attr('aria-expanded', $(this).add(siteNavigation).attr('aria-expanded') === 'false' ? 'true' : 'false');
            // jscs:enable
        });
    })();

    // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
    (function() {
        if (!siteNavigation.length || !siteNavigation.children().length) {
            return;
        }

        // Toggle `focus` class to allow submenu access on tablets.
        function toggleFocusClassTouchScreen() {
            if (window.innerWidth >= 910) {
                $(document.body).on('touchstart.consultare', function(e) {
                    if (!$(e.target).closest('.main-navigation li').length) {
                        $('.main-navigation li').removeClass('focus');
                    }
                });
                siteNavigation.find('.menu-item-has-children > a, .page_item_has_children > a').on('touchstart.consultare', function(e) {
                    var el = $(this).parent('li');

                    if (!el.hasClass('focus')) {
                        e.preventDefault();
                        el.toggleClass('focus');
                        el.siblings('.focus').removeClass('focus');
                    }
                });
            } else {
                siteNavigation.find('.menu-item-has-children > a').off('touchstart.consultare');
            }
        }

        if ('ontouchstart' in window) {
            $(window).on('resize.consultare', toggleFocusClassTouchScreen);
            toggleFocusClassTouchScreen();
        }

        siteNavigation.find('a').on('focus.consultare blur.consultare', function() {
            $(this).parents('.menu-item, .page_item').toggleClass('focus');
        });
    })();

    menuToggleMobile = $('#primary-menu-toggle');
    siteHeaderMenuMobile = $('#site-header-menu');
    siteNavigationMobile = $('#site-primary-navigation');
    initMainNavigation(siteNavigationMobile);

    // Enable menuToggleMobile.
    (function() {

        // Return early if menuToggleMobile is missing.
        if (!menuToggleMobile.length) {
            return;
        }

        // Add an initial values for the attribute.
        menuToggleMobile.add(siteNavigationMobile).attr('aria-expanded', 'false');

        menuToggleMobile.on('click.consultare', function() {
            $(this).add(siteHeaderMenuMobile).toggleClass('toggled-on');

            // jscs:disable
            $(this).add(siteNavigationMobile).attr('aria-expanded', $(this).add(siteNavigationMobile).attr('aria-expanded') === 'false' ? 'true' : 'false');
            // jscs:enable
        });
    })();

    // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
    (function() {
        if (!siteNavigationMobile.length || !siteNavigationMobile.children().length) {
            return;
        }

        // Toggle `focus` class to allow submenu access on tablets.
        function toggleFocusClassTouchScreen() {
            if (window.innerWidth >= 910) {
                $(document.body).on('touchstart.consultare', function(e) {
                    if (!$(e.target).closest('.main-navigation li').length) {
                        $('.main-navigation li').removeClass('focus');
                    }
                });
                siteNavigationMobile.find('.menu-item-has-children > a, .page_item_has_children > a').on('touchstart.consultare', function(e) {
                    var el = $(this).parent('li');

                    if (!el.hasClass('focus')) {
                        e.preventDefault();
                        el.toggleClass('focus');
                        el.siblings('.focus').removeClass('focus');
                    }
                });
            } else {
                siteNavigationMobile.find('.menu-item-has-children > a').off('touchstart.consultare');
            }
        }

        if ('ontouchstart' in window) {
            $(window).on('resize.consultare', toggleFocusClassTouchScreen);
            toggleFocusClassTouchScreen();
        }

        siteNavigationMobile.find('a').on('focus.consultare blur.consultare', function() {
            $(this).parents('.menu-item, .page_item').toggleClass('focus');
        });
    })();

    //Search Toggle
    var jQueryheader_search = $('.search-toggle');
    jQueryheader_search.on('click', function() {

        $(this).toggleClass('toggled-on');

        var jQuerythis_el_search = $(this),
            jQueryform_search = jQuerythis_el_search.siblings('.search-container');

        if (jQueryform_search.hasClass('displaynone')) {
            jQueryform_search.removeClass('displaynone').addClass('displayblock').animate({
                opacity: 1
            }, 300);
        } else {
            jQueryform_search.removeClass('displayblock').addClass('displaynone').animate({
                opacity: 0
            }, 300);
        }

        return false;
    });

    $('.skillbar').each(function() {
        $(this).find('.skillbar-bar').animate({
            width: $(this).attr('data-percent')
        }, 6000);
    });

    $('.header-top-toggle').on('click', function() {
        $('#site-top-header-mobile-container').toggle("fast");
    });

    $(".section:odd").addClass("odd-section");
    $(".section:even").addClass("even-section");
    $(".event-post:odd").addClass("odd-item");
    $(".event-post:even").addClass("even-item");

    $(document).ready(function() {
        $(window).on('load.consultare resize.consultare', function() {
            if ( window.innerWidth < 910 ) {
                if ( $('#site-primary-navigation-mobile').length ) {
                    var main_nav_mobile_focusable = $('#site-primary-navigation-mobile').find('button, a, input, select, textarea, [tabindex]:not([tabindex="-1"])');

                    $( main_nav_mobile_focusable[main_nav_mobile_focusable.length - 1] ).on('focusout', function() {
                        $('#primary-menu-toggle-mobile').trigger('click');
                    });
                }

                if ( $('#site-top-header-mobile-container').length ) {
                    var top_bar_focusable = $('#site-top-header-mobile-container').find('button, a, input, select, textarea, [tabindex]:not([tabindex="-1"])');

                    $( top_bar_focusable[top_bar_focusable.length - 1] ).on('focusout', function() {
                         $('#header-top-toggle').trigger('click');
                    });
                }
            }

            $('.search-container .search-submit').on('focusout', function() {
                var $elem = $(this);

                $elem.parents().siblings('.search-toggle').trigger('click');
            });
        });
    });
})(jQuery);
