<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>Guess my number</h1>

<p>Guess a number between 1 and 100, you have a limited amount of tries.</p>

<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <div class="buttons">
    <input type="submit" name="makeGuess" id="sub1" value="Make a guess">
    <input type="submit" name="makeInit" id="sub2" value="Start over">
    <input type="submit" name="makeCheat" id="sub3" value="Show answer">
    </div>
</form>
<div class="result-wrap">
    <?php if ($res) : ?>
        <?php if ($res == "CORRECT!") {
            echo '<script>alert("YOU WIN!! Pressing OK will reset the game.")</script>';
            session_destroy();
        } elseif ($res == "NoMore") {
            echo '<script>alert("Cant make any more guesses, that was your last one! Starting another game")</script>';
            session_destroy();
        }?>
        <p class="result">You guessed <?= $guess ?> which is <?= $res ?></p>
    <?php endif; ?>

    <?php if ($cheat) : ?>
        <p class="result">The answer is: <?= $number ?>.</p>
        <p>Tries left: <?= $tries ?>.</p>
    <?php endif; ?>
</div>
