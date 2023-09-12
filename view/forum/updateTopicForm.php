<?php
$topic = $result["data"]['topic'];
$category = $result["data"]['category'];
$categoryId = $result["data"]['categoryId'];
?>

<h2>Modifier le topic</h2>

<form method="POST" action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" class="d-flex flex-column justify-content-center align-items-center gap-5">

    <input type="hidden" id="idTopic"  name="idTopic" value="<?= $topic->getId() ?>" placeholder="idTopic">

    <label for="nameTopic">Message</label>
    <input name="nameTopic" id="nameTopic" class="text-center" value="<?= $topic->getNameTopic() ?>" placeholder="Nom du Topic">

    <input type="hidden" id="categoryId" name="categoryId" value="<?= $categoryId ?>" placeholder="categoryId">

    <button type="submit" class="btn btn-primary w-50">↑ Modifier ↻</button>

</form>