@extends('layouts.admin')
@section('page-title')
   {{__('Business Analytics')}}
@endsection
@section('title')
   {{__('Business Analytics')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('business.index') }}">{{__('Business')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Business Analytics')}}</li>
@endsection
@section('content')

<div class="row">
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="float-end">
                    <span class="mb-0 float-right">{{__('Last 15 Days')}}</span>
                </div>
                <h5>{{__('Appointments')}}</h5>
            </div>
            <div class="card-body">
                <div id="apex-storedashborad" data-color="primary" data-height="280"></div>
            </div>
        </div>
    </div>   
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="float-end">
                    <span class="mb-0 text-sm float-right mt-1">{{__('Last 15 Days')}}</span>
                </div>
                <h5 class="mb-0 float-left">{{__('Platform')}}</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                        <div id="user_platform-chart"></div>
                </div>
            </div>
        </div>
    </div> 
</div>    
<div class="row">
    <div class="col-xl-6 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-header">
                <div class="float-end">
                    <span class="mb-0 text-sm float-right mt-1">{{__('Last 15 Days')}}</span>
                </div>
                <h5 class="mb-0 float-left">{{__('Device Analytics')}}</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                        <div id="pie-storedashborad"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-header">
                <div class="float-end">
                    <span class="mb-0 text-sm float-right mt-1">{{__('Last 15 Days')}}</span>
                </div>
                <h5 class="mb-0 float-left">{{__('Browser Analytics')}}</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                        <div id="pie-storebrowser"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 col-sm-6">
        
    </div>            
</div>

@endsection
@push('custom-scripts')
    <script src="{{ asset('custom/js/purpose.js') }}"></script>
    <script>
        (function () {
        var options = {
            chart: {
                height: 350,
                type: 'line',
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
            series : {!! json_encode($chartData['data']) !!},
            xaxis: {labels: {format: "MMM", style: {colors: PurposeStyle.colors.gray[600], fontSize: "14px", fontFamily: PurposeStyle.fonts.base, cssClass: "apexcharts-xaxis-label"}}, axisBorder: {show: !1}, axisTicks: {show: !0, borderType: "solid", color: PurposeStyle.colors.gray[300], height: 6, offsetX: 0, offsetY: 0}, type: "text", categories: {!! json_encode($chartData['label']) !!}},
            yaxis: {labels: {style: {color: PurposeStyle.colors.gray[600], fontSize: "12px", fontFamily: PurposeStyle.fonts.base}}, axisBorder: {show: !1}, axisTicks: {show: !0, borderType: "solid", color: PurposeStyle.colors.gray[300], height: 6, offsetX: 0, offsetY: 0}},

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
            // markers: {
            //     size: 4,
            //     colors: ['#ffa21d', '#FF3A6E'],
            //     opacity: 0.9,
            //     strokeWidth: 2,
            //     hover: {
            //         size: 7,
            //     }
            // },
        };
        var chart = new ApexCharts(document.querySelector("#apex-storedashborad"), options);
        chart.render();
    })();
        var options = {
            chart: {
                height: 200,
                type: 'donut',
            },
            dataLabels: {
                enabled: true,
            },
            series: {!! json_encode($devicearray['data']) !!},
            colors: ["#CECECE", '#ffa21d', '#FF3A6E', '#3ec9d6'],
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
                height:200,
                type: 'donut',
            },
            dataLabels: {
                enabled: true,
            },
            series: {!! json_encode($browserarray['data']) !!},
            colors: ["#CECECE", '#ffa21d', '#FF3A6E', '#3ec9d6'],
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
        var WorkedHoursChart = (function () {
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
                            text: '{{__('Platform')}}'
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
                setTimeout(function () {
                    chart.render();
                }, 300);
            }
            // Events
            if ($chart.length) {
                $chart.each(function () {
                    init($(this));
                });
            }
        })();
    </script>
@endpush

