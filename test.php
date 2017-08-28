<pre>
<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 21/08/2017
 * Time: 11:11
 */

spl_autoload_register();

use \Classes\Cdcl\Db\User ;

echo 'blalala<br>';

$user = new User();

var_dump($user);

var_dump($user->get(2));

var_dump($user->getAllUser());

?>
</pre>