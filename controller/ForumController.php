<?php

    namespace Controller;

    use App\DAO;
    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Entities\Message;
    use Model\Entities\Topic;
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

            $category = $categoryManager->findOneById($id);

            return [
                "view" => VIEW_DIR. "forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findTopicByCategoryId($id),
                    "category" => $category
                ]
            ];
        }

        //  We search the list of messages by topic id, because we want to display messages according to their topic.
        // request in MessageManager.php
        public function findMessageByTopicId($id) {
            // var_dump($id);
            $topicManager = new TopicManager();
            $messageManager = new MessageManager();
            $userManager = new UserManager();

            $topic = $topicManager->findOneById($id);
            

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
            $commentText = filter_input(INPUT_POST, "commentText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userId = filter_input(INPUT_POST, "userId", FILTER_SANITIZE_NUMBER_INT);
            $categoryId = filter_input(INPUT_POST, "categoryId", FILTER_SANITIZE_NUMBER_INT);
            $topicId = filter_input(INPUT_POST, "topicId", FILTER_SANITIZE_NUMBER_INT);

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
            if($nameTopic && $commentText == "") {
                $isFormValid = false;
                $errorMessages["nameTopic"] = "Ce champ est obligatoire";
                $errorMessages["commentText"] = "Ce champ est obligatoire";
            }

            // si les règles de validation du formulaire sont respectées
            if ($isFormValid) {
                // "nameTopic" = nameTopic de la BDD
                $topicManager->add(["nameTopic" => $nameTopic, "user_id" => $userId, "category_id" => $categoryId]);
                $messageManager->add(["commentText" => $commentText, "user_id" => $userId, "topic_id" => $topicId]);


                $this->redirectTo("forum", "listCategories");

            } else if (!$isAddTopicSuccess) {

                    $globalMessage = "L'enregistrement a échoué";

            } else {
                // le formulaire est invalide
    
                $globalMessage = "Le formulaire est invalide";
    
                return $this->addTopicForm($id);
            }

                // si la mise à jour est un succès sinon on prérempli le formulaire et on modifie pour corriger l'erreur, dans tous les cas il y a une redirection
            if ($isAddTopicSuccess) {

                $this->redirectTo("forum", "listCategories");

            } else {
                // sinon peu importe pourquoi

                $formValues = [
                    "nameTopic" => $nameTopic,
                    "commentText" => $commentText
                ];

                return $this->addTopicForm($id);
            }

        }

        public function addMessageForm($id) 
        {
            $topicManager = new TopicManager();
            $messageManager = new MessageManager();

            $topic = $topicManager->findOneById($id);

            return [
                "view" => VIEW_DIR. "forum/addMessageForm.php",
                "data" => [
                    "topic" => $topic,
                    "messages" => $messageManager->findMessageByTopicId($id)
                ]
            ];
        }

        public function addMessage($id) 
        {
            $topicId = filter_input(INPUT_POST, "topicId", FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);
            $commentText = filter_input(INPUT_POST, "commentText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($topicId && $commentText) {

                $messageManager = new MessageManager();

                // "commentText" = commentText de la BDD
                $messageManager->add(["commentText" => $commentText, "user_id" => 1, "topic_id" => $topicId]);

                $this->redirectTo("forum", "listCategories");

            } else {

                return $this->findTopicByCategoryId($topicId);
            }

        }


            // UPDATE MESSAGE => commentText
        // On veut les vraies données de la bdd
        // "topidId" => $_GET['topicId'] => permet de récupérer topicId quand on veut changer un message (commentText) précis
        public function updateMessageForm($id) {
            // var_dump($id);
            $messageManager = new MessageManager();
            $topicManager = new TopicManager();

            $message = $messageManager->findOneById($id);
            $topic = $topicManager->findOneById($id);
            // var_dump($topic);
            return [
                "view" => VIEW_DIR. "forum/updateMessageForm.php",
                "data" => [
                    "message" => $message,
                    "topic" => $topic,
                    "topidId" => $_GET['topicId']
                ]
            ];

        }

        public function update($id) {

            $messageManager = new MessageManager();

            // filtrer ce qui arrive en POST
            // "commentText" : vient du name="commentText" du fichier updateMessageForm.php
            $idMessage = filter_input(INPUT_POST, "idMessage", FILTER_SANITIZE_NUMBER_INT);
            $commentText = filter_input(INPUT_POST, "commentText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /** 
             * id = :id de la requête
             * newCommentText = :newCommentText
             * donc bien écrire pareil dans la fonction update ici.
            */
            $messageManager->update(["id" => $idMessage, "newCommentText"=> $commentText]);

            // filtrer input topidId pour récupérer le bon id en fonction du topic
            $topicId = filter_input(INPUT_POST, "topicId", FILTER_SANITIZE_NUMBER_INT);

            // on retourne vers la liste des messages dans le bon topic grâce à $topidId
            return $this->findMessageByTopicId($topicId);

            // // vars
            // $isUpdateMessageSuccess = false;

            // // si la mise à jour est un succès sinon on prérempli le formulaire et on modifie pour corriger l'erreur, dans tous les cas il y a une redirection
            // if ($isUpdateMessageSuccess) {
            //     $this->findMessageByTopicId($id); // le require est inclus dans la méthode

            // } else {
            //     // sinon peu importe pourquoi

            //     return $this->findMessageByTopicId($id);
            // }
        }

        // DELETE MESSAGE => id_message
        public function delete($id) 
        {
            $messageManager = new MessageManager();

            /** 
             * id = :id de la requête
             * donc bien écrire pareil dans la fonction update ici.
            */
            $messageManager->delete(['id' => $id]);

            $topicId = $_GET['topicId'];

            // on retourne vers la liste des messages dans le bon topic grâce à $topidId
            return $this->findMessageByTopicId($topicId);

        }

    }
