<link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    
<h1>Inscription</h1>

<form action="index.php?ctrl=security&action=register" method="post">

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
    <!-- <div>
        <label for="password2">Password Again:</label>
        <input type="password" name="password2" id="password2">
    </div> -->
    <!-- <div>
        <label for="agree">
            <input type="checkbox" name="agree" id="agree" value="yes"/> I agree
            with the
            <a href="#" title="term of services">term of services</a>
        </label>
    </div> -->
    <button type="submit">Enregistrer</button>
    <footer>
        <p>Déjà membre?</p>
        <a href="login.php">Se connecter ici</a>
    </footer>

</form>