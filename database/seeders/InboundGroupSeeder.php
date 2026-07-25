<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InboundGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inbound_groups = [
            [
                'name' => 'IBGroup 1',
                'first_time' => '15:00:00',
                'last_time' => '18:00:00',
                'cutoff_time' => '08:00:00',
            ],
            [
                'name' => 'IBGroup 2',
                'first_time' => '06:00:00',
                'last_time' => '12:00:00',
                'cutoff_time' => '14:00:00',
            ],
            [
                'name' => 'IBGroup 3',
                'first_time' => '12:00:00',
                'last_time' => '15:00:00',
                'cutoff_time' => '17:00:00',
            ],
        ];

        foreach($inbound_groups as $group) {
            $slug = Str::slug($group['name']);
            $group['slug'] = $slug;
            \App\Models\InboundGroup::create($group);
        }
    }
}
