<?php
namespace DenisKisel\LaravelAdminWidget;

use App\Http\Controllers\Controller;
use DenisKisel\LaravelAdminWidget\Repositories\WidgetRepository;
use Illuminate\Http\UploadedFile;

Class WidgetController extends Controller
{
    protected $code = '';
    protected $widgetRepository = null;

    public function __construct(WidgetRepository $widgetRepository)
    {
        $this->widgetRepository = $widgetRepository;
    }

    /**
     * @param $requestData
     * @param $fieldName
     * @param null $size
     * @return mixed|string
     */
    public function resolveImage($requestData, $fieldName, $size = null)
    {
        $widgetData = $this->widgetRepository->getArrayDataByCode($this->code);
        $image = '';
        $UploadFile = array_get($requestData, $fieldName);
        if ($UploadFile instanceof UploadedFile) {
            $image = $this->move($UploadFile);
        } elseif(!empty(array_get($widgetData, $fieldName))) {
            $image = array_get($widgetData, $fieldName);
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
