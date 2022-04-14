<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypesSeeder extends Seeder
{
    private $userTypes = [
        ['name' => 'Исполнитель'],
        ['name' => 'Заказчик'],
        ['name' => 'Админ'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->userTypes as $userType){
            UserType::updateOrCreate($userType);
        }
    }
}
