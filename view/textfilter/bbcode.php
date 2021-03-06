<?php

use \Kris3XIQ\TextFilter\MyTextFilter;

// Include essentials
require __DIR__ . "/../../src/TextFilter/config.php";
include("../src/TextFilter/MyTextFilter.php");

$filter = new MyTextFilter();
$text = file_get_contents(__DIR__ . "/../../src/TextFilter/text/bbcode.txt");
$html = $filter->parse($text, ["bbcode"]);


?><!doctype html>
<html>
<meta charset="utf-8">
<title>Show off BBCode</title>

<h1>Showing off BBCode</h1>

<h2>Source in bbcode.txt</h2>
<pre><?= wordwrap(htmlentities($text)) ?></pre>

<h2>Filter BBCode applied, source</h2>
<pre><?= wordwrap(htmlentities($html)) ?></pre>

<h2>Text displayed after being formatted with MyTextFilter class</h2>
<?= $html ?>
