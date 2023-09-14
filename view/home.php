<?php

// var_dump($_SESSION['user']);
?>

<h1>BIENVENUE SUR LE FORUM</h1>

<div class="container d-flex flex-column justify-content-center align-items-center gap-5">
    
    <a href="index.php?ctrl=forum&action=listCategories" class="btn btn-primary">List Categories</a>


    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

    <p>
        <a class="btn btn-primary" href="index.php?ctrl=security&action=loginForm">Se connecter</a>
        <span>&nbsp;-&nbsp;</span>
        <a class="btn btn-primary" href="index.php?ctrl=security&action=registerForm">S'enregistrer</a>
    </p>

</div>