<option selected="selected"></option>
<?php foreach($listTache as $tache) :?>
    <option value="<?= $tache['id'] ?>">
        <?= $tache['code'].' - '.$tache['nom'] ?>
    </option>
<?php endforeach ; ?>
