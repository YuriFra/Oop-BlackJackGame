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
        if ($_SESSION['game']->getPlayer()->getScore() > 21) {
            $this->lost = true;
        }
    }
    public function Surrender() {
        $this->lost = true;
    }
    public function getScore() {
    $score = 0;
    $cards = $_SESSION['game']->getPlayer()->getCards();
    foreach ($cards as $card) {
        $score += $card->getValue();
    }
}
    public function hasLost() {
        return $this->lost;
    }


}