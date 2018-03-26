<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['key'], 'unique'],
            [['key', 'value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }

    public static function getAll()
	{
		$settings = self::find()
			->select(['key', 'value'])
			->asArray()
			->indexBy('key')
			->all();
		
		$result = [];
		foreach($settings as $key => $value) {
			$result[$key] = $value['value'];
		}
		
		return $result;
	}

    public static function get($key)
    {
        $row = self::find()
            ->select(['value'])
            ->where('`key` = :key', [':key' => $key])
            ->asArray()
            ->one();

        if(!empty($row)) {
            return $row['value'];
        }

        return NULL;
    }

    public static function set($key, $value)
    {
        $row = self::find()
            ->where('`key` = :key', [':key' => $key])
            ->one();

        if(!empty($row)) {
            $row->value = $value;
            if($row->save()) {
                return true;
            }
        }

        return false;
    }
    
    public static function setTheme($value)
    {
        return self::set('theme', $value);
    }
}
