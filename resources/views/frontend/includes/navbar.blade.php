<header id="pxl-header-elementor" class="is-sticky">
    @php
        $logo = asset(Storage::url('uploads/logo/'));
    @endphp
    <div class="pxl-header-elementor-main px-header--transparent">
        <div class="pxl-header-content">
            <div class="row">
                <div class="col-12">
                    <div data-elementor-type="wp-post" data-elementor-id="3165" class="elementor elementor-3165">
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
                                                <div class="pxl-logo " data-wow-delay="ms"> <a href="#">
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
                                                        <ul id="menu-main-menu" class="pxl-menu-primary clearfix">
                                                            <li id="menu-item-48"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-17 current_page_item pxl-megamenu menu-item-has-children menu-item-48">
                                                                <a href="/" aria-current="page"><span>Home<i
                                                                            class=" pxl-hide"></i></span></a>

                                                            </li>
                                                            <li id="menu-item-61"
                                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-61">
                                                                <a href="#pricing"><span>Pricing<i
                                                                            class=" pxl-hide"></i></span></a>
                                                            </li>
                                                            {{-- <li id="menu-item-64"
                                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-64">
                                                                <a href="#projects"><span>Projects<i
                                                                            class=" pxl-hide"></i></span></a>

                                                            </li> --}}
                                                            <li id="menu-item-55"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-55">
                                                                <a href="#services"><span>Services<i
                                                                            class=" pxl-hide"></i></span></a>

                                                            </li>
                                                         
                                                            <li id="menu-item-46"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-46">
                                                                <a href="#pxl-footer-elementor"><span>Contact<i
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
                                                <div class="pxl-hidden-panel-button pxl-anchor-button1 pxl-cursor--cta">
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
                                                    data-wow-delay="ms"> <a href="{{ url('/login') }}"
                                                        class="btn pxl-icon-active btn-nanuk  pxl-icon--left"
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
    </div> -
    <div id="pxl-header-mobile" class="style-inherit">
        <div id="pxl-header-main" class="pxl-header-main">
            <div class="container">
                <div class="row">
                    <div class="pxl-header-branding"> <a href="/" title="Sasnio"
                            rel="home">
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
                            <div class="pxl-logo-mobile pxl-hide-xl"> <a href="/"
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
                            <div class="pxl-header-mobile-search pxl-hide-xl">
                                <form role="search" method="get" action="#/">
                                    <input type="text" placeholder="Search..." name="s"
                                        class="search-field">
                                    <button type="submit" class="search-submit"><i
                                            class="caseicon-search"></i></button>
                                </form>
                            </div>
                            <nav class="pxl-header-nav">
                                <ul id="menu-main-menu-2" class="pxl-menu-primary clearfix">
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-17 current_page_item pxl-megamenu menu-item-has-children menu-item-48">
                                        <a href="/"
                                            aria-current="page"><span>Home</span></a>
                                    
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-61">
                                        <a href="#pricing"><span>Pricing</span></a>
                                      
                                    </li>
                                    {{-- <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-64">
                                        <a href="#projects"><span>Projects</span></a>
                                        
                                    </li> --}}
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-55">
                                        <a
                                            href="#services"><span>Services</span></a>
                                 
                                    </li>
                                 
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-46">
                                        <a
                                            href="#pxl-footer-elementor"><span>Contact</span></a>
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
