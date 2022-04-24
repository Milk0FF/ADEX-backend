<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    private $reviews = [
        ['comment' => 'Хороший исполнитель', 'author_id' => 2, 'score_type_id' => 1, 'customer_id' => 2, 'executor_id' => 1, 'task_id' => 1],
        ['comment' => 'Плохой исполнитель', 'author_id' => 2, 'score_type_id' => 2, 'customer_id' => 2, 'executor_id' => 1, 'task_id' => 1],
        ['comment' => 'Хороший заказчик', 'author_id' => 1, 'score_type_id' => 1, 'customer_id' => 2, 'executor_id' => 1, 'task_id' => 1],
        ['comment' => 'Плохой заказчик', 'author_id' => 1, 'score_type_id' => 2, 'customer_id' => 2, 'executor_id' => 1, 'task_id' => 1],
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
