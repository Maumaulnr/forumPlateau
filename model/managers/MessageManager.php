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

        public function update($id) 
        {

            $sql = "UPDATE".$this->tableName."
            SET commentText = :newCommentText
            WHERE id_".$this->tableName." = :id
            ;";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false), 
                $this->className
            );

        }

    }

?>