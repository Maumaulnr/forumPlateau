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

        public function findOneByEmail($email) 
        {

            $sql = "SELECT *
                    FROM ".$this->tableName." u
                    WHERE u.userEmail = :email";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false),
                $this->className
            );

        }


        public function findOneByPseudo($pseudo) 
        {

            $sql = "SELECT *
                    FROM ".$this->tableName." u
                    WHERE u.userName = :userName";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['userName' => $pseudo], false),
                $this->className
            );

        }

        public function findOneByPassword($currentPassword) 
        {

            $sql = "SELECT *
                    FROM ".$this->tableName." u
                    WHERE u.password = :password";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['password' => $currentPassword], false),
                $this->className
            );

        }

        // Update a user
        public function update($data)
        {

            $sql = "UPDATE " . $this->tableName . "
                    SET userName = :newUserName,
                    userEmail = :newUserEmail
                    WHERE id_" . $this->tableName . " = :id
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

        // UPDATE user
        public function updateIsAnonymous($data) 
        {

            $sql = "UPDATE ". $this->tableName. "
            SET userName = :newUserName,
            userEmail = :newUserEmail
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

        /**
         * If user is ban = 1
         * $id : user_id
         */
        public function isBan($id) {

            $sql = "UPDATE ". $this->tableName. "
            SET banUser = 1
            WHERE id_".$this->tableName." = :id 
            ;";

            /**
             * La méthode DAO::update() est appelée pour exécuter la requête SQL
             * La méthode retourne le résultat de la mise à jour, qui peut être true si la mise à jour a réussi ou false en cas d'échec.
             */
            return DAO::update($sql, ['id' => $id], false);

        }

        /**
         * If user is no longer ban = 0
         * $id : user_id
         */
        public function isUnBan($id) {

            $sql = "UPDATE ". $this->tableName. "
            SET banUser = 0
            WHERE id_".$this->tableName." = :id
            ;";

            /**
             * La méthode DAO::update() est appelée pour exécuter la requête SQL
             * La méthode retourne le résultat de la mise à jour, qui peut être true si la mise à jour a réussi ou false en cas d'échec.
             */
            return DAO::update($sql, ['id' => $id], false);
        }

        /**
         * UPDATE PASSWORD
         */
        public function updatePassword($data) {

            $sql = "UPDATE ". $this->tableName. "
            SET password = :newPassword
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