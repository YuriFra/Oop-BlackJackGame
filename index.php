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
if ($_GET['action'] === 'hit') {
    $_SESSION['game']->getPlayer()->Hit();
}
if ($_GET['action'] === 'stand') {
    $_SESSION['game']->getDealer()->Hit();
}
if ($_GET['action'] === 'surrender') {
    $_SESSION['game']->getPlayer()->Surrender();
}
if ($_SESSION['game']->getPlayer()->hasLost()) {
    echo "You lose <a href='index.php'>Play again</a>";
    session_destroy();
}
$_SESSION['game']->outPut();

/*
$deck = new Deck();
$deck->shuffle();
foreach($deck->getCards() AS $card) {
    echo $card->getUnicodeCharacter(true);
    echo '<br>';
}*/





