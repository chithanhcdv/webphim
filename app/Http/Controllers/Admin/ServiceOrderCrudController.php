<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ServiceOrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ServiceOrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ServiceOrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\ServiceOrder::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/service-order');
        CRUD::setEntityNameStrings('đơn dịch vụ', 'Đơn dịch vụ');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'user_id',
            'label' => 'Email thành viên',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'email',
            'model' => "App\Models\User",
        ]);

        CRUD::column('service_id')->label('Gói'); 
        CRUD::column('order_code')->label('Mã dịch vụ');     
        CRUD::column('payment_method')->label('Thanh toán');
        CRUD::column('service_start_at')->label('Ngày bắt đầu');     
        CRUD::column('service_end_at')->label('Ngày hết hạn');   
        CRUD::column('status')->label('Trạng thái');  
            
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ServiceOrderRequest::class);

        CRUD::addField([
            'name' => 'user_id',
            'type' => 'select',
            'label' => "Email thành viên",
            'entity' => 'User',
            'attribute' => 'email',
            'model' => 'App\Models\User',
        ]);
        CRUD::field('service_id')->label('ID gói dịch vụ');
        CRUD::field('order_code')->label('Mã dịch vụ');
        CRUD::field('payment_method')->label('Phương thức thanh toán');
        CRUD::field('service_start_at')->label('Ngày bắt đầu');
        CRUD::field('service_end_at')->label('Ngày hết hạn');
        CRUD::addField([
            'name' => 'status',
            'label' => 'Trạng thái',
            'type' => 'radio',
            'options' => [
                'đang sử dụng' => 'Đang sử dụng',
                'đã hết hạn' => 'Đã hết hạn',
                'đã hủy' => 'Đã hủy',
            ],
            'allows_null' => false, // Không cho phép bỏ trống
            'default' => 'đang sử dụng', // Giá trị mặc định
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
