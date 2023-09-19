<?php
// return de la fonction listUsers() donc bien écrire dans le même ordre que dans la fonction
$users = $result["data"]["users"];

// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];
?>

<h1>List Users</h1>

<?php
foreach ($users as $user) {
    ?>
    <p><?= $user->getUserName(). " ". $user->getUserEmail(); ?></p>

    <!-- DELETE -->
    <a href="index.php?ctrl=forum&action=deleteMessage&id=<?= $user->getId() ?>" class=".delete-btn" onclick="return confirm('Etes-vous sûr de vouloir supprimer?');">
        <i class="fa-regular fa-trash-can fs-5" title="Delete"></i>
    </a>
    <?php
}
?>