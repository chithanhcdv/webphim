<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CountryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CountryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CountryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Country::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/country');
        CRUD::setEntityNameStrings('quốc gia', 'Quốc Gia');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Tên quốc gia');
        CRUD::column('slug')->label('Đường dẫn');    
        CRUD::column('description')->label('Mô tả'); 
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        CRUD::column('created_at')->label('Ngày tạo')->type('datetime');
        CRUD::column('updated_at')->label('Ngày cập nhật')->type('datetime');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CountryRequest::class);
        CRUD::field('name')->label('Tên quốc gia');
        CRUD::field('slug')->label('Đường dẫn');
        CRUD::field('description')->label('Mô tả');

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}