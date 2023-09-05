<h1>Add Category</h1>

<?php
    // On regarde si $isAddCategorySuccess est setté ainsi que $globalMessage et on vérifie qu'elle est initialisé
    if (isset($isAddCategorySuccess) && isset($globalMessage) && $globalMessage) {
    ?>   
        <!-- id pour animation JS et la class pour personnaliser affichage du message -->
        <p id="global-message" class="<?= $isAddCategorySuccess ? "text-success" : "text-error" ?>"><?= $globalMessage ?></p>
    <?php
    }
?>

<div class="column">

    <form action="index.php?ctrl=forum&action=addCategory" method="post">

        <label for="nameCategory">Name Category</label>
        <input type="text" name="nameCategory" id="nameCategory" placeholder="Name Category" maxlength="100" />

        <?php
        // Si rien n'est écrit dans le champ alors un message renvoit "Le formulaire est invalide" et "Ce champs est obligatoire"
        if (isset($errorMessage) && isset($errorMessage["nameCategory"]) && $errorMessage["nameCategory"]) {
        ?>   
        <!-- Texte d'erreur à mettre en rouge -->
        <p class="text-error"><?= $errorMessage["nameCategory"] ?></p>
        <?php
        }
        ?>

        <button class="btn btn-primary" type="submit">Submit</button>

    </form>

</div>
