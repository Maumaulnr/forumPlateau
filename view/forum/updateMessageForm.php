<?php
$message = $result["data"]['message'];
// $user = $result["data"]['user'];
$topic = $result["data"]['topic'];
// $topicId => "topidId" => $_GET['topicId'] dans ForumController->updateMessageForm($id)
$topicId = $result["data"]['topicId'];
// var_dump($topic);
?>

<h1>Topic : <?= $topic->getNameTopic() ?></h1>


<h2>Modifier le message</h2>

<form method="POST" action="index.php?ctrl=forum&action=update&id=<?= $message->getId() ?>" class="d-flex flex-column justify-content-center align-items-center gap-5">

    <input type="hidden" id="idMessage"  name="idMessage" value="<?= $message->getId() ?>" placeholder="idMessage">

    <label for="commentText">Message</label>
    <textarea name="commentText" id="commentText" class="text-center" cols="60" rows="10"><?= $message->getCommentText() ?></textarea>

    <input type="hidden" id="topicId" name="topicId" value="<?= $topicId ?>" placeholder="topicId">

    <button type="submit" class="btn btn-primary w-50">↑ Modifier ↻</button>

</form>
