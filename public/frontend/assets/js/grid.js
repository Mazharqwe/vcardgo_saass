( function( $ ) {
    $.sep_grid_refresh = function (){
        $('.pxl-grid-masonry').each(function () {
            var iso = new Isotope(this, {
                itemSelector: '.pxl-grid-item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.grid-sizer',
                },
                containerStyle: null,
                stagger: 30,
                sortBy : 'name',
            });

            var filtersElem = $(this).parent().find('.pxl-grid-filter');
            filtersElem.on('click', function (event) {
                var filterValue = event.target.getAttribute('data-filter');
                iso.arrange({filter: filterValue});
            });

            var filterItem = $(this).parent().find('.filter-item');
            filterItem.on('click', function (e) {
                filterItem.removeClass('active');
                $(this).addClass('active');
            });

            var filtersSelect = $(this).parent().find('.pxl-grid-filter');
            filtersSelect.change(function() {
                var filters = $(this).val();
                iso.arrange({filter: filters});
            });

            var orderSelect = $(this).parent().find('.pxl-grid-filter');
            orderSelect.change(function() {
                var e_order = $(this).val();
                if(e_order == 'asc') {
                    iso.arrange({sortAscending: false});
                }
                if(e_order == 'des') {
                    iso.arrange({sortAscending: true});
                }
            });

            $('.pxl-service-grid1').each(function () {
                $(this).find('.pxl-grid-item-inner').hover(function () {
                    $(this).parents('.elementor-element').find('.pxl-grid-item-inner').removeClass('active');
                    $(this).addClass('active');
                });
            });

        });
    }
    
    
    var widget_post_masonry_handler = function( $scope, $ ) {
        $('.pxl-grid-masonry').imagesLoaded(function(){
            $.sep_grid_refresh();
        });
    };

    $(document).ajaxComplete(function(event, xhr, settings){  
        "use strict";
        $(document).on('click', '.pxl-grid-filter .filter-item', function (e) {
            $(this).siblings('.filter-item').removeClass('active');
            $(this).addClass('active');
        });
    });

    $(document).on('click', '.pxl-load-more', function(){
        var loadmore    = $(this).data('loadmore');
        var perpage     = loadmore.perpage;
        var _this       = $(this).parents(".pxl-grid");
        var layout_type = _this.data('layout');
        var loading_text = $(this).data('loading-text');
        var loadmore_text = $(this).data('loadmore-text');  
        loadmore.paged  = parseInt(_this.data('start-page')) +1;
        $(this).addClass('loading');
        $(this).find('.pxl-btn-icon').addClass('loading');
        $(this).find('.pxl-btn-text').text(loading_text);

        if(loadmore.filter == 'true'){
            $.ajax({
                url: main_data.ajax_url,
                type: 'POST',
                beforeSend: function () {

                },
                data: {
                    action: 'sasnio_get_filter_html',
                    settings: loadmore,
                    loadmore_filter: 1
                }
            }).done(function (res) { 
                if(res.status == true){
                    _this.find(".pxl-grid-filter .pxl--filter-inner").html(res.data.html); 
                }
                else if(res.status == false){
                }
            }).fail(function (res) {
                return false;
            }).always(function () {
                return false;
            });
        }

        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function () {

            },
            data: {
                action: 'sasnio_load_more_post_grid',
                settings: loadmore
            }
        })
        .done(function (res) {   
            if(res.status == true) {
                _this.find('.pxl-load-more').removeClass('loading');
                _this.find('.pxl-grid-inner').append(res.data.html);
                _this.data('start-page', res.data.paged);
                $.sep_grid_refresh();
                if(res.data.paged >= res.data.max){
                    _this.find('.pxl-load-more').hide();
                }

                /* Direction Effect */
                    function PXLgetDirection(ev, obj) {
                    var w = $(obj).width(),
                        h = $(obj).height(),
                        x = (ev.pageX - $(obj).offset().left - (w / 2)) * (w > h ? (h / w) : 1),
                        y = (ev.pageY - $(obj).offset().top - (h / 2)) * (h > w ? (w / h) : 1),
                        d = Math.round( Math.atan2(y, x) / 1.57079633 + 5 ) % 4;
                    return d;
                }
                function PXLaddClass( ev, obj, state ) {
                    var direction = PXLgetDirection( ev, obj ),
                    class_suffix = null;
                    $(obj).removeAttr('class');
                    switch ( direction ) {
                        case 0 : class_suffix = '--top';    break;
                        case 1 : class_suffix = '--right';  break;
                        case 2 : class_suffix = '--bottom'; break;
                        case 3 : class_suffix = '--left';   break;
                    }
                    $(obj).addClass( state + class_suffix );
                }
                $.fn.PXLDeriction = function () {
                    this.each(function () {
                        $(this).on('mouseenter',function(ev){
                            PXLaddClass( ev, this, 'pxl-in' );
                        });
                        $(this).on('mouseleave',function(ev){
                            PXLaddClass( ev, this, 'pxl-out' );
                        });
                    });
                }
                $('.pxl-effect--3d .pxl-effect--direction').PXLDeriction();
                /* End Direction Effect */
            } 

        })
        .fail(function (res) {
            _this.find('.btn').hide();
            return false;
        })
        .always(function () {
            return false;
        });
    });

    $(document).on('click', '.pxl-grid-pagination .ajax a.page-numbers', function(){
        var _this = $(this).parents(".pxl-grid");
        var loadmore = _this.find(".pxl-grid-pagination").data('loadmore');
        var query_vars = _this.find(".pxl-grid-pagination").data('query');

        var layout_type = _this.data('layout');
        var paged = $(this).attr('href');
        paged = paged.replace('#', '');
        loadmore.paged = parseInt(paged);
        query_vars.paged = parseInt(paged); 

        var _class = loadmore.pagin_align_cls;

        $('html,body').animate({scrollTop: _this.offset().top - 100}, 750);

        // reload filter
        if(loadmore.filter == 'true'){
            $.ajax({
                url: main_data.ajax_url,
                type: 'POST',
                beforeSend: function () {

                },
                data: {
                    action: 'sasnio_get_filter_html',
                    settings: loadmore
                }
            }).done(function (res) { 
                if(res.status == true){
                    _this.find(".pxl-grid-filter .pxl--filter-inner").html(res.data.html);
                }
                else if(res.status == false){
                }
            }).fail(function (res) {
                return false;
            }).always(function () {
                return false;
            });
        }

        // reload pagination
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function () {

            },
            data: {
                action: 'sasnio_get_pagination_html',
                query_vars: query_vars,
                cls: _class 
            }
        }).done(function (res) {
            if(res.status == true){
                _this.find(".pxl-grid-pagination").html(res.data.html);
            }
            else if(res.status == false){
            }
        }).fail(function (res) {
            return false;
        }).always(function () {
            return false;
        });

        // load post
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function () {

            },
            data: {
                action: 'sasnio_load_more_post_grid',
                settings: loadmore
            }
        }).done(function (res) { //console.log(res); return false;
            if(res.status == true){
                _this.find('.pxl-grid-inner .pxl-grid-item').remove();
                _this.find('.pxl-grid-inner').append(res.data.html);
                _this.data('start-page', res.data.paged);
                if(layout_type == 'masonry'){  
                    
                    /* Direction Effect */
                    function PXLgetDirection(ev, obj) {
                        var w = $(obj).width(),
                            h = $(obj).height(),
                            x = (ev.pageX - $(obj).offset().left - (w / 2)) * (w > h ? (h / w) : 1),
                            y = (ev.pageY - $(obj).offset().top - (h / 2)) * (h > w ? (w / h) : 1),
                            d = Math.round( Math.atan2(y, x) / 1.57079633 + 5 ) % 4;
                        return d;
                    }
                    function PXLaddClass( ev, obj, state ) {
                        var direction = PXLgetDirection( ev, obj ),
                        class_suffix = null;
                        $(obj).removeAttr('class');
                        switch ( direction ) {
                            case 0 : class_suffix = '--top';    break;
                            case 1 : class_suffix = '--right';  break;
                            case 2 : class_suffix = '--bottom'; break;
                            case 3 : class_suffix = '--left';   break;
                        }
                        $(obj).addClass( state + class_suffix );
                    }
                    $.fn.PXLDeriction = function () {
                        this.each(function () {
                            $(this).on('mouseenter',function(ev){
                                PXLaddClass( ev, this, 'pxl-in' );
                            });
                            $(this).on('mouseleave',function(ev){
                                PXLaddClass( ev, this, 'pxl-out' );
                            });
                        });
                    }
                    $('.pxl-effect--3d .pxl-effect--direction').PXLDeriction();
                    /* End Direction Effect */

                    $.sep_grid_refresh();
                }
                 
            }
            else if(res.status == false){
            }
        }).fail(function (res) {
            return false;
        }).always(function () {
            return false;
        });
        return false;
    });

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/pxl_post_grid.default', widget_post_masonry_handler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/pxl_showcase_grid.default', widget_post_masonry_handler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/pxl_testimonial_grid.default', widget_post_masonry_handler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/pxl_team_grid.default', widget_post_masonry_handler );
    } );
} )( jQuery );