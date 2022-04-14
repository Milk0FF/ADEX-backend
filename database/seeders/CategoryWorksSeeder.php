<?php

namespace Database\Seeders;

use App\Models\CategoryWork;
use Illuminate\Database\Seeder;

class CategoryWorksSeeder extends Seeder
{
    private $categoryWorks = [
        ['name' => 'Рекламные билборды'],
        ['name' => 'Реклама в соц.сетях'],
        ['name' => 'Рекламные видеоролики'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->categoryWorks as $categoryWork){
            CategoryWork::updateOrCreate($categoryWork);
        }
    }
}
