{{Form::model($webhook, array('route' => array('webhook.update', $webhook->id), 'method' => 'PUT')) }}
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('Module', __('Module'), ['class' => 'form-label']) }}
        <select name="module" class="form-control select2"
            id="module" >
            @foreach ($module as $key => $value)
             <option value = "{{ $key }}" {{ $key == $webhook->module ? 'selected' : '' }}>{{__($value)}}</option>
            @endforeach
        </select>
        @error('module')
            <small class="invalid-module" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
        @enderror
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('Method', __('Method'), ['class' => 'form-label']) }}
        <select name="method" class="form-control select2"
            id="method" >
            @foreach ($method as $key => $value)
             <option value = "{{ $key }}" {{ $key == $webhook->method ? 'selected' : '' }}>{{__($value)}}</option>
            @endforeach
        </select>
        @error('method')
            <small class="invalid-method" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
        @enderror
    </div>

    <div class="form-group col-md-12">
        {{ Form::label('url', __('URL'), ['class' => 'form-label']) }}
        {{ Form::text('url', $webhook->url, ['class' => 'form-control', 'placeholder' => __('Enter URL'), 'required' => 'required']) }}
        @error('name')
            <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
        @enderror
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Update'), ['class' => 'btn btn-primary']) }}
</div>
{{ Form::close() }}
