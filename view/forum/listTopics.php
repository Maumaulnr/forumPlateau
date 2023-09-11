<?php

$topics = $result["data"]['topics'];
$category = $result["data"]['category'];
$user = $result["data"]['user'];

?>

<h1><?= $category->getNameCategory() ?></h1>

<h2>Listes des topics</h2>

<?php
foreach($topics as $topic){
?>
    <div class="d-flex flex-row gap-5">
        <p>
            <a href="index.php?ctrl=forum&action=findMessageByTopicId&id=<?=$topic->getId();?>"><?= $topic->getNameTopic() ?></a>
        </p>
        <p>De : <?= $user->getUserName() ?></p>
        <p>Le : <?= $topic->getDateCreationTopic() ?></p>
    </div>
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




  
