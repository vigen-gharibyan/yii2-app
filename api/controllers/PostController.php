<?php
namespace api\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use api\components\Controller;

class PostController extends Controller
{
    public $modelClass = 'common\models\Post';
    public $modelSearchClass = 'common\models\PostSearch';

    /*
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    */

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return array_merge($behaviors, [
            'bearerAuth' => [
                'class' => HttpBearerAuth::className(),
                'except' => ['index', 'view'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', 'user'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['createPost'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        //  'roles' => ['updatePost'],
                        'matchCallback' => function ($rule, $action) {
                            $post_id = Yii::$app->getRequest()->get('id');
                            $post = $this->findModel($post_id);
                            $params = [
                                'post' => $post,
                            ];
                            return Yii::$app->getUser()->can('updatePost', $params);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deletePost'],
                    ],
                ],
            ],
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();

        // disable the "create" and "update" actions
        unset($actions['create'], $actions['update']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new $this->modelSearchClass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $dataProvider;
    }

    public function actionCreate()
    {
        $model = new $this->modelClass();
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');
        if(array_key_exists('categories', $params)) {
            $model->categoriesIds = $params['categories'];
        }

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id, true);
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');
        if(array_key_exists('categories', $params)) {
            $model->categoriesIds = $params['categories'];
        }

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }

    protected function findModel($id, $ml=false)
    {
        $modelClass = $this->modelClass;

        if ($ml == true) {
            $model = $modelClass::find()->multilingual()->where(['id' => $id])->one();
        } else {
            $model = $modelClass::findOne($id);
        }

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}