<?php
/** @var yii\web\View $this */
/** @var array $repos */

use yii\helpers\Html;

$this->title = 'Последние обновления репозиториев';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::cssFile('@web/css/site.css') ?>

</head>
<body>
<div class="github-repos">
    <h1><?= Html::encode($this->title) ?></h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Имя пользователя</th>
            <th>Название</th>
            <th>Ссылка</th>
            <th>Дата обновления</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($repos as $repo): ?>
            <tr>
                <td><?= Html::encode($repo['login']) ?></td>
                <td><?= Html::encode($repo['name']) ?></td>
                <td><?= Html::a(Html::encode($repo['html_url']), $repo['html_url'], ['target' => '_blank']) ?></td>
                <td><?= Html::encode(date('d.m.Y H:i:s', strtotime($repo['updated_at']))) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    setInterval(() => {
        location.reload();
    }, 600000); // 10 минут = 600000 миллисекунд
</script>
