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

    <?php 
    if (App\Session::isAdmin()) { 
        ?>
        <!-- DELETE -->
        <a href="index.php?ctrl=security&action=deleteUser&id=<?= $user->getId() ?>" class=".delete-btn" onclick="return confirm('Etes-vous sûr de vouloir supprimer?');">
            <i class="fa-regular fa-trash-can fs-5" title="Delete"></i>
        </a>
        <!-- BAN OR UNBAN -->
        <?php 
        if ($user->getBanUser() == 0) { 
            ?>
            <a href="index.php?ctrl=security&action=isBan&id=<?= $user->getId() ?>" class=".ban-btn">
                <i class="fa-solid fa-ban fs-5" title="Bannir"></i>
            </a>
            <?php 
        } else { 
            ?>
            <a href="index.php?ctrl=security&action=isUnBan&id=<?= $user->getId() ?>" class=".ban-btn">
                <i class="fa-solid fa-unlock fs-5" title="Débannir"></i>
            </a>
            <?php 
        } 
    } else {
        ?>
        <p>Il faut être administrateur pour supprimer un utilisateur ou gérer le bannissement.</p>
        <?php
    }
}
?>

<?php
// echo hash('sha1', $user->getUserName());
echo uniqid($user->getId());
?>