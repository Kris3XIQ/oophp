<?php
/**
 * Guess my number
 */
require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";

// Initialize the session
session_name("game");
session_start();

// If session isnt set, start a new game.
if (!isset($_SESSION["new_game"])) {
    $_SESSION["new_game"] = new Guess();
}
$game = $_SESSION["new_game"];

/**
 * If make init dont return NULL, the user
 * pressed the reset button, leading up
 * to the session being destroyed just to 
 * start a new one.
 */
$makeInit = $_POST["makeInit"] ?? null;
if (!(is_null($makeInit))) {
    session_destroy();
}

// Variables
$tries = $game->tries();
$number = $game->number();
$guess = $_POST["guess"] ?? null;
$makeGuess = $_POST["makeGuess"] ?? null;
$makeCheat = $_POST["makeCheat"] ?? null;

/**
 * If the user made a guess, I call for the
 * Guess class so that the game logic can be
 * processed. 
 */
if (!is_null($makeGuess)) {
    $res = $game->makeGuess($guess);
}

require __DIR__ . "/view/guess_my_number.php";
