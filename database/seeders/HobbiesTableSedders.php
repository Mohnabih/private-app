<?php

namespace Database\Seeders;

use App\Models\Hobby;
use Illuminate\Database\Seeder;

class HobbiesTableSedders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hobbis=[
            'Swimming',
            'Reading',
            'Writting',
            'Listening',
            'Watching',
            'Craft',
            'Cooking',
            'Crossword Puzzies',
            'Makaup',
            'Kung fu',
            'Hairstyle',
            'Video making',
            'Pilates',
            'Photography',
            'Fashion',
            'Karate',
            'Ice skating'
        ];
        foreach($hobbis as $hobby){
        Hobby::create([
            'key'=>$hobby,
        ]);}
    }
}
