<?php
$topic = $result["data"]['topic'];
$messages = $result["data"]['messages'];

// var_dump();
?>

<h1>List Messages</h1>

<div>


    <h2><?= $topic->getNameTopic() ?></h2>


    <?php
    if ($messages !== NULL) {
        foreach ($messages as $message) {
        ?>
            <p><?= $message->getCommentText()?></p>
            <!-- UPDATE -->
            <a href="index.php?ctrl=forum&action=updateMessageForm&id=<?= $message->getId() ?>">
                <i class="fa-solid fa-pencil" title="Update"></i>
            </a>
            <!-- DELETE -->
            <a href="index.php?ctrl=forum&action=delete&id=<?= $message->getId() ?>">
                <i class="fa-regular fa-trash-can" title="Delete"></i>
            </a>
        <?php
        }
    }
    ?>

    <!-- On ajoute un message dans le topic où l'on se trouve -->
    <a class="btn btn-primary btn-add" href="index.php?ctrl=forum&action=addMessageForm&id=<?= $topic->getId(); ?>" role="button">
        Add Message
    </a>

    <!-- on retourne dans la liste des topics -->
    <?php 
    $go_back = htmlspecialchars($_SERVER['HTTP_REFERER']);
    ?>
    <a href='<?= $go_back ?>'>Go Back</a>;

</div>