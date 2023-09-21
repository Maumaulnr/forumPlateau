<?php
$user = $result["data"]['user'];

// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];
?>

<?php 
if ($user !== false) { 
    ?>

    <div class="container">
        <div class="main-body">

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <a href="index.php?ctrl=security&action=uploadPicture&id=<?= App\Session::getUser()->getId() ?>" aria-label="Changer votre avatar">
                                    <img src="<?= PUBLIC_DIR ?>/image/<?= App\Session::getUser()->getPictureProfile() ?>" alt="Image personnalisée d'un utilisateur" class="rounded-circle" width="150">
                                </a>
                                <div class="mt-3">
                                    <h4><?= $user->getUserName() ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Pseudonyme</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <p><?= $user->getUserName() ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <p><?= $user->getUserEmail() ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Date d'inscription</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <p><?= $user->getDateCreationCount() ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Rôle dans ce forum</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php if(App\Session::getUser()->hasRole("ROLE_ADMIN")) { ?>
                                        <p>Administrateur</p>
                                    <?php } else { ?>
                                        <p>Visiteur</p>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Mot de passe</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <a class="btn btn-info " target="__blank" href="index.php?ctrl=security&action=updatePasswordForm&id=<?= $_GET['id'] ?>" title="Modifier le mot de passe">Mot de passe</a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn btn-info " target="__blank" href="index.php?ctrl=security&action=updateViewProfileForm&id=<?= $_GET['id'] ?>">Modifier</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php 
} else {
    ?>
    <p>L'utilisateur ne possède pas d'informations</p>
    <?php
    }
?>