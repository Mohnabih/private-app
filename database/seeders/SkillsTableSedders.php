<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillsTableSedders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills=[
            'Games',
            'Travelling',
            'Art',
            'Nature',
            'Languages',
            'History',
            'Theatre',
            'Community service',
            'Social causes',
            'Video gamming',
            'Hairstyle',
            'Video making',
            'Sports',
            'Politics',
            'Economy',
            'Sciences',
            'Movies '
        ];
        foreach($skills as $skill){
        Skill::create([
            'key'=>$skill,
        ]);}
    }
}
