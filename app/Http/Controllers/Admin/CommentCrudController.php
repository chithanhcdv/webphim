<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CommentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CommentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Comment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/comment');
        CRUD::setEntityNameStrings('bình luận', 'Bình luận phim');
    }

    protected function setupListOperation()
    {      
        CRUD::column('user_id')->label('Tên thành viên');
        CRUD::column('movie_id')->label('Tên phim');
        CRUD::column('content')->label('Nội dung');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        CRUD::column('created_at')->label('Ngày tạo')->type('datetime');
        CRUD::column('updated_at')->label('Ngày cập nhật')->type('datetime');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CommentRequest::class);
        CRUD::field('user_id')->label('Thành viên');
        CRUD::field('movie_id')->label('Phim');
        CRUD::field('content')->label('Nội dung');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
