<?php

namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use App\v1\Models\Funcionario;

class IndexController
{

    /**
     * @var
     */
    private $container;

    /**
     * AuthController constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, $args)
    {
        $return = 'work';
        return $response->withJson($return, 200)
                        ->withHeader('Content-type', 'application/json');
    }

}
