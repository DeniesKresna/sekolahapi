<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class EntrustTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = 'super_admin';
        $role_admin->display_name = 'Admin Page';
        $role_admin->description = 'Super Admin';
        $role_admin->save();

        $role_interled_admin = new Role();
        $role_interled_admin->name = 'interled_admin';
        $role_interled_admin->display_name = 'InterLED Admin Page';
        $role_interled_admin->description = 'InterLED Admin';
        $role_interled_admin->save();

        $role_interscreen_admin = new Role();
        $role_interscreen_admin->name = 'interscreen_admin';
        $role_interscreen_admin->display_name = 'InterScreen Admin Page';
        $role_interscreen_admin->description = 'InterScreen Admin';
        $role_interscreen_admin->save();

//        $role_maintenance_admin = new Role();
//        $role_maintenance_admin->name = 'maintenance_admin';
//        $role_maintenance_admin->display_name = 'Maintenance Admin Page';
//        $role_maintenance_admin->description = 'Maintenance Admin';
//        $role_maintenance_admin->save();

//        $role_shopadmin = new Role();
//        $role_shopadmin->name = 'shopadmin';
//        $role_shopadmin->display_name = 'Seller Page';
//        $role_shopadmin->description = 'Seller / Shop';
//        $role_shopadmin->save();

//        $role_hrdadmin = new Role();
//        $role_hrdadmin->name = 'hrdadmin';
//        $role_hrdadmin->display_name = 'HRD Page';
//        $role_hrdadmin->description = 'HRD';
//        $role_hrdadmin->save();

        $role_customer = new Role();
        $role_customer->name = 'customer';
        $role_customer->display_name = 'User Page';
        $role_customer->description = 'User Customer';
        $role_customer->save();
    }
}
