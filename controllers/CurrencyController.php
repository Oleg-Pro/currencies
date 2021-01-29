<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

class CurrencyController extends ActiveController
{
    public $modelClass = 'app\models\Currency';
}

