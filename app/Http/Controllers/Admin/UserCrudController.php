<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('thành viên', 'Thành Viên');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Tên');
        CRUD::column('email')->label('Email');
        CRUD::column('google_id')->label('Google ID');
        CRUD::column('facebook_id')->label('Facebook ID');

        CRUD::addColumn([
            'name' => 'avatar',
            'label' => 'Ảnh đại diện',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->avatar) {
                    // Kiểm tra nếu avatar là từ Google hoặc Facebook
                    if (strpos($entry->avatar, 'https://lh3.googleusercontent.com') === 0 || 
                        strpos($entry->avatar, 'https://graph.facebook.com') === 0) {
                        return '<img src="'. $entry->avatar .'" width="50" />';
                    } else {
                        return '<img src="'.asset('storage/images/avatar/' . $entry->avatar).'" width="50" />';
                    }
                }
                return 'No Image';
            },
            'escaped' => false,
        ]);

        CRUD::addColumn([
            'name' => 'is_admin',
            'label' => 'Quyền',
            'type' => 'closure',
            'function' => function($entry) {
                return $entry->is_admin ? 'Quản trị viên' : 'Người dùng'; 
            },
            'escaped' => false, 
        ]);             
    }

    protected function setupShowOperation() 
    {
        $this->setupListOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);
        CRUD::field('name')->label('Tên');
        CRUD::field('email')->label('Email');
        CRUD::field('password')->type('password')->label('Mật khẩu');
        CRUD::field('google_id')->label('Google ID');
        CRUD::field('facebook_id')->label('Facebook ID');
        CRUD::field('avatar')->type('upload')->disk('public')->upload('images/avatar')->label('Ảnh đại diện');

        $this->crud->addSaveAction([
            'name' => 'save_and_back',
            'redirect' => function ($crud, $request, $itemId) {
                $item = $crud->getEntry($itemId);
                if ($request->hasFile('avatar')) {
                    $file = $request->file('avatar');     
                    $path = $request->file('avatar')->storeAs('images/avatar', $file->getClientOriginalName(), 'public');            
                    $item->avatar = $file->getClientOriginalName();
                    $item->save();
                }                
                return $crud->route . '/' . $itemId . '/show';
            }
        ]);
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
        CRUD::removeField('password');
    }
}
