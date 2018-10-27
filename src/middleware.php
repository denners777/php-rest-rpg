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

$container['CorsMiddleware'] = function ($container) {
    return new Tuupola\Middleware\CorsMiddleware([
        'logger'         => $container['logger'],
        'origin'         => [getenv('REQUEST_ORIGIN')],
        'methods'        => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
        'headers.allow'  => [],
        'headers.expose' => [],
        'credentials'    => false,
        'cache'          => 0,
        'error'          => function ($response, $arguments) {
            $data['status']  = 'error';
            $data['message'] = $arguments['message'];
            return $response
                            ->withHeader('Content-Type', 'application/json')
                            ->withJson($data);
        }
    ]);
};

$app->add('CorsMiddleware');
