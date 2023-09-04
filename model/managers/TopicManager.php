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

    }

?>