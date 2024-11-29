<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RatingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class RatingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Rating::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/rating');
        CRUD::setEntityNameStrings('đánh giá', 'Đánh giá phim');
    }

    protected function setupListOperation()
    {
        CRUD::column('user_id')->label('Tên thành viên');
        CRUD::column('movie_id')->label('Tên phim');
        CRUD::column('rating')->label('Đánh giá');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        CRUD::column('created_at')->label('Ngày tạo')->type('datetime');
        CRUD::column('updated_at')->label('Ngày cập nhật')->type('datetime');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(RatingRequest::class);
        CRUD::field('user_id')->label('Thành viên');
        CRUD::field('movie_id')->label('Phim');
        CRUD::field('rating')->label('Đánh giá');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}