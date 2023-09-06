<?php
$topic = $result["data"]['topic'];
$messages = $result["data"]['messages'];
?>



<div class="d-flex flex-column justify-content-center gap-5">

    <form action="index.php?ctrl=forum&action=addMessage" method="post" class="d-flex flex-column gap-2 text-center">

        <label for="commentText">Message</label>
        <textarea name="commentText" id="commentText" class="text-center" cols="60" rows="10"></textarea>
        
        <input type="text" name="topicId" value="<?= $topic->getId() ?>">

        <button class="btn btn-primary" type="submit">Submit</button>

    </form>

</div>