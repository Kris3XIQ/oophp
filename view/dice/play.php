<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>DiceGame</h1>
<?php if (!($winCondition)) :?>
    <form method="post">
        <div class="buttons">
        <input type="submit" name="diceRoll" id="diceButton01" value="Roll the dice">
        <input type="submit" name="diceBank" id="diceButton02" value="Bank score on hand">
        <input type="submit" name="diceInit" id="diceButton03" value="Start over">
        </div>
    </form>
<?php endif; ?>
<div class="result-wrap">
    <h3>Nuvarande Ställning:</h3>
    <p>Spelare 1: <?= $player_one_score ?></p>
    <p>Spelare 2: <?= $player_two_score ?></p>
    <h3>Spelomgång</h3>
    <p>Poäng på hand: <?= $hand ?></p>
    <p>Player: <?= $turn ?>'s turn.</p>
    <?php if ($roll) : ?>
        <?php foreach ($roll as $rolls) { 
            echo $rolls; ?>,
        <?php } ?>
    <?php endif; ?>
    <?php if ($winCondition) :?>
        <p>WIN: <?= $winMessage ?> med <?= $winScore ?> poäng!.</p>
        <form method="post">
            <div class="buttons">
                <input type="submit" name="diceReset" id="diceButton04" value="Play Again!">
            </div>
        </form>
    <?php endif; ?>
</div>
