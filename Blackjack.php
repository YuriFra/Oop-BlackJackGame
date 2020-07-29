<?php
declare(strict_types=1);

class Blackjack {
    private object $player;
    private object $dealer;
    private object $deck;

    /**
     * Blackjack constructor.
     * @param object $player
     * @param object $dealer
     * @param object $deck
     */
    public function __construct() {
        $deck = new Deck();
        $deck->shuffle();
        $this->deck = $deck;
        $this->player = new Player($this->deck);
        $this->dealer = new Dealer($this->deck);
    }

    /**
     * @return string
     */
    public function getPlayer(): object {
        return $this->player;
    }

    /**
     * @return string
     */
    public function getDealer(): object {
        return $this->dealer;
    }

    /**
     * @return Deck|object
     */
    public function getDeck() : object {
        return $this->deck;
    }
}