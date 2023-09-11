<h1>Catégorie : <?= $topic->getNameTopic() ?></h1>

<h2>Modifier le topic</h2>

<form method="POST" action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" class="d-flex flex-column justify-content-center align-items-center gap-5">

    <input type="hidden" id="idMessage"  name="idMessage" value="<?= $topic->getId() ?>" placeholder="idMessage">

    <label for="commentText">Message</label>
    <input name="commentText" id="commentText" class="text-center" placeholder="<?= $topic->getNameTopic() ?>">

    <input type="hidden" id="topicId" name="topicId" value="<?= $topicId ?>" placeholder="topicId">

    <button type="submit" class="btn btn-primary w-50">↑ Modifier ↻</button>

</form>