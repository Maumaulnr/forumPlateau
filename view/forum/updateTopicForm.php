<?php
$topic = $result["data"]['topic'];
$categoryId = $result["data"]['categoryId'];

// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];
?>

<h2>Modifier le topic</h2>

<form method="POST" action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" class="d-flex flex-column justify-content-center align-items-center gap-5">

    <input name="nameTopic" id="nameTopic" class="text-center" value="<?= $topic->getNameTopic() ?>" placeholder="Nom du Topic">

    <input type="hidden" id="categoryId" name="categoryId" value="<?= $categoryId ?>" placeholder="categoryId">

    <button type="submit" class="btn btn-primary w-50">Modifier</button>

</form>