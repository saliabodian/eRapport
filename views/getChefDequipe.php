<option selected="selected"></option>
<?php foreach($listChefDequipe as $chefDequipe) :?>
    <option value="<?= $chefDequipe['id']?>"><?= $chefDequipe['username'].' '.$chefDequipe['lastname'] ?></option>
<?php endforeach ; ?>