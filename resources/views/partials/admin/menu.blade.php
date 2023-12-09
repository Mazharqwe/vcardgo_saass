@php
    $users = \Auth::user();
    $profile = \App\Models\Utility::get_file('uploads/avatar');
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $company_logo = Utility::getValByName('company_logo');
    $company_small_logo = Utility::getValByName('company_small_logo');
    $currantLang = $users->currentLanguage();
    $fullLang = cache()->remember('full_language_data_' . $currantLang, now()->addHours(24), function () use ($currantLang) {
    return \App\Models\Languages::languageData($currantLang);
    });
    $languages = Utility::languages();
    
    $businesses = App\Models\Business::allBusiness();
    $currantBusiness = $users->currentBusiness();
    //$bussiness_id = !empty($users->current_business)?$users->current_business:'';
    $bussiness_id = $users->current_business;
@endphp

<!-- [ Header ] start -->
@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
    <header class="dash-header transprent-bg">
    @else
        <header class="dash-header">
@endif

<div class="header-wrapper">
    <div class="me-auto dash-mob-drp">
        <ul class="list-unstyled">
            <li class="dash-h-item mob-hamburger">
                <a href="#!" class="dash-head-link" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="dropdown dash-h-item drp-company">
                <a class="dash-head-link head-link-profile dropdown-toggle btn-sm arrow-none me-0" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" aria-expanded="false">
                 <span class="theme-avtar avatar avatar-sm rounded-circle">
                     <img src="{{ !empty($users->avatar) ? $profile . '/' . $users->avatar : $profile . '/avatar.png' }}" />
                 </span>
                 <span class="hide-mob ms-2">{{ __('Hi') }}, {{ \Auth::user()->name.' ,'}}</span>
                 <span class="d-block" id="greetings"></span>
                 <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
             </a>
             
                <div class="dropdown-menu dash-h-dropdown">
                    <a href="{{ route('profile') }}" class="dropdown-item">
                        <i class="ti ti-user"></i>
                        <span>{{ __('Profile') }}</span>
                    </a>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        <i class="ti ti-power"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
        <div class="btn-group">
            <button class="btn mx-2  mb-4  btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" style="border-radius:0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-plus me-2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                {{ __('Quick add') }}</button>
            <div class="dropdown-menu">
                @can('create business')
                    <a href="#" data-size="xl" data-url="{{ route('business.create') }}"
                        data-ajax-popup="true" data-title="Create New Business" class="dropdown-item"
                        data-bs-placement="top ">
                        <span>{{ __('Add new Business') }}</span>
                    </a>
                @endcan
                @can('create user')
                    <a href="#" data-size="md" data-url="{{ route('users.create') }}"
                        data-ajax-popup="true" data-title="Create New User" class="dropdown-item"
                        data-bs-placement="top ">
                        <span>{{ __('Add new user') }}</span>
                    </a>
                @endcan
                @can('create role')
                    <a href="#" data-size="lg" data-url="{{ route('roles.create') }}"
                        data-ajax-popup="true" data-title="Create New Role" class="dropdown-item"
                        data-bs-placement="top">
                        <span>{{ __('Add new role') }}</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>
    <ul class="list-unstyled">
        <ul class="list-unstyled">
            <li class="dropdown dash-h-item drp-language">
                <a  class="dash-head-link  head-link-business-creat dropdown-toggle arrow-none me-0 cust-btn  border "
                    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                    aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    data-bs-original-title="{{ __('Select your bussiness') }}" style="border-radius: 0" style="border: 1px solid rgba(206, 206, 206, 0.2)">
                    <i style="color: white !important" class="ti ti-credit-card"></i>
                    <span class="drp-text hide-mob">{{ __(ucfirst($currantBusiness)) }}</span>
                    <i style="color: white !important" class="ti ti-chevron-down drp-arrow nocolor"></i>
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
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dash-head-link-languages dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" aria-expanded="false">
                <i class="text-light ti ti-world nocolor"></i>
                <span class="text-light drp-text hide-mob">{{ ucFirst($fullLang->fullName) }}</span>
                <i class="ti text-light ti-chevron-down drp-arrow nocolor"></i>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                @foreach (App\Models\Utility::languages() as $code => $lang)
                    <a href="{{ route('change.language', $code) }}"
                        class="dropdown-item {{ $currantLang == $code ? 'text-primary' : '' }}">
                        <span>{{ ucFirst($lang) }}</span>
                    </a>
                @endforeach
                <div class="dropdown-divider m-0"></div>
                @if (Auth::user()->type == 'super admin')
                    <a href="#" data-size="md" data-url="{{ route('create.language') }}" data-ajax-popup="true"
                        data-bs-toggle="tooltip" title="{{ __('Create') }}"
                        data-title="{{ __('Create New Language') }}" class="dropdown-item text-primary">
                        {{ __('Create Language') }}
                    </a>
                @endif
                @if (Auth::user()->type == 'super admin')
                    <a class="dropdown-item text-primary"
                        href="{{ route('manage.language', [$currantLang]) }}">{{ __('Manage Language') }}</a>
                @endif
            </div>
            
        </li>
    </ul>
</div>
</header>
<!-- [ Header ] end -->
<script>
    var timezone = '{{ !empty($settings['timezone']) ? $settings['timezone'] : 'IST' }}';

    let today = new Date(new Date().toLocaleString("en-US", {
        timeZone: timezone
    }));
    var curHr = today.getHours()
    var target = document.getElementById("greetings");

    if (curHr < 12) {
        target.innerHTML = "Good Morning";
    } else if (curHr < 17) {
        target.innerHTML = "Good Afternoon";
    } else {
        target.innerHTML = "Good Evening";
    }
</script>
