<?php
$message = $result["data"]['message'];

?>

<div class="update-message">

    <h1>Update the message</h1>

    <form method="POST" action="index.php?ctrl=forum&action=update&id=<?= $message->getId() ?>" class="form-flex-column">

        <label for="commentText" class="">Message</label>
        <textarea name="commentText" id="commentText" class="text-center" cols="60" rows="10"><?= $message->getCommentText() ?></textarea>

        <button type="submit" class="button-link">↑ Update ↻</button>

    </form>

</div>