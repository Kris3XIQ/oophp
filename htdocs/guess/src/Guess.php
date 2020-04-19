<?php
/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    public $number;
    public $tries;

    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    
    public function __construct(int $number = -1, int $tries = 6) 
    {
        $this->number = $number;
        $this->tries = $tries;
        $this->number = $this->random();
    }

    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function random() 
    {
        return rand(1, 100);
    }

    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function tries() 
    {
        return $this->tries;
    }

    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number() 
    {
        return $this->number;
    }

    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     * 
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess($numberGuessed) 
    {
        try {
            // Making sure the guess is valid, throws my GuessException otherwise.
            if ((int)$numberGuessed >= 1 and (int)$numberGuessed <= 100) {
                if ($numberGuessed and $this->tries > 0) {
                    // Make another guess
                    $this->tries -= 1;
                    if ($numberGuessed == $this->number) {
                        $res = "CORRECT!";
                        echo '<script>alert("YOU WIN!! Pressing OK will reset the game.")</script>';
                        session_destroy();
                        return;
                    } elseif ($numberGuessed > $this->number) {
                        $res = "TOO HIGH, {$this->tries} left";
                        return $res;
                    } elseif ($numberGuessed < $this->number) {
                        $res = "TOO LOW, {$this->tries} left";
                        return $res;
                    }
                }
                $res = "Cant make any more gusses, that was your last one! Starting another game";
                echo '<script>alert("Cant make any more gusses, that was your last one! Starting another game")</script>';
                session_destroy();
            } else {
                throw new GuessException("Your guess have to be a number between 1 and 100!");
            }
        } catch (GuessException $e) {
            echo "Got exception: " . get_class($e) . "\n Message: " . $e->getMessage() . "<hr>";
        }
    }
}
