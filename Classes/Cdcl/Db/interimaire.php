<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 01/09/2017
 * Time: 16:40
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;

class interimaire extends DbObject{
    /*-------------properties-------------------------*/

    /**
     * @var string
     */

     public $matricule;

    /**
     * @var double
     */

    public $matricule_cns;

    /** @var string */

    public $firstname;

    /** @var string */

    public $lastname;

}