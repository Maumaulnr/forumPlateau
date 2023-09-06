<?php
$topic = $result["data"]['topic'];
$messages = $result["data"]['messages'];

// var_dump();
?>

<h1>List Messages</h1>

<div>


    <h2><?= $topic->getNameTopic() ?></h2>


    <?php
    if ($messages !== NULL) {
        foreach ($messages as $message) {
        ?>
            <p><?= $message->getCommentText()?></p>
        <?php
        }
    }
    ?>

    <a class="btn btn-primary btn-add" href="index.php?ctrl=forum&action=addMessageForm&id=<?= $topic->getId(); ?>" role="button">
        Add Message
    </a>

    <a class="btn btn-primary btn-return" href="index.php?ctrl=forum&action=findTopicByCategoryId&id=<?= $id = $_GET['id'] ?>" role="button">
        Return
        <span class="icon-return">
            <i class="fa-solid fa-rotate-left"></i>
        </span>
    </a>

</div>