<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('participant')->insert([
                'nama' => fake()->name(),
                'telepon' => fake()->phoneNumber(),
                'KIS' => fake()->numberBetween(0, 99),
                'tanggal_lahir' => fake()->date(),
                'start' => fake()->numberBetween(0, 99),
                'tim' => fake()->domainName(),
                'kota' => fake()->domainName(),
            ]);
        }
    }
}
