<?php
$category = $result["data"]['category'];
// var_dump($category);
?>


<div class="d-flex flex-column justify-content-center gap-5">

    <h2>Add Topic</h2>

    <!-- addTopicByCategoryId -->
    <form action="index.php?ctrl=forum&action=addTopic" method="post" id="addTopicForm" class="d-flex flex-column gap-2 text-center">

        <label for="nameTopic">Name Topic</label>
        <input type="text" name="nameTopic" id="nameTopic" class="text-center" placeholder="Name Topic" maxlength="100" />

        <input type="text" id="userId" name="userId" value="1" placeholder="userId">

        <!-- Ici je veux que la catégorie sois déjà rempli car on a déjà cliqué sur la catégorie donc grâce à l'ID, on sait où l'on se trouve -->
        <input type="text" id="categoryId" name="categoryId" value="<?= $category->getId() ?>" placeholder="categoryId">

        <!-- <label for="topicId"></label>
        <input type="text" id="topicId" name="topicId" value="" placeholder="topicId"> -->

        <label for="commentText">Message</label>
        <textarea name="commentText" id="commentText" class="text-center" cols="60" rows="10"></textarea>

        <button class="btn btn-primary" type="submit">Submit</button>

    </form>

    <a class="btn btn-primary btn-return" href="index.php?ctrl=forum&action=listCategories" role="button">
    Return
    <span class="icon-return">
        <i class="fa-solid fa-rotate-left"></i>
    </span>
    </a>

</div>
