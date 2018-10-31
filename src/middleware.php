<?php

$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        $statusCode = $exception->getCode() ? $exception->getCode() : 500;
        $container->get('logger')->addError($exception->getMessage(), [
            'msg'   => $exception->getMessage(),
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);
        return $container['response']->withStatus($statusCode)
                        ->withHeader('Content-Type', 'Application/json')
                        ->withJson(["message" => $exception->getMessage()], $statusCode);
    };
};
$container['phpErrorHandler'] = function ($container) {
    return $container['errorHandler'];
};

$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        return $container['response']
                        ->withStatus(405)
                        ->withHeader('Allow', implode(', ', $methods))
                        ->withHeader('Content-Type', 'Application/json')
                        ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
                        ->withJson(["message" => "Method not Allowed; Method must be one of: " . implode(', ', $methods)], 405);
    };
};

$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['response']
                        ->withStatus(404)
                        ->withHeader('Content-Type', 'Application/json')
                        ->withJson(['message' => 'Page not found']);
    };
};

$app->add(new Psr7Middlewares\Middleware\TrailingSlash(false));
