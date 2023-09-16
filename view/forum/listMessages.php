<?php
$topic = $result["data"]['topic'];
$messages = $result["data"]['messages'];
// var_dump($user);
?>

<h1><?= $topic->getNameTopic() ?></h1>

<h2>List Messages</h2>

<div class="container d-flex flex-column justify-content-center">

    <?php
    if ($messages !== NULL) {
        foreach ($messages as $message) {
        ?>
            <div class="d-flex flex-row align-items-center gap-5">
                <p><?= $message->getCommentText()?></p>
                <!-- Faire du chaînage : $message->getUser()->getUserName() : pour récupérer le getUserName -->
                <p>De : <?= $message->getUser()->getUserName() ?></p>
                <p>Le : <?= $message->getDateCreationText() ?></p>
                <!-- UPDATE -->
                <!-- Quand on clique on récupère idMessage et topicId pour être sûr de changer le message dans le bon topic :
                $message->getId() ?>&topicId=< $topic->getId() ?>
                -->
                <a href="index.php?ctrl=forum&action=updateMessageForm&id=<?= $message->getId() ?>&topicId=<?= $topic->getId() ?>">
                    <i class="fa-solid fa-pencil" title="Update"></i>
                </a>
                <!-- DELETE -->
                <a href="index.php?ctrl=forum&action=delete&id=<?= $message->getId() ?>&topicId=<?= $topic->getId() ?>" class=".delete-btn">
                    <i class="fa-regular fa-trash-can" title="Delete"></i>
                </a>
            </div>
        <?php
        }
    }
    ?>
</div>

    <!-- On ajoute un message dans le topic où l'on se trouve -->
    <a class="btn btn-primary btn-add" href="index.php?ctrl=forum&action=addMessageForm&id=<?= $_GET['id'] ?>" role="button">
        Add Message
    </a>

    <!-- on retourne dans la liste des topics -->
    <?php 
    $go_back = htmlspecialchars($_SERVER['HTTP_REFERER']);
    ?>
    <a href='<?= $go_back ?>' class="btn btn-primary">Retour</a>

