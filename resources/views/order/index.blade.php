@extends('layouts.admin')
@php
    $admin_payment_setting = Utility::getAdminPaymentSetting();
@endphp
@section('page-title')
    {{__('Order')}}
@endsection
@section('title')
    {{__('Order')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{__('Order')}}</li>
@endsection
@section('content')
<div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{__('Order Id')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Plan Name')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('Payment Type')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Coupon')}}</th>
                                <th class="text-center">{{__('Invoice')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                               
                                <tr>
                                  <td>{{$order->order_id}}</td>
                                    <td>{{$order->created_at->format('d M Y')}}</td>
                                    <td>{{$order->user_name}}</td>
                                    <td>{{$order->plan_name}}</td>
                                    <td>{{isset($admin_payment_setting['CURRENCY_SYMBOL']) ? $admin_payment_setting['CURRENCY_SYMBOL'] : '$'}}{{$order->price}}</td>
                                    <td>{{$order->payment_type}}</td>
                                    <td>
                                        @if($order->payment_status == 'succeeded')
                                            <i class="mdi mdi-circle text-success"></i> {{ucfirst($order->payment_status)}}
                                        @else
                                            <i class="mdi mdi-circle text-danger"></i> {{ucfirst($order->payment_status)}}
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if(!empty($order->total_coupon_used) && !empty($order->total_coupon_used->coupon_detail))
                                            {{ $order->total_coupon_used->coupon_detail->code }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if($order->receipt != 'free coupon' && $order->payment_type != 'STRIPE')
                                            <a href="{{$order->receipt}}" title="Invoice" target="_blank" class="">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        @elseif($order->payment_type == 'Bank Transfer')
                                            @php
                                                 $thumbnail = !empty($order->receipt) ? '' . $order->receipt : '';
                                            @endphp
                                            
                                            <a href="{{ \App\Models\Utility::get_file('bank_receipt/'.$thumbnail) }}" title="Invoice" target="_blank" class="">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        @elseif($order->receipt == 'free coupon')
                                            <p>{{__('Used 100 % discount coupon code.')}}</p>
                                        @elseif($order->payment_type == 'Manually')
                                            <p>{{__('Manually plan upgraded by super admin')}}</p>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_status == 'pending' && $order->payment_type == 'Bank Transfer')
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center " data-url="{{ route('view.status.bank',$order->id) }}" data-size="md" data-ajax-popup="true"  data-title="{{__('Change Status')}}" title="{{__('Status')}}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <span class="text-white"><i class="ti ti-caret-right text-white"></i></span></a>
                                        </div>
                                        @endif
                                        <div class="action-btn bg-danger ms-2">
                                            <a href="#" class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{$order->id}}"
                                            title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top"><span class="text-white"><i
                                                    class="ti ti-trash"></i></span></a>
                                        </div>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['order.destory', $order->id],'id'=>'delete-form-'.$order->id]) !!}
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

