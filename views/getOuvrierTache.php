<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 31.01.2018
 * Time: 09:20
 */

?>
<option selected="selected"></option>
<?php foreach($listOuvrierTache as $task) :?>
    <option value="<?= $task['id']?>"><?= $task['code'].' '.$task['nom'] ?></option>
<?php endforeach ; ?>