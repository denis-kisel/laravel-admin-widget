<?php


namespace DenisKisel\LaravelAdminWidget\Facade;


use \DenisKisel\LaravelAdminWidget\Models\Widget as WidgetModel;


class Widget
{
    public static function put($code, $data)
    {
        unset($data['_token']);
        WidgetModel::whereCode($code)->updateOrCreate(
            ['code' => $code],
            [
                'code' => $code,
                'name' => $data['name'] ?? null,
                'content' => serialize($data)
            ]
        );
    }

    public static function getArray($code)
    {
        $output = [];
        $widget = WidgetModel::whereCode($code)->first();
        if (!is_null($widget)) {
            $output = unserialize($widget->content);
        }

        return $output;
    }

    /**
     * @param $code
     * @return \Illuminate\Support\Collection
     */
    public static function getCollection($code)
    {
        $data = self::getArray($code);
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
