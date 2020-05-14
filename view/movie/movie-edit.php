<form method="post">
    <fieldset>
    <legend>Edit</legend>

    <p>
        <label>Title:<br> 
        <input type="text" name="movieTitle" value="<?= $movie->title ??  "A title" ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br> 
        <input type="number" name="movieYear" value="<?= $movie->year ?? 2020 ?>"/>
    </p>

    <p>
        <label>Image:<br> 
        <input type="text" name="movieImage" value="<?= $movie->image ?? "img/noimage.png" ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
        <input type="submit" name="doBack" value="Back">
    </p>
    <p>
        <a href="library">Show all</a>
    </p>
    </fieldset>
</form>
