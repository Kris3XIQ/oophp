<?php

/**
 * Init the game Guess and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the gamestart.
    $game = new Kris3XIQ\Guess\Guess();
    $_SESSION["tries"] = $game->tries();
    $_SESSION["number"] = $game->number();
    
    return $app->response->redirect("guess/play");
});


/**
 * Play the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";
    // If session isnt set, start a new game.
    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new Kris3XIQ\Guess\Guess();
        $game = $_SESSION["game"];
    }

    // Variables
    $tries = $_SESSION["tries"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $cheat = $_SESSION["cheat"] ?? null;
    $guess = $_SESSION["guess"] ?? null;

    $_SESSION["res"] = null;
    $_SESSION["cheat"] = null;
    $_SESSION["guess"] = null;

    $data = [
        "guess" => $guess ?? null,
        "tries" => $tries,
        "number" => $number,
        "res" => $res,
        "cheat" => $cheat,
        "makeGuess" => $makeGuess ?? null,
        "makeCheat" => $makeCheat ?? null,
        "makeInit" => $makeInit ?? null
    ];

    $app->page->add("guess/play", $data);
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - Make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    // Incoming POST variables.
    $guess = $_POST["guess"] ?? null;
    $makeGuess = $_POST["makeGuess"] ?? null;
    $makeCheat = $_POST["makeCheat"] ?? null;
    $makeInit = $_POST["makeInit"] ?? null;

    if (!isset($_SESSION["game"])) {
        return $app->response->redirect("guess/play");
    }
    // Current settings from SESSION
    $game = $_SESSION["game"];
    $tries = $_SESSION["tries"];
    $cheat = $_SESSION["cheat"];
    $number = $_SESSION["number"];

    if ($makeInit) {
        session_destroy();
    }

    if ($makeCheat) {
        $cheat = $game->number();
        $_SESSION["cheat"] = $cheat;
        $_SESSION["number"] = $game->number();
        $_SESSION["tries"] = $game->tries();
    }

    if ($makeGuess) {
        $res = $game->makeGuess($guess);
        $_SESSION["tries"] = $game->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
    }

    return $app->response->redirect("guess/play");
});
