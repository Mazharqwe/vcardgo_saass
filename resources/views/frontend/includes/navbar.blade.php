<header id="pxl-header-elementor" class="is-sticky">
    @php
            $logo = asset(Storage::url('uploads/logo/'));
    @endphp
    <div class="pxl-header-elementor-main px-header--transparent">
        <div class="pxl-header-content">
            <div class="row">
                <div class="col-12">
                    <div data-elementor-type="wp-post" data-elementor-id="3165"
                        class="elementor elementor-3165">
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-d035d05 elementor-section-stretched elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-bg-color-none pxl-section-overlay-none"
                            data-id="d035d05" data-element_type="section"
                            data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}"
                            style="width: 1349px; left: 0px;">
                            <div class="elementor-container elementor-column-gap-extended ">
                                <div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-8da9388 pxl-column-none"
                                    data-id="8da9388" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-d5b3640 elementor-widget elementor-widget-pxl_logo"
                                            data-id="d5b3640" data-element_type="widget"
                                            data-widget_type="pxl_logo.default">
                                            <div class="elementor-widget-container">
                                                <div class="pxl-logo " data-wow-delay="ms"> <a
                                                        href="https://demo.bravisthemes.com/sasnio/">
                                                        @if ($settings['cust_darklayout'] == 'on')
                                                        <img class="logo img-fluid"
                                                            src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo_1.jpg') . '?' . time() }}"
                                                            alt="" loading="lazy" />
                                                    @else
                                                        <img class="logo"
                                                            src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo_2.jpg') . '?' . time() }}"
                                                            alt="" loading="lazy" />
                                                    @endif 
                                                        </a>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-8633032 pxl-column-none"
                                    data-id="8633032" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-a91f000 elementor-widget elementor-widget-pxl_menu"
                                            data-id="a91f000" data-element_type="widget"
                                            data-widget_type="pxl_menu.default">
                                            <div class="elementor-widget-container">
                                                <div
                                                    class="pxl-nav-menu pxl-nav-menu1 fr-style-default show-effect-slideup sub-style-default">
                                                    <div class="menu-main-menu-container">
                                                        <ul id="menu-main-menu"
                                                            class="pxl-menu-primary clearfix">
                                                            <li id="menu-item-48"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-17 current_page_item pxl-megamenu menu-item-has-children menu-item-48">
                                                                <a href="https://demo.bravisthemes.com/sasnio/"
                                                                    aria-current="page"><span>Home<i
                                                                            class=" pxl-hide"></i></span></a>
                                                           
                                                            </li>
                                                            <li id="menu-item-61"
                                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-61">
                                                                <a
                                                                    href="https://demo.bravisthemes.com/sasnio/#"><span>Pages<i
                                                                            class=" pxl-hide"></i></span></a>
                                                            </li>
                                                            <li id="menu-item-64"
                                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-64">
                                                                <a
                                                                    href="https://demo.bravisthemes.com/sasnio/#"><span>Projects<i
                                                                            class=" pxl-hide"></i></span></a>
                                                            
                                                            </li>
                                                            <li id="menu-item-55"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-55">
                                                                <a
                                                                    href="https://demo.bravisthemes.com/sasnio/our-service/"><span>Services<i
                                                                            class=" pxl-hide"></i></span></a>
                                                             
                                                            </li>
                                                            <li id="menu-item-52"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-52">
                                                                <a
                                                                    href="https://demo.bravisthemes.com/sasnio/blog-standard/"><span>News<i
                                                                            class=" pxl-hide"></i></span></a>
                                                             
                                                            </li>
                                                            <li id="menu-item-46"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-46">
                                                                <a
                                                                    href="https://demo.bravisthemes.com/sasnio/contact-us/"><span>Contact<i
                                                                            class=" pxl-hide"></i></span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-aaa0d77 pxl-column-none"
                                    data-id="aaa0d77" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-f823597 elementor-widget__width-auto elementor-widget elementor-widget-pxl_icon_hidden_panel"
                                            data-id="f823597" data-element_type="widget"
                                            data-widget_type="pxl_icon_hidden_panel.default">
                                            <div class="elementor-widget-container">
                                                <div
                                                    class="pxl-hidden-panel-button pxl-anchor-button1 pxl-cursor--cta">
                                                    <ul class="pxl-button-sidebar">
                                                        <li class="pxl-icon-line pxl-icon-line1"><span></span>
                                                        </li>
                                                        <li class="pxl-icon-line pxl-icon-line2"><span></span>
                                                        </li>
                                                        <li class="pxl-icon-line pxl-icon-line3"><span></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="elementor-element elementor-element-a15875f elementor-widget__width-auto elementor-widget elementor-widget-pxl_button"
                                            data-id="a15875f" data-element_type="widget"
                                            data-widget_type="pxl_button.default">
                                            <div class="elementor-widget-container">
                                                <div id="pxl-pxl_button-a15875f-8024" class="pxl-button "
                                                    data-wow-delay="ms"> <a
                                                        href="{{url('/login')}}"                          class="btn pxl-icon-active btn-nanuk  pxl-icon--left"
                                                        data-wow-delay="ms"> <span class="pxl--btn-text"
                                                            data-text="Sign">
                                                            <span>S</span><span>i</span><span>g</span><span>n</span><span
                                                                class="spacer">&nbsp;</span><span>I</span><span>n</span>
                                                                {{-- <span>a</span><span>r</span><span>t</span><span>e</span><span>d</span> --}}
                                                        </span> </a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pxl-header-elementor-sticky pxl-onepage-sticky pxl-sticky-stt">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div data-elementor-type="wp-post" data-elementor-id="3168"
                        class="elementor elementor-3168">
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-66264cb elementor-section-stretched elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-bg-color-none pxl-section-overlay-none"
                            data-id="66264cb" data-element_type="section"
                            data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}"
                            style="width: 1349px; left: -32px;">
                            <div class="elementor-container elementor-column-gap-extended ">
                                <div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-5e96d50 pxl-column-none"
                                    data-id="5e96d50" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-5a27357 elementor-widget elementor-widget-pxl_logo"
                                            data-id="5a27357" data-element_type="widget"
                                            data-widget_type="pxl_logo.default">
                                            <div class="elementor-widget-container">
                                                <div class="pxl-logo " data-wow-delay="ms"> <a
                                                        href="https://demo.bravisthemes.com/sasnio/"> <img
                                                            width="500" height="138"
                                                            src="{{asset('frontend/assets/images/logo.png')}}"
                                                            class="attachment-full" alt=""> </a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-7dc4885 pxl-column-none"
                                    data-id="7dc4885" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-6898206 elementor-widget elementor-widget-pxl_menu"
                                            data-id="6898206" data-element_type="widget"
                                            data-widget_type="pxl_menu.default">
                                            <div class="elementor-widget-container">
                                                <div
                                                    class="pxl-nav-menu pxl-nav-menu1 fr-style-default show-effect-slideup sub-style-default">
                                                    <div class="menu-main-menu-container">
                                                        <ul id="menu-main-menu-1"
                                                            class="pxl-menu-primary clearfix">
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-17 current_page_item pxl-megamenu menu-item-has-children menu-item-48">
                                                                <a href="https://demo.bravisthemes.com/sasnio/"
                                                                    aria-current="page"><span>Home</span></a>
                                                                <div class="sub-menu pxl-mega-menu">
                                                                    <div class="pxl-mega-menu-elementor">
                                                                        <div data-elementor-type="wp-post"
                                                                            data-elementor-id="3558"
                                                                            class="elementor elementor-3558">
                                                                            <section
                                                                                class="elementor-section elementor-top-section elementor-element elementor-element-e8b64da elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-bg-color-none pxl-section-overlay-none"
                                                                                data-id="e8b64da"
                                                                                data-element_type="section">
                                                                                <div
                                                                                    class="elementor-container elementor-column-gap-default ">
                                                                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-31eb720 pxl-column-none"
                                                                                        data-id="31eb720"
                                                                                        data-element_type="column">
                                                                                        <div
                                                                                            class="elementor-widget-wrap elementor-element-populated">
                                                                                            <div class="elementor-element elementor-element-e41a1cc elementor-widget elementor-widget-pxl_showcase_grid"
                                                                                                data-id="e41a1cc"
                                                                                                data-element_type="widget"
                                                                                                data-widget_type="pxl_showcase_grid.default">
                                                                                                <div
                                                                                                    class="elementor-widget-container">
                                                                                                    <div
                                                                                                        class="pxl-grid pxl-showcase-grid pxl-showcase-grid1">
                                                                                                        <div class="pxl-grid-inner pxl-grid-masonry row"
                                                                                                            data-gutter="15"
                                                                                                            style="height: 384.266px;">
                                                                                                            <div
                                                                                                                class="grid-sizer col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                                                                            </div>
                                                                                                            <div class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"
                                                                                                                style="position: absolute; left: 0%; top: 0px;">
                                                                                                                <div
                                                                                                                    class="pxl-item--inner ">
                                                                                                                    <div
                                                                                                                        class="pxl-item--dots">
                                                                                                                        <span></span>
                                                                                                                        <span></span>
                                                                                                                        <span></span>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="pxl-item--image">
                                                                                                                        <img width="1200"
                                                                                                                            height="900"
                                                                                                                            src="{{asset('frontend/assets/images/image-home01.jpg')}}"
                                                                                                                            class="no-lazyload attachment-full"
                                                                                                                            alt="">
                                                                                                                        <div
                                                                                                                            class="pxl-item--buttons">
                                                                                                                            <div
                                                                                                                                class="pxl-item--button">
                                                                                                                                <a class="btn btn-primary"
                                                                                                                                    href="https://demo.bravisthemes.com/sasnio/">
                                                                                                                                    Multipage
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                            <div
                                                                                                                                class="pxl-item--button">
                                                                                                                                <a class="btn btn-primary"
                                                                                                                                    href="https://demo.bravisthemes.com/sasnio/home-01-one-page/">
                                                                                                                                    Onepage
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <h5
                                                                                                                        class="pxl-item--title">
                                                                                                                        <a
                                                                                                                            href="https://demo.bravisthemes.com/sasnio/">Home
                                                                                                                            01</a>
                                                                                                                    </h5>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"
                                                                                                                style="position: absolute; left: 33.3325%; top: 0px;">
                                                                                                                <div
                                                                                                                    class="pxl-item--inner ">
                                                                                                                    <div
                                                                                                                        class="pxl-item--dots">
                                                                                                                        <span></span>
                                                                                                                        <span></span>
                                                                                                                        <span></span>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="pxl-item--image">
                                                                                                                        <img width="1200"
                                                                                                                            height="900"
                                                                                                                            src="{{asset('frontend/assets/images/image-home2.png')}}"
                                                                                                                            class="no-lazyload attachment-full"
                                                                                                                            alt="">
                                                                                                                        <div
                                                                                                                            class="pxl-item--buttons">
                                                                                                                            <div
                                                                                                                                class="pxl-item--button">
                                                                                                                                <a class="btn btn-primary"
                                                                                                                                    href="https://demo.bravisthemes.com/sasnio/home-02/">
                                                                                                                                    Multipage
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                            <div
                                                                                                                                class="pxl-item--button">
                                                                                                                                <a class="btn btn-primary"
                                                                                                                                    href="https://demo.bravisthemes.com/sasnio/home-02-one-page/">
                                                                                                                                    Onepage
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <h5
                                                                                                                        class="pxl-item--title">
                                                                                                                        <a
                                                                                                                            href="https://demo.bravisthemes.com/sasnio/home-02/">Home
                                                                                                                            02</a>
                                                                                                                    </h5>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"
                                                                                                                style="position: absolute; left: 66.6651%; top: 0px;">
                                                                                                                <div
                                                                                                                    class="pxl-item--inner ">
                                                                                                                    <div
                                                                                                                        class="pxl-item--dots">
                                                                                                                        <span></span>
                                                                                                                        <span></span>
                                                                                                                        <span></span>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="pxl-item--image">
                                                                                                                        <img width="1200"
                                                                                                                            height="900"
                                                                                                                            src="{{asset('frontend/assets/images/image-home3.png')}}"
                                                                                                                            class="no-lazyload attachment-full"
                                                                                                                            alt="">
                                                                                                                        <div
                                                                                                                            class="pxl-item--buttons">
                                                                                                                            <div
                                                                                                                                class="pxl-item--button">
                                                                                                                                <a class="btn btn-primary"
                                                                                                                                    href="https://demo.bravisthemes.com/sasnio/home-03/">
                                                                                                                                    Multipage
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                            <div
                                                                                                                                class="pxl-item--button">
                                                                                                                                <a class="btn btn-primary"
                                                                                                                                    href="https://demo.bravisthemes.com/sasnio/home-03-one-page/">
                                                                                                                                    Onepage
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <h5
                                                                                                                        class="pxl-item--title">
                                                                                                                        <a
                                                                                                                            href="https://demo.bravisthemes.com/sasnio/home-03/">Home
                                                                                                                            03</a>
                                                                                                                    </h5>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-64">
                                                                <a
                                                                    href="https://demo.bravisthemes.com/sasnio/#"><span>Projects</span></a>
                                                                <ul class="sub-menu">
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-53">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/our-projects-01/"><span>Our
                                                                                Projects 01<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-54">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/our-projects-02/"><span>Our
                                                                                Projects 02<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-portfolio menu-item-714">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/portfolio/innovative-digital-campaigns/"><span>Projects
                                                                                Details 01<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-portfolio menu-item-928">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/portfolio/fastest-growing-business-companies/"><span>Projects
                                                                                Details 02<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-55">
                                                                <a
                                                                    href="https://demo.bravisthemes.com/sasnio/our-service/"><span>Services<i
                                                                            class=" pxl-hide"></i></span></a>
                                                                <ul class="sub-menu">
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-63">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/our-service/"><span>Our
                                                                                Services<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-service menu-item-1728">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/service/cloud-services/"><span>Service
                                                                                Details<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-52">
                                                                <a
                                                                    href="https://demo.bravisthemes.com/sasnio/blog-standard/"><span>News<i
                                                                            class=" pxl-hide"></i></span></a>
                                                                <ul class="sub-menu">
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3124">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/blog-grid-01/"><span>Blog
                                                                                Grid 01<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3126">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/blog-grid-02/"><span>Blog
                                                                                Grid 02<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3125">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/blog-grid-03/"><span>Blog
                                                                                Grid 03<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-62">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/blog-standard/"><span>Blog
                                                                                Standard<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                    <li
                                                                        class="menu-item menu-item-type-post_type menu-item-object-post menu-item-230">
                                                                        <a
                                                                            href="https://demo.bravisthemes.com/sasnio/2023/09/27/business-people-working-together-for-grow-our-company/"><span>Blog
                                                                                Details<i
                                                                                    class=" pxl-hide"></i></span></a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-46">
                                                                <a
                                                                    href="https://demo.bravisthemes.com/sasnio/contact-us/"><span>Contact<i
                                                                            class=" pxl-hide"></i></span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-db9d3f1 pxl-column-none"
                                    data-id="db9d3f1" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-80a3f67 elementor-widget__width-auto elementor-widget elementor-widget-pxl_icon_hidden_panel"
                                            data-id="80a3f67" data-element_type="widget"
                                            data-widget_type="pxl_icon_hidden_panel.default">
                                            <div class="elementor-widget-container">
                                                <div
                                                    class="pxl-hidden-panel-button pxl-anchor-button1 pxl-cursor--cta">
                                                    <ul class="pxl-button-sidebar">
                                                        <li class="pxl-icon-line pxl-icon-line1"><span></span>
                                                        </li>
                                                        <li class="pxl-icon-line pxl-icon-line2"><span></span>
                                                        </li>
                                                        <li class="pxl-icon-line pxl-icon-line3"><span></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="elementor-element elementor-element-20a831c elementor-widget__width-auto elementor-widget elementor-widget-pxl_button"
                                            data-id="20a831c" data-element_type="widget"
                                            data-widget_type="pxl_button.default">
                                            <div class="elementor-widget-container">
                                                <div id="pxl-pxl_button-20a831c-2687" class="pxl-button "
                                                    data-wow-delay="ms"> <a
                                                        href="https://demo.bravisthemes.com/sasnio/contact-us/"
                                                        class="btn pxl-icon-active btn-nanuk  pxl-icon--left"
                                                        data-wow-delay="ms"> <span class="pxl--btn-text"
                                                            data-text="Let&#39;s Started">
                                                            <span>L</span><span>e</span><span>t</span><span>'</span><span>s</span><span
                                                                class="spacer">&nbsp;</span><span>S</span><span>t</span><span>a</span><span>r</span><span>t</span><span>e</span><span>d</span>
                                                        </span> </a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pxl-header-mobile" class="style-inherit">
        <div id="pxl-header-main" class="pxl-header-main">
            <div class="container">
                <div class="row">
                    <div class="pxl-header-branding"> <a href="https://demo.bravisthemes.com/sasnio/"
                            title="Sasnio" rel="home">
                            @if ($settings['cust_darklayout'] == 'on')
                                <img class="logo img-fluid"
                                    src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo_1.jpg') . '?' . time() }}"
                                    alt="" loading="lazy" />
                            @else
                                <img class="logo"
                                    src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo_2.jpg') . '?' . time() }}"
                                    alt="" loading="lazy" />
                            @endif
                            </a></div>
                    <div class="pxl-header-menu">
                        <div class="pxl-header-menu-scroll">
                            <div class="pxl-menu-close pxl-hide-xl pxl-close"></div>
                            <div class="pxl-logo-mobile pxl-hide-xl"> <a
                                    href="https://demo.bravisthemes.com/sasnio/" title="Sasnio" rel="home">
                                    @if ($settings['cust_darklayout'] == 'on')
                                    <img class="logo img-fluid"
                                        src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo_1.jpg') . '?' . time() }}"
                                        alt="" loading="lazy" />
                                @else
                                    <img class="logo"
                                        src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo_2.jpg') . '?' . time() }}"
                                        alt="" loading="lazy" />
                                @endif
                                    </a></div>
                            <div class="pxl-header-mobile-search pxl-hide-xl">
                                <form role="search" method="get" action="https://demo.bravisthemes.com/sasnio/">
                                    <input type="text" placeholder="Search..." name="s" class="search-field">
                                    <button type="submit" class="search-submit"><i
                                            class="caseicon-search"></i></button>
                                </form>
                            </div>
                            <nav class="pxl-header-nav">
                                <ul id="menu-main-menu-2" class="pxl-menu-primary clearfix">
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-17 current_page_item pxl-megamenu menu-item-has-children menu-item-48">
                                        <a href="https://demo.bravisthemes.com/sasnio/"
                                            aria-current="page"><span>Home</span></a>
                                        <div class="sub-menu pxl-mega-menu">
                                            <div class="pxl-mega-menu-elementor">
                                                <div data-elementor-type="wp-post" data-elementor-id="3558"
                                                    class="elementor elementor-3558">
                                                    <section
                                                        class="elementor-section elementor-top-section elementor-element elementor-element-e8b64da elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-bg-color-none pxl-section-overlay-none"
                                                        data-id="e8b64da" data-element_type="section">
                                                        <div
                                                            class="elementor-container elementor-column-gap-default ">
                                                            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-31eb720 pxl-column-none"
                                                                data-id="31eb720" data-element_type="column">
                                                                <div
                                                                    class="elementor-widget-wrap elementor-element-populated">
                                                                    <div class="elementor-element elementor-element-e41a1cc elementor-widget elementor-widget-pxl_showcase_grid"
                                                                        data-id="e41a1cc"
                                                                        data-element_type="widget"
                                                                        data-widget_type="pxl_showcase_grid.default">
                                                                        <div class="elementor-widget-container">
                                                                            <div
                                                                                class="pxl-grid pxl-showcase-grid pxl-showcase-grid1">
                                                                                <div class="pxl-grid-inner pxl-grid-masonry row"
                                                                                    data-gutter="15"
                                                                                    style="height: 0px;">
                                                                                    <div
                                                                                        class="grid-sizer col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                                                    </div>
                                                                                    <div class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"
                                                                                        style="position: absolute;">
                                                                                        <div
                                                                                            class="pxl-item--inner ">
                                                                                            <div
                                                                                                class="pxl-item--dots">
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="pxl-item--image">
                                                                                                <img width="1200"
                                                                                                    height="900"
                                                                                                    src="{{asset('frontend/assets/images/image-home01.jpg')}}"
                                                                                                    class="no-lazyload attachment-full"
                                                                                                    alt="">
                                                                                                <div
                                                                                                    class="pxl-item--buttons">
                                                                                                    <div
                                                                                                        class="pxl-item--button">
                                                                                                        <a class="btn btn-primary"
                                                                                                            href="https://demo.bravisthemes.com/sasnio/">
                                                                                                            Multipage
                                                                                                        </a>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="pxl-item--button">
                                                                                                        <a class="btn btn-primary"
                                                                                                            href="https://demo.bravisthemes.com/sasnio/home-01-one-page/">
                                                                                                            Onepage
                                                                                                        </a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <h5
                                                                                                class="pxl-item--title">
                                                                                                <a
                                                                                                    href="https://demo.bravisthemes.com/sasnio/">Home
                                                                                                    01</a>
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"
                                                                                        style="position: absolute;">
                                                                                        <div
                                                                                            class="pxl-item--inner ">
                                                                                            <div
                                                                                                class="pxl-item--dots">
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="pxl-item--image">
                                                                                                <img width="1200"
                                                                                                    height="900"
                                                                                                    src="{{asset('frontend/assets/images/image-home2.png')}}"
                                                                                                    class="no-lazyload attachment-full"
                                                                                                    alt="">
                                                                                                <div
                                                                                                    class="pxl-item--buttons">
                                                                                                    <div
                                                                                                        class="pxl-item--button">
                                                                                                        <a class="btn btn-primary"
                                                                                                            href="https://demo.bravisthemes.com/sasnio/home-02/">
                                                                                                            Multipage
                                                                                                        </a>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="pxl-item--button">
                                                                                                        <a class="btn btn-primary"
                                                                                                            href="https://demo.bravisthemes.com/sasnio/home-02-one-page/">
                                                                                                            Onepage
                                                                                                        </a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <h5
                                                                                                class="pxl-item--title">
                                                                                                <a
                                                                                                    href="https://demo.bravisthemes.com/sasnio/home-02/">Home
                                                                                                    02</a>
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"
                                                                                        style="position: absolute;">
                                                                                        <div
                                                                                            class="pxl-item--inner ">
                                                                                            <div
                                                                                                class="pxl-item--dots">
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="pxl-item--image">
                                                                                                <img width="1200"
                                                                                                    height="900"
                                                                                                    src="{{asset('frontend/assets/images/image-home3.png')}}"
                                                                                                    class="no-lazyload attachment-full"
                                                                                                    alt="">
                                                                                                <div
                                                                                                    class="pxl-item--buttons">
                                                                                                    <div
                                                                                                        class="pxl-item--button">
                                                                                                        <a class="btn btn-primary"
                                                                                                            href="https://demo.bravisthemes.com/sasnio/home-03/">
                                                                                                            Multipage
                                                                                                        </a>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="pxl-item--button">
                                                                                                        <a class="btn btn-primary"
                                                                                                            href="https://demo.bravisthemes.com/sasnio/home-03-one-page/">
                                                                                                            Onepage
                                                                                                        </a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <h5
                                                                                                class="pxl-item--title">
                                                                                                <a
                                                                                                    href="https://demo.bravisthemes.com/sasnio/home-03/">Home
                                                                                                    03</a>
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                        </div><span class="pxl-menu-toggle"></span>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-61">
                                        <a href="https://demo.bravisthemes.com/sasnio/#"><span>Pages</span></a>
                                        <ul class="sub-menu">
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-43">
                                                <a href="https://demo.bravisthemes.com/sasnio/about-us/"><span>About
                                                        Us</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-56">
                                                <a
                                                    href="https://demo.bravisthemes.com/sasnio/pricing-plans/"><span>Pricing</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-59">
                                                <a href="https://demo.bravisthemes.com/sasnio/team-details/"><span>Team
                                                        Details</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3529">
                                                <a href="https://demo.bravisthemes.com/sasnio/404-error"><span>404
                                                        Error</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-47">
                                                <a
                                                    href="https://demo.bravisthemes.com/sasnio/faqs/"><span>Faqs</span></a>
                                            </li>
                                        </ul><span class="pxl-menu-toggle"></span>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-64">
                                        <a
                                            href="https://demo.bravisthemes.com/sasnio/#"><span>Projects</span></a>
                                        <ul class="sub-menu">
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-53">
                                                <a href="https://demo.bravisthemes.com/sasnio/our-projects-01/"><span>Our
                                                        Projects 01</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-54">
                                                <a href="https://demo.bravisthemes.com/sasnio/our-projects-02/"><span>Our
                                                        Projects 02</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-portfolio menu-item-714">
                                                <a
                                                    href="https://demo.bravisthemes.com/sasnio/portfolio/innovative-digital-campaigns/"><span>Projects
                                                        Details 01</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-portfolio menu-item-928">
                                                <a
                                                    href="https://demo.bravisthemes.com/sasnio/portfolio/fastest-growing-business-companies/"><span>Projects
                                                        Details 02</span></a>
                                            </li>
                                        </ul><span class="pxl-menu-toggle"></span>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-55">
                                        <a
                                            href="https://demo.bravisthemes.com/sasnio/our-service/"><span>Services</span></a>
                                        <ul class="sub-menu">
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-63">
                                                <a href="https://demo.bravisthemes.com/sasnio/our-service/"><span>Our
                                                        Services</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-service menu-item-1728">
                                                <a
                                                    href="https://demo.bravisthemes.com/sasnio/service/cloud-services/"><span>Service
                                                        Details</span></a>
                                            </li>
                                        </ul><span class="pxl-menu-toggle"></span>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-52">
                                        <a
                                            href="https://demo.bravisthemes.com/sasnio/blog-standard/"><span>News</span></a>
                                        <ul class="sub-menu">
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3124">
                                                <a href="https://demo.bravisthemes.com/sasnio/blog-grid-01/"><span>Blog
                                                        Grid 01</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3126">
                                                <a href="https://demo.bravisthemes.com/sasnio/blog-grid-02/"><span>Blog
                                                        Grid 02</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3125">
                                                <a href="https://demo.bravisthemes.com/sasnio/blog-grid-03/"><span>Blog
                                                        Grid 03</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-62">
                                                <a href="https://demo.bravisthemes.com/sasnio/blog-standard/"><span>Blog
                                                        Standard</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-post menu-item-230">
                                                <a
                                                    href="https://demo.bravisthemes.com/sasnio/2023/09/27/business-people-working-together-for-grow-our-company/"><span>Blog
                                                        Details</span></a>
                                            </li>
                                        </ul><span class="pxl-menu-toggle"></span>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-46">
                                        <a
                                            href="https://demo.bravisthemes.com/sasnio/contact-us/"><span>Contact</span></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="pxl-header-menu-backdrop"></div>
                </div>
            </div>
            <div id="pxl-nav-mobile">
                <div class="pxl-nav-mobile-button"><span></span></div>
            </div>
        </div>
    </div>
</header>