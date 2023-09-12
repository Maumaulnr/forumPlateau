<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\CategoryManager;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\MessageManager;
    
    class HomeController extends AbstractController implements ControllerInterface{

        public function index(){
            
           
                return [
                    "view" => VIEW_DIR."home.php"
                ];
            }
            
        public function listUsers() {
            
            $userManager = new UserManager();

            // findAll(['dateCreationUser', 'DESC']) -> on peut cibler ce que l'on veut afficher
            $users = $userManager->findAll();

            return [
                "view" =>  VIEW_DIR."security/listUsers.php",
                "data" => [
                    "users" => $users
                ]
            ];

        }
   

        public function forumRules(){
            
            return [
                "view" => VIEW_DIR."rules.php"
            ];
        }

        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/

        public function home(){
            
           
            return [
                "view" => VIEW_DIR."home.php"
            ];
        }
    }
