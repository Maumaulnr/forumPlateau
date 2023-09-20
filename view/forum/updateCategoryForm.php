<?php
$category = $result["data"]['category'];

// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];
?>


<h1>Modifier la catégorie</h1>

<form method="POST" action="index.php?ctrl=forum&action=updateCategory&id=<?= $category->getId() ?>" class="d-flex flex-column justify-content-center align-items-center gap-5">

    <label for="nameCategory" class="fs-4">Nom de la catégorie à modifier</label>
    <input type="text" id="nameCategory"  name="nameCategory" value="<?= $category->getNameCategory() ?>" placeholder="Nom de la catégorie" class="text-center fs-5">

    <button type="submit" class="btn btn-primary w-50 fs-5">Modifier</button>

</form>