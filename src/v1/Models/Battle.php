<?php

namespace App\v1\Models;

class Battle
{

    public function __construct()
    {
        
    }

    /**
     * 
     * @param int $sides
     * @return int
     */
    protected function rollDice($sides)
    {
        return mt_rand(1, $sides);
    }

}
