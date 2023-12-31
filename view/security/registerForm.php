<?php
// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];
?>

<link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    
<h1>Inscription</h1>

<form action="index.php?ctrl=security&action=register" method="post">

    <!-- Create fields for the honeypot -->
    <input name="firstname" type="text" id="firstname" class="myBlank">
    <!-- honeypot fields end -->

    <div>
        <label for="userName">Pseudonyme:</label>
        <input type="text" name="userName" id="userName" required=true>
    </div>
    <div>
        <label for="userEmail">Email:</label>
        <input type="email" name="userEmail" id="userEmail" required=true>
    </div>
    <div>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" required=true>
    </div>
    <div>
        <label for="password2">Password Again:</label>
        <input type="password" name="confirmPassword" id="password2">
    </div>


    <div>
        <label for="agree">
            <input type="checkbox" name="agree" id="agree" value="yes"/> I agree
            with the
            <a href="#" title="term of services">term of services</a>
        </label>
    </div>
    <button type="submit">Enregistrer</button>
    
    <footer class="d-flex flex-column justify-content-center gap-2">
        <p>Déjà membre ? </p>
        <p>
            <a href="index.php?ctrl=security&action=loginForm">Se connecter ici</a>
        </p>
    </footer>

</form>