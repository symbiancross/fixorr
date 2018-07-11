<?php
use App\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin;           
        $admin->email = 'admin1@fixorr.com';
        $admin->password = bcrypt('Admin');
        $admin->save();
    }
}
