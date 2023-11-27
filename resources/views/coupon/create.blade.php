@php
$chatgpt_setting= App\Models\Utility::chatgpt_setting(\Auth::user()->creatorId());
@endphp
{{ Form::open(['url' => 'coupons', 'method' => 'post']) }}
@if(isset($chatgpt_setting['chatgpt_key']) && (!empty($chatgpt_setting['chatgpt_key'])))
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
        data-bs-placement="top">
        <a href="#" data-size="lg" class="btn btn-sm btn-primary" data-ajax-popup-over="true"
            data-url="{{ route('generate', ['coupon']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('Generate') }}" data-title="{{ __('Generate content with AI') }}">
            <i class="fas fa-robot"></i>&nbsp;{{ __('Generate with AI') }}
        </a>
    </div>
@endif
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control font-style', 'required' => 'required']) }}
    </div>

    <div class="form-group col-md-6">
        {{ Form::label('discount', __('Discount'), ['class' => 'form-label']) }}
        {{ Form::number('discount', null, ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
        <span class="small">{{ __('Note: Discount in Percentage') }}</span>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('limit', __('Limit'), ['class' => 'form-label']) }}
        {{ Form::number('limit', null, ['class' => 'form-control', 'required' => 'required']) }}
    </div>

    <div class="form-group col-md-12">
        {{ Form::label('code', __('Code'), ['class' => 'form-label']) }}
        <div class="d-flex radio-check">
            <div class="form-check  form-check-inline">
                <input type="radio" id="flexCheckChecked" value="manual" name="icon-input"
                    class="form-check-input code" checked="checked">
                <label class=" form-control-label" for="flexCheckChecked">{{ __('Manual') }}</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" id="flexCheckChecked1" value="auto" name="icon-input"
                    class="form-check-input code">
                <label class=" form-control-label" for="flexCheckChecked1">{{ __('Auto Generate') }}</label>
            </div>
        </div>
    </div>
    <div class="form-group col-md-12 d-block" id="manual">
        <input class="form-control font-uppercase" name="manualCode" type="text">
    </div>
    <div class="form-group col-md-12 d-none" id="auto">
        <div class="row">
            <div class="input-group">
                <input class="form-control" name="autoCode" type="text" id="auto-code">
                <button class="btn btn-outline-secondary " id="code-generate" type="button"><i
                        class="fas fa-history"></i>{{ __('Genrate') }}</button>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer p-0 pt-3">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
</div>
{{ Form::close() }}
