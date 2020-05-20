<?php

use \Kris3XIQ\TextFilter\MyTextFilter;

// Include essentials
require __DIR__ . "/../../src/TextFilter/config.php";
include("../src/TextFilter/MyTextFilter.php");

$filter = new MyTextFilter();
$text = file_get_contents(__DIR__ . "/../../src/TextFilter/text/clickable.txt");
$html = $filter->parse($text, ["link"]);


?><!doctype html>
<html>
<meta charset="utf-8">
<title>Show off Clickable</title>

<h1>Showing off Clickable</h1>

<h2>Source in clickable.txt</h2>
<pre><?= wordwrap(htmlentities($text)) ?></pre>

<h2>Source formatted as HTML</h2>
<?= $text ?>

<h2>Filter Clickable applied, source</h2>
<pre><?= wordwrap(htmlentities($html)) ?></pre>

<h2>Text displayed after being formatted with MyTextFilter class</h2>
<?= $html ?>
