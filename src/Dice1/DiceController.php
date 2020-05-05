<?php

namespace Kris3XIQ\Dice1;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    // /**
    //  * @var string $db a sample member variable that gets initialised
    //  */
    // //private $db = "not active";



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";

    //     // Use $this->app to access the framework services.
    // }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        //return __METHOD__ . ", \$db is {$this->db}";
        return "INDEX!!";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        //return __METHOD__ . ", \$db is {$this->db}";
        return "Debug my game!!";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        // Init the session for the gamestart.
        $session = $this->app->session;
        $response = $this->app->response;
        $game = new DiceGame();
        $diceHistogram = new DiceHistogram();
        $playerOne = $game->getPlayer(0);
        $playerTwo = $game->getPlayer(1);
        $session->set("player_one", $playerOne);
        $session->set("player_two", $playerTwo);
        $session->set("player_one_score", null);
        $session->set("player_two_score", null);
        $session->set("roll", null);
        $session->set("turn", 1);
        $session->set("sum", null);
        $session->set("hand", null);
        $session->set("handTwo", null);
        $session->set("winCondition", null);
        $session->set("winScore", null);
        $session->set("winMessage", null);
        $session->set("diceHistogram", $diceHistogram);
        $session->set("DiceGame", $game);

        return $response->redirect("dice1/play");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $title = "Play the game";
        $session = $this->app->session;
        $page = $this->app->page;
        // If session isnt set, start a new game.
        if (!isset($_SESSION["DiceGame"])) {
            $game = new DiceGame();
            $diceHistogram = new DiceHistogram();
            $playerOne = $game->getPlayer(0);
            $playerTwo = $game->getPlayer(1);
            $session->set("player_one", $playerOne);
            $session->set("player_two", $playerTwo);
            $session->set("player_one_score", null);
            $session->set("player_two_score", null);
            $session->set("roll", null);
            $session->set("turn", 1);
            $session->set("sum", null);
            $session->set("hand", null);
            $session->set("handTwo", null);
            $session->set("winCondition", null);
            $session->set("winScore", null);
            $session->set("winMessage", null);
            $session->set("diceHistogram", $diceHistogram);
            $session->set("DiceGame", $game);
        }
        
        // Variables
        $playerOne = $session->get("player_one");
        $playerTwo = $session->get("player_two");
        $playerOneScore = $session->get("player_one_score");
        $playerTwoScore = $session->get("player_two_score");
        $roll = $session->get("roll");
        $turn = $session->get("turn");
        $hand = $session->get("hand");
        $handTwo = $session->get("handTwo");
        $sum = $session->get("sum");
        $winCondition = $session->get("winCondition");
        $winScore = $session->get("winScore");
        $winMessage = $session->get("winMessage");
        $diceHistogram = $session->get("diceHistogram");
        $endTurn = $session->get("endTurn");
        $diceRoll = null;
        $diceInit = null;
        $diceBank = null;
    
        // $_SESSION["roll"] = null;
        $session->set("roll", null);
        
        $data = [
            "roll" => $roll,
            "turn" => $turn,
            "sum" => $sum,
            "hand" => $hand,
            "handTwo" => $handTwo,
            "endTurn" => $endTurn,
            "winCondition" => $winCondition,
            "winScore" => $winScore,
            "winMessage" => $winMessage,
            "diceHistogram" => $diceHistogram,
            "player_one" => $playerOne,
            "player_two" => $playerTwo,
            "player_one_score" => $playerOneScore ?? null,
            "player_two_score" => $playerTwoScore ?? null,
            "diceRoll" => $diceRoll ?? null,
            "diceInit" => $diceInit ?? null,
            "diceBank" => $diceBank ?? null
        ];
    
        $page->add("dice1/play", $data);
        //$app->page->add("guess/debug");
    
        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionPost() : object
    {
        //$page = $this->app->page;
        $request = $this->app->request;
        // $response = $this->app->response;
        $session = $this->app->session;
        // Incoming POST variables.
        $diceInit = $request->getPost("diceInit");
        $diceReset = $request->getPost("diceReset");
        $diceRoll = $request->getPost("diceRoll");
        $diceBank = $request->getPost("diceBank");

        // $game = $session->get("DiceGame");
        $playerOne = $session->get("player_one");
        $playerTwo = $session->get("player_two");
        $playerOneScore = $session->get("player_one_score");
        $playerTwoScore = $session->get("player_two_score");
        $roll = $session->get("roll");
        $turn = $session->get("turn");
        $hand = $session->get("hand");
        $handTwo = $session->get("handTwo");
        $sum = $session->get("sum");
        $diceHistogram = $session->get("diceHistogram");
        // $winCondition = $session->get("winCondition");
        $winScore = $session->get("winScore");
        // $winMessage = $session->get("winMessage");
        $endTurn = $session->get("endTurn");

        if ($diceInit or $diceReset) {
            session_destroy();
        }

        if ($diceRoll) {
            $dices = new DiceRoll();
            $dices->rollAllDices();
            $diceHistogram->injectData($dices);
            $roll = $dices->getValues();
            $sum = $dices->sumAllDices();
            $endTurn = $dices->endTurn();
            $session->set("roll", $roll);
            $session->set("turn", $turn);
            $session->set("sum", $sum);
            $session->set("hand", $hand);
            $session->set("handTwo", $handTwo);

            if ($endTurn == 1 && $turn == 1) {
                $playerOne[0]->clearHand();
                $sum = 0;
                $hand = 0;
                $session->set("sum", $sum);
                $session->set("hand", $hand);
                $session->set("turn", 2);
            } else if ($endTurn == 1 && $turn == 2) {
                $playerTwo[1]->clearHand();
                $sum = 0;
                $handTwo = 0;
                $session->set("sum", $sum);
                $session->set("handTwo", $handTwo);
                $session->set("turn", 1);
            } else if ($endTurn == 0 && $turn == 1) {
                $hand += $sum;
                $session->set("hand", $hand);
                $playerOne[0]->pointsToHand($sum);
            } else if ($endTurn == 0 && $turn == 2) {
                if ($playerTwo[1]->getTotalScore() < $playerOne[0]->getTotalScore()) {
                    $handTwo += $sum;
                    $playerTwo[1]->pointsToHand($sum); 
                    if ($playerTwo[1]->getTotalScore() + $handTwo > $playerOne[0]->getTotalScore()) {
                        $playerTwo[1]->bankPoints($handTwo);
                        $playerTwo[1]->clearHand();
                        $sum = 0;
                        $handTwo = 0;
                        $session->set("turn", 1);
                    } else {
                        $playerTwo[1]->pointsToHand($sum);
                    }
                } else {
                    $handTwo += $sum;
                    $playerTwo[1]->bankPoints($handTwo);
                    $playerTwo[1]->clearHand();
                    $sum = 0;
                    $handTwo = 0;
                    $session->set("turn", 1);
                }
                if ($playerTwo[1]->getTotalScore() >= 100) {
                    $playerTwoScore = $playerTwo[1]->getTotalScore();
                    $winScore = $playerTwoScore;
                    $session->set("player_two_score", $playerOneScore);
                    $session->set("winScore", $winScore);
                    $session->set("winCondition", 1);
                    $session->set("winMessage", "Spelare 2 vann!");
                }
                $playerOneScore = $playerOne[0]->getTotalScore();
                $playerTwoScore = $playerTwo[1]->getTotalScore();
                $session->set("player_one_score", $playerOneScore);
                $session->set("player_two_score", $playerTwoScore);
                $session->set("handTwo", $handTwo);
            }
            $session->set("diceHistogram", $diceHistogram);
            $session->set("endTurn", $endTurn);
        }

        if ($diceBank) {
            $playerTwoScore = $playerTwo[1]->getTotalScore();
            $session->set("player_two_score", $playerTwoScore);
            if ($turn == 1) {
                $sum = $session->get("sum");
                $playerOne[0]->bankPoints($hand);
                $playerOneScore = $playerOne[0]->getTotalScore();
                if ($playerOneScore >= 100) {
                    $winScore = $playerOneScore;
                    $session->set("player_one_score", $playerOneScore);
                    $session->set("winScore", $winScore);
                    $session->set("winCondition", 1);
                    $session->set("winMessage", "Spelare 1 vann!");
                }
                $playerOne[0]->clearHand();
                $sum = 0;
                $hand = 0;
                $playerOneScore = $playerOne[0]->getTotalScore();
                $session->set("player_one_score", $playerOneScore);
                $session->set("sum", $sum);
                $session->set("hand", $hand);
                $session->set("turn", 2);
            }
        }

        return $this->app->response->redirect("dice1/play");
    }


    // /**
    //  * This sample method dumps the content of $app.
    //  * GET mountpoint/dump-app
    //  *
    //  * @return string
    //  */
    // public function dumpAppActionGet() : string
    // {
    //     // Deal with the action and return a response.
    //     $services = implode(", ", $this->app->getServices());
    //     return __METHOD__ . "<p>\$app contains: $services";
    // }



    // /**
    //  * Add the request method to the method name to limit what request methods
    //  * the handler supports.
    //  * GET mountpoint/info
    //  *
    //  * @return string
    //  */
    // public function infoActionGet() : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}";
    // }



    // /**
    //  * This sample method action it the handler for route:
    //  * GET mountpoint/create
    //  *
    //  * @return string
    //  */
    // public function createActionGet() : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}";
    // }



    // /**
    //  * This sample method action it the handler for route:
    //  * POST mountpoint/create
    //  *
    //  * @return string
    //  */
    // public function createActionPost() : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}";
    // }



    // /**
    //  * This sample method action takes one argument:
    //  * GET mountpoint/argument/<value>
    //  *
    //  * @param mixed $value
    //  *
    //  * @return string
    //  */
    // public function argumentActionGet($value) : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    // }



    // /**
    //  * This sample method action takes zero or one argument and you can use - as a separator which will then be removed:
    //  * GET mountpoint/defaultargument/
    //  * GET mountpoint/defaultargument/<value>
    //  * GET mountpoint/default-argument/
    //  * GET mountpoint/default-argument/<value>
    //  *
    //  * @param mixed $value with a default string.
    //  *
    //  * @return string
    //  */
    // public function defaultArgumentActionGet($value = "default") : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    // }



    // /**
    //  * This sample method action takes two typed arguments:
    //  * GET mountpoint/typed-argument/<string>/<int>
    //  *
    //  * NOTE. Its recommended to not use int as type since it will still
    //  * accept numbers such as 2hundred givving a PHP NOTICE. So, its better to
    //  * deal with type check within the action method and throuw exceptions
    //  * when the expected type is not met.
    //  *
    //  * @param mixed $value with a default string.
    //  *
    //  * @return string
    //  */
    // public function typedArgumentActionGet(string $str, int $int) : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}, got string argument '$str' and int argument '$int'.";
    // }



    // /**
    //  * This sample method action takes a variadic list of arguments:
    //  * GET mountpoint/variadic/
    //  * GET mountpoint/variadic/<value>
    //  * GET mountpoint/variadic/<value>/<value>
    //  * GET mountpoint/variadic/<value>/<value>/<value>
    //  * etc.
    //  *
    //  * @param array $value as a variadic parameter.
    //  *
    //  * @return string
    //  */
    // public function variadicActionGet(...$value) : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}, got '" . count($value) . "' arguments: " . implode(", ", $value);
    // }



    // /**
    //  * Adding an optional catchAll() method will catch all actions sent to the
    //  * router. You can then reply with an actual response or return void to
    //  * allow for the router to move on to next handler.
    //  * A catchAll() handles the following, if a specific action method is not
    //  * created:
    //  * ANY METHOD mountpoint/**
    //  *
    //  * @param array $args as a variadic parameter.
    //  *
    //  * @return mixed
    //  *
    //  * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    //  */
    // public function catchAll(...$args)
    // {
    //     // Deal with the request and send an actual response, or not.
    //     //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
    //     return;
    // }
}
