<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmsToGenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = Genre::factory()->count(10)->create();

        Film::factory()->count(10)->create()->each(function ($film) use ($genres) {
            $film->roles()->attach(
                $genres->random(rand(1, $genres->count()))->pluck('id')->toArray()
            );
        });
    }
}
