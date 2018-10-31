<?php

$app->get('/', \App\v1\Controllers\IndexController::class);

$app->group('/v1', function() {
    $this->get('/battle/dice/{character}', '\App\v1\Controllers\BattleController:RollDice');
    $this->get('/battle/attack/{character}', '\App\v1\Controllers\BattleController:Attack');
    $this->get('/battle/defense/{character}', '\App\v1\Controllers\BattleController:Defense');
});
