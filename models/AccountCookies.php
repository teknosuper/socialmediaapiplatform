<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "account_cookies".
 *
 * @property int $id
 * @property string $service
 * @property string $username
 * @property string|null $email
 * @property string $cookie
 * @property string|null $cookies_status
 * @property string|null $cookies_response
 * @property string $updated_at
 */
class AccountCookies extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%account_cookies}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service', 'username', 'cookie'], 'required'],
            [['cookie', 'cookies_response'], 'string'],
            [['service', 'cookies_status'], 'string', 'max' => 50],
            [['username', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['cookies_status'], 'default', 'value' => 'pending'],
            [['service', 'username'], 'unique', 'targetAttribute' => ['service', 'username']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service' => 'Service',
            'username' => 'Username',
            'email' => 'Email',
            'cookie' => 'Cookie',
            'cookies_status' => 'Cookies Status',
            'cookies_response' => 'Cookies Response',
            'updated_at' => 'Updated At',
        ];
    }
}
