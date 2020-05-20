<a href="../allblogposts"><h4><i class="fa fa-arrow-left" aria-hidden="false"></i>Tillbaka</h4></a>
<article>
    <header>
        <h1><?= $content->title ?></h1>
        <p><i>Published: <time datetime="<?= $content->published_iso8601 ?>" pubdate><?= $content->published ?></time></i></p>
    </header>
    <?= $content->data ?>
</article>
