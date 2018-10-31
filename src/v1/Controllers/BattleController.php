<?php

namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\v1\Models\Human;
use App\v1\Models\Orc;

class BattleController
{

    /**
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return int
     */
    public function rollDice(Request $request, Response $response, $args)
    {
        $character = $args['character'];

        switch ($character) {
            case 'human':
                $sides = (new Human())->dice;
                break;
            case 'orc':
                $sides = (new Orc())->dice;
                break;
            default:
                $sides = 20;
                break;
        }

        return $response->withJson(mt_rand(1, $sides), 200)
                        ->withHeader('Content-type', 'application/json');
    }

}
