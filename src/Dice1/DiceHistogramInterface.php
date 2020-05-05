<?php

namespace Kris3XIQ\Dice1;

/**
 * A interface for a classes supporting histogram reports.
 */
interface DiceHistogramInterface
{
    /**
     * Get the values from the dices from the last roll.
     * 
     * @return array $values
     */
    public function getValues();

    /**
     * Get the values of previous game rounds.
     * 
     * @return array $valuesHistogram
     */
    public function getHistogramValues();
}
