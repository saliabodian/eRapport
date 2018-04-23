<pre>
<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 27.02.2018
 * Time: 15:24
 */

spl_autoload_register(/**
 * @param $pClassName
 */
    function ($pClassName) {
    if (strpos($pClassName, "\\")) {
        $namespaces = explode("\\", $pClassName);
        $classname = array_pop($namespaces);
        $includingClassname = __DIR__.'/'.join('/', $namespaces).'/'.$classname.'.php';
    }
    else {
        $includingClassname = __DIR__.'/'.$pClassName.'.php';
    }
    require $includingClassname;
});
use \Classes\Cdcl\Config\Config;
use \Classes\Cdcl\Db\Interimaire;

$conf = Config::getInstance();


if(!empty($_SESSION)){

    Interimaire::updateDates();

}else{
    header('Location: index.php');
}