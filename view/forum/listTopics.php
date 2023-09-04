<?php

$topics = $result["data"]['topics'];
    
?>

<h1>List Topics</h1>

<?php
foreach($topics as $topic){
?>
    <p><a href="index.php?ctrl=forum&action=findMessageByTopicId&id=<?=$topic->getId();?>"><?= $topic->getNameTopic(). " ". $topic->getDateCreationTopic()?></a></p>
<?php
}
?>

<a class="btn btn-primary btn-add" href="index.php?ctrl=forum&action=addTopicForm" role="button">
    Add Topic
</a>

<a class="btn btn-primary btn-return" href="index.php?ctrl=forum&action=listCategories" role="button">
    Return
    <span class="icon-return">
        <i class="fa-solid fa-rotate-left"></i>
    </span>
</a>




  
