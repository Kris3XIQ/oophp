<?php
if (!$resultset) {
    echo
    "
    <h1>Här var det tomt!</h1>
    <p>Finns inga blogg-inlägg att hämta</p>
    ";
    return;
}
?>

<article>

<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h1><a href="blogpost/<?= $row->slug ?>"><?= $row->title ?></a></h1>
        <p><i>Published: <time datetime="<?= $row->published_iso8601 ?>" pubdate><?= $row->published ?></time></i></p>
    </header>
    <?= $row->data ?>
</section>
<?php endforeach; ?>

</article>
