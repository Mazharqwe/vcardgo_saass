<link rel="stylesheet" href="{{ asset('custom/css/emojionearea.min.css') }}">
@php
$chatgpt_setting= App\Models\Utility::chatgpt_setting(\Auth::user()->creatorId());    

@endphp
{{ Form::open(['route' => ['contact.note.store', $contact->id]]) }}
@if($chatgpt_setting['enable_chatgpt']=='on') 
<div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
    data-bs-placement="top">
    <a href="#" data-size="lg" class="btn btn-sm btn-primary" data-ajax-popup-over="true"
        data-url="{{ route('generate', ['Add Note on contact']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
        title="{{ __('Generate') }}" data-title="{{ __('Generate content with AI') }}">
        <i class="fas fa-robot"></i>&nbsp;{{ __('Generate with AI') }}
    </a>
</div>
@endif

<div class="row">
    <div class="col-12 form-group">
        <div class="row gutters-xs">
            <div class="col-12">
                <h6 class="">{{ __('Status') }}</h6>
            </div>
            <div class="col-6 ">
                <div class="form-check ">
                    <input type="radio" id="pending" class="form-check-input mt-1" name="status" value="pending"
                        @if ($contact->status == 'pending') checked @endif>
                    {{ Form::label('pending', 'Pending', ['class' => 'custom-control-label ml-4 badge bg-warning p-2 px-3 rounded']) }}
                </div>

            </div>
            <div class="col-6 ">
                <div class=" form-check  ">
                    <input type="radio" id="completed" class="form-check-input mt-1" name="status" value="completed"
                        @if ($contact->status == 'completed') checked @endif>
                    {{ Form::label('completed', 'Completed', ['class' => 'custom-control-label ml-4  badge bg-success p-2 px-3 rounded']) }}
                </div>

            </div>
        </div>
    </div>
    <div class="col-12 form-group mt-4">
        <div class="row gutters-xs">
            <div class="col-12">
                <h6 class="ml-2">{{ __('Add Note') }}</h6>
            </div>
            <div class="col-12">
                <textarea class="summernote-simple" row="10" cols="50" id="note" name="note">{!! $contact->note !!}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Save') }}">
</div>
{{ Form::close() }}
<script src="{{ asset('custom/js/emojionearea.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#emojiarea").emojioneArea();
    });
</script>
<link rel="stylesheet" href="{{asset('custom/libs/summernote/summernote-bs4.css')}}">
<script src="{{ asset('custom/libs/summernote/summernote-bs4.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote();
    });
</script>
