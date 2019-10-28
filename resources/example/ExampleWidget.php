<?php
namespace App\Admin\Controllers\Widgets;

use DenisKisel\LaravelAdminWidget\Facade\Widget;
use DenisKisel\LaravelAdminWidget\WidgetController;
use Encore\Admin\Form\NestedForm;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Illuminate\Http\Request;

Class ExampleWidget extends WidgetController
{
    protected $code = 'example';

    public function index(Content $content)
    {
        $box = new Box('Box Title', 'Box content');
        $box->solid();

        return $content
            ->header('Index')
            ->description('description')
            ->body($box->content($this->form()));
    }

    public function form()
    {
        $data = Widget::getArray($this->code);
        $form = new \Encore\Admin\Widgets\Form($data);

        $form->text('name', __('admin.name'));
        $form->summernote('description', __('admin.description'));
        $form->color('color');
        $form->image('image', __('admin.image'));

        $form->repeat('icons', function (NestedForm $form) {
            $form->text('name', __('admin.name'))->rules('required');
            $form->textarea('description');
            $form->image('icon', __('admin.icon'));
        });

        $form->repeat('items', function (NestedForm $form) {
            $form->text('name', __('admin.name'))->rules('required');
            $form->textarea('description');
        });

        $form->action(url()->current());

        return $form->render();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['image'] = $this->resolveImage($data, 'image');

        if (!empty($data['icons'])) {
            foreach ($data['icons'] as $key => &$item) {
                $item['icon'] = $this->resolveImage($data, 'icons.' . $key . '.icon');
            }
        }

        Widget::put($this->code, $data);
    }
}
