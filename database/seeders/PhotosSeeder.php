<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(\Illuminate\Support\Facades\DB::table('photos')->count() === 0) {
            $photosValues = [
                [
                    'photo_title' => 'BMW X5 Blue 1',
                    'photo_url' => '/images/bmw-x5-blue1.jpg',
                ],
                [
                    'photo_title' => 'Mercedes Red 1',
                    'photo_url' => '/images/mercedes-red-1.jpg',
                ],
                [
                    'photo_title' => 'Mercedes Blue 1',
                    'photo_url' => '/images/mercedes-blue-1.png',
                ],
            ];
            \Illuminate\Support\Facades\DB::table('photos')->insert($photosValues);
            
            $photosFromDB =
                    \Illuminate\Support\Facades\DB::table('photos')->get();
            
            foreach ($photosFromDB as $photo) {
                foreach (range(1, 3) as $tagNumber) {
                    \Illuminate\Support\Facades\DB::table('tags')->insert([
                        'tag_title' => 'tag' . $tagNumber,
                        'x_offset' => $tagNumber * 10,
                        'y_offset' => $tagNumber * 10,
                        'photo_id' => $photo->id
                    ]);
                }
            }
            
//            dd($photosFromDB);
        }
    }
}
