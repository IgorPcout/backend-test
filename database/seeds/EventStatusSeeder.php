<?php

use App\Models\EventStatus;
use Illuminate\Database\Seeder;

class EventStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventStatus::create([
            'id' => 1,
            'value' => 'open'
        ]);
        EventStatus::create([
            'id' => 2,
            'value' => 'closed'
        ]);
        EventStatus::create([
            'id' => 3,
            'value' => 'canceled'
        ]);
    }
}
