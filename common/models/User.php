<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    // Use the trait in your User model
    use \damirka\JWT\UserTrait;

    public $password;

    // Override this method
    protected static function getSecretKey()
    {
        return 'someSecretKey';
    }

    // And this one if you wish
    protected static function getHeaderToken()
    {
        return [];
    }

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 10;

    const ROLE_USER = 1;
    const ROLE_WORKER = 2;
    const ROLE_MODERATOR = 5;
    const ROLE_ADMIN = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function fields()
    {
        $fields = parent::fields();

        foreach (['created_at', 'updated_at'] as $attr) {
            $fields[$attr] = function ($model, $attr) {
                return date('d.m.Y H:i', $this->$attr);
            };
        }

        foreach (['password', 'password_hash', 'password_reset_token', 'auth_key'] as $attr) {
            unset($fields[$attr]);
        }

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['username', 'email', 'role', 'status', 'password'];
        $scenarios['update'] = ['username', 'email', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'string', 'min' => 6],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_WORKER, self::ROLE_MODERATOR, self::ROLE_ADMIN]],
        ];
    }

    public static function getRules()
    {
        return [
            'username' => [
                ['username', 'filter', 'filter' => 'trim'],
                ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
                ['username', 'string', 'min' => 2, 'max' => 255],
            ],

            'email' => [
                ['email', 'filter', 'filter' => 'trim'],
                ['email', 'email'],
                ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ],

            'password' => [
                ['password', 'string', 'min' => 6],
            ],

            'status' => [
                ['status', 'default', 'value' => self::STATUS_INACTIVE],
                ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ],

            'role' => [
                ['role', 'default', 'value' => self::ROLE_USER],
                ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_WORKER, self::ROLE_MODERATOR, self::ROLE_ADMIN]],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => Yii::t('app', 'Inactive'),
            self::STATUS_DELETED => Yii::t('app', 'Deleted'),
        ];
    }

    public static function getRoles()
    {
        return [
            self::ROLE_USER => Yii::t('app', 'User'),
            self::ROLE_WORKER => Yii::t('app', 'Worker'),
            self::ROLE_MODERATOR => Yii::t('app', 'Moderator'),
            self::ROLE_ADMIN => Yii::t('app', 'Administrator'),
        ];
    }

    //todo
    public static function getAll($role = NULL)
    {
        $role = self::ROLE_WORKER;

        return self::find()
            ->where('`role` = :role', [':role' => $role])
            ->asArray()
            ->indexBy('id')
            ->all();
    }

    /**
     * @param null $role
     * @return array
     */
    public static function getList($role = NULL)
    {
        return ArrayHelper::map(
            self::getAll($role),
            function ($model) {
                $id = $model['id'];
                return $id;
            },
            'username'
        );
    }

}
