<?php

namespace Database\Seeders;

use App\Models\ScoreType;
use Illuminate\Database\Seeder;

class ScoreTypesSeeder extends Seeder
{
    private $scoreTypes = [
        ['name' => 'Положительно'],
        ['name' => 'Негативно'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->scoreTypes as $scoreType){
            ScoreType::updateOrCreate($scoreType);
        }
    }
}
