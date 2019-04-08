<?php


namespace DenisKisel\LaravelAdminWidget\Repositories;

use DenisKisel\LaravelAdminWidget\Models\Widget;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Repositories\WidgetRepository
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repositories\WidgetRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repositories\WidgetRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repositories\WidgetRepository query()
 */
class WidgetRepository extends Model
{
    public function store($code, $data)
    {
        unset($data['_token']);
        Widget::whereCode($code)->delete();

        $widget = new Widget();
        $widget->name = $data['name'] ?? '';
        $widget->code = $code;
        $widget->content = serialize($data);

        $widget->save();
    }

    public function updateContent($code, $data)
    {
        $widget = Widget::whereCode($code)->firstOrFail();
        $widget->content = serialize($data);
        $widget->save();
    }

    public function getArrayDataByCode($code)
    {
        $output = [];
        $widget = Widget::whereCode($code)->first();
        if (!is_null($widget)) {
            $output = unserialize($widget->content);
        }

        return $output;
    }

    /**
     * @param $code
     * @return \Illuminate\Support\Collection
     */
    public function getCollection($code)
    {
        $data = $this->getArrayDataByCode($code);
        $output = [];

        if (!empty($data)) {
            foreach ($data as $datum) {
                foreach ($datum as $item) {
                    $output[] = $item;
                }
            }
        }

        return collect($output);
    }
}
