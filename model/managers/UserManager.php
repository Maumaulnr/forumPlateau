<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }

       public function findOneByEmail($email) {
            $sql = "SELECT *
                    FROM ".$this->tableName." u
                    WHERE u.userEmail = :email";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false),
                $this->className
            );
       }


       public function findOneByPseudo($pseudo) {
            $sql = "SELECT *
                    FROM ".$this->tableName." u
                    WHERE u.userName = :userName";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['userName' => $pseudo], false),
                $this->className
            );
       }

    }

?>