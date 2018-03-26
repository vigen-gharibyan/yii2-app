<?php

namespace backend\controllers;

use Yii;
use common\models\Lang;
use common\models\Settings;
use yii\data\ActiveDataProvider;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use Aws\S3\S3Client;

/**
 * LanguageController implements the CRUD actions for Lang model.
 */
class LanguageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'order'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Lang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Lang::find()->orderBy(['order' => SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lang model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Lang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lang();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->image = UploadedFile::getInstance($model, 'image')) {
                $upload_dir = $this->uploadDir();
                if ($model->upload($upload_dir)) {
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            } else {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

        /*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        */
    }

    /**
     * Updates an existing Lang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $bucket = 'testbucketvigen';
            $keyId = 'AKIAIP6DWTUMQ2FDLBQA';
            $secretKey = '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';

            $keyname = 'RJV4L37pBeN5/rVm9MvHG4/2DlKRDpeMNnPOoqyi';
            // $filepath should be absolute path to a file on disk
            $filepath = $this->uploadDir() .'am.txt';

            // Instantiate the client.
            $s3 = S3Client::factory([
                'key'       => $keyId,
                'secret'    => $secretKey,
                'region'    => 'us-west-2',
                'version'   => '2006-03-01',
                'profile' => 'myprofile',
            ]);

            // Upload a file.

            /*
            $result = $s3->putObject([
                'Bucket'     => $bucket,
                'Key'        => $secretKey,
                'ACL'        => 'public-read',
                'SourceFile' => $filepath,
            //  'ContentType'=> 'image/jpeg'
            ]);
            */


            $result = $s3->putObject(array(
                'Bucket'       => $bucket,
                'Key'          => $secretKey,
                'SourceFile'   => $filepath,
                'ContentType'  => 'text/plain',
                'ACL'          => 'public-read',
                'StorageClass' => 'REDUCED_REDUNDANCY',
                'Metadata'     => array(
                    'param1' => 'value 1',
                    'param2' => 'value 2'
                )
            ));


            echo $result['ObjectURL'];
            die('die');


            if ($model->image = UploadedFile::getInstance($model, 'image')) {
                $upload_dir = $this->uploadDir();
                if ($model->upload($upload_dir)) {
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            } else {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Lang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionOrder()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        if (Yii::$app->request->isAjax) {
            $response = ['success' => false];
            $orderIds = Yii::$app->request->post('orderIds');

            if(Lang::order($orderIds)) {
                $response = ['success' => true];
                Yii::$app->session->setFlash('success', Yii::t('app', 'Orders successfully changed'));
            //  $this->redirect('/language/index');
            } else {
                $response = ['success' => false];
            }

            echo json_encode($response);
        }
    }

    /**
     * Finds the Lang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function uploadDir()
    {
        $frontend_dir = Yii::getAlias('@frontend');
        $dir = '/web/img/flags/';
        $theme = Settings::get('theme');

        if(!empty($theme)) {
            $theme_dir = '/web/themes/'. $theme;
            if(file_exists($frontend_dir . $theme_dir)) {
                $dir = $theme_dir .'/img/flags/';
            }
        }

        return $frontend_dir . $dir;
    }
}
