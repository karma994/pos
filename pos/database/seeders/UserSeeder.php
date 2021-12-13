<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Dorji Wangdi',
            'email' => 'admin@lamla.com',
            'password' => bcrypt('12345678'),
            'employee_code' => 'LAMLA/2009/E01723',
            'branch' => 'Thimphu',
            'department' => 'Admin',
            'status' => 'active',
            'cid' => '2002883647',
            'contact_no' => '17653421',
            'gender' => 'male',
            'date_of_join' => '2021/01/01',
        ]);
//        $user->assignRole('admin');
    }
}
