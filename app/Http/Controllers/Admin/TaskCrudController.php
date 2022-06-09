<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaskRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaskCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/task');
        CRUD::setEntityNameStrings('задача', 'задачи');
        CRUD::denyAccess(['create', 'update', 'delete']);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'name', 'label' => 'Название', 'type' => 'text']);
        CRUD::addColumn(['name' => 'description', 'label' => 'Описание', 'type' => 'text']);
        CRUD::addColumn([
            'label' => 'Заказчик',
            'type' => "relationship",
            'name' => 'customerInfo',
            'attribute' => 'fullname'
        ]);
        CRUD::addColumn([
            'label' => 'Исполнитель',
            'type' => "relationship",
            'name' => 'executorInfo',
            'attribute' => 'fullname'
        ]);
        CRUD::addColumn([
            'label' => 'Статус',
            'type' => "relationship",
            'name' => 'status',
            'attribute' => 'name'
        ]);
    }

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);
        CRUD::addColumn(['name' => 'name', 'label' => 'Название', 'type' => 'text']);
        CRUD::addColumn(['name' => 'description', 'label' => 'Описание', 'type' => 'text']);
        CRUD::addColumn(['name' => 'price', 'label' => 'Цена', 'type' => 'text']);
        CRUD::addColumn([
            'label' => 'Заказчик',
            'type' => "relationship",
            'name' => 'customerInfo',
            'attribute' => 'firstname'
        ]);
        CRUD::addColumn([
            'label' => 'Исполнитель',
            'type' => "relationship",
            'name' => 'executorInfo',
            'attribute' => 'firstname'
        ]);
        CRUD::addColumn([
            'label' => 'Статус',
            'type' => "relationship",
            'name' => 'status',
            'attribute' => 'name'
        ]);
        CRUD::addColumn(['name' => 'date_end', 'label' => 'Дата окончания', 'type' => 'date']);
        CRUD::removeColumn('task_status_id');
    }
}
