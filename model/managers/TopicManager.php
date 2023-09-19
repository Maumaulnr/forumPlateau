<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }

        // We retrieve all topics associated with a particular category.
        public function findTopicByCategoryId($id)
        {

            $sql= "SELECT *
                    FROM ".$this->tableName." t
                    WHERE t.category_id = :id
                    ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]), 
                $this->className
            );
           
        }

        /** 
         * $data = param
         * 
         * On met à jour le nom du topic en fonction de son id
         */  
        public function update($data) 
        {

            $sql = "UPDATE ".$this->tableName."
            SET nameTopic = :newNameTopic
            WHERE id_".$this->tableName." = :id
            ;";

            /**
             * on essaie la fonction du DAO
             * on renvoie l'état du statement après exécution (true ou false)
             */
           try {

            return DAO::update($sql, $data);

           } catch (\Throwable $th) {

            //throw $th;

           }

        }

        /**
         * On met à jour subjectLock pour pouvoir verrouiller un topic en fonction de son id
         * 
         * Cette méthode exécute la requête SQL pour verrouiller le sujet avec l'ID spécifié. Si la mise à jour réussit, elle renverra probablement true, sinon, elle renverra false. 
         * 
         * L'utilisation d'un bloc try...catch permet de gérer les exceptions potentielles lors de l'exécution de la requête.
         */
        public function topicLock($id) 
        {

            $sql = "UPDATE ".$this->tableName."
            SET subjectLock = 1
            WHERE id_".$this->tableName." = :id
            ;";

            /**
             * on essaie la fonction du DAO
             * on renvoie l'état du statement après exécution (true ou false)
             */
           try {

            return DAO::update($sql, ['id' => $id], false);

           } catch (\Throwable $th) {

            //throw $th;

           }

        }

        /**
         * On met à jour subjectLock pour pouvoir déverrouiller un topic en fonction de son id
         * 
         * Cette méthode exécute la requête SQL pour déverrouiller le sujet avec l'ID spécifié. Si la mise à jour réussit, elle renverra probablement true, sinon, elle renverra false. 
         * 
         * L'utilisation d'un bloc try...catch permet de gérer les exceptions potentielles lors de l'exécution de la requête.
         */
        public function topicUnlock($id) 
        {

            $sql = "UPDATE ".$this->tableName."
            SET subjectLock = 0
            WHERE id_".$this->tableName." = :id
            ;";

            /**
             * on essaie la fonction du DAO
             * on renvoie l'état du statement après exécution (true ou false)
             */
           try {

            return DAO::update($sql, ['id' => $id], false);

           } catch (\Throwable $th) {

            //throw $th;

           }

        }

        // UPDATE message
        // SET user_id = NULL
        // WHERE user_id = 1;
        public function updateIsAnonymous($data) 
        {

            $sql = "UPDATE ". $this->tableName. "
            SET user_id = newUserId
            WHERE id_".$this->tableName. " = :id 
            ;";

            /**
             * on essaie la fonction du DAO
             * on renvoie l'état du statement après exécution (true ou false)
             */
           try {

            return DAO::update($sql, $data);

           } catch (\Throwable $th) {

            //throw $th;

           }

        }


    }

?>