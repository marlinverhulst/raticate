<?php

use Illuminate\Database\Seeder;
use App\Role;

class RollsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *  
     *  To run : php artisan db:seed --class=RollsTableSeeder
     * 
     * @return void
     */
    public function run()
    {
        //

        Role::create([
            'name'=> 'admin'
        ]);
        Role::create([
            'name'=> 'technician'
        ]);
        Role::create([
            'name'=> 'deactivated'
        ]);
        

        
    }
}
