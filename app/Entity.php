<?php
//  voit si clé étrangère et si c'est le cas hydrate
    namespace App;

    abstract class Entity{

        protected function hydrate($data){
            // data = tableau associatif = un enregistrement / une ligne d'une table de la BDD

            foreach($data as $field => $value){
                // field = nom d'une colonne
                // value = valeur d'une cellule

                //field = marque_id
                //fieldarray = ['marque','id']
                // explode : transformer un string en un tableau de strings, en découpant au niveau des séparateurs
                // 3 cas possibles (pour l'entité "Truc) :
                //      - PK : id_truc, id_post (Primary Key)
                //          => ['id', 'truc']
                //      - FK : truc_id, topic_id, user_id (Foreign Key)
                //          => ['truc', 'id']
                //      - autre (données classiques, qui ne sont pas des clés) : title, message, postDate, ...
                //          => ['title']
                $fieldArray = explode("_", $field);

                // "le if des FK"
                // si fieldArray a un 2è élément ET que c'est vraiment "id"
                if(isset($fieldArray[1]) && $fieldArray[1] == "id"){
                    // définition du nom du manager
                    $manName = ucfirst($fieldArray[0])."Manager";
                    // FQC = Fully Qualified Name
                    $FQCName = "Model\Managers".DS.$manName;

                    // instance du manager
                    $man = new $FQCName();

                    // appel à la méthode findOneById du bon manager, en fournissant l'id de l'entité référencée (de l'enregistrement de la table "truc" qui a pour id $value)
                    // $value, qui contenait un id (car le champ était une FK), contient maintenant un objet (instance d'une entité (dans model/entities/))
                    $value = $man->findOneById($value);
                }
                //fabrication du nom du setter à appeler (ex: setMarque)
                // 3 cas possibles (pour l'entité "Truc") :
                //      - PK : "id" -> "setId"
                //      - FK : "truc" -> "setTruc"
                //      - autre : "title" -> "setTitle"
                $method = "set".ucfirst($fieldArray[0]);
               
                // si cette méthode (ce setter) existe
                if(method_exists($this, $method)){
                    // on l'appelle, en lui passant $value en argument
                    // 2 cas possibles : 
                    //      - FK : un objet
                    //      - PK ou autre : une valeur
                    $this->$method($value);
                }

            }
        }

        public function getClass(){
            return get_class($this);
        }
    }