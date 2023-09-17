<p>Ceci n'a pas fonctionné</p>

<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="topics-table">
                <li class="topics-header">
                    <ul class="header-titles text-center">
                        <li>Topic</li>
                        <li>Pseudo</li>
                        <li>Date</li>
                        <li>Modifier</li>
                        <li>Verrouiller</li>
                        <li>Supprimer</li>
                    </ul>
                </li>
                <li class="topics-body">
                    <?php
                    if ($topics !== NULL) {
                        foreach ($topics as $topic) {
                    ?>
                        <ul class="topic-item-1 text-center">
                            <li>
                                <a href="index.php?ctrl=forum&action=findMessageByTopicId&id=<?=$topic->getId();?>"><?= $topic->getNameTopic() ?></a>
                            </li>
                            <li>De : <?= $topic->getUser()->getUserName() ?></li>
                            <li>Le : <?= $topic->getDateCreationTopic() ?></li>
                            <li>
                                <!-- UPDATE -->
                                <!-- Quand on clique on récupère idMessage et topicId pour être sûr de changer le message dans le bon topic :
							    $message->getId() ?>&topicId=< $topic->getId() ?>
							    -->
                                <a href="index.php?ctrl=forum&action=updateTopicForm&id=<?= $topic->getId() ?>&categoryId=<?= $category->getId() ?>">
                                    <i class="fa-solid fa-pencil" title="Update"></i>
                                </a>
                            </li>
                            <li>
                                <!-- LOCK THE TOPIC -->
                                <?php if(App\Session::isAdmin()) { 
                                    ?>
                                    <input type="hidden" name="sujet_id" value="1"> <!-- Remplacez 1 par l'ID du sujet -->
                                    <input type="submit" name="subjectLock" value="Verrouiller le sujet">
                                    <?php 
                                } 
                                ?>
                            </li>
                            <li>
                                <!-- DELETE -->
                                <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>&categoryId=<?= $category->getId() ?>" class=".delete-btn" onclick="return confirm('Etes-vous sûr de vouloir supprimer?');">
                                    <i class="fa-regular fa-trash-can" title="Delete"></i>
                                </a>
                            </li>
                        </ul>
                    <?php
                        }
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</div>