@php
$chatgpt_setting= App\Models\Utility::chatgpt_setting(\Auth::user()->creatorId());
@endphp
{{ Form::open(['url' => 'plans', 'enctype' => 'multipart/form-data']) }}
@if(isset($chatgpt_setting['chatgpt_key']) && (!empty($chatgpt_setting['chatgpt_key'])))
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
        data-bs-placement="top">
        <a href="#" data-size="lg" class="btn btn-sm btn-primary" data-ajax-popup-over="true"
            data-url="{{ route('generate', ['plan']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('Generate') }}" data-title="{{ __('Generate content with AI') }}">
            <i class="fas fa-robot"></i>&nbsp;{{ __('Generate with AI') }}
        </a>
    </div>
@endif
 <div class="row">
     <div class="form-group col-md-6">
         {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
         {{ Form::text('name', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter Plan Name'), 'required' => 'required']) }}
     </div>
     <div class="form-group col-md-6">
         {{ Form::label('price', __('Price'), ['class' => 'form-label']) }}
         {{ Form::number('price', null, ['class' => 'form-control', 'required' => 'required','placeholder' => __('Enter Plan Price')]) }}
     </div>
     <div class="form-group col-md-6">
         {{ Form::label('duration', __('Duration'), ['class' => 'form-label']) }}
         {!! Form::select('duration', $arrDuration, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
     </div>
     <div class="form-group col-md-6">
         {{ Form::label('max_users', __('Max User'), ['class' => 'form-label']) }}
         {{ Form::number('max_users', null, ['class' => 'form-control', 'required' => 'required','placeholder' => __('Enter Max User Create Limite')]) }}
         <span class="small">{{ __('Note: "-1" for Unlimited') }}</span>
     </div>
     <div class="form-group col-md-6">
         {{ Form::label('business', __('Max Business'), ['class' => 'form-label']) }}
         {{ Form::number('business', null, ['class' => 'form-control','required' => 'required', 'placeholder' => __('Enter Max Business Create Limite')]) }}
         <span class="small">{{ __('Note: "-1" for Unlimited') }}</span>
     </div>
     <div class="form-group col-md-6">
        <label for="storage_limit" class="form-label">{{__('Storage limit')}}</label>
        <div class="input-group">
            <input class="form-control" required="required" name="storage_limit" type="number" id="storage_limit">
            <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2">{{__('MB')}}</span>
            </div>
        </div>
        <span class="small">{{__('Note: upload size ( In MB)')}}</span>
    </div>
     <div class="col-6">
         <div class="form-check form-switch custom-switch-v1">
             <input type="checkbox" class="form-check-input input-primary" name="enable_custdomain"
                 id="enable_custdomain">
             <label class="custom-control-label form-control-label"
                 for="enable_custdomain">{{ __('Enable Domain') }}</label>
         </div>
     </div>
     <div class="col-6">
         <div class="form-check form-switch custom-switch-v1">
             <input type="checkbox" class="form-check-input input-primary" name="enable_custsubdomain"
                 id="enable_custsubdomain">
             <label class="custom-control-label form-control-label"
                 for="enable_custsubdomain">{{ __('Enable Sub Domain') }}</label>
         </div>
     </div>

     <div class="col-6"><br>
         <div class="form-check form-switch custom-switch-v1">
             <input type="checkbox" class="form-check-input input-primary" name="enable_branding" id="enable_branding">
             <label class="branding-control-label form-control-label"
                 for="enable_branding">{{ __('Enable Branding') }}</label>
         </div>
     </div>
     <div class="col-6"><br>
         <div class="form-check form-switch custom-switch-v1">
             <input type="checkbox" class="form-check-input input-primary" name="pwa_business" id="pwa_business">
             <label class="branding-control-label form-control-label"
                 for="pwa_business">{{ __('Progressive Web App (PWA)') }}</label>
         </div>
     </div>
     <div class="col-6"><br>
         <div class="form-check form-switch custom-switch-v1">
             <input type="checkbox" class="form-check-input input-primary" name="enable_qr_code" id="enable_qr_code">
             <label class="branding-control-label form-control-label"
                 for="enable_qr_code">{{ __('Enable QR Code') }}</label>
         </div>
     </div>
     <div class="col-6"><br>
         <div class="form-check form-switch custom-switch-v1">
             <input type="checkbox" class="form-check-input" name="enable_chatgpt" id="enable_chatgpt">
             <label class="custom-control-label form-check-label"
                 for="enable_chatgpt">{{ __('Enable Chatgpt') }}</label>
         </div>
     </div>
     <div class="horizontal mt-3">

         <div class="verticals twelve">
             <div class="form-group col-md-6">
                 {{ Form::label('Select Themes', __('Select Themes'), ['class' => 'form-control-label']) }}
             </div>
             <ul class="uploaded-pics">
                 @foreach (\App\Models\Utility::themeOne() as $key => $v)
                     <li>
                         <input type="checkbox" id="checkthis{{ $loop->index }}" value="{{ $key }}"
                             name="themes[]" checked />
                         <label for="checkthis{{ $loop->index }}"><img
                                 src="{{ asset(Storage::url('uploads/card_theme/' . $key . '/color1.png')) }}" /></label>
                     </li>
                 @endforeach
             </ul>
         </div>


     </div>

     <div class="form-group col-md-12">
         {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
         {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
     </div>

 </div>
 <div class="modal-footer p-0 pt-3">
     <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
     <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
 </div>
 {{ Form::close() }}
