<?php

$messages = $result["data"]['messages'];
    
?>

<h1>List Messages</h1>

<?php
foreach($messages as $message){
?>
    <p><?= $message->getCommentText()?></p>
<?php
}
?>

<a class="btn btn-primary btn-return" href="index.php?ctrl=forum&action=listTopics" role="button">
    Return
    <span class="icon-return">
        <i class="fa-solid fa-rotate-left"></i>
    </span>
</a>