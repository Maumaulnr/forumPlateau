<?php

        // Je lui dis que je le range dans l'espace Model\Entities
    namespace Model\Entities;

    // le chemin à utiliser
    use App\Entity;

    // final class : bout de la class, ne peut pas être la mère de quelque chose d'autre. Meilleure lisibilité
    // ne peut pas avoir d'enfants
    // Class topic hérite de la class entity (entity parent)
    final class User extends Entity{

        // Liste des propriétés de la class Topic selon le principe d'encapsulation (visibilté des éléments au sein d'une class)
        // Propriété privé accessible que au sein de la class
        // propriétés dans le même ordre que dans la BDD (lira les colonnes dans cet ordre là)
        private $id; // id_user
        private $dateCreationCount;
        private $userName;
        private $userEmail;
        private $password;
        private $banUser;
        private $userRole;

        

        // hydrate vient de la class Entity
        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of dateCreationCount
         */ 
        public function getDateCreationCount()
        {
                return $this->dateCreationCount;
        }

        /**
         * Set the value of dateCreationCount
         *
         * @return  self
         */ 
        public function setDateCreationCount($dateCreationCount)
        {
                $this->dateCreationCount = $dateCreationCount;

                return $this;
        }

        /**
         * Get the value of userName
         */ 
        public function getUserName()
        {
                return $this->userName;
        }

        /**
         * Set the value of userName
         *
         * @return  self
         */ 
        public function setUserName($userName)
        {
                $this->userName = $userName;

                return $this;
        }

        /**
         * Get the value of userEmail
         */ 
        public function getUserEmail()
        {
                return $this->userEmail;
        }

        /**
         * Set the value of userEmail
         *
         * @return  self
         */ 
        public function setUserEmail($userEmail)
        {
                $this->userEmail = $userEmail;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of banUser
         */ 
        public function getBanUser()
        {
                return $this->banUser;
        }

        /**
         * Set the value of banUser
         *
         * @return  self
         */ 
        public function setBanUser($banUser)
        {
                $this->banUser = $banUser;

                return $this;
        }

        
        // Method _toString
        public function __toString()
        {
                return $this->getUserName() . $this->getUserEmail() . $this->getPassword() . $this->getDateCreationCount() . $this->getBanUser();
        }


        /**
         * Get the value of userRole
         */ 
        public function afficherRole()
        {
                if(in_array("ROLE_ADMIN", $this->getUserRole())) {

                        return "admin";
                } else {

                        return "user";
                }
        }

        /**
         * Set the value of userRole
         *
         * @return  self
         */ 
        public function setUserRole($role)
        {
                // // Afficher la valeur de $role
                // echo "Contenu de la variable \$role : ";
                // var_dump($role);

                /** 
                 * Vérifier si $role est NULL ou une chaîne JSON vide
                 * trim($role) === '' vérifie si la variable $role est soit null, soit une chaîne vide (après avoir supprimé les espaces et les caractères invisibles de ses extrémités). Si c'est le cas, la condition est vraie, ce qui peut indiquer que la variable $role est vide ou non définie.
                 * Vérifier si $role est NULL ou une chaîne JSON vide
                 * */ 
                if ($role === null || trim($role) === '') {

                        
                        // S'il est vide, vous pouvez attribuer un rôle par défaut
                        $this->userRole = ["ROLE_USER"];
                        // S'il n'y a pas de rôles attitrés, on va lui attribué un rôle

                } else {

                        // on récupère du JSON
                        // S'il contient une chaîne JSON valide, la décoder
                        $this->userRole = json_decode($role);

                        // Vérifier si la décoding a échoué (probablement en raison d'une JSON invalide)
                        if ($this->userRole === null && json_last_error() !== JSON_ERROR_NONE) {
                                // Gérer l'erreur de décoding JSON ici si nécessaire
                                
                        }
                }

                return $this;
                
        }

        public function hasRole($role) 
        {
                
                // si dans mon tableau JSON on trouve un rôle qui correspond au rôle en paramètre alors ça va nous return le rôle
                return in_array($role, $this->getUserRole());
                
        }


        /**
         * Get the value of userRole
         */ 
        public function getUserRole()
        {
                return $this->userRole;
        }
        
    }
