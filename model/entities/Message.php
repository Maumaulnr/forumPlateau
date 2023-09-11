<?php

        // Je lui dis que je le range dans l'espace Model\Entities
    namespace Model\Entities;

    // le chemin à utiliser
    use App\Entity;

    // final class : bout de la class, ne peut pas être la mère de quelque chose d'autre. Meilleure lisibilité
    // ne peut pas avoir d'enfants
    // Class topic hérite de la class entity (entity parent)
    final class Message extends Entity{

        // Liste des propriétés de la class Topic selon le principe d'encapsulation (visibilté des éléments au sein d'une class)
        // Propriété privé accessible que au sein de la class
        // propriétés dans le même ordre que dans la BDD (lira les colonnes dans cet ordre là)
        private $id; // id_message
        private $commentText;
        private $user; // user_id
        private $topic; // topic_id
        private $dateCreationText;
        

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
         * Get the value of commentText
         */ 
        public function getCommentText()
        {
                return $this->commentText;
        }

        /**
         * Set the value of commentText
         *
         * @return  self
         */ 
        public function setCommentText($commentText)
        {
                $this->commentText = $commentText;

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

        /**
         * Get the value of topic
         */ 
        public function getTopic()
        {
                return $this->topic;
        }

        /**
         * Set the value of topic
         *
         * @return  self
         */ 
        public function setTopic($topic)
        {
                $this->topic = $topic;

                return $this;
        }

        /**
         * Get the value of dateCreationText
         */ 
        public function getDateCreationText()
        {
                return $this->dateCreationText;
        }

        /**
         * Set the value of dateCreationText
         *
         * @return  self
         */ 
        public function setDateCreationText($dateCreationText)
        {
                $this->dateCreationText = $dateCreationText;

                return $this;
        }

        // Method _toString
        public function __toString()
        {
                return $this->getUser() . $this->getTopic() . $this->getCommentText() . $this->getDateCreationText();
        }

    }
