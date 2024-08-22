<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ImageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Image::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/administracao/image');
        CRUD::setEntityNameStrings('image', 'Images');
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb();
        $this->addImageColumn();
    }

    protected function setupCreateOperation()
    {
        $this->addFields();
        CRUD::setValidation(ImageRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->addFields();
        $this->addImageColumn();
    }

    private function addFields()
    {
        $this->crud->addFields([
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
            ],
            [
                'name' => 'file',
                'label' => 'Nome da Imagem',
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'hint' => 'Opcional: você pode deixar em branco.',
            ],
            [
                'name' => 'filename',
                'label' => 'Image',
                'type' => 'upload',
                'upload' => true,
                'disk' => 'public',
                'prefix' => 'storage/gallery/',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
            ],
        ]);
    }

    private function addImageColumn()
    {
        CRUD::column('filename')->type('image');
    }

    private function addShowColumns()
    {
        CRUD::column('title')
            ->tab('Detalhe')->label('Title');

        CRUD::column('file')
            ->tab('Detalhe')->label('File');

        CRUD::column('filename')
            ->tab('Image')->type('image');
    }
}
