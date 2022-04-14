<?php

namespace Database\Seeders;

use App\Models\EmploymentType;
use Illuminate\Database\Seeder;

class EmploymentTypesSeeder extends Seeder
{
    private $employmentTypes = [
        ['name' => 'Свободен'],
        ['name' => 'Занят'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->employmentTypes as $employmentType){
            EmploymentType::updateOrCreate($employmentType);
        }
    }
}
