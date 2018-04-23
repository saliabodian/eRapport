<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 30.01.2018
 * Time: 09:06
 */
?>
<option selected="selected"></option>
    <?php foreach($listOuvrier as $ouvrier) :?>
    <option value="<?= isset($ouvrier['ouvrier_id'])? $ouvrier['ouvrier_id'] : $ouvrier['interimaire_id']?>">
        <?= isset($ouvrier['ouvrier_id'])? $ouvrier['ouvrier_id'].' '.$ouvrier['fullname'] : $ouvrier['interimaire_id'].' '.$ouvrier['fullname'] ?>
    </option>
<?php endforeach ; ?>