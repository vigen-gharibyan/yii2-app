<?php
namespace api\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use api\components\Controller;
use common\models\SignupForm;
use common\models\LoginForm;
use common\models\User;

class UserController extends Controller
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return array_merge($behaviors, [
            'bearerAuth' => [
                'class' => HttpBearerAuth::className(),
                'except' => ['login', 'signup'],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'login' => ['POST', 'OPTIONS'],
                    'signup' => ['POST', 'OPTIONS'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['view', 'update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $id = Yii::$app->getRequest()->get('id');
                            return Yii::$app->getUser()->can('updateProfile', [
                                'id' => $id,
                            ]);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteProfile'],
                    ],
                ]
            ],
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update']);

        return $actions;
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->login()) {
            return [
                'token' => Yii::$app->user->identity->getJWT(),
            ];
        } else {
            return $model;
        }
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($user = $model->signup()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);

            Yii::$app->mailer
                ->compose([
                    'html' => 'signup-html',
                ], [
                    'user' => $user,
                ])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($user->email)
                ->setSubject(Yii::t('app', 'You have registered'))
                ->send();

            return $user;
        }

        return $model;
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}