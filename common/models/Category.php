<?php

namespace common\models;

use common\models\multilingual\MultilingualBehavior;
use common\models\multilingual\MultilingualQuery;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $enabled
 */
class Category extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function statuses()
    {
        return [
            self::STATUS_INACTIVE => Yii::t('app', 'Disabled'),
            self::STATUS_ACTIVE => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    public function fields()
    {
        $fields = parent::fields();

        foreach (['name', 'description'] as $attr) {
            $fields[$attr] = function ($model, $attr) {
                return $this->$attr;
            };
        }
        foreach (['created_at', 'updated_at'] as $attr) {
            unset($fields[$attr]);
        }

        return $fields;
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
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['languages'],
                //	'languageField' => 'language',
                //	'localizedPrefix' => '',
                //	'requireTranslations' => false',
                //	'dynamicLangClass' => true',
                //	'langClassName' => PostLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => Yii::$app->params['defaultLanguage'],
                'langForeignKey' => 'category_id',
                'tableName' => "{{%categories_lang}}",
                'attributes' => [
                    'name', 'description',
                ]
            ],
            \common\models\behaviors\LinkAllBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $required = ['enabled', 'name'];
        $unique = ['name'];
        $integer = ['enabled'];
        $safe = ['created_at', 'updated_at', 'name', 'description'];

        return [
            [$required, 'required'],
        //  [$unique, 'unique'],
            [$integer, 'integer'],
            [$safe, 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    public function getCategoryLangs()
    {
        return $this->hasMany(CategoryLang::className(), ['category_id' => 'id']);
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

}
