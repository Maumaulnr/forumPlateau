<?php
var_dump($_GET);
?>

<h2>Add Topic</h2>

<?php
    // On regarde si $isAddCategorySuccess est setté ainsi que $globalMessage et on vérifie qu'elle est initialisé
    if (isset($isAddTopicSuccess) && isset($globalMessage) && $globalMessage) {
    ?>   
        <!-- id pour animation JS et la class pour personnaliser affichage du message -->
        <p id="global-message" class="<?= $isAddTopicSuccess ? "text-success" : "text-error" ?>"><?= $globalMessage ?></p>
    <?php
    }
?>

<div class="column">

    <!-- addTopicByCategoryId -->
    <form action="index.php?ctrl=forum&action=addTopic" method="post" id="addTopicForm">

        <label for="nameTopic">Name Topic</label>
        <input type="text" name="nameTopic" id="nameTopic" placeholder="Name Topic" maxlength="100" />

        <!-- Ici je veux que la catégorie sois déjà rempli car on a déjà cliqué sur la catégorie donc grâce à l'ID, on sait où l'on se trouve -->
        <label for="categoryId"></label>
        <input type="text" id="categoryId" name="categoryId" value="<?= $id = $_GET['id'] ?>">

        <label for="commentText">Message</label>
        <textarea name="commentText" id="commentText" cols="30" rows="10"></textarea>

        <?php
        // Si rien n'est écrit dans le champ alors un message renvoit "Le formulaire est invalide" et "Ce champs est obligatoire"
        if (isset($errorMessage) && isset($errorMessage["nameTopic"]) && $errorMessage["nameTopic"] && isset($errorMessage["commentText"]) && $errorMessage["commentText"]) {
        ?>   
        <!-- Texte d'erreur à mettre en rouge -->
        <p class="text-error"><?= $errorMessage["nameTopic"] ?></p>
        <p class="text-error"><?= $errorMessage["commentText"] ?></p>
        <?php
        }
        ?>

        <button class="btn btn-primary" type="submit">Submit</button>

    </form>

    <a class="btn btn-primary btn-return" href="index.php?ctrl=forum&action=listCategories" role="button">
    Return
    <span class="icon-return">
        <i class="fa-solid fa-rotate-left"></i>
    </span>
    </a>

</div>