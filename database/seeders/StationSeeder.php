<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = [
            'Batang Peranap Hub',
            'Benai Hub',
            'Gunung Sahilan Hub',
            'Gunung Toar Hub',
            'Inuman Hub',
            'Kampar Hub',
            'Kampar Kiri Hilir Hub',
            'Kampar Kiri Hub',
            'Kampar Kiri Tengah Hub',
            'Kampar Kiri Tengah 2 Hub',
            'Kelayang Hub',
            'Kemuning Riau Hub',
            'Keritang Hub',
            'Keritang 2 Hub',
            'Keritang 4 Hub',
            'Koto Kampar Hulu Hub',
            'Kuantan Mudik Hub',
            'Kuantan Tengah Hub',
            'Logas Tanah Darat Hub',
            'Lubuk Batu Jaya Hub',
            'Peranap Hub',
            'Peranap 2 Hub',
            'Pucuk Rantau Hub',
            'Sentajo Raya Hub',
            'Singingi Hilir Hub',
            'Singingi Hub',
            'Tanah Merah Hub',
        ];

        foreach ($stations as $station) {
            Station::create([
                'name' => $station,
                'slug' => Str::slug($station),
            ]);
        }
    }
}
