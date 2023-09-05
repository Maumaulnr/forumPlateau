<?php

    namespace Controller;

    use App\DAO;
    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\CategoryManager;
    use Model\Managers\TopicManager;
    use Model\Managers\MessageManager;
    use Model\Managers\UserManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          
           $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["dateCreationTopic", "DESC"])
                ]
            ];
        
        }

        public function listCategories() {
            $categoryManager = new CategoryManager();
            $topicManager = new TopicManager();

            $categories = $categoryManager->findAll();

            return [
                "view" => VIEW_DIR. "forum/listCategories.php",
                "data" => [
                    "categories" => $categories,
                    "topics" => $topicManager
                ]
            ];
        }

        // We search the list of topics by category id, because we want to display topics according to their category.
        // request in TopicManager.php
        public function findTopicByCategoryId($id) {

            $topicManager = new TopicManager();
            $categoryManager = new CategoryManager();

            return [
                "view" => VIEW_DIR. "forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findTopicByCategoryId($id),
                    "categories" => $categoryManager->findAll()
                ]
            ];
        }

        //  We search the list of messages by topic id, because we want to display messages according to their topic.
        // request in MessageManager.php
        public function findMessageByTopicId($id) {

            $topicManager = new TopicManager();
            $messageManager = new MessageManager();
            $userManager = new UserManager();
            $topic = $topicManager->findTopicByCategoryId($id);

            return [
                "view" => VIEW_DIR. "forum/listMessages.php",
                "data" => [
                    "topic" => $topic,
                    "messages" => $messageManager->findMessageByTopicId($id),
                    "userManager" => $userManager
                ]
            ];
        }

        /**  
         * public function addCategoryForm(): Cette ligne définit une méthode publique appelée addCategoryForm(). On peut appeler cette méthode depuis d'autres parties du programme pour effectuer une action spécifique.
         * @return: La déclaration return est utilisée pour renvoyer une valeur depuis une fonction. Dans ce cas, la fonction addCategoryForm() renvoie un tableau associatif.
         * afficher un formulaire permettant d'ajouter une catégorie 
         */
        public function addCategoryForm() {

            return [
                "view" => VIEW_DIR. "forum/addCategoryForm.php"
            ];
        }

        public function addCategory() {

            $nameCategory = filter_input(INPUT_POST, 'nameCategory', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $categoryManager = new CategoryManager();

            // vars
            $isAddCategorySuccess = false;
            $globalMessage = "L'enregistrement a bien été effectué";
            $formValues = null;

            // validation des règles du formulaire
            $isFormValid = true;
            $errorMessages = [];

            // nameCategory est obligatoire
            // si nameCategory est vide
            if($nameCategory == "") {
                $isFormValid = false;
                $errorMessages["nameCategory"] = "Ce champ est obligatoire";
            }

            // label ne doit pas dépasser 30 caractères
            if(strlen($nameCategory) > 100) {
                $isFormValid = false;
                $errorMessages["nameCategory"] = "Ce champ est limité à 100 caractères";
            }

            // si les règles de validation du formulaire sont respectées
            if ($isFormValid) {

                $categoryManager->add(["nameCategory"=>$nameCategory]);

                $this->redirectTo("forum", "listCategories");

            } else {
                // le formulaire est invalide
    
                $globalMessage = "Le formulaire est invalide";
    
                $formValues = [
                    "nameCategory" => $nameCategory
                ];
            }
        }

        // On fait en sorte de pouvoir choisir la catégorie a associé au topic que l'on pourra choisir dans le fichier addTopicForm.php en retournant le tableau categories.
        // Grâce à cette fonction on peut récupérer getNameCategory dans addTopicForm.php pour choisir le nom de la catégorie.
        public function addTopicForm($id) {

            $categoryManager = new CategoryManager();
            $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR. "forum/addTopicForm.php",
                "data" => [
                    "categories" => $categoryManager->findAll(),
                    "topics" => $topicManager->findTopicByCategoryId($id)
                ]
            ];
        }

        // ajouter un topic en fonction de la catégorie sur laquelle on a cliqué
        public function addTopic($id) {

            // filtrer ce qui arrive en POST
            // "nameTopic" : vient du name="nameTopic" du fichier addActorForm.php
            $nameTopic = filter_input(INPUT_POST, "nameTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $message = filter_input(INPUT_POST, "commentText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $userId = filter_input(INPUT_POST, "user_id", FILTER_SANITIZE_NUMBER_INT);
            $categoryId = filter_input(INPUT_POST, "categoryId", FILTER_SANITIZE_NUMBER_INT);

            $topicManager = new TopicManager();
            $messageManager = new MessageManager();

            // vars
            $isAddTopicSuccess = false;
            $globalMessage = "L'enregistrement a bien été effectué";
            $formValues = null;

            // validation des règles du formulaire
            $isFormValid = true;
            $errorMessages = [];

            // nameCategory est obligatoire
            // si nameCategory est vide
            if($nameTopic && $message == "") {
                $isFormValid = false;
                $errorMessages["nameTopic"] = "Ce champ est obligatoire";
                $errorMessages["message"] = "Ce champ est obligatoire";
            }

            // si les règles de validation du formulaire sont respectées
            if ($isFormValid) {
                
                $topicManager->add(["nameTopic" => $nameTopic, "category_id" => $categoryId]);
                $messageManager->add(["commentText" => $message]);


                return $this->addTopicForm($id);

            } else if (!$isAddTopicSuccess) {

                    $globalMessage = "L'enregistrement a échoué";

            } else {
                // le formulaire est invalide
    
                $globalMessage = "Le formulaire est invalide";
    
                return $this->addTopicForm($id);
            }

                // si la mise à jour est un succès sinon on prérempli le formulaire et on modifie pour corriger l'erreur, dans tous les cas il y a une redirection
            if ($isAddTopicSuccess) {

                $this->redirectTo("forum", "listTopics");

            } else {
                // sinon peu importe pourquoi

                $formValues = [
                    "nameTopic" => $nameTopic,
                    "message" => $message
                ];

                return $this->addTopicForm($id);
            }

        }

    }
