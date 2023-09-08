<?php

    namespace Controller;

    use App\DAO;
    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    

    class SecurityController extends AbstractController implements ControllerInterface {

        public function index()
        {
            $user = Session::getUser()();

            return [
                "view" => VIEW_DIR. "error404.php",
                "data" => [
                    "user" => $user
                ]
            ];
        }

        public function registerForm() {

            $user = Session::getUser();

            /**
             * App/Session::getFlash()
            */
            return [
                "view" => VIEW_DIR. "/security/registerForm.php",
                "data" => [
                    "user" => $user,
                    "successMessage" => Session::getFlash('success'),
                    "errorMessage" => Session::getFlash('error')
                ]
            ];

        }

        public function register() 
        {

            // filtrer ce qui arrive en POST
            // "userName" : vient du name="userName" du fichier register.php
            $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userEmail = filter_input(INPUT_POST, "userEmail", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_NUMBER_INT);
            // password_hash = creates a new password hash using a strong one-way hashing algorithm.
            /**
             * PASSWORD_DEFAULT - Use the bcrypt algorithm (default as of PHP 5.5.0). Note that this constant is designed to change over time as new and stronger algorithms are added to PHP. For that reason, the length of the result from using this identifier can change over time. Therefore, it is recommended to store the result in a database column that can expand beyond 60 characters (255 characters would be a good choice).
             */
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            if($userName && $userEmail && $password)
            {
                $userManager = new UserManager();

                $userManager->add(['userName' => $userName, 'userEmail' => $userEmail, 'password' => $passwordHash]);

                Session::addFlash('success', 'Vous êtes bien enregistré !');

                $this->redirectTo('security', 'listUsers');

            } else {

                Session::addFlash('error', 'Une erreur est survenue, veuillez réessayer');

                return $this->registerForm();

            }

            
        }

    }