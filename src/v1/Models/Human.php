<?php

namespace App\v1\Models;

class Human extends Character
{

    public function __construct()
    {
        $this->hp       = 12;
        $this->attack   = 2;
        $this->defense  = 1;
        $this->strength = 1;
        $this->agility  = 2;
        $this->weapon   = 'long-sword.svg';
        $this->dice     = 6;
    }

}
