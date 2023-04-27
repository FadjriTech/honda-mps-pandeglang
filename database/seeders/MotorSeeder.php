<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotorSeeder extends Seeder
{
    public function run(): void
    {
        $jsonString = file_get_contents(public_path('motocross.json'));
        $datas = json_decode($jsonString, true);


        foreach($datas as $data){
            DB::table('motocross')->insert([
                'nama' => $data['nama'],
                'kelas' => $data['kelas'],
                'biaya' => $data['biaya'],
            ]);
        }
    }
}
