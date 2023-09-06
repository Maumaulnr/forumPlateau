<?php

        // Je lui dis que je le range dans l'espace Model\Entities
    namespace Model\Entities;

    // le chemin à utiliser
    use App\Entity;

    // final class : bout de la class, ne peut pas être la mère de quelque chose d'autre. Meilleure lisibilité
    // ne peut pas avoir d'enfants
    // Class topic hérite de la class entity (entity parent)
    final class Category extends Entity{

        // Liste des propriétés de la class Topic selon le principe d'encapsulation (visibilté des éléments au sein d'une class)
        // Propriété privé accessible que au sein de la class
        // propriétés dans le même ordre que dans la BDD (lira les colonnes dans cet ordre là)
        private $id; // id_category
        private $nameCategory;
        

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
        public function getNameCategory()
        {
                return $this->nameCategory;
        }

        /**
         * Set the value of nameCategory
         *
         * @return  self
         */ 
        public function setNameCategory($nameCategory)
        {
                $this->nameCategory = $nameCategory;

                return $this;
        }

        public function __toString()
        {
            return $this->getNameCategory();
        }
    }
