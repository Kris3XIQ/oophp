<?php

namespace Kris3XIQ\Dice1;

/**
 * A trait implementing HistogramInterface.
 */
trait DiceHistogramTrait
{
    /**
     * @var array $values  The numbers stored in sequence.
     * 
     * @var array $valuesHistogram Game history of previously rolled values.
     */
    private $values = [];
    public $valuesHistogram = [];

    /**
     * Get the values from the dices from the last roll.
     * 
     * @return array $values
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Get the values of previous game rounds.
     * 
     * @return array $valuesHistogram
     */
    public function getHistogramValues()
    {
        return $this->valuesHistogram;
    }
}
