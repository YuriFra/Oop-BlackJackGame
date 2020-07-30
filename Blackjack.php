<?php
declare(strict_types=1);

class Blackjack {
    private Player $player;
    private Dealer $dealer;

    public function __construct() {
        $deck = new Deck();
        $deck->shuffle();
        $this->player = new Player($deck);
        $this->dealer = new Dealer($deck);
    }

    public function getPlayer(): Player {
        return $this->player;
    }

    public function getDealer(): Dealer {
        return $this->dealer;
    }
}