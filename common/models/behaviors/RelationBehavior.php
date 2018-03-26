<?php

namespace common\models\behaviors;

use frostealth\yii2\behaviors\EasyRelationBehavior;
use yii\db\BaseActiveRecord;

class RelationBehavior extends EasyRelationBehavior
{
    public function events()
    {
        $events = parent::events();

        return array_merge($events, [
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ]);
    }

    public function afterDelete()
    {
        foreach($this->relations as $relation) {
            $this->owner->unlinkAll($relation, true);
        }
    }

}
