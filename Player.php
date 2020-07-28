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
        $this->cards[] = $_SESSION['game']->getDeck()->drawCard();
        $scorePlayer = $_SESSION['game']->getPlayer()->getScore()[0];
        if ($scorePlayer > 21) {
            $this->lost = true;
        }
    }
    public function Surrender() {
        $this->lost = true;
    }
    public function getScore() {
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
    public function hasLost() {
        return ($this->lost);
    }
}

class Dealer extends Player {
    public function Hit()
    {
        while ($_SESSION['game']->getDealer()->getScore()[1] < 15) {
            parent::Hit();
        }
        if ($_SESSION['game']->getDealer()->getScore()[1] > 21 && $_SESSION['game']->getPlayer()->getScore()[0] > 21) {
            $_SESSION['game']->getPlayer()->Surrender();
        } elseif ($_SESSION['game']->getDealer()->getScore()[1] <= 21 && $_SESSION['game']->getDealer()->getScore()[1] >= $_SESSION['game']->getPlayer()->getScore()[0]) {
            $_SESSION['game']->getPlayer()->Surrender();
        } else {
            echo "You win <a href='index.php'>Play again</a>";
            session_destroy();
        }
    }
}