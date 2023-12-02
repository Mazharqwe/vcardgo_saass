@extends('frontend.layouts.front-layout')

@section('css')
    <style>
        :root {
            --theme-1: linear-gradient(141.55deg, #0CAF60 3.46%, #0CAF60 99.86%), #0CAF60;
            --theme-2: linear-gradient(141.55deg, #584ED2 3.46%, #584ED2 99.86%),
                #584ED2;
            --theme-3: linear-gradient(141.55deg, #6FD943 3.46%, #6FD943 99.86%),
                #6FD943;
            --theme-4: linear-gradient(141.55deg, #145388 3.46%, #145388 99.86%),
                #145388;
            --theme-5: linear-gradient(141.55deg, #B9406B 3.46%, #B9406B 99.86%),
                #B9406B;
            --theme-6: linear-gradient(141.55deg, #008ECC 3.46%, #008ECC 99.86%),
                #008ECC;
            --theme-7: linear-gradient(141.55deg, #922C88 3.46%, #922C88 99.86%),
                #922C88;
            --theme-8: linear-gradient(141.55deg, #C0A145 3.46%, #C0A145 99.86%),
                #C0A145;
            --theme-9: linear-gradient(141.55deg, #48494B 3.46%, #48494B 99.86%),
                #48494B;
            --theme-10: linear-gradient(141.55deg, #0C7785 3.46%, #0C7785 99.86%),
             #0C7785;
             --theme-1-boxshadow: #0CAF60;
             --theme-2-boxshadow: #584ED2;
             --theme-3-boxshadow: #6FD943;
             --theme-4-boxshadow: #145388;
             --theme-5-boxshadow: #B9406B;
             --theme-6-boxshadow: #008ECC;
             --theme-7-boxshadow: #922C88;
             --theme-8-boxshadow: #C0A145;
             --theme-9-boxshadow: #48494B;
             --theme-10-boxshadow: #0C7785;



            
        }

        .theme-1:before {
            background: var(--theme-1);
        }

        .theme-2:before {
            background: var(--theme-2);
        }

        .theme-3:before {
            background: var(--theme-3);
        }

        .theme-4:before {
            background: var(--theme-4);
        }

        .theme-5:before {
            background: var(--theme-5);
        }

        .theme-6:before {
            background: var(--theme-6);
        }

        .theme-7:before {
            background: var(--theme-7);
        }

        .theme-8:before {
            background: var(--theme-8);
        }

        .theme-9:before {
            background: var(--theme-9);
        }

        .theme-10:before {
            background: var(--theme-10);
        }
        .btn-theme-1 {
            color: black;
            background: white;
        }
             .btn-theme-2 {
            color: black;
            background: white;
        } 
            .btn-theme-3 {
            color: black;
            background: white;
        }

        .btn-theme-4 {
            color: black;
            background: white;
        }
        .btn-theme-5 {
            color: black;
            background: white;
        }
             .btn-theme-6 {
            color: black;
            background: white;
        } 
            .btn-theme-7 {
            color: black;
            background: white;
        }

        .btn-theme-8 {
            color: black;
            background: white;
        }

        .btn-theme-9 {
            color: black;
            background: white;
        }

        .btn-theme-10 {
            color: black;
            background: white;
        }

        .pxl-item-icon-theme-1 {
            background: var(--theme-1) !important;
        }

        .pxl-item-icon-theme-2 {
            background: var(--theme-2) !important;
        }

        .pxl-item-icon-theme-3 {
            background: var(--theme-3) !important;

        }
        .pxl-item-icon-theme-4 {
            background: var(--theme-4) !important;
        }
        .pxl-item-icon-theme-5 {
            background: var(--theme-5) !important;
        }
        .pxl-item-icon-theme-6 {
            background: var(--theme-6) !important;
        }
        .pxl-item-icon-theme-7 {
            background: var(--theme-7) !important;
        }
        .pxl-item-icon-theme-8 {
            background: var(--theme-8) !important;
        }
        .pxl-item-icon-theme-9 {
            background: var(--theme-9) !important;
        }
        .pxl-item-icon-theme-10 {
            background: var(--theme-10) !important;
        }

        .pxl-content-theme-1{
            border: 5px solid var(--theme-1);
        }
        .pxl-content-theme-2 {
            border: 5px solid var(--theme-2);
        }
        .pxl-content-theme-3 {
            border: 5px solid var(--theme-3);
        }

        .pxl-content-theme-4 {
            border: 5px solid var(--theme-4);
        }
        .pxl-content-theme-5 {
            border: 5px solid var(--theme-5);
        }
        .pxl-content-theme-6 {
            border: 5px solid var(--theme-6);
        }
        .pxl-content-theme-7 {
            border: 5px solid var(--theme-7);
        }
        .pxl-content-theme-8 {
            border: 5px solid var(--theme-8);
        }
        .pxl-content-theme-9 {
            border: 5px solid var(--theme-9);
        }
        .pxl-content-theme-10 {
            border: 5px solid var(--theme-10);
        }


        .pxl-item--date-theme-1 {
            background: var(--theme-1);
        }
        .pxl-item--date-theme-2 {
            background: var(--theme-2);
        }
        .pxl-item--date-theme-3 {
            background: var(--theme-3);
        }
        .pxl-item--date-theme-4 {
            background: var(--theme-4);
        }
        .pxl-item--date-theme-5 {
            background: var(--theme-5);
        }
        .pxl-item--date-theme-6 {
            background: var(--theme-6);
        }
        .pxl-item--date-theme-7 {
            background: var(--theme-7);
        } 
       .pxl-item--date-theme-8 {
            background: var(--theme-8);
        }
          .pxl-item--date-theme-9 {
            background: var(--theme-9);
        }
        .pxl-item--date-theme-10 {
            background: var(--theme-10);
        }

        #blog-layout3-theme-1:hover:before {
            box-shadow: 0 0 13px var(--theme-1-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-1-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-1-boxshadow) !important;
        }
        #blog-layout3-theme-2:hover:before {
            box-shadow: 0 0 13px var(--theme-2-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-2-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-2-boxshadow) !important;
        }

        #blog-layout3-theme-3:hover:before {
            box-shadow: 0 0 13px var(--theme-3-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-3-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-3-boxshadow) !important;
        }
        #blog-layout3-theme-4:hover:before {
            box-shadow: 0 0 13px var(--theme-4-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-4-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-4-boxshadow) !important;
        }
        #blog-layout3-theme-5:hover:before {
            box-shadow: 0 0 13px var(--theme-5-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-5-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-5-boxshadow) !important;
        }
        #blog-layout3-theme-6:hover:before {
            box-shadow: 0 0 13px var(--theme-6-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-6-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-6-boxshadow) !important;
        }
        #blog-layout3-theme-7:hover:before {
            box-shadow: 0 0 13px var(--theme-7-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-7-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-7-boxshadow) !important;
        }
        #blog-layout3-theme-8:hover:before {
            box-shadow: 0 0 13px var(--theme-8-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-8-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-8-boxshadow) !important;
        }
        #blog-layout3-theme-9:hover:before {
            box-shadow: 0 0 13px var(--theme-9-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-9-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-9-boxshadow) !important;
        }
        #blog-layout3-theme-10:hover:before {
            box-shadow: 0 0 13px var(--theme-10-boxshadow) !important;
            -webkit-box-shadow: 0 0 13px 0 var(--theme-10-boxshadow) !important;
            -moz-box-shadow: 0 0 13px 0 var(--theme-10-boxshadow) !important;
        }

        #footer-theme-1{
            background: var(--theme-4);

        }
        #footer-theme-2{
            background: var(--theme-2);

        }
        #footer-theme-3{
            background: var(--theme-3);

        }

        #footer-theme-4{
            background: var(--theme-4);

        }

        #footer-theme-5{
            background: var(--theme-5);

        }
        #footer-theme-6{
            background: var(--theme-6);

        }
        #footer-theme-7{
            background: var(--theme-7);

        }
        #footer-theme-8{
            background: var(--theme-8);

        }
        #footer-theme-9{
            background: var(--theme-9);

        }

        #footer-theme-10{
            background: var(--theme-10);

        }
        #pxl-text-theme-4{
            color: var(--theme-4) !important;
        }

        .pxl-item--meta-theme-4{
            background: var(--theme-4);
        }
     
    </style>
@endsection
@section('content')
    <div id="theme" class="d-none" data-settings="{{ $settings['color'] }}">
    </div>
    @include('frontend.includes.navbar')
    @include('frontend.components.hero')
    @include('frontend.components.services')
    @include('frontend.components.footer')
@endsection
@include('frontend.includes.jquery')
<script>
    $(document).ready(function() {
        const theme = $("#theme").attr('data-settings');
        const customeTheme = $('#custom-theme');
        let pxlItem = $('.pxl-item--icon');
        let pxlContent = $('.pxl-inner-content');
        let pxlSubtitle = $('.px-sub-title-default');
        let pxlDate = $('.pxl-item--date');
        let blogLayout = $('.blog-layout3 .pxl-item--inner');
        let footer = $('.footer-theme');
        let customebutton = $('.btn');
        let pxlItemText = $('#pxl-content-theme');
        let pxlPricing = $('.pxl-item--meta');


        // Function to add theme classes
        function addThemeClasses(element, className) {
            if (element.length) {
                element.addClass(className);
            }
        }

        // Add theme classes
        addThemeClasses(customeTheme, theme);
        addThemeClasses(customebutton, 'btn-' + theme);
        addThemeClasses(pxlItem, 'pxl-item-icon-' + theme);
        addThemeClasses(pxlContent, 'pxl-content-' + theme);
        addThemeClasses(pxlSubtitle, 'px-sub-title-' + theme);
        addThemeClasses(pxlDate, 'pxl-item--date-' + theme);
        addThemeClasses(blogLayout, 'blog-layout3-' + theme);
        addThemeClasses(pxlPricing, 'pxl-item--meta-'+theme);
        
        
        // Assign unique IDs
        blogLayout.attr('id', 'blog-layout3-' + theme);
        footer.attr('id', 'footer-' + theme);
        pxlItemText.attr('id', 'pxl-text-'+theme);
    });
</script>
