<?php

namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\v1\Models\Human;
use App\v1\Models\Orc;

class IndexController
{

    /**
     * @var
     */
    private $container;
    
    /**
     *
     * @var array 
     */
    private $data;

    /**
     * IndexController constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * 
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return type
     */
    public function __invoke(Request $request, Response $response, $args)
    {
        $this->data['human'] = new Human();
        $this->data['orc'] = new Orc();
        $renderer = $this->container->get('renderer');
        $renderer->render($response, 'index.phtml', $this->data);
    }

}
