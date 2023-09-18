<?php

// return from the listCategories() function, so write in the same order as in the function.
$categories = $result["data"]["categories"];

// On affiche le titre pour la balise <title> et la description dans la balise <meta name="description" ...>
// On récupère les informations via le ForumController via le return où l'on a écrit le titre et la description unique
$title = $result["data"]['title'];
$description = $result["data"]['description'];

?>

<h1>Liste des catégories</h1>

<div class="container">
	<div class="row">
		<div class="col-12">
		    <form class="search-form d-flex justify-content-end">
		        <div class="input-group">
		            <input id="input-1" class="form-control" type="text" aria-describedby="search-btn">
		            <label for="input-1" class="sr-only">Search</label>
		            <div class="input-group-append">
		                <button id="search-btn" class="btn btn-primary">Recherche</button>
		            </div>
		        </div>
		    </form>
		    <ul class="topics-table">
		        <li class="topics-header">
		           <ul class="header-titles text-center">
		               <li>Forum</li>
		               <li>Topics</li>
		               <li>Messages</li>
		               <li>Modifier</li>
		               <li>Supprimer</li>
		           </ul>
		        </li>
		        <li class="topics-body">
                    <?php
                        foreach($categories as $value) {
                        ?>
		            <ul class="topic-item-1 text-center">
		                <li>
                            <a href="index.php?ctrl=forum&action=findTopicByCategoryId&id=<?=$value->getId();?>" class="text-decoration-none category-link"><?= $value->getNameCategory(); ?>
                            </a>
	                    </li>
	                    <li>4</li>
	                    <li>5</li>
	                    <li>
	                       <!-- UPDATE -->
							<!-- Quand on clique on récupère idMessage et topicId pour être sûr de changer le message dans le bon topic :
							$message->getId() ?>&topicId=< $topic->getId() ?>
							-->
							<a href="index.php?ctrl=forum&action=updateCategoryForm&id=<?= $value->getId() ?>">
								<i class="fa-solid fa-pencil" title="Update"></i>
							</a>
	                    </li>
						<li>
							<!-- DELETE -->
							<a href="index.php?ctrl=forum&action=deleteCategory&id=<?= $value->getId() ?>" class=".delete-btn" onclick="return confirm('Etes-vous sûr de vouloir supprimer?');">
                    			<i class="fa-regular fa-trash-can" title="Delete"></i>
               	 			</a>
						</li>
		            </ul>
                    <?php
                    }
                    ?>
		        </li>
		    </ul>
		</div>
	</div>

	<?php
	if(App\Session::getUser()){
    	?>
		<a class="btn btn-primary btn-add" href="index.php?ctrl=forum&action=addCategoryForm" role="button">
        Add Category
    	</a>
		<?php
	} else { 
    	?>
    	<p>Pour créer une catégorie veuillez vous connecter !</p>
    	<?php
	}
	?>
    

</div>
