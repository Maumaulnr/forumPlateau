<?php

        // Je lui dis que je le range dans l'espace Model\Entities
    namespace Model\Entities;

    // le chemin à utiliser
    use App\Entity;

    // final class : bout de la class, ne peut pas être la mère de quelque chose d'autre. Meilleure lisibilité
    // ne peut pas avoir d'enfants
    // Class topic hérite de la class entity (entity parent)
    final class Topic extends Entity{

        // Liste des propriétés de la class Topic selon le principe d'encapsulation (visibilté des éléments au sein d'une class)
        // Propriété privé accessible que au sein de la class
        // propriétés dans le même ordre que dans la BDD (lira les colonnes dans cet ordre là)
        private $id; // id_topic
        private $nameTopic;
        private $user; // user_id
        //private $category; // category_id
        private $dateCreationTopic;
        private $subjectLock;

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
         * Get the value of title
         */ 
        public function getTitle()
        {
                return $this->nameTopic;
        }

        /**
         * Set the value of nameTopic
         *
         * @return  self
         */ 
        public function setNameTopic($nameTopic)
        {
                $this->nameTopic = $nameTopic;

                return $this;
        }

        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }

        public function getDateCreationTopic(){
            $formattedDate = $this->dateCreationTopic->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setDateCreationTopic($date){
            $this->dateCreationTopic = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of subjectLock
         */ 
        public function getSubjectLock()
        {
                return $this->subjectLock;
        }

        /**
         * Set the value of subjectLock
         *
         * @return  self
         */ 
        public function setSubjectLock($subjectLock)
        {
                $this->subjectLock = $subjectLock;

                return $this;
        }

        // A FAIRE : Method _toString
        public function __toString()
        {
                return $this->nameTopic;
        }
    }
