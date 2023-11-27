<?php
namespace Database\Seeders;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create(
            [
                'name' => 'Free Plan',
                'price' => 0,
                'duration' => 'Lifetime',
                'themes' => 'theme1,theme2,theme3,theme4,theme5,theme6,theme7,theme8,theme9,theme10,theme11,theme12,theme13,theme14,theme15,theme16,theme17,theme18,theme19,theme20,theme21',
                'business'=>'-1',
                'max_users'=>'10',
                'enable_custdomain' => 'on',
                'enable_custsubdomain' => 'on',
                'enable_branding' => 'on',
                'pwa_business'=> 'on',
                'enable_qr_code'=> 'on',
                'enable_chatgpt'=>'on',
                'storage_limit'=>'100.00',
            ]
        );
    }
}
