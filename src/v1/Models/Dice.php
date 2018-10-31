<?php

namespace App\v1\Models;

class Dice
{

    public function __construct()
    {
        
    }

    /**
     * 
     * @param int $sides
     * @param int $agility
     * @return int
     */
    public function roll($sides)
    {
        return mt_rand(1, $sides);
    }

}
