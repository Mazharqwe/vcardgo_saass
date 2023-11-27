@extends('layouts.admin')
@section('page-title')
    {{__('Plan Request')}}
@endsection
@section('title')
    {{__('Plan Request')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{__('Plan Request')}}</li>
@endsection
@section('content')
<div class="col-xl-12">
        <div class="card">
            <div class=" card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('User Name') }}</th>
                                <th>{{ __('Plan Name') }}</th>
                                <th>{{ __('Business') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($plan_requests->count() > 0)
                                @foreach($plan_requests as $prequest)
                                <tr>
                                  <tr>
                                        <td>
                                            <div class="font-style font-weight-bold">{{ $prequest->user->name }}</div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold">{{ $prequest->plan->name }}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ $prequest->plan->business }}</div>
                                            <div>{{__('Business')}}</div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold">{{ $prequest->duration }}</div>
                                        </td>
                                        <td>{{ \App\Models\Utility::getDateFormated($prequest->created_at,true) }}</td>
                                        <td>
                                            <div>
                                                <a href="{{route('response.request',[$prequest->id,1])}}" data-bs-placement="top" data-bs-toggle="tooltip"
 data-bs-original-title="{{__('Accept')}}" class="btn btn-success btn-xs">
                                                    <i class="ti ti-check"></i>
                                                </a>
                                                <a data-bs-placement="top" data-bs-toggle="tooltip"
 data-bs-original-title="{{__('Reject')}}" href="{{route('response.request',[$prequest->id,0])}}" class="btn btn-danger btn-xs">
                                                    <i class="ti ti-x"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                   
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <th scope="col" colspan="7"><h6 class="text-center p-4">{{__('No Manually Plan Request Found.')}}</h6></th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
@endsection


