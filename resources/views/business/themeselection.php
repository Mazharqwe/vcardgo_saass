=>in utility
public static function themeOne()
{
    $arr = [];

    $arr = [
        'theme1' => [
            'green-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme1/Home.png')),
                'color' => '92bd88',
            ],
            'geen-blue-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme1/Home-1.png')),
                'color' => '276968',
            ],
            'geen-brown-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme1/Home-2.png')),
                'color' => 'af8637',
            ],
            'geen-white-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme1/Home-3.png')),
                'color' => 'e7d7bd',
            ],
            'green-Pink-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme1/Home-4.png')),
                'color' => 'b7786f',
            ],
        ],

        'theme2' => [
            'blue-yellow-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme2/Home.png')),
                'color' => 'f5ba20',
            ],
            'blue-pink-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme2/Home-1.png')),
                'color' => 'fa747d',
            ],
            'blue-cream-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme2/Home-2.png')),
                'color' => 'c8ae9d',
            ],
            'blue-white-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme2/Home-3.png')),
                'color' => 'd7e2dc',
            ],
            'blue-sky-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme2/Home-4.png')),
                'color' => '5ea5ab',
            ],
        ],

        'theme3' => [
            'white-yellow-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme3/Home.png')),
                'color' => 'f6e32f',
            ],
            'white-geen-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme3/Home-1.png')),
                'color' => '7db802',
            ],
            'white-blue-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme3/Home-2.png')),
                'color' => '3e77ea',
            ],
            'white-black-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme3/Home-3.png')),
                'color' => '2b2d2d',
            ],
            'white-pink-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme3/Home-4.png')),
                'color' => 'ffccb4',
            ],
        ],

        'theme4' => [
            'light-blue-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme4/Home.png')),
                'color' => '5e7698',
            ],
            'light-green-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme4/Home-1.png')),
                'color' => '88d297',
            ],
            'light-cream-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme4/Home-2.png')),
                'color' => 'c9aea7',
            ],
            'light-black-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme4/Home-3.png')),
                'color' => '2f343a',
            ],
            'light-orange-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme4/Home-4.png')),
                'color' => 'f3ba51',
            ],
        ],

        'theme5' => [
            'dark-sky-blue-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme5/Home.png')),
                'color' => '007aff',
            ],
            'dark-yellow-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme5/Home-1.png')),
                'color' => 'febd00',
            ],
            'dark-green-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme5/Home-2.png')),
                'color' => '05d79f',
            ],
            'dark-pink-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme5/Home-3.png')),
                'color' => 'e91e63',
            ],
            'dark-blue-color.css' => [
                'img_path' => asset(Storage::url('uploads/store_theme/theme5/Home-4.png')),
                'color' => '2b2d42',
            ],
        ],
    ];

    return $arr;
}


=>in setting

<div id="store_theme_setting" class="tab-pane fade show" role="tabpanel" aria-labelledby="orders-tab">
    {{Form::open(array('route' => array('store.changetheme', $store_settings->id),'method' => 'POST'))}}
    <div class="card-body">
        <div class="row">
            @foreach(\App\Utility::themeOne() as $key => $v)
                <div class="col-3 cc-selector mb-2">
                    <div class="mb-3 screen">
                        <img src="{{asset(Storage::url('uploads/store_theme/'.$key.'/Home.png'))}}" class="img-center pro_max_width pro_max_height {{$key}}_img">
                    </div>
                    <div class="form-group">
                        <div class="row gutters-xs mx-auto" id="{{$key}}">
                            @foreach($v as $css => $val)
                                <div class="col">
                                    <label class="colorinput">
                                        <input name="theme_color" type="radio" value="{{$css}}" data-theme="{{$key}}" data-imgpath="{{$val['img_path']}}" class="colorinput-input" {{(isset($store_settings['store_theme']) && $store_settings['store_theme'] == $css) ? 'checked' : ''}}>
                                        <span class="colorinput-color" style="background:#{{$val['color']}}"></span>
                                    </label>
                                </div>
                            @endforeach
                            <div class="col">
                                @if(isset($store_settings['theme_dir']) && $store_settings['theme_dir'] == $key)
                                    <a href="{{route('store.editproducts',[$store_settings->slug,$key])}}" class="btn btn-outline-primary theme_btn" type="button" id="button-addon2">{{__('Edit')}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row card-footer">
        <div class="col-6">
            <p class="small">{{__('Note')}} : {{__('you can edit theme after saving')}}</p>
        </div>
        <div class="col-6 text-right">
            {{Form::hidden('themefile',null,array('id'=>'themefile'))}}
            {{Form::submit(__('Save Change'),array('class'=>'btn btn-sm btn-primary rounded-pill'))}}
        </div>
    </div>
    {{Form::close()}}
</div>

=>in css

.screen {
    display: block;
    width: 300px;
    height: 350px;
    overflow: hidden;
    position: relative;
    border-radius: 5px;
    margin: 0 auto;
}

.screen img {
    bottom: -595px;
    width: 100%;
    height: auto;
    position: absolute;
    z-index: 0;
    margin: 0;
    padding: 0;
    -webkit-transition: top 3s;
    -moz-transition: top 3s;
    -ms-transition: top 3s;
    -o-transition: top 3s;
    transition: bottom 3s;
}

.screen:hover img {
    bottom: 0;
    -webkit-transition: all 3s;
    -moz-transition: all 3s;
    -ms-transition: all 3s;
    -o-transition: all 3s;
    transition: all 3s;
}

=>in js

$(document).on('click', 'input[name="theme_color"]', function () {
    var eleParent = $(this).attr('data-theme');
    $('#themefile').val(eleParent);
    var imgpath = $(this).attr('data-imgpath');
    $('.' + eleParent + '_img').attr('src', imgpath);
});

$(document).ready(function () {
    setTimeout(function (e) {
        var checked = $("input[type=radio][name='theme_color']:checked");
        $('#themefile').val(checked.attr('data-theme'));
        $('.' + checked.attr('data-theme') + '_img').attr('src', checked.attr('data-imgpath'));
    }, 300);
});

=>in controller=>>

public function changeTheme(Request $request, $slug)
{
    $validator = \Validator::make(
        $request->all(), [
                           'theme_color' => 'required',
                           'themefile' => 'required',
                       ]
    );
    if($validator->fails())
    {
        $messages = $validator->getMessageBag();

        return redirect()->back()->with('error', $messages->first());
    }
    $store                = Store::find($slug);
    $store['store_theme'] = $request->theme_color;
    $store['theme_dir']   = $request->themefile;
    $store->save();

    return redirect()->back()->with('success', __('Theme Successfully Updated.'));

}