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
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <title>BlackJackGame</title>
</head>
<body>
    <header>
        <div class="row m-2">
        <?php
        $chipsLeft = 100;
        echo "<h3 class='m-3'>Chips: {$chipsLeft}</h3>"; ?>
        <form class='form-inline'>
            <label for="input"></label>
            <input type='number' id="input" class='form-control mx-3' min='5' max='<?= $chipsLeft ?>' step='5' placeholder='Place a bet >= 5'>
            <button type='submit' class='btn btn-danger'>Submit</button>
        </form></div>
        <h1 class="text-center my-3">BlackJack Game</h1>
    </header>

<?php
include 'form.html';

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






