<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slots = [
            [
                'name' => 'Slot 1',
                'eta' => '23:55:00',
            ],
            [
                'name' => 'Slot 2',
                'eta' => '04:51:00',
            ],
            [
                'name' => 'Slot 3',
                'eta' => '10:51:00',
            ]
        ];

        foreach ($slots as $slot) {
            $slug = \Illuminate\Support\Str::slug($slot['name']);
            $slot['slug'] = $slug;
            $slot['station_id'] = 5;
            \App\Models\Slot::create($slot);
        }
    }
}
