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

        /**
         *  La méthode Session::getUser() est utilisée pour obtenir les informations de l'utilisateur connecté.
         * La variable $user contiendra les données de l'utilisateur si un utilisateur est connecté, sinon elle sera null.
         * Les méthodes Session::getFlash('success') et Session::getFlash('error') sont utilisées pour récupérer ces messages depuis la session.
         * La fonction retourne un tableau associatif contenant deux éléments :
                * "view" : Il s'agit du chemin vers le fichier de vue qui sera affiché pour le formulaire d'inscription. Ce chemin est généralement utilisé pour inclure la vue dans la page web.
                * "data" : Il s'agit d'un tableau associatif qui contient des données à transmettre à la vue. Dans ce cas, il contient les données de l'utilisateur, le message de succès et le message d'erreur.
            * Cette fonction prépare les données nécessaires à l'affichage du formulaire d'inscription en récupérant l'utilisateur connecté, les messages flash de succès et d'erreur, puis les renvoie sous forme de tableau pour être utilisés lors de l'affichage de la vue.
         **/
        public function registerForm() {

            $user = Session::getUser();

            /**
             * App/Session::getFlash()
            */
            return [
                "view" => VIEW_DIR. "security/registerForm.php",
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
            $userEmail = filter_input(INPUT_POST, "userEmail", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

        /**
         * LOGIN
         */

        public function loginForm() 
        {

            $user = Session::getUser();

            /**
             * App/Session::getFlash()
            */
            return [
                "view" => VIEW_DIR. "security/loginForm.php",
                "data" => [
                    "user" => $user,
                    "successMessage" => Session::getFlash('success'),
                    "errorMessage" => Session::getFlash('error')
                ]
            ];

        }

        /**
         * 
         */

        public function login()
        {
            $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            if ($userName && $password) {

                $userManager = new UserManager();

                
            }
        }

    }