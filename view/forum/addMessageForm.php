<?php

$topic = $result["data"]['topic'];

// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];

?>



<div class="d-flex flex-column justify-content-center gap-5">

    <form action="index.php?ctrl=forum&action=addMessage" method="post" class="d-flex flex-column justify-content-center align-items-center gap-5 text-center">

        <label for="commentText" class="fs-4">Vous pouvez écrire votre message</label>
        <textarea name="commentText" id="commentText" class="post" cols="60" rows="10"></textarea>
        
        <input type="hidden" name="topicId" value="<?= $topic->getId() ?>">

        <button class="btn btn-primary w-50 fs-5" type="submit">Envoyer</button>

    </form>

</div>