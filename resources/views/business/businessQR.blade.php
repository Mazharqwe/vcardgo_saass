@php
    // $logo_img=\App\Models\Utility::getValByName('logo'); 
    $company_logo = \App\Models\Utility::GetLogo();
    $logo=\App\Models\Utility::get_file('uploads/logo/');
@endphp
<style>
    .qrcode canvas {
    width: 100%;
    height: 100%;   
    padding: 12px 25px;
}
.qrcode img {
    width: 100%;
    height: 100%;   
}
</style>
<div class=" modal-body-section text-center">
   
    <img src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
    alt="{{ config('app.name', 'vCardgo-SaaS') }}" class="logo logo-lg">
</div>
<div class="modal-body border-0">
    <div class="modal-body-section text-center">
        <div class="qr-main-image">
            <div class="qr-code-border">
                @if(isset($plan->enable_qr_code) && $plan->enable_qr_code=="on")
                 <div class="qrcode "></div>
                @else
                 <div class="downloadqrcode  "></div>
                @endif
            </div>
        </div>
        <div class="text mt-3">
            <p class="text-black">
                {{__('Point your camera at the QR code, or visit')}}<br><a class="qr-link" onclick="copyToClipboard(this)"></a>
            </p>
        </div>
    </div>
</div>
<script> 
    
    $( document ).ready(function() {
        var slug = '{{$qrData}}';
        var url_link = `{{ url("/") }}/${slug}`;
        // console.log(url_link);
        $(`.qr-link`).text(url_link);
        @if(isset($plan->enable_qr_code) && $plan->enable_qr_code=="on")
        var foreground_color = `{{ isset($qr_detail->foreground_color)?$qr_detail->foreground_color:'#000000' }}`;
                var background_color = `{{ isset($qr_detail->background_color)?$qr_detail->background_color:'#ffffff' }}`;
                var radius = `{{ isset($qr_detail->radius)?$qr_detail->radius:26 }}`;
                var qr_type = `{{ isset($qr_detail->qr_type)?$qr_detail->qr_type:0 }}`;
                var qr_font = `{{ isset($qr_detail->qr_text)?$qr_detail->qr_text:'vCard' }}`;
                var qr_font_color = `{{ isset($qr_detail->qr_text_color)?$qr_detail->qr_text_color:'#f50a0a' }}`;
                var size = `{{ isset($qr_detail->size)?$qr_detail->size:9 }}`;

                $('.qrcode').empty().qrcode({
                        render: 'image',
                        size: 500,
                        ecLevel: 'H',
                        minVersion: 3,
                        quiet: 1,
                        text: url_link,
                        fill: foreground_color,
                        background: background_color,
                        radius: .01 * parseInt( radius, 10),
                        mode: parseInt(qr_type, 10),
                        label: qr_font,
                        fontcolor: qr_font_color,
                        image: $("#image-buffers")[0],
                        mSize: .01 * parseInt(size, 10)
                    });
        @else
            $('.downloadqrcode').empty().qrcode({
            render: 'image',
            size: 500,
            ecLevel: 'H',
            minVersion: 3,
            quiet: 1,
            text: url_link,
            fill: $('.foreground_color').val(),
            background: $('.background_color').val(),
            radius: .01 * parseInt($('.radius').val(), 10),
            mode: parseInt($('#qr_type').val(), 10),
            label: $('.qr_text').val(),
            fontcolor: $('.qr_text_color').val(),
            mSize: .01 * parseInt($('.qr_size').val(), 10)
        });
        @endif
        
    }); 

    const copyToClipboardX = str => {
    const el = document.createElement('textarea');
    el.value = str;
    document.body.appendChild(el);
    el.select();
        document.execCommand('copy');
    document.body.removeChild(el);
  };

    function copyToClipboard(e) {
    var slug = '{{$qrData}}';
    var url_link = `{{ url("/") }}/${slug}`;

    var api_key = e.text;
    
    // e.getAttribute("text")
    
    if(typeof api_key != "undefined")
    {
        copyToClipboardX(api_key);
        toastrs('{{ __('Success') }}', '{{ __('Link Copy on Clipboard') }}', 'success');
    }
    }
</script>



