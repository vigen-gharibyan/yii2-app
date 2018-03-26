<?php
require('functions.php'); //custom helper functions to the whole application

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@root', dirname(dirname(__DIR__)));
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@spa', dirname(dirname(__DIR__)) . '/spa');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
