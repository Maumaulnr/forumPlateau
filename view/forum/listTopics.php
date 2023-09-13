<?php

$topics = $result["data"]['topics'];
$category = $result["data"]['category'];
// $user = $result["data"]['user'];

?>

<h1><?= $category->getNameCategory() ?></h1>

<h2>Listes des topics</h2>

<?php
if ($topics !== NULL) {
    foreach($topics as $topic){
    ?>
        <div class="d-flex flex-row gap-5">
            <p>
                <a href="index.php?ctrl=forum&action=findMessageByTopicId&id=<?=$topic->getId();?>"><?= $topic->getNameTopic() ?></a>
            </p>
            <p>De : <?= $topic->getUser()->getUserName() ?></p>
            <p>Le : <?= $topic->getDateCreationTopic() ?></p>
            <!-- UPDATE -->
            <!-- Quand on clique on récupère idTopic et categoryId pour être sûr de changer le topic dans la bonne catégorie :
            $topic->getId() ?>&categoryId=< $category->getId() ?>
            -->
            <a href="index.php?ctrl=forum&action=updateTopicForm&id=<?= $topic->getId() ?>&categoryId=<?= $category->getId() ?>">
                <i class="fa-solid fa-pencil" title="Update"></i>
            </a>
            <!-- DELETE -->
            <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>&categoryId=<?= $category->getId() ?>">
                <i class="fa-regular fa-trash-can" title="Delete"></i>
            </a>
        </div>
    <?php
    }
}
?>

<!-- On ajoute un Topic dans le catégorie où l'on se trouve -->
<?php
if(App\Session::getUser()){
?>
<a class="btn btn-primary btn-add" href="index.php?ctrl=forum&action=addTopicForm&id=<?= $_GET['id'] ?>" class="btn btn-primary" role="button">
    Add Topic
</a>
<?php
} else { ?>
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




  
