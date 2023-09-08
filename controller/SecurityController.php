<?php

    namespace Controller;

    use App\DAO;
    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Entities\User;
    use Model\Managers\UserManager;
    

    class SecurityController extends AbstractController implements ControllerInterface {

        public function index()
        {
            
        }

        public function registerForm() {

            /**
             * App/Session::getFlash()
            */
            return [
                "view" => VIEW_DIR. "security/registerForm.php",
                "data" => [
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
            $password = password_hash($password, PASSWORD_DEFAULT);
            $banUser = filter_input(INPUT_POST, "banUser", FILTER_SANITIZE_NUMBER_INT);

            if($userName && $userEmail && $password && $banUser)
            {
                $userManager = new UserManager();

                $userManager->add(["userName" => $userName, "userEmail" => $userEmail, "password" => $password, "banUser" => 0]);

                Session::addFlash('success', 'Vous êtes bien enregistré !');

                $this->redirectTo('security', 'listUsers');

            } else {

                return $this->registerForm();

            }

            
        }

    }