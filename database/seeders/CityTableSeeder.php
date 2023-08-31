<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities=[
            'Dubai',
            'Abu Dhabi',
            'Sharjah',
            'Al Ain',
            'Ajman',
            'Ras Al Khaimah',
            'Fujairah',
            'Umm al-Quwain',
            'Dibba Al-Fujairah',
            'Khor Fakkan',
            'Kalba',
            'Jebel Ali',
            'Madinat Zayed',
            'Ruwais',
            'Liwa Oasis',
            'Dhaid',
            'Ghayathi',
            'Ar-Rams',
            'Dibba Al-Hisn',
            'Hatta',
            'Al Madam'
        ];
        foreach($cities as $city){
        City::create([
            'value'=>$city,
        ]);}
    }
}
