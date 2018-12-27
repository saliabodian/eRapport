<option selected="selected"></option>
<?php foreach($listOuvrierTypeTache as $typeTask) :?>
    <option value="<?= $typeTask['id']?>"><?= $typeTask['code_type_tache'].' - '.$typeTask['nom_type_tache'] ?></option>
<?php endforeach ; ?>