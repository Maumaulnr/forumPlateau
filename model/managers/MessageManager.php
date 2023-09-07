<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class MessageManager extends Manager{

        protected $className = "Model\Entities\Message";
        protected $tableName = "message";


        public function __construct(){
            parent::connect();
        }

        // We retrieve all messages associated with a particular topic.
        public function findMessageByTopicId($id)
        {

            $sql= "SELECT *
                    FROM ".$this->tableName." m
                    WHERE m.topic_id = :id
                    ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]), 
                $this->className
            );
           
        }

        /** 
         * $data = param
         * 
         * 
         */  
        public function update($data) 
        {

            $sql = "UPDATE ".$this->tableName."
            SET commentText = :newCommentText
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

        public function delete($data){
            $sql = "DELETE FROM ".$this->tableName."
                    WHERE id_".$this->tableName." = :id
                    ";

            try {

                return DAO::delete($sql, $data);
    
                } catch (\Throwable $th) {
    
                //throw $th;
    
                }
        }

    }

?>