<?php

namespace Kris3XIQ\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class DicePlayer
{
    /**
     * Constructor to initiate the object with current game settings.
     *
     * @param int $score Defaults to zero, players total banked score.
     *                    
     * @param int $hand  Defaults to zero, score on hand (non-banked).
     * 
     */
    
    public function __construct() 
    {
        $this->roll = [];
        $this->bank = 0;
        $this->hand = 0;
    }

    /**
     * Get a players total score.
     *
     * @return int as players total banked score.
     */
    public function getTotalScore() 
    {
        return $this->bank;
    }

    /**
     * Get a players score on hand.
     *
     * @return int as players total score on hand.
     */
    public function getHand() 
    {
        return $this->hand;
    }

    /**
     * Clear a players hand
     *
     */
    public function clearHand() 
    {
        $this->hand = 0;
    }

    /**
     * @param int $scoreToHand : Secure all your current 
     *                           points and bank them.
     * 
     */
    public function bankPoints($scoreToBank) 
    {
        $this->bank += $scoreToBank;
    }

    /**
     * @param int $scoreToHand : A players hand, if he/she decides to keep
     *                           rolling, the hand will incremently increase.
     *
     */
    public function pointsToHand($scoreToHand) 
    {
        $this->hand += $scoreToHand;
    }
}
