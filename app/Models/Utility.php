<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\business_hours;
use App\Models\appoinment;
use App\Models\service;
use App\Models\social;
use App\Models\ContactInfo;
use App\Models\testimonial;
use App\Models\Business;
use App\Models\Webhook;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonEmailTemplate;
use Storage;
use Spatie\GoogleCalendar\Event as GoogleEvent;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Languages;


class Utility extends Model
{
    //Access specifrer
    private static $storesettings = null;
    private static $colorset = null;
    private static $storagesettings = null;
    private static $cookiesettings = null;
    private static $getsettings = null;
    private static $getsettingsid = null;
    private static $layoutsetting = null;
    private static $adminpaymentsettings = null;
    private static $languages = null;
    public static function AddBusinessField()
    {
        $data = [
            ['name' => 'phone', 'icon' => 'fa fa-phone'],
            ['name' => 'email', 'icon' => 'fa fa-envelope'],
            ['name' => 'address', 'icon' => 'fa fa-map-marker'],
            ['name' => 'website', 'icon' => 'fa fa-link'],
            ['name' => 'custom_field', 'icon' => 'fa fa-align-left'],
            ['name' => 'facebook', 'icon' => 'fab fa-facebook'],
            ['name' => 'twitter', 'icon' => 'fab fa-twitter'],
            ['name' => 'instagram', 'icon' => 'fab fa-instagram'],
            ['name' => 'whatsapp', 'icon' => 'fab fa-whatsapp'],
        ];
        foreach ($data as $value) {
            \DB::insert(
                'insert into businessfields (`name`,`icon`,`created_at`,`updated_at`) values (?,?,?,?) ON DUPLICATE KEY UPDATE `name` = VALUES(`name`) ',
                [$value['name'], $value['icon'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]
            );
        }

        return true;
    }

    public static function createSlug($table, $title, $id = 0)
    {

        // Normalize the title
        $slug = Str::slug($title, '-');
        $routes = array_map(function (\Illuminate\Routing\Route $route) {
            return $route->uri;
        }, (array) Route::getRoutes()->getIterator());


        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = self::getRelatedSlugs($table, $slug, $id);
        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug) && !in_array($slug, $routes)) {

            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug) && !in_array($newSlug, $routes)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    public static function getRelatedSlugs($table, $slug, $id = 0)
    {
        return DB::table($table)->select()->where('slug', 'like', $slug . '%')->where('id', '<>', $id)->get();
    }

    public static function getFields()
    {
        $icons = [
            'Facebook',
            'Instagram',
            'LinkedIn',
            'Phone',
            'Twitter',
            'Youtube',
            'Email',
            'Behance',
            'Dribbble',
            'Figma',
            'Messenger',
            'Pinterest',
            'Tiktok',
            'Whatsapp',
            'Address',
            'Web_url',
        ];

        return $icons;
    }

    public static function themeOne()
    {
        $arr = [];

        $arr = [
            'theme1' => [
                'color1-theme1' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme1/color1.png')),
                    'color' => '#F9D254',
                    'theme_name' => 'theme1-v1'
                ],
                'color2-theme1' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme1/color2.png')),
                    'color' => '#8ECAE6',
                    'theme_name' => 'theme1-v2'
                ],
                'color3-theme1' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme1/color3.png')),
                    'color' => '#FDF0D5',
                    'theme_name' => 'theme1-v3'
                ],
                'color4-theme1' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme1/color4.png')),
                    'color' => '#E9EDC9',
                    'theme_name' => 'theme1-v4'
                ],
            ],
            'theme2' => [
                'color1-theme2' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme2/color1.png')),
                    'color' => '#1840DA',
                    'theme_name' => 'theme2-v1'
                ],
                'color2-theme2' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme2/color2.png')),
                    'color' => '#8338EC',
                    'theme_name' => 'theme2-v2'
                ],
                'color3-theme2' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme2/color3.png')),
                    'color' => '#3A5A40',
                    'theme_name' => 'theme2-v3'
                ],
                'color4-theme2' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme2/color4.png')),
                    'color' => '#003049',
                    'theme_name' => 'theme2-v4'
                ],
            ],
            'theme3' => [
                'color1-theme3' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme3/color1.png')),
                    'color' => '#B89C87',
                    'theme_name' => 'theme3-v1'
                ],
                'color2-theme3' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme3/color2.png')),
                    'color' => '#344E41',
                    'theme_name' => 'theme3-v2'
                ],
                'color3-theme3' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme3/color3.png')),
                    'color' => '#778DA9',
                    'theme_name' => 'theme3-v3'
                ],
                'color4-theme3' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme3/color4.png')),
                    'color' => '#0D1B2A',
                    'theme_name' => 'theme3-v4'
                ],
            ],
            'theme4' => [
                'color1-theme4' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme4/color1.png')),
                    'color' => '#ECDACA',
                    'theme_name' => 'theme4-v1'
                ],
                'color2-theme4' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme4/color2.png')),
                    'color' => '#FFC8DD',
                    'theme_name' => 'theme4-v2'
                ],
                'color3-theme4' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme4/color3.png')),
                    'color' => '#E9EDC9',
                    'theme_name' => 'theme4-v3'
                ],
                'color4-theme4' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme4/color4.png')),
                    'color' => '#8ECAE6',
                    'theme_name' => 'theme4-v4'
                ],
            ],
            'theme5' => [
                'color1-theme5' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme5/color1.png')),
                    'color' => '#022A2E',
                    'theme_name' => 'theme5-v1'
                ],
                'color2-theme5' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme5/color2.png')),
                    'color' => '#1B263B',
                    'theme_name' => 'theme5-v2'
                ],
                'color3-theme5' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme5/color3.png')),
                    'color' => '#283618',
                    'theme_name' => 'theme5-v3'
                ],
                'color4-theme5' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme5/color4.png')),
                    'color' => '#000000',
                    'theme_name' => 'theme5-v4'
                ],
            ],
            'theme6' => [
                'color1-theme6' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme6/color1.png')),
                    'color' => '#ADD9FF',
                    'theme_name' => 'theme6-v1'
                ],
                'color2-theme6' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme6/color2.png')),
                    'color' => '#749D73',
                    'theme_name' => 'theme6-v2'
                ],
                'color3-theme6' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme6/color3.png')),
                    'color' => '#FFB703',
                    'theme_name' => 'theme6-v3'
                ],
                'color4-theme6' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme6/color4.png')),
                    'color' => '#DDA15E',
                    'theme_name' => 'theme6-v4'
                ],
            ],
            'theme7' => [
                'color1-theme7' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme7/color1.png')),
                    'color' => '#000',
                    'theme_name' => 'theme7-v1'
                ],
                'color2-theme7' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme7/color2.png')),
                    'color' => '#7E6455',
                    'theme_name' => 'theme7-v2'
                ],
                'color3-theme7' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme7/color3.png')),
                    'color' => '#14213D',
                    'theme_name' => 'theme7-v3'
                ],
                'color4-theme7' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme7/color4.png')),
                    'color' => '#283618',
                    'theme_name' => 'theme7-v4'
                ],
            ],
            'theme8' => [
                'color1-theme8' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme8/color1.png')),
                    'color' => '#242424',
                    'theme_name' => 'theme8-v1'
                ],
                'color2-theme8' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme8/color2.png')),
                    'color' => '#283618',
                    'theme_name' => 'theme8-v2'
                ],
                'color3-theme8' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme8/color3.png')),
                    'color' => '#1B263B',
                    'theme_name' => 'theme8-v3'
                ],
                'color4-theme8' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme8/color4.png')),
                    'color' => '#2477C5',
                    'theme_name' => 'theme8-v4'
                ],
            ],
            'theme9' => [
                'color1-theme9' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme9/color1.png')),
                    'color' => '#0248A3',
                    'theme_name' => 'theme9-v1'
                ],
                'color2-theme9' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme9/color2.png')),
                    'color' => '#3F02A3',
                    'theme_name' => 'theme9-v2'
                ],
                'color3-theme9' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme9/color3.png')),
                    'color' => '#A30280',
                    'theme_name' => 'theme9-v3'
                ],
                'color4-theme9' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme9/color4.png')),
                    'color' => '#8CA302',
                    'theme_name' => 'theme9-v4'
                ],
            ],
            'theme10' => [
                'color1-theme10' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme10/color1.png')),
                    'color' => '#000000',
                    'theme_name' => 'theme10-v1'
                ],
                'color2-theme10' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme10/color2.png')),
                    'color' => '#281616',
                    'theme_name' => 'theme10-v2'
                ],
                'color3-theme10' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme10/color3.png')),
                    'color' => '#162825',
                    'theme_name' => 'theme10-v3'
                ],
                'color4-theme10' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme10/color4.png')),
                    'color' => '#0D1D34',
                    'theme_name' => 'theme10-v4'
                ],
            ],
            'theme11' => [
                'color1-theme11' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme11/color1.png')),
                    'color' => '#000000',
                    'theme_name' => 'theme11-v1'
                ],
                'color2-theme11' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme11/color2.png')),
                    'color' => '#342F14',
                    'theme_name' => 'theme11-v2'
                ],
                'color3-theme11' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme11/color3.png')),
                    'color' => '#14342E',
                    'theme_name' => 'theme11-v3'
                ],
                'color4-theme11' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme11/color4.png')),
                    'color' => '#141F34',
                    'theme_name' => 'theme11-v4'
                ],
            ],

            'theme12' => [
                'color1-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color1.png')),
                    'color' => '#FDD395',
                    'theme_name' => 'theme12-v1'
                ],
                'color2-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color2.png')),
                    'color' => '#94D2BD',
                    'theme_name' => 'theme12-v2'
                ],
                'color3-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color3.png')),
                    'color' => '#168AAD',
                    'theme_name' => 'theme12-v3'
                ],
                'color4-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color4.png')),
                    'color' => '#A01A58',
                    'theme_name' => 'theme12-v4'
                ],
                'color5-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color5.png')),
                    'color' => '#B5E48C',
                    'theme_name' => 'theme12-v5'
                ],
            ],
            'theme13' => [
                'color1-theme13' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme13/color1.png')),
                    'color' => 'linear-gradient(180deg, #ADE8F4 0%, #46B7CE 100%)',
                    'theme_name' => 'theme13-v1'
                ],
                'color2-theme13' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme13/color2.png')),
                    'color' => 'linear-gradient(180deg, #D9ED92 0%, #B5E48C 100%)',
                    'theme_name' => 'theme13-v2'
                ],
                'color3-theme13' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme13/color3.png')),
                    'color' => 'linear-gradient(180deg, #F7B801 0%, #F18701 100%)',
                    'theme_name' => 'theme13-v3'
                ],
                'color4-theme13' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme13/color4.png')),
                    'color' => 'linear-gradient(180deg, #94D2BD 0%, #0A9396 100%)',
                    'theme_name' => 'theme13-v4'
                ],
                'color5-theme13' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme13/color5.png')),
                    'color' => 'linear-gradient(180deg, #FF7900 0%, #FF5400 100%)',
                    'theme_name' => 'theme13-v5'
                ],
            ],

            'theme14' => [
                'color1-theme14' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme14/color1.png')),
                    'color' => '#99E2B4',
                    'theme_name' => 'theme14-v1'
                ],
                'color2-theme14' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme14/color2.png')),
                    'color' => '#F18701',
                    'theme_name' => 'theme14-v2'
                ],
                'color3-theme14' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme14/color3.png')),
                    'color' => '#34A0A4',
                    'theme_name' => 'theme14-v3'
                ],
                'color4-theme14' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme14/color4.png')),
                    'color' => '#7678ED',
                    'theme_name' => 'theme14-v4'
                ],
                'color5-theme14' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme14/color5.png')),
                    'color' => '#4EAAFF',
                    'theme_name' => 'theme14-v5'
                ],
            ],
            'theme15' => [
                'color1-theme15' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme15/color1.png')),
                    'color' => '#000000',
                    'theme_name' => 'theme15-v1'
                ],
                'color2-theme15' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme15/color2.png')),
                    'color' => '#858585;',
                    'theme_name' => 'theme15-v2'
                ],
                'color3-theme15' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme15/color3.png')),
                    'color' => '#005F73',
                    'theme_name' => 'theme15-v3'
                ],
                'color4-theme15' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme15/color4.png')),
                    'color' => '#723C70',
                    'theme_name' => 'theme15-v4'
                ],
                'color5-theme15' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme15/color5.png')),
                    'color' => '#60873A',
                    'theme_name' => 'theme15-v5'
                ],
            ],
            'theme16' => [
                'color1-theme16' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme16/color1.png')),
                    'color' => '#F05C35',
                    'theme_name' => 'theme16-v1'
                ],
                'color2-theme16' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme16/color2.png')),
                    'color' => '#0A9396',
                    'theme_name' => 'theme16-v2'
                ],
                'color3-theme16' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme16/color3.png')),
                    'color' => '#B5E48C',
                    'theme_name' => 'theme16-v3'
                ],
                'color4-theme16' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme16/color4.png')),
                    'color' => '#B7094C',
                    'theme_name' => 'theme16-v4'
                ],
                'color5-theme16' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme16/color5.png')),
                    'color' => '#7678ED',
                    'theme_name' => 'theme16-v5'
                ],
            ],
            'theme17' => [
                'color1-theme17' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme17/color1.png')),
                    'color' => '#52189C',
                    'theme_name' => 'theme17-v1'
                ],
                'color2-theme17' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme17/color2.png')),
                    'color' => '#FF9E00',
                    'theme_name' => 'theme17-v2'
                ],
                'color3-theme17' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme17/color3.png')),
                    'color' => '#CB997E',
                    'theme_name' => 'theme17-v3'
                ],
                'color4-theme17' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme17/color4.png')),
                    'color' => '#6B705C',
                    'theme_name' => 'theme17-v4'
                ],
                'color5-theme17' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme17/color5.png')),
                    'color' => '#76C893',
                    'theme_name' => 'theme17-v5'
                ],
            ],
            'theme18' => [
                'color1-theme18' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme18/color1.png')),
                    'color' => '#000000',
                    'theme_name' => 'theme18-v1'
                ],
                'color2-theme18' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme18/color2.png')),
                    'color' => '#455E89',
                    'theme_name' => 'theme18-v2'
                ],
                'color3-theme18' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme18/color3.png')),
                    'color' => '#3D348B',
                    'theme_name' => 'theme18-v3'
                ],
                'color4-theme18' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme18/color4.png')),
                    'color' => '#9B2226',
                    'theme_name' => 'theme18-v4'
                ],
                'color5-theme18' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme18/color5.png')),
                    'color' => '#52B69A',
                    'theme_name' => 'theme18-v5'
                ],
            ],
            'theme19' => [
                'color1-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color1.png')),
                    'color' => 'linear-gradient(102.24deg, #936639 6.21%, #656D4A 99.29%)',
                    'theme_name' => 'theme19-v1'
                ],
                'color2-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color2.png')),
                    'color' => 'linear-gradient(102.24deg, #723C70 6.21%, #2E6F95 99.29%)',
                    'theme_name' => 'theme19-v2'
                ],
                'color3-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color3.png')),
                    'color' => 'linear-gradient(102.24deg, #005F73 6.21%, #0A9396 99.29%)',
                    'theme_name' => 'theme19-v3'
                ],
                'color4-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color4.png')),
                    'color' => 'linear-gradient(102.24deg, #9B2226 6.21%, #BB3E03 99.29%)',
                    'theme_name' => 'theme19-v4'
                ],
                'color5-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color5.png')),
                    'color' => 'linear-gradient(102.24deg, #76C893 6.21%, #99D98C 99.29%)',
                    'theme_name' => 'theme19-v5'
                ],
            ],
            'theme20' => [
                'color1-theme20' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme20/color1.png')),
                    'color' => '#FFD4E0',
                    'theme_name' => 'theme20-v1'
                ],
                'color2-theme20' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme20/color2.png')),
                    'color' => '#FFE8D6',
                    'theme_name' => 'theme20-v2'
                ],
                'color3-theme20' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme20/color3.png')),
                    'color' => '#B7B7A4',
                    'theme_name' => 'theme20-v3'
                ],
                'color4-theme20' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme20/color4.png')),
                    'color' => '#B5E48C',
                    'theme_name' => 'theme20-v4'
                ],
                'color5-theme20' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme20/color5.png')),
                    'color' => '#94D2BD',
                    'theme_name' => 'theme20-v5'
                ],
            ],
            'theme21' => [
                'color1-theme21' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme21/color1.png')),
                    'color' => '#F7762E',
                    'theme_name' => 'theme21-v1'
                ],
                'color2-theme21' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme21/color2.png')),
                    'color' => '#7678ED',
                    'theme_name' => 'theme21-v2'
                ],
                'color3-theme21' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme21/color3.png')),
                    'color' => '#99D98C',
                    'theme_name' => 'theme21-v3'
                ],
                'color4-theme21' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme21/color4.png')),
                    'color' => '#1A759F',
                    'theme_name' => 'theme21-v4'
                ],
                'color5-theme21' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme21/color5.png')),
                    'color' => '#6B705C',
                    'theme_name' => 'theme21-v5'
                ],
            ],



        ];

        return $arr;
    }
    public static function getCompanyPaymentSetting()
    {
        $data = \DB::table('admin_payment_settings');
        $settings = [];
        if (\Auth::check()) {
            $user_id = \Auth::user()->creatorId();
            $data = $data->where('created_by', '=', $user_id);

        }
        $data = $data->get();
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }
    public static function settings()
    {
        if (self::$storesettings == null) {
            $data = DB::table('settings');

            if (\Auth::check()) {
                if (\Auth::user()->type == 'super admin') {
                    $data = Utility::getSetting();
                    //$data = $data->where('created_by', '=', \Auth::user()->creatorId())->get();
                    if (count($data) == 0) {
                        $data = Utility::getSetting();
                    }
                } else {
                    $data = Utility::getSettingById(\Auth::user()->creatorId());
                    if (count($data) == 0) {
                        $data = Utility::getSetting();
                    }

                }

            } else {

                $data = Utility::getSetting();

            }
            self::$storesettings = $data;
        }

        $settings = [
            "site_currency" => "USD",
            "site_currency_symbol" => "$",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INVO",
            "invoice_color" => "ffffff",
            "proposal_prefix" => "#PROP",
            "proposal_color" => "ffffff",
            "bill_prefix" => "#BILL",
            "bill_color" => "ffffff",
            "customer_prefix" => "#CUST",
            "vender_prefix" => "#VEND",
            "footer_text" => "vCardGo-SaaS",
            "footer_notes" => "",
            "invoice_template" => "template1",
            "bill_template" => "template1",
            "proposal_template" => "template1",
            "registration_number" => "",
            "vat_number" => "",
            "default_language" => "en",
            "enable_stripe" => "",
            "enable_paypal" => "",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "stripe_key" => "",
            "stripe_secret" => "",
            "decimal_number" => "2",
            "tax_type" => "",
            "shipping_display" => "on",
            "journal_prefix" => "#JUR",
            "display_landing_page" => "on",
            "title_text" => "vCardgo-SaaS",
            "company_logo" => 'logo-dark.png',
            "company_logo_light" => 'logo-light.png',
            "company_favicon" => 'favicon.png',
            "signup_button" => "on",
            "email_verification" => 'on',
            "color" => "theme-3",
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "SITE_RTL" => "",
            "storage_setting" => "local",
            "local_storage_validation" => "jpg,jpeg,png",
            "local_storage_max_upload_size" => "250000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url" => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
            "google_calender_id" => "",
            "google_calender_json_file" => "",
            "Google_Calendar" => "",
            'enable_cookie' => 'on',
            'necessary_cookies' => 'on',
            'cookie_logging' => 'on',
            'cookie_title' => 'We use cookies!',
            'cookie_description' => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it',
            'strictly_cookie_title' => 'Strictly necessary cookies',
            'strictly_cookie_description' => 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
            'more_information_description' => 'For any queries in relation to our policy on cookies and your choices,',
            'contactus_url' => '#',
            'chatgpt_key' => '',
            "disable_lang" => '',
            'company_default_language' => 'en',
            'mail_driver' => '',
            'mail_host' => '',
            'mail_port' => '',
            'mail_username' => '',
            'mail_password' => '',
            'mail_encryption' => '',
            'mail_from_address' => '',
            'mail_from_name' => '',
            'timezone' => 'Asia/Kolkata',
            'RECAPTCHA_MODULE'=>'no',
            'NOCAPTCHA_SITEKEY'=>'',
            'NOCAPTCHA_SECRET'=>''
        ];

        foreach (self::$storesettings as $row) {
            $settings[$row->name] = $row->value;

        }

        return $settings;
    }

    public static function getStorageSetting()
    {
        if (self::$storagesettings == null) {
            $data = Utility::getSetting();
            self::$storagesettings = $data;
        }

        $settings = [
            "storage_setting" => "local",
            "local_storage_validation" => "jpg,jpeg,png",
            "local_storage_max_upload_size" => "250000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url" => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
        ];

        foreach (self::$storagesettings as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function getSetting()
    {
        if (self::$getsettings == null) {
            $data = DB::table('settings');
            $data = $data->where('created_by', '=', 1)->get();
            if (count($data) == 0) {
                $data = DB::table('settings')->where('created_by', '=', 1)->get();
            }
            self::$getsettings = $data;
        }
        return self::$getsettings;
    }

    public static function getSettingById($id)
    {
        if (self::$getsettingsid == null) {
            $data = DB::table('settings');
            $data = $data->where('created_by', '=', $id)->get();
            if (count($data) == 0) {
                $data = DB::table('settings')->where('created_by', '=', 1)->get();
            }
            self::$getsettingsid = $data;
        }
        return self::$getsettingsid;
    }

    public static function languages()
    {
        if (self::$languages == null) {
            $languages = Utility::langList();

            if (\Schema::hasTable('language')) {
                $settings = Utility::langSetting();
                if (!empty($settings['disable_lang'])) {
                    $disabledlang = explode(',', $settings['disable_lang']);
                    $languages = Languages::whereNotIn('code', $disabledlang)->pluck('fullName', 'code');
                } else {
                    $languages = Languages::pluck('fullName', 'code');
                }
            }
            self::$languages = $languages;
        }

        return self::$languages;
    }

    public static function getValByName($key)
    {
        $setting = Utility::settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }
    public static function getAdminPaymentSetting()
    {
        if (self::$adminpaymentsettings == null) {
            $data = \DB::table('admin_payment_settings');
            $settings = [];
            if (\Auth::check()) {
                $user_id = 1;
                $data = $data->where('created_by', '=', $user_id);

            }
            $data = $data->get();
            self::$adminpaymentsettings = $data;
        }


        foreach (self::$adminpaymentsettings as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function getPaymentIsOn()
    {
        $payments = self::getAdminPaymentSetting();
        if (isset($payments['is_stripe_enabled']) && $payments['is_stripe_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paypal_enabled']) && $payments['is_paypal_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paystack_enabled']) && $payments['is_paystack_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_flutterwave_enabled']) && $payments['is_flutterwave_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_razorpay_enabled']) && $payments['is_razorpay_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_mercado_enabled']) && $payments['is_mercado_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paytm_enabled']) && $payments['is_paytm_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_mollie_enabled']) && $payments['is_mollie_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_skrill_enabled']) && $payments['is_skrill_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_coingate_enabled']) && $payments['is_coingate_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_toyyibpay_enabled']) && $payments['is_toyyibpay_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_payfast_enabled']) && $payments['is_payfast_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_iyzipay_enabled']) && $payments['is_iyzipay_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_sspay_enabled']) && $payments['is_sspay_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paytab_enabled']) && $payments['is_paytab_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_benefit_enabled']) && $payments['is_benefit_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_cashfree_enabled']) && $payments['is_cashfree_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_aamarpay_enabled']) && $payments['is_aamarpay_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_manually_enabled']) && $payments['is_manually_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_bank_enabled']) && $payments['is_bank_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paytr_enabled']) && $payments['is_paytr_enabled'] == 'on') {
            return true;
        } else {
            return false;
        }

    }

    public static function addCreatedByInVisitor()
    {
    }

    public static function getDefaultThemeOrder($themename)
    {
        $order = [];
        if ($themename == 'theme1') {
            $order = [
                'description' => '1',
                'contact_info' => '2',
                'bussiness_hour' => '3',
                'appointment' => '4',
                'service' => '5',
                'product' => '6',
                'gallery' => '7',
                'more' => '8',
                'testimonials' => '9',
                'social' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme2') {
            $order = [
                'description' => '1',
                'service' => '2',
                'product' => '3',
                'contact_info' => '4',
                'bussiness_hour' => '5',
                'appointment' => '6',
                'gallery' => '7',
                'more' => '8',
                'testimonials' => '9',
                'social' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme3') {
            $order = [
                'description' => '1',
                'gallery' => '2',
                'service' => '3',
                'bussiness_hour' => '4',
                'product' => '5',
                'contact_info' => '6',
                'appointment' => '7',
                'testimonials' => '8',
                'social' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme4') {
            $order = [
                'description' => '1',
                'gallery' => '2',
                'service' => '3',
                'product' => '4',
                'bussiness_hour' => '5',
                'contact_info' => '6',
                'appointment' => '7',
                'testimonials' => '8',
                'social' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme5') {
            $order = [
                'description' => '1',
                'social' => '2',
                'service' => '3',
                'product' => '4',
                'bussiness_hour' => '5',
                'gallery' => '6',
                'appointment' => '7',
                'testimonials' => '8',
                'contact_info' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme6') {
            $order = [
                'description' => '1',
                'contact_info' => '2',
                'service' => '3',
                'product' => '4',
                'bussiness_hour' => '5',
                'appointment' => '6',
                'gallery' => '7',
                'testimonials' => '8',
                'social' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme7') {
            $order = [
                'description' => '1',
                'gallery' => '2',
                'service' => '3',
                'product' => '4',
                'bussiness_hour' => '5',
                'appointment' => '6',
                'social' => '7',
                'contact_info' => '8',
                'testimonials' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme8') {
            $order = [
                'description' => '1',
                'social' => '2',
                'service' => '3',
                'product' => '4',
                'appointment' => '5',
                'bussiness_hour' => '6',
                'gallery' => '7',
                'contact_info' => '8',
                'testimonials' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme9') {
            $order = [
                'description' => '1',
                'social' => '2',
                'service' => '3',
                'product' => '4',
                'appointment' => '5',
                'bussiness_hour' => '6',
                'gallery' => '7',
                'contact_info' => '8',
                'testimonials' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme10') {
            $order = [
                'description' => '1',
                'appointment' => '2',
                'contact_info' => '3',
                'service' => '4',
                'product' => '5',
                'bussiness_hour' => '6',
                'gallery' => '7',
                'testimonials' => '8',
                'social' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme11') {
            $order = [
                'description' => '1',
                'contact_info' => '2',
                'gallery' => '3',
                'social' => '4',
                'service' => '5',
                'product' => '6',
                'bussiness_hour' => '7',
                'appointment' => '8',
                'testimonials' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme12') {
            $order = [
                'description' => '1',
                'contact_info' => '2',
                'bussiness_hour' => '3',
                'appointment' => '4',
                'service' => '5',
                'product' => '6',
                'gallery' => '7',
                'more' => '8',
                'testimonials' => '9',
                'social' => '10',
                'custom_html' => '11',

            ];
        }
        if ($themename == 'theme13') {
            $order = [
                'description' => '1',
                'contact_info' => '2',
                'bussiness_hour' => '3',
                'appointment' => '4',
                'service' => '5',
                'product' => '6',
                'gallery' => '7',
                'more' => '8',
                'testimonials' => '9',
                'social' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme14') {
            $order = [
                'description' => '1',
                'contact_info' => '2',
                'appointment' => '3',
                'testimonials' => '4',
                'bussiness_hour' => '5',
                'service' => '6',
                'product' => '7',
                'gallery' => '8',
                'more' => '9',
                'social' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme15') {
            $order = [
                'more' => '1',
                'description' => '2',
                'social' => '3',
                'appointment' => '4',
                'service' => '5',
                'product' => '6',
                'gallery' => '7',
                'testimonials' => '8',
                'bussiness_hour' => '9',
                'contact_info' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme16') {
            $order = [
                'appointment' => '1',
                'service' => '2',
                'product' => '3',
                'gallery' => '4',
                'testimonials' => '5',
                'bussiness_hour' => '6',
                'contact_info' => '7',
                'more' => '8',
                'custom_html' => '9',
                'social' => '10',
            ];
        }
        if ($themename == 'theme17') {
            $order = [
                'description' => '1',
                'social' => '2',
                'contact_info' => '3',
                'appointment' => '4',
                'testimonials' => '5',
                'bussiness_hour' => '6',
                'service' => '7',
                'product' => '8',
                'gallery' => '9',
                'more' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme18') {
            $order = [
                'contact_info' => '1',
                'more' => '2',
                'description' => '3',
                'appointment' => '4',
                'testimonials' => '5',
                'bussiness_hour' => '6',
                'service' => '7',
                'product' => '8',
                'gallery' => '9',
                'social' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme19') {
            $order = [
                'description' => '1',
                'contact_info' => '2',
                'more' => '3',
                'appointment' => '4',
                'service' => '5',
                'product' => '6',
                'gallery' => '7',
                'testimonials' => '8',
                'bussiness_hour' => '9',
                'social' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme20') {
            $order = [
                'more' => '1',
                'service' => '2',
                'product' => '3',
                'scan_me' => '4',
                'gallery' => '5',
                'appointment' => '6',
                'contact_info' => '7',
                'testimonials' => '8',
                'bussiness_hour' => '9',
                'social' => '10',
                'custom_html' => '11',
            ];
        }
        if ($themename == 'theme21') {
            $order = [
                'contact_info' => '1',
                'description' => '2',
                'appointment' => '3',
                'service' => '4',
                'product' => '5',
                'gallery' => '6',
                'testimonials' => '7',
                'social' => '8',
                'more' => '9',
                'custom_html' => '10',
            ];
        }
        return $order;
    }
    public static function isEnableBlock($block, $id)
    {
        if ($block == 'contact_info') {
            $block_data = ContactInfo::contactData($id);
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }

        }
        if ($block == 'bussiness_hour') {
            $block_data = business_hours::businessHour($id);
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'appointment') {
            $block_data = appoinment::appointmentData($id);
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'service') {
            $block_data = service::serviceData($id);
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'testimonials') {
            $block_data = testimonial::testimonialData($id);
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'social') {
            $block_data = social::socialData($id);
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'custom_html') {
            $block_data = Business::where('id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_custom_html_enabled;
            } else {
                $isenable = '0';
            }
        }
        //Gallery
        if ($block == 'gallery') {
            $block_data = Gallery::galleryData($id);
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        //product
        if ($block == 'product') {
            $block_data = Product::productData($id);
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        return $isenable;
    }

    public static function getDateFormated($date, $time = false)
    {
        if (!empty($date) && $date != '0000-00-00') {
            if ($time == true) {
                return date("d M Y H:i A", strtotime($date));
            } else {
                return date("d M Y", strtotime($date));
            }
        } else {
            return '';
        }
    }
    public static function getfonts()
    {
        $fonts = [
            "Default" => [
                "link" => "https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap",
                "fontfamily" => "Inter,sans-serif",
            ],
            "Roboto" => [
                "link" => "https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap",
                "fontfamily" => "Roboto,sans-serif",
            ],
            "OpenSans" => [
                "link" => "https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap",
                "fontfamily" => "Open Sans,sans-serif",
            ],
            "Montserrat" => [
                "link" => "https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap",
                "fontfamily" => "Montserrat,sans-serif",
            ],
            "Lato" => [
                "link" => "https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap",
                "fontfamily" => "Lato,sans-serif",
            ],
            "Raleway" => [
                "link" => "https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap",
                "fontfamily" => "Raleway,sans-serif",
            ],
            "PTSans" => [
                "link" => "https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap",
                "fontfamily" => "PT Sans,sans-serif",
            ],
            "WorkSans" => [
                "link" => "https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap",
                "fontfamily" => "Work Sans,sans-serif",
            ],
            "Merriweather" => [
                "link" => "https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap",
                "fontfamily" => "Merriweather,serif",
            ],
            "Prompt" => [
                "link" => "https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap",
                "fontfamily" => "Prompt,sans-serif",
            ],
            "ConcertOne" => [
                "link" => "https://fonts.googleapis.com/css2?family=Concert+One&display=swap",
                "fontfamily" => "Concert One,cursive",
            ],
        ];

        return $fonts;
    }
    public static function getvalueoffont($font)
    {
        $allfonts = Utility::getfonts();
        if (!isset($allfonts[$font]) || empty($allfonts[$font])) {
            $allfonts[$font] = '';
        }

        return $allfonts[$font];
    }

    public static function colorset()
    {
        if (self::$colorset == null) {
            if (\Auth::user()) {

                if (\Auth::user()->type == 'super admin') {
                    $user = \Auth::user();
                    $setting = DB::table('settings')->where('created_by', $user->id)->pluck('value', 'name')->toArray();
                } else {
                    $setting = DB::table('settings')->where('created_by', \Auth::user()->creatorId())->pluck('value', 'name')->toArray();
                }
            } else {
                $user = User::where('type', 'super admin')->first();
                $setting = DB::table('settings')->where('created_by', $user->id)->pluck('value', 'name')->toArray();
            }
            if (!isset($setting['color'])) {
                $setting = Utility::settings();
            }
            self::$colorset = $setting;
        }
        return self::$colorset;
    }

    public static function GetLogo()
    {
        $setting = Utility::colorset();

        if (\Auth::user() && \Auth::user()->type != 'super admin') {

            if (Utility::getValByName('cust_darklayout') == 'on') {

                return Utility::getValByName('company_logo_light');
            } else {
                return Utility::getValByName('company_logo');
            }
        } else {

            if (Utility::getValByName('cust_darklayout') == 'on') {

                return Utility::getValByName('landing_logo');
            } else {
                return Utility::getValByName('logo');
            }
        }
    }

    public static function getLayoutsSetting()
    {
        if (self::$layoutsetting == null) {
            if (\Auth::check()) {
                $data = Utility::getSettingById(\Auth::user()->creatorId());
                $created_by = \Auth::user()->creatorId();
                if (count($data) == 0) {
                    $data = Utility::getSetting();
                    $created_by = 1;
                }
            } else {
                $data = Utility::getSetting();
                $created_by = 1;
            }
            self::$layoutsetting = $data;
        }
        $settings = [
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "color" => "theme-3",
            "SITE_RTL" => "off",
            "created_by" => $created_by,
        ];
        foreach (self::$layoutsetting as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }
    public static function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }

    public static function userDefaultData()
    {
        // Make Entry In User_Email_Template
        $allEmail = EmailTemplate::all();
        foreach ($allEmail as $email) {
            UserEmailTemplate::create(
                [
                    'template_id' => $email->id,
                    'user_id' => 1,
                    'is_active' => 1,
                ]
            );
        }
    }

    // Common Function That used to send mail with check all cases
    public static function sendEmailTemplate($emailTemplate, $obj, $mailTo)
    {

        if (empty($obj->lang)) {
            $user = User::where('id', $obj['created_by'])->first();
            $obj['lang'] = $user->lang;
        }

        // find template is exist or not in our record
        $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();

        if (isset($template) && !empty($template)) {
            // check template is active or not by company
            $is_actives = UserEmailTemplate::where('template_id', '=', $template->id)->first();


            if ($is_actives->is_active == 1) {
                // get email content language base
                $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $obj['lang'])->first();

                $content->from = $template->from;


                if (!empty($content->content)) {

                    $content->content = self::replaceVariables($content->content, $obj);
                    if (\Auth::user()->type == "super admin") {
                        $settings = self::settings();
                    } else {
                        $settings = self::settings();
                    }


                    if ($emailTemplate == "Appointment Created") {
                        $userdata = [
                            'from_name' => $obj['appointment_name'],
                            'from_email' => $obj['appointment_email'],

                        ];
                    }


                    // send email

                    try {
                        config(
                            [
                                'mail.driver' => $settings['mail_driver'],
                                'mail.host' => $settings['mail_host'],
                                'mail.port' => $settings['mail_port'],
                                'mail.encryption' => $settings['mail_encryption'],
                                'mail.username' => $settings['mail_username'],
                                'mail.password' => $settings['mail_password'],
                                'mail.from.address' => $settings['mail_from_address'],
                                'mail.from.name' => $settings['mail_from_name'],
                            ]
                        );
                        Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));

                    } catch (\Exception $e) {
                        $error = __('E-Mail has been not sent due to SMTP configuration');
                    }
                    if (isset($error)) {
                        $arReturn = [
                            'is_success' => false,
                            'error' => $error,
                        ];
                    } else {
                        $arReturn = [
                            'is_success' => true,
                            'error' => false,
                        ];
                    }
                } else {
                    $arReturn = [
                        'is_success' => false,
                        'error' => __('Mail not send, email is empty'),
                    ];
                }
                return $arReturn;
            } else {
                return [
                    'is_success' => true,
                    'error' => false,
                ];
            }
        } else {
            return [
                'is_success' => false,
                'error' => __('Mail not send, email not found'),
            ];
        }

    }

    public static function sendEmailTemplateUser($emailTemplate, $obj, $mailTo)
    {

        if (empty($obj->lang)) {
            $user = User::where('id', $obj['created_by'])->first();
            $obj['lang'] = $user->lang;
        }

        // find template is exist or not in our record
        $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();

        if (isset($template) && !empty($template)) {
            // check template is active or not by company
            $is_actives = UserEmailTemplate::where('template_id', '=', $template->id)->first();


            if ($is_actives->is_active == 1) {
                // get email content language base
                $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $obj['lang'])->first();

                $content->from = $template->from;


                if (!empty($content->content)) {

                    $content->content = self::replaceVariables($content->content, $obj);
                    $settings = self::settings();
                    if ($emailTemplate == "Appointment Created") {
                        $userdata = [
                            'from_name' => $obj['appointment_name'],
                            'from_email' => $obj['appointment_email'],

                        ];
                    }

                    // send email

                    try {
                        config(
                            [
                                'mail.driver' => $settings['mail_driver'],
                                'mail.host' => $settings['mail_host'],
                                'mail.port' => $settings['mail_port'],
                                'mail.encryption' => $settings['mail_encryption'],
                                'mail.username' => $settings['mail_username'],
                                'mail.password' => $settings['mail_password'],
                                'mail.from.address' => $settings['mail_from_address'],
                                'mail.from.name' => $settings['mail_from_name'],
                            ]
                        );
                        Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));

                    } catch (\Exception $e) {
                        $error = __('E-Mail has been not sent due to SMTP configuration');
                    }
                    if (isset($error)) {
                        $arReturn = [
                            'is_success' => false,
                            'error' => $error,
                        ];
                    } else {
                        $arReturn = [
                            'is_success' => true,
                            'error' => false,
                        ];
                    }
                } else {
                    $arReturn = [
                        'is_success' => false,
                        'error' => __('Mail not send, email is empty'),
                    ];
                }
                return $arReturn;
            } else {
                return [
                    'is_success' => true,
                    'error' => false,
                ];
            }
        } else {
            return [
                'is_success' => false,
                'error' => __('Mail not send, email not found'),
            ];
        }

    }
    // used for replace email variable (parameter 'template_name','id(get particular record by id for data)')
    public static function replaceVariables($content, $obj)
    {

        $arrVariable = [
            '{app_name}',
            '{app_url}',
            '{user_name}',
            '{user_email}',
            '{user_password}',
            '{user_type}',
            '{appointment_name}',
            '{appointment_email}',
            '{appointment_phone}',
            '{appointment_date}',
            '{appointment_time}',
        ];
        $arrValue = [
            'app_name' => '-',
            'app_url' => '-',
            'user_name' => '-',
            'user_email' => '-',
            'user_password' => '-',
            'user_type' => '-',
            'appointment_name' => '-',
            'appointment_email' => '-',
            'appointment_phone' => '-',
            'appointment_date' => '-',
            'appointment_time' => '-',
        ];
        foreach ($obj as $key => $val) {

            $arrValue[$key] = $val;
        }

        $arrValue['app_name'] = (isset(\Utility::settings()['company_name']) && !empty(\Utility::settings()['company_name'])) ? \Utility::settings()['company_name'] : env('APP_NAME');
        $arrValue['app_url'] = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';

        return str_replace($arrVariable, array_values($arrValue), $content);
    }
    public static function paySettings()
    {
        $data = DB::table('admin_payment_settings');

        if (\Auth::check()) {
            $userId = \Auth::user()->creatorId();
            $data = $data->where('created_by', '=', $userId);
        } else {
            $data = $data->where('created_by', '=', 1);
        }
        $data = $data->get();
        $settings = [

            "is_stripe_enabled" => "off",
            "is_paypal_enabled" => "off",
            "is_paystack_enabled" => "off",
            "is_flutterwave_enabled" => "off",
            "is_razorpay_enabled" => "off",
            "is_mercado_enabled" => "off",
            "is_paytm_enabled" => "off",
            "is_mollie_enabled" => "off",
            "is_skrill_enabled" => "off",
            "is_coingate_enabled" => "off",

        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }
    public static function error_res($msg = "", $args = array())
    {
        $msg = $msg == "" ? "error" : $msg;
        $msg_id = 'error.' . $msg;
        $converted = \Lang::get($msg_id, $args);
        $msg = $msg_id == $converted ? $msg : $converted;
        $json = array(
            'flag' => 0,
            'msg' => $msg,
        );

        return $json;
    }

    public static function success_res($msg = "", $args = array())
    {
        $msg = $msg == "" ? "success" : $msg;
        $msg_id = 'success.' . $msg;
        $converted = \Lang::get($msg_id, $args);
        $msg = $msg_id == $converted ? $msg : $converted;
        $json = array(
            'flag' => 1,
            'msg' => $msg,
        );

        return $json;
    }
    public static function upload_file($request, $key_name, $name, $path, $custom_validation = [])
    {
        try {
            $settings = Utility::getStorageSetting();
            if (!empty($settings['storage_setting'])) {

                if ($settings['storage_setting'] == 'wasabi') {

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes = !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';

                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes = !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';


                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes = !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $file = $request->$key_name;


                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];

                }

                $validator = \Validator::make($request->all(), [
                    $key_name => $validation
                ]);

                if ($validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;
                    if ($settings['storage_setting'] == 'local') {
                        $request->$key_name->move(storage_path($path), $name);
                        $path = $path . $name;

                    } else if ($settings['storage_setting'] == 'wasabi') {

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $file,
                            $name
                        );



                    } else if ($settings['storage_setting'] == 's3') {

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                    }


                    $res = [
                        'flag' => 1,
                        'msg' => 'success',
                        'url' => $path
                    ];
                    return $res;
                }

            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }


    public static function get_file($path)
    {
        $settings = Utility::getStorageSetting();

        try {
            if ($settings['storage_setting'] == 'wasabi') {
                config(
                    [
                        'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                        'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                        'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                        'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                        'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                    ]
                );
            } elseif ($settings['storage_setting'] == 's3') {
                config(
                    [
                        'filesystems.disks.s3.key' => $settings['s3_key'],
                        'filesystems.disks.s3.secret' => $settings['s3_secret'],
                        'filesystems.disks.s3.region' => $settings['s3_region'],
                        'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                        'filesystems.disks.s3.use_path_style_endpoint' => false,
                    ]
                );
            }

            return \Storage::disk($settings['storage_setting'])->url($path);
        } catch (\Throwable $th) {
            return '';
        }
    }


    public static function keyWiseUpload_file($request, $key_name, $name, $path, $data_name, $data_key, $custom_validation = [])
    {
        try {
            $settings = Utility::getStorageSetting();


            if (!empty($settings['storage_setting'])) {

                if ($settings['storage_setting'] == 'wasabi') {

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes = !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';

                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes = !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';


                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes = !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $file = $request->$key_name;
                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];

                }
                $validator = \Validator::make($request->file($data_name)[$data_key], [
                    $key_name => $validation
                ]);

                if ($validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    if ($settings['storage_setting'] == 'local') {

                        \Storage::disk()->putFileAs(
                            $path,
                            $request->file($data_name)[$data_key][$key_name],
                            $name
                        );


                        $path = $path . $name;
                    } else if ($settings['storage_setting'] == 'wasabi') {

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $request->file($data_name)[$data_key][$key_name],
                            $name
                        );



                    } else if ($settings['storage_setting'] == 's3') {

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $request->file($data_name)[$data_key][$key_name],
                            $name
                        );

                    }


                    $res = [
                        'flag' => 1,
                        'msg' => 'success',
                        'url' => $path
                    ];
                    return $res;
                }

            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    //googleCalendar
    public static function colorCodeData($type)
    {
        if ($type == 'event') {
            return 1;
        } elseif ($type == 'zoom_meeting') {
            return 2;
        } elseif ($type == 'task') {
            return 3;
        } elseif ($type == 'appointment') {
            return 11;
        } elseif ($type == 'rotas') {
            return 3;
        } elseif ($type == 'holiday') {
            return 4;
        } elseif ($type == 'call') {
            return 10;
        } elseif ($type == 'meeting') {
            return 5;
        } elseif ($type == 'leave') {
            return 6;
        } elseif ($type == 'work_order') {
            return 7;
        } elseif ($type == 'lead') {
            return 7;
        } elseif ($type == 'deal') {
            return 8;
        } elseif ($type == 'interview_schedule') {
            return 9;
        } else {
            return 11;
        }
    }

    public static $colorCode = [
        1 => 'event-warning',
        2 => 'event-secondary',
        3 => 'event-success',
        4 => 'event-warning',
        5 => 'event-danger',
        6 => 'event-dark',
        7 => 'event-black',
        8 => 'event-info',
        9 => 'event-secondary',
        10 => 'event-success',
        11 => 'event-warning',
    ];

    public static function googleCalendarConfig()
    {
        $setting = Utility::settings();
        $path = storage_path($setting['google_calender_json_file']);
        config([
            'google-calendar.default_auth_profile' => 'service_account',
            'google-calendar.auth_profiles.service_account.credentials_json' => $path,
            'google-calendar.auth_profiles.oauth.credentials_json' => $path,
            'google-calendar.auth_profiles.oauth.token_json' => $path,
            'google-calendar.calendar_id' => isset($setting['google_calender_id']) ? $setting['google_calender_id'] : '',
            'google-calendar.user_to_impersonate' => '',

        ]);
    }
    public static function addCalendarData($request, $type)
    {
        self::googleCalendarConfig();

        $event = new GoogleEvent();
        $event->name = $request->get('title');
        $event->startDateTime = Carbon::parse($request->get('start_date'));
        $event->endDateTime = Carbon::parse($request->get('end_date'));
        $event->colorId = self::colorCodeData($type);

        $event->save();
    }
    public static function getCalendarData($type)
    {
        self::googleCalendarConfig();

        $data = GoogleEvent::get();

        $type = self::colorCodeData($type);
        $arrayJson = [];
        foreach ($data as $val) {
            $end_date = date_create($val->endDateTime);
            date_add($end_date, date_interval_create_from_date_string("1 days"));

            if ($val->colorId == "$type") {

                $arrayJson[] = [
                    "id" => $val->id,
                    "title" => $val->summary,
                    "start" => $val->startDateTime,
                    "end" => date_format($end_date, "Y-m-d H:i:s"),
                    "className" => self::$colorCode[$type],
                    "allDay" => true,
                ];
            }

        }
        return $arrayJson;
    }

    //Gallary Option
    public static function gallaryoption()
    {
        $gallaryOption = [
            'video' => 'Video',
            'image' => 'Image',
            'custom_image_link' => 'Custom Image',
            'custom_video_link' => 'Custom Video',
        ];
        return $gallaryOption;
    }

    //PixelField
    public static function pixel_plateforms()
    {
        $plateforms = [
            '' => 'Please select',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'linkedin' => 'Linkedin',
            'pinterest' => 'Pinterest',
            'quora' => 'Quora',
            'bing' => 'Bing',
            'google-adwords' => 'Google Adwords',
            'google-analytics' => 'Google Analytics',
            'snapchat' => 'Snapchat',
            'tiktok' => 'Tiktok',
        ];

        return $plateforms;
    }
    //WebHook
    public static function webhookSetting($module, $id)
    {
        if (\Auth::user()) {
            $webhook = Webhook::where('module', $module)->where('created_by', '=', $id)->first();
        } else {
            $webhook = Webhook::where('module', $module)->where('created_by', '=', $id)->first();
        }
        if (!empty($webhook)) {
            $url = $webhook->url;
            $method = $webhook->method;
            $reference_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $data['method'] = $method;
            $data['reference_url'] = $reference_url;
            $data['url'] = $url;
            return $data;
        }
        return false;

    }

    public static function WebhookCall($url = null, $parameter = null, $method = 'POST')
    {
        if (!empty($url) && !empty($parameter)) {
            try {
                $curlHandle = curl_init($url);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameter);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                $curlResponse = curl_exec($curlHandle);
                curl_close($curlHandle);
                if (empty($curlResponse)) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Throwable $th) {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function cookie_settings()
    {
        if (self::$cookiesettings == null) {
            $data = Utility::getSetting();
            self::$cookiesettings = $data;
        }

        $cookie_settings = [
            "enable_cookie" => "on",
            "default_language" => "en",
            "cookie_title" => "We use cookies!",
            "cookie_description" => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it.',
            "strictly_cookie_title" => "Strictly necessary cookies",
            "strictly_cookie_description" => "These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly",
            "contact_description" => "For any queries in relation to our policy on cookies and your choices,",
            'more_information_description' => 'For any queries in relation to our policy on cookies and your choices,please',
            "contactus_url" => '<a class="cc-link" href="#yourcontactpage">contact us</a>.',
        ];
        foreach (self::$cookiesettings as $row) {
            if (array_key_exists($row->name, $cookie_settings)) {
                $cookie_settings[$row->name] = $row->value;
            }
        }
        return $cookie_settings;
    }

    public static function getsettingsbyid($id)
    {
        $data = Utility::getSettingById($id);

        $settings = [
            "site_currency" => "USD",
            "site_currency_symbol" => "$",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INVO",
            "invoice_color" => "ffffff",
            "proposal_prefix" => "#PROP",
            "proposal_color" => "ffffff",
            "bill_prefix" => "#BILL",
            "bill_color" => "ffffff",
            "customer_prefix" => "#CUST",
            "vender_prefix" => "#VEND",
            "footer_text" => "",
            "footer_notes" => "",
            "invoice_template" => "template1",
            "bill_template" => "template1",
            "proposal_template" => "template1",
            "registration_number" => "",
            "vat_number" => "",
            "default_language" => "en",
            "enable_stripe" => "",
            "enable_paypal" => "",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "stripe_key" => "",
            "stripe_secret" => "",
            "decimal_number" => "2",
            "tax_type" => "",
            "shipping_display" => "on",
            "journal_prefix" => "#JUR",
            "display_landing_page" => "on",
            "title_text" => "vCardgo-SaaS",
            "company_logo" => 'logo-dark.png',
            "company_logo_light" => 'logo-light.png',
            "company_favicon" => 'favicon.png',
            "signup_button" => "on",
            "email_verification" => 'on',
            "color" => "theme-3",
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "SITE_RTL" => "",
            "storage_setting" => "local",
            "local_storage_validation" => "jpg,jpeg,png",
            "local_storage_max_upload_size" => "250000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url" => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
            "google_calender_id" => "",
            "google_calender_json_file" => "",
            "Google_Calendar" => "",
            'enable_cookie' => 'on',
            'necessary_cookies' => 'on',
            'cookie_logging' => 'on',
            'cookie_title' => 'We use cookies!',
            'cookie_description' => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it',
            'strictly_cookie_title' => 'Strictly necessary cookies',
            'strictly_cookie_description' => 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
            'more_information_description' => 'For any queries in relation to our policy on cookies and your choices,',
            'contactus_url' => '#',
            'chatgpt_key' => '',
            'company_default_language' => 'en'
        ];

        foreach ($data as $row) {

            $settings[$row->name] = $row->value;

        }

        return $settings;
    }

    public static function flagOfCountry()
    {
        $arr = [
            'ar' => '🇦🇪 ar',
            'da' => '🇩🇰 da',
            'de' => '🇩🇪 de',
            'es' => '🇪🇸 es',
            'fr' => '🇫🇷 fr',
            'it' => '🇮🇹 it',
            'ja' => '🇯🇵 ja',
            'nl' => '🇳🇱 nl',
            'pl' => '🇵🇱 pl',
            'ru' => '🇷🇺 ru',
            'pt' => '🇵🇹 pt',
            'en' => '🇮🇳 en',
            'tr' => '🇹🇷 tr',
            'pt-br' => '🇵🇹 pt-br',
            'zh' => '🇨🇳 zh',
            'he' => '🇮🇱 he',

        ];
        return $arr;
    }

    public static function chatgpt_setting($company_id)
    {
        if (\Auth::user()->type == "super admin") {
            $data = Utility::getSetting();
            $chatgpt_setting = [
                "chatgpt_key" => '',
            ];
            foreach ($data as $row) {
                if (array_key_exists($row->name, $chatgpt_setting)) {
                    $chatgpt_setting[$row->name] = $row->value;
                }
            }
        } else {
            $user = User::find($company_id);
            $data = Plan::where('id', $user->plan)->get();
            $chatgpt_setting = [
                "enable_chatgpt" => '',
            ];
            foreach ($data as $row) {
                if (array_key_exists('enable_chatgpt', $chatgpt_setting)) {
                    $chatgpt_setting['enable_chatgpt'] = $row->enable_chatgpt;
                }
            }
        }
        return $chatgpt_setting;
    }

    public static function updateStorageLimit($company_id, $image_size)
    {
        $image_size = number_format($image_size / 1048576, 2);

        $user = User::find($company_id);
        $plan = Plan::find($user->plan);
        $total_storage = $user->storage_limit + $image_size;
        if ($plan->storage_limit <= $total_storage && $plan->storage_limit != -1) {

            $error = __('Plan storage limit is over so please upgrade the plan.');
            return $error;
        } else {
            $user->storage_limit = $total_storage;
        }

        $user->save();
        return 1;

    }

    public static function changeStorageLimit($company_id, $file_path)
    {

        $files = \File::glob(storage_path($file_path));

        $fileSize = 0;
        foreach ($files as $file) {
            $fileSize += \File::size($file);
        }

        $image_size = number_format($fileSize / 1048576, 2);
        $user = User::find($company_id);
        $plan = Plan::find($user->plan);
        $total_storage = $user->storage_limit - $image_size;
        $user->storage_limit = $total_storage;
        $user->save();

        $status = false;
        foreach ($files as $key => $file) {
            if (\File::exists($file)) {
                $status = \File::delete($file);
            }
        }

        return true;

    }

    public static function changeStorageLimitGallery($company_id, $file_path)
    {

        $files = \File::glob(storage_path($file_path));
        $fileSize = 0;
        foreach ($files as $file) {
            $fileSize += \File::size($file);
        }

        $image_size = number_format($fileSize / 1048576, 2);
        $user = User::find($company_id);
        $plan = Plan::find($user->plan);
        $total_storage = $user->storage_limit - $image_size;
        $user->storage_limit = $total_storage;
        $user->save();

        $status = false;
        foreach ($files as $key => $file) {
            if (\File::exists($file)) {
                //$status = \File::delete($file);
            }
        }

        return true;

    }

    //Language Data 
    public static function languagecreate()
    {
        $languages = Utility::langList();
        foreach ($languages as $key => $lang) {
            $languageExist = Languages::where('code', $key)->first();
            if (empty($languageExist)) {
                $language = new Languages();
                $language->code = $key;
                $language->fullName = $lang;
                $language->save();
            }
        }
        return $languages;
    }

    public static function langSetting()
    {
        $data = Utility::getSetting();
        $settings = [];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }

    public static function langList()
    {
        $languages = [
            "ar" => "Arabic",
            "zh" => "Chinese",
            "da" => "Danish",
            "de" => "German",
            "en" => "English",
            "es" => "Spanish",
            "fr" => "French",
            "he" => "Hebrew",
            "it" => "Italian",
            "ja" => "Japanese",
            "nl" => "Dutch",
            "pl" => "Polish",
            "pt" => "Portuguese",
            "ru" => "Russian",
            "tr" => "Turkish",
            "pt-br" => "Portuguese(Brazil)",
        ];
        return $languages;
    }

    public static function getCurrency()
    {
        $currencies = array(
            'code' =>
                array('code' => 'INR', 'name' => 'Indian', 'symbol' => '₹'),
            array('code' => 'AFN', 'name' => 'Afghani', 'symbol' => '؋'),
            array('code' => 'ANG', 'name' => 'Netherlands Antillian Guilder', 'symbol' => 'ƒ'),
            array('code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => '$'),
            array('code' => 'AWG', 'name' => 'Aruban Guilder', 'symbol' => 'ƒ'),
            array('code' => 'AZN', 'name' => 'Azerbaijanian Manat', 'symbol' => 'ман'),
            array('code' => 'BAM', 'name' => 'Convertible Marks', 'symbol' => 'KM'),
            array('code' => 'BBD', 'name' => 'Barbados Dollar', 'symbol' => '$'),
            array('code' => 'BGN', 'name' => 'Bulgarian Lev', 'symbol' => 'лв'),
            array('code' => 'BMD', 'name' => 'Bermudian Dollar', 'symbol' => '$'),
            array('code' => 'BND', 'name' => 'Brunei Dollar', 'symbol' => '$'),
            array('code' => 'BOB', 'name' => 'BOV Boliviano Mvdol', 'symbol' => '$b'),
            array('code' => 'BRL', 'name' => 'Brazilian Real', 'symbol' => 'R$'),
            array('code' => 'BSD', 'name' => 'Bahamian Dollar', 'symbol' => '$'),
            array('code' => 'BWP', 'name' => 'Pula', 'symbol' => 'P'),
            array('code' => 'BYR', 'name' => 'Belarussian Ruble', 'symbol' => 'p.'),
            array('code' => 'BZD', 'name' => 'Belize Dollar', 'symbol' => 'BZ$'),
            array('code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => '$'),
            array('code' => 'CHF', 'name' => 'Swiss Franc', 'symbol' => 'CHF'),
            array('code' => 'CLP', 'name' => 'CLF Chilean Peso Unidades de fomento', 'symbol' => '$'),
            array('code' => 'CNY', 'name' => 'Yuan Renminbi', 'symbol' => '¥'),
            array('code' => 'COP', 'name' => 'COU Colombian Peso Unidad de Valor Real', 'symbol' => '$'),
            array('code' => 'CRC', 'name' => 'Costa Rican Colon', 'symbol' => '₡'),
            array('code' => 'CUP', 'name' => 'CUC Cuban Peso Peso Convertible', 'symbol' => '₱'),
            array('code' => 'CZK', 'name' => 'Czech Koruna', 'symbol' => 'Kč'),
            array('code' => 'DKK', 'name' => 'Danish Krone', 'symbol' => 'kr'),
            array('code' => 'DOP', 'name' => 'Dominican Peso', 'symbol' => 'RD$'),
            array('code' => 'EGP', 'name' => 'Egyptian Pound', 'symbol' => '£'),
            array('code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'),
            array('code' => 'FJD', 'name' => 'Fiji Dollar', 'symbol' => '$'),
            array('code' => 'FKP', 'name' => 'Falkland Islands Pound', 'symbol' => '£'),
            array('code' => 'GBP', 'name' => 'Pound Sterling', 'symbol' => '£'),
            array('code' => 'GIP', 'name' => 'Gibraltar Pound', 'symbol' => '£'),
            array('code' => 'GTQ', 'name' => 'Quetzal', 'symbol' => 'Q'),
            array('code' => 'GYD', 'name' => 'Guyana Dollar', 'symbol' => '$'),
            array('code' => 'HKD', 'name' => 'Hong Kong Dollar', 'symbol' => '$'),
            array('code' => 'HNL', 'name' => 'Lempira', 'symbol' => 'L'),
            array('code' => 'HRK', 'name' => 'Croatian Kuna', 'symbol' => 'kn'),
            array('code' => 'HUF', 'name' => 'Forint', 'symbol' => 'Ft'),
            array('code' => 'IDR', 'name' => 'Rupiah', 'symbol' => 'Rp'),
            array('code' => 'ILS', 'name' => 'New Israeli Sheqel', 'symbol' => '₪'),
            array('code' => 'IRR', 'name' => 'Iranian Rial', 'symbol' => '﷼'),
            array('code' => 'ISK', 'name' => 'Iceland Krona', 'symbol' => 'kr'),
            array('code' => 'JMD', 'name' => 'Jamaican Dollar', 'symbol' => 'J$'),
            array('code' => 'JPY', 'name' => 'Yen', 'symbol' => '¥'),
            array('code' => 'KGS', 'name' => 'Som', 'symbol' => 'лв'),
            array('code' => 'KHR', 'name' => 'Riel', 'symbol' => '៛'),
            array('code' => 'KPW', 'name' => 'North Korean Won', 'symbol' => '₩'),
            array('code' => 'KRW', 'name' => 'Won', 'symbol' => '₩'),
            array('code' => 'KYD', 'name' => 'Cayman Islands Dollar', 'symbol' => '$'),
            array('code' => 'KZT', 'name' => 'Tenge', 'symbol' => 'лв'),
            array('code' => 'LAK', 'name' => 'Kip', 'symbol' => '₭'),
            array('code' => 'LBP', 'name' => 'Lebanese Pound', 'symbol' => '£'),
            array('code' => 'LKR', 'name' => 'Sri Lanka Rupee', 'symbol' => '₨'),
            array('code' => 'LRD', 'name' => 'Liberian Dollar', 'symbol' => '$'),
            array('code' => 'LTL', 'name' => 'Lithuanian Litas', 'symbol' => 'Lt'),
            array('code' => 'LVL', 'name' => 'Latvian Lats', 'symbol' => 'Ls'),
            array('code' => 'MKD', 'name' => 'Denar', 'symbol' => 'ден'),
            array('code' => 'MNT', 'name' => 'Tugrik', 'symbol' => '₮'),
            array('code' => 'MUR', 'name' => 'Mauritius Rupee', 'symbol' => '₨'),
            array('code' => 'MXN', 'name' => 'MXV Mexican Peso Mexican Unidad de Inversion (UDI)', 'symbol' => '$'),
            array('code' => 'MYR', 'name' => 'Malaysian Ringgit', 'symbol' => 'RM'),
            array('code' => 'MZN', 'name' => 'Metical', 'symbol' => 'MT'),
            array('code' => 'NGN', 'name' => 'Naira', 'symbol' => '₦'),
            array('code' => 'NIO', 'name' => 'Cordoba Oro', 'symbol' => 'C$'),
            array('code' => 'NOK', 'name' => 'Norwegian Krone', 'symbol' => 'kr'),
            array('code' => 'NPR', 'name' => 'Nepalese Rupee', 'symbol' => '₨'),
            array('code' => 'NZD', 'name' => 'New Zealand Dollar', 'symbol' => '$'),
            array('code' => 'OMR', 'name' => 'Rial Omani', 'symbol' => '﷼'),
            array('code' => 'PAB', 'name' => 'USD Balboa US Dollar', 'symbol' => 'B/.'),
            array('code' => 'PEN', 'name' => 'Nuevo Sol', 'symbol' => 'S/.'),
            array('code' => 'PHP', 'name' => 'Philippine Peso', 'symbol' => 'Php'),
            array('code' => 'PKR', 'name' => 'Pakistan Rupee', 'symbol' => '₨'),
            array('code' => 'PLN', 'name' => 'Zloty', 'symbol' => 'zł'),
            array('code' => 'PYG', 'name' => 'Guarani', 'symbol' => 'Gs'),
            array('code' => 'QAR', 'name' => 'Qatari Rial', 'symbol' => '﷼'),
            array('code' => 'RON', 'name' => 'New Leu', 'symbol' => 'lei'),
            array('code' => 'RSD', 'name' => 'Serbian Dinar', 'symbol' => 'Дин.'),
            array('code' => 'RUB', 'name' => 'Russian Ruble', 'symbol' => 'руб'),
            array('code' => 'SAR', 'name' => 'Saudi Riyal', 'symbol' => '﷼'),
            array('code' => 'SBD', 'name' => 'Solomon Islands Dollar', 'symbol' => '$'),
            array('code' => 'SCR', 'name' => 'Seychelles Rupee', 'symbol' => '₨'),
            array('code' => 'SEK', 'name' => 'Swedish Krona', 'symbol' => 'kr'),
            array('code' => 'SGD', 'name' => 'Singapore Dollar', 'symbol' => '$'),
            array('code' => 'SHP', 'name' => 'Saint Helena Pound', 'symbol' => '£'),
            array('code' => 'SOS', 'name' => 'Somali Shilling', 'symbol' => 'S'),
            array('code' => 'SRD', 'name' => 'Surinam Dollar', 'symbol' => '$'),
            array('code' => 'SVC', 'name' => 'USD El Salvador Colon US Dollar', 'symbol' => '$'),
            array('code' => 'SYP', 'name' => 'Syrian Pound', 'symbol' => '£'),
            array('code' => 'THB', 'name' => 'Baht', 'symbol' => '฿'),
            array('code' => 'TRY', 'name' => 'Turkish Lira', 'symbol' => 'TL'),
            array('code' => 'TTD', 'name' => 'Trinidad and Tobago Dollar', 'symbol' => 'TT$'),
            array('code' => 'TWD', 'name' => 'New Taiwan Dollar', 'symbol' => 'NT$'),
            array('code' => 'UAH', 'name' => 'Hryvnia', 'symbol' => '₴'),
            array('code' => 'USD', 'name' => 'United States Dollar', 'symbol' => '$'),
            array('code' => 'UYU', 'name' => 'UYI Peso Uruguayo Uruguay Peso en Unidades Indexadas', 'symbol' => '$U'),
            array('code' => 'UZS', 'name' => 'Uzbekistan Sum', 'symbol' => 'лв'),
            array('code' => 'VEF', 'name' => 'Bolivar Fuerte', 'symbol' => 'Bs'),
            array('code' => 'VND', 'name' => 'Dong', 'symbol' => '₫'),
            array('code' => 'XCD', 'name' => 'East Caribbean Dollar', 'symbol' => '$'),
            array('code' => 'YER', 'name' => 'Yemeni Rial', 'symbol' => '﷼'),
            array('code' => 'ZAR', 'name' => 'Rand', 'symbol' => 'R'),
        );
        return $currencies;
    }

    public static function setCaptchaConfig()
    {
        config([ 
            'captcha.secret' => Utility::getValByName('NOCAPTCHA_SECRET'),
            'captcha.sitekey' => Utility::getValByName('NOCAPTCHA_SITEKEY') ,
        ]);
    }
}