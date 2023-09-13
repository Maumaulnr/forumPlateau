<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class CategoryManager extends Manager{

        protected $className = "Model\Entities\Category";
        protected $tableName = "category";


        public function __construct(){
            parent::connect();
        }

        /** 
         * $data = param
         * 
         * 
         */  
        public function update($data) 
        {

            $sql = "UPDATE ".$this->tableName."
            SET nameCategory = :newNameCategory
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

    }

?>