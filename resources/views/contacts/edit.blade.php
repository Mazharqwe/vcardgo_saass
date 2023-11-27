{{Form::model($Contacts, array('route' => array('Contacts.update', $Contacts->id))) }}
<div class="row">
    <div class="form-group col-md-12">
        {{Form::label('name',__('Name'),['class'=>'form-label'])}}
        {{Form::text('name',null,array('class'=>'form-control font-style','required'=>'required'))}}
    </div>
    <div class="form-group col-md-6">
        {{Form::label('email',__('email'),['class'=>'form-label'])}}
        {{Form::text('email',null,array('class'=>'form-control','required'=>'required'))}}
    </div>
    <div class="form-group col-md-6">
        {{Form::label('phone',__('Phone'),['class'=>'form-label'])}}
        {{Form::number('phone',null,array('class'=>'form-control','required'=>'required'))}}
    </div>
    <div class="form-group col-md-12">
        {{Form::label('message',__('Message'),['class'=>'form-label'])}}
        {{Form::text('message',null,array('class'=>'form-control','required'=>'required'))}}
    </div>
</div>
<div class="modal-footer p-0 pt-3">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
</div>
{{ Form::close() }}
