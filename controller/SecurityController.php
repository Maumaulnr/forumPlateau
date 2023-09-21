<?php

    namespace Controller;

    use App\DAO;
    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\MessageManager;
    use Model\Managers\TopicManager;
    use Model\Entities\Category;
    use Model\Managers\UserManager;
    

    class SecurityController extends AbstractController implements ControllerInterface {

        public function index()
        {

            // Gérez le cas où l'utilisateur n'a pas été trouvé (par exemple, affichez un message d'erreur)
            return [
                "view" => VIEW_DIR . "security/error404.php"
            ];

        }

        /**
         * Liste des utilisateurs
         */
        public function listUsers() {
            
            $userManager = new UserManager();

            // findAll(['dateCreationUser', 'DESC']) -> on peut cibler ce que l'on veut afficher
            $users = $userManager->findAll();

            return [
                "view" =>  VIEW_DIR."security/listUsers.php",
                "data" => [
                    "users" => $users,
                    "title" => "Liste des utilisateurs",
                    "description" => "Liste des utilisateurs du forum"
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
        public function registerForm() 
        {

            /**
             * App/Session::getFlash()
            */
            return [
                "view" => VIEW_DIR. "security/registerForm.php",
                "data" => [
                    "successMessage" => Session::getFlash('success'),
                    "errorMessage" => Session::getFlash('error'),
                    "title" => "S'enregistrer",
                    "description" => "Page d'enregistrement pour pouvoir participer au forum"
                ]
            ];

        }

        public function register() 
        {

            // filtrer ce qui arrive en POST
            // "userName" : vient du name="userName" du fichier register.php
            $honeypot = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userEmail = filter_input(INPUT_POST, "userEmail", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            // password_hash = creates a new password hash using a strong one-way hashing algorithm.
            /**
             * PASSWORD_DEFAULT - Use the bcrypt algorithm (default as of PHP 5.5.0). Note that this constant is designed to change over time as new and stronger algorithms are added to PHP. For that reason, the length of the result from using this identifier can change over time. Therefore, it is recommended to store the result in a database column that can expand beyond 60 characters (255 characters would be a good choice).
             */

            
            if (empty($honeypot)) 
            {
                /**
                 * si le honeypot est vide on passe à la suite sinon on le redirige vers une page d'erreur
                 */

                if($userName && $userEmail && $password && $confirmPassword)
                {

                    $userManager = new UserManager();

                    // on doit d'abord rechercher si le userEmail existe en BDD
                    if(!$userManager->findOneByEmail($userEmail)) 
                    {
                        // si c'est false on poursuit

                        // si le password correspond au confirmPassword et que la longueur de la chaîne de caractère du password est supérieur ou égale à 12
                        if(($password == $confirmPassword)and(strlen($password)>=12)) 
                        {

                            // On va hasher le password et enregistrer le user en BDD
                            // un password est hashé en BDD. Le hashage est un mécanisme unidirectionnel et irréversible. ON NE DEHASHE JAMAIS UN PASSWORD!!!

                            // la fonction password_hash va nous demander l'algorithme de hash choisi. Les algos a priviligié sont BCRYPT et ARGON2i.
                            // Ne pas utiliser sha ou md5
                            // DCRYPT et ARGON2i font parti des algos de hash fort
                            // sha ou md5 font parti des algos de hash faible

                            $password_hash = password_hash($password, PASSWORD_DEFAULT);
                            // password_default utilise par défault l'algo BCRYPT
                            // BCRYPT est un algo fort comme ARGON2i
                            // il va créé une empreinte numérique en BDD composé de l'algo utilisé, d'un cost, d'un salt et du password hashé
                            // le salt est une chaîne de caractère aléatoire hashée qui sera concaténé à notre password hashé.
                            // si un pirate récupère notre password hashé il aura plus de difficulté à découvrir notre MDP d'origine

                            // $password_hash2 = md5($password);
                            

                            $userManager->add(['userName' => $userName, 'userEmail' => $userEmail, 'password' => $password_hash, "userRole" => json_encode(['ROLE_USER'])]);

                        } else {

                            Session::addFlash('error', 'Les mots de passe ne sont pas identiques ou pas assez long');
                        }

                    } else {

                        Session::addFlash('error', 'Email déjà utilisé !');
                    }

                } else {

                    /**
                     * Erreur pour le honeypot
                     */
                    Session::addFlash('error', 'Dommage!');

                    $this->redirectTo('security', 'error404');    

                }

            }

            $this->redirectTo("forum", "listCategories");
        }


        /**
         * LOGIN FORM
         */

        public function loginForm() 
        {


            /**
             * App/Session::getFlash()
            */
            return [
                "view" => VIEW_DIR. "security/loginForm.php",
                "data" => [
                    "successMessage" => Session::getFlash('success'),
                    "errorMessage" => Session::getFlash('error'),
                    "title" => "Connexion",
                    "description" => "Page de connexion pour participer au forum"
                ]
            ];

        }

        /**
         * LOGIN 
         */

        public function login()
        {

            // je filtre les données envoyées dans le formulaire
            $honeypot = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($honeypot)) 
            {
                /**
                 * si le honeypot est vide on passe à la suite sinon on le redirige vers une page d'erreur
                 */

                // on va d'abord vérifié si le filtrage s'est bien passé
                if($userName && $password) {
                    
                    // on va instancier le UserManager pour vérifier que j'ai bien un user à ce nom là
                    $userManager = new UserManager();

                    $user = $userManager->findOneByPseudo($userName);

                    if($user) {

                        $userId = $user->getPassword();
                        // si un user existe avec ce pseudo on continue
                        // on va vérfier que le password donné dans le formulaire de login correspond au password de l'utilisateur qui pseudo
                        
                        if(password_verify($password, $userId)) {
                            
                            // PASSWORD_VERIFY VA COMPARER DEUX CHAINES DE CARACTERES HASHE!

                            if($user->getBanUser() == 0) {
                                // si ça fonctionne on met le user en session
                                Session::setUser($user);

                                $this->redirectTo('forum', 'listCategories');
                                
                            } else {

                                Session::addFlash('error','personne ne t aime tu es banni!!!');

                                $this->redirectTo('view', 'layout');

                            }
                                    
                        }

                    } else {

                        Session::addFlash('error','Le pseudo n\'est pas bon');

                        $this->redirectTo('view', 'loginForm');

                    }

                } else {

                    Session::addFlash('error','Il y a une erreur, veuillez recommencer');
                }
            
            } else {

                Session::addFlash('error', 'Dommage!');

                $this->redirectTo('security', 'error404');
                
            }

        }

        /**
         * LOG OUT
         */

        public function logout() {

            unset($_SESSION['user']);

            Session::addFlash('success', 'Vous êtes déconnecté, à bientôt !');

            $this->redirectTo('view', 'home');
        }

        /*********
         * 
         * 
         * VIEW PROFILE
         * 
         * 
         ***********/

        public function viewProfile($id) 
        {
            
            // On veut afficher les informations de l'utilisateur connecté 

            $userManager = new UserManager();

            // On veut trouver le profil d'un utilisateur en fonction de son Id
            $user = $userManager->findOneById($id);
            
            return [
                "view" => VIEW_DIR . "security/viewProfile.php",
                "data" => [
                    "user" => $user,
                    "title" => "Voir son profil",
                    "description" => "Voir son profil"
                ]
            ];

        }

        /*********
         * 
         * 
         * UPDATE PROFILE
         * 
         * 
         ***********/
        public function updateViewProfileForm($id) 
        {
            
            $userManager = new UserManager();

            $user = $userManager->findOneById($id);
            
            return [
                "view" => VIEW_DIR. "security/updateViewProfileForm.php",
                "data" => [
                    "user" => $user,
                    "title" => "Modifier son profil",
                    "description" => "Modifier son profil"
                ]
            ];

        }

        public function updateViewProfile($id) 
        {

            $userManager = new UserManager();

            // filtrer ce qui arrive en POST
            // "userName" : vient du name="userName" du fichier updateViewProfileForm.php
            $id = filter_input(INPUT_POST, "idUser", FILTER_SANITIZE_NUMBER_INT);
            $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userEmail = filter_input(INPUT_POST, "userEmail", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /** 
             * id = :id de la requête
             * newUserName = :newUserName
             * donc bien écrire pareil dans la fonction update ici.
            */
            $userManager->update(["id" => $id, "newUserName" => $userName, "newUserEmail" => $userEmail]);

            // on retourne vers le profil de l'utilisateur grâce à son Id
            $this->redirectTo('security', 'viewProfile', $id);

        }

        /*********
         * 
         * 
         * UPDATE PASSWORD
         * 
         * 
         ***********/

        public function updatePasswordForm($id) 
        {
            
            $userManager = new UserManager();

            $user = $userManager->findOneById($id);

            return [
                "view" => VIEW_DIR. "security/updatePasswordForm.php",
                "data" => [
                    "user" => $user,
                    "title" => "Modifier le mot de passe",
                    "description" => "Modifier son mot de passe"
                ]
            ];

        }

        public function updatePassword($id) 
        {
            
            // filtrer ce qui arrive en POST
            // "userName" : vient du name="userName" du fichier register.php
            $honeypot = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $currentPassword = filter_input(INPUT_POST, "currentPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            // password_hash = creates a new password hash using a strong one-way hashing algorithm.
            /**
             * PASSWORD_DEFAULT - Use the bcrypt algorithm (default as of PHP 5.5.0). Note that this constant is designed to change over time as new and stronger algorithms are added to PHP. For that reason, the length of the result from using this identifier can change over time. Therefore, it is recommended to store the result in a database column that can expand beyond 60 characters (255 characters would be a good choice).
             */

            
            if (empty($honeypot)) 
            {
                
                /**
                 * si le honeypot est vide on passe à la suite sinon on le redirige vers une page d'erreur
                 **/


                if($currentPassword && $password && $confirmPassword)
                {
                    
                    $userManager = new UserManager();

                    $user = Session::getUser();

                    if($user) {
                        
                        $userId = $user->getPassword();
                        // on va vérfier que le password donné dans le formulaire du updatePassword correspond au password de l'utilisateur qui a ce pseudo

                        if (!password_verify($password, $userId)) {
                            
                            // PASSWORD_VERIFY VA COMPARER DEUX CHAINES DE CARACTERES HASHE!

                            // si le password correspond au confirmPassword et que la longueur de la chaîne de caractère du password est supérieur ou égale à 12 et si le mot de passe vérifier n'est pas le même que le mot de passe actuel
                            if(($password == $confirmPassword)and(strlen($password)>=12)) 
                            {
                                
                                // On va hasher le password et enregistrer le user en BDD
                                // un password est hashé en BDD. Le hashage est un mécanisme unidirectionnel et irréversible. ON NE DEHASHE JAMAIS UN PASSWORD!!!

                                // la fonction password_hash va nous demander l'algorithme de hash choisi. Les algos a priviligié sont BCRYPT et ARGON2i.
                                // Ne pas utiliser sha ou md5
                                // DCRYPT et ARGON2i font parti des algos de hash fort
                                // sha ou md5 font parti des algos de hash faible

                                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                                // password_default utilise par défault l'algo BCRYPT
                                // BCRYPT est un algo fort comme ARGON2i
                                // il va créé une empreinte numérique en BDD composé de l'algo utilisé, d'un cost, d'un salt et du password hashé
                                // le salt est une chaîne de caractère aléatoire hashée qui sera concaténé à notre password hashé.
                                // si un pirate récupère notre password hashé il aura plus de difficulté à découvrir notre MDP d'origine

                                // $password_hash2 = md5($password);

                                $userManager->updatePassword(['id' => $id, 'newPassword' => $password_hash]);

                                $this->redirectTo('view', 'home');

                            } else {

                                Session::addFlash('error', 'Les mots de passe ne sont pas identiques ou pas assez long');

                            }

                        } else {

                            Session::addFlash('error','personne ne t aime tu es banni!!!');
                
                            $this->redirectTo('view', 'layout');
                
                        }

                    } else {

                        $this->redirectTo('view', 'home');

                    }

                }

            } else {

                /**
                 * Erreur pour le honeypot
                 */
                Session::addFlash('error', 'Dommage!');

                $this->redirectTo('security', 'error404');
                
            }

        }



        /**
         * DELETE USER
         */
        public function deleteUser($id) {
            
            $messageManager = new MessageManager();
            $topicManager = new TopicManager();
            $userManager = new UserManager();

            $user = $userManager->findOneById($id);

            if ($user) {

                $messageManager->delete($id);
                $topicManager->delete($id);
                $userManager->delete($id);

            }

            $this->redirectTo('security', 'listUsers');

        }
        
        /**
         * BAN USER
         * 
         * Cette méthode prend l'identifiant d'un utilisateur en paramètre, tente de le bannir en utilisant la méthode isBan($id) de UserManager, et redirige ensuite l'utilisateur vers la page d'accueil avec un message de succès ou d'erreur en fonction du résultat de l'opération de bannissement.
         * 
         **/
        public function isBan($id) {

            $userManager = new UserManager();

            if ($id) {

                $userManager->isBan($id);

                Session::addFlash('success', 'L\'utilisateur a bien été banni du forum');

                $this->redirectTo('view', 'layout');

            } else {

                Session::addFlash('error', 'L\'utilisateur n\'a pas pu être banni du forum');

                $this->redirectTo('view', 'layout');

            }
        }

        /**
         * 
         * cette méthode prend l'identifiant d'un utilisateur en paramètre, tente de l'admettre en utilisant la méthode isUnBan($id) de UserManager, et redirige ensuite l'utilisateur vers la page d'accueil avec un message de succès ou d'erreur en fonction du résultat de l'opération d'admission.
         * 
         **/
        public function isUnBan($id) {

            $userManager = new UserManager();

            if ($id) {

                $userManager->isUnBan($id);

                Session::addFlash('success', 'L\'utilisateur est de nouveau admis dans le forum');

                $this->redirectTo('view', 'layout');

            } else {

                Session::addFlash('error', 'L\'utilisateur n\'a pas pu être admis suite à une erreur');

                $this->redirectTo('view', 'layout');

            }

        }

    }
