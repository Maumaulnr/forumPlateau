<?php
$category = $result["data"]['category'];
// var_dump($topic);
?>


<h1>Modifier la catégorie</h1>

<form method="POST" action="index.php?ctrl=forum&action=updateCategory&id=<?= $category->getId() ?>" class="d-flex flex-column justify-content-center align-items-center gap-5">

    <label for="nameCategory">Message</label>
    <input type="text" id="nameCategory"  name="nameCategory" value="<?= $category->getNameCategory() ?>" placeholder="Nom de la catégorie">

    <button type="submit" class="btn btn-primary w-50">↑ Modifier ↻</button>

</form>