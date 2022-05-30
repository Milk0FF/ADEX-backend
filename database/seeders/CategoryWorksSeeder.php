<?php

namespace Database\Seeders;

use App\Models\CategoryWork;
use Illuminate\Database\Seeder;

class CategoryWorksSeeder extends Seeder
{
    private $categoryWorks = [
        ['name' => 'Рекламные билборды', 'color' => 'green'],
        ['name' => 'Реклама в соц.сетях', 'color' => 'purple'],
        ['name' => 'Рекламные видеоролики', 'color' => 'red'],
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
