<?php

namespace App\v1\Models;

class Character
{

    /**
     *
     * @var int 
     */
    public $hp;

    /**
     *
     * @var int 
     */
    public $attack;

    /**
     *
     * @var int 
     */
    public $defense;

    /**
     *
     * @var int 
     */
    public $strength;

    /**
     *
     * @var int 
     */
    public $agility;

    /**
     *
     * @var string 
     */
    public $weapon;

    /**
     *
     * @var int 
     */
    public $dice;

    /**
     * 
     */
    public function __construct()
    {
        
    }

    /**
     * 
     * @return int
     */
    public function getAttack()
    {
        return $this->attack + $this->agility;
    }

    /**
     * 
     * @return int
     */
    public function getDefense()
    {
        return $this->defense + $this->agility;
    }

}
