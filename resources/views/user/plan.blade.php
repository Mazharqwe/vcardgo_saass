@php
    $admin_payment_setting = Utility::getAdminPaymentSetting();
@endphp
<div class="table-responsive">
    <table class="table ">
        <tbody>
        @foreach($plans as $plan)
            <tr>
                <td>
                    <div class="font-style font-weight-bold">{{$plan->name}} ({{$admin_payment_setting['CURRENCY_SYMBOL'] ? $admin_payment_setting['CURRENCY_SYMBOL'] : '$'}}{{$plan->price}}) {{' / '. $plan->duration}}</div>
                </td>
                <td>{{ __('Business') }} : {{ $plan->business }}</td>
                <td>
                    @if($user->plan==$plan->id)
                        <button type="button" class="btn btn-xs btn-soft-success btn-icon">
                            <span class="btn-inner--icon"><i class="fas fa-check"></i></span>
                            <span class="btn-inner--text">{{__('Active')}}</span>
                        </button>
                    @else
                        <div>
                            <a href="{{route('plan.active',[$user->id,$plan->id])}}" class="btn btn-sm btn-primary btn-icon" title="{{ __('Click to Upgrade Plan') }}"><i class="ti ti-shopping-cart"></i> {{ __('Upgrade') }}</a>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
