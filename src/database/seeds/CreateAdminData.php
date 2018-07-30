<?php

use Illuminate\Database\Seeder;
use OneUpReviews\Models\Organization;
use OneUpReviews\Models\User;

class CreateAdminData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $org = Organization::create([
            'name' => 'Orion - Admins'
        ]);

        User::create([
            'first_name' => 'Jake',
            'last_name' => 'Toolson',
            'email' => 'jaketoolson@gmail.com',
            'password' => bcrypt('testing1234'),
            'organization_id' => $org->id
        ]);
    }
}
