<?php
declare(strict_types=1);

class Player {
    private array $cards;
    private bool $lost = false;

    /**
     * Player constructor.
     * @param array $cards
     */
    public function __construct(Deck $deck)
    {
        for($i = 0; $i < 2; $i++) {
            $this->cards[] = $deck->drawCard();
        }
    }

    /**
     * @return array
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function Hit() {

    }

    public function hasLost() {}
    public function Surrender() {}
    public function getScore() {}

}