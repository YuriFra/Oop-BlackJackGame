<?php
declare(strict_types=1);

class Player {
    private array $cards;
    private bool $lost = false;

    /**
     * Player constructor.
     * @param array $cards
     */
    public function __construct(array $cards)
    {
        $this->cards = $cards;

    }


    public function Hit() {}
    public function hasLost() {}
    public function Surrender() {}
    public function getScore() {}

}