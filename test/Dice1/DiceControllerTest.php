<?php

namespace Kris3XIQ\Dice1;

use Anax\Response\ResponseUtility;
use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;

/**
 * 
 */
class Dice1ControllerTest extends TestCase
{

    private $controller;
    private $app;

    /**
     * Setup the controller, before each testcase, just like the router
     * would set it up.
     */
    protected function setUp() : void
    {
        global $di;

        // Init service container $di to contain $app as a service
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $this->app = $app;
        $di->set("app", $app);

        $this->controller = new DiceController();
        $this->controller->setApp($app);
    }

    /**
     * Call the controller index action.
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertIsString($res);
        $this->assertContains("INDEX!!", $res);
    }

    /**
     * Call the controller debug action.
     */
    public function testDebugAction()
    {
        $res = $this->controller->debugAction();
        $this->assertIsString($res);
        $this->assertContains("Debug my game!!", $res);
    }

    /**
     * Call the controller init action.
     */
    public function testInitAction()
    {
        $res = $this->controller->initAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller play action GET.
     */
    public function testPlayActionGet()
    {
        $res = $this->controller->playActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller play action GET without an active session.
     */
    public function testPlayActionGetWihtoutActiveSession()
    {
        unset($_SESSION["DiceGame"]);
        $res = $this->controller->playActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller play action POST.
     */
    public function testPlayActionPost()
    {
        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller play action POST with the reset button.
     */
    public function testPlayActionPostDiceRollTrue()
    {
        $this->app->request->setGlobals([
            "post" => [
                "diceRoll" => true,
            ]
        ]);

        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller play action POST with 
     * DiceRoll => True
     * EndTurn => True
     * During player 1's turn
     */
    public function testPlayActionPostDiceRollTrueEndTurnTrueP1()
    {
        $this->app->request->setGlobals([
            "post" => [
                "diceRoll" => true,
                "endTurn" => 1,
                "turn" => 1,
            ],
            "get" => [
                "turn" => 1,
                "endTurn" => 1,
            ]
        ]);
        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller play action POST with 
     * DiceRoll => True
     * EndTurn => False
     * During player 1's turn
     */
    public function testPlayActionPostDiceRollTrueEndTurnFalseP1()
    {
        $this->app->request->setGlobals([
            "post" => [
                "diceRoll" => true,
                "endTurn" => 0,
                "turn" => 1,
            ],
            "get" => [
                "turn" => 1,
                "endTurn" => 0,
            ]
        ]);

        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller play action POST with the bank points button.
     */
    public function testPlayActionPostDiceBank()
    {
        $this->app->request->setGlobals([
            "post" => [
                "diceBank" => true,
            ]
        ]);

        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
