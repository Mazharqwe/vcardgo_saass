@php
    $currantLang = \Auth::user()->lang;
@endphp
<form action="" id="myForm">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('template', __('For What'), ['class' => 'col-form-label']) }}</br>
                @foreach ($templateName as $key => $value)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input template_name" type="radio" name="template_name"
                            value="{{ $value->id }}" id="product_name_{{ $value->id }}"
                            data-name="{{ $value->template_name }}">
                        <label class="form-check-label" for="product_name_{{ $value->id }}">
                            {{ ucwords(str_replace('_', ' ', $value->template_name)) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('language', __('Language'), ['class' => 'col-form-label']) }}
                <select name="language" class="form-select" id="language">
                    @foreach (App\Models\Utility::flagOfCountry() as $key => $lang)
                        <option value="{{ $key }}" {{ $currantLang == $key ? 'selected' : '' }}>
                            {{ Str::upper($lang) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6 tone">
            <div class="form-group">
                {{ Form::label('', __('Tone'), ['class' => 'col-form-label']) }}
                @php
                    $tone = [
                        'funny' => 'funny',
                        'casual' => 'casual',
                        'excited' => 'excited',
                        'professional' => 'professional',
                        'witty' => 'witty',
                        'sarcastic' => 'sarcastic',
                        'feminine' => 'feminine',
                        'masculine' => 'masculine',
                        'bold' => 'bold',
                        'dramatic' => 'dramatic',
                        'gumpy' => 'gumpy',
                        'secretive' => 'secretive',
                    ];
                @endphp
                {{ Form::select('tone', $tone, null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('', __('AI Creativity'), ['class' => 'col-form-label']) }}
                <select name="ai_creativity" id="ai_creativity" class="form-select">
                    <option value="1">{{ __('High') }}</option>
                    <option value="0.5">{{ __('Meduium') }}</option>
                    <option value="0">{{ __('Low') }}</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('', __('Number of Result'), ['class' => 'col-form-label']) }}
                <select name="num_of_result" id="" class="form-select">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('', __('Maximum Result Length'), ['class' => 'col-form-label']) }}
                {{ Form::number('result_length', 10, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-12" id="getkeywords">
        </div>
    </div>
    <div class="response">
        <a class="btn btn-primary btn-sm float-left" href="#!" id="generate_service">{{ __('Generate') }}</a>
        <a href="#!" onclick="copyText()" class="btn btn-primary btn-sm float-end"><i
                class="ti ti-copy"></i>{{ __('Copy Text') }}</a>
        <a href="#!" onclick="copySelectedText()" class="btn btn-primary btn-sm float-end me-2"><i
                class="ti ti-copy"></i>{{ __('Copy Selected Text') }}</a>
    </div>
</form>
<div class="form-group mt-3">
    {{ Form::textarea('description', null, ['class' => 'form-control','rows' => 5,'placeholder' => __('Description'),'id'=>'ai-description']) }}
</div>



<link rel="stylesheet" href="{{ asset('public/css/richtext.min.css') }}">
<script src="{{ asset('public/js/jquery.richtext.js') }}"></script>
{{-- <script src="{{ asset('public/js/jquery.richtext.min.js') }}"></script> --}}
<script>
    $('body').ready(function() {
        "use strict";
        $('#ai_richtext_editor').richText({
           
            bold: true,
            italic: true,
            underline: true,
            leftAlign: true,
            centerAlign: true,
            rightAlign: true,
            justify: true,
            ol: true,
            ul: true,
            heading: true,
            fonts: true,
            fontList: [
                "Arial",
                "Arial Black",
                "Comic Sans MS",
                "Courier New",
                "Geneva",
                "Georgia",
                "Helvetica",
                "Impact",
                "Lucida Console",
                "Tahoma",
                "Times New Roman",
                "Verdana"
            ],
            fontColor: true,
            fontSize: true,
            imageUpload: false,
            fileUpload: false,
            videoEmbed: false,
            urls: false,
            table: false,
            removeStyles: false,
            code: false,
            colors: [],
            fileHTML: '',
            imageHTML: '',
            translations: {
                'title': 'Title',
            },
            youtubeCookies: false,
            useSingleQuotes: false,
            height: 0,
            heightPercentage: 0,
            id: "",
            class: "",
            useParagraph: true,
            maxlength: 0,
            callback: undefined,
            useTabForNext: false
        });
    });
</script>
<script>
    function copyText() {
        var service_id="{{$serviceid}}";
        var selected = $('input[name="template_name"]:checked').attr('data-name');
        var servicename='title_'+service_id;
        var servicedesc='description_'+service_id;
        var copied = $("#ai-description").val();

        if (selected=="service_title") {  
            $('input[id=' + servicename + ']').val(copied)
            $('#title_'+service_id+'_preview').text(copied);
        } else {
            if ($('textarea[name=' + selected + ']').hasClass('pc-tinymce-2')) {
                tinymce.get(selected).setContent(copied);
            }
            else if ($('textarea[name=' + selected + ']').hasClass('summernote-simple')) {
                $('textarea[name=' + selected + ']').summernote("code", copied);
            } else {
                $('textarea[id=' + servicedesc + ']').val(copied)
                $('#description_'+service_id+'_preview').text(copied);
                
            }
        }
        toastrs('{{ __('Success') }}', '{{ __('Result text has been copied successfully') }}', 'success');
        $('#commonModalOver').modal('hide');
    }

    function copySelectedText() {
        var selected = $('input[name="template_name"]:checked').attr('data-name');
        var selectedText = window.getSelection().toString();
        var input = $('input[name=' + selected + ']').length;
        $('#ai-description').after("Copied to clipboard");

        var service_id="{{$serviceid}}";
        var servicename='title_'+service_id;
        var servicedesc='description_'+service_id;

        if (selected=="service_title") {  
            $('input[id=' + servicename + ']').val(selectedText)
            $('#title_'+service_id+'_preview').text(selectedText);
        } else {
            if ($('textarea[name=' + selected + ']').hasClass('pc-tinymce-2')) {
                tinymce.get(selected).setContent(selectedText);
            } else if ($('textarea[name=' + selected + ']').hasClass('summernote-simple')) {
                $('textarea[name=' + selected + ']').summernote("code", copied);
            }else {
                $('textarea[id=' + servicedesc + ']').val(selectedText)
                $('#description_'+service_id+'_preview').text(selectedText);
                
            }
        }
        
        toastrs('{{ __('Success') }}', '{{ __('Result text has been copied successfully') }}', 'success');
        $('#commonModalOver').modal('hide');
    }


    $('body').on('shown.bs.modal', function() {
        $("#commonModalOver input:radio:first").prop("checked", true).trigger("change");
    });
    $('body').on('change', '.template_name', function() {
        var templateId = $(this).val();
        var url =
            $.ajax({
                type: 'post',
                url: '{{ route('generate.keywords', ['__templateId']) }}'.replace('__templateId',
                    templateId),
                datType: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'template_id': templateId,
                },
                success: function(data) {
                    if (data.tone == 1) {
                        $('.tone').removeClass('d-none');
                        $('.tone select').attr('name', 'tone');
                    } else {
                        $('.tone').addClass('d-none');
                        $('.d-none select').removeAttr('name');
                    }
                    $('#getkeywords').empty();
                    $('#getkeywords').append(data.template)
                },
            })
    })
    
    $('#generate_service').on('click', function () {
        var form = $("#myForm");
        $.ajax({
            type: 'post',
            url: '{{ route('generate.response') }}',
            datType: 'json',
            data: form.serialize(),
            beforeSend: function(msg) {
                $("#generate_service").empty();
                var html = '<span class="spinner-grow spinner-grow-sm" role="status"></span>';
                $("#generate_service").append(html);
            },
            afterSend: function(msg) {
                $("#generate2").empty();
                var html =
                    `<a class="btn btn-primary" href="#!" id="generate_service">{{ __('Generate') }}</a>`;
                $("#generate2").replaceWith(html);

            },
            success: function(data){
                $('.response').removeClass('d-none');
                $('#generate_service').text('Re-Generate');
                if(data.message){
                    show_toastr('error', data.message, 'error');
                    $('#commonModalOver').modal('hide');
                }
                else{
                    $('#ai-description').val(data)
                }
            },
        });
    });
</script>
