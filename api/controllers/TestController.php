<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use moonland\phpexcel\Excel;
use common\models\UploadForm;

/**
 * Site controller
 */
class TestController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return array_merge($behaviors, [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['upload'],
                        'allow' => true,
                    //  'roles' => ['user'],
                    ],
                ],
            ],
        ]);
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');

            if(!empty($model->excelFile)) {
                if ($filePath = $model->uploadExcel()) {
                // $basePath = Yii::$app->basePath;
                    $onlySheet = 'data';
                    $excel_data = Excel::import($filePath, [
                        'setFirstRecordAsKeys' => false,
                        'getOnlySheet' => $onlySheet,
                    ]);

                    $data = [];
                    foreach($excel_data as $row) {
                        $key = $row['A'];
                        $value = $row['B'];
                        $data[$key] = $value;
                    }

                    if(file_exists($filePath)) {
                        unlink($filePath);
                    }

                    return $data;
                }
            }

            return false;
        }
    }

}
