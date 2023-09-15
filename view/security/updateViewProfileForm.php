<?php
$user = $result["data"]['user'];
// var_dump();
?>

<form method="POST" action="index.php?ctrl=security&action=updateViewProfil&id=<?= $user->getId() ?>" class="container rounded bg-blue mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="https://bootdey.com/img/Content/avatar/avatar7.png">
                <!-- <span class="font-weight-bold">Edogaru</span>
                <span class="text-black-50">edogaru@mail.com.my</span> -->
                <span> </span>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <input type="hidden" class="form-control" name="idUser" value="<?= $user->getId() ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="userName" class="labels">Pseudonyme</label>
                        <input id="userName" type="text" class="form-control" name="userName" placeholder="Pseudonyme" value="<?= $user->getUserName() ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="userEmail" class="labels">Email</label>
                        <input id="userEmail" type="text" class="form-control" name="userEmail" placeholder="Email" value="<?= $user->getUserEmail() ?>">
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <button class="btn btn-primary profile-button" type="submit">Sauvegarder le profil</button>
                </div>
            </div>
        </div>
    </div>
</form>