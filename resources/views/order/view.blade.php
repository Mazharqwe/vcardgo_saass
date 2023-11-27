
    <div class="row">
        <div class="col-md-4">
            <div class="form-control-label"><b>{{__('Order ID')}}</b></div>
        </div>
        <div class="col-md-6">
            <p class="mb-4">
                {{$order->order_id}}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-control-label"><b>{{__('Plan Name')}}</b></div>
        </div>
        <div class="col-md-6">
            <p class="mb-4">
                {{$order->plan_name}}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-control-label"><b>{{__('Plan Price')}}</b></div>
        </div>
        <div class="col-md-6">
            <p class="mb-4">
                {{$order->price}}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-control-label"><b>{{__('Payment Type')}}</b></div>
        </div>
        <div class="col-md-6">
            <p class="mb-4">
                {{$order->payment_type}}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-control-label"><b>{{__('Payment Status')}}</b></div>
        </div>
        <div class="col-md-6">
            <p class="mb-4">
                {{$order->payment_status}}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-control-label"><b>{{__('Bank Detail')}}</b></div>
        </div>
        <div class="col-md-6">
            <p class="mb-4">
                {!!$bank_detail!!}
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-control-label"><b>{{__('Payment Receipt')}}</b></div>
        </div>
        <div class="col-md-6">
                <a href="{{ asset(Storage::url('bank_receipt')) . '/'.$order->receipt }}" class="btn btn-sm btn-primary mr-2 " download>
                    <i class="ti ti-download"></i>
                </a>
        </div>
    </div>
    
    <div class="modal-footer">
        <a href="{{ route('change.status', [$order->id, 1]) }}"
            class="btn btn-success btn-xs">
            {{__('Approve')}}
        </a>
        <a href="{{ route('change.status', [$order->id, 0]) }}"
            class="btn btn-danger btn-xs">
            {{__('Reject')}}
        </a>
        
    </div>   

