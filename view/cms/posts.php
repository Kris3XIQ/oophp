<?php

namespace Anax\View;

/**
 * View file to render view from my different textfilters.
 */

if (!$resultset) {
    echo "
<table>
    <tr>
        <th>Id</th>
        <th>Path</th>
        <th>Slug</th>
        <th>Titel</th>
        <th>Innehåll</th>
        <th>Typ</th>
        <th>Filter</th>
        <th>Publicerad</th>
        <th>Skapad</th>
        <th>Uppdaterad</th>
        <th>Borttagen</th>
    </tr>
</table>
<p> Finns inga blogg-inlägg att hämta! </p>
";
    return;
}
?>
<table>
    <tr class="first">
        <th>Id</th>
        <th>Titel</th>
        <th>Typ</th>
        <th>Publicerad</th>
        <th>Skapad</th>
        <th>Uppdaterad</th>
        <th>Bortagen</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>
