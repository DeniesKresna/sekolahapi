<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = DB::table('roles')->insert([[
            'name'=>'super_admin',
            'display_name'=>'Admin Page',
            'description'=>'Super Admin',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s")
        ],
        [
            'name'=>'customer',
            'display_name'=>'Customer',
            'description'=>'Customer',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s")
        ]]);

        $user = DB::table('users')->insert([
            [
                'name'=>"Admnistrator",
                'email'=>"barbar.smartit@gmail.com",
                'phone'=>"08157006008",
                'address'=>"Plampitan 12/24",
                'username'=>"barbar",
                'password'=>password_encrypt("barbar123!!!"),
                'active'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ],
            [
                'name'=>"Denies Kresna",
                'email'=>"denies@smart-it.co.id",
                'phone'=>"08157006008",
                'address'=>"Plampitan 12/24",
                'username'=>"barbar",
                'password'=>password_encrypt("denies123!!!"),
                'active'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]
        ]);

        $user = DB::table('role_user')->insert([
            [
                'user_id'=>1,
                'role_id'=>1,
            ],
            [
                'user_id'=>2,
                'role_id'=>2,
            ]
        ]);

        $locations = DB::table('locations')->insert([
            [   "name"=>"Jakarta",
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ],[
                "name"=>"Surabaya",
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ],[ 
                "name"=>"Sidoarjo",
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]
        ]);

        $device_group = DB::table('device_groups')->insert([
            'key' => 'idn_devices',
            'name'  => 'IDN DEVICES',
            'creator_id' => 1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s")
        ]);

        $device_type = DB::table('device_types')->insert([
            [
                'name' => "led",
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ],
            [
                'name' => "screen",
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]
        ]);

        $device = DB::table('devices')->insert([
            [
                'name'=>'551800100114',
                'imei'=>'E10-B17-00535',
                'sim_card_no'=>'0811-9740-4091',
                'sim_card_serial'=>'0015-0000-0904-7037',
                'active'=>0,
                'last_gps_time'=>'2018-11-28 13:01:06',
                'last_screen_time'=>'2018-11-28 13:01:06',
                'last_screen_off_time'=>'2018-10-17 10:34:35',
                'total_distance'=>0,
                'total_screen_time'=>0,
                'total_park_time'=>0,
                'screen_status'=>'off',
                'last_lat'=>0.00000,
                'last_lng'=>0.00000,
                'driver_id'=>113,
                'troubled'=>0,
                'box_id'=>112,
                'location_id'=>1,
                'device_type_id'=>1,
                'device_group_id'=>1,
                'app_version'=>1,
                'creator_id'=> 1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H::i:s")
            ],
            [
                'name'=>'551800100114',
                'imei'=>'355853105999612',
                'sim_card_no'=>'0811-9740-4091',
                'sim_card_serial'=>'0015-0000-0904-7037',
                'active'=>0,
                'last_gps_time'=>'2018-11-28 13:01:06',
                'last_screen_time'=>'2018-11-28 13:01:06',
                'last_screen_off_time'=>'2018-10-17 10:34:35',
                'total_distance'=>0,
                'total_screen_time'=>0,
                'total_park_time'=>0,
                'screen_status'=>'off',
                'last_lat'=>0.00000,
                'last_lng'=>0.00000,
                'driver_id'=>612,
                'troubled'=>0,
                'box_id'=>612,
                'location_id'=>2,
                'device_type_id'=>1,
                'device_group_id'=>1,
                'app_version'=>1,
                'creator_id'=> 1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H::i:s")
            ]
        ]);

        $device_line = DB::table('device_lines')->insert([
            [
                'device_id'=>1,
                'box_id'=>112,
                'driver_id'=>113,
                'device_type_id'=>1,
                'layout_id'=>1
            ],
            [
                'device_id'=>2,
                'box_id'=>612,
                'driver_id'=>612,
                'device_type_id'=>1,
                'layout_id'=>1
            ]
        ]);

        $layout = DB::table('layouts')->insert([
            [
                'name'=>'LED FULL 240x80',
                'timeout'=>15000,
                'type'=>'normal',
                'creator_id'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H::i:s")
            ]
        ]);

        $layout_box = DB::table('layout_boxes')->insert([
            [
                'layout_id'=>1,
                'box_number'=>1,
                'timeout'=>15,
                'data_type'=>'video',
                'width'=>200,
                'height'=>80,
                'below'=>0,
                'right_of'=>0,
                'left_of'=>0,
                'font_size'=>0,
                'enable_slotting'=>1,
                'creator_id'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H::i:s")
            ],
            [
                'layout_id'=>1,
                'box_number'=>2,
                'timeout'=>15,
                'data_type'=>'image',
                'width'=>40,
                'height'=>80,
                'below'=>0,
                'right_of'=>1,
                'left_of'=>0,
                'font_size'=>0,
                'enable_slotting'=>0,
                'creator_id'=>1,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H::i:s")
            ]
        ]);
        //$user->roles()->attach(Role::where("name","super_admin")->pluck('id'));
        //$user->save();
    }
}
