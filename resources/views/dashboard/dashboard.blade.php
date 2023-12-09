@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
    $qr_path = \App\Models\Utility::get_file('qrcode');
    $businesses = App\Models\Business::allBusiness();
    $currantBusiness = $users->currentBusiness();
    $bussiness_id = $users->current_business;
    $settings = Utility::settings();
@endphp
@extends('layouts.admin')
@push('css-page')
    <style>
        .shareqrcode img {
            width: 30%;
            height: 30%;
        }

        .shareqrcode canvas {
            width: 30%;
            height: 30%;
        }
    </style>
@endpush
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('content')
    <div class="row">
        <div class="page-title mb-3">
            <div class="row justify-content-between align-items-center">
                <div class="d-flex col-md-10 mb-3 mb-md-0">
                    <h5 class="h3 mb-0">{{ __('Dashboard') }}</h5>

                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row ">
                @if ($businessData)
                    <div class="col-md-3">
                        <div class="card" style="background: linear-gradient(to right, #fe5d70, #fe909d) !important;">
                            <div class="card-body" style="min-height: 170px; max-height:170px">
                                <h6 class="mb-0 text-center">{{ ucFirst($businessData->title) }}</h6>
                                <div class="mb-3 shareqrcode text-center"></div>
                                <div class="d-flex justify-content-between">
                                    <a href="#!" class="btn btn-sm btn-light-primary w-100 cp_link"
                                        data-link="{{ url('/' . $businessData->slug) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title=""
                                        data-bs-original-title="Click to copy business link">
                                        {{ 'Business Link' }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-copy ms-1">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2">
                                            </rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                    </a>
                                    <a href="#" id="socialShareButton"
                                        class="socialShareButton btn btn-sm p-1 btn-primary ms-1 share-btn">
                                        <i class="ti ti-share"></i>
                                    </a>
                                    <div id="sharingButtonsContainer" class="sharingButtonsContainer"
                                        style="display: none;">
                                        <div class="Demo1 d-flex align-items-center justify-content-center hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-3">
                    <div class="card" style="background: linear-gradient(to right, #0ac282, #0df3a3);">
                        <div class="card-body" style="min-height: 170px;">
                            <div class="row">
                                <div class="col-3">
                                    <div class="theme-avtar bg-light mt-3">
                                        <i class="ti text-dark ti-briefcase dash-micon"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <p class=" text-light text-muted text-sm mt-3 mb-2"></p>
                                    <h6 class=" text-light mb-2">{{ __('Total Business') }}</h6>
                                    <h3 class=" text-light mb-0">{{ $total_bussiness }} </h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="background: linear-gradient(to right, #fe9365, #feb798);">
                        <div class="card-body" style="min-height: 170px;">
                            <div class="row">
                                <div class="col-3">
                                    <div class="theme-avtar bg-light mt-3">
                                        <i class="ti  text-dark ti-clipboard-check dash-micon"></i>
                                    </div>
                                </div>
                                <div class="col-9 ">
                                    <p class=" text-light text-sm mb-2 mt-3"></p>
                                    <h6 class="mb-2 text-light">{{ __('Total Appointments') }}</h6>
                                    <h3 class="mb-0 text-light">{{ $total_app }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" >
                    <div class="card" style="min-height: 170px;background: linear-gradient(to right, #01a9ac, #01dbdf);">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                            <div class="theme-avtar bg-light mt-3">
                                <i class="ti ti-users text-dark dash-micon"></i>
                            </div>
                        </div>
                            <div class="col-9">
                                <p class=" text-light text-muted text-sm mb-2 mt-3"></p>
                                <h6 class=" text-light mb-2">{{ __('Total Staff') }}</h6>
                            <h3 class=" text-light mb-0">{{ $total_staff }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                <div class="col-lg-6 mt-2">
                    <div class="card">
                        <div class="card-header" style="background:#7cccfc">
                            <div class="float-end">
                                <span class="text-light mb-0 float-right">{{ __('Last 7 Days') }}</span>
                            </div>
                            <h5 class="text-light" >{{ __('Appointments') }}</h5>
                        </div>
                        <div class="card-body">
                            <div id="apex-storedashborad" data-color="primary" data-height="280"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2">
                    <div class="card">
                        <div class="card-header" style="background:#7cccfc">
                            <div class="float-end">
                                <span class="text-light mb-0 text-sm float-right mt-1">{{ __('Last 15 Days') }}</span>
                            </div>
                            <h5 class="text-light mb-0 float-left">{{ __('Platform') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div id="user_platform-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 ">
                    <div class="card" style="height: 24rem; ">
                        <div class="card-header" style="background: linear-gradient(to right, #01a9ac, #01dbdf);">
                            <div class="float-end">
                                <span class="text-light mb-0 text-sm float-right mt-1">{{ __('Last 15 Days') }}</span>
                            </div>
                            <h5 class="mb-0 text-light float-left">{{ __('Browser') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div id="pie-storebrowser"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 ">
                    <div class="card" style="height: 24rem; ">
                        <div class="card-header" style="background: linear-gradient(to right, #0ac282, #0df3a3);
                        ">
                            <div class="float-end">
                                <span class="mb-0 text-light text-sm float-right mt-1">{{ __('Last 15 Days') }}</span>
                            </div>
                            <h5 class="mb-0 text-light float-left">{{ __('Device') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div id="pie-storedashborad"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Storage Limit Chart --}}
                @if (\Auth::user()->type == 'company')
                    <div class="col-md-4 ">
                        <div class="card" style="height: 24rem; ">
                            <div class="card-header " style="background: linear-gradient(to right, #fe9365, #feb798);">
                                <h5 class="text-light">{{ __('Storage Status') }} <small>({{ $users->storage_limit . 'MB' }} /
                                        {{ $plan->storage_limit . 'MB' }})</small></h5>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div id="device-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- Storage Limit Chart End --}}
            </div>
        </div>
        <img src="{{ isset($qr_detail->image) ? $qr_path . '/' . $qr_detail->image : '' }}" id="image-buffers"
            style="display: none">
    @endsection

    @push('custom-scripts')
        <script src="{{ asset('custom/js/purpose.js') }}"></script>
        @if (isset($plan->enable_qr_code) && $plan->enable_qr_code == 'on')
            <script src="{{ asset('custom/js/jquery.qrcode.min.js') }}"></script>
        @else
            <script src="{{ asset('custom/js/jquery.qrcode.js') }}"></script>
            <script type="text/javascript" src="https://jeromeetienne.github.io/jquery-qrcode/src/qrcode.js"></script>
        @endif
        <script type="text/javascript">
            $(document).on("change", "select[name='select_card']", function() {
                var b_id = $("select[name='select_card']").val();
                if (b_id == '0') {
                    window.location.href = '{{ url('/dashboard') }}';
                } else {
                    window.location.href = '{{ url('business/analytics') }}/' + b_id;
                }

            });
        </script>
        <script>
            (function() {
                var options = {
                    chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: {!! json_encode($chartData['data']) !!},
                    xaxis: {
                        labels: {
                            format: "MMM",
                            style: {
                                colors: PurposeStyle.colors.gray[600],
                                fontSize: "14px",
                                fontFamily: PurposeStyle.fonts.base,
                                cssClass: "apexcharts-xaxis-label"
                            }
                        },
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !0,
                            borderType: "solid",
                            color: PurposeStyle.colors.gray[300],
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        },
                        type: "text",
                        categories: {!! json_encode($chartData['label']) !!}
                    },
                    yaxis: {
                        labels: {
                            style: {
                                color: PurposeStyle.colors.gray[600],
                                fontSize: "12px",
                                fontFamily: PurposeStyle.fonts.base
                            }
                        },
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !0,
                            borderType: "solid",
                            color: PurposeStyle.colors.gray[300],
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        }
                    },

                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY: -25,
                        offsetX: -5
                    },

                };
                var chart = new ApexCharts(document.querySelector("#apex-storedashborad"), options);
                chart.render();
            })();

            var options = {
                chart: {
                    height: 250,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: true,
                },
                series: {!! json_encode($devicearray['data']) !!},
                colors: ["#6fd943", '#ffa21d', '#FF3A6E', '#3ec9d6'],
                labels: {!! json_encode($devicearray['label']) !!},
                legend: {
                    show: true,
                    position: 'bottom',
                },
            };
            var chart = new ApexCharts(document.querySelector("#pie-storedashborad"), options);
            chart.render();

            var options = {
                chart: {
                    height: 250,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: true,
                },
                series: {!! json_encode($browserarray['data']) !!},
                colors: ["#6fd943", '#ffa21d', '#FF3A6E', '#3ec9d6'],
                labels: {!! json_encode($browserarray['label']) !!},
                legend: {
                    show: true,
                    position: 'bottom',
                },
            };
            var chart = new ApexCharts(document.querySelector("#pie-storebrowser"), options);
            chart.render();
        </script>
        <script>
            var WorkedHoursChart = (function() {
                var $chart = $('#user_platform-chart');

                function init($this) {
                    var options = {
                        chart: {
                            height: 250,
                            type: 'bar',
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false
                            },
                            shadow: {
                                enabled: false,
                            },

                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '30%',
                                borderRadius: 10,
                                dataLabels: {
                                    position: 'top',
                                },
                            }
                        },
                        stroke: {
                            show: true,
                            width: 1,
                            colors: ['#fff']
                        },
                        series: [{
                            name: 'Platform',
                            data: {!! json_encode($platformarray['data']) !!},
                        }],
                        xaxis: {
                            labels: {
                                // format: 'MMM',
                                style: {
                                    colors: PurposeStyle.colors.gray[600],
                                    fontSize: '14px',
                                    fontFamily: PurposeStyle.fonts.base,
                                    cssClass: 'apexcharts-xaxis-label',
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: true,
                                borderType: 'solid',
                                color: PurposeStyle.colors.gray[300],
                                height: 6,
                                offsetX: 0,
                                offsetY: 0
                            },
                            title: {
                                text: '{{ __('Platform') }}'
                            },
                            categories: {!! json_encode($platformarray['label']) !!},
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    color: PurposeStyle.colors.gray[600],
                                    fontSize: '12px',
                                    fontFamily: PurposeStyle.fonts.base,
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: true,
                                borderType: 'solid',
                                color: PurposeStyle.colors.gray[300],
                                height: 6,
                                offsetX: 0,
                                offsetY: 0
                            }
                        },
                        fill: {
                            type: 'solid',
                            opacity: 1

                        },
                        markers: {
                            size: 4,
                            opacity: 0.7,
                            strokeColor: "#fff",
                            strokeWidth: 3,
                            hover: {
                                size: 7,
                            }
                        },
                        grid: {
                            borderColor: PurposeStyle.colors.gray[300],
                            strokeDashArray: 5,
                        },
                        dataLabels: {
                            enabled: false
                        }
                    }
                    // Get data from data attributes
                    var dataset = $this.data().dataset,
                        labels = $this.data().labels,
                        color = $this.data().color,
                        height = $this.data().height,
                        type = $this.data().type;

                    // Inject synamic properties
                    // options.colors = [
                    //     PurposeStyle.colors.theme[color]
                    // ];
                    // options.markers.colors = [
                    //     PurposeStyle.colors.theme[color]
                    // ];
                    options.chart.height = height ? height : 350;
                    // Init chart
                    var chart = new ApexCharts($this[0], options);
                    // Draw chart
                    setTimeout(function() {
                        chart.render();
                    }, 300);
                }

                // Events
                if ($chart.length) {
                    $chart.each(function() {
                        init($(this));
                    });
                }
            })();
        </script>
        {{-- AUTO TOOLTIP FOCUS --}}
        <script>
            $(function() {
                $(".dash-head-link.cust-btn").tooltip().tooltip("show");
                setTimeout(() => {
                    $(".dash-head-link.cust-btn").tooltip().tooltip("hide");

                    $(".cust-btn-creat").tooltip().tooltip("show");
                }, 4000);
            });
            $(function() {
                setTimeout(() => {
                    $(".cust-btn-creat").tooltip().tooltip("hide");
                }, 8000);
            });
        </script>
        <script>
            (function() {
                var options = {
                    series: [{{ number_format($storage_limit, 2) }}],
                    chart: {
                        height: 350,
                        type: 'radialBar',
                        offsetY: -20,
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -90,
                            endAngle: 90,
                            track: {
                                background: "#e7e7e7",
                                strokeWidth: '97%',
                                margin: 5, // margin is in pixels
                            },
                            dataLabels: {
                                name: {
                                    show: true
                                },
                                value: {
                                    offsetY: -50,
                                    fontSize: '20px'
                                }
                            }
                        }
                    },
                    grid: {
                        padding: {
                            top: -10
                        }
                    },
                    colors: ["#000"],
                    labels: ['Used'],
                };
                var chart = new ApexCharts(document.querySelector("#device-chart"), options);
                chart.render();
            })();
        </script>
        <script type="text/javascript">
            $('.cp_link').on('click', function() {
                var value = $(this).attr('data-link');
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(value).select();
                document.execCommand("copy");
                $temp.remove();
                toastrs('{{ __('Success') }}', '{{ __('Link Copy on Clipboard') }}', 'success');
            });
        </script>
        <script>
            $(document).ready(function() {
                @if ($businessData)
                    var slug = '{{ $businessData->slug }}';
                    var url_link = `{{ url('/') }}/${slug}`;

                    $(`.qr-link`).text(url_link);
                    @if (isset($plan->enable_qr_code) && $plan->enable_qr_code == 'on')
                        var foreground_color =
                            `{{ isset($qr_detail->foreground_color) ? $qr_detail->foreground_color : '#000000' }}`;
                        var background_color =
                            `{{ isset($qr_detail->background_color) ? $qr_detail->background_color : '#ffffff' }}`;
                        var radius = `{{ isset($qr_detail->radius) ? $qr_detail->radius : 26 }}`;
                        var qr_type = `{{ isset($qr_detail->qr_type) ? $qr_detail->qr_type : 0 }}`;
                        var qr_font = `{{ isset($qr_detail->qr_text) ? $qr_detail->qr_text : 'vCard' }}`;
                        var qr_font_color =
                            `{{ isset($qr_detail->qr_text_color) ? $qr_detail->qr_text_color : '#f50a0a' }}`;
                        var size = `{{ isset($qr_detail->size) ? $qr_detail->size : 9 }}`;

                        $('.shareqrcode').empty().qrcode({
                            render: 'image',
                            size: 500,
                            ecLevel: 'H',
                            minVersion: 3,
                            quiet: 1,
                            text: url_link,
                            fill: foreground_color,
                            background: background_color,
                            radius: .01 * parseInt(radius, 10),
                            mode: parseInt(qr_type, 10),
                            label: qr_font,
                            fontcolor: qr_font_color,
                            image: $("#image-buffers")[0],
                            mSize: .01 * parseInt(size, 10)
                        });
                    @else
                        $('.shareqrcode').qrcode(url_link);
                    @endif
                @endif
            });
        </script>
        <script>
            var timezone = '{{ !empty($settings['timezone']) ? $settings['timezone'] : 'IST' }}';

            let today = new Date(new Date().toLocaleString("en-US", {
                timeZone: timezone
            }));
            var curHr = today.getHours()
            var target = document.getElementById("greetings");

            if (curHr < 12) {
                target.innerHTML = "Good Morning,";
            } else if (curHr < 17) {
                target.innerHTML = "Good Afternoon,";
            } else {
                target.innerHTML = "Good Evening,";
            }
        </script>

        <script type="text/javascript">
            @if ($businessData)
                $(document).ready(function() {
                    var customURL = {!! json_encode(url('/' . $businessData->slug)) !!};
                    $('.Demo1').socialSharingPlugin({
                        url: customURL,
                        title: $('meta[property="og:title"]').attr('content'),
                        description: $('meta[property="og:description"]').attr('content'),
                        img: $('meta[property="og:image"]').attr('content'),
                        enable: ['whatsapp', 'facebook', 'twitter', 'pinterest', 'linkedin']
                    });

                    $('.socialShareButton').click(function(e) {
                        e.preventDefault();
                        $('.sharingButtonsContainer').toggle();
                    });
                });
            @endif
        </script>
    @endpush
