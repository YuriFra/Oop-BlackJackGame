<?php
declare(strict_types=1);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Blackjack.php';
require 'Player.php';
include 'form.html';

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
    echo "<h3 class='text-center'>You lose</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";
    session_destroy();
}
$scorePlayer = $_SESSION['game']->getPlayer()->getScore()[0];
$scoreDealer = $_SESSION['game']->getDealer()->getScore()[1];

if ($_GET['action'] === 'stand') {
    if ($scoreDealer > 21 && $scorePlayer > 21) {
        $_SESSION['game']->getPlayer()->Surrender();
    }
    if ($scoreDealer <= 21 && $scoreDealer >= $scorePlayer) {
        $_SESSION['game']->getPlayer()->Surrender();
    }
    if (!$_SESSION['game']->getPlayer()->hasLost()){
        echo "<h3 class='text-center'>You win</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";
    } else {
        echo "<h3 class='text-center'>You lose</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";
    }
    session_destroy();
}

//output
echo "<div class='container'><div class='row'><div class='col-6 text-center'><h1>Player</h1>";
echo "<h2>Score: {$scorePlayer}</h2>";
foreach($_SESSION['game']->getPlayer()->getCards() AS $card) {
    echo $card->getUnicodeCharacter(true);
    echo '<br>';
}
echo '</div>';
echo "<div class='col-6 text-center'><h1>Dealer</h1>";
echo "<h2>Score: {$scoreDealer}</h2>";
foreach($_SESSION['game']->getDealer()->getCards() AS $card) {
    echo $card->getUnicodeCharacter(true);
    echo '<br>';
}
echo '</div></div>';

/*
$deck = new Deck();
$deck->shuffle();
foreach($deck->getCards() AS $card) {
    echo $card->getUnicodeCharacter(true);
    echo '<br>';
}*/





