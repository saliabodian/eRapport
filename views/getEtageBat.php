<option selected="selected"></option>
<?php foreach($listEtage as $etage) :?>
    <option value="<?= $etage['etage'] ?>">
        <?= $etage['etage'] ?>
    </option>
<?php endforeach ; ?>//