<div class="form-control-label">{{__('Bussiness Card')}} : </div>
    <p class="text-muted mb-4">
        {{$ad->getBussinessName()}}
    </p>
    <div class="form-control-label">{{__('Name')}} </div>
    <p class="text-muted mb-4">
        {{$ad->name}}
    </p>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="form-control-label">{{__('Email')}} </div>
            <p class="text-muted mb-4">
                {{$ad->email}}
            </p>
        </div>
        <div class="col-md-6">
            <div class="form-control-label">{{__('Phone')}} </div>
            <p class="text-muted mb-4">
                {{$ad->phone}}
            </p>
        </div>
        <div class="col-md-6">
            <div class="form-control-label">{{__('Date')}}</div>
            <p class="mt-1">{{$ad->date}}</p>
        </div>
        <div class="col-md-6">
            <div class="form-control-label">{{__('Time')}}</div>
            <p class="mt-1">{{$ad->time}}</p>
        </div>
    </div>
</div>