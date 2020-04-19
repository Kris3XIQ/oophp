<head>
    <link rel='stylesheet' type='text/css' href='css/style.css' />
</head>
<div class="main-wrap">
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
        <?php if ($makeGuess) : ?>
                <p class="result">You guessed <?= $guess ?> which is <?= $res ?></p>
        <?php endif; ?>

        <?php if ($makeCheat) : ?>
            <p class="result">The answer is: <?= $number ?>.</p>
            <p>Tries left: <?= $tries ?>.</p>
        <?php endif; ?>
    </div>
</div>
