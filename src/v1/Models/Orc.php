<?php

namespace App\v1\Models;

class Orc extends Character
{

    public function __construct()
    {
        $this->hp       = 20;
        $this->attack   = 1;
        $this->defense  = 0;
        $this->strength = 2;
        $this->agility  = 0;
        $this->weapon   = 'wood-club.svg';
        $this->dice     = 8;
    }

}
