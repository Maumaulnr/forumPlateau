<?php
$user = $result["data"]['user'];
// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];
?>

<link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    
<h1>Mise à jour du mot de passe</h1>

<form action="index.php?ctrl=security&action=updatePassword&id=<?= $user->getId() ?>" method="post">

    <!-- Create fields for the honeypot -->
    <input name="firstname" type="text" id="firstname" class="myBlank">
    <!-- honeypot fields end -->

    <div>
        <label for="currentPassword">Mot de passe actuel:</label>
        <input type="password" name="currentPassword" id="currentPassword" required=true>
    </div>
    <div>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" required=true>
    </div>
    <div>
        <label for="passwordAgain">Password Again:</label>
        <input type="password" name="confirmPassword" id="passwordAgain">
    </div>

    <button type="submit">Enregistrer</button>
    
    <!-- <footer class="d-flex flex-column justify-content-center gap-2">
        <p>Déjà membre ? </p>
        <p>
            <a href="index.php?ctrl=security&action=loginForm">Se connecter ici</a>
        </p>
    </footer> -->

</form>