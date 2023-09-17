<?php
// var_dump($_SESSION['user']);
?>

<h1>List Categories</h1>

<?php

// return de la fonction listCategories() donc bien écrire dans le même ordre que dans la fonction
$categories = $result["data"]["categories"];
// $topics = $result["data"]['topics'];

?>


<div class="container">
	<div class="row">
		<div class="col-12">
		    <form class="search-form">
		        <div class="input-group">
		            <input id="input-1" class="form-control" type="text" aria-describedby="search-btn">
		            <label for="input-1" class="sr-only">Search</label>
		            <div class="input-group-append">
		                <button id="search-btn" class="btn btn-primary">Search</button>
		            </div>
		        </div>
		    </form>
		    <ul class="topics-table">
		        <li class="topics-header">
		           <ul class="header-titles">
		               <li>Forum</li>
		               <li>Topics</li>
		               <li>Posts</li>
		               <li>Update</li>
		               <li>Delete</li>
		           </ul>
		        </li>
		        <li class="topics-body">
                    <?php
                        foreach($categories as $value) {
                        ?>
		            <ul class="topic-item-1">
		                <li>
                            <a href="index.php?ctrl=forum&action=findTopicByCategoryId&id=<?=$value->getId();?>"><?= $value->getNameCategory(); ?>
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

    <a class="btn btn-primary btn-add" href="index.php?ctrl=forum&action=addCategoryForm" role="button">
        Add Category
    </a>
</div>
