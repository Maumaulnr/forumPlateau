<?php

$topics = $result["data"]['topics'];
    
?>

<h1>List Topics</h1>

<?php
foreach($topics as $topic){
?>
    <p><?= $topic->getNameTopic(). " ". $topic->getDateCreationTopic()?></p>
<?php
}
?>




  
