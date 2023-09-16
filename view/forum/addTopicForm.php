<?php
// var_dump($id);
?>


<div class="d-flex flex-column justify-content-center align-items-center gap-5">

    <h2>Add Topic</h2>

    <!-- addTopicByCategoryId -->
    <form action="index.php?ctrl=forum&action=addTopic&id=<?= $id ?>" method="post" id="addTopicForm" class="d-flex flex-column gap-2 text-center">

        <label for="nameTopic">Nom du topic</label>
        <input type="text" name="nameTopic" id="nameTopic" class="text-center" placeholder="Name Topic" maxlength="100" />

        <label for="commentText">Message</label>
        <textarea name="commentText" id="commentText" class="text-center" cols="60" rows="10"></textarea>

        <button class="btn btn-primary" type="submit">Enregistrer</button>

    </form>

    <!-- on retourne dans la liste des topics -->
    <?php 
    $go_back = htmlspecialchars($_SERVER['HTTP_REFERER']);
    ?>
    <a href='<?= $go_back ?>' class="btn btn-primary">Retour</a>

</div>
