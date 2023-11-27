{{Form::open(array('url'=>'permissions','method'=>'post'))}}
<div class="row">
    <div class="col-12">
        {{Form::label('name',__('Name'))}}
        {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Permission Name')))}}
        @error('name')
        <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
        @enderror
    </div>
    <div class="col-12 mt-3">
        @if(!$roles->isEmpty())
            <h6>{{__('Assign Permission to Roles')}}</h6>
            @foreach ($roles as $role)
                <div class="mb-1">
                    {{Form::checkbox('roles[]',$role->id,false, ['class'=>'form-check-input','id' =>'role'.$role->id])}}
                    {{Form::label('role'.$role->id, __(ucfirst($role->name)),['class'=>'form-check-label '])}}
                </div>
            @endforeach
        @endif
        @error('roles')
        <span class="invalid-roles" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}
