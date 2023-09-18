<?php
$topic = $result["data"]['topic'];
$messages = $result["data"]['messages'];

// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];

?>

<h1><?= $topic->getNameTopic() ?></h1>

<!-- LOCK OR UNLOCK TOPIC -->
<!-- L'admin peut choisir de clore un topic ou non -->
<?php 
if (App\Session::isAdmin()) {
    if ($topic->getSubjectLock()) {
    ?>
    <a href="index.php?ctrl=forum&action=topicUnlock&id=<?= $topic->getId() ?>">
        <i class="fa-solid fa-lock-open fs-2"></i>
    </a>
    <?php 
    } else {
    ?>
    <a href="index.php?ctrl=forum&action=topicLock&id=<?= $topic->getId() ?>">
        <i class="fa-solid fa-lock fs-2"></i>
    </a>
    <?php 
    }
} 
?>

<h2>List Messages</h2>

<div class="container d-flex flex-column justify-content-center">

    <?php
    if ($messages !== NULL) {
        foreach ($messages as $message) {
        ?>
            <div class="d-flex flex-row align-items-center gap-5 border border-primary p-2 mb-3 rounded">
                <div class="message-author flex-grow-0">
                    <!-- Faire du chaînage : $message->getUser()->getUserName() : pour récupérer le getUserName -->
                    <p>De : <?= $message->getUser()->getUserName() ?></p>

                    <?php if(App\Session::getUser()->hasRole("ROLE_ADMIN")) { 
                        ?>
                        <p>Administrateur</p>
                        <?php 
                    } else { 
                        ?>
                        <p>Visiteur</p>
                        <?php 
                    } 
                    ?>
                </div>
                <div class="message-published">
                    <div class="date text-end">
                        <p>Le : <?= $message->getDateCreationText() ?></p>
                    </div>
                    <div class="text border border-primary rounded p-2">
                        <p><?= $message->getCommentText()?></p>
                    </div>
                </div>

                <!-- UPDATE -->
                <!-- Quand on clique on récupère idMessage et topicId pour être sûr de changer le message dans le bon topic :
                $message->getId() ?>&topicId=< $topic->getId() ?>
                -->
                <?php if (App\Session::getUser()) { 
                    ?>
                    <a href="index.php?ctrl=forum&action=updateMessageForm&id=<?= $message->getId() ?>&topicId=<?= $topic->getId() ?>">
                        <i class="fa-solid fa-pencil fs-5" title="Update"></i>
                    </a>

                    <!-- DELETE -->
                    <a href="index.php?ctrl=forum&action=deleteMessage&id=<?= $message->getId() ?>&topicId=<?= $topic->getId() ?>" class=".delete-btn" onclick="return confirm('Etes-vous sûr de vouloir supprimer?');">
                        <i class="fa-regular fa-trash-can fs-5" title="Delete"></i>
                    </a>
                <?php 
                } 
                ?>
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
    <a class="btn btn-primary btn-add fs-5" href="index.php?ctrl=forum&action=addMessageForm&id=<?= $_GET['id'] ?>" role="button">
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
<a href='<?= $go_back ?>' class="btn btn-primary fs-5">Retour</a>

