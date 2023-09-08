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

        /**
         * ******************************
         * 
         * 
         *          FUNCTION : LIST
         * 
         * 
         * ******************************
         */

         /**
          * List of categories
          */
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

        /**
         * 
         * List of Topic by Category Id
         * 
         * We search the list of topics by category id, because we want to display topics according to their category.
         * 
         * request in TopicManager.php
         * 
        */
        public function findTopicByCategoryId($id) {

            $topicManager = new TopicManager();
            $categoryManager = new CategoryManager();

            /**
             * For title of the category 
             */
            $category = $categoryManager->findOneById($id);

            return [
                "view" => VIEW_DIR. "forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findTopicByCategoryId($id),
                    "category" => $category
                ]
            ];
        }

        /**
         * 
         * List of Message by Topic Id
         * 
         *  We search the list of messages by topic id, because we want to display messages according to their topic.
         * 
         * request in MessageManager.php
        */
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
         * ******************************
         * 
         * 
         *          FUNCTION : ADD
         * 
         * 
         * *******************************
         */

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

        /**
         * On reçoit le formulaire
         * 
         * On filtre le formulaire grâce aux FILTER
         */
        public function addCategory() {

            $nameCategory = filter_input(INPUT_POST, 'nameCategory', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $categoryManager = new CategoryManager();

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

            /**
             * App/Session::getFlash()
            */
            return [
                "view" => VIEW_DIR. "forum/addTopicForm.php",
                "data" => [
                    "category" => $categoryManager->findOneById($id),
                    // "topics" => $topicManager->findTopicByCategoryId($id),
                    "successMessage" => Session::getFlash('success'),
                    "errorMessage" => Session::getFlash('error')
                ]
            ];
        }

        // ajouter un topic en fonction de la catégorie sur laquelle on a cliqué
        public function addTopic($id) {

            // filtrer ce qui arrive en POST
            // "nameTopic" : vient du name="nameTopic" du fichier addTopicForm.php
            $nameTopic = filter_input(INPUT_POST, "nameTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $commentText = filter_input(INPUT_POST, "commentText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userId = filter_input(INPUT_POST, "userId", FILTER_SANITIZE_NUMBER_INT);
            $categoryId = filter_input(INPUT_POST, "categoryId", FILTER_SANITIZE_NUMBER_INT);
            // $topicId = filter_input(INPUT_POST, "topicId", FILTER_SANITIZE_NUMBER_INT);

            // $topicManager = new TopicManager();
            // $messageManager = new MessageManager();

            if($nameTopic && $categoryId && $commentText) 
            {
                $topicManager = new TopicManager();
                $messageManager = new MessageManager();

                /**
                 * On ajoute un topic en fontion de la catégorie
                 * $topicId -> DAO->return self::$bdd->lastInsertId() : pour pousser l'id jusquà la table Message et donc pouvoir ajouter un message ("topic_id" => $topicId)
                 */
                $topicId = $topicManager->add(["nameTopic" => $nameTopic, "user_id" => $userId, "category_id" => $categoryId]);

                /**
                 * on ajoute le message
                 */
                $messageManager->add(["commentText" => $commentText, "user_id" => $userId, "topic_id" => $topicId]);

                Session::addFlash('success', 'Le topic a été ajouté');

                /**
                 * On redirige vers layout pour voir le message s'afficher
                 */
                $this->redirectTo('view', 'layout');

            } else {

                return $this->addTopicForm($categoryId);

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


        /**
         * ******************************
         * 
         * 
         *          FUNCTION : UPDATE
         * 
         * 
         * ******************************
         **/


        /**
         *  UPDATE MESSAGE => commentText
         * 
         * On veut les vraies données de la bdd
         * 
         * "topidId" => $_GET['topicId'] => permet de récupérer topicId quand on veut changer un message (commentText) précis
         */
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
                    "topicId" => $_GET['topicId']
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

        }


        /**
         * ******************************
         * 
         * 
         *          FUNCTION : DELETE
         * 
         * 
         * ******************************
         **/


        /**
         * DELETE MESSAGE => id_message
         *  
         **/ 
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
