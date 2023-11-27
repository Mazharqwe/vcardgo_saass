@extends('layouts.admin')
@section('page-title')
    {{ __('Permission') }}
@endsection
@section('title')
    {{ __('Permission') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Permission') }}</li>
@endsection
@section('action-btn')
@can('create permission')
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
    data-bs-placement="top">
    <a href="#" data-size="md" data-url="{{ route('permissions.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Permission')}}" class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i>
    </a>
    </div>
@endcan
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="dataTable">
                                <thead>
                                <tr>
                                    <th> {{__('Permissions')}}</th>
                                    <th class="text-right" width="200px"> {{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td class="action">
                                            @can('edit permission')
                                            <div class="action-btn bg-info  ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-toggle="modal" data-target="#commonModal" data-ajax-popup="true" data-size="md" data-url="{{ route('permissions.edit',$permission->id) }}" data-title="{{__('Permission Edit')}}" data-bs-toggle="tooltip" data-bs-original-title="{{__('Permission Edit')}}"> <span class="text-white"><i
                                                    class="ti ti-edit text-white    "></i></span></a>
                                            </div> 
                                            @endcan 
                                            @can('delete permission')
                                            <div class="action-btn bg-danger ms-2">
                                                <a href="#"
                                                    class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-confirm="{{ __('Are You Sure?') }}"
                                                    data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="delete-form-{{$permission->id}}"
                                                    title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"><span class="text-white"><i
                                                            class="ti ti-trash"></i></span></a>
                                            </div>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id],'id'=>'delete-form-'.$permission->id]) !!}
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
        </div>
    </section>
@endsection
