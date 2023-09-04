<h1>List Users</h1>

<?php

// return de la fonction listUsers() donc bien écrire dans le même ordre que dans la fonction
$users = $result["data"]["users"];
?>

<?php
foreach ($users as $user) {
    ?>
    <p><?= $user->getUserName(). " ". $user->getUserEmail(); ?></p>
    <?php
}
?>