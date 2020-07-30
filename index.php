<?php
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Blackjack.php';
require 'Player.php';

session_start();

const BLACKJACK = 21;

if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = new Blackjack();
}
if (isset($_POST['input'])) {
    $_SESSION['bet'] = $_POST['input'];
}
if(!isset($_COOKIE['chips'])){
    setcookie('chips', '100', time() + (120), "/");
}
$bet = isset($_SESSION['bet']) ? (int)$_SESSION['bet'] : 0;

require 'form.php';

//button actions
if(isset($_GET['action'])) {
    if ($_GET['action'] === 'hit') {
        $_SESSION['game']->getPlayer()->Hit();
    }
    if ($_GET['action'] === 'stand') {
        $_SESSION['game']->getDealer()->Hit();
    }
    if ($_GET['action'] === 'surrender') {
        $_SESSION['game']->getPlayer()->Surrender();
    }
}

//output html result
$win = "<h3 class='text-center'>You win</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";
$lose = "<h3 class='text-center'>You lose</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";
$tie = "<h3 class='text-center'>It's a tie</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";

if ($_SESSION['game']->getPlayer()->hasLost()) {
    echo $lose;
    $chipStatus = (int)$_COOKIE['chips'] - $bet;
    setcookie('chips', (string)$chipStatus);
    session_destroy();
}

$scorePlayer = $_SESSION['game']->getPlayer()->getScore();
$scoreDealer = $_SESSION['game']->getDealer()->getScore();

//first turn rule
if (!isset($_GET['action'])) {
    if ($scoreDealer === BLACKJACK && $scorePlayer === BLACKJACK) {
        echo $tie;
        session_destroy();
    } elseif ($scorePlayer === BLACKJACK || $scoreDealer > BLACKJACK) {
        echo $win;
        $chipStatus = (int)$_COOKIE['chips'] + 10;
        setcookie('chips', (string)$chipStatus);
        session_destroy();
    } elseif ($scoreDealer === BLACKJACK || $scorePlayer > BLACKJACK) {
        echo $lose;
        $chipStatus = (int)$_COOKIE['chips'] - 5;
        setcookie('chips', (string)$chipStatus);
        session_destroy();
    }
}
//output stand result
else {
    if ($_GET['action'] === 'stand') {
        if ($scoreDealer > BLACKJACK && $scorePlayer > BLACKJACK) {
            $_SESSION['game']->getPlayer()->Surrender();
        }
        if ($scoreDealer <= BLACKJACK && $scoreDealer >= $scorePlayer) {
            $_SESSION['game']->getPlayer()->Surrender();
        }
        if (!$_SESSION['game']->getPlayer()->hasLost()) {
            echo $win;
            $chipStatus = (int)$_COOKIE['chips'] + $bet;
            setcookie('chips', (string)$chipStatus);
        } else {
            echo $lose;
            $chipStatus = (int)$_COOKIE['chips'] - $bet;
            setcookie('chips', (string)$chipStatus);
        }
        session_destroy();
    }
}

//output player cards & score
echo "<div class='container'><div class='row'><div class='col-6 text-center'><h1>Player</h1>
      <h2>Score: {$scorePlayer}</h2><div class='d-flex flex-row justify-content-center'>";
foreach($_SESSION['game']->getPlayer()->getCards() AS $card) {
    echo "{$card->getUnicodeCharacter(true)}<br>";
}
echo '</div></div>';

//output dealer on draw 1 card & score
echo "<div class='col-6 text-center'><h1>Dealer</h1>";
if ((isset($_GET['action']) && $_GET['action'] === 'stand') || $_SESSION['game']->getPlayer()->hasLost()) {
    echo "<h2>Score: {$scoreDealer}</h2><div class='d-flex flex-row justify-content-center'>";
    foreach ($_SESSION['game']->getDealer()->getCards() as $card) {
        echo "{$card->getUnicodeCharacter(true)}<br>";
    }
} else {
    echo "<h2>Score: ?</h2><div class='d-flex flex-row justify-content-center'>
          {$_SESSION['game']->getDealer()->getCards()[0]->getUnicodeCharacter(true)}<br>";
}
echo '</div></div></div></body></html>';






