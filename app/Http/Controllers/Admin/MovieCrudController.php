<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MovieRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MovieCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MovieCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Movie::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/movie');
        CRUD::setEntityNameStrings('Phim', 'Phim');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Tên phim');       

        // Các cột khác
        CRUD::addColumn([
            'name' => 'genres',
            'label' => 'Thể loại',
            'type' => 'closure',
            'function' => function($entry) {
                $genres = $entry->genres->take(3)->pluck('name')->toArray();
                return implode(', ', $genres);
            },
            'escaped' => false,
        ]);

        CRUD::addColumn([
            'name' => 'country_id',
            'label' => 'Quốc gia',
            'type' => 'select',
            'entity' => 'country',
            'attribute' => 'name',
            'model' => "App\Models\Country",
        ]);

        CRUD::addColumn([
            'name' => 'release_year_id',
            'label' => 'Năm sản xuất',
            'type' => 'select',
            'entity' => 'releaseYear',
            'attribute' => 'year',
            'model' => "App\Models\ReleaseYear",
        ]);

        CRUD::addColumn([
            'name' => 'category_id',
            'label' => 'Danh mục',
            'type' => 'select',
            'entity' => 'category',
            'attribute' => 'name',
            'model' => "App\Models\Category",
        ]);

        CRUD::addColumn([
            'name' => 'hot',
            'label' => 'Hot',
            'type' => 'boolean',
            'options' => [0 => 'Không', 1 => 'Có'], // Tùy chọn hiển thị
        ]);

        CRUD::addColumn([
            'name' => 'image',
            'label' => 'Hình ảnh',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->image) {
                    return '<img src="'.asset('storage/images/movies/' . $entry->image).'" width="50" />';
                }
                return 'No Image';
            },
            'escaped' => false,
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MovieRequest::class);

        CRUD::field('name')->label('Tên phim');
        CRUD::field('slug')->label('Đường dẫn');
        CRUD::field('description')->label('Mô tả');
        CRUD::addField([
            'name' => 'genres',
            'type' => 'select_multiple',
            'label' => "Thể loại",
            'entity' => 'genres',
            'attribute' => 'name',
            'model' => 'App\Models\Genre',
            'pivot' => true, // Set this to true if you're using a pivot table
        ]);
        CRUD::field('country_id')->type('select')->entity('country')->model('App\Models\Country')->attribute('name')->label('Quốc gia');
        CRUD::field('release_year_id')->type('select')->entity('releaseYear')->model('App\Models\ReleaseYear')->attribute('year')->label('Năm sản xuất');   
        CRUD::field('category_id')->type('select')->entity('category')->model('App\Models\Category')->attribute('name')->label('Danh mục'); 
        CRUD::field('studio');
        CRUD::field('director')->label('Đạo diễn');
        CRUD::field('actor')->label('Diễn viên');
        CRUD::field('total_episode')->label('Tổng số tập');
        
        CRUD::field('other_name')->label('Tên khác');   
        CRUD::field('hot')->type('checkbox');

        CRUD::field('image')->type('upload')->disk('public')->upload('images/movies')->label('Hình ảnh');
        CRUD::field('background_image')->type('upload')->disk('public')->upload('images/movies')->label('Ảnh nền');

        $this->crud->addSaveAction([
            'name' => 'save_and_back',
            'redirect' => function ($crud, $request, $itemId) {
                $item = $crud->getEntry($itemId);
                if ($request->hasFile('image')) {
                    $file = $request->file('image');     
                    $path = $request->file('image')->storeAs('images/movies', $file->getClientOriginalName(), 'public');            
                    //$item->image = $path;
                    $item->image = $file->getClientOriginalName();
                    $item->save();
                }
                if ($request->hasFile('background_image')) {
                    $file = $request->file('background_image');
                    $path = $request->file('background_image')->storeAs('images/movies', $file->getClientOriginalName(), 'public'); 
                    //$item->background_image = $path;
                    $item->background_image = $file->getClientOriginalName();
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
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        CRUD::column('slug')->after('name')->label('Đường dẫn');
        CRUD::column('description')->after('slug')->type('textarea')->label('Mô tả');
        CRUD::column('director')->after('category_id')->label('Đạo diễn')->type('textarea');
        CRUD::column('studio')->after('director')->label('Studio');
        CRUD::column('actor')->type('textarea')->after('studio')->label('Diễn viên');
        CRUD::column('total_episode')->after('actor')->label('Tổng số tập');
        CRUD::column('other_name')->after('total_episode')->label('Tên khác');
        
        //Hiển thị hình ảnh trong trang chi tiết
            CRUD::modifyColumn('image', [
            'name' => 'image',
            'label' => 'Hình ảnh',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->image) {
                    //return '<img src="'.asset('storage/' . $entry->image).'" width="100" />'; 
                    return '<img src="'.asset('storage/images/movies/' . $entry->image).'" width="100" />';
                }
                return 'No Image';
            },
            'escaped' => false,
        ]);

        //Hiển thị background_image trang chi tiết
        CRUD::column([
            'name' => 'background_image',
            'label' => 'Ảnh nền',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->background_image) {
                    //return '<img src="'.asset('storage/' . $entry->background_image).'" width="200" />';
                    return '<img src="'.asset('storage/images/movies/' . $entry->background_image).'" width="200" />';
                }
                return 'No Image';
            },
            'escaped' => false,
        ]);

        CRUD::column('created_at')->label('Ngày tạo')->type('datetime');
        CRUD::column('updated_at')->label('Ngày cập nhật')->type('datetime');
    }
}
