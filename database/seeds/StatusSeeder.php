<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'id' => 1,
            'value' => 'pending'
        ]);
        Status::create([
            'id' => 2,
            'value' => 'confirmed'
        ]);
        Status::create([
            'id' => 3,
            'value' => 'rejected'
        ]);
    }
}
