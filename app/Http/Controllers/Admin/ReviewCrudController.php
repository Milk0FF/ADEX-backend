<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ReviewRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ReviewCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ReviewCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Review::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/review');
        CRUD::setEntityNameStrings('отзыв', 'отзывы');
        CRUD::denyAccess(['create', 'delete']);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'comment', 'label' => 'Комментарий', 'type' => 'text']);
        CRUD::column('comment');
        CRUD::addColumn([
            'label' => 'Оценка',
            'type' => "relationship",
            'name' => 'scoreType',
        ]);
        CRUD::addColumn([
            'label' => 'Задача',
            'type' => "relationship",
            'name' => 'task',
            'attribute' => 'name',
        ]);
        CRUD::addColumn([
            'label' => 'Автор',
            'type' => "relationship",
            'name' => 'authorInfo',
            'attribute' => 'fullname',
        ]);
        CRUD::addColumn(['name' => 'is_disable', 'label' => 'Отключено', 'options' => [0 => 'Нет', 1 => 'Да'], 'type' => 'boolean']);
    }
    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);

        CRUD::addColumn(['name' => 'comment', 'label' => 'Комментарий', 'type' => 'text']);
        CRUD::column('comment');
        CRUD::addColumn([
            'label' => 'Оценка',
            'type' => "relationship",
            'name' => 'scoreType',
        ]);
        CRUD::addColumn([
            'label' => 'Задача',
            'type' => "relationship",
            'name' => 'task',
            'attribute' => 'name',
        ]);
        CRUD::addColumn([
            'label' => 'Автор',
            'type' => "relationship",
            'name' => 'authorInfo',
            'attribute' => 'fullname',
        ]);

        CRUD::addColumn([
            'label' => 'Заказчик',
            'type' => "relationship",
            'name' => 'customerInfo',
            'attribute' => 'fullname',
        ]);
        CRUD::addColumn([
            'label' => 'Исполнитель',
            'type' => "relationship",
            'name' => 'executorInfo',
            'attribute' => 'fullname',
        ]);
        CRUD::addColumn(['name' => 'is_disable', 'label' => 'Отключено', 'options' => [0 => 'Нет', 1 => 'Да'], 'type' => 'boolean']);
        CRUD::removeColumn('score_type_id');
    }

     /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(ReviewRequest::class);

        CRUD::addField(['name' => 'is_disable', 'label' => 'Отключено', 'type' => 'boolean']);
    }

}
