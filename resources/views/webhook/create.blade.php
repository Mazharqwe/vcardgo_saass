{{ Form::open(['url' => 'webhook', 'method' => 'post']) }}
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('Module', __('Module'), ['class' => 'form-label']) }}
        {!! Form::select('module', $module, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
        @error('module')
            <small class="invalid-module" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
        @enderror
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('Method', __('Method'), ['class' => 'form-label']) }}
        {!! Form::select('method', $method, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
        @error('method')
            <small class="invalid-method" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
        @enderror
    </div>

    <div class="form-group col-md-12">
        {{ Form::label('url', __('URL'), ['class' => 'form-label']) }}
        {{ Form::text('url', null, ['class' => 'form-control', 'placeholder' => __('Enter URL'), 'required' => 'required']) }}
        @error('name')
            <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
        @enderror
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn btn-primary']) }}
</div>
{{ Form::close() }}
