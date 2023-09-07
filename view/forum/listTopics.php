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

<?php 
$go_back = htmlspecialchars($_SERVER['HTTP_REFERER']);
?>
<a href='<?= $go_back ?>'>Go Back</a>;




  
