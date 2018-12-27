<option selected="selected"></option>
<?php foreach($listBatiment as $batiment) :?>
    <option value="<?= $batiment['id'] ?>">
        <?= $batiment['nom'] ?>
    </option>
<?php endforeach ; ?>/