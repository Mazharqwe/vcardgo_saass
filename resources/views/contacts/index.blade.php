@php
    $users = \Auth::user();
    $businesses = App\Models\Business::allBusiness();
    $currantBusiness = $users->currentBusiness();
    $bussiness_id = $users->current_business;
@endphp
@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Contacts') }}</li>
@endsection
@section('page-title')
    {{ __('Contacts') }}
@endsection
@section('title')
    {{ __('Contacts') }}
@endsection
@section('content')
    <style>
        .export-btn {
            float: right;
        }
    </style>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="d-flex align-items-center justify-content-between">
                    {{-- //business Display Start --}}
                    <ul class="list-unstyled">
                        <li class="dropdown dash-h-item drp-language">
                            <a class="dash-head-link dropdown-toggle arrow-none me-0 cust-btn shadow-sm border border-success"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-original-title="{{ __('Select your bussiness') }}">
                                <i class="ti ti-credit-card"></i>
                                <span class="drp-text hide-mob">{{ __(ucfirst($currantBusiness)) }}</span>
                                <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                            </a>
                            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end page-inner-dropdowm">
                                @foreach ($businesses as $key => $business)
                                    <a href="{{ route('business.change', $key) }}" class="dropdown-item">
                                        <i
                                            class="@if ($bussiness_id == $key) ti ti-checks text-primary @elseif($currantBusiness == $business) ti ti-checks text-primary @endif "></i>
                                        <span>{{ ucfirst($business) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    </ul>

                    {{-- //business Display End --}}
                    <button class="csv btn btn-sm btn-primary export-btn mb-3">{{ __('Export') }}</button>
                </div>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-export">
                        <thead>
                            <tr>
                                <th>{{ __('Business Name') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Message') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th id="ignore">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts_deatails as $val)
                                <tr>
                                    <td>{{ $val->business_name }}</td>
                                    <td>{{ $val->name }}</td>
                                    <td>{{ $val->email }}</td>
                                    <td>{{ $val->phone }}</td>
                                    <td style="white-space: normal;width: 500px;">{{ $val->message }}</td>
                                    @if ($val->status == 'pending')
                                        <td><span
                                                class="badge bg-warning p-2 px-3 rounded">{{ ucFirst($val->status) }}</span>
                                        </td>
                                    @else
                                        <td><span
                                                class="badge bg-success p-2 px-3 rounded">{{ ucFirst($val->status) }}</span>
                                        </td>
                                    @endif
                                    <div class="row ">
                                        <td class="d-flex">
                                            @can('delete contact')
                                                <div class="action-btn bg-danger ms-2">
                                                    <a href="#"
                                                        class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $val->id }}"
                                                        title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"><span class="text-white"><i
                                                                class="ti ti-trash"></i></span></a>
                                                </div>
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['contacts.destroy', $val->id],
                                                    'id' => 'delete-form-' . $val->id,
                                                ]) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                            @can('edit contact')
                                                <div class="action-btn bg-success  ms-2">
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center cp_link"
                                                        data-toggle="modal" data-target="#commonModal" data-ajax-popup="true"
                                                        data-size="lg" data-url="{{ route('contact.add-note', $val->id) }}"
                                                        data-title="{{ __('Add Note & Change Status') }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('Add Note & Change Status') }}"> <span
                                                            class="text-white"><i class="ti ti-note"></i></span></a>
                                                </div>
                                            @endcan
                                        </td>

                                    </div>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
    <script>
        const table = new simpleDatatables.DataTable("#pc-dt-export", {
            searchable: true,
            fixedheight: true,
            dom: 'Bfrtip',
        });
        $('.csv').on('click', function() {
            $('#ignore').remove();
            $("#pc-dt-export").table2excel({
                filename: "contactDetail"
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        });
    </script>
@endpush
