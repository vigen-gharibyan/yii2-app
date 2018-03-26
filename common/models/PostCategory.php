<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_category".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $category_id
 */
class PostCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'category_id'], 'required'],
            [['post_id', 'category_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }
}
