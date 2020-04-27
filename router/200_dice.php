<?php

/**
 * Init the game Guess and redirect to play the game.
 */
$app->router->get("dice/init", function () use ($app) {
    // Init the session for the gamestart.
    $game = new Kris3XIQ\Dice\DiceGame();
    $player_one = $game->getPlayer(0);
    $player_two = $game->getPlayer(1);
    $_SESSION["player_one"] = $player_one;
    $_SESSION["player_two"] = $player_two;
    $_SESSION["player_one_score"] = null;
    $_SESSION["player_two_score"] = null;
    $_SESSION["roll"] = null;
    $_SESSION["turn"] = 1;
    $_SESSION["hand"] = null;
    $_SESSION["sum"] = null;
    $_SESSION["winCondition"] = null;
    $_SESSION["winScore"] = null;
    $_SESSION["winMessage"] = null;
    $_SESSION["DiceGame"] = $game;

    return $app->response->redirect("dice/play");
});


/**
 * Play the game - show game status
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";
    // If session isnt set, start a new game.
    if (!isset($_SESSION["DiceGame"])) {
        $game = new Kris3XIQ\Dice\DiceGame();
        $player_one = $game->getPlayer(0);
        $player_two = $game->getPlayer(1);
        $_SESSION["player_one"] = $player_one;
        $_SESSION["player_two"] = $player_two;
        $_SESSION["player_one_score"] = null;
        $_SESSION["player_two_score"] = null;
        $_SESSION["roll"] = null;
        $_SESSION["hand"] = null;
        $_SESSION["turn"] = 1;
        $_SESSION["sum"] = null;
        $_SESSION["winCondition"] = null;
        $_SESSION["winScore"] = null;
        $_SESSION["winMessage"] = null;
        $_SESSION["DiceGame"] = $game;
    }
    
    // Variables
    $player_one = $_SESSION["player_one"] ?? null;
    $player_two = $_SESSION["player_two"] ?? null;
    $player_one_score = $_SESSION["player_one_score"] ?? null;
    $player_two_score = $_SESSION["player_two_score"] ?? null;
    $roll = $_SESSION["roll"] ?? null;
    $turn = $_SESSION["turn"] ?? null;
    $hand = $_SESSION["hand"] ?? null;
    $sum = $_SESSION["sum"] ?? null;
    $winCondition = $_SESSION["winCondition"] ?? null;
    $winScore = $_SESSION["winScore"] ?? null;
    $winMessage = $_SESSION["winMessage"] ?? null;
    $endTurn = $_SESSION["endTurn"] ?? null;

    $_SESSION["roll"] = null;
    
    $data = [
        "roll" => $roll,
        "turn" => $turn,
        "sum" => $sum,
        "hand" => $hand,
        "endTurn" => $endTurn,
        "winCondition" => $winCondition,
        "winScore" => $winScore,
        "winMessage" => $winMessage,
        "player_one" => $player_one,
        "player_two" => $player_two,
        "player_one_score" => $player_one_score ?? null,
        "player_two_score" => $player_two_score ?? null,
        "diceRoll" => $diceRoll ?? null,
        "diceInit" => $diceInit ?? null,
        "diceBank" => $diceBank ?? null
    ];

    $app->page->add("dice/play", $data);
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - Make a guess
 */
$app->router->post("dice/play", function () use ($app) {
    // Incoming POST variables.
    $diceInit = $_POST["diceInit"] ?? null;
    $diceReset = $_POST["diceReset"] ?? null;
    $diceRoll = $_POST["diceRoll"] ?? null;
    $diceBank = $_POST["diceBank"] ?? null;

    // Current settings from SESSION
    $game = $_SESSION["DiceGame"];
    $player_one = $_SESSION["player_one"];
    $player_two = $_SESSION["player_two"];
    $player_one_score = $_SESSION["player_one_score"];
    $player_two_score = $_SESSION["player_two_score"];
    $roll = $_SESSION["roll"];
    $turn = $_SESSION["turn"];
    $hand = $_SESSION["hand"];
    $sum = $_SESSION["sum"];
    $winCondition = $_SESSION["winCondition"];
    $winScore = $_SESSION["winScore"];
    $winMessage = $_SESSION["winMessage"];
    $endTurn = $_SESSION["endTurn"];

    if ($diceInit or $diceReset) {
        session_destroy();
    }

    if ($diceRoll) {
        $dices = new Kris3XIQ\Dice\DiceRoll();
        $dices->rollAllDices();
        $roll = $dices->values();
        $sum = $dices->sumAllDices();
        $endTurn = $dices->endTurn();
        $_SESSION["roll"] = $roll;
        $_SESSION["turn"] = $turn;
        $_SESSION["sum"] = $sum;
        $_SESSION["hand"] = $hand;

        if ($endTurn == 1 && $turn == 1) {
            $sum = 0;
            $hand = 0;
            $_SESSION["sum"] = $sum;
            $_SESSION["hand"] = $hand;
            $_SESSION["turn"] = 2;
        } else if ($endTurn == 1 && $turn == 2) {
            $player_one[0]->clearHand();
            $sum = 0;
            $hand = 0;
            $_SESSION["sum"] = $sum;
            $_SESSION["hand"] = $hand;
            $_SESSION["turn"] = 1;
        } else if ($endTurn == 0 && $turn == 1) {
            $hand += $sum;
            $_SESSION["hand"] = $hand;
            $player_one[0]->pointsToHand($sum);
        } else if ($endTurn == 0 && $turn == 2) {
            $player_two[1]->bankPoints($sum);
            if ($player_two[1]->getTotalScore() >= 100) {
                $player_two_score = $player_two[1]->getTotalScore();
                $winScore = $player_two_score;
                $_SESSION["player_two_score"] = $player_two_score;
                $_SESSION["winScore"] = $winScore;
                $_SESSION["winCondition"] = 1;
                $_SESSION["winMessage"] = "Spelare 2 vann!";
            }
            $sum = 0;
            $hand = 0;
            $player_one_score = $player_one[0]->getTotalScore();
            $player_two_score = $player_two[1]->getTotalScore();
            $_SESSION["player_one_score"] = $player_one_score;
            $_SESSION["player_two_score"] = $player_two_score;
            $_SESSION["sum"] = $sum;
            $_SESSION["hand"] = $hand;
            $_SESSION["turn"] = 1;
        }
        $_SESSION["endTurn"] = $endTurn;
    }

    if ($diceBank) {
        $player_two_score = $player_two[1]->getTotalScore();
        $_SESSION["player_two_score"] = $player_two_score;
        if ($turn == 1) {
            $sum = $_SESSION["sum"];
            $player_one[0]->bankPoints($hand);
            if ($player_one[0]->getTotalScore() >= 100) {
                $player_one_score = $player_one[0]->getTotalScore();
                $winScore = $player_one_score;
                $_SESSION["player_one_score"] = $player_one_score;
                $_SESSION["winScore"] = $winScore;
                $_SESSION["winCondition"] = 1;
                $_SESSION["winMessage"] = "Spelare 1 vann!";
            }
            $player_one[0]->clearHand();
            $sum = 0;
            $hand = 0;
            $player_one_score = $player_one[0]->getTotalScore();
            $_SESSION["player_one_score"] = $player_one_score;
            $_SESSION["sum"] = $sum;
            $_SESSION["hand"] = $hand;
            $_SESSION["turn"] = 2;
        }
    }

    return $app->response->redirect("dice/play");
});
