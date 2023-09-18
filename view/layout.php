<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="title" content="<?= $title ?>">
    <meta name="description" content="<?= $description ?>">
    <meta name="keywords" content="métiers, conseils, partage, découverte">

    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"> -->

    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">

    <title><?= $title ?></title>

</head>

<body>
    <div id="container-fluid">
        
        <div id="mainpage">
            <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
            <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
            <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
            <header class="container-fluid">
                <img class="img-fluid" src="<?= PUBLIC_DIR ?>/image/metiers.png" alt="Bannière des métiers : personnages représentant divers métiers avec le sourire" width="1600" height="547">
                <nav class="navbar" id="myNavbar">
                    <div class="navbar-nav" id="nav-left">
                        <ul class="nav-menu">
                            <a href="index.php?ctrl=home&action" class="nav-title">Home</a>
                            <a href="index.php?ctrl=forum&action=listCategories" class="nav-title">List Categories</a>
                            <a href="index.php?ctrl=security&action=loginForm" class="nav-title" rel="nofollow">Log In</a>
                            <a href="index.php?ctrl=security&action=registerForm" class="nav-title" rel="nofollow">Sign Up</a>
                            <?php
                            if (App\Session::isAdmin()) {
                            ?>
                                <a href="index.php?ctrl=home&action=users" class="nav-title">List members</a>
                                <a href="index.php?ctrl=home&action=listUsers" class="btn btn-primary" rel="nofollow">List Users</a>
                            <?php
                            }
                            ?>
                        </ul>
                        <div class="hamburger">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                    </div>
                    <div id="nav-right">
                        <?php
                        if (App\Session::getUser()) {
                        ?>
                            <div class="dropdown">
                                <a class="nav-link btn-lg dropdown-toggle" href="#" id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="user-icon" data-username="<?= App\Session::getUser()->getUserName() ?>">
                                        <span class="fas fa-user"></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li>
                                        <a class="dropdown-item text-light" href="index.php?ctrl=security&action=viewProfile&id=<?= App\Session::getUser()->getId() ?>">View Profile</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-light" href="index.php?ctrl=security&action=logout">Log Out</a>
                                    </li>
                                </ul>
                            </div>
                        <?php
                        } else {
                        ?>
                            <a href="index.php?ctrl=home&action">Home</a>
                        <?php
                        }
                        ?>
                    </div>
                    
                </nav>
            </header>

            <main id="forum">
                <?= $page ?>
            </main>

        </div>

        <footer class="container d-flex flex-column align-items-center p-3 text-center gap-3 rounded">
            <div class="d-flex flex-wrap justify-content-center border border-black col-6">
                <a href="#" id="link-social-icon" class="text-decoration-none">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="#" id="link-social-icon" class="text-decoration-none">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" id="link-social-icon" class="text-decoration-none">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
            </div>
                        
            <p class="bg-white rounded p-1">&copy; 2023 - Forum CDA - <a href="/home/forumRules.html">Forum Rules</a> - <a href="">Terms & Conditions</a> - <a href="#">Plan du site</a></p>
            <!--<button id="ajaxbtn">Surprise en Ajax !</button> -> cliqué <span id="nbajax">0</span> fois-->

        </footer>

    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $(".message").each(function() {
                if ($(this).text().length > 0) {
                    $(this).slideDown(500, function() {
                        $(this).delay(3000).slideUp(500)
                    })
                }
            })
            $(".delete-btn").on("click", function() {
                return confirm("Etes-vous sûr de vouloir supprimer?")
            })
            tinymce.init({
                selector: '.post',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css'
            });
        })


        /*
        $("#ajaxbtn").on("click", function(){
            $.get(
                "index.php?action=ajax",
                {
                    nb : $("#nbajax").text()
                },
                function(result){
                    $("#nbajax").html(result)
                }
            )
        })*/
    </script>
    <script src="<?= PUBLIC_DIR ?>/js/burgerMenu.js"></script>
</body>

</html>