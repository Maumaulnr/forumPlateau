<?php
$categories = $result["data"]['categories'];
?>

<h1>Add Topic</h1>

<div class="column">

    <!-- addTopicByCategoryId -->
    <form action="index.php?ctrl=forum&action=addTopic" method="post">

        <label for="nameCategory">Name Topic</label>
        <input type="text" name="nameTopic" id="nameTopic" placeholder="Name Topic" maxlength="100" />

        <label for="commentText">Message</label>
        <textarea name="commentText" id="commentText" cols="30" rows="10"></textarea>

        <!-- Ici je veux que la catégorie sois déjà rempli car on a déjà cliqué sur la catégorie donc grâce à l'ID, on sait où l'on se trouve -->
        <label for="nameCategory">Catégorie</label>
        <select name="nameCategory" id="selectCategory">
            <?php
            foreach ($categories as $value) {
            ?>
            <option value="<?= $value->getId() ?>"><?= $value->getNameCategory() ?></option>
            <?php
            }
            ?>
        </select>

        <button class="btn btn-primary" type="submit">Submit</button>

    </form>

    <a class="btn btn-primary btn-return" href="index.php?ctrl=forum&action=listCategories" role="button">
    Return
    <span class="icon-return">
        <i class="fa-solid fa-rotate-left"></i>
    </span>
    </a>

</div>