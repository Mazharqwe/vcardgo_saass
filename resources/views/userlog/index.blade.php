@extends('layouts.admin')
@section('page-title')
    {{ __('Userlog') }}
@endsection
@section('title')
    {{ __('Userlog') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Userlog') }}</li>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{__('Userlog')}}</li>
@endsection
@push('css-page')

@endpush
@section('content')
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class=" mt-2 " id="multiCollapseExample1" style="">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['userlogs.index'], 'method' => 'get', 'id' => 'userlog_filter']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('month', __('Month'), ['class' => 'form-label']) }}
                                <input type="month" name="month" class="form-control" value="{{ isset($_GET['month']) ? $_GET['month'] : '' }}" placeholder ="">
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('user', __('User'), ['class' => 'form-label']) }}
                                {{ Form::select('user', $userList, isset($_GET['user']) ? $_GET['user'] : '', ['class' => 'form-control select ', 'id' => 'user_id']) }}
                            </div>
                        </div>
                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('userlog_filter').submit(); return false;"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('userlogs.index') }}" class="btn btn-sm btn-danger"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="Reset">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
     </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style ">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <th>{{__('User')}} </th>
                            <th>{{__('Role')}} </th>
                            <th>{{__('Email')}} </th>
                            <th>{{__('Last Login At')}} </th>
                            <th>{{__('IP')}} </th>
                            <th>{{__('Country')}} </th>
                            <th>{{__('OS Name')}} </th>
                            <th>{{__('Device Name')}} </th>
                            <th width="200px">{{__('Action')}} </th>
                        </thead>
                        <tbody>
                        @foreach ($userlogdetail as $userlogs)
                        <?php
                             $json=json_decode($userlogs->details);
                        ?>
                            <tr>
                                <td>{{ ucfirst($userlogs->name) }}</td>
                                <td><span class="badge rounded p-2 m-1 px-3 bg-primary">{{ ucfirst($userlogs->type)}}</span></td>
                                <td>{{ $userlogs->email }}</td>
                                <td>{{ $userlogs->date }}</td>
                                <td>{{ $userlogs->ip }}</td>
                                <td>{{ $json->country }}</td>
                                <td>{{ $json->os_name }}</td>
                                <td>{{ $json->device_type }}</td>
                                <td>
                                    <div class="action-btn bg-secondary ms-2">
                                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center " data-url="{{ route('userlogs.show',$userlogs->id) }}" data-size="lg" data-ajax-popup="true"  data-title="{{__('View UserLog')}}" title="{{__('View')}}" data-bs-toggle="tooltip" data-bs-placement="top"><span class="text-white"><i class="ti ti-eye text-white"></i></span></a>
                                    </div>
                                    <div class="action-btn bg-danger ms-2">
                                        <a href="#" class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{$userlogs->id}}"
                                        title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top"><span class="text-white"><i
                                                class="ti ti-trash"></i></span></a>
                                    </div>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['userlogs.destroy', $userlogs->id],'id'=>'delete-form-'.$userlogs->id]) !!}
                                    {!! Form::close() !!}
                                </td>
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

@endpush