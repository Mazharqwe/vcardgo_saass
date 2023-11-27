@extends('layouts.admin')
@section('page-title')
    {{ __('Role') }}
@endsection
@section('title')
    {{ __('Role') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Role') }}</li>
@endsection
@section('action-btn')
    @can('create role')
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
        data-bs-placement="top">
        <a href="#" data-size="lg" data-url="{{ route('roles.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Role')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
    @endcan
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{__('Role')}}</li>
@endsection
@section('content')
    
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style ">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <th>{{__('Role')}} </th>
                            <th>{{__('Permissions')}} </th>
                            <th width="200px">{{__('Action')}} </th>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ ucfirst($role->name)}}</td>
                                <td style="white-space: normal;" width="100%">
                                    @foreach($role->permissions()->pluck('name') as $permissionName)
                                        <span class="badge rounded p-2 m-1 px-3 bg-primary">{{$permissionName}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @can('edit role')
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center " data-url="{{ route('roles.edit',$role->id) }}" data-size="lg" data-ajax-popup="true"  data-title="{{__('Update Role')}}" title="{{__('Update')}}" data-bs-toggle="tooltip" data-bs-placement="top"><span class="text-white"><i class="ti ti-edit text-white"></i></span></a>
                                        </div>
                                    @endcan
                                    @can('delete role')
                                        <div class="action-btn bg-danger ms-2">
                                            <a href="#" class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{$role->id}}"
                                            title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top"><span class="text-white"><i
                                                    class="ti ti-trash"></i></span></a>
                                        </div>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id],'id'=>'delete-form-'.$role->id]) !!}
                                        {!! Form::close() !!}
                                    @endcan
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

@push('script-page')


@endpush