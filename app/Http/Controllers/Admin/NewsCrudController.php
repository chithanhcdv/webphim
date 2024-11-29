<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NewsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NewsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\News::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/news');
        CRUD::setEntityNameStrings('news', 'news');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('title')->label('Tiêu đề');
        CRUD::column('slug')->label('Đường dẫn');
        CRUD::addColumn([
            'name' => 'title_image',
            'label' => 'Hình ảnh tiêu đề',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->title_image) {
                    return '<img src="'.asset('storage/images/news/' . $entry->title_image).'" width="100" />';
                }
                return 'No Image';
            },
            'escaped' => false,
        ]);
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        CRUD::column('content')->label('Nội dung');
        CRUD::addColumn([
            'name' => 'content_image',
            'label' => 'Hình ảnh nội dung',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->content_image) {
                    return '<img src="'.asset('storage/images/news/' . $entry->content_image).'" width="100" />';
                }
                return 'No Image';
            },
            'escaped' => false,
        ]);
        CRUD::column('other_content')->label('Nội dung khác');
        CRUD::addColumn([
            'name' => 'other_image',
            'label' => 'Hình ảnh khác',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->other_image) {
                    return '<img src="'.asset('storage/images/news/' . $entry->other_image).'" width="100" />';
                }
                return 'No Image';
            },
            'escaped' => false,
        ]);
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
        CRUD::setValidation(NewsRequest::class);
        CRUD::field('title')->label('Tiêu đề');
        CRUD::field('slug')->label('Đường dẫn');
        CRUD::field('content')->label('Nội dung');
        CRUD::field('other_content')->label('Nội dung khác');
        CRUD::field('title_image')->type('upload')->disk('public')->upload('images/news')->label('Hình ảnh tiêu đề');
        CRUD::field('content_image')->type('upload')->disk('public')->upload('images/news')->label('Hình ảnh nội dung');
        CRUD::field('other_image')->type('upload')->disk('public')->upload('images/news')->label('Hình ảnh nội dung khác');
        $this->crud->addSaveAction([
            'name' => 'save_and_back',
            'redirect' => function ($crud, $request, $itemId) {
                $item = $crud->getEntry($itemId);
                if ($request->hasFile('title_image')) {
                    $file = $request->file('title_image');     
                    $path = $request->file('title_image')->storeAs('images/news', $file->getClientOriginalName(), 'public');            
                    //$item->image = $path;
                    $item->title_image = $file->getClientOriginalName();
                    $item->save();
                }
                if ($request->hasFile('content_image')) {
                    $file = $request->file('content_image');
                    $path = $request->file('content_image')->storeAs('images/news', $file->getClientOriginalName(), 'public'); 
                    //$item->background_image = $path;
                    $item->content_image = $file->getClientOriginalName();
                    $item->save();
                }
                if ($request->hasFile('other_image')) {
                    $file = $request->file('other_image');
                    $path = $request->file('other_image')->storeAs('images/news', $file->getClientOriginalName(), 'public'); 
                    //$item->background_image = $path;
                    $item->other_image = $file->getClientOriginalName();
                    $item->save();
                }
                return $crud->route . '/' . $itemId . '/show';
            }
        ]); 

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
