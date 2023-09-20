<?php
$message = $result["data"]['message'];
// $topicId => "topidId" => $_GET['topicId'] dans ForumController->updateMessageForm($id)
$topicId = $result["data"]['topicId'];

// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];
?>


<h1>Modifier le message</h1>

<form method="POST" action="index.php?ctrl=forum&action=update&id=<?= $message->getId() ?>" class="d-flex flex-column justify-content-center align-items-center gap-5">

    <input type="hidden" id="idMessage"  name="idMessage" value="<?= $message->getId() ?>" placeholder="idMessage">

    <label for="commentText">Message</label>
    <textarea name="commentText" id="commentText" class="text-center" cols="60" rows="10"><?= $message->getCommentText() ?></textarea>

    <input type="hidden" id="topicId" name="topicId" value="<?= $topicId ?>" placeholder="topicId">

    <button type="submit" class="btn btn-primary w-50">Modifier</button>

</form>
