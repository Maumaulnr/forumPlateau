<?php
$message = $result["data"]['message'];
// $user = $result["data"]['user'];
$topic = $result["data"]['topic'];
// $topicId => "topidId" => $_GET['topicId'] dans ForumController->updateMessageForm($id)
$topicId = $result["data"]['topidId'];
// var_dump($topic);
?>

<div class="update-message">

    <h1>Update the message</h1>

    <form method="POST" action="index.php?ctrl=forum&action=update&id=<?= $message->getId() ?>" class="form-flex-column">

        <input type="text" id="idMessage" name="idMessage" value="<?= $message->getId() ?>" placeholder="idMessage">

        <label for="commentText" class="">Message</label>
        <textarea name="commentText" id="commentText" class="text-center" cols="60" rows="10"><?= $message->getCommentText() ?></textarea>

        <input type="text" id="topicId" name="topicId" value="<?= $topicId ?>" placeholder="topicId">

        <button type="submit" class="button-link">↑ Update ↻</button>

    </form>

</div>