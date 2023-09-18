<?php
// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];
?>

<h1>Add Category</h1>

<div class="column">

    <form action="index.php?ctrl=forum&action=addCategory" method="post">

        <label for="nameCategory">Name Category</label>
        <input type="text" name="nameCategory" id="nameCategory" placeholder="Name Category" maxlength="100" />

        <button class="btn btn-primary" type="submit">Submit</button>

    </form>

</div>
