<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    private $reviews = [
        ['comment' => 'Хороший исполнитель', 'score_type_id' => 1, 'customer_id' => 2, 'executor_id' => 1, 'task_id' => 1],
        ['comment' => 'Плохой исполнитель', 'score_type_id' => 2, 'customer_id' => 2, 'executor_id' => 1, 'task_id' => 1],
        ['comment' => 'Хороший заказчик', 'score_type_id' => 1, 'customer_id' => 2, 'executor_id' => 1, 'task_id' => 1],
        ['comment' => 'Плохой заказчик', 'score_type_id' => 2, 'customer_id' => 2, 'executor_id' => 1, 'task_id' => 1],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->reviews as $review){
            Review::updateOrCreate($review);
        }
    }
}
