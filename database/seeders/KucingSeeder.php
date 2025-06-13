<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kucing;

class KucingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kucings = [
            [
                'id_user' => null,
                'name' => "Kucing Oren",
                'warna' => "Orange",
                'rating' => "7",
                'imageUrl' => "gambar/Kucing2.jpg",
            ],
            [
                'id_user' => null,
                'name' => "Kucing Hitam",
                'warna' => "Hitam",
                'rating' => "6",
                'imageUrl' => "gambar/Kucing1.jpg",
            ],
        ];
        foreach ($kucings as $value) {
            Kucing::create($value);
        }
    }
}
