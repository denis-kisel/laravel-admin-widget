<?php
namespace DenisKisel\LaravelAdminWidget;

use App\Http\Controllers\Controller;
use DenisKisel\LaravelAdminWidget\Facade\Widget;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

Class WidgetController extends Controller
{
    protected $code = '';

    /**
     * @param $requestData
     * @param $fieldName
     * @param null $size
     * @return mixed|string
     */
    public function resolveImage($requestData, $fieldName, $size = null)
    {
        $widgetData = Widget::getArray($this->code);
        $image = '';
        $UploadFile = Arr::get($requestData, $fieldName);
        if ($UploadFile instanceof UploadedFile) {
            $image = $this->move($UploadFile);
        } elseif(!empty(Arr::get($widgetData, $fieldName))) {
            $image = Arr::get($widgetData, $fieldName);
        }

        return $image;
    }

    public function move(UploadedFile $datum)
    {
        $widgetPath = storage_path('app/public/images/widgets/' . $this->code . '/');

        if (!is_dir($widgetPath)) {
            mkdir($widgetPath, 0777, true);
        }

//        dd($datum->extension());

        $extension = (!is_null($datum->extension())) ? $datum->extension() : 'svg';

        $fileName = $datum->getFilename() . '.' . $extension;
        $datum->move($widgetPath, $fileName);
        return 'images/widgets/' . $this->code . '/' . $fileName;
    }
}
