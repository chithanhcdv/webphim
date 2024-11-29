<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EpisodeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EpisodeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EpisodeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Episode::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/episode');
        CRUD::setEntityNameStrings('tập phim', 'Tập Phim');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb();
        CRUD::addColumn([
            'name' => 'movie_id',
            'label' => 'Tên phim',
            'type' => 'select',
            'entity' => 'movie',
            'attribute' => 'name',
            'model' => "App\Models\Movie",
        ]);
        CRUD::column('episode_number')->label('Tập');
        CRUD::column('duration')->label('Thời lượng (phút)');
     
        CRUD::addColumn([
            'name' => 'server1',
            'label' => 'Video',
            'type' => 'custom_html',
            'value' => function ($entry) {
                $server = $entry->server1;
                return "<iframe width='200' height='100' src='$server' frameborder='0' allowfullscreen></iframe>";
            }
        ]);
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
        CRUD::setValidation(EpisodeRequest::class);
        CRUD::field('movie_id')->type('select')->entity('movie')->model('App\Models\Movie')->attribute('name')->label('Tên phim');
        CRUD::field('episode_number')->label('Tập'); 
        CRUD::field('duration')->label('Thời lượng (phút)'); 
        CRUD::field('server1')->label('Server 1'); 
        CRUD::field('server2')->label('Server 2'); 
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
