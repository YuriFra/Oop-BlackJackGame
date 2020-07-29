<?php
declare(strict_types=1);

class Player {
    private array $cards;
    private bool $lost = false;
    private int $chips;

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

    public function Hit() : void {
        $this->cards[] = $_SESSION['game']->getDeck()->drawCard();
        $scorePlayer = $_SESSION['game']->getPlayer()->getScore()[0];
        if ($scorePlayer > 21) {
            $this->lost = true;
        }
    }
    public function Surrender() : void {
        $this->lost = true;
    }
    public function getScore() : array {
        $scorePlayer = 0;
        $cards = $_SESSION['game']->getPlayer()->getCards();
        foreach ($cards as $card) {
            $scorePlayer += $card->getValue();
        }
        $scoreDealer = 0;
        $cards = $_SESSION['game']->getDealer()->getCards();
        foreach ($cards as $card) {
            $scoreDealer += $card->getValue();
        }
        return [$scorePlayer, $scoreDealer];
    }
    public function hasLost() : bool {
        return ($this->lost);
    }

    /**
     * @return int
     */
    public function getChips(): int
    {
        return $this->chips;
    }

}

class Dealer extends Player {
    public function Hit() : void {
        while ($_SESSION['game']->getDealer()->getScore()[1] < 15) {
            parent::Hit();
        }
    }
}