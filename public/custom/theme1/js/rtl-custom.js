/*  jQuery Nice Select - v1.0
    https://github.com/hernansartorio/jquery-nice-select
    Made by Hernán Sartorio  */
    !function(e){e.fn.niceSelect=function(t){function s(t){t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class")||"").addClass(t.attr("disabled")?"disabled":"").attr("tabindex",t.attr("disabled")?null:"0").html('<span class="current"></span><ul class="list"></ul>'));var s=t.next(),n=t.find("option"),i=t.find("option:selected");s.find(".current").html(i.data("display")||i.text()),n.each(function(t){var n=e(this),i=n.data("display");s.find("ul").append(e("<li></li>").attr("data-value",n.val()).attr("data-display",i||null).addClass("option"+(n.is(":selected")?" selected":"")+(n.is(":disabled")?" disabled":"")).html(n.text()))})}if("string"==typeof t)return"update"==t?this.each(function(){var t=e(this),n=e(this).next(".nice-select"),i=n.hasClass("open");n.length&&(n.remove(),s(t),i&&t.next().trigger("click"))}):"destroy"==t?(this.each(function(){var t=e(this),s=e(this).next(".nice-select");s.length&&(s.remove(),t.css("display",""))}),0==e(".nice-select").length&&e(document).off(".nice_select")):console.log('Method "'+t+'" does not exist.'),this;this.hide(),this.each(function(){var t=e(this);t.next().hasClass("nice-select")||s(t)}),e(document).off(".nice_select"),e(document).on("click.nice_select",".nice-select",function(t){var s=e(this);e(".nice-select").not(s).removeClass("open"),s.toggleClass("open"),s.hasClass("open")?(s.find(".option"),s.find(".focus").removeClass("focus"),s.find(".selected").addClass("focus")):s.focus()}),e(document).on("click.nice_select",function(t){0===e(t.target).closest(".nice-select").length&&e(".nice-select").removeClass("open").find(".option")}),e(document).on("click.nice_select",".nice-select .option:not(.disabled)",function(t){var s=e(this),n=s.closest(".nice-select");n.find(".selected").removeClass("selected"),s.addClass("selected");var i=s.data("display")||s.text();n.find(".current").text(i),n.prev("select").val(s.data("value")).trigger("change")}),e(document).on("keydown.nice_select",".nice-select",function(t){var s=e(this),n=e(s.find(".focus")||s.find(".list .option.selected"));if(32==t.keyCode||13==t.keyCode)return s.hasClass("open")?n.trigger("click"):s.trigger("click"),!1;if(40==t.keyCode){if(s.hasClass("open")){var i=n.nextAll(".option:not(.disabled)").first();i.length>0&&(s.find(".focus").removeClass("focus"),i.addClass("focus"))}else s.trigger("click");return!1}if(38==t.keyCode){if(s.hasClass("open")){var l=n.prevAll(".option:not(.disabled)").first();l.length>0&&(s.find(".focus").removeClass("focus"),l.addClass("focus"))}else s.trigger("click");return!1}if(27==t.keyCode)s.hasClass("open")&&s.trigger("click");else if(9==t.keyCode&&s.hasClass("open"))return!1});var n=document.createElement("a").style;return n.cssText="pointer-events:auto","auto"!==n.pointerEvents&&e("html").addClass("no-csspointerevents"),this}}(jQuery);


    $(document).ready(function() {
        /********* On scroll heder Sticky *********/
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 50) {
                $("header").addClass("head-sticky");
            } else {
                $("header").removeClass("head-sticky");
            }
        });   
        /********* Wrapper top space ********/
        var header_hright = $('header').outerHeight();
        $('header').next('.wrapper').css('margin-top', header_hright + 'px');  
        /********* Announcebar hide ********/
        $('#announceclose').click(function () {
            $('.announcebar').slideUp();
        }); 
        /********* Mobile Menu ********/  
        $('.mobile-menu-button').on('click',function(e){
            e.preventDefault();
            setTimeout(function(){
                $('body').addClass('no-scroll active-menu');
                $(".mobile-menu-wrapper").toggleClass("active-menu");
                $('.overlay').addClass('menu-overlay');
            }, 50);
        }); 
        $('body').on('click','.overlay.menu-overlay, .menu-close-icon svg', function(e){
            e.preventDefault(); 
            $('body').removeClass('no-scroll active-menu');
            $(".mobile-menu-wrapper").removeClass("active-menu");
            $('.overlay').removeClass('menu-overlay');
        });
    
        /********* Mobile Filter Popup ********/
        $('.filter-title').on('click',function(e){
            e.preventDefault();
            setTimeout(function(){
                $('body').addClass('no-scroll filter-open');
                $('.overlay').addClass('active');
            }, 50);
        }); 
        $('body').on('click','.overlay.active, .close-filter', function(e){
            e.preventDefault(); 
            $('.overlay').removeClass('active');
            $('body').removeClass('no-scroll filter-open');
        }); 
           /*********  Header Search Popup  ********/ 
           $(".mobile-search-btn a").click(function() { 
            $(".search-popup").toggleClass("active"); 
            $("body").toggleClass("no-scroll");
        });
        $(".close-search").click(function() { 
            $(".search-popup").removeClass("active"); 
            $("body").removeClass("no-scroll");
        });
        /******* Cookie Js *******/
        $('.cookie-close').click(function () {
            $('.cookie').slideUp();
        });
        /******* Subscribe popup Js *******/
        $('.close-sub-btn').click(function () {
            $('.subscribe-popup').slideUp(); 
            $(".subscribe-overlay").removeClass("open");
        });      
        /********* qty spinner ********/
        var quantity = 0;
        $('.quantity-increment').click(function(){;
            var t = $(this).siblings('.quantity');
            var quantity = parseInt($(t).val());
            $(t).val(quantity + 1); 
        }); 
        $('.quantity-decrement').click(function(){
            var t = $(this).siblings('.quantity');
            var quantity = parseInt($(t).val());
            if(quantity > 1){
                $(t).val(quantity - 1);
            }
        });   
        /******  Nice Select  ******/ 
        $('#view_theme11 select').niceSelect(); 
        /*********  Multi-level accordion nav  ********/ 
        $('.acnav-label').click(function () {
            var label = $(this);
            var parent = label.parent('.has-children');
            var list = label.siblings('.acnav-list');
            if (parent.hasClass('is-open')) {
                list.slideUp('fast');
                parent.removeClass('is-open');
            }
            else {
                list.slideDown('fast');
                parent.addClass('is-open');
            }
        });  
        /****  TAB Js ****/
        $('ul.tabs li').click(function(){
            var $this = $(this);
            var $theTab = $(this).attr('data-tab');
            console.log($theTab);
            if($this.hasClass('active')){
              // do nothing
            } else{
              $this.closest('.tabs-wrapper').find('ul.tabs li, .tabs-container .tab-content').removeClass('active');
              $('.tabs-container .tab-content[id="'+$theTab+'"], ul.tabs li[data-tab="'+$theTab+'"]').addClass('active');
            }
        });  
    
        $('.gallery-slider').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 2,
            slidesToScroll: 2,
            rtl:true,
            prevArrow: '<button class="slick-prev slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none"><path d="M17.9117 6.97283C17.8433 6.80735 17.7446 6.65825 17.6205 6.53414L12.2246 1.13817C11.6976 0.611168 10.8431 0.611168 10.3161 1.13817C9.78912 1.66518 9.78912 2.5196 10.3161 3.04661L13.4098 6.14024H2.27795C1.5333 6.14024 0.928955 6.74459 0.928955 7.48924C0.928955 8.23388 1.5333 8.83823 2.27795 8.83823H13.4098L10.3161 11.9319C9.78912 12.4589 9.78912 13.3133 10.3161 13.8403C10.5787 14.1029 10.9241 14.2359 11.2695 14.2359C11.6148 14.2359 11.9602 14.1047 12.2228 13.8403L17.6188 8.44433C17.7429 8.32023 17.8416 8.17112 17.9099 8.00565C18.0484 7.67469 18.0484 7.30378 17.9117 6.97283Z" fill="#242424"/></svg></button>',
            nextArrow: '<button class="slick-next slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none"><path d="M17.9117 6.97283C17.8433 6.80735 17.7446 6.65825 17.6205 6.53414L12.2246 1.13817C11.6976 0.611168 10.8431 0.611168 10.3161 1.13817C9.78912 1.66518 9.78912 2.5196 10.3161 3.04661L13.4098 6.14024H2.27795C1.5333 6.14024 0.928955 6.74459 0.928955 7.48924C0.928955 8.23388 1.5333 8.83823 2.27795 8.83823H13.4098L10.3161 11.9319C9.78912 12.4589 9.78912 13.3133 10.3161 13.8403C10.5787 14.1029 10.9241 14.2359 11.2695 14.2359C11.6148 14.2359 11.9602 14.1047 12.2228 13.8403L17.6188 8.44433C17.7429 8.32023 17.8416 8.17112 17.9099 8.00565C18.0484 7.67469 18.0484 7.30378 17.9117 6.97283Z" fill="#242424"/></svg></button>',
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2,
                  infinite: true,
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
            ]
          });
          $('.testimonial-slider').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 2,
            slidesToScroll: 2,
            rtl:true,
            prevArrow: '<button class="slick-prev slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none"><path d="M17.9117 6.97283C17.8433 6.80735 17.7446 6.65825 17.6205 6.53414L12.2246 1.13817C11.6976 0.611168 10.8431 0.611168 10.3161 1.13817C9.78912 1.66518 9.78912 2.5196 10.3161 3.04661L13.4098 6.14024H2.27795C1.5333 6.14024 0.928955 6.74459 0.928955 7.48924C0.928955 8.23388 1.5333 8.83823 2.27795 8.83823H13.4098L10.3161 11.9319C9.78912 12.4589 9.78912 13.3133 10.3161 13.8403C10.5787 14.1029 10.9241 14.2359 11.2695 14.2359C11.6148 14.2359 11.9602 14.1047 12.2228 13.8403L17.6188 8.44433C17.7429 8.32023 17.8416 8.17112 17.9099 8.00565C18.0484 7.67469 18.0484 7.30378 17.9117 6.97283Z" fill="#242424"/></svg></button>',
            nextArrow: '<button class="slick-next slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none"><path d="M17.9117 6.97283C17.8433 6.80735 17.7446 6.65825 17.6205 6.53414L12.2246 1.13817C11.6976 0.611168 10.8431 0.611168 10.3161 1.13817C9.78912 1.66518 9.78912 2.5196 10.3161 3.04661L13.4098 6.14024H2.27795C1.5333 6.14024 0.928955 6.74459 0.928955 7.48924C0.928955 8.23388 1.5333 8.83823 2.27795 8.83823H13.4098L10.3161 11.9319C9.78912 12.4589 9.78912 13.3133 10.3161 13.8403C10.5787 14.1029 10.9241 14.2359 11.2695 14.2359C11.6148 14.2359 11.9602 14.1047 12.2228 13.8403L17.6188 8.44433C17.7429 8.32023 17.8416 8.17112 17.9099 8.00565C18.0484 7.67469 18.0484 7.30378 17.9117 6.97283Z" fill="#242424"/></svg></button>',
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2,
                  infinite: true,
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
            ]
          });
        //   share modal
          $('.share-modal-toggle').on('click', function(e) {
            $('.theme-modal.share-card').toggleClass('active');
            $('body').toggleClass('no-scroll');
          });
          // appointment modal
          $('.appointment-modal-toggle').on('click', function(e) {
            $('.theme-modal.appointment-modal').toggleClass('active');
            $('body').toggleClass('no-scroll');
          });
          // contact modal
          $('.make-contact-modal-toggle').on('click', function(e) {
            $('.theme-modal.contact-modal').toggleClass('active');
            $('body').toggleClass('no-scroll');
          });
    });
    