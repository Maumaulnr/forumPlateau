<link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    
<h1>Connexion</h1>

<form action="index.php?ctrl=security&action=login" method="post">

    <!-- Create fields for the honeypot -->
    <input name="firstname" type="text" id="firstname" class="myBlank">
    <!-- honeypot fields end -->

    <div>
        <label for="userName">Pseudonyme:</label>
        <input type="text" name="userName" id="userName" required=true>
    </div>
    <div>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" required=true>
    </div>
    <button type="submit">Connexion</button>
    <footer class="d-flex flex-column justify-content-center gap-2">
        <p>Pas encore inscrit ? </p>
        <p>
            <a href="index.php?ctrl=security&action=loginForm">S'inscrire ici</a>
        </p>
    </footer>

</form>