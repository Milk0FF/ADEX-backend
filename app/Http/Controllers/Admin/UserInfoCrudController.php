<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserInfoRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserInfoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserInfoCrudController extends CrudController
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
        CRUD::setModel(\App\Models\UserInfo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-info');
        CRUD::setEntityNameStrings('пользователь', 'пользователи');
        CRUD::denyAccess(['create', 'delete', 'update']);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::addColumn(['name' => 'firstname', 'label' => 'Имя', 'type' => 'text']);
        CRUD::addColumn(['name' => 'lastname', 'label' => 'Фамилия', 'type' => 'text']);
        CRUD::addColumn([
            'label' => 'Email',
            'type' => "relationship",
            'name' => 'user',
            'attribute' => 'email',
        ]);
        CRUD::addColumn(['name' => 'phone', 'label' => 'Телефон', 'type' => 'text']);
        CRUD::addColumn(['name' => 'city', 'label' => 'Город', 'type' => 'text']);
        CRUD::addColumn(['name' => 'country', 'label' => 'Страна', 'type' => 'text']);
        CRUD::addColumn([
            'label' => 'Никнейм',
            'type' => "relationship",
            'name' => 'user',
            'attribute' => 'username',
        ]);
        CRUD::addColumn([
            'label' => 'Тип занятости',
            'type' => "relationship",
            'name' => 'employmentType',
        ]);
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

        CRUD::addColumn(['name' => 'firstname', 'label' => 'Имя', 'type' => 'text']);
        CRUD::addColumn(['name' => 'lastname', 'label' => 'Фамилия', 'type' => 'text']);
        CRUD::addColumn(['name' => 'about', 'label' => 'О себе', 'type' => 'text']);
        CRUD::addColumn([
            'label' => 'Email',
            'type' => "relationship",
            'name' => 'user',
            'attribute' => 'email',
        ]);
        CRUD::addColumn(['name' => 'phone', 'label' => 'Телефон', 'type' => 'text']);
        CRUD::addColumn(['name' => 'city', 'label' => 'Город', 'type' => 'text']);
        CRUD::addColumn(['name' => 'country', 'label' => 'Страна', 'type' => 'text']);
        CRUD::addColumn(['name' => 'birth_date', 'label' => 'Дата рождения', 'type' => 'date']);
        CRUD::addColumn(['name' => 'rating', 'label' => 'Рейтинг', 'type' => 'number']);
        CRUD::addColumn([
            'label' => 'Никнейм',
            'type' => "relationship",
            'name' => 'user',
            'attribute' => 'username',
        ]);
        CRUD::addColumn([
            'label' => 'Тип занятости',
            'type' => "relationship",
            'name' => 'employmentType',
        ]);
        CRUD::removeColumn('media_id');
    }
}
