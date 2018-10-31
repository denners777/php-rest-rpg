<?php

$app->get('/', \App\v1\Controllers\IndexController::class);

$app->group('/v1', function() {
    $this->get('/battle/dice/{character}', '\App\v1\Controllers\BattleController:rollDice');
});
