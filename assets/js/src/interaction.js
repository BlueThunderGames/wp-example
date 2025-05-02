jQuery(document).ready(function()
{
    statCarousels();
    multipurposeCarousels();
    scrollPanels();
    bubbleAnims();
    scrollingVideo();
    blogCarousel();
    navAccessibility();
    navCarousel();
    teamModals();
    //videoModals();
    stickyNav();
    mobileNav();
    announcementBanner();
    pageIntro();
    twoColChartAnim();
    threeColChartAnim();
    searchForm();
    showJoinFrame();
    alphabetCarousel();
    fundInteractions();
    fundModal();
    pdfSearch();
    linkSmoothScroll();
    vanityFormScroll();
    resourcesInteraction();
    shareModal();
    initAOS();
    fancyBoxInit();
});
function statCarousels() {
    if (jQuery('.stat-slider-container').length) {
        jQuery('.stat-slide-wrapper').each(function() {
            const $this = jQuery(this);
            const swiper = new Swiper($this[0], {
                loop: false,
                slidesPerView: 1,
                spaceBetween: 0, // Set spaceBetween to 0 to ensure slides take up full width
                pagination: {
                    el: $this.find('.swiper-pagination')[0],
                    clickable: true,
                },
                allowTouchMove: true, // Enable touch drag
                simulateTouch: true, // Enable mouse drag
            });

            const numberOfItems = swiper.slides.length;
            var smallerItems = numberOfItems * .9;
            let currentSlide = 1;

            if (jQuery(window).width() > 1024) {
                // Set the height of the great-grandparent container
                const mainSectionHeight = 100 * smallerItems + 'vh';
                $this.closest('.stat-slider-container').css('height', mainSectionHeight);

                // Initialize GSAP ScrollTrigger
                gsap.registerPlugin(ScrollTrigger);

                const statSlideOuter = $this.closest('.stat-slide-outer');

                if (statSlideOuter.length) {
                    const scrollTrigger = ScrollTrigger.create({
                        id: 'statScrollTrigger',
                        trigger: $this[0], // Ensure this targets the correct element
                        start: "center center", // Trigger when the top of the viewport reaches the top of the carousel
                        end: () => "+=" + jQuery(window).height() * (numberOfItems - 1), // End when the final slide is reached
                        pin: statSlideOuter[0], // Pin the stat-slide-outer element
                        pinSpacing: false,
                        scrub: true,
                        onUpdate: (self) => {
                            const progress = self.progress;
                            const newSlide = Math.min(Math.floor(progress * numberOfItems), numberOfItems - 1);

                            $this.parent().find('.progress-bar').css('width', (newSlide / (numberOfItems - 1)) * 100 + '%');

                            if (newSlide !== currentSlide) {
                                currentSlide = newSlide;
                                swiper.slideTo(currentSlide, 300);
                            }
                        }
                    });

                    swiper.on('slideChange', function() {
                        var currentDot = swiper.activeIndex;

                        if(currentDot + 1 == numberOfItems)
                        {
                            $this.parent().find('.progress-bar').css('width', '100%');
                        }
                        

                        $this.find('.swiper-pagination-bullet').each(function(index)
                        {
                            if(index < currentDot)
                            {
                                jQuery(this).addClass('passed');
                            }
                            else 
                            {
                                jQuery(this).removeClass('passed');
                            }
                        });

                        const swiperProgress = swiper.activeIndex / (numberOfItems - 1);

                        $this.parent().find('.progress-bar').css('width', swiperProgress * 100 + '%');
                    });

                    swiper.on('slideChangeTransitionEnd', function() {
                        const newProgress = swiper.activeIndex / (numberOfItems - 1);
                        var scrollPosition = newProgress * (scrollTrigger.end - scrollTrigger.start) + scrollTrigger.start;
                        var currentScrollPosition = scrollTrigger.scroll();

                        if(scrollPosition != currentScrollPosition)
                        {
                            scrollTrigger.scroll(scrollPosition);
                        }
                    });

                } 
            }
            else 
            {
                swiper.on('slideChange', function() {
                    var currentDot = swiper.activeIndex;

                    if(currentDot + 1 == numberOfItems)
                    {
                        $this.parent().find('.progress-bar').css('width', '100%');
                    }
                    

                    $this.find('.swiper-pagination-bullet').each(function(index)
                    {
                        if(index < currentDot)
                        {
                            jQuery(this).addClass('passed');
                        }
                        else 
                        {
                            jQuery(this).removeClass('passed');
                        }
                    });

                    const swiperProgress = swiper.activeIndex / (numberOfItems - 1);

                    $this.parent().find('.progress-bar').css('width', swiperProgress * 100 + '%');
                });
            }
        });
    }
}
function multipurposeCarousels() {
    if (jQuery('.testimonial-slider').length) {
        jQuery('.testimonial-slider').each(function() {
            const $this = jQuery(this);
            const swiper = new Swiper($this.find('.slider-wrapper')[0], {
                loop: false,
                slidesPerView: 1,
                spaceBetween: 0, // Set spaceBetween to 0 to ensure slides take up full width
                pagination: {
                    el: $this.find('.swiper-pagination')[0],
                    clickable: true,
                },
                allowTouchMove: true, // Enable touch drag
                simulateTouch: true, // Enable mouse drag
            });

            const numberOfItems = swiper.slides.length;
            let currentSlide = 1;

            if (jQuery(window).width() > 1024) {
                // Set the height of the great-grandparent container
                const mainSectionHeight = 100 * numberOfItems + 'vh';
                $this.css('height', mainSectionHeight);

                // Initialize GSAP ScrollTrigger
                gsap.registerPlugin(ScrollTrigger);

                const statSlideOuter = $this.find('.stat-slide-outer');
                const statSlideInner = $this.find('.stat-slide-inner');

                if (statSlideOuter.length) {
                    const scrollTrigger = ScrollTrigger.create({
                        id: 'multiScrollTrigger',
                        trigger: statSlideOuter[0], // Ensure this targets the correct element
                        start: "center center", // Trigger when the top of the viewport reaches the top of the carousel
                        end: () => "+=" + jQuery(window).height() * (numberOfItems - 1), // End when the final slide is reached
                        pin: statSlideInner[0], // Pin the stat-slide-outer element
                        pinSpacing: true, // Ensure pin spacing is enabled
                        scrub: true,
                        onUpdate: (self) => {
                            const progress = self.progress;
                            const newSlide = Math.min(Math.floor(progress * numberOfItems), numberOfItems - 1);

                            $this.find('.progress-bar').css('width', (newSlide / (numberOfItems - 1)) * 100 + '%');

                            if (newSlide !== currentSlide) {
                                currentSlide = newSlide;
                                swiper.slideTo(currentSlide, 300);
                            }
                        }
                    });

                    swiper.on('slideChange', function() {
                        var currentDot = swiper.activeIndex;

                        if(currentDot + 1 == numberOfItems)
                        {
                            $this.find('.progress-bar').css('width', '100%');
                        }
                        

                        $this.find('.swiper-pagination-bullet').each(function(index)
                        {
                            if(index < currentDot)
                            {
                                jQuery(this).addClass('passed');
                            }
                            else 
                            {
                                jQuery(this).removeClass('passed');
                            }
                        });

                        const swiperProgress = swiper.activeIndex / (numberOfItems - 1);

                        $this.find('.progress-bar').css('width', swiperProgress * 100 + '%');
                    });

                    swiper.on('slideChangeTransitionEnd', function() {
                        const newProgress = swiper.activeIndex / (numberOfItems - 1);
                        var scrollPosition = newProgress * (scrollTrigger.end - scrollTrigger.start) + scrollTrigger.start;
                        var currentScrollPosition = scrollTrigger.scroll();

                        if(scrollPosition != currentScrollPosition)
                        {
                            scrollTrigger.scroll(scrollPosition);
                        }
                    });
                }
            } else {
                swiper.on('slideChange', function() {
                    var currentDot = swiper.activeIndex;

                    if (currentDot + 1 == numberOfItems) {
                        $this.find('.progress-bar').css('width', '100%');
                    }

                    $this.find('.swiper-pagination-bullet').each(function(index) {
                        if (index < currentDot) {
                            jQuery(this).addClass('passed');
                        } else {
                            jQuery(this).removeClass('passed');
                        }
                    });

                    const swiperProgress = swiper.activeIndex / (numberOfItems - 1);
                    $this.find('.progress-bar').css('width', swiperProgress * 100 + '%');
                });
            }
        });
    }
}
function scrollPanels()
{
    if(jQuery('.scroll-panels-container').length && jQuery(window).width() > 1024)
    {
        function createScrollTriggers(containerClass, panelClass) {
            let container = jQuery(containerClass);
            let panels = container.find(panelClass);
            let nextSection = container.next(); // Get the next sibling element of the container
            let nextSectionContainer = container.next('section');

            panels.each(function(i, panel) {
                let tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: panel,
                        start: "top-=200 top", // if it's shorter than the viewport, we prefer to pin it at the top
                        end: () => nextSection.length ? nextSection.offset().top - window.innerHeight - 200 : "top top",
                        scrub: 2,
                        pin: true,
                        pinSpacing: false
                    }
                });

                // Apply scale and blur animations only if it's not the last panel
                if (i < panels.length - 1) {
                    tl.to(panel, {
                        scale: 0.6,
                        //filter: "blur(10px)",
                        duration: 1
                    });
                }
            });
        }
        // Call the function with the desired container and panel class names
        createScrollTriggers(".scroll-panels-container", ".scroll-panel");
    }
}
function bubbleAnims()
{
    if(jQuery('.bubble').length)
    {
            var bubbleRadius = 1200;

            if(jQuery(window).width() < 1024)
            {
                bubbleRadius = 2000;
            }
            
            jQuery('.bubble').each(function()
            {
                var currentBubble = this;
                var masker = jQuery(currentBubble).find('#masker');
                var clipPathReveal = jQuery(currentBubble).find('#clipPathReveal');

                var bubbleAnim = gsap.timeline({
                    defaults: {
                        ease: "none"
                    },
                    scrollTrigger: {
                        trigger: currentBubble,
                        start: "bottom+=200 bottom",
                        end: "bottom+=1600 bottom",
                        scrub: 1,
                        onUpdate: self => {
                            const progress = self.progress;

                            // Find the closest section to the .bubble element
                            const parentSection = jQuery(currentBubble).closest("section");

                            if (progress >= 0.10) {
                                // Add the 'bubbled' class if progress is greater than or equal to 0.10
                                parentSection.addClass("bubbled");
                            } else {
                                // Remove the 'bubbled' class if progress is less than 0.10
                                parentSection.removeClass("bubbled");
                            }
                        }
                    }
                });

                bubbleAnim.to(masker, {
                    attr: { r: bubbleRadius },
                    duration: 1, // This duration is relative to the scroll distance due to scrub
                    ease: "none"
                });

                bubbleAnim.to(clipPathReveal, {
                    rotation: -360,
                    svgOrigin: "200 200",
                    duration: 1, // This duration is relative to the scroll distance due to scrub
                    ease: "none"
                });
            });
    }
}
function scrollingVideo()
{
    if(jQuery('#bannerVideo').length)
    {
        const video = document.querySelector("#bannerVideo");
        let src = video.currentSrc || video.src;

        /* Make sure the video is 'activated' on iOS */
        function once(el, event, fn, opts) {
        var onceFn = function (e) {
            el.removeEventListener(event, onceFn);
            fn.apply(this, arguments);
        };
        el.addEventListener(event, onceFn, opts);
        return onceFn;
        }

        once(document.documentElement, "touchstart", function (e) {
        video.play();
        video.pause();
        });

        /* ---------------------------------- */
        /* Scroll Control! */

        gsap.registerPlugin(ScrollTrigger);

        let tl = gsap.timeline({
        defaults: { duration: 1 },
        scrollTrigger: {
            trigger: ".home-banner-container",
            start: "top-=200 top",
            end: "bottom+=450 bottom",
            scrub: true
        }
        });

        once(video, "loadedmetadata", () => {
        tl.fromTo(
            video,
            {
            currentTime: 0
            },
            {
            currentTime: video.duration || 1
            }
        );
        });

        /* When first coded, the Blobbing was important to ensure the browser wasn't dropping previously played segments, but it doesn't seem to be a problem now. Possibly based on memory availability? */
        setTimeout(function () {
        if (window["fetch"]) {
            fetch(src)
            .then((response) => response.blob())
            .then((response) => {
                var blobURL = URL.createObjectURL(response);

                var t = video.currentTime;
                once(document.documentElement, "touchstart", function (e) {
                video.play();
                video.pause();
                });

                video.setAttribute("src", blobURL);
                video.currentTime = t + 0.01;
            });
        }
        }, 1000);
    }
}
function blogCarousel()
{
    if(jQuery('.blog-feed-carousel').length)
    {
        jQuery('.blog-feed-carousel').each(function() {
            const $this = jQuery(this);
            const swiper = new Swiper(this, {
                direction: 'horizontal',
                loop: false,
                slidesPerView: 3,
                spaceBetween: 68,
                navigation: {
                    nextEl: $this.closest('.blog-feed-wrapper').find('.swiper-button-next')[0],
                    prevEl: $this.closest('.blog-feed-wrapper').find('.swiper-button-prev')[0],
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    720: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1025: {
                        slidesPerView: 3,
                        spaceBetween: 68,
                    },
                }
            });
        });
    }
}
function navAccessibility()
{
    jQuery('.keyboard-toggle').click(function(e)
    {
        e.preventDefault();
    });

    jQuery('.keyboard-toggle').on('keydown', function(e)
    {
        
        if(e.which == 13)
        {
            e.preventDefault();

            if(jQuery(this).attr('aria-expanded') == 'false')
            {
                jQuery(this).attr('aria-expanded', 'true');
                jQuery(this).next('.sub-menu').css('opacity', '1');
                jQuery(this).next('.sub-menu').slideDown('fast');
                jQuery(this).next('.sub-menu').addClass('keyboard-active');
            }
            else 
            {
                jQuery(this).attr('aria-expanded', 'false');
                jQuery(this).next('.sub-menu').slideUp('fast');
                jQuery(this).next('.sub-menu').css('opacity', '1');
            }
        }
    })

    jQuery('body').on('keydown', function(e)
    {
        if(e.which == 27)
        {
            jQuery('.keyboard-active').css('opacity', '0');
            jQuery('.keyboard-active').slideUp('fast');
            jQuery('.keyboard-active').prev('.keyboard-toggle').attr('aria-expanded', 'false');
            jQuery('.keyboard-active').removeClass('keyboard-active');
        }
    });
}
function navCarousel()
{
    if(jQuery('.featured-wrapper').length)
    {
        setTimeout(function() 
        {
            jQuery('.header-menu .sub-menu').removeClass('visible');
        }, 100);
        
        const swiper = new Swiper('.lower-header .featured-wrapper', {
            direction: 'horizontal',
            loop: false,
            slidesPerView: 2,
            spaceBetween: 30,
            navigation: {
                nextEl: '.lower-header .swiper-button-next',
                prevEl: '.lower-header .swiper-button-prev',
            },
            breakpoints: {
                0: {
                  slidesPerView: 1,
                  spaceBetween: 32,
                },
                720: {
                  slidesPerView: 2,
                  spaceBetween: 32,
                },
                1025: {
                  slidesPerView: 2,
                  spaceBetween: 32,
                },
            }
        });

        const mobileSwiper = new Swiper('.mobile-menu .featured-wrapper', {
            direction: 'horizontal',
            loop: false,
            slidesPerView: 2,
            spaceBetween: 32,
            navigation: {
                nextEl: '.mobile-menu .swiper-button-next',
                prevEl: '.mobile-menu .swiper-button-prev',
            },
            breakpoints: {
                0: {
                  slidesPerView: 1,
                  spaceBetween: 32,
                },
                720: {
                  slidesPerView: 2,
                  spaceBetween: 32,
                },
                1025: {
                  slidesPerView: 2,
                  spaceBetween: 32,
                },
            }
        });
    }
}

function teamModals()
{
    if(jQuery('.member-item').length)
    {
        /*
        jQuery('.member-item.has-bio').magnificPopup({
            type: 'inline',
            gallery: {
                enabled: true
            }
        });

        jQuery('.mfp-close').click(function(e)
        {
            e.preventDefault();
            jQuery.magnificPopup.close();
        });
        */

        jQuery('.member-item.no-bio').click(function(e)
        {
            e.preventDefault();
        });

        jQuery('.member-item.has-region').click(function(e) 
        {
            e.preventDefault();

            //var region = jQuery(this).attr('href');

            var region;
            var teamName = jQuery.trim(jQuery(this).find('.member-name').text());

            // Find the .map-person element that contains an h6 with text matching teamName and has a data-person-region attribute matching region
            var matchingPerson = '';

            jQuery('.map-person').each(function()
            {
                if(jQuery(this).find('h6').text() == teamName)
                {
                    matchingPerson = jQuery(this);
                }
            });

            if(matchingPerson != '')
            {   
                region = matchingPerson.attr('data-person-region');
            }

            if(region) 
            {
                jQuery('button[data-region="' + region + '"]').trigger('click');

                jQuery('html, body').animate({
                    scrollTop: jQuery('.m-map__wrapper').offset().top - 139
                }, 500);
            }
        });
    }
}
function videoModals()
{
    if(jQuery('.video').length)
    {
        /*
        jQuery('.video').magnificPopup({
            type: 'iframe',
        });
        */
    }
}
function stickyNav()
{
    jQuery(window).scroll(function()
    {
        if(jQuery(window).scrollTop() > 300)
        {
            if(!jQuery('.header-container').hasClass('sticky'))
            {
                jQuery('.header-container').addClass('sticky');
            }
        }
        else
        {
            if(jQuery('.header-container').hasClass('sticky'))
            {
                jQuery('.header-container').removeClass('sticky');
            }
        }
    });
}
function mobileNav()
{
    jQuery('.nav-tab').click(function(e)
    {
        e.preventDefault();

        jQuery('.mobile-nav-container').slideDown();
    });

    jQuery('.mobile-close-btn').click(function(e)
    {
        e.preventDefault();

        jQuery('.mobile-nav-container').slideUp();
    });

    jQuery('.mobile-menu >li.has-children >a').click(function(e)
    {
        e.preventDefault();

        jQuery(this).parent().children('.sub-menu').slideToggle();
    });

    jQuery('.mobile-menu a.back-btn').click(function(e)
    {
        e.preventDefault();

        jQuery(this).closest('.sub-menu').slideUp(); 
    });
}
function announcementBanner()
{
    jQuery('.banner-modal .banner-minify-btn').click(function(e)
    {
        e.preventDefault();

        jQuery('.banner-modal').addClass('slim');
    });

    jQuery('.banner-modal .close-btn').click(function(e)
    {
        e.preventDefault();

        jQuery('.banner-modal').remove();
        jQuery('body').removeClass('announcement-banner');

        setCookie('bannerClosed', 'true');
    });
}
function pageIntro()
{
    if(jQuery('.page-transition-container').length)
    {
        setTimeout(function()
        {
            jQuery('.page-transition-container').fadeOut(500);
        }, 500);
    }
    
}
function twoColChartAnim()
{
    if(jQuery('.two-column-chart-container .charts-wrapper').length)
    {
        var finalChartReached = false;

        jQuery(window).scroll(function()
        {
            var windowBottomPosition = jQuery(window).scrollTop() + jQuery(window).height();

            var elementPosition = jQuery('.two-column-chart-container .charts-wrapper').offset().top;

            if(windowBottomPosition > elementPosition + 200)
            {
                jQuery('.two-column-chart-container .chart-row').each(function(index)
                {
                    jQuery(this).delay(600 * index).queue(function(next)
                    {
                        if(!jQuery(this).hasClass('animated'))
                        {
                            jQuery(this).addClass('animated');
    
                            var currentElement = jQuery(this);
    
                            jQuery(currentElement).find('.left-chart .chart-item').animate({
                                    opacity: 1
                                }, 250, function()
                                {
                                jQuery(currentElement).find('.line').animate({
                                    width: '172px'
                                }, 100, function()
                                {
                                    jQuery(currentElement).find('.right-chart .chart-item').animate({
                                        opacity: 1
                                    }, 250, function()
                                {
                                    jQuery(currentElement).find('.right-chart .chart-item').addClass('faded');
                                    
                                    if(jQuery('.chart-row.animated').length == jQuery('.chart-row').length)
                                    {
                                        jQuery('.charts-wrapper').find('.final-line').animate({
                                            height: '116%'
                                        }, 500);
                                    }
                                });
                                });
                            });
                        }
                    });
                    
                });
            }
        });
    }
}
function threeColChartAnim()
{
    if(jQuery('.three-col-chart-container').length)
    {
        jQuery(window).scroll(function()
        {
            var windowBottomPosition = jQuery(window).scrollTop() + jQuery(window).height();

            jQuery('.three-col-chart-container .chart-row').each(function(index)
            {
                var elementTopPosition = jQuery(this).offset().top + 80;
                var elementBottomPosition = elementTopPosition + jQuery(this).outerHeight();

                if(windowBottomPosition > elementTopPosition && windowBottomPosition <= elementBottomPosition)
                {
                    if(!jQuery(this).hasClass('animated'))
                    {
                        jQuery(this).addClass('animated');
                    }
                }
            });
        });
        
    }
}
function searchForm()
{
    jQuery(".search-icon").click(function(e)
    {
        e.preventDefault();

        jQuery(this).fadeOut('fast', function()
        {
            jQuery(".search-form").animate({width: 'toggle'}, 500, function()
            {
                jQuery('.search-form input[type="text"]').focus();
            });
        });
    });

    jQuery('body').click(function(e)
    {
        if (!jQuery(e.target).closest('.search-form input[type="text"]').length)
        {
            if(!jQuery(e.target).closest('.search-form').length && jQuery('.search-form input[type="text"]').width() > 1)
            {
                jQuery(".search-form").animate({width: 'toggle'}, 500, function()
                {
                    jQuery('.search-icon').fadeIn('fast');
                });
            }
        }
    });
}
function showJoinFrame()
{
    if(jQuery('.ggt-job-listing-embed').length)
    {
        setTimeout(function()
        {
            jQuery('.ggt-job-listing-embed').css('display', 'block');
        }, 2000);
    }
}
function alphabetCarousel()
{
    if(jQuery('.alphabet-carousel').length) 
    {
        var swiper = new Swiper('.alphabet-carousel', {
            loop: false,
            slidesPerView: 5,
            spaceBetween: 10,
            breakpoints: {
                720: {
                    slidesPerView: 13,
                    spaceBetween: 10
                },
                1100: {
                    slidesPerView: 26,
                    spaceBetween: 10
                }
            }
        });

        jQuery('body').on('click', '.letter-link', function(e)
        {
            e.preventDefault();

            if(!jQuery(this).hasClass('no-letter'))
            {
                var letterTarget = jQuery(this).attr('href');
                //letterTarget = letterTarget.replace('#', '');

                var targetElement = jQuery('' + letterTarget);

                if(targetElement.length)
                {
                    jQuery('html, body').animate({
                        scrollTop: targetElement.offset().top - 250
                    }, 500);
                }
            }
        });

        jQuery(window).scroll(function()
        {
            var windowTopPosition = jQuery(window).scrollTop();

            var elementTopPosition = jQuery('.funds-alphabet-outer').offset().top;

            if(windowTopPosition > elementTopPosition)
            {
                if(!jQuery('.funds-alphabet').hasClass('sticky'))
                {
                    jQuery('.funds-alphabet').addClass('sticky');
                }
            }
            else 
            {
                if(jQuery('.funds-alphabet').hasClass('sticky'))
                {
                    jQuery('.funds-alphabet').removeClass('sticky');
                }
            }
        });
    }
}
function fundInteractions()
{
    if(jQuery('.fund-listings-wrapper').length) 
    {
        var selectedCategories = [];

        jQuery('.parent-fund-link').click(function(e)
        {
            e.preventDefault();

            if(!jQuery(this).hasClass('loaded'))
            {
                /* Load the fund details and show the child table */
            }
            else 
            {
                if(jQuery(this).hasClass('active'))
                {
                    jQuery(this).removeClass('active');
                    jQuery(this).parent().find('.child-fund-table').slideUp();
                }
                else 
                {
                    jQuery(this).addClass('active');
                    jQuery(this).parent().find('.child-fund-table').slideDown();
                }
            }
        });

        var searchLoading = false;
        var oldValue = jQuery('input[name="fund_search"]').val();

        jQuery('input[name="fund_search"]').on('input', function()
        {
            var letterCount = jQuery(this).val().length;
            var currentValue = jQuery(this).val();

            if(letterCount >= 3 && currentValue != oldValue)
            {
                if(searchLoading == false)
                {
                    searchLoading = true;
                    oldValue = currentValue;

                    jQuery.ajax({
                        url: '/wp-admin/admin-ajax.php?action=ajaxFundSearch',
                        type: 'POST',
                        data: {
                            searchTerm: currentValue,
                            categories: selectedCategories
                        },
                        success: function(response)
                        {
                            searchLoading = false;

                            if(response == 'no results')
                            {
                                var numberOfCategories = toggleFundCategories(currentValue);

                                jQuery('.fund-results-families').empty();

                                if(numberOfCategories == 0)
                                {
                                    if(jQuery('.fund-results-wrapper').is(':visible'))
                                    {
                                        jQuery('.fund-results-wrapper').slideUp();
                                    }
                                }
                                else 
                                {
                                    if(!jQuery('.fund-results-wrapper').is(':visible'))
                                    {
                                        jQuery('.fund-results-wrapper').slideDown();
                                    }
                                }
                            }
                            else 
                            {
                                toggleFundCategories(currentValue);

                                jQuery('.fund-results-families').html(response);

                                if(!jQuery('.fund-results-wrapper').is(':visible'))
                                {
                                    jQuery('.fund-results-wrapper').slideDown();
                                }
                            }
                        }
                    });
                }

            }
            else if(letterCount == 0)
            {
                /* Add Category Interactions Here - Show All Categories */
                //jQuery('.category-result').not(':visible').removeClass('selected').css('display', '');

                jQuery('.fund-results-families').empty();

                if(jQuery('.fund-results-wrapper').is(':visible'))
                {
                    jQuery('.fund-results-wrapper').slideUp();
                }
            }
        });

        jQuery('#fund-search-form').submit(function(e)
        {
            e.preventDefault();

            searchLoading = true;

            var searchValue = jQuery('input[name="fund_search"]').val();

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php?action=ajaxFundSearch',
                type: 'POST',
                data: {
                    searchTerm: searchValue,
                    categories: selectedCategories
                },
                success: function(response)
                {
                    searchLoading = false;
                    
                    if(response == 'no results')
                    {
                        var numberOfCategories = toggleFundCategories(searchValue);
                        jQuery('.fund-results-families').empty();

                        if(numberOfCategories == 0)
                        {
                            if(jQuery('.fund-results-wrapper').is(':visible'))
                            {
                                jQuery('.fund-results-wrapper').slideUp();
                            }
                        }
                        else 
                        {
                            if(!jQuery('.fund-results-wrapper').is(':visible'))
                            {
                                jQuery('.fund-results-wrapper').slideDown();
                            }
                        }
                    }
                    else 
                    {
                        toggleFundCategories(searchValue);
                        jQuery('.fund-results-families').html(response);

                        if(!jQuery('.fund-results-wrapper').is(':visible'))
                        {
                            jQuery('.fund-results-wrapper').slideDown();
                        }
                    }
                }
            });
        });

        function toggleFundCategories(term) 
        {
            var numberReturned = 0;
            var cleanTerm = jQuery.trim(term);
            var lowercaseTerm = cleanTerm.toLowerCase();

            jQuery('.category-result').each(function()
            {
                var cleanCatName = jQuery.trim(jQuery(this).find('.name-inner').text());
                
                if(cleanCatName.toLowerCase().indexOf(lowercaseTerm) > -1)
                {
                    if(!jQuery(this).is(':visible'))
                    {
                        jQuery(this).show();
                        numberReturned++;
                    }
                }
                else 
                {
                    jQuery(this).hide();
                }
            });

            return numberReturned;
        }

        jQuery('body').on('click', '.category-result', function(e)
        {
            e.preventDefault();

            var categoryID = jQuery(this).attr('data-id');
            var categoryName = jQuery(this).find('.name-inner').text();

            jQuery(this).addClass('selected');

            selectedCategories.push(categoryID);

            jQuery('.cat-filter-list').append('<li><a href="#" data-id="'+categoryID+'">'+categoryName+'<span class="icon"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"> <circle cx="10" cy="10" r="10" fill="#F7F6FB"/> <path d="M6 6L14 14" stroke="#2F3942"/> <path d="M14 6L6 14" stroke="#2F3942"/> </svg> </span></a></li>');

            if(!jQuery('.fund-cat-wrapper').is(':visible'))
            {
                jQuery('.fund-cat-wrapper').show();
            }

            /* Query New Fund Families Here based on selected categories */
            jQuery('.ajax-loader').fadeIn('fast');
            jQuery('.fund-results-families').empty();

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php?action=ajaxRebuildFunds',
                type: 'POST',
                data: {
                    fund_categories: selectedCategories
                },
                dataType: "json",
                success: function(response)
                {
                    jQuery('.fund-results-families').html(response[0]);
                    jQuery('.funds-alphabet').html(response[1]);
                    jQuery('.fund-listings-wrapper').html(response[2]);

                    jQuery('.ajax-loader').fadeOut('fast');

                    var swiper = new Swiper('.alphabet-carousel', {
                        loop: false,
                        slidesPerView: 5,
                        spaceBetween: 10,
                        breakpoints: {
                            720: {
                                slidesPerView: 13,
                                spaceBetween: 10
                            },
                            1100: {
                                slidesPerView: 26,
                                spaceBetween: 10
                            }
                        }
                    });
                }
            });
        });

        jQuery('body').on('click', '.cat-filter-list a', function(e)
        {
            e.preventDefault();

            var categoryID = jQuery(this).attr('data-id');

            jQuery('.category-result[data-id="'+categoryID+'"]').removeClass('selected');

            jQuery(this).parent().remove();

            selectedCategories.splice(selectedCategories.indexOf(categoryID), 1);

            if(selectedCategories.length == 0)
            {
                jQuery('.fund-cat-wrapper').hide();
            }

            jQuery('.ajax-loader').fadeIn('fast');
            jQuery('.fund-results-families').empty();

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php?action=ajaxRebuildFunds',
                type: 'POST',
                data: {
                    fund_categories: selectedCategories
                },
                dataType: "json",
                success: function(response)
                {
                    jQuery('.fund-results-families').html(response[0]);
                    jQuery('.funds-alphabet').html(response[1]);
                    jQuery('.fund-listings-wrapper').html(response[2]);

                    jQuery('.ajax-loader').fadeOut('fast');

                    var swiper = new Swiper('.alphabet-carousel', {
                        loop: false,
                        slidesPerView: 5,
                        spaceBetween: 10,
                        breakpoints: {
                            720: {
                                slidesPerView: 13,
                                spaceBetween: 10
                            },
                            1100: {
                                slidesPerView: 26,
                                spaceBetween: 10
                            }
                        }
                    });
                }
            });
        });

        /* Close the fund results wrapper if clicked outside */
        jQuery(document).on('click', function(event) 
        {
            // Check if the clicked element is outside the .fund-results-wrapper and its children
            if (!jQuery(event.target).closest('.fund-results-wrapper').length) 
            {
                jQuery('.fund-results-wrapper').slideUp();
            }
        });

        /* Populate Fund Table when Parent Link Clicked */
        jQuery('body').on('click', '.parent-fund-link', function(e)
        {
            e.preventDefault();

            var parentID = jQuery(this).parent().attr('data-id');
            var childID = parentID;

            populateFundTable(parentID, childID, 'resume');
        });

        /* Populate Fund Table when Search Result Clicked */
        jQuery('body').on('click', '.fund-result', function(e)
        {
            e.preventDefault();

            var parentID = jQuery(this).attr('data-parent');
            var childID = jQuery(this).attr('data-id');

            populateFundTable(parentID, childID, 'scroll');

            jQuery('.fund-results-wrapper').slideUp();
        });
    }
}
function populateFundTable(parentID, childID, followUp)
{
    if(parentID != null)
    {
        var parentRow = jQuery('.parent-fund-wrapper[data-id="' + parentID + '"]');

        if(parentRow.length)
        {
            if(jQuery(parentRow).hasClass('populated'))
            {
                if(jQuery(parentRow).find('.parent-fund-link').hasClass('expanded'))
                {
                    if(followUp == 'scroll')
                    {
                        var targetElement = jQuery('div[data-id="' + childID + '"]');

                        if(targetElement.length)
                        {
                            jQuery('html, body').animate({
                                scrollTop: targetElement.offset().top - 200
                            }, 500);
                        }
                    }
                    else 
                    {
                        jQuery(parentRow).find('.child-fund-table').slideUp();
                        jQuery(parentRow).find('.parent-fund-link').removeClass('expanded');
                    }   
                }
                else 
                {
                    jQuery(parentRow).find('.child-fund-table').slideDown('fast', function()
                    {
                        if(followUp == 'scroll')
                        {
                            var targetElement = jQuery('div[data-id="' + childID + '"]');

                            if(targetElement.length)
                            {
                                jQuery('html, body').animate({
                                    scrollTop: targetElement.offset().top - 200
                                }, 500);
                            }
                        }
                    });

                    jQuery(parentRow).find('.parent-fund-link').addClass('expanded');
                }
            }
            else 
            {
                jQuery('.ajax-loader').fadeIn('fast');

                jQuery.ajax({
                    url: '/wp-admin/admin-ajax.php?action=ajaxGetFundTable',
                    type: 'POST',
                    data: {
                        parentID: parentID
                    },
                    success: function(response)
                    {
                        searchLoading = false;
                        jQuery('.ajax-loader').fadeOut('fast');

                        if(response !== 'no results') 
                        {
                            jQuery(parentRow).find('.child-fund-table').html(response);

                            jQuery('.parent-fund-wrapper[data-id="' + parentID + '"]').addClass('populated');
                            jQuery('.parent-fund-wrapper[data-id="' + parentID + '"]').find('.parent-fund-link').addClass('expanded');

                            jQuery(parentRow).find('.child-fund-table').slideDown('fast', function()
                            {
                                if(followUp == 'scroll')
                                {
                                    var targetElement = jQuery('div[data-id="' + childID + '"]');

                                    if(targetElement.length)
                                    {
                                        jQuery('html, body').animate({
                                            scrollTop: targetElement.offset().top - 200
                                        }, 500);
                                    }
                                }
                            });
                        }
                        else 
                        {
                            jQuery(parentRow).find('.child-fund-table').html('<div class="child-fund-row"><div class="child-fund-cell">No results found</div></div>');

                            jQuery('.parent-fund-wrapper[data-id="' + parentID + '"]').addClass('populated');
                            jQuery('.parent-fund-wrapper[data-id="' + parentID + '"]').find('.parent-fund-link').addClass('expanded');

                            jQuery(parentRow).find('.child-fund-table').slideDown('fast', function()
                            {
                                if(followUp == 'scroll')
                                {
                                    var targetElement = jQuery('div[data-id="' + childID + '"]');

                                    if(targetElement.length)
                                    {
                                        jQuery('html, body').animate({
                                            scrollTop: targetElement.offset().top - 200
                                        }, 500);
                                    }
                                }
                            });
                        }
                    }
                });
            }
        }
    }
}
function fundModal()
{
    if(jQuery('.fund-information-modal').length)
    {
        var termsAccepted = false;

        let fundModal =  new Fancybox([
            {
                src: '#fund-modal',
                type: 'inline',
                closeButton: false,
                backdropClick: false,
                contentClick: false
            }
        ]);

        fundModal.on('shouldClose', (fancybox, slide) => {
            if (!termsAccepted) {
                Fancybox.open();
            }
            return true; // Allow closing
        });

        jQuery('.modal-redirect-btn').click(function(e)
        {
            e.preventDefault();

            var target = '/';

            window.location.href = target;
        });


        jQuery('.modal-accept-btn').click(function(e)
        {
            e.preventDefault();

            termsAccepted = true;

            Fancybox.close();

            setCookie('fundModal', 'true');
        });
    }
}
function pdfSearch()
{
    if(jQuery('#pdf-search-form').length)
    {
        jQuery('input[name="pdf_search"]').on('input', function()
        {
            var oldValue = '';
            var letterCount = jQuery(this).val().length;
            var currentValue = jQuery(this).val();

            if(letterCount >= 3 && currentValue != oldValue)
            {
                oldValue = currentValue;

                var linksArray = [];

                jQuery('.pdf-link').each(function()
                {
                    var pdfName = jQuery(this).text();
                    var pdfLink = jQuery(this).attr('href');
                    var cleanName = pdfName.trim();

                    if (cleanName.toLowerCase().includes(currentValue.toLowerCase())) 
                    {
                        linksArray.push({ name: pdfName, link: pdfLink });
                    }
                });

                if(linksArray.length != 0)
                {
                    // Sort the array alphabetically by name
                    linksArray.sort(function(a, b) 
                    {
                        return b.name.localeCompare(a.name);
                    });

                    // Generate the HTML for the sorted links
                    var linksHtml = linksArray.map(function(item) 
                    {
                        return '<a href="' + item.link + '" target="_blank"><span class="result-name">' + item.name + '</span></a>';
                    }).join('');

                    // Replace the fund-results-wrapper HTML with the sorted links
                    jQuery('.fund-results-wrapper').html(linksHtml);

                    if (!jQuery('.fund-results-wrapper').is(':visible')) 
                    {
                        jQuery('.fund-results-wrapper').slideDown();
                    }
                }
                else 
                {
                    jQuery('.fund-results-wrapper').empty();

                    if(jQuery('.fund-results-wrapper').is(':visible'))
                    {
                        jQuery('.fund-results-wrapper').slideUp();
                    }
                }
                
            }
            else if(letterCount == 0)
            {
                jQuery('.fund-results-wrapper').empty();

                if(jQuery('.fund-results-wrapper').is(':visible'))
                {
                    jQuery('.fund-results-wrapper').slideUp();
                }
            }
        });

        jQuery('#pdf-search-form').submit(function(e)
        {
            e.preventDefault();

            var searchValue = jQuery('input[name="pdf_search"]').val();

            var linksArray = [];

            jQuery('.pdf-link').each(function()
            {
                var pdfName = jQuery(this).text();
                var pdfLink = jQuery(this).attr('href');
                var cleanName = pdfName.trim();

                if (cleanName.toLowerCase().includes(searchValue.toLowerCase())) 
                {
                    linksArray.push({ name: pdfName, link: pdfLink });
                }
            });

            if(linksArray.length != 0)
            {
                // Sort the array alphabetically by name
                linksArray.sort(function(a, b) 
                {
                    return b.name.localeCompare(a.name);
                });

                // Generate the HTML for the sorted links
                var linksHtml = linksArray.map(function(item) 
                {
                    return '<a href="' + item.link + '" target="_blank"><span class="result-name">' + item.name + '</span></a>';
                }).join('');

                // Replace the fund-results-wrapper HTML with the sorted links
                jQuery('.fund-results-wrapper').html(linksHtml);

                jQuery('.fund-results-wrapper').slideDown();
            }
            else 
            {
                jQuery('.fund-results-wrapper').empty();

                if(jQuery('.fund-results-wrapper').is(':visible'))
                {
                    jQuery('.fund-results-wrapper').slideUp();
                }
            }
        });

        /* Close the fund results wrapper if clicked outside */
        jQuery(document).on('click', function(event) 
        {
            // Check if the clicked element is outside the .fund-results-wrapper and its children
            if (!jQuery(event.target).closest('.fund-results-wrapper').length) 
            {
                jQuery('.fund-results-wrapper').slideUp();
            }
        });
    }
}
function linkSmoothScroll()
{
    jQuery('a[href^=\\#]:not(.category-result):not(.fund-result):not(.letter-link):not(.category-filter):not(.file-filter):not(.feed-tag):not(.share-btn):not(.mobile-close-btn):not(.nav-tab):not(.copy-btn):not(.print-btn):not(.member-item').on('click', function(event) {
        event.preventDefault();

        if(jQuery(this.hash).length)
        {
            jQuery('html,body').animate({ scrollTop: jQuery(this.hash).offset().top -150 }, 500);
        }
    });
}
function vanityFormScroll()
{
    const queryParams = new URLSearchParams(window.location.search);

    if(queryParams.has('schedule-demo'))
    {
        jQuery('html,body').animate({ scrollTop: jQuery('#gform_3').offset().top -220 }, 500);
    }
}
function resourcesInteraction()
{
    if(jQuery('body.page-template-blog-archive').length)
    {
        var categories = [];
        var tags = [];
        var types = [];
        var page = 1;
        var loading = false;
        var noResults = false;
        var searchTerm;
        const urlParams = new URLSearchParams(window.location.search);

        if(jQuery('.archive-search-form input[name="search"]').val() != '')
        {
            searchTerm = jQuery('.archive-search-form input[name="search"]').val();
        }

        if(urlParams.has('cat'))
        {
            var categoryID = urlParams.get('cat');

            categories.push(categoryID);
        }

        if(urlParams.has('tag'))
        {
            var tagID = urlParams.get('tag');

            tags.push(tagID);
        }

        if(urlParams.has('type'))
        {
            var typeID = urlParams.get('type');

            types.push(typeID);
        }

        jQuery('.category-filter').click(function(e)
        {
            e.preventDefault();

            page = 1;
            loading = true;
            noResults = false;

            var categoryID = jQuery(this).attr('data-id');

            if(jQuery(this).hasClass('active'))
            {
                jQuery(this).removeClass('active');
                categories.splice(categories.indexOf(categoryID), 1);
            }
            else 
            {
                jQuery(this).addClass('active');
                categories.push(categoryID);
            }

            jQuery('.ajax-loader').fadeIn('fast');

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php?action=ajaxGetResources',
                type: 'POST',
                data: {
                    searchTerm: searchTerm,
                    categories: categories,
                    tags: tags,
                    types: types,
                    page: page
                },
                success: function(response)
                {
                    loading = false;

                    jQuery('.ajax-loader').fadeOut('fast');

                    if(response == '<h3 class="no-results">No Results Found!</h3>')
                    {
                        noResults = true;
                    }

                    jQuery('.blog-results').html(response);
                },
                error: function(response)
                {
                    loading = false;

                    console.log(response);
                }
            });
        });

        jQuery('.file-filter').click(function(e)
        {
            e.preventDefault();

            page = 1;
            loading = true;
            noResults = false;

            var typeID = jQuery(this).attr('data-id');

            if(jQuery(this).hasClass('active'))
            {
                jQuery(this).removeClass('active');
                types.splice(types.indexOf(typeID), 1);
            }
            else 
            {
                jQuery(this).addClass('active');
                types.push(typeID);
            }

            jQuery('.ajax-loader').fadeIn('fast');

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php?action=ajaxGetResources',
                type: 'POST',
                data: {
                    searchTerm: searchTerm,
                    categories: categories,
                    tags: tags,
                    types: types,
                    page: page
                },
                success: function(response)
                {
                    loading = false;

                    jQuery('.ajax-loader').fadeOut('fast');

                    if(response == '<h3 class="no-results">No Results Found!</h3>')
                    {
                        noResults = true;
                    }

                    jQuery('.blog-results').html(response);
                },
                error: function(response)
                {
                    loading = false;

                    console.log(response);
                }
            });
        });

        jQuery('.archive-search-form').submit(function(e)
        {
            e.preventDefault();

            page = 1;
            loading = true;
            noResults = false;
            searchTerm = jQuery('.archive-search-form input[name="search"]').val();

            jQuery('.ajax-loader').fadeIn('fast');

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php?action=ajaxGetResources',
                type: 'POST',
                data: {
                    searchTerm: searchTerm,
                    categories: categories,
                    tags: tags,
                    types: types,
                    page: page
                },
                success: function(response)
                {
                    loading = false;

                    jQuery('.ajax-loader').fadeOut('fast');

                    if(response == '<h3 class="no-results">No Results Found!</h3>')
                    {
                        noResults = true;
                    }

                    jQuery('.blog-results').html(response);
                },
                error: function(response)
                {
                    loading = false;

                    console.log(response);
                }
            });
        });

        jQuery('body').on('click', '.feed-tag', function(e)
        {
            e.preventDefault();

            var tagID = jQuery(this).attr('data-id');
            var tagName = jQuery(this).text();

            if(!tags.includes(tagID))
            {
                tags.push(tagID);

                jQuery('.tags-applied .tags-list').append('<li> <a data-id="'+tagID+'" class="removal-tag"> '+tagName+' <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"> <circle cx="10" cy="10" r="10" fill="#F7F6FB"/> <path d="M6 6L14 14" stroke="#2F3942"/> <path d="M14 6L6 14" stroke="#2F3942"/> </svg> </a> </li>');
            }
            else 
            {
                tags.splice(tags.indexOf(tagID), 1);

                jQuery('.tags-applied .tags-list a[data-id="'+tagID+'"]').parent().remove();
            }

            jQuery('.ajax-loader').fadeIn('fast');

            jQuery('body,html').animate({
                scrollTop: jQuery('.blog-results').offset().top - 100
            }, 500);

            page = 1;
            loading = true;
            noResults = false; 

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php?action=ajaxGetResources',
                type: 'POST',
                data: {
                    searchTerm: searchTerm,
                    categories: categories,
                    tags: tags,
                    types: types,
                    page: page
                },
                success: function(response)
                {
                    loading = false;

                    jQuery('.ajax-loader').fadeOut('fast');

                    if(response == '<h3 class="no-results">No Results Found!</h3>')
                    {
                        noResults = true;
                    }

                    jQuery('.blog-results').html(response);
                },
                error: function(response)
                {
                    loading = false;

                    console.log(response);
                }
            });
        });

        jQuery('body').on('click', '.removal-tag', function(e)
        {
            e.preventDefault();

            var tagID = jQuery(this).attr('data-id');

            tags.splice(tags.indexOf(tagID), 1);

            jQuery(this).parent().remove();

            page = 1;
            loading = true;
            noResults = false;

            jQuery('.ajax-loader').fadeIn('fast');

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php?action=ajaxGetResources',
                type: 'POST',
                data: {
                    searchTerm: searchTerm,
                    categories: categories,
                    tags: tags,
                    types: types,
                    page: page
                },
                success: function(response)
                {
                    loading = false;

                    jQuery('.ajax-loader').fadeOut('fast');

                    if(response == '<h3 class="no-results">No Results Found!</h3>')
                    {
                        noResults = true;
                    }

                    jQuery('.blog-results').html(response);
                },
                error: function(response)
                {
                    loading = false;

                    console.log(response);
                }
            });
        });

        jQuery(window).scroll(function()
        {
            var windowBottomPosition = jQuery(window).scrollTop() + jQuery(window).height();

            var loadingPosition = jQuery('.loading-position').offset().top;

            if(windowBottomPosition >= loadingPosition - 400 && !loading && !noResults)
            {
                page++;

                loading = true;

                jQuery.ajax({
                    url: '/wp-admin/admin-ajax.php?action=ajaxGetResources',
                    type: 'POST',
                    data: {
                        searchTerm: searchTerm,
                        categories: categories,
                        tags: tags,
                        types: types,
                        page: page
                    },
                    success: function(response)
                    {
                        loading = false;

                        if(response == '<h3 class="no-results">No Results Found!</h3>')
                        {
                            noResults = true;
                        }
                        else 
                        {
                            jQuery('.blog-results').append(response);
                        }
                    },
                    error: function(response)
                    {
                        loading = false;

                        console.log(response);
                    }
                });
            }
        });
    }
}
function shareModal()
{
    if(jQuery('.share-btn').length)
    {
        /*
        jQuery('.share-btn').magnificPopup({
            type: 'inline',
            preloader: false,
            closeOnBgClick: true,
            showCloseBtn: true
        });
        */

        jQuery('.mfp-close').click(function(e)
        {
            e.preventDefault();

            //jQuery.magnificPopup.close();
            Fancybox.close();
        });

        jQuery('.copy-btn').click(function(e)
        {
            e.preventDefault();

            var copyText = document.getElementById('post-url');

            copyText.readOnly = true;
            copyText.type = 'text';

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value);

            copyText.type = 'hidden';
        });

        jQuery('.share-form').submit(function(e)
        {
            e.preventDefault();

            var formData = jQuery(this).serialize();

            if(jQuery('.share-success').is(':visible'))
            {
                jQuery('.share-success').fadeOut('fast');
            }

            if(jQuery('.share-error').is(':visible'))
            {
                jQuery('.share-error').fadeOut('fast');
            }

            jQuery('.share-form').fadeOut('fast');

            jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php?action=ajaxSharePost',
                data: formData,
                success: function(response)
                {
                    if(response == 'success')
                    {
                        jQuery('.share-success').fadeIn('fast');
                    }
                    else
                    {
                        jQuery('.share-form').fadeIn('fast');
                        jQuery('.share-error').fadeIn('fast');
                    }
                },
                error: function(errorThrown)
                {
                    jQuery('.share-form').fadeIn('fast');

                    console.log(errorThrown);
                }
            });
        });
    }
}
function initAOS()
{
    AOS.init();
}
function fancyBoxInit()
{
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
      });
}
function setCookie(key, value) 
{
    var expires = new Date();
    expires.setTime(expires.getTime() + 31536000000); //1 year
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}
function getCookie(key) 
{
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}