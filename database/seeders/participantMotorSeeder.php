<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class participantMotorSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            try {
                DB::table('motor')->insert([
                    'merk' => fake()->company(),
                    'mesin' => fake()->buildingNumber(),
                    'rangka' => fake()->buildingNumber(),
                    'kategori' => fake()->buildingNumber(),
                    'kelas' => fake()->jobTitle(),
                    'biaya' => fake()->numberBetween(0, 999),
                    'participantId' => fake()->numberBetween(0, 50),
                ]);
            } catch (Exception $error) {
                continue;
            }
        }
    }
}
