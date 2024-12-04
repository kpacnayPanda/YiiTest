<?php

namespace app\models;

use yii\base\Model;

class Repo extends Model
{
    public string $name;
    public string $html_url;
    public string $updated_at;

    public function rules()
    {
        return [
            [['login','name', 'html_url', 'updated_at'], 'required'],
            [['login','name', 'html_url'], 'string', 'max' => 255],
            [['updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }
}
