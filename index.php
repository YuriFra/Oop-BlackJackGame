<?php
declare(strict_types=1);

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

//set cookie to store bet
$cookie_name = 'chips';
$chipsLeft = $_SESSION['game']->getPlayer()->getChips() - ($_SESSION['bet'] ?? 0);
$cookie_value = $chipsLeft;
setcookie($cookie_name, (string)$cookie_value, time() + (120), "/");
var_dump($_COOKIE);

require 'form.php';

//output html result
$win = "<h3 class='text-center'>You win</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";
$lose = "<h3 class='text-center'>You lose</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";
$tie = "<h3 class='text-center'>It's a tie</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";

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
    echo $lose;
    session_destroy();
}

$scorePlayer = $_SESSION['game']->getPlayer()->getScore()[0];
$scoreDealer = $_SESSION['game']->getDealer()->getScore()[1];

//first turn rule
if (!isset($_GET['action'])) {
    if ($scoreDealer === BLACKJACK && $scorePlayer === BLACKJACK) {
        echo $tie;
        session_destroy();
    } elseif ($scorePlayer === BLACKJACK || $scoreDealer > BLACKJACK) {
        echo $win;
        session_destroy();
    } elseif ($scoreDealer === BLACKJACK || $scorePlayer > BLACKJACK) {
        echo $lose;
        session_destroy();
    }
}

if ($_GET['action'] === 'stand') {
    if ($scoreDealer > BLACKJACK && $scorePlayer > BLACKJACK) {
        $_SESSION['game']->getPlayer()->Surrender();
    }
    if ($scoreDealer <= BLACKJACK && $scoreDealer >= $scorePlayer) {
        $_SESSION['game']->getPlayer()->Surrender();
    }
    if (!$_SESSION['game']->getPlayer()->hasLost()){
        echo $win;
    } else {
        echo $lose;
    }
    session_destroy();
}

//output player cards & score
echo "<div class='container'><div class='row'><div class='col-6 text-center'><h1>Player</h1>
      <h2>Score: {$scorePlayer}</h2><div class='d-flex flex-row justify-content-center'>";
foreach($_SESSION['game']->getPlayer()->getCards() AS $card) {
    echo "{$card->getUnicodeCharacter(true)}<br>";
}
echo '</div></div>';

//output dealer cards & score
echo "<div class='col-6 text-center'><h1>Dealer</h1>
      <h2>Score: {$scoreDealer}</h2><div class='d-flex flex-row justify-content-center'>";
foreach($_SESSION['game']->getDealer()->getCards() AS $card) {
    echo "{$card->getUnicodeCharacter(true)}<br>";
}
echo '</div></div></div></body></html>';






