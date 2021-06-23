<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\db\Exception;
use yii\db\Query;

/**
 * Этот класс предназначен для доступа к настройкам сайта во всем приложении
 *
 * Class SettingsComponent
 * @package common\components
 */
class SettingsComponent extends Component
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name)
    {
        $rawValue = (new Query())->select('value')->from('settings')->where(['name' => $name])->one();

        if (empty($rawValue)) {
            $this->createRecords();
        }

        $value = json_decode($rawValue['value']);

        if (empty($value->value)) {
            $value->value = $value->default;
        }

        return $value;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return bool
     */
    public function set(string $name, $value): bool
    {
        $command = Yii::$app->db->createCommand();

        $setting = $this->get($name);

        if (!is_numeric($setting->value) && (gettype($setting->value) != $setting->type)) {
            return false;
        }

        if (!isset($value['value'])) {
            return false;
        }

        $setting->value = $value['value'];

        try {
            $command->update('settings', ['value' => $setting], ['name' => $name])->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function createRecords()
    {
        $command = Yii::$app->db->createCommand();

        $command->insert(
            '{{%settings}}',
            [
                'name' => 'phone',
                'value' => [
                    'type' => 'string',
                    'label' => 'Контактный номер',
                    'value' => '89999999999',
                    'default' => '89999999999'
                ]
            ]
        )->execute();

        $command->insert(
            '{{%settings}}',
            [
                'name' => 'email',
                'value' => [
                    'type' => 'string',
                    'label' => 'E-mail',
                    'value' => 'i.voloshenko@ddemo.ru',
                    'default' => 'i.voloshenko@ddemo.ru'
                ]
            ]
        )->execute();
    }
}