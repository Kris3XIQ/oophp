<?php

use \Kris3XIQ\TextFilter\MyTextFilter;

// Include essentials
require __DIR__ . "/../../src/TextFilter/config.php";
include("../src/TextFilter/MyTextFilter.php");

$filter = new MyTextFilter();
$text = file_get_contents(__DIR__ . "/../../src/TextFilter/text/sample.md");
$html = $filter->parse($text, ["markdown"]);


?><!doctype html>
<html>
<meta charset="utf-8">
<title>Show off Markdown</title>

<h1>Showing off Markdown</h1>

<h2>Markdown source in sample.md</h2>
<pre><?= $text ?></pre>

<h2>Text formatted as HTML source</h2>
<pre><?= htmlentities($html) ?></pre>

<h2>Text displayed after being formatted with MyTextFilter class</h2>
<?= $html ?>
