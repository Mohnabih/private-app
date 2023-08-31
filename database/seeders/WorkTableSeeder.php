<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Seeder;

class WorkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $works=[
            'Engineers',
            'Sales executives',
            'Administrative staff',
            'Accountants',
            'acaustomer service staff',
        ];
        foreach($works as $work){
        Work::create([
            'value'=>$work,
        ]);}
    }
}
