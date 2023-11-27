@extends('layouts.admin')
@section('page-title')
    {{ __('Calendar') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Calender') }}</li>
@endsection
@section('title')
    {{ __('Calendar') }}
@endsection
    @php
        $settings = App\Models\Utility::settings();
    @endphp
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5>{{__('Calendar')}}</h5>
                        </div>
                        <div class="col-lg-6">
                            @if (isset($settings['Google_Calendar']) && $settings['Google_Calendar'] == 'on')
                                    <select class="form-control" name="is_live" id="is_live"
                                        style="float: right;width: 170px;" onchange="get_data()">
                                        <option value="1">{{ __('Google Calender') }}</option>
                                        <option value="0" selected="true">{{ __('Local Calender') }}</option>
                                    </select>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id='calendar' class='calendar'></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card ">
                <div class="card-body ">
                    <h4 class="mb-4">{{ __('Appointments') }}</h4>
                    <ul class="event-cards list-group list-group-flush mt-3 w-100 ">
                        @foreach ($arrayJson as $appointment)
                            @php
                                $month = date('m', strtotime($appointment['start']));
                            @endphp
                            @if ($month == date('m'))
                                <li class="list-group-item card mb-3">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-auto mb-3 mb-sm-0">
                                            <div class="d-flex align-items-center">
                                                <div class="theme-avtar bg-primary">
                                                    <i class="ti ti-calendar"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="">{{ $appointment['title'] }}</h6>
                                                    <small class="text-muted mt-2">{{ $appointment['start'] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                        <input type="hidden" class="business_id" name="business_id"
                        value="{{ $id }}">
                    </ul>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
@endsection
@push('custom-scripts')
    <script src="{{ asset('custom/libs/moment/min/moment.min.js') }}"></script>
    <script>
        $(document).ready(function()
        {
            get_data();
        });
        function get_data()
        {
            var is_live=$('#is_live :selected').val();
            var id=$(".business_id").val();

            $.ajax({
                url: $("#path_admin").val()+"/get_appointment_data" ,
                method:"POST",
                data: {"id":id,"_token": "{{ csrf_token() }}",'is_live':is_live},
                success: function(data) {
                (function() {
                        var etitle;
                        var etype;
                        var etypeclass;
                        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            buttonText: {
                                timeGridDay: "{{ __('Day') }}",
                                timeGridWeek: "{{ __('Week') }}",
                                dayGridMonth: "{{ __('Month') }}"
                            },
                            slotLabelFormat: {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    hour12: false,
                                },
                            allDaySlot:false,
                            themeSystem: 'bootstrap',
                            // slotDuration: '00:10:00',
                            navLinks: true,
                            droppable: true,
                            selectable: true,
                            selectMirror: true,
                            editable: true,
                            dayMaxEvents: true,
                            handleWindowResize: false,
                            height: 'auto',
                            events: data,
                            eventClick: function(e) {
                                e.jsEvent.preventDefault();
                                var title = e.title;
                                var url = e.el.href;
                                
                                if(is_live==0 || is_live==undefined)
                                {
                                    if (typeof url != 'undefined') {
                                    $("#commonModal .modal-title").html(e.event.title);
                                    $("#commonModal .modal-dialog").addClass('modal-md');
                                    $("#commonModal").modal('show');

                                    $.get(url, {}, function(data) {
                                        $('#commonModal .modal-body ').html(data);
                                    });
                                    return false;
                                    }
                               }
                                
                            }
                        });
                        calendar.render();
                    })();
                }
            });

        }
    </script>
@endpush
