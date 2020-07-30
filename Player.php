<?php
declare(strict_types=1);

class Player {
    private array $cards;
    private bool $lost = false;
    private int $chips;
    const START_CHIPS = 100;
    private Deck $deck;

    public function __construct(Deck $deck)
    {
        for($i = 0; $i < 2; $i++) {
            $this->cards[] = $deck->drawCard();
        }
        $this->chips = isset($_COOKIE['chips']) ? (int)$_COOKIE['chips'] : self::START_CHIPS;
        $this->deck = $deck;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function Hit() : void {
        $this->cards[] = $this->deck->drawCard();
        if ($this->getScore() > 21) {
            $this->lost = true;
        }
    }
    public function Surrender() : void {
        $this->lost = true;
    }
    public function getScore() : int {
        $scorePlayer = 0;
        $cards = $this->cards;
        foreach ($cards as $card) {
            $scorePlayer += $card->getValue();
        }
        return $scorePlayer;
    }
    public function hasLost() : bool {
        return $this->lost;
    }

    public function getChips(): int
    {
        return $this->chips;
    }
}

class Dealer extends Player {
    const DEALER_LIMIT = 15;

    public function Hit() : void {
        while ($this->getScore() < self::DEALER_LIMIT) {
            parent::Hit();
        }
    }
}