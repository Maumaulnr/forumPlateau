<?php

$topics = $result["data"]['topics'];
$category = $result["data"]['category'];

$title = $result["data"]['title'];

?>

<h1><?= $category->getNameCategory() ?></h1>

<h2>Listes des topics</h2>

<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="topics-table">
                <li class="topics-header">
                    <ul class="header-titles text-center">
                        <li>Topic</li>
                        <li>Pseudo</li>
                        <li>Date</li>
                        <li>Modifier</li>
                        <li>Supprimer</li>
                    </ul>
                </li>
                <li class="topics-body">
                    <?php
                    if ($topics !== NULL) {
                        foreach ($topics as $topic) {
                    ?>
                        <ul class="topic-item-1 text-center">
                            <li>
                                <a href="index.php?ctrl=forum&action=findMessageByTopicId&id=<?=$topic->getId();?>"><?= $topic->getNameTopic() ?></a>
                            </li>
                            <li>De : <?= $topic->getUser()->getUserName() ?></li>
                            <li>Le : <?= $topic->getDateCreationTopic() ?></li>
                            <li>
                                <!-- UPDATE -->
                                <!-- Quand on clique on récupère idMessage et topicId pour être sûr de changer le message dans le bon topic :
							    $message->getId() ?>&topicId=< $topic->getId() ?>
							    -->
                                <a href="index.php?ctrl=forum&action=updateTopicForm&id=<?= $topic->getId() ?>&categoryId=<?= $category->getId() ?>">
                                    <i class="fa-solid fa-pencil" title="Update"></i>
                                </a>
                            </li>
                            <li>
                                <!-- DELETE -->
                                <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>&categoryId=<?= $category->getId() ?>" class=".delete-btn" onclick="return confirm('Etes-vous sûr de vouloir supprimer?');">
                                    <i class="fa-regular fa-trash-can" title="Delete"></i>
                                </a>
                            </li>
                        </ul>
                    <?php
                        }
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- We add a Topic in the category where we are -->
<?php
if(App\Session::getUser()){
    ?>
    <a class="btn btn-primary btn-add" href="index.php?ctrl=forum&action=addTopicForm&id=<?= $_GET['id'] ?>" class="btn btn-primary" role="button">
        Add Topic
    </a>
    <?php
} else { 
    ?>
    <p>Pour créer un topic veuillez vous connecter !</p>
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