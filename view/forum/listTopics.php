<?php

$topics = $result["data"]['topics'];
$category = $result["data"]['category'];
    
?>

<h1><?= $category->getNameCategory() ?></h1>

<h2>List Topics</h2>

<?php
foreach($topics as $topic){
?>
    <p><a href="index.php?ctrl=forum&action=findMessageByTopicId&id=<?=$topic->getId();?>"><?= $topic->getNameTopic(). " ". $topic->getDateCreationTopic()?></a></p>
<?php
}
?>

<a class="btn btn-primary btn-return" href="index.php?ctrl=forum&action=listCategories" role="button">
    Return
    <span class="icon-return">
        <i class="fa-solid fa-rotate-left"></i>
    </span>
</a>




  
