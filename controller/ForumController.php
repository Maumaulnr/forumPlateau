<?php

    namespace Controller;

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

        // We search the list of topics by category id, because we want to display topics according to their category.
        // request in TopicManager.php
        public function findTopicByCategoryId($id) {

            $topicManager = new TopicManager();
            $categoryManager = new CategoryManager();

            return [
                "view" => VIEW_DIR. "forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findTopicByCategoryId($id)
                ]
            ];
        }

        //  We search the list of messages by topic id, because we want to display messages according to their topic.
        // request in MessageManager.php
        public function findMessageByTopicId($id) {

            $topicManager = new TopicManager();
            $messageManager = new MessageManager();

            return [
                "view" => VIEW_DIR. "forum/listMessages.php",
                "data" => [
                    "messages" => $messageManager->findMessageByTopicId($id)
                ]
            ];
        }

        

    }
