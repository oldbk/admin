<?php

use yii\bootstrap\Html;

/**
 * Created by PhpStorm.
 * User: me
 * Date: 27.08.16
 * Time: 20:21
 *
 * @var int $id
 */ ?>

<ul>
    <li>
        <?= Html::a('Бой', ['/quest/task-validator/fight', 'id' => $id], ['class' => 'btn btn-xs btn-primary']) ?>
    </li>
    <li>
        <?= Html::a('Локация', ['/quest/task-validator/location', 'id' => $id], ['class' => 'btn btn-xs btn-primary']) ?>
    </li>
    <li>
        <div>
            <?= Html::a('Вход в игру', ['/quest/task-validator/game-enter', 'id' => $id], ['class' => 'btn btn-xs btn-primary']) ?>
        </div>
        <span class="hint">Применять только для события входа в игру</span>
    </li>
</ul>

