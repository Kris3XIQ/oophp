<?php

namespace Kris3XIQ\Dice1;

/**
 * Generating histogram data.
 */
class DiceHistogram
{
    /**
     * @var array $values The numbers stored in sequence.
     */
    // private $values = [];
    public $valuesHistogram = [];

    /**
     * Return a string with a textual representation of the histogram.
     * 
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $num1 = 0;
        $num2 = 0;
        $num3 = 0;
        $num4 = 0;
        $num5 = 0;
        $num6 = 0;
        $string = "";

        foreach ($this->getHistogramValues() as $value) {
            if ($value == 1) {
                $num1 += 1;
                $string1 = str_repeat("*", $num1);
            } elseif ($value == 2) {
                $num2 += 1;
                $string2 = str_repeat("*", $num2);
            } elseif ($value == 3) {
                $num3 += 1;
                $string3 = str_repeat("*", $num3);
            } elseif ($value == 4) {
                $num4 += 1;
                $string4 = str_repeat("*", $num4);
            } elseif ($value == 5) {
                $num5 += 1;
                $string5 = str_repeat("*", $num5);
            } elseif ($value == 6) {
                $num6 += 1;
                $string6 = str_repeat("*", $num6);
            }
        }
        if ($num1 != null) {
            $string = $string . "1: " . $string1 . "\n";
        } else {
            $string = $string . "1: " . "\n";
        }

        if ($num2 != null) {
            $string = $string . "2: " . $string2 . "\n";
        } else {
            $string = $string . "2: " . "\n";
        }

        if ($num3 != null) {
            $string = $string . "3: " . $string3 . "\n";
        } else {
            $string = $string . "3: " . "\n";
        }

        if ($num4 != null) {
            $string = $string . "4: " . $string4 . "\n";
        } else {
            $string = $string . "4: " . "\n";
        }

        if ($num5 != null) {
            $string = $string . "5: " . $string5 . "\n";
        } else {
            $string = $string . "5: " . "\n";
        }

        if ($num6 != null) {
            $string = $string . "6: " . $string6 . "\n";
        } else {
            $string = $string . "6: " . "\n";
        }
        print_r($string);
    }

    /**
     * Get the values.
     *
     * @return array with the values.
     */
    public function getHistogramValues()
    {
        return $this->valuesHistogram;
    }

    /**
     * Inject the object to use as base for the histogram data.
     * 
     * @param DiceHistogramInterface $object The object holding the values.
     * 
     * @return void.
     */
    public function injectData(DiceHistogramInterface $object)
    {
        foreach ($object->getHistogramValues() as $value) {
            $this->valuesHistogram[] = $value;
        }
    }
}
