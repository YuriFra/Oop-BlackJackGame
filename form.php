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
        $scorePlayer = $_SESSION['game']->getPlayer()->getScore();
        $scoreDealer = $_SESSION['game']->getDealer()->getScore();
        //$chipsLeft = $_SESSION['game']->getPlayer()->getChips() - ($_SESSION['bet'] ?? 0);
        if (!isset($_GET['action'])) {
            if ($scorePlayer === BLACKJACK) {
                $chipsLeft += 10;
            } elseif ($scoreDealer === BLACKJACK) {
                $chipsLeft -= 5;
            }
        } elseif (isset($_GET['action']) ) {

        }
        if (isset($_GET['win'])) {
            $chipsLeft += ($_SESSION['bet'] * 2);
        }
        echo "<h3 class='m-3'>Chips: {$chipsLeft}</h3>"; ?>
        <form class='form-inline' method="post">
            <label for="input"></label>
            <input type='number' name="input" class='form-control mx-3' min='5' max='<?= $chipsLeft ?>' step='5' value="5">
            <button type='submit' class='btn btn-danger'>Place Bet</button>
        </form>
    </div>
    <h1 class="text-center my-3">BlackJack Game</h1>
</header>
<nav>
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="btn btn-primary m-2" role="button" href="index.php?action=hit">Hit</a>
        </li>
        <li class="nav-item">
            <a class="btn btn-primary m-2" role="button" href="index.php?action=stand">Stand</a>
        </li>
        <li class="nav-item">
            <a class="btn btn-primary m-2" role="button" href="index.php?action=surrender">Surrender</a>
        </li>
    </ul>
</nav>
