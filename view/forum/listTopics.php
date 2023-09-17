<?php

$topics = $result["data"]['topics'];
$category = $result["data"]['category'];

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
            <!-- When we click, we get idTopic and categoryId to make sure we change the topic to the right category:
            $topic->getId() ?>&categoryId=< $category->getId() ?>
            -->
            <a href="index.php?ctrl=forum&action=updateTopicForm&id=<?= $topic->getId() ?>&categoryId=<?= $category->getId() ?>">
                <i class="fa-solid fa-pencil" title="Update"></i>
            </a>

            <!-- LOCK THE TOPIC -->
            <?php if(App\Session::isAdmin()) { 
                ?>
                <input type="hidden" name="sujet_id" value="1"> <!-- Remplacez 1 par l'ID du sujet -->
                <input type="submit" name="verrouiller" value="Verrouiller le sujet">
                <?php 
            } 
            ?>

            <!-- DELETE -->
            <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>&categoryId=<?= $category->getId() ?>" class=".delete-btn" onclick="return confirm('Etes-vous sûr de vouloir supprimer?');">
                <i class="fa-regular fa-trash-can" title="Delete"></i>
            </a>
        </div>
    <?php
    }
}
?>

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




  
