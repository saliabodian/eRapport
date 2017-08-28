<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/08/2017
 * Time: 13:26
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;


class Tache {
    /*----------------Properties------------------*/
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $firstname;
    /**
     * @var string
     */
    public $lastname;
    /**
     * @var string
     */
    public $email;
    /**
     * @var int
     */
    public $registration_number;
    /**
     * @var timestamp
     */
    public $created;
    /**
     * @var int
     */
    public $password;
    /**
     * @var int
     */
    public $post_id;

}