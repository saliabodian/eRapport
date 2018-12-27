<option selected="selected"></option>
<?php foreach($listTypeTache as $typeTache) :?>
    <option value="<?= $typeTache['id'] ?>">
        <?= $typeTache['code_type_tache'].' - '.$typeTache['nom_type_tache'] ?>
    </option>
<?php endforeach ; ?>