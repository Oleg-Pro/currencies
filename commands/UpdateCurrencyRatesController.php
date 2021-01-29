<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\services\parsers\CurrencyRateParser;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command update currency rates
 */
class UpdateCurrencyRatesController extends Controller
{
    protected $currencyRateParser;

    public function __construct($id, $module, CurrencyRateParser $currencyRateParser, $config = [])
    {
        $this->currencyRateParser = $currencyRateParser;
        parent::__construct($id, $module, $config);
    }

    /**
     * This command updates currency rates
     * @return int Exit code
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        $currentRates = $this->currencyRateParser->getList();
        $dateTime = (new \DateTime())->format('Y-m-d H:i:s');
        foreach ($currentRates as $rate) {
            $insertValues = [
                'name' => $rate['name'],
                'rate' => $rate['rate'],
                'insert_dt' => $dateTime,
            ];
            \Yii::$app->db->createCommand()->upsert('currency', $insertValues)->execute();
        }

        return ExitCode::OK;
    }

}
