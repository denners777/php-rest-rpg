<?php

$app->get('/', \App\v1\Controllers\IndexController::class);

$app->group('/v1', function() {
    
});
