@php
    $settings = \App\Models\Utility::settings();
@endphp

@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Language') }}
@endsection
@section('title')
    {{ __('Manage Language') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Language') }}</li>
@endsection
@section('action-btn')
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
        @if ($currantLang != (!empty(env('default_language')) ? env('default_language') : 'en'))
            <div class="action-btn bg-danger ms-2">
                <form method="POST" action="{{ route('lang.destroy', $currantLang) }}">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger btn-icon m-1 show_confirm" data-toggle="tooltip"
                        title='Delete'>
                        <span class="text-white"> <i class="ti ti-trash"></i></span>
                    </button>
                </form>
            </div>
        @endif
        @if ($currantLang != (!empty($settings['default_language']) ? $settings['default_language'] : 'en'))
            <div class="form-check form-switch custom-switch-v1 m-2">
                <input type="hidden" name="disable_lang" value="off">
                <input type="checkbox" class="form-check-input input-primary" name="disable_lang" data-bs-placement="top"
                    title="{{ __('Enable/Disable') }}" id="disable_lang" data-bs-toggle="tooltip"
                    {{ !in_array($currantLang, $disabledLang) ? 'checked' : '' }}>
                <label class="form-check-label" for="disable_lang"></label>
            </div>
        @endif
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-2">
            <div class="card sticky-top" style="top:30px">
                <div class="list-group list-group-flush" id="useradd-sidenav">
                    @foreach ($languages as $code => $lang)
                        <a href="{{ route('manage.language', $code) }}"
                            class="list-group-item list-group-item-action border-0 {{ $currantLang == $code ? 'active' : '' }}">
                            {{ ucFirst($lang) }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="p-3 card">
                <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-user-tab-1" data-bs-toggle="pill" data-bs-target="#labels"
                            type="button">{{ __('Labels') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-user-tab-2" data-bs-toggle="pill" data-bs-target="#messages"
                            type="button">{{ __('Messages') }}</button>
                    </li>

                </ul>
            </div>
            <div class="card">
                <div class="card-body p-3">
                    <form method="post" action="{{ route('store.language.data', [$currantLang]) }}">
                        @csrf
                        <div class="tab-content">
                            <div class="tab-pane active" id="labels">
                                <div class="row">
                                    @foreach ($arrLabel as $label => $value)
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label text-dark">{{ $label }}</label>
                                                <input type="text" class="form-control"
                                                    name="label[{{ $label }}]" value="{{ $value }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane" id="messages">
                                @foreach ($arrMessage as $fileName => $fileValue)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h6>{{ ucfirst($fileName) }}</h6>
                                        </div>
                                        @foreach ($fileValue as $label => $value)
                                            @if (is_array($value))
                                                @foreach ($value as $label2 => $value2)
                                                    @if (is_array($value2))
                                                        @foreach ($value2 as $label3 => $value3)
                                                            @if (is_array($value3))
                                                                @foreach ($value3 as $label4 => $value4)
                                                                    @if (is_array($value4))
                                                                        @foreach ($value4 as $label5 => $value5)
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group mb-3">
                                                                                    <label
                                                                                        class="form-label text-dark">{{ $fileName }}.{{ $label }}.{{ $label2 }}.{{ $label3 }}.{{ $label4 }}.{{ $label5 }}</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="message[{{ $fileName }}][{{ $label }}][{{ $label2 }}][{{ $label3 }}][{{ $label4 }}][{{ $label5 }}]"
                                                                                        value="{{ $value5 }}">
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label
                                                                                    class="form-label text-dark">{{ $fileName }}.{{ $label }}.{{ $label2 }}.{{ $label3 }}.{{ $label4 }}</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="message[{{ $fileName }}][{{ $label }}][{{ $label2 }}][{{ $label3 }}][{{ $label4 }}]"
                                                                                    value="{{ $value4 }}">
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <div class="col-lg-6">
                                                                    <div class="form-group mb-3">
                                                                        <label
                                                                            class="form-label text-dark">{{ $fileName }}.{{ $label }}.{{ $label2 }}.{{ $label3 }}</label>
                                                                        <input type="text" class="form-control"
                                                                            name="message[{{ $fileName }}][{{ $label }}][{{ $label2 }}][{{ $label3 }}]"
                                                                            value="{{ $value3 }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-3">
                                                                <label
                                                                    class="form-label text-dark">{{ $fileName }}.{{ $label }}.{{ $label2 }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="message[{{ $fileName }}][{{ $label }}][{{ $label2 }}]"
                                                                    value="{{ $value2 }}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            class="form-label text-dark">{{ $fileName }}.{{ $label }}</label>
                                                        <input type="text" class="form-control"
                                                            name="message[{{ $fileName }}][{{ $label }}]"
                                                            value="{{ $value }}">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-end">
                            <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        $(document).on('change', '#disable_lang', function() {
            var val = $(this).prop("checked");
            if (val == true) {
                var langMode = 'on';
            } else {
                var langMode = 'off';
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('disablelanguage') }}",
                datType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "mode": langMode,
                    "lang": "{{ $currantLang }}"
                },
                success: function(data) {
                    toastrs('{{ __('Success') }}', data.message, 'success');
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            });
        });
    </script>
@endpush
