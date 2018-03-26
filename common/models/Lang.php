<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "lang".
 *
 * @property integer $id
 * @property string $enabled
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $date_update
 * @property integer $created_at
 * @property string $code
 * @property string $flag
 * @property integer $order
 */
class Lang extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;

	public static function statuses()
	{
		return [
			self::STATUS_ACTIVE => Yii::t('app', 'Active'),
			self::STATUS_INACTIVE => Yii::t('app', 'Inactive'),
		];
	}
	
	//Переменная, для хранения текущего объекта языка
	public static $current = null;
	public static $languages = [];

	public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
			[['enabled', 'local', 'name', 'code'], 'required'],
			[['enabled'], 'integer'],
			[['default', 'updated_at', 'created_at', 'order'], 'integer'],
			[['local', 'name', 'flag'], 'string', 'max' => 255],
			[['code'], 'string', 'length' => 2],
			[['code', 'local'], 'unique'],
			[['image'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'checkExtensionByMimeType' => false],
		];
	}

    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'enabled' => Yii::t('app', 'Enabled'),
			'local' => Yii::t('app', 'Local'),
			'name' => Yii::t('app', 'Name'),
			'default' => Yii::t('app', 'Default'),
			'updated_at' => Yii::t('app', 'Updated at'),
			'created_at' => Yii::t('app', 'Created at'),
			'code' => Yii::t('app', 'Code'),
			'flag' => Yii::t('app', 'Flag'),
			'image' => Yii::t('app', 'Flag'),
			'order' => Yii::t('app', 'Order'),
		];
	}
	
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					\yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					\yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
			],
		];
	}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($this->isNewRecord) {
				if(empty($this->order)) {
					$this->order = 10000;
				}
			}
			return true;
		} else {
			return false;
		}
	}
	
	//Получение текущего объекта языка
	static function getCurrent()
	{
		return Yii::$app->params['currentLanguage'];
	}

	//Установка текущего объекта языка и локаль пользователя
	static function setCurrent($code)
	{
		if(array_key_exists($code, Yii::$app->params['languages'])) {
			Yii::$app->session->set('language', $code);
            $cookie = new \yii\web\Cookie([
                'name' => 'language',
                'value' => $code,
            ]);
            $cookie->expire = time() + (60 * 60 * 24); // (1 day)
			Yii::$app->response->cookies->add($cookie);
			
			$language = Yii::$app->params['languages'][$code];
			Yii::$app->params['currentLanguage'] = $code;
			Yii::$app->language = $language['local'];
		}
	}

	//Получения объекта языка по умолчанию
	static function getDefault()
	{
		$default = self::find()
			->where('`default` = :default and `enabled` = :enabled', [':default' => 1, ':enabled' => self::STATUS_ACTIVE])
			->asArray()
			->one();

		if(empty($default)) {
			$langs = self::getAll();
			$default = array_shift($langs);
		}

		if(!empty($default['code'])) {
			return $default['code'];
		}

		return NULL;
	}
	
	public static function getAll()
	{
		return self::find()
			->where('`enabled` = :enabled', [':enabled' => self::STATUS_ACTIVE])
			->orderBy(['`order`' => SORT_ASC])
			->asArray()
			->indexBy('code')
			->all();
	}

	public static function order($orderIds)
	{
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		$return_value = false;

		try {
			foreach ($orderIds as $order => $id) {
				$model = self::findOne($id);

				if ($model === null) {
					return false;
				}

				$model->order = $order + 1;
				$model->save();
			}
			$transaction->commit();
			$return_value = true;
		} catch(Exception $e) {
			$return_value = true;
			$transaction->rollback();
		}

		return $return_value;
	}

	public function upload($upload_dir)
	{
		if (!file_exists($upload_dir)) {
			mkdir($upload_dir, 0755, true);
		}

		if ($this->validate()) {
			$ext = pathinfo($this->image->name, PATHINFO_EXTENSION);
			$file_name = $this->code .'.'. $ext;
			$file_path = $upload_dir . $file_name;
			if(file_exists($file_path)) {
				unlink($file_path);
			}
			$this->image->saveAs($file_path);
			$this->flag = $file_name;
			return true;
		} else {
			return false;
		}
	}
}
