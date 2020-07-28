<?php
declare(strict_types=1);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Blackjack.php';
require 'Player.php';
include 'form.php';


session_start();

if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = new Blackjack();
}
$_SESSION['game']->outPut();


if ($_GET['action'] === 'hit') {
    echo "player chose hit";
}



/*
$deck = new Deck();
$deck->shuffle();
foreach($deck->getCards() AS $card) {
    echo $card->getUnicodeCharacter(true);
    echo '<br>';
}*/





