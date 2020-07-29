<?php
declare(strict_types=1);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Blackjack.php';
require 'Player.php';

session_start();

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
        //$chipsLeft += ($_SESSION['bet'] * 2);
        echo "<h3 class='text-center my-2'>You win</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";
    } else {
        echo "<h3 class='text-center my-2'>You lose</h3><div class='text-center'><a class='badge badge-primary' href='index.php'>Play again</a></div>";
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






