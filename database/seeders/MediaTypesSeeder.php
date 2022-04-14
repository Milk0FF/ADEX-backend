<?php

namespace Database\Seeders;

use App\Models\MediaType;
use Illuminate\Database\Seeder;

class MediaTypesSeeder extends Seeder
{
    private $mediaTypes = [
        ['name' => 'Видео'],
        ['name' => 'Фото'],
        ['name' => 'Документ'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->mediaTypes as $mediaType){
            MediaType::updateOrCreate($mediaType);
        }
    }
}
