<?php

namespace app\models;

use yii\base\Model;

class User extends Model
{
    public string $username;

    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'string', 'max' => 255],
        ];
    }
}
