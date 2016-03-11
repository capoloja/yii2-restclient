<?php

/*
 * Tools to use API as ActiveRecord for Yii2
 *
 * @link      https://github.com/apexwire/yii2-restclient
 * @package   yii2-restclient
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, ApexWire
 */

namespace yii\restclient;

use Yii;
use yii\db\QueryInterface;
use yii\db\QueryTrait;
use yii\helpers\ArrayHelper;

/**
 * Class Query
 * @package yii\restclient
 */
class Query extends \yii\db\Query implements QueryInterface
{
    public $index;
    public $type;

    /**
     * @param null $db
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function createCommand($db = null)
    {
        if ($db === null) {
            /** @var Connection $db */
            $db = Yii::$app->get(Connection::getDriverName());
        }

        $commandConfig = $db->getQueryBuilder()->build($this);

        return $db->createCommand($commandConfig);
    }

    /**
     * Получаем количетсво объектов
     *
     * @param string $q
     * @param null $db
     * @return mixed
     */
    public function count($q = '*', $db = null)
    {
        $result = $this->createCommand($db)->head();

        return current(ArrayHelper::getValue($result, 'X-Pagination-Total-Count'));
    }

    /**
     * @inheritdoc
     */
    public function exists($db = null)
    {
        throw new NotSupportedException('exists in is not supported.');
    }

    /**
     * Устанавливает from.
     * @deprecated Не поддерживается
     *
     * @param array|string $index
     * @param null $type
     * @throws NotSupportedException
     */
    public function from($index, $type = null)
    {
        throw new NotSupportedException('from in is not supported.');
    }
}