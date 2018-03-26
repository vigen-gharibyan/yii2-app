<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\multilingual\MultilingualBehavior;
use common\models\multilingual\MultilingualQuery;
use common\models\behaviors\RelationBehavior;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $enabled
 *
 * @property PostLang[] $postLangs
 */
class Post extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    public function fields()
    {
        $fields = parent::fields();
        $languages = array_keys(Yii::$app->params['languages']);

        foreach (['title', 'content'] as $attr) {
            $fields[$attr] = function ($model, $attr) {
                return $this->$attr;
            };
            /*
            foreach($languages as $language) {
                $attr_lang = $attr . '_' . $language;
                $fields[$attr_lang] = function ($model, $attr_lang) {
                    return $this->$attr_lang;
                };
            }
            */
        }
        foreach (['created_at', 'updated_at'] as $attr) {
            $fields[$attr] = function ($model, $attr) {
                return date('d.m.Y H:i', $this->$attr);
            };
        }

        $fields['user'] = function ($model) {
            return $this->user;
        };

        $fields['categories'] = function ($model) {
            return $this->categories;
        };

        unset($fields['created_by']);

        return $fields;
    }

    public function extraFields()
    {
        return [
            //  'categories',
            //  'user',
        ];
    }

    public static function statuses()
    {
        return [
            0 => Yii::t('app', 'Disabled'),
            1 => Yii::t('app', 'Enabled'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
                'langForeignKey' => 'post_id',
                'tableName' => "{{%posts_lang}}",
                'attributes' => [
                    'title',
                    'content',
                ]
            ],
            'easyRelation' => [
                'class' => RelationBehavior::className(),
                'relations' => ['categories'],
                'suffix' => 'ids', // by default
            ],
            \common\models\behaviors\LinkAllBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $required = ['enabled', 'title', 'content'];
        $safe = ['created_by', 'created_at', 'updated_at', 'title', 'content'];
        $integer = ['enabled'];

        /*
        foreach(Yii::$app->params['languages'] as $language) {
            if($language['code'] != Yii::$app->params['defaultLanguage']) {
                $title = 'title_' . $language['code'];
                $content = 'content_' . $language['code'];
                $required[] = $title;
                $required[] = $content;
            }
        }
        */

        return [
            [$required, 'required'],
            [$safe, 'safe'],
            [$integer, 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'created_by' => Yii::t('app', 'Created by'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (empty($this->created_by)) {
                    $this->created_by = Yii::$app->user->identity->getId();
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostLangs()
    {
        return $this->hasMany(PostLang::className(), ['post_id' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('post_category', ['post_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

}
