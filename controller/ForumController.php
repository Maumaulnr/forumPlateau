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
    
    class ForumController extends AbstractController implements ControllerInterface {

        public function index()
        {
          
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

            $categories = $categoryManager->findAll();

            return [
                "view" => VIEW_DIR. "forum/listCategories.php",
                "data" => [
                    "categories" => $categories,
                    "title" => "Liste des catégories",
                    "description" => "Liste des catégories du forum des métiers"
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
             * $category : For title of the category in the topic
             * 
             */
            $category = $categoryManager->findOneById($id);
            // var_dump($category);

            return [
                "view" => VIEW_DIR. "forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findTopicByCategoryId($id),
                    "category" => $category,
                    "title" => "Liste des topics",
                    "description" => "Liste des topics par catégorie"
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

             /**
             * For title of the topic
             * 
             */
            $topic = $topicManager->findOneById($id);
            
            return [
                "view" => VIEW_DIR. "forum/listMessages.php",
                "data" => [
                    "topic" => $topic,
                    "messages" => $messageManager->findMessageByTopicId($id),
                    "title" => "Liste des messages",
                    "description" => "Liste des messages par topic"
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
                "view" => VIEW_DIR. "forum/addCategoryForm.php",
                "data" => [
                    "title" => "Formulaire de la catégorie",
                    "description" => "Formulaire pour ajouter une catégorie"
                ]
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

                Session::addFlash('error', 'Ce champ est obligatoire');
    
            }

            // label ne doit pas dépasser 30 caractères
            if(strlen($nameCategory) > 100) {
                Session::addFlash('error', 'Le nom est trop long');
            }

            if($nameCategory) {
            // si les règles de validation du formulaire sont respectées
            $categoryManager->add(["nameCategory"=>$nameCategory]);

            $this->redirectTo("forum", "listCategories");

            } else {

                Session::addFlash('error', 'Veuillez entrer à nouveau le nom de la catégorie');
                return $this->addCategoryForm();
            }

        }

        // On fait en sorte de pouvoir choisir la catégorie a associé au topic que l'on pourra choisir dans le fichier addTopicForm.php en retournant le tableau categories.
        // Grâce à cette fonction on peut récupérer getNameCategory dans addTopicForm.php pour choisir le nom de la catégorie.
        public function addTopicForm($id) {

            $categoryManager = new CategoryManager();

            /**
             * App/Session::getFlash()
             * Dans addTopicForm : action="index.php?ctrl=forum&action=addTopic&id=<?= $id ?>" : on récupère l'id de la category grâce au lien pour ajouter un topic qui se trouve dans UNE category ($_GET["id"])
            */
            return [
                "view" => VIEW_DIR. "forum/addTopicForm.php",
                "data" => [
                    "category" => $categoryManager->findOneById($id),
                    "successMessage" => Session::getFlash('success'),
                    "errorMessage" => Session::getFlash('error'),
                    "title" => "Formulaire d'ajout d'un topic",
                    "description" => "Formulaire pour ajouter un topic en fonction de la catégorie"
                ]
            ];
        }

        // ajouter un topic en fonction de la catégorie sur laquelle on a cliqué
        public function addTopic($id) {

            // filtrer ce qui arrive en POST
            // "nameTopic" : vient du name="nameTopic" du fichier addTopicForm.php
            $nameTopic = filter_input(INPUT_POST, "nameTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $commentText = filter_input(INPUT_POST, "commentText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            if($nameTopic && $commentText) 
            {
                $topicManager = new TopicManager();
                $messageManager = new MessageManager();

                // On récupère l'id de l'utilisateur qui est connecté
                $userId = Session::getUser()->getId();

                /**
                 * On ajoute un topic en fontion de la catégorie
                 * $topicId -> DAO->return self::$bdd->lastInsertId() : pour pousser l'id jusquà la table Message et donc pouvoir ajouter un message ("topic_id" => $topicId)
                 */
                $topicId = $topicManager->add(["nameTopic" => $nameTopic, "user_id" => $userId, "category_id" => $id]);

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

                return $this->addTopicForm($id);

            }

        }

        /**
         * ADD MESSAGE
         **/

        public function addMessageForm($id) 
        {
            $topicManager = new TopicManager();
            // $messageManager = new MessageManager();

            $topic = $topicManager->findOneById($id);

            return [
                "view" => VIEW_DIR. "forum/addMessageForm.php",
                "data" => [
                    "topic" => $topic,
                    "title" => "Formulaire d'ajout d'un message",
                    "description" => "Formulaire pour ajouter un message en fonction du topic dans lequel on se trouve"
                ]
            ];
        }

        public function addMessage($id) 
        {

            $commentText = filter_input(INPUT_POST, "commentText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $topicId = filter_input(INPUT_POST, "topicId", FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);

            // On récupère l'id de l'utilisateur qui est connecté
            $userId = Session::getUser()->getId();

            if ($commentText && $topicId) {

                $messageManager = new MessageManager();

                // "commentText" = commentText de la BDD
                $messageManager->add(["commentText" => $commentText, "user_id" => $userId, "topic_id" => $topicId]);

                $this->redirectTo("forum", "findMessageByTopicId", $topicId);

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

            $message = $messageManager->findOneById($id);
            // var_dump($topic);
            return [
                "view" => VIEW_DIR. "forum/updateMessageForm.php",
                "data" => [
                    "message" => $message,
                    "topicId" => $_GET['topicId'],
                    "title" => "Formulaire de modification d'un message",
                    "description" => "Formulaire pour modifier un message en fonction du topic"
                ]
            ];

        }

        public function update($id) {

            $messageManager = new MessageManager();

            // filtrer ce qui arrive en POST
            // "commentText" : vient du name="commentText" du fichier updateMessageForm.php
            $id = filter_input(INPUT_POST, "idMessage", FILTER_SANITIZE_NUMBER_INT);
            $commentText = filter_input(INPUT_POST, "commentText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /** 
             * id = :id de la requête
             * newCommentText = :newCommentText
             * donc bien écrire pareil dans la fonction update ici.
            */
            $messageManager->update(["id" => $id, "newCommentText"=> $commentText]);

            // filtrer input topidId pour récupérer le bon id en fonction du topic
            $topicId = filter_input(INPUT_POST, "topicId", FILTER_SANITIZE_NUMBER_INT);

            // on retourne vers la liste des messages dans le bon topic grâce à $topidId
            return $this->findMessageByTopicId($topicId);

        }

        /**
         * UPDATE TOPIC
         *  
         **/
        public function updateTopicForm($id) 
        {
            $topicManager = new TopicManager();

            $topic = $topicManager->findOneById($id);

            return [
                "view" => VIEW_DIR. "forum/updateTopicForm.php",
                "data" => [
                    "topic" => $topic,
                    "categoryId" => $_GET['categoryId'],
                    "title" => "Formulaire de modification d'un topic",
                    "description" => "Formulaire pour modifier un topic en fonction de la catégorie"
                ]
            ];
        }

        public function updateTopic($id) 
        {
            $topicManager = new TopicManager();

            // filtrer ce qui arrive en POST
            // "nameTopic" : vient du name="nameTopic" du fichier updateTopicForm.php
            // $id = filter_input(INPUT_POST, "idTopic", FILTER_SANITIZE_NUMBER_INT);
            $categoryId = filter_input(INPUT_POST, "categoryId", FILTER_SANITIZE_NUMBER_INT);
            $nameTopic = filter_input(INPUT_POST, "nameTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /** 
             * id = :id de la requête
             * newNameTopic = :newNameTopic
             * donc bien écrire pareil dans la fonction update ici.
            */
            $topicManager->update(["id" => $id, "newNameTopic"=> $nameTopic]);

            // on retourne vers la liste des topics dans la bonne catégorie grâce à l'id
            $this->redirectTo("forum", "findTopicByCategoryId", $categoryId) ;
        }

        /**
         * UPDATE CATEGORY
         *  
         **/
        public function updateCategoryForm($id) {
            
            $categoryManager = new CategoryManager();

            $category = $categoryManager->findOneById($id);
            
            return [
                "view" => VIEW_DIR. "forum/updateCategoryForm.php",
                "data" => [
                    "category" => $category,
                    "title" => "Formulaire de modification d'une catégorie",
                    "description" => "Formulaire pour modifier une catégorie"
                ]
            ];

        }

        public function updateCategory($id) {

            $categoryManager = new CategoryManager();

            // filtrer ce qui arrive en POST
            // "nameCategory" : vient du name="nameCategory" du fichier updateCategoryForm.php
            $nameCategory = filter_input(INPUT_POST, "nameCategory", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /** 
             * id = :id de la requête
             * newNameCategory = :newNameCategory
             * donc bien écrire pareil dans la fonction update ici.
            */
            $categoryManager->update(["id" => $id, "newNameCategory"=> $nameCategory]);

            // on retourne vers la liste des messages dans la liste des catégories
            $this->redirectTo('forum', 'listCategories');

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
        public function deleteMessage($id) 
        {

            $messageManager = new MessageManager();

            /** 
             * id = :id de la requête
             * 
            */
            $messageManager->delete($id);

            $topicId = $_GET['topicId'];

            // on retourne vers la liste des messages dans le bon topic grâce à $topicId
            return $this->findMessageByTopicId($topicId);

        }

        /**
         * DELETE TOPIC => id_topic 
         *  
         * Supprimer un topic et les messages DU topic
         * FK dans table Message => topic_id
         **/
        public function deleteTopic($id) 
        {
            $topicManager = new TopicManager();
            $messageManager = new MessageManager();

            /** 
             * id = :id de la requête
             *
            */
            
            $messageManager->delete($id);
            $topicManager->delete($id);

            // on récupère category_id pour la redirection
            $categoryId = $_GET['categoryId'];

            // on retourne vers la liste des topics dans la bonne catégorie grâce à $categoryId
            return $this->findTopicByCategoryId($categoryId);

        }
        
        /**
         * DELETE CATEGORY => id_category
         *  
         **/
        public function deleteCategory($id) 
        {
            $messageManager = new MessageManager();
            $topicManager = new TopicManager();
            $categoryManager = new CategoryManager();

            /** 
             * id = :id de la requête
             * 
            */
            $messageManager->delete($id);
            $topicManager->delete($id);
            $categoryManager->delete($id);

            // on retourne vers la liste des categories
            $this->redirectTo('forum', 'listCategories');
        }

        /**
         * Cette méthode topicLock est responsable de la gestion du verrouillage d'un sujet. 
         * Elle utilise un gestionnaire de sujets (TopicManager) pour effectuer l'opération de verrouillage dans la base de données, puis redirige l'utilisateur vers une autre page pour afficher les sujets mis à jour. 
         * 
         */

        public function topicLock($id) 
        {

            if (Session::isAdmin()) 
            {

                $topicManager = new TopicManager();

                $topicManager->topicLock($id);

            }

            // on retourne vers la liste des messages dans le bon topic grâce à $id
            $this->redirectTo("forum", "findMessageByTopicId", $id);

        }
 
        /**
         * Cette méthode topicUnlock est responsable de la gestion du déverrouillage d'un sujet. 
        * Elle utilise un gestionnaire de sujets (TopicManager) pour effectuer l'opération de déverrouillage dans la base de données, puis redirige l'utilisateur vers une autre page pour afficher les sujets mis à jour. 
        * 
        */

        public function topicUnlock($id)
        {
            
            if (Session::isAdmin()) 
            {

                $topicManager = new TopicManager();

                $topicManager->topicUnlock($id);

            }

            // on retourne vers la liste des messages dans le bon topic grâce à $id
            $this->redirectTo("forum", "findMessageByTopicId", $id);

        }

    }
