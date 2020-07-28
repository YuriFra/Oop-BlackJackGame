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
    public function __construct()
    {
        $deck = new Deck();
        $deck->shuffle();
        $this->deck = $deck;
        $this->player = new Player($this->deck);
        $this->dealer = new Player($this->deck);
    }

    /**
     * @return string
     */
    public function getPlayer(): object
    {
        return $this->player;
    }

    /**
     * @return string
     */
    public function getDealer(): object
    {
        return $this->dealer;
    }

    public function outPut() {
        $scorePlayer = 0;
        $scoreDealer = 0;
        echo "<h1>Player</h1><br>";
        foreach($this->player->getCards() AS $card) {
            echo $card->getUnicodeCharacter(true);
            echo '<br>';
            $scorePlayer += $card->getValue();
        }
        echo "<h1>Score: {$scorePlayer}</h1><br>";
        echo "<h1>Dealer</h1><br>";
        foreach($this->dealer->getCards() AS $card) {
            echo $card->getUnicodeCharacter(true);
            echo '<br>';
            $scoreDealer += $card->getValue();
        }
        echo "<h1>Score: {$scoreDealer}</h1><br>";
    }

}