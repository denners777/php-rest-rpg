<?php

namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\v1\Models\Human;
use App\v1\Models\Orc;
use App\v1\Models\Dice;

class BattleController
{

    /**
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return int
     */
    public function RollDice(Request $request, Response $response, $args)
    {
        $character = $args['character'];

        $object = $this->setCharacter($character);

        $agility = $object->agility;

        $return = (new Dice())->roll(20) + $agility;
        return $response->withJson($return, 200)
                        ->withHeader('Content-type', 'application/json');
    }

    public function Attack(Request $request, Response $response, $args)
    {
        $character = $args['character'];

        $object = $this->setCharacter($character);

        $attack = $object->getAttack();

        $return = (new Dice())->roll(20) + $attack;
        return $response->withJson($return, 200)
                        ->withHeader('Content-type', 'application/json');
    }

    public function Defense(Request $request, Response $response, $args)
    {
        $character = $args['character'];

        $object = $this->setCharacter($character);

        $defense = $object->getDefense();

        $return = (new Dice())->roll(20) + $defense;
        return $response->withJson($return, 200)
                        ->withHeader('Content-type', 'application/json');
    }

    public function Damage(Request $request, Response $response, $args)
    {
        $character = $args['character'];

        $object = $this->setCharacter($character);

        $strength = $object->strength;
        $sides    = $object->dice;

        $return = (new Dice())->roll($sides) + $strength;
        return $response->withJson($return, 200)
                        ->withHeader('Content-type', 'application/json');
    }

    private function setCharacter($character)
    {
        switch ($character) {
            case 'Human':
                return new Human();
            case 'Orc':
                return new Orc();
        }
    }

}
