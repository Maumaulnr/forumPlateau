<?php
$topic = $result["data"]['topic'];
$messages = $result["data"]['messages'];
// var_dump($user);
?>

<h1><?= $topic->getNameTopic() ?></h1>

<!-- LOCK OR UNLOCK TOPIC -->
<?php 
if (App\Session::isAdmin()) { 
    ?>
    <a href="index.php?ctrl=security&action=topicUnlock&id=<?= $topic->getId() ?>">
        <i class="fa-solid fa-lock-open"></i>
    </a>
    <?php 
} else {
    ?>
    <a href="index.php?ctrl=security&action=topicLock&id=<?= $topic->getId() ?>">
        <i class="fa-solid fa-lock"></i>
    </a>
    <?php 
} 
?>

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
                <a href="index.php?ctrl=forum&action=deleteMessage&id=<?= $message->getId() ?>&topicId=<?= $topic->getId() ?>" class=".delete-btn" onclick="return confirm('Etes-vous sûr de vouloir supprimer?');">
                    <i class="fa-regular fa-trash-can" title="Delete"></i>
                </a>
            </div>
        <?php
        }
    }
    ?>
</div>

<?php 
// si le visiteur est connecté et si le topic n'est pas verouillé (&& !)
 if (App\Session::getUser() && !$topic->getSubjectLock()) {
?>
    <!-- On ajoute un message dans le topic où l'on se trouve -->
    <a class="btn btn-primary btn-add" href="index.php?ctrl=forum&action=addMessageForm&id=<?= $_GET['id'] ?>" role="button">
        Add Message
    </a>
<?php
} else {
?>
<p>Veuillez vous connecter et si vous êtes connecté alors le topic est clos</p>
<?php
}
?>

<!--
 * Returns a URL to the page where user was before this page
 -->
<?php 
$go_back = htmlspecialchars($_SERVER['HTTP_REFERER']);
?>
<a href='<?= $go_back ?>' class="btn btn-primary">Retour</a>

