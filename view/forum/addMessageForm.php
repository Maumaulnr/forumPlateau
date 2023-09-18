<?php

$topic = $result["data"]['topic'];

// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];

?>



<div class="d-flex flex-column justify-content-center gap-5">

    <form action="index.php?ctrl=forum&action=addMessage" method="post" class="d-flex flex-column gap-2 text-center">

        <label for="commentText">Message</label>
        <textarea name="commentText" id="commentText" class="text-center" cols="60" rows="10"></textarea>
        
        <input type="hidden" name="topicId" value="<?= $topic->getId() ?>">

        <button class="btn btn-primary" type="submit">Submit</button>

    </form>

</div>