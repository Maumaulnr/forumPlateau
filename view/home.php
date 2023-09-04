<h1>BIENVENUE SUR LE FORUM</h1>

<?php
$categories = $result["data"]["categories"];
$topics = $result["data"]['topics'];
?>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<p>
    <a href="/security/login.html">Log In</a>
    <span>&nbsp;-&nbsp;</span>
    <a href="/security/register.html">Sign Up</a>
</p>


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
		               <li>Freshness</li>
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
	                        <a class="badge badge-info" href="http://skatingbuzz.test/forums/topic/random-4/" title="Random 4">1 week ago</a>
                            <p class="bbp-topic-meta">
		                        <span class="bbp-topic-freshness-author">
	                                <a 
	                                href="http://skatingbuzz.test/forums/user/admin/" 
	                                title="View admin's profile" 
	                                class="bbp-author-name badge badge-info" 
	                                rel="nofollow">
	                                    admin
                                    </a>
	                            </span>
                            </p>
	                    </li>
		            </ul>
                    <?php
                    foreach($topics as $topic){
                    ?>
		            <ul class="topic-item-2">
		                <li>
		                    <a class="badge badge-primary" href="index.php?ctrl=forum&action=findMessageByTopicId&id=<?=$topic->getId();?>"><?= $topic->getNameTopic(). " ". $topic->getDateCreationTopic()?>
                            </a>
	                    </li>
	                    <li>2</li>
	                    <li>4</li>
	                    <li>
	                        
	                        <a class="badge badge-info" href="http://skatingbuzz.test/forums/topic/random-4/" title="Random 4">1 day ago</a>
                            <p class="bbp-topic-meta">
		                        <span class="bbp-topic-freshness-author">
	                                <a 
	                                href="http://skatingbuzz.test/forums/user/admin/" 
	                                title="View admin's profile" 
	                                class="bbp-author-name badge badge-info" 
	                                rel="nofollow">
	                                    leslie
                                    </a>
	                            </span>
                            </p>
	                    </li>
		            </ul>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>
		        </li>
		    </ul>
		</div>
	</div>
</div>