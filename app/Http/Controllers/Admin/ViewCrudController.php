<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ViewRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ViewCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\View::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/view');
        CRUD::setEntityNameStrings('Lượt xem', 'Lượt xem phim');
    }

    protected function setupListOperation()
    {
        CRUD::column('movie_id')->label('Tên phim');
        CRUD::column('views_count')->label('Lượt xem phim');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        CRUD::column('created_at')->label('Ngày tạo')->type('datetime');
        CRUD::column('updated_at')->label('Ngày cập nhật')->type('datetime');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ViewRequest::class);
        CRUD::field('movie_id')->label('Phim');
        CRUD::field('views_count')->label('Lượt xem phim');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
