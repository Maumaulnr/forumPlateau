<h1>List Categories</h1>

<?php

// return de la fonction listCategories() donc bien écrire dans le même ordre que dans la fonction
$categories = $result["data"]["categories"];

?>

<?php foreach ($categories as $value) { ?>
    <p><a href="index.php?ctrl=forum&action=findTopicByCategoryId&id=<?=$value->getId();?>"><?= $value->getNameCategory(); ?></a></p>

<?php } ?>

